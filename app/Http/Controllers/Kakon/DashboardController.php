<?php

namespace App\Http\Controllers\Kakon;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');

        $kelas  = $request->input('kelas', 'XI SIJA 1');
        $period = $request->input('period', 'hari_ini');
        $search = $request->input('search', '');

        // ── Rentang tanggal berdasarkan period ──────────────────────────────
        [$startDate, $endDate, $periodLabel] = $this->getRentang($period);

        // ── Query siswa ─────────────────────────────────────────────────────
        $siswaQuery = Siswa::where('kelas', $kelas);
        if ($search) {
            $siswaQuery->where('nama_siswa', 'like', "%{$search}%");
        }
        $semuaSiswa = $siswaQuery->orderBy('nama_siswa')->get();

        // ── Presensi dalam rentang ───────────────────────────────────────────
        $nisList = $semuaSiswa->pluck('nis');

        $semuaPresensi = Presensi::whereIn('nis', $nisList)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->get();

        // ── Rekap per status (keseluruhan kelas) ─────────────────────────────
        $rekap = [
            'Hadir' => $semuaPresensi->where('status', 'Hadir')->count(),
            'Izin'  => $semuaPresensi->where('status', 'Izin')->count(),
            'Sakit' => $semuaPresensi->where('status', 'Sakit')->count(),
            'Alpa'  => $semuaPresensi->where('status', 'Alpa')->count(),
        ];
        $rekapTotal = array_sum($rekap) ?: 1; // hindari div/0

        // ── Tren harian (untuk grafik garis) ────────────────────────────────
        $trenHarian = [];
        $cursor = Carbon::parse($startDate)->copy();
        $end    = Carbon::parse($endDate)->copy();

        while ($cursor->lte($end)) {
            $tgl = $cursor->format('Y-m-d');
            // skip Sabtu & Minggu
            if (!in_array($cursor->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                $trenHarian[$tgl] = [
                    'label' => $cursor->translatedFormat('d M'),
                    'Hadir' => $semuaPresensi->where('tanggal', $tgl)->where('status', 'Hadir')->count(),
                    'Izin'  => $semuaPresensi->where('tanggal', $tgl)->where('status', 'Izin')->count(),
                    'Sakit' => $semuaPresensi->where('tanggal', $tgl)->where('status', 'Sakit')->count(),
                    'Alpa'  => $semuaPresensi->where('tanggal', $tgl)->where('status', 'Alpa')->count(),
                ];
            }
            $cursor->addDay();
        }

        // ── Rekap per siswa (untuk tabel) ───────────────────────────────────
        $rekapSiswa = $semuaSiswa->map(function ($siswa) use ($semuaPresensi) {
            $ps = $semuaPresensi->where('nis', $siswa->nis);
            return [
                'nis'        => $siswa->nis,
                'nama'       => $siswa->nama_siswa,
                'kelas'      => $siswa->kelas,
                'Hadir'      => $ps->where('status', 'Hadir')->count(),
                'Izin'       => $ps->where('status', 'Izin')->count(),
                'Sakit'      => $ps->where('status', 'Sakit')->count(),
                'Alpa'       => $ps->where('status', 'Alpa')->count(),
                'total'      => $ps->count(),
            ];
        });

        // ── Siswa dengan alpha terbanyak (top 5) ─────────────────────────────
        $topAlpa = $rekapSiswa->sortByDesc('Alpa')->take(5)->values();

        return view('kakon.dashboard', compact(
            'kelas', 'period', 'periodLabel', 'search',
            'startDate', 'endDate',
            'rekap', 'rekapTotal',
            'trenHarian',
            'rekapSiswa',
            'topAlpa',
            'semuaSiswa'
        ));
    }

    private function getRentang(string $period): array
    {
        $today = Carbon::today();

        return match ($period) {
            'hari_ini'   => [
                $today->format('Y-m-d'),
                $today->format('Y-m-d'),
                'Hari Ini (' . $today->translatedFormat('d M Y') . ')',
            ],
            'minggu_ini' => [
                $today->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d'),
                $today->copy()->endOfWeek(Carbon::FRIDAY)->format('Y-m-d'),
                'Minggu Ini',
            ],
            'bulan_ini'  => [
                $today->copy()->startOfMonth()->format('Y-m-d'),
                $today->copy()->endOfMonth()->format('Y-m-d'),
                'Bulan Ini (' . $today->translatedFormat('F Y') . ')',
            ],
            'semester'   => $this->getSemester($today),
            default      => [
                $today->format('Y-m-d'),
                $today->format('Y-m-d'),
                'Hari Ini',
            ],
        };
    }

    private function getSemester(Carbon $today): array
    {
        $month = $today->month;
        $year  = $today->year;

        // Semester 1: Juli – Desember | Semester 2: Januari – Juni
        if ($month >= 7) {
            return [
                Carbon::create($year, 7, 1)->format('Y-m-d'),
                Carbon::create($year, 12, 31)->format('Y-m-d'),
                'Semester 1 (' . $year . '/' . ($year + 1) . ')',
            ];
        } else {
            return [
                Carbon::create($year, 1, 1)->format('Y-m-d'),
                Carbon::create($year, 6, 30)->format('Y-m-d'),
                'Semester 2 (' . ($year - 1) . '/' . $year . ')',
            ];
        }
    }
}