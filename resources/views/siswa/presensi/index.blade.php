<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Presensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme-mode.css') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:        #0B1F3A;
            --gold:        #C9963C;
            --gold-light:  #e0b060;
            --gold-dim:    rgba(201,150,60,.16);
            --gold-border: rgba(201,150,60,.26);
            --muted:       #8FA3C0;
            --glass:       rgba(255,255,255,.06);
            --glass-b:     rgba(255,255,255,.10);
            --white:       #ffffff;
            --text-dim:    rgba(255,255,255,.75);
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
                radial-gradient(ellipse 70% 50% at 15% 10%, rgba(201,150,60,.07) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 85% 85%, rgba(17,40,71,.8) 0%, transparent 60%);
        }
        body::after {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(201,150,60,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,150,60,.035) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Status bar */
        .status-bar {
            height: 3px;
            background: linear-gradient(90deg, var(--gold), #a8782e, var(--gold));
            background-size: 200% 100%;
            animation: shimmer 3s infinite linear;
            position: relative; z-index: 10;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Navbar */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 16px; height: 56px;
            background: rgba(11,31,58,.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gold-border);
        }
        .nav-brand { display: flex; align-items: center; gap: 9px; text-decoration: none; min-width: 0; }
        .nav-logo {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: .95rem; color: var(--navy);
            flex-shrink: 0;
        }
        .nav-title {
            font-family: 'Playfair Display', serif;
            font-size: .95rem; color: var(--white);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .btn-back {
            display: flex; align-items: center; gap: 5px;
            padding: 6px 12px;
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 7px;
            color: var(--gold-light);
            text-decoration: none;
            font-size: .8rem; font-weight: 600;
            transition: all .2s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-back:hover { background: var(--glass-b); border-color: var(--gold); color: var(--gold); }
        .btn-back .label-text { display: inline; }

        /* Page wrap */
        .page-wrap {
            position: relative; z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 24px 16px 64px;
        }

        /* Page title */
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.3rem, 5vw, 1.7rem);
            font-weight: 700;
            color: var(--white); margin-bottom: 4px;
        }
        .page-title span { color: var(--gold); }
        .page-sub { color: var(--muted); font-size: .86rem; margin-bottom: 22px; }

        /* Card */
        .card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 14px;
            backdrop-filter: blur(14px);
            overflow: hidden;
            margin-bottom: 16px;
        }
        .card-header {
            padding: 13px 18px;
            border-bottom: 1px solid var(--gold-border);
            background: rgba(201,150,60,.06);
        }
        .card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: .95rem; font-weight: 600;
            color: var(--gold-light);
        }
        .card-body { padding: 16px 18px; }

        /* Filter form */
        .filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 12px;
            align-items: end;
        }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-label {
            font-size: .72rem; font-weight: 700;
            color: var(--muted);
            letter-spacing: .06em; text-transform: uppercase;
        }
        .form-input, .form-select {
            padding: 10px 12px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(143,163,192,.2);
            border-radius: 8px;
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .86rem;
            outline: none;
            transition: all .2s;
            width: 100%;
        }
        .form-input:focus, .form-select:focus {
            border-color: var(--gold);
            background: rgba(201,150,60,.06);
            box-shadow: 0 0 0 3px rgba(201,150,60,.09);
        }
        .form-input::placeholder { color: rgba(143,163,192,.4); }
        input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(.5); cursor: pointer; }
        .form-select { appearance: none; cursor: pointer; }
        .form-select option { background: #112847; color: var(--white); }

        .btn-search {
            padding: 10px 18px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border: none; border-radius: 8px;
            color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .84rem; font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
            height: 42px;
        }
        .btn-search:hover { filter: brightness(1.08); transform: translateY(-1px); }

        /* ─── DESKTOP TABLE ─────────────────────── */
        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; min-width: 520px; }
        thead tr {
            background: rgba(201,150,60,.08);
            border-bottom: 1px solid var(--gold-border);
        }
        thead th {
            padding: 11px 14px;
            text-align: left;
            font-size: .72rem; font-weight: 700;
            color: var(--gold);
            letter-spacing: .07em; text-transform: uppercase;
            white-space: nowrap;
        }
        tbody tr {
            border-bottom: 1px solid rgba(143,163,192,.08);
            transition: background .15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.03); }
        tbody td {
            padding: 12px 14px;
            font-size: .85rem;
            color: var(--text-dim);
            vertical-align: middle;
        }

        /* ─── MOBILE CARDS (hidden on desktop) ─── */
        .mobile-list { display: none; }
        .mobile-item {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(143,163,192,.09);
        }
        .mobile-item:last-child { border-bottom: none; }
        .mobile-row-top {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 6px; gap: 8px;
        }
        .mobile-mapel { font-size: .9rem; font-weight: 600; color: var(--white); }
        .mobile-row-mid {
            display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
            margin-bottom: 4px;
        }
        .mobile-meta { font-size: .78rem; color: var(--muted); }
        .mobile-token {
            font-family: monospace;
            font-size: .8rem; font-weight: 600;
            color: var(--muted);
        }

        /* Badges status */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 9px;
            border-radius: 6px;
            font-size: .74rem; font-weight: 700;
            white-space: nowrap;
        }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .badge-hadir { background: rgba(76,175,138,.14); border: 1px solid rgba(76,175,138,.28); color: #7fe3b8; }
        .badge-izin  { background: rgba(96,165,250,.14); border: 1px solid rgba(96,165,250,.28); color: #93c5fd; }
        .badge-sakit { background: rgba(251,191,36,.14);  border: 1px solid rgba(251,191,36,.28);  color: #fcd34d; }
        .badge-alpa  { background: rgba(224,92,92,.14);   border: 1px solid rgba(224,92,92,.28);   color: #f9a8a8; }

        /* Token monospace */
        .token-code {
            font-family: monospace;
            font-size: .85rem; font-weight: 600;
            color: var(--muted);
            letter-spacing: .05em;
        }

        /* Empty */
        .empty-state {
            text-align: center; padding: 44px 20px; color: var(--muted);
        }
        .empty-icon { font-size: 2rem; margin-bottom: 10px; }
        .empty-state p { font-size: .88rem; }

        /* Pagination Override */
        .pagination-wrap {
            padding: 14px 16px;
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

        /* ── RESPONSIVE ─────────────────────────────────── */

        @media (max-width: 600px) {
            .filter-grid { grid-template-columns: 1fr 1fr; }
            .filter-grid .btn-search { grid-column: 1 / -1; width: 100%; height: auto; }
        }

        @media (max-width: 440px) {
            .filter-grid { grid-template-columns: 1fr; }
        }

        /* Switch to card view on mobile */
        @media (max-width: 580px) {
            .table-wrap { display: none; }
            .mobile-list { display: block; }
        }

        /* Very small screens */
        @media (max-width: 380px) {
            .page-wrap { padding: 18px 12px 56px; }
            .navbar { padding: 0 12px; }
            .nav-title { display: none; }
            .btn-back .label-text { display: none; }
            .btn-back { padding: 6px 10px; }
        }
    </style>
</head>
<body>

<div class="status-bar"></div>

<!-- Navbar -->
<nav class="navbar">
    <a href="{{ route('siswa.dashboard') }}" class="nav-brand">
        <div class="nav-logo">S</div>
        <span class="nav-title">SchoolSystem</span>
    </a>
    <a href="{{ route('siswa.dashboard') }}" class="btn-back">
        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 10L4 6.5 8 3"/></svg>
        <span class="label-text">Dashboard</span>
    </a>
    <div style="display:flex;align-items:center;gap:7px;margin-left:auto;"><label class="theme-switch" title="Ganti tema"><input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode"><span class="track"></span><span class="thumb"></span></label><span class="theme-label">Dark</span></div>
</nav>

<div class="page-wrap">

    <!-- Title -->
    <h1 class="page-title">Riwayat <span>Presensi</span></h1>
    <p class="page-sub">Daftar lengkap kehadiran Anda</p>

    <!-- Filter -->
    <div class="card">
        <div class="card-header">
            <h2>Filter Presensi</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('siswa.presensi.search') }}" method="GET">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-input" value="{{ request('tanggal') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="Izin"  {{ request('status') == 'Izin'  ? 'selected' : '' }}>Izin</option>
                            <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-search">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data -->
    <div class="card">

        {{-- ─── DESKTOP: Tabel biasa ─── --}}
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Mata Pelajaran</th>
                        <th>Jam Ke</th>
                        <th>Jam Masuk</th>
                        <th style="text-align:center">Status</th>
                        <th>Token</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presensi as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                            <td style="font-weight:500; color:var(--white);">{{ $item->jadwal->mapel->nama_mapel ?? '-' }}</td>
                            <td>Jam ke-{{ $item->jadwal->jam_ke ?? '-' }}</td>
                            <td>{{ $item->jam_masuk }}</td>
                            <td style="text-align:center;">
                                @if($item->status == 'Hadir')
                                    <span class="badge badge-hadir"><span class="badge-dot" style="background:#4caf8a;"></span>Hadir</span>
                                @elseif($item->status == 'Izin')
                                    <span class="badge badge-izin"><span class="badge-dot" style="background:#60a5fa;"></span>Izin</span>
                                @elseif($item->status == 'Sakit')
                                    <span class="badge badge-sakit"><span class="badge-dot" style="background:#fbbf24;"></span>Sakit</span>
                                @else
                                    <span class="badge badge-alpa"><span class="badge-dot" style="background:#e05c5c;"></span>{{ $item->status }}</span>
                                @endif
                            </td>
                            <td><span class="token-code">{{ $item->token ?? '-' }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <p>Tidak ada data presensi ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ─── MOBILE: Card list ─── --}}
        <div class="mobile-list">
            @forelse($presensi as $item)
                <div class="mobile-item">
                    <div class="mobile-row-top">
                        <span class="mobile-mapel">{{ $item->jadwal->mapel->nama_mapel ?? '-' }}</span>
                        @if($item->status == 'Hadir')
                            <span class="badge badge-hadir"><span class="badge-dot" style="background:#4caf8a;"></span>Hadir</span>
                        @elseif($item->status == 'Izin')
                            <span class="badge badge-izin"><span class="badge-dot" style="background:#60a5fa;"></span>Izin</span>
                        @elseif($item->status == 'Sakit')
                            <span class="badge badge-sakit"><span class="badge-dot" style="background:#fbbf24;"></span>Sakit</span>
                        @else
                            <span class="badge badge-alpa"><span class="badge-dot" style="background:#e05c5c;"></span>{{ $item->status }}</span>
                        @endif
                    </div>
                    <div class="mobile-row-mid">
                        <span class="mobile-meta">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</span>
                        <span class="mobile-meta">·</span>
                        <span class="mobile-meta">Jam ke-{{ $item->jadwal->jam_ke ?? '-' }}</span>
                        <span class="mobile-meta">·</span>
                        <span class="mobile-meta">Masuk {{ $item->jam_masuk }}</span>
                    </div>
                    @if($item->token)
                        <span class="mobile-token">Token: {{ $item->token }}</span>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <p>Tidak ada data presensi ditemukan.</p>
                </div>
            @endforelse
        </div>

        @if($presensi->hasPages())
            <div class="pagination-wrap">
                {{ $presensi->links() }}
            </div>
        @endif
    </div>

</div>
<script src="{{ asset('js/theme-mode.js') }}"></script>
</body>
</html>