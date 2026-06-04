<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            ->orderBy('nama_guru')
            ->paginate(10);

        $mapel = Mapel::all();

        return view('admin.guru.index', compact('guru', 'mapel'));
    }

    public function create()
    {
        // Tidak dipakai — form tambah ada di index (inline)
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'        => [
                'required',
                'string',
                'digits:18',
                'unique:guru,nip',
            ],
            'nama_guru'  => 'required|string',
            'kode_mapel' => 'required|string',
        ], [
            'nip.digits'  => 'NIP harus tepat 18 digit angka.',
            'nip.unique'  => 'NIP sudah terdaftar di sistem.',
            'nip.required' => 'NIP wajib diisi.',
        ]);

        Guru::create([
            'nip'        => $request->nip,
            'nama_guru'  => $request->nama_guru,
            'kode_mapel' => $request->kode_mapel,
        ]);

        $nip          = $request->nip;
        $baseEmail    = 'guru.' . substr($nip, -5) . '@sija.sch.id';
        $emailGuru    = $baseEmail;
        $counter      = 1;
        while (User::where('email', $emailGuru)->exists()) {
            $emailGuru = 'guru.' . substr($nip, -5) . '-' . $counter . '@sija.sch.id';
            $counter++;
        }
        
        $passwordGuru = 'password';

        User::create([
            'name'       => $request->nama_guru,
            'email'      => $emailGuru,
            'password'   => Hash::make($passwordGuru),
            'role'       => 'guru',
            'nip'        => $nip,
            'is_active'  => true,
            'kelas_wali' => null,
        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', "Data guru berhasil ditambahkan. Email: {$emailGuru} | Password: {$passwordGuru}");
    }

    public function edit($id)
    {
        $guru  = Guru::findOrFail($id);
        $mapel = Mapel::all();
        $user  = User::where('nip', $id)->first();

        return view('admin.guru.edit', compact('guru', 'mapel', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_guru'  => 'required|string',
            'kode_mapel' => 'required|string',
            'role'       => 'required|in:guru,walikelas,kakon',
            'kelas_wali' => 'nullable|in:XI SIJA 1,XI SIJA 2',
        ]);

        // Update tabel guru
        $guru = Guru::findOrFail($id);
        $guru->update([
            'nama_guru'  => $request->nama_guru,
            'kode_mapel' => $request->kode_mapel,
        ]);

        // Update tabel users
        $user = User::where('nip', $id)->first();
        if ($user) {
            $kelasWali = ($request->role === 'walikelas') ? $request->kelas_wali : null;

            $user->update([
                'name'       => $request->nama_guru,
                'role'       => $request->role,
                'is_active'  => $request->has('is_active') ? 1 : 0,
                'kelas_wali' => $kelasWali,
            ]);
        }

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diupdate');
    }

    public function export()
    {
        $data = Guru::with('mapel')->get();

        $filename = "data_guru_" . date('Y-m-d') . ".csv";
        $headers  = [
            "Content-Type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'NIP', 'Nama Guru', 'Mata Pelajaran', 'Role', 'Kelas Wali']);
            $no = 1;
            foreach ($data as $row) {
                $user = User::where('nip', $row->nip)->first();
                fputcsv($file, [
                    $no++,
                    $row->nip,
                    $row->nama_guru,
                    $row->mapel->nama_mapel ?? '-',
                    $user->role ?? 'guru',
                    $user->kelas_wali ?? '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function templateImport()
    {
        $filepath = public_path('templates/template_import_guru.xlsx');

        if (!file_exists($filepath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan.');
        }

        return response()->download($filepath, 'template_import_guru.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:xlsx,xls,csv,txt|max:5120',
        ], [
            'file_import.required' => 'Pilih file Excel terlebih dahulu.',
            'file_import.mimes'    => 'File harus berformat .xlsx, .xls, atau .csv',
            'file_import.max'      => 'Ukuran file maksimal 5MB',
        ]);

        $file = $request->file('file_import');

        try {
            $rows = $this->bacaExcel($file->getPathname());

            if (empty($rows)) {
                return redirect()->back()->with('error', 'File Excel kosong atau format tidak sesuai template.');
            }

            $berhasil = 0;
            $gagal    = [];
            $duplikat = [];

            DB::beginTransaction();

            foreach ($rows as $i => $row) {
                $nip       = str_replace(' ', '', trim((string)($row[0] ?? '')));
                $namaGuru  = trim((string)($row[1] ?? ''));
                $kodeMapel = trim((string)($row[2] ?? ''));

                if (empty($nip) && empty($namaGuru)) continue;

                if (empty($nip) || empty($namaGuru) || empty($kodeMapel)) {
                    $gagal[] = "Baris " . ($i + 1) . ": Data tidak lengkap";
                    continue;
                }

                // Validasi format NIP: harus 18 digit angka
                if (!preg_match('/^\d{18}$/', $nip)) {
                    $gagal[] = "Baris " . ($i + 1) . ": NIP '{$nip}' tidak valid — harus tepat 18 digit angka";
                    continue;
                }

                $mapelAda = Mapel::where('kode_mapel', $kodeMapel)->exists();
                if (!$mapelAda) {
                    $gagal[] = "Baris " . ($i + 1) . ": Kode Mapel '{$kodeMapel}' tidak ditemukan";
                    continue;
                }

                if (Guru::where('nip', $nip)->exists()) {
                    $duplikat[] = "NIP {$nip} ({$namaGuru}) sudah ada, dilewati";
                    continue;
                }

                Guru::create([
                    'nip'        => $nip,
                    'nama_guru'  => $namaGuru,
                    'kode_mapel' => $kodeMapel,
                ]);

                $baseEmail    = 'guru.' . substr($nip, -5) . '@sija.sch.id';
                $emailGuru    = $baseEmail;
                $counter      = 1;
                while (User::where('email', $emailGuru)->exists()) {
                    $emailGuru = 'guru.' . substr($nip, -5) . '-' . $counter . '@sija.sch.id';
                    $counter++;
                }
                
                $passwordGuru = 'password';

                User::create([
                    'name'       => $namaGuru,
                    'email'      => $emailGuru,
                    'password'   => Hash::make($passwordGuru),
                    'role'       => 'guru',
                    'nip'        => $nip,
                    'is_active'  => true,
                    'kelas_wali' => null,
                ]);

                $berhasil++;
            }

            DB::commit();

            $pesan = "Import selesai: {$berhasil} guru berhasil ditambahkan.";
            if (!empty($duplikat)) $pesan .= " " . count($duplikat) . " data dilewati (duplikat).";
            if (!empty($gagal)) {
                $pesan .= " " . count($gagal) . " baris gagal.";
                return redirect()->route('admin.guru.index')
                    ->with('success', $pesan)
                    ->with('import_errors', array_merge($duplikat, $gagal));
            }

            return redirect()->route('admin.guru.index')->with('success', $pesan);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membaca file: ' . $e->getMessage());
        }
    }

    private function bacaExcel(string $path): array
    {
        if (class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = [];

            foreach ($sheet->getRowIterator() as $rowObj) {
                $rowNum = $rowObj->getRowIndex();
                if ($rowNum <= 3) continue;

                $cells    = [];
                $cellIter = $rowObj->getCellIterator('A', 'C');
                $cellIter->setIterateOnlyExistingCells(false);
                foreach ($cellIter as $cell) {
                    $cells[] = $cell->getFormattedValue();
                }

                if (empty(array_filter(array_map('trim', $cells)))) continue;
                $rows[] = $cells;
            }

            return $rows;
        }

        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) throw new \Exception('Tidak bisa membuka file Excel.');

        $xml    = $zip->getFromName('xl/worksheets/sheet1.xml');
        $shared = $zip->getFromName('xl/sharedStrings.xml');
        $zip->close();

        if (!$xml) throw new \Exception('Format file tidak valid.');

        $strings = [];
        if ($shared) {
            $sharedXml = simplexml_load_string($shared);
            foreach ($sharedXml->si as $si) {
                if (isset($si->r)) {
                    $text = '';
                    foreach ($si->r as $r) $text .= (string)$r->t;
                    $strings[] = $text;
                } else {
                    $strings[] = (string)$si->t;
                }
            }
        }

        $xmlObj = simplexml_load_string($xml);
        $rows   = [];

        foreach ($xmlObj->sheetData->row as $row) {
            $rowNum = (int)$row['r'];
            if ($rowNum <= 3) continue;

            $cells = ['', '', ''];
            foreach ($row->c as $c) {
                preg_match('/^([A-Z]+)/', (string)$c['r'], $m);
                $colIdx         = ord($m[1] ?? 'A') - ord('A');
                if ($colIdx > 2) continue;
                $type           = (string)$c['t'];
                $val            = isset($c->v) ? (string)$c->v : '';
                $cells[$colIdx] = $type === 's' ? ($strings[(int)$val] ?? '') : $val;
            }

            if (!empty(array_filter(array_map('trim', $cells)))) $rows[] = $cells;
        }

        return $rows;
    }
}