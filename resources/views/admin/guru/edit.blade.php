<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Guru — SIJA Presensi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:      #0B1F3A;
            --navy-mid:  #132D52;
            --navy-soft: #1C3D6E;
            --gold:      #C9963C;
            --gold-lt:   #E8B455;
            --gold-dim:  #F5D9A0;
            --white:     #FAFAF8;
            --muted:     #8FA3C0;
            --border:    rgba(201,150,60,.25);
            --border-w:  rgba(255,255,255,.07);
            --glass:     rgba(255,255,255,.04);
        }

        html, body { min-height: 100%; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy); color: var(--white); overflow-x: hidden;
        }

        body::before {
            content: ''; position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 70% -10%, rgba(28,61,110,.8) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 10% 80%, rgba(201,150,60,.07) 0%, transparent 50%);
            pointer-events: none; z-index: 0;
        }
        body::after {
            content: ''; position: fixed; inset: 0;
            background-image:
                linear-gradient(rgba(201,150,60,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,150,60,.04) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none; z-index: 0;
        }

        /* NAV */
        nav {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.1rem 2.5rem;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(20px);
            background: rgba(11,31,58,.85);
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
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px;
            background: var(--glass); border: 1px solid var(--border-w); border-radius: 8px;
            color: var(--muted); font-size: 13px; font-weight: 500; text-decoration: none;
            transition: all .2s;
        }
        .nav-back:hover { background: rgba(255,255,255,.08); color: var(--white); border-color: var(--border); }
        .nav-back svg { width: 15px; height: 15px; }

        /* WRAP */
        .wrap {
            position: relative; z-index: 2;
            max-width: 900px; margin: 0 auto;
            padding: 2.5rem 2.5rem 4rem;
            animation: fadeUp .7s ease both;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* PAGE HEADER */
        .page-header { margin-bottom: 2rem; }
        .page-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 5px 12px;
            background: rgba(201,150,60,.12); border: 1px solid rgba(201,150,60,.28); border-radius: 100px;
            font-size: 11px; font-weight: 600; color: var(--gold-lt);
            letter-spacing: .5px; text-transform: uppercase; margin-bottom: 1rem;
        }
        .page-badge::before {
            content: ''; width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold); animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(.7)} }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem; font-weight: 700; color: var(--white);
        }
        .page-title span { color: var(--gold); }
        .page-sub { margin-top: .35rem; font-size: 14px; color: var(--muted); }

        /* ALERTS */
        .alert {
            display: flex; align-items: flex-start; gap: 10px;
            border-radius: 10px; padding: 13px 16px; font-size: 13px; margin-bottom: 1.2rem;
        }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }
        .alert-error { background: rgba(248,113,113,.08); border: 1px solid rgba(248,113,113,.22); color: #fca5a5; }
        .alert ul { margin: 6px 0 0 16px; line-height: 1.7; }

        /* LAYOUT */
        .edit-layout {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 1.2rem;
            align-items: flex-start;
        }

        /* CARD */
        .card {
            background: var(--glass); border: 1px solid var(--border-w); border-radius: 16px;
            overflow: hidden;
        }
        .card-head {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-w);
            display: flex; align-items: center; gap: 10px;
        }
        .card-head svg { width: 16px; height: 16px; color: var(--gold); flex-shrink: 0; }
        .card-head-title { font-size: 14px; font-weight: 600; color: var(--white); }
        .card-body { padding: 1.5rem; }

        /* FORM */
        .form-group { margin-bottom: 1.3rem; }
        .form-group:last-child { margin-bottom: 0; }

        .form-label {
            display: block; font-size: 11px; font-weight: 700;
            color: var(--muted); letter-spacing: .5px; text-transform: uppercase;
            margin-bottom: 7px;
        }

        .form-input {
            width: 100%;
            background: rgba(255,255,255,.05);
            border: 1px solid var(--border-w);
            border-radius: 9px;
            padding: 11px 14px;
            font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--white);
            transition: border-color .2s, background .2s;
            outline: none; appearance: none;
        }
        .form-input::placeholder { color: rgba(143,163,192,.5); }
        .form-input:focus { border-color: var(--gold); background: rgba(255,255,255,.08); }
        .form-input:disabled {
            background: rgba(255,255,255,.02); color: var(--muted);
            cursor: not-allowed; border-color: rgba(255,255,255,.05);
        }
        .form-input.error { border-color: #f87171; }

        select.form-input option { background: #132D52; color: var(--white); }

        /* NIP wrapper */
        .nip-wrap { position: relative; }
        .nip-badge {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            font-size: 11px; font-weight: 700; color: var(--muted);
            background: rgba(255,255,255,.06); border: 1px solid var(--border-w);
            padding: 2px 9px; border-radius: 20px; letter-spacing: .3px;
        }
        .nip-input-padded { padding-right: 70px; font-family: monospace; letter-spacing: 1.5px; }

        .field-note {
            margin-top: 6px; font-size: 12px; color: var(--muted);
            display: flex; align-items: center; gap: 6px;
        }
        .field-note svg { width: 13px; height: 13px; flex-shrink: 0; color: #fbbf24; }
        .form-err { font-size: 12px; color: #f87171; margin-top: 5px; }

        /* ROLE DESC */
        .role-desc {
            margin-top: 8px; padding: 10px 14px;
            border-radius: 8px; font-size: 13px; font-weight: 500;
            display: none; line-height: 1.5;
        }
        .rd-guru      { background: rgba(59,130,246,.08);  border-left: 3px solid #3b82f6; color: #93c5fd; }
        .rd-walikelas { background: rgba(13,148,136,.08);  border-left: 3px solid #0d9488; color: #2dd4bf; }
        .rd-kakon     { background: rgba(124,58,237,.08);  border-left: 3px solid #7c3aed; color: #a78bfa; }

        /* RADIO KELAS */
        .radio-group { display: flex; gap: 10px; margin-top: 4px; }
        .radio-card {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 16px;
            background: rgba(255,255,255,.04); border: 1px solid var(--border-w); border-radius: 9px;
            cursor: pointer; transition: all .2s; flex: 1;
        }
        .radio-card:has(input:checked) {
            background: rgba(201,150,60,.1); border-color: var(--border);
        }
        .radio-card input { accent-color: var(--gold); width: 15px; height: 15px; cursor: pointer; }
        .radio-card span { font-size: 13px; font-weight: 600; color: var(--white); }

        /* TOGGLE */
        .toggle-wrap { display: flex; align-items: center; gap: 14px; margin-top: 4px; }
        .toggle {
            position: relative; width: 44px; height: 24px; flex-shrink: 0;
        }
        .toggle input { opacity: 0; width: 0; height: 0; }
        .toggle-track {
            position: absolute; inset: 0;
            background: rgba(255,255,255,.1); border: 1px solid var(--border-w);
            border-radius: 100px; cursor: pointer; transition: all .25s;
        }
        .toggle-track::before {
            content: ''; position: absolute;
            width: 18px; height: 18px; left: 2px; top: 2px;
            background: var(--muted); border-radius: 50%;
            transition: all .25s;
        }
        .toggle input:checked + .toggle-track { background: rgba(16,185,129,.2); border-color: rgba(16,185,129,.4); }
        .toggle input:checked + .toggle-track::before { transform: translateX(20px); background: #10b981; }
        .toggle-label { font-size: 13px; color: var(--white); }

        /* ACTION BUTTONS */
        .form-actions { display: flex; flex-direction: column; gap: 10px; margin-top: 1.5rem; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 7px;
            padding: 11px 18px; border-radius: 9px; font-size: 13px; font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; border: 1px solid transparent; text-decoration: none;
            transition: all .2s; width: 100%;
        }
        .btn svg { width: 15px; height: 15px; }

        .btn-gold {
            background: var(--gold); border-color: var(--gold); color: var(--navy);
        }
        .btn-gold:hover { background: var(--gold-lt); transform: translateY(-1px); }

        .btn-ghost {
            background: var(--glass); border-color: var(--border-w); color: var(--muted);
        }
        .btn-ghost:hover { background: rgba(255,255,255,.08); color: var(--white); border-color: rgba(255,255,255,.15); }

        /* INFO SIDEBAR */
        .info-card { display: flex; flex-direction: column; gap: 1rem; }
        .info-box {
            background: var(--glass); border: 1px solid var(--border-w); border-radius: 14px;
            overflow: hidden;
        }
        .info-box-head {
            padding: .85rem 1.2rem;
            border-bottom: 1px solid var(--border-w);
            font-size: 12px; font-weight: 700;
            color: var(--muted); letter-spacing: .5px; text-transform: uppercase;
            display: flex; align-items: center; gap: 8px;
        }
        .info-box-head svg { width: 14px; height: 14px; color: var(--gold); }
        .info-list { padding: .9rem 1.2rem; display: flex; flex-direction: column; gap: .75rem; }
        .info-item { display: flex; align-items: flex-start; gap: 10px; }
        .info-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold); flex-shrink: 0; margin-top: 5px;
        }
        .info-text { font-size: 12px; color: var(--muted); line-height: 1.6; }
        .info-text strong { color: var(--white); display: block; margin-bottom: 1px; }

        /* ROLE CARDS in sidebar */
        .role-item {
            display: flex; align-items: flex-start; gap: 10px;
            padding: .85rem 1.2rem;
            border-bottom: 1px solid var(--border-w);
        }
        .role-item:last-child { border-bottom: none; }
        .role-dot {
            width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; margin-top: 4px;
        }
        .role-item-text strong { font-size: 12px; color: var(--white); display: block; margin-bottom: 2px; }
        .role-item-text span  { font-size: 11px; color: var(--muted); line-height: 1.5; }

        footer {
            position: relative; z-index: 2;
            text-align: center; padding: 1.5rem;
            border-top: 1px solid var(--border-w);
            font-size: 12px; color: var(--muted);
        }

        @media (max-width: 768px) {
            nav { padding: 1rem 1.2rem; }
            .wrap { padding: 1.5rem 1.2rem 3rem; }
            .edit-layout { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

{{-- NAV --}}
<nav>
    <div class="nav-brand">
        <div class="nav-logo">S</div>
        <div>
            <div class="nav-name">SIJA Presensi</div>
            <div class="nav-sub">Sistem Informasi Akademik</div>
        </div>
    </div>
    <a href="{{ route('admin.guru.index') }}" class="nav-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5M12 5l-7 7 7 7"/>
        </svg>
        Daftar Guru
    </a>
</nav>

<div class="wrap">

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <strong>Terjadi Kesalahan:</strong>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-badge">Edit Data</div>
        <h1 class="page-title">Edit <span>Guru</span></h1>
        <p class="page-sub">Ubah informasi dan role guru — {{ $guru->nama_guru }}</p>
    </div>

    <div class="edit-layout">

        {{-- FORM --}}
        <div class="card">
            <div class="card-head">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <span class="card-head-title">Formulir Edit Guru</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.guru.update', $guru->nip) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- NIP readonly --}}
                    <div class="form-group">
                        <label class="form-label">NIP — Nomor Induk Pegawai</label>
                        <div class="nip-wrap">
                            <input type="text" class="form-input nip-input-padded"
                                   value="{{ $guru->nip }}" disabled>
                            <span class="nip-badge">18 digit</span>
                        </div>
                        <div class="field-note">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            NIP tidak dapat diubah setelah data disimpan
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div class="form-group">
                        <label class="form-label">Nama Guru</label>
                        <input type="text" name="nama_guru"
                               class="form-input @error('nama_guru') error @enderror"
                               placeholder="Nama lengkap guru"
                               value="{{ old('nama_guru', $guru->nama_guru) }}" required>
                        @error('nama_guru')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Mapel --}}
                    <div class="form-group">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="kode_mapel"
                                class="form-input @error('kode_mapel') error @enderror" required>
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mapel as $m)
                                <option value="{{ $m->kode_mapel }}"
                                    {{ old('kode_mapel', $guru->kode_mapel) === $m->kode_mapel ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_mapel')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Role --}}
                    <div class="form-group">
                        <label class="form-label">Role / Jabatan</label>
                        <select name="role" id="roleSelect"
                                class="form-input @error('role') error @enderror"
                                onchange="handleRoleChange()" required>
                            <option value="guru"
                                {{ old('role', $user->role ?? 'guru') === 'guru' ? 'selected' : '' }}>
                                Guru Normatif/Produktif
                            </option>
                            <option value="walikelas"
                                {{ old('role', $user->role ?? 'guru') === 'walikelas' ? 'selected' : '' }}>
                                Wali Kelas
                            </option>
                            <option value="kakon"
                                {{ old('role', $user->role ?? 'guru') === 'kakon' ? 'selected' : '' }}>
                                Kepala Konsentrasi Jurusan
                            </option>
                        </select>
                        @error('role')<div class="form-err">{{ $message }}</div>@enderror
                        <div class="role-desc" id="roleDesc"></div>
                    </div>

                    {{-- Kelas Wali --}}
                    <div class="form-group" id="kelasWaliGroup"
                         style="display: {{ old('role', $user->role ?? 'guru') === 'walikelas' ? 'block' : 'none' }};">
                        <label class="form-label">Kelas yang Diwali</label>
                        <div class="radio-group">
                            <label class="radio-card">
                                <input type="radio" name="kelas_wali" value="XI SIJA 1"
                                    {{ old('kelas_wali', $user->kelas_wali ?? '') === 'XI SIJA 1' ? 'checked' : '' }}>
                                <span>XI SIJA 1</span>
                            </label>
                            <label class="radio-card">
                                <input type="radio" name="kelas_wali" value="XI SIJA 2"
                                    {{ old('kelas_wali', $user->kelas_wali ?? '') === 'XI SIJA 2' ? 'checked' : '' }}>
                                <span>XI SIJA 2</span>
                            </label>
                        </div>
                        @error('kelas_wali')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Status Akun --}}
                    <div class="form-group">
                        <label class="form-label">Status Akun</label>
                        <div class="toggle-wrap">
                            <label class="toggle">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ ($user && $user->is_active) ? 'checked' : '' }}
                                    onchange="updateToggleLabel(this)">
                                <span class="toggle-track"></span>
                            </label>
                            <span class="toggle-label" id="toggleLabel">
                                {{ ($user && $user->is_active) ? 'Aktif — Guru dapat login' : 'Nonaktif — Guru tidak dapat login' }}
                            </span>
                        </div>
                        @if(!$user)
                            <div class="field-note" style="margin-top:8px;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                Akun login belum ditemukan untuk guru ini
                            </div>
                        @endif
                    </div>

                    {{-- ACTIONS --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-gold">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-ghost">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="info-card">

            {{-- Panduan Role --}}
            <div class="info-box">
                <div class="info-box-head">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Panduan Role
                </div>
                <div>
                    <div class="role-item">
                        <div class="role-dot" style="background:#60a5fa"></div>
                        <div class="role-item-text">
                            <strong>Guru Normatif/Produktif</strong>
                            <span>Akses dashboard guru, generate token & kelola presensi kelas</span>
                        </div>
                    </div>
                    <div class="role-item">
                        <div class="role-dot" style="background:#2dd4bf"></div>
                        <div class="role-item-text">
                            <strong>Wali Kelas</strong>
                            <span>Pantau presensi kelas yang diwali secara real-time</span>
                        </div>
                    </div>
                    <div class="role-item">
                        <div class="role-dot" style="background:#a78bfa"></div>
                        <div class="role-item-text">
                            <strong>Kepala Konsentrasi</strong>
                            <span>Lihat data presensi seluruh kelas SIJA</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="info-box">
                <div class="info-box-head">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Catatan Penting
                </div>
                <div class="info-list">
                    <div class="info-item">
                        <div class="info-dot"></div>
                        <div class="info-text">
                            <strong>NIP Permanen</strong>
                            NIP 18 digit bersifat tetap dan tidak bisa dimodifikasi setelah disimpan
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-dot"></div>
                        <div class="info-text">
                            <strong>Nonaktifkan Akun</strong>
                            Guru yang dinonaktifkan tidak bisa login ke sistem
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-dot"></div>
                        <div class="info-text">
                            <strong>Kelas Wali</strong>
                            Hanya muncul jika role dipilih sebagai Wali Kelas
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<footer>&copy; {{ date('Y') }} SMK — Sistem Presensi Digital Kelas XI SIJA 1 &amp; 2</footer>

<script>
const roleDescs = {
    guru:      { text: 'Guru Normatif/Produktif — akses dashboard guru untuk generate token dan kelola presensi kelas.', cls: 'rd-guru' },
    walikelas: { text: 'Wali Kelas — akses dashboard walikelas untuk memantau presensi kelas yang diwali.', cls: 'rd-walikelas' },
    kakon:     { text: 'Kepala Konsentrasi — akses dashboard kakon untuk data presensi seluruh kelas SIJA.', cls: 'rd-kakon' },
};

function handleRoleChange() {
    const role = document.getElementById('roleSelect').value;
    const descBox = document.getElementById('roleDesc');
    const kelasGrp = document.getElementById('kelasWaliGroup');
    const info = roleDescs[role];

    descBox.textContent = info.text;
    descBox.className   = 'role-desc ' + info.cls;
    descBox.style.display = 'block';

    kelasGrp.style.display = (role === 'walikelas') ? 'block' : 'none';
    if (role !== 'walikelas') {
        document.querySelectorAll('input[name="kelas_wali"]').forEach(r => r.checked = false);
    }
}

function updateToggleLabel(el) {
    document.getElementById('toggleLabel').textContent = el.checked
        ? 'Aktif — Guru dapat login'
        : 'Nonaktif — Guru tidak dapat login';
}

document.addEventListener('DOMContentLoaded', handleRoleChange);
</script>
</body>
</html>