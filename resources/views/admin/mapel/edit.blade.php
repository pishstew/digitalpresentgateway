<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Pelajaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:        #0B1F3A;
            --navy-mid:    #112847;
            --navy-light:  #1a3560;
            --gold:        #C9963C;
            --gold-light:  #e0b060;
            --gold-dim:    rgba(201,150,60,.18);
            --gold-border: rgba(201,150,60,.28);
            --muted:       #8FA3C0;
            --glass:       rgba(255,255,255,.06);
            --glass-hover: rgba(255,255,255,.10);
            --white:       #ffffff;
            --danger:      #e05c5c;
            --text-light:  rgba(255,255,255,.80);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(201,150,60,.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(11,31,58,.9) 0%, transparent 70%);
        }
        body::after {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(201,150,60,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,150,60,.04) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .status-bar {
            height: 3px;
            background: linear-gradient(90deg, var(--gold), #a8782e, var(--gold));
            background-size: 200% 100%;
            animation: shimmer 3s infinite linear;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* ── Navbar ── */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px;
            height: 64px;
            background: rgba(11,31,58,.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gold-border);
        }
        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .nav-logo {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 1.1rem; color: var(--navy);
        }
        .nav-title { font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--white); }
        .nav-right { display: flex; align-items: center; gap: 10px; }
        .btn-back {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 16px;
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 8px;
            color: var(--gold-light);
            text-decoration: none;
            font-size: .85rem; font-weight: 600;
            transition: all .2s;
        }
        .btn-back:hover { background: var(--glass-hover); border-color: var(--gold); color: var(--gold); }

        /* ── Page wrap ── */
        .page-wrap {
            position: relative; z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 24px 80px;
        }

        /* ── Page header ── */
        .page-badge {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 5px 14px;
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            border-radius: 20px;
            font-size: .78rem; font-weight: 600;
            color: var(--gold-light);
            letter-spacing: .05em;
            margin-bottom: 12px;
        }
        .pulse-dot {
            width: 7px; height: 7px;
            background: var(--gold);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:.5; transform:scale(1.4); }
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem; font-weight: 700;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 6px;
        }
        .page-title span { color: var(--gold); }
        .page-sub { color: var(--muted); font-size: .9rem; margin-bottom: 32px; }

        /* ── Layout 2 kolom ── */
        .two-col {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 24px;
            align-items: start;
        }
        @media (max-width: 720px) {
            .two-col { grid-template-columns: 1fr; }
        }

        /* ── Glass card ── */
        .g-card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 16px;
            backdrop-filter: blur(16px);
            overflow: hidden;
        }
        .g-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--gold-border);
            background: rgba(201,150,60,.06);
        }
        .g-card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem; font-weight: 600;
            color: var(--gold-light);
        }
        .g-card-body { padding: 28px 24px; }

        /* ── Error alert ── */
        .error-alert {
            padding: 14px 18px;
            background: rgba(224,92,92,.1);
            border: 1px solid rgba(224,92,92,.3);
            border-radius: 10px;
            margin-bottom: 24px;
        }
        .error-alert h3 {
            font-size: .88rem; font-weight: 700;
            color: #f08080;
            margin-bottom: 8px;
        }
        .error-alert ul { padding-left: 18px; }
        .error-alert li { font-size: .85rem; color: #f08080; margin-bottom: 4px; }

        /* ── Form fields ── */
        .form-group { margin-bottom: 22px; }
        .form-label {
            display: block;
            font-size: .78rem; font-weight: 700;
            color: var(--muted);
            letter-spacing: .06em;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .field-wrap { position: relative; }
        .form-input {
            width: 100%;
            padding: 11px 14px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(143,163,192,.25);
            border-radius: 9px;
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem;
            transition: all .2s;
            outline: none;
        }
        .form-input::placeholder { color: rgba(143,163,192,.45); }
        .form-input:focus {
            border-color: var(--gold);
            background: rgba(201,150,60,.06);
            box-shadow: 0 0 0 3px rgba(201,150,60,.12);
        }
        .form-input:disabled {
            background: rgba(255,255,255,.03);
            color: var(--muted);
            cursor: not-allowed;
        }
        .form-input.has-error { border-color: rgba(224,92,92,.6); }

        .field-badge {
            position: absolute; right: 10px; top: 50%;
            transform: translateY(-50%);
            padding: 3px 9px;
            background: rgba(143,163,192,.15);
            border: 1px solid rgba(143,163,192,.2);
            border-radius: 5px;
            font-size: .72rem; font-weight: 700;
            color: var(--muted);
        }

        .field-warning {
            display: flex; align-items: center; gap: 5px;
            margin-top: 7px;
            font-size: .8rem;
            color: rgba(201,150,60,.7);
        }
        .field-warning svg { width: 13px; height: 13px; flex-shrink: 0; }
        .form-error-msg {
            margin-top: 7px;
            font-size: .8rem;
            color: #f08080;
        }

        /* ── Form buttons ── */
        .form-buttons {
            display: flex; gap: 12px;
            margin-top: 28px;
        }
        .btn-save {
            flex: 1;
            padding: 12px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border: none; border-radius: 9px;
            color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem; font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(201,150,60,.35); filter: brightness(1.08); }
        .btn-cancel {
            flex: 1;
            padding: 12px;
            background: var(--glass);
            border: 1px solid rgba(143,163,192,.25);
            border-radius: 9px;
            color: var(--muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem; font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: 7px;
        }
        .btn-cancel:hover { border-color: var(--gold-border); color: var(--gold-light); background: rgba(255,255,255,.08); }

        /* ── Sidebar info card ── */
        .info-card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 16px;
            backdrop-filter: blur(16px);
            overflow: hidden;
        }
        .info-card-header {
            padding: 16px 20px;
            background: rgba(201,150,60,.08);
            border-bottom: 1px solid var(--gold-border);
        }
        .info-card-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: .95rem; font-weight: 600;
            color: var(--gold-light);
        }
        .info-card-body { padding: 20px; }

        /* Preview box */
        .preview-box {
            background: rgba(201,150,60,.07);
            border: 1px solid var(--gold-border);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 18px;
        }
        .preview-label {
            font-size: .72rem; font-weight: 700;
            color: var(--muted);
            letter-spacing: .07em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .preview-row {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 8px;
        }
        .preview-row:last-child { margin-bottom: 0; }
        .preview-key {
            font-size: .78rem; color: var(--muted); min-width: 80px;
        }
        .preview-val {
            font-size: .88rem; font-weight: 600; color: var(--white);
        }
        .badge-mono {
            padding: 3px 10px;
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            border-radius: 6px;
            font-family: monospace;
            font-size: .85rem; font-weight: 700;
            color: var(--gold-light);
        }

        /* Info list */
        .info-list { list-style: none; }
        .info-list li {
            display: flex; gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(143,163,192,.08);
            font-size: .83rem; color: var(--muted);
            line-height: 1.5;
        }
        .info-list li:last-child { border-bottom: none; padding-bottom: 0; }
        .info-list .dot {
            width: 5px; height: 5px;
            background: var(--gold);
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 7px;
        }
    </style>
</head>
<body>

<div class="status-bar"></div>

<!-- Navbar -->
<nav class="navbar">
    <a href="{{ route('admin.dashboard') }}" class="nav-brand">
        <div class="nav-logo">S</div>
        <span class="nav-title">SchoolSystem</span>
    </a>
    <div class="nav-right">
        <a href="{{ route('admin.mapel.index') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11L5 7l4-4"/></svg>
            Kembali
        </a>
    </div>
</nav>

<div class="page-wrap">

    <!-- Page Header -->
    <div class="page-badge">
        <div class="pulse-dot"></div>
        EDIT DATA
    </div>
    <h1 class="page-title">Edit <span>Mata Pelajaran</span></h1>
    <p class="page-sub">Ubah informasi mata pelajaran sesuai kebutuhan</p>

    <div class="two-col">

        <!-- Kolom Kiri: Form -->
        <div class="g-card">
            <div class="g-card-header">
                <h2>Formulir Edit</h2>
            </div>
            <div class="g-card-body">

                @if ($errors->any())
                    <div class="error-alert">
                        <h3>Terjadi Kesalahan</h3>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.mapel.update', $mapel->kode_mapel) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Kode Mapel (disabled) -->
                    <div class="form-group">
                        <label class="form-label">Kode Mapel</label>
                        <div class="field-wrap">
                            <input type="text" id="kode_mapel" name="kode_mapel"
                                class="form-input"
                                value="{{ $mapel->kode_mapel }}"
                                style="padding-right: 80px;"
                                disabled>
                            <span class="field-badge">permanen</span>
                        </div>
                        <p class="field-warning">
                            <svg viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="6.5" cy="6.5" r="5.5"/><path d="M6.5 4v2.5M6.5 8.5v.5" stroke-linecap="round"/></svg>
                            Kode mapel tidak dapat diubah
                        </p>
                    </div>

                    <!-- Nama Mapel -->
                    <div class="form-group">
                        <label class="form-label" for="nama_mapel">Nama Mata Pelajaran</label>
                        <input type="text" id="nama_mapel" name="nama_mapel"
                            class="form-input @error('nama_mapel') has-error @enderror"
                            placeholder="Contoh: Bahasa Indonesia"
                            value="{{ old('nama_mapel', $mapel->nama_mapel) }}"
                            required>
                        @error('nama_mapel')
                            <p class="form-error-msg">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="form-buttons">
                        <button type="submit" class="btn-save">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7l3.5 3.5L12 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Perbarui
                        </button>
                        <a href="{{ route('admin.mapel.index') }}" class="btn-cancel">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M10 4L4 10M4 4l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>

        <!-- Kolom Kanan: Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 16px;">

            <!-- Preview data saat ini -->
            <div class="info-card">
                <div class="info-card-header">
                    <h3>Data Saat Ini</h3>
                </div>
                <div class="info-card-body">
                    <div class="preview-box">
                        <div class="preview-label">Informasi Mapel</div>
                        <div class="preview-row">
                            <span class="preview-key">Kode</span>
                            <span class="badge-mono">{{ $mapel->kode_mapel }}</span>
                        </div>
                        <div class="preview-row">
                            <span class="preview-key">Nama</span>
                            <span class="preview-val">{{ $mapel->nama_mapel }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panduan -->
            <div class="info-card">
                <div class="info-card-header">
                    <h3>Catatan Penting</h3>
                </div>
                <div class="info-card-body">
                    <ul class="info-list">
                        <li>
                            <div class="dot"></div>
                            <span>Hanya nama mata pelajaran yang dapat diubah</span>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <span>Kode mapel bersifat permanen dan tidak bisa dimodifikasi</span>
                        </li>
                        <li>
                            <div class="dot"></div>
                            <span>Pastikan data sudah benar sebelum menyimpan perubahan</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>