<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JadwalPelajaranController extends Controller
{
    // tampil data + form
    public function index(Request $request)
    {
        $search = $request->search;

        $jadwal = JadwalPelajaran::with(['guru','mapel'])
            ->when($search, function ($query) use ($search) {
                $query->where('kelas','like',"%$search%");
            })
            ->paginate(10);

        $guru = Guru::all();
        $mapel = Mapel::all();

        return view('admin.jadwal.index', compact('jadwal','guru','mapel'));
    }

    // simpan
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_ke' => 'required',
            'kode_mapel' => 'required',
            'nip' => 'required',
            'kelas' => 'required'
        ]);

        JadwalPelajaran::create([
            'kode_jam_pelajaran' => 'JAD-' . Str::random(5),
            'hari' => $request->hari,
            'jam_ke' => $request->jam_ke,
            'kode_mapel' => $request->kode_mapel,
            'nip' => $request->nip,
            'kelas' => $request->kelas
        ]);

        return redirect()->route('jadwal.index')
            ->with('success','Jadwal berhasil ditambahkan');
    }

    // edit
    public function edit($id)
    {
        $jadwal = JadwalPelajaran::findOrFail($id);
        $guru = Guru::all();
        $mapel = Mapel::all();

        return view('admin.jadwal.edit', compact('jadwal', 'guru', 'mapel'));
    }

    // update
    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required',
            'jam_ke' => 'required',
            'kode_mapel' => 'required',
            'nip' => 'required',
            'kelas' => 'required'
        ]);

        $jadwal = JadwalPelajaran::findOrFail($id);
        $jadwal->update([
            'hari' => $request->hari,
            'jam_ke' => $request->jam_ke,
            'kode_mapel' => $request->kode_mapel,
            'nip' => $request->nip,
            'kelas' => $request->kelas
        ]);

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diupdate');
    }

    // delete
    public function destroy($id)
    {
        JadwalPelajaran::destroy($id);

        return redirect()->route('jadwal.index')
            ->with('success','Jadwal dihapus');
    }
}