<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;

        // Urutan hari yang benar
        $urutan = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        // Ambil semua jadwal guru ini, dikelompokkan per hari
        $jadwalPerHari = collect();

        if ($guru) {
            $semua = JadwalPelajaran::with('mapel')
                ->where('nip', $guru->nip)
                ->orderBy('jam_ke')
                ->get()
                ->groupBy('hari');

            // Susun sesuai urutan Senin-Jumat (hanya hari yang punya jadwal)
            foreach ($urutan as $hari) {
                if ($semua->has($hari)) {
                    $jadwalPerHari[$hari] = $semua[$hari];
                }
            }
        }

        // Hari aktif hari ini (dalam bahasa Indonesia)
        $hariIniMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        $hariIni = $hariIniMap[now()->format('l')] ?? '';

        return view('guru.jadwal.index', compact('jadwalPerHari', 'guru', 'hariIni'));
    }
}