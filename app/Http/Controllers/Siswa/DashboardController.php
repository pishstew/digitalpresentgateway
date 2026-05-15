<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Presensi;
use App\Models\JadwalPelajaran;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Mengambil NIS dari email (format: siswa.NIS@sija.sch.id)
        $nis = str_replace(['siswa.', '@sija.sch.id'], '', $user->email);
        $siswa = Siswa::where('nis', $nis)->first();

        // Menampilkan jadwal hari ini
        $jadwalHariIni = collect();
        $activeJadwal = null;

        if ($siswa) {
            $hariMap = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];
            $hariIniEng = date('l');
            $hariIni = $hariMap[$hariIniEng] ?? 'Senin';
            
            $jadwalHariIni = JadwalPelajaran::with('mapel')
                ->where('hari', $hariIni)
                ->where('kelas', $siswa->kelas)
                ->orderBy('jam_ke')
                ->get();

            // Tambahkan status presensi ke setiap jadwal
            foreach ($jadwalHariIni as $jadwal) {
                $presensi = Presensi::where('nis', $nis)
                    ->where('tanggal', date('Y-m-d'))
                    ->where('kode_jam_pelajaran', $jadwal->kode_jam_pelajaran)
                    ->first();
                
                $jadwal->sudah_absen = $presensi ? true : false;
                $jadwal->data_presensi = $presensi;

                // Set activeJadwal ke jadwal pertama yang belum diabsen (default)
                if (!$activeJadwal && !$jadwal->sudah_absen) {
                    $activeJadwal = $jadwal;
                }
            }

            // Jika user memilih jadwal spesifik via query string
            if (request('jadwal_id')) {
                $selected = $jadwalHariIni->where('kode_jam_pelajaran', request('jadwal_id'))->first();
                if ($selected && !$selected->sudah_absen) {
                    $activeJadwal = $selected;
                }
            }
        }

        return view('siswa.dashboard', compact('siswa', 'activeJadwal', 'jadwalHariIni'));
    }

    public function store(Request $request)
    {
        // CREATE: Menyimpan presensi baru
        $request->validate([
            'kode_jam_pelajaran' => 'required|exists:jadwal_pelajaran,kode_jam_pelajaran',
            'token' => 'required|string|size:4'
        ]);

        $user = Auth::user();
        $nis = str_replace(['siswa.', '@sija.sch.id'], '', $user->email);

        // Cek apakah sudah absen hari ini untuk jam pelajaran tersebut
        $cekPresensi = Presensi::where('nis', $nis)
            ->where('tanggal', date('Y-m-d'))
            ->where('kode_jam_pelajaran', $request->kode_jam_pelajaran)
            ->first();

        if ($cekPresensi) {
            return redirect()->route('siswa.dashboard')->with('error', 'Anda sudah melakukan presensi untuk jadwal ini hari ini.');
        }

        $kodePresensi = 'PR-' . date('YmdHis') . '-' . $nis;

        Presensi::create([
            'kode_presensi' => $kodePresensi,
            'tanggal' => date('Y-m-d'),
            'kode_jam_pelajaran' => $request->kode_jam_pelajaran,
            'jam_masuk' => date('H:i:s'),
            'status' => 'Hadir', // Default ke Hadir
            'nis' => $nis,
            'token' => $request->token
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Presensi berhasil disimpan.');
    }

}
