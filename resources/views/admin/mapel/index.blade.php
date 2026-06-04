<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Mata Pelajaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme-mode.css') }}">
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
            --success:     #4caf8a;
            --text-light:  rgba(255,255,255,.80);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            min-height: 100vh;
        }

        /* ── Background ── */
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
        .btn-back svg { width: 14px; height: 14px; }

        /* ── Page wrapper ── */
        .page-wrap {
            position: relative; z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 24px 80px;
        }

        /* ── Page header ── */
        .page-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 36px; gap: 20px;
        }
        .page-header-left {}
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
            font-size: 2rem; font-weight: 700;
            color: var(--white);
            line-height: 1.2;
        }
        .page-title span { color: var(--gold); }
        .page-sub { margin-top: 6px; color: var(--muted); font-size: .9rem; }

        /* ── Alert success ── */
        .alert-success {
            display: flex; align-items: center; gap: 10px;
            padding: 14px 20px;
            background: rgba(76,175,138,.12);
            border: 1px solid rgba(76,175,138,.3);
            border-radius: 10px;
            color: #7fe3b8;
            font-size: .9rem; font-weight: 500;
            margin-bottom: 28px;
        }

        /* ── Glass card ── */
        .g-card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 16px;
            backdrop-filter: blur(16px);
            overflow: hidden;
            margin-bottom: 24px;
        }
        .g-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--gold-border);
            background: rgba(201,150,60,.06);
            display: flex; align-items: center; justify-content: space-between;
        }
        .g-card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem; font-weight: 600;
            color: var(--gold-light);
        }
        .g-card-body { padding: 24px; }

        /* ── Form tambah ── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr auto;
            gap: 14px;
            align-items: end;
        }
        @media (max-width: 700px) {
            .form-grid { grid-template-columns: 1fr; }
        }
        .form-group { display: flex; flex-direction: column; gap: 7px; }
        .form-label {
            font-size: .78rem; font-weight: 700;
            color: var(--muted);
            letter-spacing: .06em;
            text-transform: uppercase;
        }
        .form-input {
            padding: 10px 14px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(143,163,192,.25);
            border-radius: 9px;
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem;
            transition: all .2s;
            outline: none;
        }
        .form-input::placeholder { color: rgba(143,163,192,.5); }
        .form-input:focus {
            border-color: var(--gold);
            background: rgba(201,150,60,.07);
            box-shadow: 0 0 0 3px rgba(201,150,60,.12);
        }

        /* ── Buttons ── */
        .btn-gold {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 22px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border: none; border-radius: 9px;
            color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .88rem; font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
        }
        .btn-gold:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(201,150,60,.35); filter: brightness(1.08); }
        .btn-ghost {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 18px;
            background: var(--glass);
            border: 1px solid rgba(143,163,192,.25);
            border-radius: 8px;
            color: var(--muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .85rem; font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-ghost:hover { border-color: var(--gold-border); color: var(--gold-light); background: var(--glass-hover); }

        /* ── Search ── */
        .search-row {
            display: flex; gap: 10px;
        }
        .search-row .form-input { flex: 1; }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr {
            background: rgba(201,150,60,.08);
            border-bottom: 1px solid var(--gold-border);
        }
        thead th {
            padding: 13px 18px;
            text-align: left;
            font-size: .78rem; font-weight: 700;
            color: var(--gold);
            letter-spacing: .07em;
            text-transform: uppercase;
        }
        tbody tr {
            border-bottom: 1px solid rgba(143,163,192,.1);
            transition: background .15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.04); }
        tbody td {
            padding: 14px 18px;
            font-size: .9rem;
            color: var(--text-light);
            vertical-align: middle;
        }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center;
            padding: 4px 11px;
            border-radius: 6px;
            font-size: .78rem; font-weight: 700;
            letter-spacing: .03em;
        }
        .badge-gold {
            background: rgba(201,150,60,.15);
            border: 1px solid rgba(201,150,60,.3);
            color: var(--gold-light);
            font-family: monospace;
        }

        /* ── Action btn ── */
        .btn-edit {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 6px 14px;
            background: rgba(201,150,60,.12);
            border: 1px solid rgba(201,150,60,.28);
            border-radius: 7px;
            color: var(--gold-light);
            font-size: .8rem; font-weight: 600;
            text-decoration: none;
            transition: all .18s;
        }
        .btn-edit:hover { background: rgba(201,150,60,.22); border-color: var(--gold); color: var(--gold); }
        .btn-edit svg { width: 13px; height: 13px; }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--muted);
        }
        .empty-icon { font-size: 2.5rem; margin-bottom: 12px; }
        .empty-state p { font-size: .95rem; margin-bottom: 4px; }
        .empty-state small { font-size: .82rem; opacity: .7; }

        /* ── Card footer ── */
        .card-footer {
            padding: 14px 24px;
            border-top: 1px solid var(--gold-border);
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(201,150,60,.04);
        }
        .card-footer span { font-size: .83rem; color: var(--muted); }
        .badge-count {
            padding: 3px 10px;
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            border-radius: 20px;
            color: var(--gold-light);
            font-size: .78rem; font-weight: 700;
        }

        /* ── Pagination ── */
        .pagination-wrap {
            padding: 14px 24px;
            border-top: 1px solid var(--gold-border);
        }
        .pagination-wrap svg {
            width: 16px !important;
            height: 16px !important;
            display: inline-block;
            vertical-align: middle;
        }
        .pagination-wrap nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        .pagination-wrap nav > div:first-child {
            display: none !important;
        }
        .pagination-wrap nav > div:last-child {
            display: flex !important;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 15px;
            flex-wrap: wrap;
        }
        .pagination-wrap nav p {
            font-size: 13px;
            color: var(--muted);
            margin: 0;
        }
        .pagination-wrap nav span.relative {
            display: inline-flex;
            gap: 4px;
            align-items: center;
        }
        .pagination-wrap nav a, 
        .pagination-wrap nav span[aria-current="page"] > span, 
        .pagination-wrap nav span.disabled > span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
            padding: 0 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.07);
            color: var(--muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
        }
        .pagination-wrap nav a:hover {
            background: rgba(201, 150, 60, 0.15);
            border-color: var(--gold);
            color: var(--gold-light) !important;
        }
        .pagination-wrap nav span[aria-current="page"] > span {
            background: var(--gold) !important;
            color: var(--navy) !important;
            border-color: var(--gold) !important;
        }
        .pagination-wrap nav span.disabled > span {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* ── Status bar top ── */
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

        /* ── No of column ── */
        .col-no { width: 5%; }
        .col-kode { width: 22%; }
        .col-nama { width: 55%; }
        .col-aksi { width: 18%; text-align: center; }
        td.col-aksi { text-align: center; }
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
        <div style="display:flex;align-items:center;gap:7px;"><label class="theme-switch" title="Ganti tema"><input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode"><span class="track"></span><span class="thumb"></span></label><span class="theme-label">Dark</span></div>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 12L6 8l4-4"/></svg>
            Dashboard
        </a>
    </div>
</nav>

<div class="page-wrap">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <div class="page-badge">
                <div class="pulse-dot"></div>
                ADMIN PANEL
            </div>
            <h1 class="page-title">Manajemen <span>Mata Pelajaran</span></h1>
            <p class="page-sub">Kelola data mata pelajaran sekolah dengan mudah dan efisien</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if ($message = Session::get('success'))
        <div class="alert-success">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="#4caf8a" stroke-width="1.5"/><path d="M5 8l2 2 4-4" stroke="#4caf8a" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ $message }}
        </div>
    @endif

    <!-- Form Tambah -->
    <div class="g-card">
        <div class="g-card-header">
            <h2>Tambah Mata Pelajaran</h2>
        </div>
        <div class="g-card-body">
            <form action="{{ route('admin.mapel.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Kode Mapel</label>
                        <input type="text" name="kode_mapel" class="form-input" placeholder="Contoh: MPL01" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Mata Pelajaran</label>
                        <input type="text" name="nama_mapel" class="form-input" placeholder="Contoh: Bahasa Indonesia" required>
                    </div>
                    <button type="submit" class="btn-gold">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 2v10M2 7h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search -->
    <div class="g-card">
        <div class="g-card-header">
            <h2>Cari Mata Pelajaran</h2>
        </div>
        <div class="g-card-body">
            <form method="GET" class="search-row">
                <input type="text" name="search" class="form-input"
                    placeholder="Cari berdasarkan kode atau nama mata pelajaran..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn-ghost">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="6" cy="6" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M9.5 9.5l2.5 2.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Tabel -->
    <div class="g-card">
        <div class="g-card-header">
            <h2>Daftar Mata Pelajaran</h2>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-kode">Kode Mapel</th>
                        <th class="col-nama">Nama Mata Pelajaran</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapel as $index => $item)
                        <tr>
                            <td>{{ $mapel->firstItem() + $index }}</td>
                            <td><span class="badge badge-gold">{{ $item->kode_mapel }}</span></td>
                            <td style="font-weight:500; color: var(--white);">{{ $item->nama_mapel }}</td>
                            <td class="col-aksi">
                                <a href="{{ route('admin.mapel.edit', $item->kode_mapel) }}" class="btn-edit">
                                    <svg viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 2l2 2-7 7H2V9L9 2z"/></svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <p>Belum ada data mata pelajaran</p>
                                    <small>Gunakan form di atas untuk menambahkan data baru</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $mapel->links() }}
        </div>

        <div class="card-footer">
            <span>Total Mata Pelajaran</span>
            <span class="badge-count">{{ $mapel->total() }} item</span>
        </div>
    </div>

</div>

<script src="{{ asset('js/theme-mode.js') }}"></script>
</body>
</html>