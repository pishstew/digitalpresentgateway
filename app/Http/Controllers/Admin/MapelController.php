<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    // tampil semua + search
    public function index(Request $request)
    {
        $search = $request->search;

        $mapel = Mapel::when($search, function ($query) use ($search) {
            $query->where('kode_mapel', 'like', "%$search%")
                  ->orWhere('nama_mapel', 'like', "%$search%");
        })->paginate(10);

        return view('admin.mapel.index', compact('mapel'));
    }

    // simpan data
    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|unique:mapel,kode_mapel',
            'nama_mapel' => 'required'
        ]);

        Mapel::create($request->all());

        return redirect()->route('admin.mapel.index')
            ->with('success','Mapel berhasil ditambahkan');
    }

    // edit
    public function edit($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('admin.mapel.edit', compact('mapel'));
    }

    // update
    public function update(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);
        $mapel->update($request->all());

        return redirect()->route('admin.mapel.index')
            ->with('success','Mapel berhasil diupdate');
    }

    // delete
    public function destroy($id)
    {
        Mapel::destroy($id);

        return redirect()->route('admin.mapel.index')
            ->with('success','Mapel berhasil dihapus');
    }
}