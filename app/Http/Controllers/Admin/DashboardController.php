<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\JadwalPelajaran;
use App\Models\Presensi;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $siswaCount = Siswa::count();
        $guruCount = Guru::count();
        $mapelCount = Mapel::count();
        $jadwalCount = JadwalPelajaran::count();
        $presensiCount = Presensi::count();

        return view('admin.dashboard', [
            'siswaCount' => $siswaCount,
            'guruCount' => $guruCount,
            'mapelCount' => $mapelCount,
            'jadwalCount' => $jadwalCount,
            'presensiCount' => $presensiCount,
        ]);
    }
}
