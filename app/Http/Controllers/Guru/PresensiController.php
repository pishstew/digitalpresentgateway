<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\JadwalPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Halaman rekap presensi (READ + SEARCH + UPDATE).
     */
    public function index(Request $request)
    {
        $user      = Auth::user();
        $guru      = $user->guru;
        $search    = $request->search;
        $jadwalId  = $request->jadwal_id; // nilai ini adalah kode_jam_pelajaran
        $tanggal   = $request->tanggal ?? Carbon::today()->toDateString();

        // Jadwal milik guru ini untuk filter dropdown
        $jadwals = $guru
            ? JadwalPelajaran::with('mapel')
                ->where('nip', $guru->nip)
                ->orderBy('hari')
                ->orderBy('jam_ke')
                ->get()
            : collect();

        // Jadwal yang sedang dipilih — pakai kode_jam_pelajaran (PK), bukan id
        $jadwal = $jadwalId
            ? JadwalPelajaran::with('mapel')->where('kode_jam_pelajaran', $jadwalId)->first()
            : $jadwals->first();

        $semuaSiswa    = collect();
        $presensiHadir = collect();

        // Cek apakah guru punya jadwal di hari tanggal yang dipilih
        $hariIndonesia = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        $hariTanggal = $hariIndonesia[Carbon::parse($tanggal)->format('l')] ?? '';
        $adaJadwalHariIni = $jadwals->contains('hari', $hariTanggal);

        if ($jadwal && $adaJadwalHariIni) {
            $semuaSiswa = Siswa::where('kelas', $jadwal->kelas)->get();

            // Kolom FK di tabel presensi adalah kode_jam_pelajaran, bukan jadwal_id
            $query = Presensi::with('siswa')
                ->where('kode_jam_pelajaran', $jadwal->kode_jam_pelajaran)
                ->whereDate('tanggal', $tanggal);

            if ($search) {
                $query->whereHas('siswa', fn($q) =>
                    $q->where('nama_siswa', 'like', "%$search%")
                      ->orWhere('nis', 'like', "%$search%")
                );
            }

            $presensiHadir = $query->get();
        }

        $nisHadir = $presensiHadir->pluck('nis')->toArray();

        return view('guru.presensi.index', compact(
            'jadwals', 'jadwal', 'semuaSiswa', 'presensiHadir',
            'nisHadir', 'tanggal', 'search', 'jadwalId',
            'adaJadwalHariIni', 'hariTanggal'
        ));
    }

    /**
     * Hitung jarak (meter) antara dua koordinat — formula Haversine.
     */
    private function hitungJarak(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $r    = 6371000; // radius bumi dalam meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a    = sin($dLat / 2) ** 2
              + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return $r * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    /**
     * Siswa submit kode presensi → validasi token + geofencing → simpan record hadir.
     */
    public function store(Request $request)
    {
        // ── Koordinat & radius sekolah ──────────────────────────────
        $sekolahLat    = -7.975020;
        $sekolahLng    = 112.671699;
        $radiusMeter   = 100;

        // ── Validasi input dasar ────────────────────────────────────
        $request->validate([
            'token'     => 'required|string|size:4',
            'nis'       => 'required|exists:siswa,nis',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'latitude.required'  => 'Lokasi GPS tidak terdeteksi. Pastikan izin lokasi diaktifkan.',
            'longitude.required' => 'Lokasi GPS tidak terdeteksi. Pastikan izin lokasi diaktifkan.',
        ]);

        // ── Validasi Geofencing ─────────────────────────────────────
        $jarak = $this->hitungJarak(
            (float) $request->latitude,
            (float) $request->longitude,
            $sekolahLat,
            $sekolahLng
        );

        if ($jarak > $radiusMeter) {
            $jarakBulat = round($jarak);
            return back()->withErrors([
                'kode' => "Presensi ditolak. Kamu berada {$jarakBulat} meter dari sekolah (batas: {$radiusMeter} meter). Hadir ke sekolah untuk melakukan presensi.",
            ]);
        }

        // ── Validasi token ──────────────────────────────────────────
        $tokenAktif  = session('presensi_token');
        $tokenExpiry = session('presensi_token_expiry');
        $kodeJadwal  = session('presensi_jadwal_id');

        if (!$tokenAktif || $request->token !== $tokenAktif) {
            return back()->withErrors(['kode' => 'Kode presensi salah.']);
        }

        if (Carbon::now()->isAfter(Carbon::parse($tokenExpiry))) {
            return back()->withErrors(['kode' => 'Kode presensi sudah kedaluwarsa.']);
        }

        // ── Cek duplikasi ───────────────────────────────────────────
        $sudahPresensi = Presensi::where('nis', $request->nis)
            ->where('kode_jam_pelajaran', $kodeJadwal)
            ->whereDate('tanggal', Carbon::today())
            ->exists();

        if ($sudahPresensi) {
            return back()->withErrors(['kode' => 'Anda sudah melakukan presensi untuk sesi ini.']);
        }

        // ── Simpan presensi ─────────────────────────────────────────
        Presensi::create([
            'kode_presensi'      => 'PRE-' . strtoupper(uniqid()),
            'nis'                => $request->nis,
            'kode_jam_pelajaran' => $kodeJadwal,
            'tanggal'            => Carbon::today()->toDateString(),
            'jam_masuk'          => Carbon::now()->format('H:i:s'),
            'status'             => 'Hadir',
        ]);

        return back()->with('success', 'Presensi berhasil dicatat! ✓');
    }

    /**
     * Update status presensi siswa.
     */
    public function update(Request $request, $kodePresensi)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit,Alpa',
        ]);

        // Primary key tabel presensi adalah kode_presensi (string), bukan id integer
        $presensi = Presensi::where('kode_presensi', $kodePresensi)->firstOrFail();

        // Pastikan jadwal milik guru yang login
        $guru   = Auth::user()->guru;
        $jadwal = JadwalPelajaran::where('kode_jam_pelajaran', $presensi->kode_jam_pelajaran)->first();

        if ($jadwal && $guru && $jadwal->nip !== $guru->nip) {
            abort(403, 'Unauthorized');
        }

        $presensi->update(['status' => $request->status]);

        return back()->with('success', 'Status presensi berhasil diperbarui.');
    }
}