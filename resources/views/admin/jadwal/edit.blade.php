<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Jadwal — SIJA Presensi</title>
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
            position: relative; z-index: 2; max-width: 900px; margin: 0 auto;
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
        .alert-error { background: rgba(248,113,113,.08); border: 1px solid rgba(248,113,113,.22); color: #fca5a5; }
        .alert ul { margin: 6px 0 0 16px; line-height: 1.7; }

        /* LAYOUT */
        .edit-layout { display: grid; grid-template-columns: 1fr 260px; gap: 1.2rem; align-items: flex-start; }

        /* CARD */
        .card { background: var(--glass); border: 1px solid var(--border-w); border-radius: 16px; overflow: hidden; }
        .card-head { padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-w); display: flex; align-items: center; gap: 10px; }
        .card-head svg { width: 16px; height: 16px; color: var(--gold); flex-shrink: 0; }
        .card-head-title { font-size: 14px; font-weight: 600; color: var(--white); }
        .card-body { padding: 1.5rem; }

        /* FORM */
        .form-group { margin-bottom: 1.3rem; }
        .form-group:last-child { margin-bottom: 0; }
        .form-label {
            display: block; font-size: 11px; font-weight: 700; color: var(--muted);
            letter-spacing: .5px; text-transform: uppercase; margin-bottom: 7px;
        }
        .form-input {
            width: 100%; background: rgba(255,255,255,.05); border: 1px solid var(--border-w);
            border-radius: 9px; padding: 11px 14px; font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif; color: var(--white);
            transition: border-color .2s, background .2s; outline: none; appearance: none;
        }
        .form-input::placeholder { color: rgba(143,163,192,.5); }
        .form-input:focus { border-color: var(--gold); background: rgba(255,255,255,.08); }
        .form-input:disabled {
            background: rgba(255,255,255,.02); color: var(--muted);
            cursor: not-allowed; border-color: rgba(255,255,255,.05);
        }
        .form-input.error { border-color: #f87171; }
        select.form-input option { background: #132D52; color: var(--white); }
        .form-err { font-size: 12px; color: #f87171; margin-top: 5px; }

        /* KODE wrapper */
        .kode-wrap { position: relative; }
        .kode-badge {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            font-size: 11px; font-weight: 700; color: var(--muted);
            background: rgba(255,255,255,.06); border: 1px solid var(--border-w);
            padding: 2px 9px; border-radius: 20px;
        }
        .field-note {
            margin-top: 6px; font-size: 12px; color: var(--muted);
            display: flex; align-items: center; gap: 6px;
        }
        .field-note svg { width: 13px; height: 13px; color: #fbbf24; }

        /* RADIO KELAS */
        .radio-group { display: flex; gap: 10px; margin-top: 4px; }
        .radio-card {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 16px; background: rgba(255,255,255,.04);
            border: 1px solid var(--border-w); border-radius: 10px;
            cursor: pointer; transition: all .2s; flex: 1;
        }
        .radio-card:has(input:checked) { background: rgba(201,150,60,.1); border-color: var(--border); }
        .radio-card input { accent-color: var(--gold); width: 16px; height: 16px; cursor: pointer; flex-shrink: 0; }
        .radio-card-label { font-size: 14px; font-weight: 600; color: var(--white); display: block; }
        .radio-card-sub { font-size: 11px; color: var(--muted); margin-top: 2px; }

        /* FORM GRID — 2 col for hari + jam */
        .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        /* BUTTONS */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 7px;
            padding: 11px 18px; border-radius: 9px; font-size: 13px; font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
            border: 1px solid transparent; text-decoration: none; transition: all .2s; width: 100%;
        }
        .btn svg { width: 15px; height: 15px; }
        .btn-gold  { background: var(--gold); border-color: var(--gold); color: var(--navy); }
        .btn-gold:hover { background: var(--gold-lt); transform: translateY(-1px); }
        .btn-ghost { background: var(--glass); border-color: var(--border-w); color: var(--muted); }
        .btn-ghost:hover { background: rgba(255,255,255,.08); color: var(--white); }
        .form-actions { display: flex; flex-direction: column; gap: 10px; margin-top: 1.5rem; }

        /* JADWAL PREVIEW CARD */
        .preview-card {
            background: rgba(201,150,60,.06); border: 1px solid var(--border);
            border-radius: 14px; padding: 1.3rem; margin-bottom: 1rem;
        }
        .preview-label {
            font-size: 11px; font-weight: 700; color: var(--muted);
            text-transform: uppercase; letter-spacing: .4px; margin-bottom: .8rem;
            display: flex; align-items: center; gap: 6px;
        }
        .preview-label svg { width: 13px; height: 13px; color: var(--gold); }
        .preview-row { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
        .preview-row:last-child { margin-bottom: 0; }
        .preview-key { font-size: 12px; color: var(--muted); width: 80px; flex-shrink: 0; }
        .preview-val { font-size: 13px; font-weight: 600; color: var(--white); }

        /* HARI TAG colors */
        .hari-tag { display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .hari-Senin   { background: rgba(59,130,246,.12);  color: #93c5fd; }
        .hari-Selasa  { background: rgba(13,148,136,.12);  color: #2dd4bf; }
        .hari-Rabu    { background: rgba(124,58,237,.12);  color: #a78bfa; }
        .hari-Kamis   { background: rgba(217,119,6,.12);   color: #fde68a; }
        .hari-Jumat   { background: rgba(236,72,153,.12);  color: #f9a8d4; }

        .jam-badge {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 8px;
            background: rgba(201,150,60,.12); border: 1px solid var(--border);
            font-size: 13px; font-weight: 700; color: var(--gold-lt);
        }

        /* INFO SIDEBAR */
        .info-box { background: var(--glass); border: 1px solid var(--border-w); border-radius: 14px; overflow: hidden; }
        .info-box-head {
            padding: .85rem 1.2rem; border-bottom: 1px solid var(--border-w);
            font-size: 12px; font-weight: 700; color: var(--muted);
            letter-spacing: .5px; text-transform: uppercase;
            display: flex; align-items: center; gap: 8px;
        }
        .info-box-head svg { width: 14px; height: 14px; color: var(--gold); }
        .info-list { padding: .9rem 1.2rem; display: flex; flex-direction: column; gap: .75rem; }
        .info-item { display: flex; align-items: flex-start; gap: 10px; }
        .info-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--gold); flex-shrink: 0; margin-top: 5px; }
        .info-text { font-size: 12px; color: var(--muted); line-height: 1.6; }
        .info-text strong { color: var(--white); display: block; margin-bottom: 1px; }

        footer { position: relative; z-index: 2; text-align: center; padding: 1.5rem; border-top: 1px solid var(--border-w); font-size: 12px; color: var(--muted); }

        @media (max-width: 768px) {
            nav { padding: 1rem 1.2rem; }
            .wrap { padding: 1.5rem 1.2rem 3rem; }
            .edit-layout { grid-template-columns: 1fr; }
            .form-row-2 { grid-template-columns: 1fr; }
            .radio-group { flex-direction: column; }
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
    <a href="{{ route('admin.jadwal.index') }}" class="nav-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Daftar Jadwal
    </a>
</nav>

<div class="wrap">

    @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div><strong>Terjadi Kesalahan:</strong>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-badge">Edit Data</div>
        <h1 class="page-title">Edit <span>Jadwal</span></h1>
        <p class="page-sub">Ubah informasi jadwal pelajaran — kode {{ $jadwal->kode_jam_pelajaran }}</p>
    </div>

    <div class="edit-layout">

        {{-- FORM --}}
        <div class="card">
            <div class="card-head">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <span class="card-head-title">Formulir Edit Jadwal</span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jadwal.update', $jadwal->kode_jam_pelajaran) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Kode Jadwal readonly --}}
                    <div class="form-group">
                        <label class="form-label">Kode Jadwal</label>
                        <div class="kode-wrap">
                            <input type="text" class="form-input"
                                   value="{{ $jadwal->kode_jam_pelajaran }}" disabled
                                   style="font-family:monospace; letter-spacing:1px; padding-right:80px;">
                            <span class="kode-badge">permanen</span>
                        </div>
                        <div class="field-note">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            Kode jadwal tidak dapat diubah setelah dibuat
                        </div>
                    </div>

                    {{-- Hari + Jam Ke --}}
                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Hari</label>
                            <select name="hari" class="form-input @error('hari') error @enderror" required>
                                <option value="">-- Pilih Hari --</option>
                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $h)
                                    <option value="{{ $h }}" {{ old('hari', $jadwal->hari) === $h ? 'selected' : '' }}>{{ $h }}</option>
                                @endforeach
                            </select>
                            @error('hari')<div class="form-err">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jam Ke</label>
                            <input type="number" name="jam_ke"
                                   class="form-input @error('jam_ke') error @enderror"
                                   placeholder="Contoh: 1, 2, 3..."
                                   value="{{ old('jam_ke', $jadwal->jam_ke) }}"
                                   min="1" required>
                            @error('jam_ke')<div class="form-err">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Mapel --}}
                    <div class="form-group">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="kode_mapel" class="form-input @error('kode_mapel') error @enderror" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapel as $m)
                                <option value="{{ $m->kode_mapel }}"
                                    {{ old('kode_mapel', $jadwal->kode_mapel) === $m->kode_mapel ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_mapel')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Guru --}}
                    <div class="form-group">
                        <label class="form-label">Guru Pengampu</label>
                        <select name="nip" class="form-input @error('nip') error @enderror" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->nip }}"
                                    {{ old('nip', $jadwal->nip) === $g->nip ? 'selected' : '' }}>
                                    {{ $g->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                        @error('nip')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <div class="radio-group">
                            <label class="radio-card">
                                <input type="radio" name="kelas" value="XI SIJA 1"
                                       {{ old('kelas', $jadwal->kelas) === 'XI SIJA 1' ? 'checked' : '' }} required>
                                <div>
                                    <span class="radio-card-label">XI SIJA 1</span>
                                    <span class="radio-card-sub">Kelas SIJA pertama</span>
                                </div>
                            </label>
                            <label class="radio-card">
                                <input type="radio" name="kelas" value="XI SIJA 2"
                                       {{ old('kelas', $jadwal->kelas) === 'XI SIJA 2' ? 'checked' : '' }}>
                                <div>
                                    <span class="radio-card-label">XI SIJA 2</span>
                                    <span class="radio-card-sub">Kelas SIJA kedua</span>
                                </div>
                            </label>
                        </div>
                        @error('kelas')<div class="form-err" style="margin-top:8px">{{ $message }}</div>@enderror
                    </div>

                    {{-- ACTIONS --}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-gold">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-ghost">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div style="display: flex; flex-direction: column; gap: 1rem;">

            {{-- Preview Jadwal Saat Ini --}}
            <div class="preview-card">
                <div class="preview-label">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Jadwal Saat Ini
                </div>
                <div class="preview-row">
                    <span class="preview-key">Hari</span>
                    <span class="hari-tag hari-{{ $jadwal->hari }}">{{ $jadwal->hari }}</span>
                </div>
                <div class="preview-row">
                    <span class="preview-key">Jam Ke</span>
                    <span class="jam-badge">{{ $jadwal->jam_ke }}</span>
                </div>
                <div class="preview-row">
                    <span class="preview-key">Mapel</span>
                    <span class="preview-val" style="font-size:12px">{{ $jadwal->mapel->nama_mapel ?? '—' }}</span>
                </div>
                <div class="preview-row">
                    <span class="preview-key">Guru</span>
                    <span class="preview-val" style="font-size:12px">{{ $jadwal->guru->nama_guru ?? '—' }}</span>
                </div>
                <div class="preview-row">
                    <span class="preview-key">Kelas</span>
                    <span class="preview-val" style="font-size:12px">{{ $jadwal->kelas }}</span>
                </div>
            </div>

            {{-- Catatan --}}
            <div class="info-box">
                <div class="info-box-head">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    Catatan
                </div>
                <div class="info-list">
                    <div class="info-item">
                        <div class="info-dot"></div>
                        <div class="info-text">
                            <strong>Kode Permanen</strong>
                            Kode jadwal tidak bisa diubah setelah dibuat
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-dot"></div>
                        <div class="info-text">
                            <strong>Semua Field Bisa Diubah</strong>
                            Hari, jam, mapel, guru, dan kelas bisa diperbarui
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-dot"></div>
                        <div class="info-text">
                            <strong>Cek Konflik</strong>
                            Pastikan tidak ada jadwal yang bertabrakan di hari dan jam yang sama
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<footer>&copy; {{ date('Y') }} SMK — Sistem Presensi Digital Kelas XI SIJA 1 &amp; 2</footer>
</body>
</html>