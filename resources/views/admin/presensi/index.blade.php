<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Presensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme-mode.css') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:        #0B1F3A;
            --gold:        #C9963C;
            --gold-light:  #e0b060;
            --gold-dim:    rgba(201,150,60,.18);
            --gold-border: rgba(201,150,60,.28);
            --muted:       #8FA3C0;
            --glass:       rgba(255,255,255,.06);
            --glass-hover: rgba(255,255,255,.10);
            --white:       #ffffff;
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

        /* Status bar */
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

        /* Navbar */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px; height: 64px;
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

        /* Page wrap */
        .page-wrap {
            position: relative; z-index: 1;
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 24px 80px;
        }

        /* Page header */
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
            background: var(--gold); border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:.5; transform:scale(1.4); }
        }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem; font-weight: 700;
            color: var(--white); line-height: 1.2;
        }
        .page-title span { color: var(--gold); }
        .page-sub { margin-top: 6px; color: var(--muted); font-size: .9rem; margin-bottom: 32px; }

        /* Alert */
        .alert-success {
            display: flex; align-items: center; gap: 10px;
            padding: 14px 20px;
            background: rgba(76,175,138,.12);
            border: 1px solid rgba(76,175,138,.3);
            border-radius: 10px;
            color: #7fe3b8;
            font-size: .9rem; font-weight: 500;
            margin-bottom: 24px;
        }

        /* Glass card */
        .g-card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 16px;
            backdrop-filter: blur(16px);
            overflow: hidden;
            margin-bottom: 20px;
        }
        .g-card-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--gold-border);
            background: rgba(201,150,60,.06);
            display: flex; align-items: center; justify-content: space-between;
        }
        .g-card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.02rem; font-weight: 600;
            color: var(--gold-light);
        }
        .g-card-body { padding: 20px 24px; }

        /* Pilih kelas — radio pill */
        .kelas-pills {
            display: flex; gap: 12px;
        }
        .kelas-pill {
            flex: 1;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-size: .9rem; font-weight: 600;
            transition: all .2s;
        }
        .kelas-pill.active {
            background: linear-gradient(135deg, var(--gold), #a8782e);
            color: var(--navy);
            box-shadow: 0 4px 16px rgba(201,150,60,.3);
        }
        .kelas-pill.inactive {
            background: var(--glass);
            border: 1px solid rgba(143,163,192,.2);
            color: var(--muted);
        }
        .kelas-pill.inactive:hover {
            border-color: var(--gold-border);
            color: var(--gold-light);
            background: var(--glass-hover);
        }
        .kelas-pill svg { width: 15px; height: 15px; }

        /* Search */
        .search-row { display: flex; gap: 10px; }
        .form-input {
            flex: 1;
            padding: 10px 14px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(143,163,192,.22);
            border-radius: 9px;
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem;
            outline: none;
            transition: all .2s;
        }
        .form-input::placeholder { color: rgba(143,163,192,.45); }
        .form-input:focus {
            border-color: var(--gold);
            background: rgba(201,150,60,.06);
            box-shadow: 0 0 0 3px rgba(201,150,60,.10);
        }
        .btn-ghost {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 18px;
            background: var(--glass);
            border: 1px solid rgba(143,163,192,.22);
            border-radius: 9px;
            color: var(--muted);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .85rem; font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-ghost:hover { border-color: var(--gold-border); color: var(--gold-light); background: var(--glass-hover); }

        /* Export btn */
        .btn-export {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 7px 16px;
            background: rgba(76,175,138,.14);
            border: 1px solid rgba(76,175,138,.28);
            border-radius: 8px;
            color: #7fe3b8;
            font-size: .82rem; font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }
        .btn-export:hover { background: rgba(76,175,138,.22); border-color: rgba(76,175,138,.45); }
        .btn-export svg { width: 13px; height: 13px; }

        /* Table */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr {
            background: rgba(201,150,60,.08);
            border-bottom: 1px solid var(--gold-border);
        }
        thead th {
            padding: 13px 16px;
            text-align: left;
            font-size: .75rem; font-weight: 700;
            color: var(--gold);
            letter-spacing: .07em;
            text-transform: uppercase;
            white-space: nowrap;
        }
        tbody tr {
            border-bottom: 1px solid rgba(143,163,192,.08);
            transition: background .15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.04); }
        tbody td {
            padding: 13px 16px;
            font-size: .88rem;
            color: var(--text-light);
            vertical-align: middle;
        }

        /* Badges */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: .78rem; font-weight: 700;
        }
        .badge-kelas {
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            color: var(--gold-light);
        }
        .badge-hadir {
            background: rgba(76,175,138,.14);
            border: 1px solid rgba(76,175,138,.28);
            color: #7fe3b8;
        }
        .badge-izin {
            background: rgba(96,165,250,.14);
            border: 1px solid rgba(96,165,250,.28);
            color: #93c5fd;
        }
        .badge-sakit {
            background: rgba(251,191,36,.14);
            border: 1px solid rgba(251,191,36,.28);
            color: #fcd34d;
        }
        .badge-alpa {
            background: rgba(224,92,92,.14);
            border: 1px solid rgba(224,92,92,.28);
            color: #f9a8a8;
        }
        .badge-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
        }

        .kode-mono {
            font-family: monospace;
            font-size: .85rem; font-weight: 600;
            color: var(--muted);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 52px 20px;
            color: var(--muted);
        }
        .empty-icon { font-size: 2.5rem; margin-bottom: 12px; }
        .empty-state p { font-size: .95rem; margin-bottom: 4px; }
        .empty-state small { font-size: .82rem; opacity: .7; }

        /* Pagination Override */
        .pagination-wrap {
            padding: 14px 24px;
            border-top: 1px solid rgba(143,163,192,.1);
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
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.07);
            color: var(--muted);
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all .2s;
            cursor: pointer;
        }
        .pagination-wrap nav a:hover {
            background: rgba(201,150,60,.15);
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

        /* Card footer */
        .card-footer {
            padding: 13px 24px;
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

        @media (max-width: 640px) {
            .kelas-pills { flex-direction: column; }
            .navbar { padding: 0 16px; }
            .page-wrap { padding: 24px 16px 60px; }
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
    <a href="{{ route('admin.dashboard') }}" class="btn-back">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11L5 7l4-4"/></svg>
        Dashboard
    </a>
    <div style="display:flex;align-items:center;gap:7px;margin-left:auto;"><label class="theme-switch" title="Ganti tema"><input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode"><span class="track"></span><span class="thumb"></span></label><span class="theme-label">Dark</span></div>
</nav>

<div class="page-wrap">

    <!-- Page Header -->
    <div class="page-badge">
        <div class="pulse-dot"></div>
        ADMIN PANEL
    </div>
    <h1 class="page-title">Data <span>Presensi</span></h1>
    <p class="page-sub">Lihat dan kelola data presensi siswa sekolah</p>

    <!-- Alert -->
    @if ($message = Session::get('success'))
        <div class="alert-success">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none"><circle cx="7.5" cy="7.5" r="6.5" stroke="#4caf8a" stroke-width="1.5"/><path d="M4.5 7.5l2 2 4-4" stroke="#4caf8a" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ $message }}
        </div>
    @endif

    <!-- Pilih Kelas -->
    <div class="g-card">
        <div class="g-card-header">
            <h2>Pilih Kelas</h2>
        </div>
        <div class="g-card-body">
            <div class="kelas-pills">
                <a href="{{ route('admin.presensi.index', ['kelas' => 'XI SIJA 1']) }}"
                   class="kelas-pill {{ $kelas === 'XI SIJA 1' ? 'active' : 'inactive' }}">
                    <svg viewBox="0 0 15 15" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7.5" cy="5" r="2.5"/><path d="M2.5 13c0-2.76 2.24-5 5-5s5 2.24 5 5" stroke-linecap="round"/></svg>
                    XI SIJA 1
                </a>
                <a href="{{ route('admin.presensi.index', ['kelas' => 'XI SIJA 2']) }}"
                   class="kelas-pill {{ $kelas === 'XI SIJA 2' ? 'active' : 'inactive' }}">
                    <svg viewBox="0 0 15 15" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="7.5" cy="5" r="2.5"/><path d="M2.5 13c0-2.76 2.24-5 5-5s5 2.24 5 5" stroke-linecap="round"/></svg>
                    XI SIJA 2
                </a>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="g-card">
        <div class="g-card-header">
            <h2>Cari Presensi</h2>
        </div>
        <div class="g-card-body">
            <form method="GET" action="{{ route('admin.presensi.index') }}" class="search-row">
                <input type="text" name="search" class="form-input"
                    placeholder="Cari berdasarkan nama siswa atau status..."
                    value="{{ request('search') }}">
                @if($kelas)
                    <input type="hidden" name="kelas" value="{{ $kelas }}">
                @endif
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
            <h2>Daftar Presensi @if($kelas) — {{ $kelas }} @endif</h2>
            <a href="{{ route('admin.presensi.export') }}" class="btn-export">
                <svg viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6.5 1v7M4 6l2.5 2.5L9 6" stroke-linecap="round" stroke-linejoin="round"/><path d="M1 10v1a1 1 0 001 1h9a1 1 0 001-1v-1" stroke-linecap="round"/></svg>
                Export Excel
            </a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:14%">Kode Presensi</th>
                        <th style="width:22%">Nama Siswa</th>
                        <th style="width:12%">Kelas</th>
                        <th style="width:14%">Tanggal</th>
                        <th style="width:12%">Jam Masuk</th>
                        <th style="width:21%; text-align:center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presensi as $index => $item)
                        <tr>
                            <td>{{ $presensi->firstItem() + $index }}</td>
                            <td><span class="kode-mono">{{ $item->kode_presensi }}</span></td>
                            <td style="font-weight:500; color:var(--white);">{{ $item->siswa->nama_siswa ?? '-' }}</td>
                            <td><span class="badge badge-kelas">{{ $item->jadwal->kelas ?? '-' }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->jam_masuk ?? '-' }}</td>
                            <td style="text-align:center;">
                                @if($item->status === 'Hadir')
                                    <span class="badge badge-hadir">
                                        <span class="badge-dot" style="background:#4caf8a;"></span>
                                        Hadir
                                    </span>
                                @elseif($item->status === 'Izin')
                                    <span class="badge badge-izin">
                                        <span class="badge-dot" style="background:#60a5fa;"></span>
                                        Izin
                                    </span>
                                @elseif($item->status === 'Sakit')
                                    <span class="badge badge-sakit">
                                        <span class="badge-dot" style="background:#fbbf24;"></span>
                                        Sakit
                                    </span>
                                @else
                                    <span class="badge badge-alpa">
                                        <span class="badge-dot" style="background:#e05c5c;"></span>
                                        Alpa
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <p>Belum ada data presensi</p>
                                    <small>Data presensi akan ditampilkan di sini</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrap">
            {{ $presensi->appends(request()->query())->links() }}
        </div>

        <div class="card-footer">
            <span>Total Presensi</span>
            <span class="badge-count">{{ $presensi->total() }} record</span>
        </div>
    </div>

</div>
<script src="{{ asset('js/theme-mode.js') }}"></script>
</body>
</html>