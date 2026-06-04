<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $siswa = $query->orderBy('nama_siswa')->paginate(10)->withQueryString();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'        => [
                'required',
                'string',
                'digits:11',
                'unique:siswa,nis',
            ],
            'nama_siswa' => 'required|string',
            'kelas'      => 'required|string',
        ], [
            'nis.digits'   => 'NIS harus tepat 11 digit angka.',
            'nis.unique'   => 'NIS sudah terdaftar di sistem.',
            'nis.required' => 'NIS wajib diisi.',
        ]);

        Siswa::create([
            'nis'        => $request->nis,
            'nama_siswa' => $request->nama_siswa,
            'kelas'      => $request->kelas,
        ]);

        $nis           = $request->nis;
        $baseEmail     = 'siswa.' . substr($nis, -5) . '@sija.sch.id';
        $emailSiswa    = $baseEmail;
        $counter       = 1;
        while (User::where('email', $emailSiswa)->exists()) {
            $emailSiswa = 'siswa.' . substr($nis, -5) . '-' . $counter . '@sija.sch.id';
            $counter++;
        }
        $passwordSiswa = 'Siswa#' . substr($nis, -4);

        User::create([
            'name'      => $request->nama_siswa,
            'email'     => $emailSiswa,
            'password'  => Hash::make($passwordSiswa),
            'role'      => 'siswa',
            'nip'       => null,
            'is_active' => true,
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', "Siswa berhasil ditambahkan. Email: {$emailSiswa} | Password: {$passwordSiswa}");
    }

    public function show(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa)
    {
        $user = User::where('email', 'siswa.' . substr($siswa->nis, -5) . '@sija.sch.id')->first();
        return view('admin.siswa.edit', compact('siswa', 'user'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama_siswa' => 'required|string',
            'kelas'      => 'required|string',
        ]);

        $siswa->update([
            'nama_siswa' => $request->nama_siswa,
            'kelas'      => $request->kelas,
        ]);

        $user = User::where('email', 'siswa.' . substr($siswa->nis, -5) . '@sija.sch.id')->first();
        if ($user) {
            $user->update([
                'name'      => $request->nama_siswa,
                'is_active' => $request->has('is_active') ? 1 : 0,
            ]);
        }

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil diubah!');
    }

    public function templateImport()
    {
        $filepath = public_path('templates/template_import_siswa.xlsx');

        if (!file_exists($filepath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan.');
        }

        return response()->download($filepath, 'template_import_siswa.xlsx');
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
                $nis       = trim((string)($row[0] ?? ''));
                $namaSiswa = trim((string)($row[1] ?? ''));
                $kelas     = trim((string)($row[2] ?? ''));

                if (empty($nis) && empty($namaSiswa)) continue;

                if (empty($nis) || empty($namaSiswa) || empty($kelas)) {
                    $gagal[] = "Baris " . ($i + 1) . ": Data tidak lengkap (NIS/Nama/Kelas kosong)";
                    continue;
                }

                // Validasi format NIS: harus 11 digit angka
                if (!preg_match('/^\d{11}$/', $nis)) {
                    $gagal[] = "Baris " . ($i + 1) . ": NIS '{$nis}' tidak valid — harus tepat 11 digit angka";
                    continue;
                }

                if (!in_array($kelas, ['XI SIJA 1', 'XI SIJA 2'])) {
                    $gagal[] = "Baris " . ($i + 1) . ": Kelas '{$kelas}' tidak valid. Gunakan: XI SIJA 1 atau XI SIJA 2";
                    continue;
                }

                $baseEmail     = 'siswa.' . substr($nis, -5) . '@sija.sch.id';
                $emailSiswa    = $baseEmail;
                $counter       = 1;
                while (User::where('email', $emailSiswa)->exists()) {
                    $emailSiswa = 'siswa.' . substr($nis, -5) . '-' . $counter . '@sija.sch.id';
                    $counter++;
                }
                $passwordSiswa = 'Siswa#' . substr($nis, -4);

                if (Siswa::where('nis', $nis)->exists()) {
                    // Cek jika akun login belum ada, buatkan
                    if (!User::where('email', $emailSiswa)->exists()) {
                        User::create([
                            'name'      => $namaSiswa,
                            'email'     => $emailSiswa,
                            'password'  => Hash::make($passwordSiswa),
                            'role'      => 'siswa',
                            'nip'       => null,
                            'is_active' => true,
                        ]);
                        $berhasil++;
                        continue;
                    }
                    $duplikat[] = "NIS {$nis} ({$namaSiswa}) sudah ada beserta akun loginnya, dilewati";
                    continue;
                }

                Siswa::create([
                    'nis'        => $nis,
                    'nama_siswa' => $namaSiswa,
                    'kelas'      => $kelas,
                ]);

                if (!User::where('email', $emailSiswa)->exists()) {
                    User::create([
                        'name'      => $namaSiswa,
                        'email'     => $emailSiswa,
                        'password'  => Hash::make($passwordSiswa),
                        'role'      => 'siswa',
                        'nip'       => null,
                        'is_active' => true,
                    ]);
                }

                $berhasil++;
            }

            DB::commit();

            $pesan = "Import selesai: {$berhasil} siswa berhasil ditambahkan.";
            if (!empty($duplikat)) {
                $pesan .= " " . count($duplikat) . " data dilewati (duplikat).";
            }
            if (!empty($gagal)) {
                $pesan .= " " . count($gagal) . " baris gagal.";
                return redirect()->route('admin.siswa.index')
                    ->with('success', $pesan)
                    ->with('import_errors', array_merge($duplikat, $gagal));
            }

            return redirect()->route('admin.siswa.index')->with('success', $pesan);

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
        if ($zip->open($path) !== true) {
            throw new \Exception('Tidak bisa membuka file Excel.');
        }

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
                    foreach ($si->r as $r) {
                        $text .= (string)$r->t;
                    }
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
                $colLetter = $m[1] ?? '';
                $colIdx    = ord($colLetter) - ord('A');
                if ($colIdx > 2) continue;

                $type = (string)$c['t'];
                $val  = isset($c->v) ? (string)$c->v : '';

                if ($type === 's') {
                    $cells[$colIdx] = $strings[(int)$val] ?? '';
                } elseif ($type === 'str' || $type === 'inlineStr') {
                    $cells[$colIdx] = isset($c->is->t) ? (string)$c->is->t : $val;
                } else {
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