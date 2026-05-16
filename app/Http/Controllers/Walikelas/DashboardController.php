<?php

namespace App\Http\Controllers\Walikelas;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get filter inputs
        $kelas = $request->input('kelas', 'XI SIJA 1');
        $search = $request->input('search');

        // Calculate current week dates (Monday to Friday)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::FRIDAY)->format('Y-m-d');

        // Fetch students
        $query = Siswa::where('kelas', $kelas);

        if ($search) {
            $query->where('nama_siswa', 'like', '%' . $search . '%');
        }

        // Eager load presensi for current week
        $siswas = $query->with(['presensi' => function ($q) use ($startOfWeek, $endOfWeek) {
            $q->whereBetween('tanggal', [$startOfWeek, $endOfWeek]);
        }])->get();

        // Map presensi to days
        // To make it easy for view, we can organize presensi by day of week
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        
        // Let's pass $startOfWeek to calculate dates for each day
        $weekDates = [];
        for ($i = 0; $i < 5; $i++) {
            $weekDates[] = Carbon::parse($startOfWeek)->addDays($i)->format('Y-m-d');
        }

        return view('walikelas.dashboard', compact('siswas', 'kelas', 'search', 'days', 'weekDates', 'startOfWeek', 'endOfWeek'));
    }
}
