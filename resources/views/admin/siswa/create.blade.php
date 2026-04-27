@extends('layouts.app')

@section('content')
<div class="page-bg">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">🎓 Tambah Data Siswa</h1>
        <p class="hero-sub">Tambahkan siswa satu per satu atau langsung import banyak sekaligus</p>
    </div>

    <div class="dash-body" style="max-width: 860px;">

        @if ($message = Session::get('success'))
            <div class="alert-success">✅ {{ $message }}</div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert-error">❌ {{ $message }}</div>
        @endif

        @if (Session::has('import_errors'))
            <div class="alert-warning">
                <strong>⚠️ Detail error saat import:</strong>
                <ul style="margin: 8px 0 0 16px;">
                    @foreach (Session::get('import_errors') as $err)
                        <li style="font-size: 13px;">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ACTION BAR --}}
        <div style="margin-bottom: 20px;">
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-slate">⬅️ Kembali ke Daftar Siswa</a>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SECTION 1: TAMBAH MANUAL --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="form-section" style="margin-bottom: 24px;">
            <h2 style="margin-bottom: 4px;">✍️ Tambah Siswa Satu per Satu</h2>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">
                Isi form di bawah untuk menambahkan satu data siswa beserta akun loginnya.
            </p>

            @if ($errors->any())
                <div class="alert-error" style="margin-bottom: 16px;">
                    <strong>❌ Terjadi Kesalahan:</strong>
                    <ul style="margin: 6px 0 0 16px;">
                        @foreach ($errors->all() as $error)
                            <li style="font-size: 13px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">🆔 NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis"
                           class="form-input @error('nis') error @enderror"
                           placeholder="Contoh: 12345678901"
                           value="{{ old('nis') }}" required>
                    @error('nis')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">👤 Nama Siswa</label>
                    <input type="text" name="nama_siswa"
                           class="form-input @error('nama_siswa') error @enderror"
                           placeholder="Contoh: Ahmad Reza Pratama"
                           value="{{ old('nama_siswa') }}" required>
                    @error('nama_siswa')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">📚 Kelas</label>
                    <div style="display: flex; gap: 16px; margin-top: 6px;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px;">
                            <input type="radio" name="kelas" value="XI SIJA 1"
                                   @if(old('kelas') == 'XI SIJA 1') checked @endif required>
                            <span>🎓 XI SIJA 1</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 14px;">
                            <input type="radio" name="kelas" value="XI SIJA 2"
                                   @if(old('kelas') == 'XI SIJA 2') checked @endif>
                            <span>🎓 XI SIJA 2</span>
                        </label>
                    </div>
                    @error('kelas')
                        <p class="form-error-message">❌ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Info akun otomatis --}}
                <div style="background: var(--bg-soft); border-left: 3px solid var(--teal); border-radius: 8px; padding: 12px 16px; margin-bottom: 20px; font-size: 13px;">
                    <strong>🔐 Akun login akan dibuat otomatis:</strong><br>
                    <span style="color: var(--text-muted);">
                        Email: <code>siswa.{NIS}@sija.sch.id</code> &nbsp;|&nbsp;
                        Password: <code>Siswa#{4 digit terakhir NIS}</code>
                    </span>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-teal">✅ Simpan Siswa</button>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-slate">❌ Batal</a>
                </div>
            </form>
        </div>

        {{-- DIVIDER --}}
        <div style="display: flex; align-items: center; gap: 16px; margin: 28px 0;">
            <div style="flex: 1; height: 1px; background: var(--border-color);"></div>
            <span style="font-size: 13px; color: var(--text-muted); white-space: nowrap;">atau tambahkan banyak siswa sekaligus</span>
            <div style="flex: 1; height: 1px; background: var(--border-color);"></div>
        </div>

        {{-- ═══════════════════════════════════════════════════════ --}}
        {{-- SECTION 2: IMPORT EXCEL --}}
        {{-- ═══════════════════════════════════════════════════════ --}}
        <div class="g-card" style="margin-bottom: 32px;">
            <div class="g-card-header">
                <h2>📥 Import Data Siswa dari Excel</h2>
            </div>
            <div class="g-card-body">
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
                    Upload file Excel sesuai format template untuk menambahkan banyak siswa sekaligus.
                    Akun login akan dibuat otomatis untuk setiap siswa yang berhasil diimport.
                </p>

                {{-- Langkah-langkah --}}
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px;">
                    <div style="background: var(--bg-soft); border-radius: 10px; padding: 14px; text-align: center; font-size: 13px;">
                        <div style="font-size: 22px; margin-bottom: 6px;">1️⃣</div>
                        <strong>Download Template</strong>
                        <p style="color: var(--text-muted); margin-top: 4px; font-size: 12px;">Klik tombol di bawah untuk download file Excel template</p>
                    </div>
                    <div style="background: var(--bg-soft); border-radius: 10px; padding: 14px; text-align: center; font-size: 13px;">
                        <div style="font-size: 22px; margin-bottom: 6px;">2️⃣</div>
                        <strong>Isi Data di Excel</strong>
                        <p style="color: var(--text-muted); margin-top: 4px; font-size: 12px;">Isi NIS, Nama Siswa, dan Kelas mulai baris ke-4</p>
                    </div>
                    <div style="background: var(--bg-soft); border-radius: 10px; padding: 14px; text-align: center; font-size: 13px;">
                        <div style="font-size: 22px; margin-bottom: 6px;">3️⃣</div>
                        <strong>Upload & Import</strong>
                        <p style="color: var(--text-muted); margin-top: 4px; font-size: 12px;">Pilih file dan klik Upload untuk proses import</p>
                    </div>
                </div>

                {{-- Info format kolom --}}
                <div style="background: #0f172a; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 13px;">
                    <span style="color: #94a3b8;">📋 Format kolom:</span>
                    <span style="font-family: monospace; color: #7dd3fc; margin-left: 8px;">
                        A: NIS &nbsp;|&nbsp; B: Nama Siswa &nbsp;|&nbsp; C: Kelas
                    </span>
                    <br>
                    <span style="color: #f59e0b; font-size: 12px; margin-top: 6px; display: block;">
                        ⚠️ Kolom Kelas hanya boleh diisi: <strong>XI SIJA 1</strong> atau <strong>XI SIJA 2</strong>
                        &nbsp;|&nbsp; Jangan ubah baris 1–3 (header template)
                    </span>
                </div>

                {{-- Form upload + tombol download --}}
                <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                    <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data"
                          style="display: flex; gap: 10px; align-items: center; flex: 1; min-width: 260px;">
                        @csrf
                        <input type="file" name="file_import" accept=".xlsx,.xls"
                               class="form-input" style="flex: 1; padding: 6px 10px; font-size: 13px;" required>
                        <button type="submit" class="btn btn-teal" style="white-space: nowrap;">
                            📤 Upload & Import
                        </button>
                    </form>

                    <a href="{{ route('admin.siswa.template-import') }}" class="btn btn-yellow" style="white-space: nowrap;">
                        ⬇️ Download Template
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection