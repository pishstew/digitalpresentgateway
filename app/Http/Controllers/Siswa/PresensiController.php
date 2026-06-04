<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $emailNisLast5 = str_replace(['siswa.', '@sija.sch.id'], '', $user->email);
        $siswa = \App\Models\Siswa::where('nis', 'LIKE', '%' . $emailNisLast5)->first();
        $nis = $siswa ? $siswa->nis : '';

        $query = Presensi::with('jadwal.mapel')
            ->where('nis', $nis);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $presensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->paginate(15);

        return view('siswa.presensi.index', compact('presensi'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }
}
