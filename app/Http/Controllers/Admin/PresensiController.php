<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    // tampil + search saja
    public function index(Request $request)
    {
        $search = $request->search;

        $presensi = Presensi::with(['siswa','jadwal'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_siswa','like',"%$search%");
                })
                ->orWhere('status','like',"%$search%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.presensi.index', compact('presensi'));
    }
}