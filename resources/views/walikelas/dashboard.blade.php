<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas – {{ $kelas }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/theme-mode.css') }}">
    <style>
        :root {
            --navy:        #0B1F3A;
            --navy-mid:    #112240;
            --navy-light:  #1A3358;
            --navy-muted:  #1E3A5F;
            --gold:        #C9963C;
            --gold-light:  #E8B45A;
            --gold-pale:   rgba(201,150,60,.12);
            --gold-border: rgba(201,150,60,.28);
            --muted:       #8FA3C0;
            --text-dim:    #5A7A9E;
            --white:       #FFFFFF;
            --glass:       rgba(255,255,255,.04);
            --glass-hover: rgba(255,255,255,.07);
            --success:     #2DD4BF;
            --warn:        #F59E0B;
            --danger:      #F87171;
            --info:        #60A5FA;
            --sick:        #FB923C;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--navy);
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── BACKGROUND ── */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 20%, rgba(201,150,60,.07) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 90% 80%, rgba(11,31,58,.9) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(201,150,60,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,150,60,.04) 1px, transparent 1px);
            background-size: 44px 44px;
            pointer-events: none;
        }

        /* ── LAYOUT ── */
        .page-wrap { position: relative; z-index: 1; min-height: 100vh; display: flex; flex-direction: column; }

        /* ── NAVBAR ── */
        .navbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px;
            height: 68px;
            background: rgba(11,31,58,.85);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--gold-border);
            position: sticky; top: 0; z-index: 100;
        }
        .nav-brand { display: flex; align-items: center; gap: 14px; text-decoration: none; }
        .nav-logo {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; font-weight: 800; color: var(--navy);
        }
        .nav-title { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: var(--white); }
        .nav-title span { color: var(--gold); }

        .nav-right { display: flex; align-items: center; gap: 14px; }
        .nav-badge {
            padding: 5px 14px; border-radius: 20px;
            background: var(--gold-pale); border: 1px solid var(--gold-border);
            font-size: .8rem; font-weight: 600; color: var(--gold-light);
            display: flex; align-items: center; gap: 6px;
        }
        .pulse-dot {
            width: 7px; height: 7px; border-radius: 50%; background: var(--success);
            animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

        .nav-btn {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 16px; border-radius: 10px;
            background: var(--glass); border: 1px solid var(--gold-border);
            color: var(--muted); font-size: .85rem; font-weight: 600;
            text-decoration: none; transition: all .2s;
        }
        .nav-btn:hover { background: var(--gold-pale); color: var(--gold-light); border-color: var(--gold); text-decoration: none; }
        .nav-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .85rem; color: var(--navy);
            border: 2px solid var(--gold-border);
        }

        /* ── MAIN ── */
        .main { padding: 40px; flex: 1; max-width: 1400px; margin: 0 auto; width: 100%; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            margin-bottom: 36px; gap: 20px; flex-wrap: wrap;
        }
        .page-title-group {}
        .page-eyebrow {
            font-size: .75rem; font-weight: 700; letter-spacing: .12em;
            text-transform: uppercase; color: var(--gold);
            display: flex; align-items: center; gap: 8px; margin-bottom: 8px;
        }
        .page-eyebrow::before { content: ''; width: 24px; height: 2px; background: var(--gold); border-radius: 2px; }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem; font-weight: 800; line-height: 1.15;
            color: var(--white);
        }
        .page-title span { color: var(--gold); }
        .page-period {
            margin-top: 8px; font-size: .9rem; color: var(--muted);
            display: flex; align-items: center; gap: 8px;
        }
        .page-period svg { color: var(--gold); }

        /* ── FILTER CARD (Kakon Style) ── */
        .filter-card {
            background: var(--glass); border: 1px solid var(--gold-border);
            border-radius: 14px; padding: 1.2rem 1.5rem; margin-bottom: 1.5rem;
            backdrop-filter: blur(12px);
        }
        .filter-grid {
            display: grid; grid-template-columns: 1fr 1fr auto;
            gap: 12px; align-items: flex-end;
        }
        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-label {
            font-size: 11px; font-weight: 700; color: var(--muted);
            text-transform: uppercase; letter-spacing: .5px;
        }
        .input-wrap { position: relative; display: flex; align-items: center; }
        .input-ico { position: absolute; left: 12px; pointer-events: none; color: var(--muted); display: flex; }
        .input-ico svg { width: 15px; height: 15px; }
        .f-select, .f-input {
            width: 100%; background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.07);
            border-radius: 9px; padding: 10px 14px 10px 36px;
            font-size: 13px; font-weight: 600; color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            outline: none; transition: all .2s; appearance: none;
        }
        .f-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238FA3C0' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center; background-size: 12px; padding-right: 30px;
        }
        .f-select option { background: var(--navy-mid); }
        .f-select:focus, .f-input:focus { border-color: var(--gold); background: rgba(255,255,255,.08); }
        .f-input::placeholder { color: rgba(143,163,192,.5); }
        .btn-filter {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 18px; background: var(--gold); border: none; border-radius: 9px;
            font-size: 13px; font-weight: 700; color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
            white-space: nowrap; transition: all .2s; height: 40px;
        }
        .btn-filter:hover { background: var(--gold-light); }
        .btn-filter svg { width: 14px; height: 14px; }

        /* ── STAT CARDS ── */
        .stats-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; margin-bottom: 28px; }

        .stat-card {
            background: var(--glass); border: 1px solid var(--gold-border);
            border-radius: 16px; padding: 20px 22px;
            backdrop-filter: blur(10px);
            transition: all .25s; cursor: default;
            position: relative; overflow: hidden;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 3px; border-radius: 16px 16px 0 0;
        }
        .stat-card.c-hadir::before  { background: var(--success); }
        .stat-card.c-izin::before   { background: var(--warn); }
        .stat-card.c-sakit::before  { background: var(--sick); }
        .stat-card.c-alpha::before  { background: var(--danger); }
        .stat-card.c-total::before  { background: var(--gold); }

        .stat-card:hover { background: var(--glass-hover); transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,.25); }

        .stat-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; margin-bottom: 14px;
        }
        .stat-card.c-hadir .stat-icon  { background: rgba(45,212,191,.15); }
        .stat-card.c-izin .stat-icon   { background: rgba(245,158,11,.15); }
        .stat-card.c-sakit .stat-icon  { background: rgba(251,146,60,.15); }
        .stat-card.c-alpha .stat-icon  { background: rgba(248,113,113,.15); }
        .stat-card.c-total .stat-icon  { background: var(--gold-pale); }

        .stat-value { font-size: 2rem; font-weight: 800; color: var(--white); line-height: 1; margin-bottom: 4px; }
        .stat-label { font-size: .78rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: .07em; }
        .stat-pct { font-size: .78rem; color: var(--text-dim); margin-top: 4px; font-family: 'JetBrains Mono', monospace; }

        /* ── PANEL (Chart Containers) ── */
        .chart-grid {
            display: grid; grid-template-columns: 2fr 1fr;
            gap: 16px; margin-bottom: 28px;
        }
        @media (max-width: 900px) { .chart-grid { grid-template-columns: 1fr; } }
        .panel {
            background: var(--glass); border: 1px solid var(--gold-border);
            border-radius: 16px; overflow: hidden;
            backdrop-filter: blur(12px);
        }
        .panel-hd {
            padding: 1rem 1.4rem; border-bottom: 1px solid var(--gold-border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .panel-title {
            display: flex; align-items: center; gap: 9px;
            font-size: 13px; font-weight: 700; color: var(--white); margin: 0;
        }
        .panel-title svg { width: 16px; height: 16px; color: var(--gold); }
        .panel-badge {
            font-size: 11px; font-weight: 700; color: var(--muted);
            background: rgba(255,255,255,.06); border: 1px solid var(--gold-border);
            padding: 3px 11px; border-radius: 99px;
        }
        .panel-body { padding: 1.2rem 1.4rem; }
        .chart-wrap { position: relative; }
        
        .donut-legend { display: flex; flex-direction: column; gap: 8px; margin-top: 1rem; }
        .d-legend-item { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .d-legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .d-legend-label { font-size: 12px; color: var(--muted); flex: 1; }
        .d-legend-val { font-size: 12px; font-weight: 700; color: var(--white); }
        .d-legend-pct { font-size: 11px; color: var(--muted); min-width: 38px; text-align: right; }

        /* ── TABLE SECTION ── */
        .table-section {
            background: var(--glass); border: 1px solid var(--gold-border);
            border-radius: 20px; overflow: hidden;
            backdrop-filter: blur(12px);
        }
        .table-section-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 22px 28px; border-bottom: 1px solid var(--gold-border);
        }
        .table-section-title { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; }
        .table-count {
            padding: 4px 12px; border-radius: 20px;
            background: var(--gold-pale); border: 1px solid var(--gold-border);
            font-size: .78rem; font-weight: 600; color: var(--gold);
            font-family: 'JetBrains Mono', monospace;
        }

        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 700px; }

        thead tr { border-bottom: 1px solid var(--gold-border); }
        thead th {
            padding: 14px 16px; text-align: center;
            font-size: .72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .1em;
            color: var(--muted); background: rgba(201,150,60,.05);
        }
        thead th.col-siswa { text-align: left; padding-left: 24px; }

        tbody tr {
            border-bottom: 1px solid rgba(201,150,60,.08);
            transition: background .18s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--glass-hover); }

        td { padding: 14px 16px; vertical-align: middle; }
        td.col-siswa { padding-left: 24px; }

        /* student cell */
        .student-cell { display: flex; align-items: center; gap: 14px; }
        .s-avatar {
            width: 42px; height: 42px; border-radius: 12px; flex-shrink: 0;
            background: linear-gradient(135deg, rgba(201,150,60,.3) 0%, rgba(201,150,60,.1) 100%);
            border: 1px solid var(--gold-border);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: var(--gold-light);
        }
        .s-name { font-weight: 600; color: var(--white); font-size: .92rem; line-height: 1.3; }
        .s-nis { font-size: .75rem; color: var(--text-dim); font-family: 'JetBrains Mono', monospace; margin-top: 2px; }

        /* status badge */
        .s-badge {
            display: inline-flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 9px;
            font-weight: 700; font-size: .78rem;
            margin: 0 auto; display: flex;
            transition: transform .15s;
        }
        .s-badge:hover { transform: scale(1.15); }

        .s-H { background: rgba(45,212,191,.2); color: var(--success); border: 1px solid rgba(45,212,191,.35); }
        .s-I { background: rgba(245,158,11,.2); color: var(--warn);    border: 1px solid rgba(245,158,11,.35); }
        .s-S { background: rgba(251,146,60,.2); color: var(--sick);    border: 1px solid rgba(251,146,60,.35); }
        .s-A { background: rgba(248,113,113,.2); color: var(--danger); border: 1px solid rgba(248,113,113,.35); }
        .s-none { background: rgba(90,122,158,.1); color: var(--text-dim); border: 1px solid rgba(90,122,158,.2); }

        /* summary column */
        .summary-cell { display: flex; align-items: center; gap: 6px; justify-content: center; }
        .mini-bar { display: flex; gap: 2px; align-items: flex-end; height: 20px; }
        .mini-bar-seg { width: 5px; border-radius: 2px; }

        /* total attendance pill */
        .attend-pct {
            font-family: 'JetBrains Mono', monospace; font-size: .8rem; font-weight: 600;
            padding: 3px 10px; border-radius: 20px;
        }
        .attend-high { background: rgba(45,212,191,.15); color: var(--success); border: 1px solid rgba(45,212,191,.3); }
        .attend-mid  { background: rgba(245,158,11,.15); color: var(--warn);    border: 1px solid rgba(245,158,11,.3); }
        .attend-low  { background: rgba(248,113,113,.15); color: var(--danger); border: 1px solid rgba(248,113,113,.3); }

        /* day header */
        .day-th { display: flex; flex-direction: column; align-items: center; gap: 2px; }
        .day-name { font-weight: 700; color: var(--white); font-size: .8rem; }
        .day-date-label { font-size: .68rem; color: var(--text-dim); font-family: 'JetBrains Mono', monospace; }

        /* today highlight */
        th.today-col { background: rgba(201,150,60,.1) !important; }
        th.today-col .day-name { color: var(--gold); }
        td.today-col { background: rgba(201,150,60,.04); }

        /* ── LEGEND ── */
        .legend-bar {
            display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
            padding: 18px 28px; border-top: 1px solid var(--gold-border);
            background: rgba(201,150,60,.03);
        }
        .legend-item { display: flex; align-items: center; gap: 8px; font-size: .8rem; color: var(--muted); font-weight: 500; }

        /* ── EMPTY ── */
        .empty-state {
            padding: 70px 40px; text-align: center;
        }
        .empty-icon { font-size: 3.5rem; margin-bottom: 16px; opacity: .5; }
        .empty-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 700; color: var(--white); margin-bottom: 6px; }
        .empty-sub { color: var(--muted); font-size: .9rem; }

        /* ── FOOTER ── */
        .footer {
            text-align: center; padding: 28px 40px;
            border-top: 1px solid var(--gold-border);
            color: var(--text-dim); font-size: .8rem;
        }
        .footer span { color: var(--gold); font-weight: 600; }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
        .stat-card { animation: fadeUp .45s both; }
        .stat-card:nth-child(1){animation-delay:.05s}
        .stat-card:nth-child(2){animation-delay:.1s}
        .stat-card:nth-child(3){animation-delay:.15s}
        .stat-card:nth-child(4){animation-delay:.2s}
        .stat-card:nth-child(5){animation-delay:.25s}
        .table-section { animation: fadeUp .5s .28s both; }

        /* ── RESPONSIVE ── */
        @media(max-width:900px){
            .main{ padding: 24px 16px; }
            .stats-grid{ grid-template-columns: repeat(2,1fr); }
            .search-input{ width: 180px; }
            .navbar{ padding: 0 16px; }
            .page-title{ font-size: 1.6rem; }
        }

        /* ── EXPORT BUTTON ── */
        .btn-export {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 16px; border-radius: 10px;
            background: rgba(201,150,60,.15); border: 1px solid var(--gold-border);
            color: var(--gold-light); font-size: .82rem; font-weight: 600;
            cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all .2s; text-decoration: none;
        }
        .btn-export:hover { background: var(--gold-pale); color: var(--gold); }
        .btn-export svg { width: 14px; height: 14px; }

        /* ── PRINT STYLES ── */
        @media print {
            * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            body { background: #fff !important; color: #000 !important; }
            body::before, body::after { display: none !important; }
            .navbar, .filter-card, .footer, .btn-export, .nav-btn { display: none !important; }
            .page-wrap { background: #fff; }
            .main { padding: 20px !important; max-width: 100%; }
            .page-header, .stats-grid, .chart-grid { display: none !important; }
            .table-section { border: 1px solid #ddd !important; background: #fff !important; break-inside: avoid; }
            .table-section-header { background: #f0f0f0 !important; border-bottom: 1px solid #ddd !important; }
            .table-section-title { color: #000 !important; }
            thead th { color: #555 !important; background: #f5f5f5 !important; }
            td { color: #000 !important; }
            tbody tr { border-bottom: 1px solid #eee !important; }
            .s-name { color: #000 !important; }
            .s-nis  { color: #555 !important; }
            .s-H { background: #d1fae5 !important; color: #065f46 !important; border: 1px solid #a7f3d0 !important; }
            .s-I { background: #fef3c7 !important; color: #92400e !important; border: 1px solid #fde68a !important; }
            .s-S { background: #ffedd5 !important; color: #9a3412 !important; border: 1px solid #fed7aa !important; }
            .s-A { background: #fee2e2 !important; color: #991b1b !important; border: 1px solid #fca5a5 !important; }
            .s-none { background: #f3f4f6 !important; color: #6b7280 !important; border: 1px solid #e5e7eb !important; }
            .attend-high { background: #d1fae5 !important; color: #065f46 !important; }
            .attend-mid  { background: #fef3c7 !important; color: #92400e !important; }
            .attend-low  { background: #fee2e2 !important; color: #991b1b !important; }
            .legend-bar { background: #f9f9f9 !important; border-top: 1px solid #ddd !important; }
            .legend-item { color: #555 !important; }
            .d-legend-label { color: #555 !important; }
            .d-legend-val { color: #000 !important; }
            .print-header { display: block !important; text-align: center; margin-bottom: 20px; }
            .print-header h2 { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 800; color: #0B1F3A; margin-bottom: 5px; }
            .print-header p { font-size: 1.1rem; color: #555; }
            @page { size: A4 landscape; margin: 15mm; }
        }
        .print-header { display: none; }
    </style>
</head>
<body>
<div class="page-wrap">

    {{-- ═══ NAVBAR ═══ --}}
    <nav class="navbar">
        <a href="#" class="nav-brand">
            <div class="nav-logo">S</div>
            <span class="nav-title">Sekolah<span>App</span></span>
        </a>
        <div class="nav-right">
            <div style="display:flex;align-items:center;gap:7px;"><label class="theme-switch" title="Ganti tema"><input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode"><span class="track"></span><span class="thumb"></span></label><span class="theme-label">Dark</span></div>
            <div class="nav-badge">
                <div class="pulse-dot"></div>
                Wali Kelas · {{ $kelas }}
            </div>

            <a href="{{ route('guru.dashboard') }}" class="nav-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                Dashboard Guru
            </a>
            <div class="nav-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'W', 0, 1)) }}</div>
        </div>
    </nav>

    {{-- ═══ MAIN ═══ --}}
    <main class="main">

        <div class="print-header">
            <h2>Laporan Rekap Presensi Siswa</h2>
            <p>Kelas: {{ $kelas }} | Periode: {{ ucfirst(str_replace('_', ' ', $filter)) }}</p>
        </div>

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="page-title-group">
                <div class="page-eyebrow">Presensi Mingguan</div>
                <h1 class="page-title">Dashboard <span>Wali Kelas</span></h1>
                <div class="page-period">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    @if($startDate->isSameDay($endDate))
                        {{ $startDate->translatedFormat('d M Y') }}
                    @else
                        {{ $startDate->translatedFormat('d M') }}
                        –
                        {{ $endDate->translatedFormat('d M Y') }}
                    @endif
                </div>
            </div>

        </div>

        {{-- ═══ FILTER ═══ --}}
        <form id="filterForm" method="GET" action="{{ route('walikelas.dashboard') }}">
            <div class="filter-card">
                <div class="filter-grid">

                    {{-- Periode --}}
                    <div class="filter-group">
                        <span class="filter-label">Periode Waktu</span>
                        <div class="input-wrap">
                            <span class="input-ico">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </span>
                            <select class="f-select" name="filter" onchange="document.getElementById('filterForm').submit()">
                                <option value="hari_ini"   @selected($filter==='hari_ini')>Hari Ini</option>
                                <option value="minggu_ini" @selected($filter==='minggu_ini')>Minggu Ini</option>
                                <option value="minggu_lalu" @selected($filter==='minggu_lalu')>Minggu Lalu</option>
                                <option value="bulan_ini"  @selected($filter==='bulan_ini')>Bulan Ini</option>
                                <option value="bulan_lalu"  @selected($filter==='bulan_lalu')>Bulan Lalu</option>
                                <option value="tahun_ini"  @selected($filter==='tahun_ini')>Tahun Ini</option>
                            </select>
                        </div>
                    </div>

                    {{-- Search --}}
                    <div class="filter-group">
                        <span class="filter-label">Cari Nama Siswa</span>
                        <div class="input-wrap">
                            <span class="input-ico">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            </span>
                            <input type="text" class="f-input" name="search"
                                   value="{{ $search ?? '' }}" placeholder="Masukkan nama..."
                                   onkeydown="if(event.key==='Enter') document.getElementById('filterForm').submit()">
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div>
                        <button type="submit" class="btn-filter">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Cari
                        </button>
                    </div>

                </div>
            </div>
        </form>

        {{-- ═══ STAT CARDS ═══ --}}
        @php
            $totalSiswa = $siswas->count();
            // Hitung rekap presensi periode ini
            $allPresensi = $siswas->flatMap(fn($s) => $s->presensi->filter(fn($p) => $p->tanggal >= $startStr && $p->tanggal <= $endStr));
            $totalH = $allPresensi->where('status','hadir')->count();
            $totalI = $allPresensi->where('status','izin')->count();
            $totalS = $allPresensi->where('status','sakit')->count();
            $totalA = $allPresensi->where('status','alpha')->count();
            $totalRec = $allPresensi->count();
            $pctH = $totalRec > 0 ? round($totalH/$totalRec*100) : 0;
        @endphp

        <div class="stats-grid">
            <div class="stat-card c-total">
                <div class="stat-icon">🎓</div>
                <div class="stat-value">{{ $totalSiswa }}</div>
                <div class="stat-label">Total Siswa</div>
                <div class="stat-pct">Kelas {{ $kelas }}</div>
            </div>
            <div class="stat-card c-hadir">
                <div class="stat-icon" style="color:var(--success);">✓</div>
                <div class="stat-value" style="color:var(--success);">{{ $totalH }}</div>
                <div class="stat-label">Hadir</div>
                <div class="stat-pct">{{ $pctH }}% kehadiran</div>
            </div>
            <div class="stat-card c-izin">
                <div class="stat-icon" style="color:var(--warn);">📋</div>
                <div class="stat-value" style="color:var(--warn);">{{ $totalI }}</div>
                <div class="stat-label">Izin</div>
                <div class="stat-pct">Periode ini</div>
            </div>
            <div class="stat-card c-sakit">
                <div class="stat-icon" style="color:var(--sick);">🩺</div>
                <div class="stat-value" style="color:var(--sick);">{{ $totalS }}</div>
                <div class="stat-label">Sakit</div>
                <div class="stat-pct">Periode ini</div>
            </div>
            <div class="stat-card c-alpha">
                <div class="stat-icon" style="color:var(--danger);">⚠</div>
                <div class="stat-value" style="color:var(--danger);">{{ $totalA }}</div>
                <div class="stat-label">Alpha</div>
                <div class="stat-pct">Perlu perhatian</div>
            </div>
        </div>

        {{-- ═══ CHARTS ═══ --}}
        <div class="chart-grid">
            {{-- GRAFIK TREN --}}
            <div class="panel">
                <div class="panel-hd">
                    <h5 class="panel-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Tren Aktivitas Presensi
                    </h5>
                    <span class="panel-badge">{{ ucfirst(str_replace('_', ' ', $filter)) }}</span>
                </div>
                <div class="panel-body">
                    <div class="chart-wrap" style="height:240px">
                        <canvas id="chartTren"></canvas>
                    </div>
                </div>
            </div>

            {{-- DONUT CHART --}}
            <div class="panel">
                <div class="panel-hd">
                    <h5 class="panel-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
                        Komposisi Kehadiran
                    </h5>
                </div>
                <div class="panel-body">
                    <div class="chart-wrap" style="height:150px">
                        <canvas id="chartDonut"></canvas>
                    </div>

                    {{-- Custom legend --}}
                    @php
                        $legendItems = [
                            ['label'=>'Hadir', 'key'=>'Hadir', 'color'=>'#2DD4BF'],
                            ['label'=>'Izin',  'key'=>'Izin',  'color'=>'#F59E0B'],
                            ['label'=>'Sakit', 'key'=>'Sakit', 'color'=>'#FB923C'],
                            ['label'=>'Alpa',  'key'=>'Alpa',  'color'=>'#F87171'],
                        ];
                    @endphp
                    <div class="donut-legend">
                        @foreach($legendItems as $li)
                            @php $pctLi = $rekapTotal > 0 ? round($rekap[$li['key']] / $rekapTotal * 100, 1) : 0; @endphp
                            <div class="d-legend-item">
                                <div class="d-legend-dot" style="background:{{ $li['color'] }}"></div>
                                <span class="d-legend-label">{{ $li['label'] }}</span>
                                <span class="d-legend-val">{{ $rekap[$li['key']] }}</span>
                                <span class="d-legend-pct">{{ $pctLi }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══ TABLE ═══ --}}
        <div class="table-section">
            <div class="table-section-header">
                <div style="display:flex;align-items:center;gap:12px;">
                    <h2 class="table-section-title">Rekap Presensi</h2>
                    <span class="table-count">{{ $totalSiswa }} siswa</span>
                </div>
                <div style="display:flex;align-items:center;gap:16px;">
                    <div style="font-size:.8rem;color:var(--muted);">
                        Klik badge untuk detail
                    </div>
                    <button onclick="exportPDF()" class="btn-export">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Export PDF
                    </button>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th class="col-siswa">Siswa</th>
                            @foreach($days as $index => $day)
                                @php
                                    $isToday = \Carbon\Carbon::parse($weekDates[$index])->isToday();
                                @endphp
                                <th class="{{ $isToday ? 'today-col' : '' }}">
                                    <div class="day-th">
                                        <span class="day-name">{{ $day }}</span>
                                        <span class="day-date-label">{{ \Carbon\Carbon::parse($weekDates[$index])->format('d/m') }}</span>
                                    </div>
                                </th>
                            @endforeach
                            <th>Ringkasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $siswa)
                        @php
                            $weekPresensi = $siswa->presensi->filter(fn($p) => in_array($p->tanggal, $weekDates));
                            $siswaH = $weekPresensi->where('status','hadir')->count();
                            $siswaI = $weekPresensi->where('status','izin')->count();
                            $siswaS = $weekPresensi->where('status','sakit')->count();
                            $siswaA = $weekPresensi->where('status','alpha')->count();
                            $totalDays = count($weekDates);
                            $pct = $totalDays > 0 ? round($siswaH/$totalDays*100) : 0;
                            $attendClass = $pct >= 80 ? 'attend-high' : ($pct >= 60 ? 'attend-mid' : 'attend-low');
                        @endphp
                        <tr>
                            <td class="col-siswa">
                                <div class="student-cell">
                                    <div class="s-avatar">{{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}</div>
                                    <div>
                                        <div class="s-name">{{ $siswa->nama_siswa }}</div>
                                        <div class="s-nis">{{ $siswa->nis }}</div>
                                    </div>
                                </div>
                            </td>

                            @foreach($weekDates as $idx => $date)
                                @php
                                    $p = $siswa->presensi->firstWhere('tanggal', $date);
                                    $st = $p ? strtolower($p->status) : null;
                                    $letter = $st ? strtoupper(substr($st, 0, 1)) : null;
                                    $cls = $letter ? "s-{$letter}" : 's-none';
                                    $label = $letter ?? '–';
                                    $isToday = \Carbon\Carbon::parse($date)->isToday();
                                @endphp
                                <td style="text-align:center;" class="{{ $isToday ? 'today-col' : '' }}">
                                    <div class="s-badge {{ $cls }}" title="{{ ucfirst($st ?? 'Belum ada data') }}">{{ $label }}</div>
                                </td>
                            @endforeach

                            {{-- Summary --}}
                            <td style="text-align:center;">
                                <div class="summary-cell">
                                    <span class="attend-pct {{ $attendClass }}">{{ $pct }}%</span>
                                </div>
                                <div style="font-size:.68rem;color:var(--text-dim);margin-top:4px;font-family:'JetBrains Mono',monospace;">
                                    {{ $siswaH }}H {{ $siswaI }}I {{ $siswaS }}S {{ $siswaA }}A
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($days) + 2 }}">
                                <div class="empty-state">
                                    <div class="empty-icon">📭</div>
                                    <div class="empty-title">Tidak ada siswa ditemukan</div>
                                    <div class="empty-sub">Coba ubah kata kunci pencarian.</div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- LEGEND --}}
            <div class="legend-bar">
                <div class="legend-item">
                    <div class="s-badge s-H" style="width:26px;height:26px;font-size:.72rem;">H</div> Hadir
                </div>
                <div class="legend-item">
                    <div class="s-badge s-I" style="width:26px;height:26px;font-size:.72rem;">I</div> Izin
                </div>
                <div class="legend-item">
                    <div class="s-badge s-S" style="width:26px;height:26px;font-size:.72rem;">S</div> Sakit
                </div>
                <div class="legend-item">
                    <div class="s-badge s-A" style="width:26px;height:26px;font-size:.72rem;">A</div> Alpha
                </div>
                <div class="legend-item">
                    <div class="s-badge s-none" style="width:26px;height:26px;font-size:.72rem;">–</div> Belum ada data
                </div>
                <div style="margin-left:auto;display:flex;gap:12px;">
                    <div class="legend-item"><span class="attend-pct attend-high" style="padding:2px 10px;">≥80%</span> Baik</div>
                    <div class="legend-item"><span class="attend-pct attend-mid"  style="padding:2px 10px;">60–79%</span> Perlu pantau</div>
                    <div class="legend-item"><span class="attend-pct attend-low"  style="padding:2px 10px;">&lt;60%</span> Kritis</div>
                </div>
            </div>
        </div>

    </main>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="footer">
        &copy; {{ date('Y') }} <span>Dibuat oleh ONEJAY TEAM</span> &mdash; <a href="{{ url('/about') }}" style="color: var(--gold-light); text-decoration: none; font-weight: 600;">Tentang Kami | About Us</a>
    </footer>

</div>

{{-- CHARTS SCRIPT --}}
<script>
const trenData = @json(array_values($trenHarian));
const rekap    = @json($rekap);

const C = { Hadir:'#2DD4BF', Izin:'#F59E0B', Sakit:'#FB923C', Alpa:'#F87171' };

Chart.defaults.color = '#8FA3C0';
Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

// ── Tren Garis
(function() {
    if(trenData.length === 0) return;
    const labels   = trenData.map(d => d.label);
    const datasets = ['Hadir','Izin','Sakit','Alpa'].map(k => ({
        label: k, data: trenData.map(d => d[k]),
        borderColor: C[k], backgroundColor: C[k] + '15',
        borderWidth: 2.5, pointRadius: 3, pointHoverRadius: 6,
        pointBackgroundColor: C[k], pointBorderColor: '#0B1F3A', pointBorderWidth: 2,
        tension: 0.4, fill: true,
    }));

    new Chart(document.getElementById('chartTren'), {
        type: 'line',
        data: { labels, datasets },
        options: {
            responsive: true, maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { font:{size:11,weight:'600'}, color:'#8FA3C0', usePointStyle:true, boxWidth:8, boxHeight:8, padding:14 }
                },
                tooltip: {
                    backgroundColor: '#112240', titleColor: '#FFFFFF', bodyColor: '#8FA3C0',
                    padding: 12, cornerRadius: 10, boxPadding: 6,
                    borderColor: 'rgba(201,150,60,.28)', borderWidth: 1,
                    titleFont:{size:12,weight:'700'}, bodyFont:{size:12},
                },
            },
            scales: {
                x: { grid:{color:'rgba(255,255,255,.04)'}, ticks:{color:'#8FA3C0',font:{size:10,weight:'600'}} },
                y: { beginAtZero:true, grid:{color:'rgba(255,255,255,.04)'}, ticks:{color:'#8FA3C0',precision:0,font:{size:10,weight:'600'}} },
            },
        },
    });
})();

// ── Donut
(function() {
    const keys   = ['Hadir','Izin','Sakit','Alpa'];
    const values = keys.map(k => rekap[k]);
    if(values.reduce((a,b)=>a+b, 0) === 0) return;

    new Chart(document.getElementById('chartDonut'), {
        type: 'doughnut',
        data: {
            labels: keys,
            datasets: [{
                data: values,
                backgroundColor: keys.map(k => C[k]),
                borderWidth: 3, borderColor: '#0B1F3A', hoverOffset: 8,
            }],
        },
        options: {
            responsive: true, maintainAspectRatio: false, cutout: '74%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#112240', padding: 12, cornerRadius: 10,
                    borderColor: 'rgba(201,150,60,.28)', borderWidth: 1,
                    titleFont:{size:12,weight:'700'}, bodyFont:{size:12},
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed} (${Math.round(ctx.parsed/(ctx.dataset.data.reduce((a,b)=>a+b,0)||1)*100)}%)`,
                    },
                },
            },
        },
    });
})();

function exportPDF() {
    // Pastikan chart sudah ter-render sebelum print
    window.print();
}
</script>
<script src="{{ asset('js/theme-mode.js') }}"></script>
</body>
</html>