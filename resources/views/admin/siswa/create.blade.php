<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Siswa — SIJA Presensi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy: #0B1F3A; --navy-mid: #132D52; --navy-soft: #1C3D6E;
            --gold: #C9963C; --gold-lt: #E8B455; --gold-dim: #F5D9A0;
            --white: #FAFAF8; --muted: #8FA3C0;
            --border: rgba(201,150,60,.25); --border-w: rgba(255,255,255,.07);
            --glass: rgba(255,255,255,.04);
        }
        html, body { min-height: 100%; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--navy); color: var(--white); overflow-x: hidden; }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: radial-gradient(ellipse 80% 60% at 70% -10%, rgba(28,61,110,.8) 0%, transparent 60%),
                        radial-gradient(ellipse 50% 40% at 10% 80%, rgba(201,150,60,.07) 0%, transparent 50%);
            pointer-events: none; z-index: 0;
        }
        body::after {
            content: ''; position: fixed; inset: 0;
            background-image: linear-gradient(rgba(201,150,60,.04) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(201,150,60,.04) 1px, transparent 1px);
            background-size: 60px 60px; pointer-events: none; z-index: 0;
        }

        /* NAV */
        nav {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.1rem 2.5rem; border-bottom: 1px solid var(--border);
            backdrop-filter: blur(20px); background: rgba(11,31,58,.85);
        }
        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-logo {
            width: 38px; height: 38px; background: var(--gold); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif; font-weight: 700; font-size: 17px; color: var(--navy);
        }
        .nav-name { font-size: 14px; font-weight: 600; color: var(--white); }
        .nav-sub  { font-size: 10px; color: var(--muted); letter-spacing: .6px; text-transform: uppercase; }
        .nav-back {
            display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px;
            background: var(--glass); border: 1px solid var(--border-w); border-radius: 8px;
            color: var(--muted); font-size: 13px; font-weight: 500; text-decoration: none; transition: all .2s;
        }
        .nav-back:hover { background: rgba(255,255,255,.08); color: var(--white); border-color: var(--border); }
        .nav-back svg { width: 15px; height: 15px; }

        /* WRAP */
        .wrap {
            position: relative; z-index: 2; max-width: 960px; margin: 0 auto;
            padding: 2.5rem 2.5rem 4rem; animation: fadeUp .7s ease both;
        }
        @keyframes fadeUp { from { opacity:0; transform:translateY(22px); } to { opacity:1; transform:translateY(0); } }

        /* PAGE HEADER */
        .page-header { margin-bottom: 2rem; }
        .page-badge {
            display: inline-flex; align-items: center; gap: 8px; padding: 5px 12px;
            background: rgba(201,150,60,.12); border: 1px solid rgba(201,150,60,.28); border-radius: 100px;
            font-size: 11px; font-weight: 600; color: var(--gold-lt); letter-spacing: .5px;
            text-transform: uppercase; margin-bottom: 1rem;
        }
        .page-badge::before {
            content: ''; width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold); animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.9rem; font-weight: 700; color: var(--white); }
        .page-title span { color: var(--gold); }
        .page-sub { margin-top: .35rem; font-size: 14px; color: var(--muted); }

        /* ALERTS */
        .alert {
            display: flex; align-items: flex-start; gap: 10px;
            border-radius: 10px; padding: 13px 16px; font-size: 13px; margin-bottom: 1.2rem;
        }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }
        .alert-error   { background: rgba(248,113,113,.08); border: 1px solid rgba(248,113,113,.22); color: #fca5a5; }
        .alert-warning { background: rgba(251,191,36,.08);  border: 1px solid rgba(251,191,36,.22);  color: #fde68a; }
        .alert ul { margin: 6px 0 0 16px; line-height: 1.7; }

        /* DIVIDER */
        .divider {
            display: flex; align-items: center; gap: 16px; margin: 2rem 0;
        }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border-w); }
        .divider span { font-size: 12px; color: var(--muted); white-space: nowrap; letter-spacing: .3px; }

        /* SEC TITLE */
        .sec-title {
            font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700;
            color: var(--white); margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;
        }
        .sec-title::after { content: ''; flex: 1; height: 1px; background: var(--border-w); }

        /* CARD */
        .card { background: var(--glass); border: 1px solid var(--border-w); border-radius: 16px; margin-bottom: 1.2rem; overflow: hidden; }
        .card-head {
            padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-w);
            display: flex; align-items: center; gap: 10px;
        }
        .card-head svg { width: 16px; height: 16px; color: var(--gold); flex-shrink: 0; }
        .card-head-title { font-size: 14px; font-weight: 600; color: var(--white); }
        .card-body { padding: 1.5rem; }

        /* FORM */
        .form-group { margin-bottom: 1.3rem; }
        .form-label {
            display: block; font-size: 11px; font-weight: 700; color: var(--muted);
            letter-spacing: .5px; text-transform: uppercase; margin-bottom: 7px;
        }
        .form-input {
            width: 100%; background: rgba(255,255,255,.05); border: 1px solid var(--border-w);
            border-radius: 9px; padding: 11px 14px; font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif; color: var(--white);
            transition: border-color .2s, background .2s; outline: none;
        }
        .form-input::placeholder { color: rgba(143,163,192,.5); }
        .form-input:focus { border-color: var(--gold); background: rgba(255,255,255,.08); }
        .form-input.error { border-color: #f87171; }
        .input-hint { display: flex; justify-content: space-between; align-items: center; min-height: 20px; margin-top: 5px; }
        .hint-text  { font-size: 12px; color: var(--muted); }
        .hint-count { font-size: 12px; font-weight: 600; color: var(--muted); }
        .form-err   { font-size: 12px; color: #f87171; margin-top: 4px; }

        /* RADIO KELAS */
        .radio-group { display: flex; gap: 10px; margin-top: 4px; }
        .radio-card {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 18px; background: rgba(255,255,255,.04);
            border: 1px solid var(--border-w); border-radius: 10px;
            cursor: pointer; transition: all .2s; flex: 1;
        }
        .radio-card:has(input:checked) { background: rgba(201,150,60,.1); border-color: var(--border); }
        .radio-card input { accent-color: var(--gold); width: 16px; height: 16px; cursor: pointer; flex-shrink: 0; }
        .radio-card-text {}
        .radio-card-label { font-size: 14px; font-weight: 600; color: var(--white); display: block; }
        .radio-card-sub   { font-size: 11px; color: var(--muted); margin-top: 2px; }

        /* AKUN INFO BOX */
        .akun-info {
            background: rgba(13,148,136,.07); border: 1px solid rgba(45,212,191,.18);
            border-radius: 10px; padding: 14px 16px; margin-bottom: 1.3rem;
        }
        .akun-info-title {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; font-weight: 700; color: #2dd4bf;
            text-transform: uppercase; letter-spacing: .4px; margin-bottom: 10px;
        }
        .akun-info-title svg { width: 14px; height: 14px; }
        .akun-row { display: flex; align-items: center; gap: 10px; margin-bottom: 6px; }
        .akun-row:last-child { margin-bottom: 0; }
        .akun-key { font-size: 12px; color: var(--muted); width: 70px; flex-shrink: 0; }
        .akun-val { font-size: 12px; font-family: monospace; background: rgba(255,255,255,.06); border: 1px solid var(--border-w); border-radius: 5px; padding: 3px 10px; color: var(--gold-dim); }

        /* BUTTONS */
        .btn {
            display: inline-flex; align-items: center; gap: 7px; padding: 11px 20px;
            border-radius: 9px; font-size: 13px; font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
            border: 1px solid transparent; text-decoration: none; white-space: nowrap; transition: all .2s;
        }
        .btn svg { width: 15px; height: 15px; }
        .btn-gold   { background: var(--gold); border-color: var(--gold); color: var(--navy); }
        .btn-gold:hover { background: var(--gold-lt); transform: translateY(-1px); }
        .btn-ghost  { background: var(--glass); border-color: var(--border-w); color: var(--muted); }
        .btn-ghost:hover { background: rgba(255,255,255,.08); color: var(--white); }
        .btn-teal   { background: rgba(13,148,136,.15); border-color: rgba(13,148,136,.3); color: #2dd4bf; }
        .btn-teal:hover { background: rgba(13,148,136,.25); }
        .btn-yellow { background: rgba(217,119,6,.12); border-color: rgba(217,119,6,.28); color: #fbbf24; }
        .btn-yellow:hover { background: rgba(217,119,6,.22); }
        .btn-sm { padding: 7px 13px; font-size: 12px; }
        .form-actions { display: flex; gap: 10px; margin-top: 1.5rem; }

        /* STEPS GRID */
        .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 1.2rem; }
        .step-box {
            background: rgba(255,255,255,.03); border: 1px solid var(--border-w);
            border-radius: 10px; padding: 14px; text-align: center;
        }
        .step-num {
            width: 28px; height: 28px; border-radius: 50%;
            background: rgba(201,150,60,.15); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: var(--gold-lt);
            margin: 0 auto 8px;
        }
        .step-title { font-size: 12px; font-weight: 700; color: var(--white); margin-bottom: 4px; }
        .step-desc  { font-size: 11px; color: var(--muted); line-height: 1.6; }

        /* FORMAT INFO */
        .format-info { background: rgba(255,255,255,.03); border: 1px solid var(--border-w); border-radius: 9px; padding: 12px 16px; margin-bottom: 1rem; font-size: 13px; }
        .format-info strong { color: var(--gold-dim); }
        .code-tag { font-family: monospace; background: rgba(96,165,250,.1); border: 1px solid rgba(96,165,250,.2); color: #93c5fd; padding: 2px 9px; border-radius: 5px; font-size: 12px; margin-left: 6px; }
        .format-note { margin-top: 7px; font-size: 12px; color: var(--muted); line-height: 1.7; }
        .import-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .import-file {
            flex: 1; min-width: 220px; background: rgba(255,255,255,.04);
            border: 1px dashed rgba(255,255,255,.15); border-radius: 9px; padding: 9px 13px;
            font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--white); cursor: pointer;
        }
        .import-file::file-selector-button {
            background: rgba(201,150,60,.15); border: 1px solid var(--border); border-radius: 6px;
            padding: 4px 10px; font-size: 12px; font-weight: 600; color: var(--gold-lt); cursor: pointer; margin-right: 10px;
        }

        footer { position: relative; z-index: 2; text-align: center; padding: 1.5rem; border-top: 1px solid var(--border-w); font-size: 12px; color: var(--muted); }

        @media (max-width: 640px) {
            nav { padding: 1rem 1.2rem; }
            .wrap { padding: 1.5rem 1.2rem 3rem; }
            .radio-group { flex-direction: column; }
            .steps-grid { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column; }
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-brand">
        <div class="nav-logo">S</div>
        <div>
            <div class="nav-name">SIJA Presensi</div>
            <div class="nav-sub">Sistem Informasi Akademik</div>
        </div>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="nav-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Daftar Siswa
    </a>
</nav>

<div class="wrap">

    @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <strong>Terjadi Kesalahan:</strong>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    @if(Session::has('import_errors'))
        <div class="alert alert-warning">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <div>
                <strong>Detail error saat import:</strong>
                <ul>@foreach(Session::get('import_errors') as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-badge">Input Data</div>
        <h1 class="page-title">Tambah <span>Siswa</span></h1>
        <p class="page-sub">Tambahkan satu siswa manual atau import banyak sekaligus</p>
    </div>

    {{-- ══ SECTION 1: MANUAL ══ --}}
    <div class="sec-title">Tambah Siswa Satu per Satu</div>
    <div class="card">
        <div class="card-head">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            <span class="card-head-title">Formulir Data Siswa</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.siswa.store') }}" method="POST" id="formTambahSiswa">
                @csrf

                {{-- NIS --}}
                <div class="form-group">
                    <label class="form-label">NIS — Nomor Induk Siswa</label>
                    <input type="text" name="nis" id="inputNis"
                           class="form-input @error('nis') error @enderror"
                           placeholder="11 digit angka"
                           value="{{ old('nis') }}"
                           maxlength="11" inputmode="numeric" pattern="\d{11}" required>
                    <div class="input-hint">
                        <span class="hint-text" id="nisHint">NIS harus tepat 11 digit angka</span>
                        <span class="hint-count" id="nisCounter">0 / 11</span>
                    </div>
                    @error('nis')<div class="form-err">{{ $message }}</div>@enderror
                </div>

                {{-- Nama --}}
                <div class="form-group">
                    <label class="form-label">Nama Siswa</label>
                    <input type="text" name="nama_siswa"
                           class="form-input @error('nama_siswa') error @enderror"
                           placeholder="Nama lengkap siswa"
                           value="{{ old('nama_siswa') }}" required>
                    @error('nama_siswa')<div class="form-err">{{ $message }}</div>@enderror
                </div>

                {{-- Kelas --}}
                <div class="form-group">
                    <label class="form-label">Kelas</label>
                    <div class="radio-group">
                        <label class="radio-card">
                            <input type="radio" name="kelas" value="XI SIJA 1"
                                   {{ old('kelas') === 'XI SIJA 1' ? 'checked' : '' }} required>
                            <div class="radio-card-text">
                                <span class="radio-card-label">XI SIJA 1</span>
                                <span class="radio-card-sub">Kelas SIJA angkatan pertama</span>
                            </div>
                        </label>
                        <label class="radio-card">
                            <input type="radio" name="kelas" value="XI SIJA 2"
                                   {{ old('kelas') === 'XI SIJA 2' ? 'checked' : '' }}>
                            <div class="radio-card-text">
                                <span class="radio-card-label">XI SIJA 2</span>
                                <span class="radio-card-sub">Kelas SIJA angkatan kedua</span>
                            </div>
                        </label>
                    </div>
                    @error('kelas')<div class="form-err" style="margin-top:8px">{{ $message }}</div>@enderror
                </div>

                {{-- INFO AKUN OTOMATIS --}}
                <div class="akun-info">
                    <div class="akun-info-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Akun Login Dibuat Otomatis
                    </div>
                    <div class="akun-row">
                        <span class="akun-key">Email</span>
                        <span class="akun-val">siswa.{5 digit terakhir NIS}@sija.sch.id</span>
                    </div>
                    <div class="akun-row">
                        <span class="akun-key">Password</span>
                        <span class="akun-val">password</span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-gold" id="btnSimpan">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Siswa
                    </button>
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-ghost">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- DIVIDER --}}
    <div class="divider">
        <span>atau tambahkan banyak siswa sekaligus via Excel</span>
    </div>

    {{-- ══ SECTION 2: IMPORT ══ --}}
    <div class="sec-title">Import dari Excel</div>
    <div class="card">
        <div class="card-head">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            <span class="card-head-title">Upload File Excel</span>
        </div>
        <div class="card-body">

            {{-- STEPS --}}
            <div class="steps-grid">
                <div class="step-box">
                    <div class="step-num">1</div>
                    <div class="step-title">Download Template</div>
                    <div class="step-desc">Klik tombol di bawah untuk mendapatkan file Excel template</div>
                </div>
                <div class="step-box">
                    <div class="step-num">2</div>
                    <div class="step-title">Isi Data di Excel</div>
                    <div class="step-desc">Isi NIS (11 digit), Nama Siswa, dan Kelas mulai dari baris ke-4</div>
                </div>
                <div class="step-box">
                    <div class="step-num">3</div>
                    <div class="step-title">Upload & Import</div>
                    <div class="step-desc">Pilih file lalu klik Upload untuk memproses import data</div>
                </div>
            </div>

            <div class="format-info">
                <strong>Format kolom Excel:</strong>
                <span class="code-tag">A: NIS (11 digit) &nbsp;|&nbsp; B: Nama Siswa &nbsp;|&nbsp; C: Kelas</span>
                <div class="format-note">
                    ⚠️ Kolom Kelas hanya boleh <strong style="color:var(--gold-dim)">XI SIJA 1</strong> atau <strong style="color:var(--gold-dim)">XI SIJA 2</strong>
                    &nbsp;·&nbsp; NIS harus tepat <strong style="color:var(--gold-dim)">11 digit angka</strong>
                    &nbsp;·&nbsp; Jangan ubah baris 1–3 (header template)
                </div>
            </div>

            <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="import-row">
                    <input type="file" name="file_import" accept=".xlsx,.xls" class="import-file" required>
                    <button type="submit" class="btn btn-teal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                        Upload & Import
                    </button>
                    <a href="{{ route('admin.siswa.template-import') }}" class="btn btn-yellow">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download Template
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>

<footer>&copy; {{ date('Y') }} SMK — Sistem Presensi Digital Kelas XI SIJA 1 &amp; 2</footer>

<script>
const inputNis   = document.getElementById('inputNis');
const nisCounter = document.getElementById('nisCounter');
const nisHint    = document.getElementById('nisHint');

inputNis.addEventListener('keypress', e => { if (!/\d/.test(e.key)) e.preventDefault(); });
inputNis.addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 11);
    updateNisUI();
});

function updateNisUI() {
    const len = inputNis.value.length;
    nisCounter.textContent = len + ' / 11';
    if (len === 0) {
        nisCounter.style.color    = 'var(--muted)';
        nisHint.textContent       = 'NIS harus tepat 11 digit angka';
        nisHint.style.color       = 'var(--muted)';
        inputNis.style.borderColor = '';
    } else if (len < 11) {
        nisCounter.style.color    = '#f59e0b';
        nisHint.textContent       = 'Masih kurang ' + (11 - len) + ' digit lagi';
        nisHint.style.color       = '#f59e0b';
        inputNis.style.borderColor = '#f59e0b';
    } else {
        nisCounter.style.color    = '#10b981';
        nisHint.textContent       = '✓ Format NIS valid';
        nisHint.style.color       = '#10b981';
        inputNis.style.borderColor = '#10b981';
    }
}

document.getElementById('formTambahSiswa').addEventListener('submit', function (e) {
    if (inputNis.value.length !== 11) {
        e.preventDefault();
        inputNis.focus();
        nisHint.textContent       = 'NIS harus tepat 11 digit angka!';
        nisHint.style.color       = '#f87171';
        inputNis.style.borderColor = '#f87171';
    }
});

updateNisUI();
</script>
</body>
</html>