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
    private function getWaktuJadwal($jam_ke)
    {
        $timeMap = [
            1 => ['start' => '07:00', 'end' => '07:45'],
            2 => ['start' => '07:45', 'end' => '08:30'],
            3 => ['start' => '08:30', 'end' => '09:15'],
            4 => ['start' => '09:15', 'end' => '10:00'],
            5 => ['start' => '10:15', 'end' => '11:00'],
            6 => ['start' => '11:00', 'end' => '11:45'],
            7 => ['start' => '12:15', 'end' => '13:00'],
            8 => ['start' => '13:00', 'end' => '13:45'],
            9 => ['start' => '13:45', 'end' => '14:30'],
            10 => ['start' => '14:30', 'end' => '15:15'],
            11 => ['start' => '15:15', 'end' => '16:00'],
            12 => ['start' => '16:00', 'end' => '16:45'],
        ];

        $parts = explode('-', $jam_ke);
        $startJam = (int)$parts[0];
        $endJam = isset($parts[1]) ? (int)$parts[1] : $startJam;

        $startTime = isset($timeMap[$startJam]) ? $timeMap[$startJam]['start'] : '07:00';
        $endTime = isset($timeMap[$endJam]) ? $timeMap[$endJam]['end'] : '16:45';

        return ['start' => $startTime, 'end' => $endTime];
    }

    public function index()
    {
        $user = Auth::user();
        
        // Mengambil 5 digit terakhir NIS dari email (format: siswa.NIS@sija.sch.id)
        $emailNisLast5 = str_replace(['siswa.', '@sija.sch.id'], '', $user->email);
        $siswa = Siswa::where('nis', 'LIKE', '%' . $emailNisLast5)->first();
        $nis = $siswa ? $siswa->nis : null;

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

            $currentTime = date('H:i');

            // Tambahkan status presensi ke setiap jadwal
            foreach ($jadwalHariIni as $jadwal) {
                $presensi = Presensi::where('nis', $nis)
                    ->where('tanggal', date('Y-m-d'))
                    ->where('kode_jam_pelajaran', $jadwal->kode_jam_pelajaran)
                    ->first();
                
                $waktu = $this->getWaktuJadwal($jadwal->jam_ke);
                $jadwal->jam_mulai = $waktu['start'];
                $jadwal->jam_selesai = $waktu['end'];
                
                $jadwal->is_waktunya = ($currentTime >= $waktu['start'] && $currentTime <= $waktu['end']);
                $jadwal->waktu_berakhir = ($currentTime > $waktu['end']);

                $jadwal->sudah_absen = $presensi ? true : false;
                $jadwal->data_presensi = $presensi;

                // Set activeJadwal ke jadwal pertama yang belum diabsen dan masih/sudah waktunya
                if (!$activeJadwal && !$jadwal->sudah_absen && $jadwal->is_waktunya) {
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

        $jadwal = JadwalPelajaran::where('kode_jam_pelajaran', $request->kode_jam_pelajaran)->first();
        if (!$jadwal) {
            return redirect()->route('siswa.dashboard')->with('error', 'Jadwal tidak ditemukan.');
        }

        $waktu = $this->getWaktuJadwal($jadwal->jam_ke);
        $currentTime = date('H:i');

        if ($currentTime < $waktu['start']) {
            return redirect()->route('siswa.dashboard')->with('error', 'Belum waktunya presensi untuk mapel ini. Waktu presensi dimulai jam ' . $waktu['start']);
        }
        
        if ($currentTime > $waktu['end']) {
            return redirect()->route('siswa.dashboard')->with('error', 'Waktu presensi untuk mapel ini sudah berakhir. Selesai jam ' . $waktu['end']);
        }

        $user = Auth::user();
        $emailNisLast5 = str_replace(['siswa.', '@sija.sch.id'], '', $user->email);
        $siswa = Siswa::where('nis', 'LIKE', '%' . $emailNisLast5)->first();
        $nis = $siswa ? $siswa->nis : null;

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
