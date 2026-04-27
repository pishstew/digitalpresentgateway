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

        if ($jadwal) {
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
            'nisHadir', 'tanggal', 'search', 'jadwalId'
        ));
    }

    /**
     * Siswa submit kode presensi → validasi token → simpan record hadir.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|size:4',
            'nis'  => 'required|exists:siswa,nis',
        ]);

        $tokenAktif  = session('presensi_token');
        $tokenExpiry = session('presensi_token_expiry');
        $kodeJadwal  = session('presensi_jadwal_id'); // ini adalah kode_jam_pelajaran

        if (!$tokenAktif || $request->kode !== $tokenAktif) {
            return back()->withErrors(['kode' => 'Kode presensi salah.']);
        }

        if (Carbon::now()->isAfter(Carbon::parse($tokenExpiry))) {
            return back()->withErrors(['kode' => 'Kode presensi sudah kedaluwarsa.']);
        }

        // Cek sudah presensi hari ini di sesi ini?
        $sudahPresensi = Presensi::where('nis', $request->nis)
            ->where('kode_jam_pelajaran', $kodeJadwal)
            ->whereDate('tanggal', Carbon::today())
            ->exists();

        if ($sudahPresensi) {
            return back()->withErrors(['kode' => 'Anda sudah melakukan presensi untuk sesi ini.']);
        }

        Presensi::create([
            'kode_presensi'      => 'PRE-' . strtoupper(uniqid()),
            'nis'                => $request->nis,
            'kode_jam_pelajaran' => $kodeJadwal,
            'tanggal'            => Carbon::today()->toDateString(),
            'jam_masuk'          => Carbon::now()->format('H:i:s'),
            'status'             => 'Hadir',
        ]);

        return back()->with('success', 'Presensi berhasil dicatat!');
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