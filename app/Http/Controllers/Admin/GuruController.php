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
            'nip'        => 'required|unique:guru,nip',
            'nama_guru'  => 'required',
            'kode_mapel' => 'required',
        ]);

        Guru::create([
            'nip'        => $request->nip,
            'nama_guru'  => $request->nama_guru,
            'kode_mapel' => $request->kode_mapel,
        ]);

        $nip          = $request->nip;
        $emailGuru    = 'guru.' . $nip . '@sija.sch.id';
        $passwordGuru = 'Guru#' . substr($nip, -4);

        User::create([
            'name'      => $request->nama_guru,
            'email'     => $emailGuru,
            'password'  => Hash::make($passwordGuru),
            'role'      => 'guru',
            'nip'       => $nip,
            'is_active' => true,
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
        $guru = Guru::findOrFail($id);
        $guru->update([
            'nama_guru'  => $request->nama_guru,
            'kode_mapel' => $request->kode_mapel,
        ]);

        $user = User::where('nip', $id)->first();
        if ($user) {
            $user->update([
                'name'      => $request->nama_guru,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);
        }

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil diupdate');
    }

    // ❌ destroy() DIHAPUS — fitur hapus dinonaktifkan

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
            fputcsv($file, ['No', 'NIP', 'Nama Guru', 'Mata Pelajaran']);
            $no = 1;
            foreach ($data as $row) {
                fputcsv($file, [
                    $no++,
                    $row->nip,
                    $row->nama_guru,
                    $row->mapel->nama_mapel ?? '-',
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
            'file_import' => 'required|file|mimes:xlsx,xls|max:5120',
        ], [
            'file_import.required' => 'Pilih file Excel terlebih dahulu.',
            'file_import.mimes'    => 'File harus berformat .xlsx atau .xls',
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
                $nip       = trim((string)($row[0] ?? ''));
                $namaGuru  = trim((string)($row[1] ?? ''));
                $kodeMapel = trim((string)($row[2] ?? ''));

                if (empty($nip) && empty($namaGuru)) continue;

                if (empty($nip) || empty($namaGuru) || empty($kodeMapel)) {
                    $gagal[] = "Baris " . ($i + 1) . ": Data tidak lengkap (NIP/Nama/Kode Mapel kosong)";
                    continue;
                }

                $mapelAda = Mapel::where('kode_mapel', $kodeMapel)->exists();
                if (!$mapelAda) {
                    $gagal[] = "Baris " . ($i + 1) . ": Kode Mapel '{$kodeMapel}' tidak ditemukan di sistem";
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

                $emailGuru    = 'guru.' . $nip . '@sija.sch.id';
                $passwordGuru = 'Guru#' . substr($nip, -4);

                if (!User::where('email', $emailGuru)->exists()) {
                    User::create([
                        'name'      => $namaGuru,
                        'email'     => $emailGuru,
                        'password'  => Hash::make($passwordGuru),
                        'role'      => 'guru',
                        'nip'       => $nip,
                        'is_active' => true,
                    ]);
                }

                $berhasil++;
            }

            DB::commit();

            $pesan = "Import selesai: {$berhasil} guru berhasil ditambahkan.";
            if (!empty($duplikat)) {
                $pesan .= " " . count($duplikat) . " data dilewati (duplikat).";
            }
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

    /**
     * Baca Excel — pakai PhpSpreadsheet, fallback ke ZIP reader yang diperbaiki
     */
    private function bacaExcel(string $path): array
    {
        // ── Prioritas 1: PhpSpreadsheet (paling akurat) ──────────────────────
        if (class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $sheet       = $spreadsheet->getActiveSheet();
            $rows        = [];

            foreach ($sheet->getRowIterator() as $rowObj) {
                $rowNum = $rowObj->getRowIndex();
                if ($rowNum <= 3) continue; // skip baris judul, panduan, header

                $cells = [];
                $cellIter = $rowObj->getCellIterator('A', 'C');
                $cellIter->setIterateOnlyExistingCells(false);
                foreach ($cellIter as $cell) {
                    // getCalculatedValue() agar formula pun terbaca
                    $cells[] = $cell->getFormattedValue();
                }

                // Skip baris kosong
                if (empty(array_filter(array_map('trim', $cells)))) continue;

                $rows[] = $cells;
            }

            return $rows;
        }

        // ── Prioritas 2: ZIP/XML reader yang diperbaiki ───────────────────────
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \Exception('Tidak bisa membuka file Excel.');
        }

        $xml    = $zip->getFromName('xl/worksheets/sheet1.xml');
        $shared = $zip->getFromName('xl/sharedStrings.xml');
        $zip->close();

        if (!$xml) {
            throw new \Exception('Format file tidak valid.');
        }

        // Parse shared strings dengan cara yang lebih lengkap
        $strings = [];
        if ($shared) {
            // Tangani <t> yang bisa ada di dalam <r> (rich text) maupun langsung di <si>
            $sharedXml = simplexml_load_string($shared);
            foreach ($sharedXml->si as $si) {
                // Rich text: gabungkan semua <r><t>
                if (isset($si->r)) {
                    $text = '';
                    foreach ($si->r as $r) {
                        $text .= (string)$r->t;
                    }
                    $strings[] = $text;
                } else {
                    $strings[] = (string)$si->t;
                }
            }
        }

        // Parse rows
        $xmlObj = simplexml_load_string($xml);
        $ns     = $xmlObj->getNamespaces(true);
        $rows   = [];

        foreach ($xmlObj->sheetData->row as $row) {
            $rowNum = (int)$row['r'];
            if ($rowNum <= 3) continue;

            $cells = ['', '', ''];
            foreach ($row->c as $c) {
                // Ambil huruf kolom saja (A, B, C)
                preg_match('/^([A-Z]+)/', (string)$c['r'], $m);
                $colLetter = $m[1] ?? '';
                $colIdx    = ord($colLetter) - ord('A'); // A=0, B=1, C=2
                if ($colIdx > 2) continue;

                $type = (string)$c['t'];
                $val  = isset($c->v) ? (string)$c->v : '';

                if ($type === 's') {
                    // Shared string
                    $cells[$colIdx] = $strings[(int)$val] ?? '';
                } elseif ($type === 'str' || $type === 'inlineStr') {
                    // Formula string atau inline string
                    $cells[$colIdx] = isset($c->is->t) ? (string)$c->is->t : $val;
                } else {
                    // Number atau kosong
                    $cells[$colIdx] = $val;
                }
            }

            if (!empty(array_filter(array_map('trim', $cells)))) {
                $rows[] = $cells;
            }
        }

        return $rows;
    }
}   