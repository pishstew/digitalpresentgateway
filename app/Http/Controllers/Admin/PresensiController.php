<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    // tampil + search + filter kelas
    public function index(Request $request)
    {
        $search = $request->search;
        $kelas = $request->kelas;

        $presensi = Presensi::with(['siswa','jadwal'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('siswa', function ($q) use ($search) {
                    $q->where('nama_siswa','like',"%$search%");
                })
                ->orWhere('status','like',"%$search%");
            })
            ->when($kelas, function ($query) use ($kelas) {
                $query->whereHas('jadwal', function ($q) use ($kelas) {
                    $q->where('kelas', $kelas);
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.presensi.index', compact('presensi', 'kelas'));
    }
    public function export()
{
    $data = Presensi::all();

    $filename = "presensi_" . date('Y-m-d') . ".csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function() use ($data) {

        $file = fopen('php://output', 'w');

        // Header kolom
        fputcsv($file, ['ID', 'Nama', 'Tanggal', 'Status']);

        foreach ($data as $row) {
            fputcsv($file, [
                $row->id,
                $row->nama,
                $row->tanggal,
                $row->status
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}