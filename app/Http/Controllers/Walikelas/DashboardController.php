<?php

namespace App\Http\Controllers\Walikelas;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Kelas diambil dari profil user yang login, bukan dari input request
        // Sehingga walikelas hanya bisa melihat kelasnya sendiri
        $kelas  = Auth::user()->kelas_wali;
        $search = $request->input('search');
        $filter = $request->input('filter', 'minggu_ini');

        // Navigasi manual minggu masih bisa dipakai jika ada
        $weekParam = $request->input('week');

        if ($weekParam) {
            $baseDate = Carbon::parse($weekParam);
            $startDate = $baseDate->copy()->startOfWeek(Carbon::MONDAY);
            $endDate = $baseDate->copy()->startOfWeek(Carbon::MONDAY)->addDays(4);
            $filterLabel = 'Minggu Pilihan';
        } else {
            if ($filter == 'hari_ini') {
                $startDate = Carbon::now()->startOfDay();
                $endDate = Carbon::now()->endOfDay();
                $filterLabel = 'Hari Ini';
            } elseif ($filter == 'minggu_ini') {
                $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY);
                $endDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->addDays(4);
                $filterLabel = 'Minggu Ini';
            } elseif ($filter == 'bulan_ini') {
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                $filterLabel = 'Bulan Ini';
            } elseif ($filter == 'tahun_ini') {
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                $filterLabel = 'Tahun Ini';
            } elseif ($filter == 'minggu_lalu') {
                $startDate = Carbon::now()->subWeek()->startOfWeek(Carbon::MONDAY);
                $endDate = Carbon::now()->subWeek()->startOfWeek(Carbon::MONDAY)->addDays(4);
                $filterLabel = 'Minggu Lalu';
            } elseif ($filter == 'bulan_lalu') {
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                $filterLabel = 'Bulan Lalu';
            } else {
                $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY);
                $endDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->addDays(4);
                $filterLabel = 'Minggu Ini';
            }
        }

        $startStr = $startDate->format('Y-m-d');
        $endStr   = $endDate->format('Y-m-d');

        // Query siswa berdasarkan kelas walikelas yang login
        $query = Siswa::where('kelas', $kelas);

        if ($search) {
            $query->where('nama_siswa', 'like', '%' . $search . '%');
        }

        // Eager load presensi periode terpilih
        $siswas = $query->with(['presensi' => function ($q) use ($startStr, $endStr) {
            $q->whereBetween('tanggal', [$startStr, $endStr]);
        }])->get();

        $daysMap = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];

        $days = [];
        $weekDates = [];
        $currentDate = $startDate->copy();

        $allPresensi = collect();
        foreach ($siswas as $siswa) {
            foreach ($siswa->presensi as $p) {
                if ($p->tanggal >= $startStr && $p->tanggal <= $endStr) {
                    $allPresensi->push($p);
                }
            }
        }

        $rekap = [
            'Hadir' => $allPresensi->filter(fn($p) => strtolower($p->status) == 'hadir')->count(),
            'Izin'  => $allPresensi->filter(fn($p) => strtolower($p->status) == 'izin')->count(),
            'Sakit' => $allPresensi->filter(fn($p) => strtolower($p->status) == 'sakit')->count(),
            'Alpa'  => $allPresensi->filter(fn($p) => in_array(strtolower($p->status), ['alpha', 'alpa']))->count(),
        ];
        $rekapTotal = array_sum($rekap) ?: 1;

        $trenHarian = [];

        while ($currentDate->lte($endDate)) {
            // Hanya tampilkan hari kerja, kecuali jika filternya "hari ini" di hari libur
            if ($currentDate->isWeekday() || $filter == 'hari_ini') {
                $days[] = $daysMap[$currentDate->format('l')];
                $tgl = $currentDate->format('Y-m-d');
                $weekDates[] = $tgl;

                $trenHarian[$tgl] = [
                    'label' => $currentDate->translatedFormat('d M'),
                    'Hadir' => $allPresensi->where('tanggal', $tgl)->filter(fn($p) => strtolower($p->status) == 'hadir')->count(),
                    'Izin'  => $allPresensi->where('tanggal', $tgl)->filter(fn($p) => strtolower($p->status) == 'izin')->count(),
                    'Sakit' => $allPresensi->where('tanggal', $tgl)->filter(fn($p) => strtolower($p->status) == 'sakit')->count(),
                    'Alpa'  => $allPresensi->where('tanggal', $tgl)->filter(fn($p) => in_array(strtolower($p->status), ['alpha', 'alpa']))->count(),
                ];
            }
            $currentDate->addDay();
        }

        return view('walikelas.dashboard', compact(
            'siswas', 'kelas', 'search', 'filter', 'filterLabel', 'days', 'weekDates', 'startStr', 'endStr', 'startDate', 'endDate',
            'trenHarian', 'rekap', 'rekapTotal'
        ));
    }
}