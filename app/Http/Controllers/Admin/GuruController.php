<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $guru = Guru::with('mapel')
        ->when($search, function ($query) use ($search) {
            $query->where('nama_guru', 'like', "%$search%")
                  ->orWhere('nip', 'like', "%$search%");
        })
        ->paginate(10);

    $mapel = Mapel::all(); // ← WAJIB ADA

    return view('admin.guru.index', compact('guru', 'mapel'));
}

    public function create()
    {
       // ...
    }

    public function store(Request $request)
{
    $request->validate([
        'nip' => 'required|unique:guru,nip',
        'nama_guru' => 'required',
        'kode_mapel' => 'required'
    ]);

    Guru::create([
        'nip' => $request->nip,
        'nama_guru' => $request->nama_guru,
        'kode_mapel' => $request->kode_mapel
    ]);

    return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan');
}

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        $mapel = Mapel::all();

        return view('admin.guru.edit', compact('guru','mapel'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $guru->update($request->all());

        return redirect()->route('guru.index')->with('success','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Guru::destroy($id);

        return redirect()->route('guru.index')->with('success','Data berhasil dihapus');
    }

    public function export()
{
    $data = Guru::with('mapel')->get();

    $filename = "data_guru_" . date('Y-m-d') . ".csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function() use ($data) {

        $file = fopen('php://output', 'w');

        fputcsv($file, ['No', 'NIP', 'Nama Guru', 'Mata Pelajaran']);

        $no = 1;
        foreach ($data as $row) {
            fputcsv($file, [
                $no++,
                $row->nip,
                $row->nama_guru,
                $row->mapel->nama_mapel ?? '-'
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}