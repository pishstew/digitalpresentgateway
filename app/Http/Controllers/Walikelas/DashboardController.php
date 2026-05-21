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

        // Hitung rentang minggu — support navigasi via parameter ?week=YYYY-MM-DD
        $weekParam   = $request->input('week');
        $baseDate    = $weekParam ? Carbon::parse($weekParam) : Carbon::now();
        $startOfWeek = $baseDate->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $endOfWeek   = $baseDate->copy()->startOfWeek(Carbon::MONDAY)->addDays(4)->format('Y-m-d');

        // Query siswa berdasarkan kelas walikelas yang login
        $query = Siswa::where('kelas', $kelas);

        if ($search) {
            $query->where('nama_siswa', 'like', '%' . $search . '%');
        }

        // Eager load presensi minggu ini
        $siswas = $query->with(['presensi' => function ($q) use ($startOfWeek, $endOfWeek) {
            $q->whereBetween('tanggal', [$startOfWeek, $endOfWeek]);
        }])->get();

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        $weekDates = [];
        for ($i = 0; $i < 5; $i++) {
            $weekDates[] = Carbon::parse($startOfWeek)->addDays($i)->format('Y-m-d');
        }

        return view('walikelas.dashboard', compact(
            'siswas', 'kelas', 'search', 'days', 'weekDates', 'startOfWeek', 'endOfWeek'
        ));
    }
}