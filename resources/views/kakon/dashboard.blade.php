<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Kepala Konsentrasi — SIJA Presensi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

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

            /* Status colors */
            --hadir: #10b981;  --hadir-a: rgba(16,185,129,.12);
            --izin:  #3b82f6;  --izin-a:  rgba(59,130,246,.12);
            --sakit: #f59e0b;  --sakit-a: rgba(245,158,11,.12);
            --alpa:  #f43f5e;  --alpa-a:  rgba(244,63,94,.12);
        }

        html, body { min-height: 100%; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy); color: var(--white); overflow-x: hidden;
        }

        /* BG */
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
            background-size: 60px 60px; pointer-events: none; z-index: 0;
        }

        /* ── NAV ── */
        nav {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 2.5rem; border-bottom: 1px solid var(--border);
            backdrop-filter: blur(20px); background: rgba(11,31,58,.88);
        }
        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-logo {
            width: 38px; height: 38px; background: var(--gold); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif; font-weight: 700; font-size: 17px; color: var(--navy);
        }
        .nav-name { font-size: 14px; font-weight: 600; }
        .nav-sub  { font-size: 10px; color: var(--muted); letter-spacing: .6px; text-transform: uppercase; }
        .nav-right { display: flex; align-items: center; gap: 10px; }
        .nav-pill {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 6px 14px; border-radius: 8px;
            font-size: 12px; font-weight: 600; text-decoration: none; transition: all .2s;
        }
        .nav-pill-gold { background: rgba(201,150,60,.15); border: 1px solid var(--border); color: var(--gold-lt); }
        .nav-pill-gold:hover { background: rgba(201,150,60,.25); }
        .nav-pill-ghost { background: var(--glass); border: 1px solid var(--border-w); color: var(--muted); }
        .nav-pill-ghost:hover { background: rgba(255,255,255,.08); color: var(--white); }
        .nav-pill svg { width: 14px; height: 14px; }
        .nav-user-ava {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--navy-soft); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: var(--gold-lt);
        }

        /* ── WRAP ── */
        .wrap {
            position: relative; z-index: 2;
            max-width: 1280px; margin: 0 auto;
            padding: 2rem 2.5rem 4rem;
            animation: fadeUp .7s ease both;
        }
        @keyframes fadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:translateY(0)} }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex; align-items: flex-end; justify-content: space-between;
            flex-wrap: wrap; gap: 1rem; margin-bottom: 1.75rem;
        }
        .page-badge {
            display: inline-flex; align-items: center; gap: 8px; padding: 5px 12px;
            background: rgba(201,150,60,.12); border: 1px solid rgba(201,150,60,.28);
            border-radius: 100px; font-size: 11px; font-weight: 600; color: var(--gold-lt);
            letter-spacing: .5px; text-transform: uppercase; margin-bottom: .8rem;
        }
        .page-badge::before {
            content: ''; width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold); animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem; font-weight: 700; line-height: 1.2; color: var(--white);
        }
        .page-title span { color: var(--gold); }
        .page-sub { margin-top: .3rem; font-size: 13px; color: var(--muted); }
        .page-meta {
            text-align: right; font-size: 12px; color: var(--muted);
        }
        .page-meta strong { display: block; font-size: 15px; color: var(--gold-dim); font-weight: 700; }

        /* ── FILTER CARD ── */
        .filter-card {
            background: var(--glass); border: 1px solid var(--border-w);
            border-radius: 14px; padding: 1.2rem 1.5rem; margin-bottom: 1.5rem;
        }
        .filter-grid {
            display: grid; grid-template-columns: repeat(3, 1fr) auto;
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
            width: 100%; background: rgba(255,255,255,.05); border: 1px solid var(--border-w);
            border-radius: 9px; padding: 10px 14px 10px 36px;
            font-size: 13px; font-weight: 600; color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            outline: none; transition: all .2s; appearance: none;
        }
        .f-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%238FA3C0' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center; background-size: 12px; padding-right: 30px;
        }
        .f-select option { background: #132D52; }
        .f-select:focus, .f-input:focus { border-color: var(--gold); background: rgba(255,255,255,.08); }
        .f-input::placeholder { color: rgba(143,163,192,.5); }
        .btn-filter {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 10px 18px; background: var(--gold); border: none; border-radius: 9px;
            font-size: 13px; font-weight: 700; color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
            white-space: nowrap; transition: all .2s;
        }
        .btn-filter:hover { background: var(--gold-lt); }
        .btn-filter svg { width: 14px; height: 14px; }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid; grid-template-columns: repeat(5, 1fr);
            gap: 1rem; margin-bottom: 1.5rem;
        }
        .stat-card {
            background: var(--glass); border: 1px solid var(--border-w);
            border-radius: 14px; padding: 1.3rem 1.2rem;
            position: relative; overflow: hidden; transition: all .25s; cursor: default;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 2px; border-radius: 14px 14px 0 0;
        }
        .stat-card:hover { transform: translateY(-3px); background: rgba(255,255,255,.07); }
        .sc-hadir::before { background: var(--hadir); }
        .sc-izin::before  { background: var(--izin); }
        .sc-sakit::before { background: var(--sakit); }
        .sc-alpa::before  { background: var(--alpa); }
        .sc-total::before { background: linear-gradient(90deg, var(--gold), var(--gold-lt)); }

        .stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: .9rem; }
        .stat-lbl { font-size: 11px; font-weight: 700; color: var(--muted); text-transform: uppercase; letter-spacing: .4px; }
        .stat-ico {
            width: 36px; height: 36px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
        }
        .stat-ico svg { width: 18px; height: 18px; }
        .sc-hadir .stat-ico { background: var(--hadir-a); color: var(--hadir); }
        .sc-izin  .stat-ico { background: var(--izin-a);  color: var(--izin);  }
        .sc-sakit .stat-ico { background: var(--sakit-a); color: var(--sakit); }
        .sc-alpa  .stat-ico { background: var(--alpa-a);  color: var(--alpa);  }
        .sc-total .stat-ico { background: rgba(201,150,60,.15); color: var(--gold-lt); }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem; font-weight: 700; line-height: 1; margin-bottom: .5rem;
        }
        .sc-hadir .stat-num { color: var(--hadir); }
        .sc-izin  .stat-num { color: var(--izin);  }
        .sc-sakit .stat-num { color: var(--sakit); }
        .sc-alpa  .stat-num { color: var(--alpa);  }
        .sc-total .stat-num { color: var(--gold-lt); }

        .stat-bar { height: 4px; background: rgba(255,255,255,.06); border-radius: 99px; overflow: hidden; margin-bottom: .5rem; }
        .stat-bar-fill { height: 100%; border-radius: 99px; transition: width .6s ease; }
        .sc-hadir .stat-bar-fill { background: var(--hadir); }
        .sc-izin  .stat-bar-fill { background: var(--izin);  }
        .sc-sakit .stat-bar-fill { background: var(--sakit); }
        .sc-alpa  .stat-bar-fill { background: var(--alpa);  }
        .sc-total .stat-bar-fill { background: linear-gradient(90deg, var(--gold), var(--gold-lt)); }
        .stat-foot { font-size: 11px; color: var(--muted); }
        .stat-foot strong { color: var(--white); }

        /* ── MAIN GRID ── */
        .main-grid {
            display: grid; grid-template-columns: 1fr 320px;
            gap: 1.2rem; align-items: start;
        }
        @media (max-width: 1100px) { .main-grid { grid-template-columns: 1fr; } }

        /* ── PANEL ── */
        .panel {
            background: var(--glass); border: 1px solid var(--border-w);
            border-radius: 16px; overflow: hidden; margin-bottom: 1.2rem;
        }
        .panel:last-child { margin-bottom: 0; }
        .panel-hd {
            padding: 1rem 1.4rem; border-bottom: 1px solid var(--border-w);
            display: flex; align-items: center; justify-content: space-between;
        }
        .panel-title {
            display: flex; align-items: center; gap: 9px;
            font-size: 13px; font-weight: 700; color: var(--white); margin: 0;
        }
        .panel-title svg { width: 16px; height: 16px; color: var(--gold); }
        .panel-badge {
            font-size: 11px; font-weight: 700; color: var(--muted);
            background: rgba(255,255,255,.06); border: 1px solid var(--border-w);
            padding: 3px 11px; border-radius: 99px;
        }
        .panel-body { padding: 1.2rem 1.4rem; }

        /* ── CHART WRAPPER ── */
        .chart-wrap { position: relative; }

        /* ── TABLE ── */
        .tbl-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: rgba(201,150,60,.06); border-bottom: 1px solid var(--border); }
        th {
            padding: 10px 14px; text-align: left;
            font-size: 11px; font-weight: 700; color: var(--muted);
            letter-spacing: .5px; text-transform: uppercase; white-space: nowrap;
        }
        td {
            padding: 12px 14px; font-size: 13px; color: var(--white);
            border-bottom: 1px solid var(--border-w); vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.03); }

        /* USER CELL */
        .user-cell { display: flex; align-items: center; gap: 10px; }
        .user-ava {
            width: 34px; height: 34px; border-radius: 9px;
            background: var(--navy-soft); border: 1px solid var(--border-w);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; color: var(--gold-lt); flex-shrink: 0;
        }
        .user-name { font-weight: 600; font-size: 13px; }
        .user-nis  { font-size: 11px; color: var(--muted); font-family: monospace; }

        /* PILLS */
        .pill {
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 99px;
            min-width: 32px;
        }
        .pill-h { background: var(--hadir-a); color: var(--hadir); border: 1px solid rgba(16,185,129,.2); }
        .pill-i { background: var(--izin-a);  color: var(--izin);  border: 1px solid rgba(59,130,246,.2); }
        .pill-s { background: var(--sakit-a); color: var(--sakit); border: 1px solid rgba(245,158,11,.2); }
        .pill-a { background: var(--alpa-a);  color: var(--alpa);  border: 1px solid rgba(244,63,94,.2); }

        /* PROGRESS */
        .prog-wrap { display: flex; align-items: center; gap: 8px; }
        .prog-track { flex: 1; height: 5px; background: rgba(255,255,255,.07); border-radius: 99px; overflow: hidden; min-width: 60px; }
        .prog-fill { height: 100%; border-radius: 99px; transition: width .6s ease; }
        .prog-lbl { font-size: 11px; font-weight: 700; color: var(--white); min-width: 34px; text-align: right; }

        /* ── LEADERBOARD ── */
        .lboard { display: flex; flex-direction: column; gap: 8px; }
        .lboard-item {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,.03); border: 1px solid var(--border-w);
            border-radius: 12px; padding: 11px 13px; transition: all .2s;
        }
        .lboard-item:hover { background: var(--alpa-a); border-color: rgba(244,63,94,.2); }
        .lboard-rank {
            width: 24px; height: 24px; border-radius: 50%;
            background: var(--alpa); color: #fff;
            font-size: 11px; font-weight: 800;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .lboard-ava {
            width: 32px; height: 32px; border-radius: 8px;
            background: var(--navy-soft); border: 1px solid var(--border-w);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 12px; color: var(--gold-lt); flex-shrink: 0;
        }
        .lboard-info { flex: 1; min-width: 0; }
        .lboard-name { font-size: 12px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .lboard-kelas { font-size: 11px; color: var(--muted); }
        .lboard-score {
            background: var(--alpa-a); color: var(--alpa);
            font-size: 11px; font-weight: 700;
            padding: 3px 9px; border-radius: 99px;
            border: 1px solid rgba(244,63,94,.2); white-space: nowrap;
        }

        /* ── DONUT LEGEND ── */
        .donut-legend { display: flex; flex-direction: column; gap: 8px; margin-top: 1rem; }
        .legend-item { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
        .legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .legend-label { font-size: 12px; color: var(--muted); flex: 1; }
        .legend-val { font-size: 12px; font-weight: 700; color: var(--white); }
        .legend-pct { font-size: 11px; color: var(--muted); min-width: 38px; text-align: right; }

        /* ── EMPTY STATE ── */
        .empty { text-align: center; padding: 3rem 2rem; color: var(--muted); }
        .empty svg { opacity: .3; margin-bottom: .6rem; }
        .empty p { font-size: 13px; }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,.12); border-radius: 99px; }

        footer { position: relative; z-index: 2; text-align: center; padding: 1.5rem; border-top: 1px solid var(--border-w); font-size: 12px; color: var(--muted); }

        @media (max-width: 900px) {
            nav { padding: 1rem 1.2rem; }
            .wrap { padding: 1.5rem 1.2rem 3rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .filter-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 540px) {
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .filter-grid { grid-template-columns: 1fr; }
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
            <div class="nav-sub">Dashboard Kepala Konsentrasi</div>
        </div>
    </div>
    <div class="nav-right">
        <div style="display:flex;align-items:center;gap:8px;">
            <div class="nav-user-ava">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div style="font-size:13px;font-weight:600;">{{ auth()->user()->name }}</div>
                <div style="font-size:10px;color:var(--muted);">Kepala Konsentrasi</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button type="submit" class="nav-pill nav-pill-ghost" style="border:none;cursor:pointer;font-family:inherit;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Logout
            </button>
        </form>
    </div>
</nav>

<div class="wrap">

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <div class="page-badge">Kepala Konsentrasi SIJA</div>
            <h1 class="page-title">Rekap <span>Presensi</span></h1>
            <p class="page-sub">Pantau kehadiran seluruh siswa kelas XI SIJA</p>
        </div>
        <div class="page-meta">
            <span>Tahun Ajaran</span>
            <strong>2025 / 2026</strong>
        </div>
    </div>

    {{-- FILTER --}}
    <form id="filterForm" method="GET" action="{{ route('kakon.dashboard') }}">
        <div class="filter-card">
            <div class="filter-grid">

                {{-- Kelas --}}
                <div class="filter-group">
                    <span class="filter-label">Kelas Konsentrasi</span>
                    <div class="input-wrap">
                        <span class="input-ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </span>
                        <select class="f-select" name="kelas" onchange="document.getElementById('filterForm').submit()">
                            @foreach(['XI SIJA 1','XI SIJA 2'] as $k)
                                <option value="{{ $k }}" @selected($kelas === $k)>{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Periode --}}
                <div class="filter-group">
                    <span class="filter-label">Periode Waktu</span>
                    <div class="input-wrap">
                        <span class="input-ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </span>
                        <select class="f-select" name="period" onchange="document.getElementById('filterForm').submit()">
                            <option value="hari_ini"   @selected($period==='hari_ini')>Hari Ini</option>
                            <option value="minggu_ini" @selected($period==='minggu_ini')>Minggu Ini</option>
                            <option value="bulan_ini"  @selected($period==='bulan_ini')>Bulan Ini</option>
                            <option value="semester"   @selected($period==='semester')>Semester Aktif</option>
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
                               value="{{ $search }}" placeholder="Masukkan nama..."
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

    {{-- STAT CARDS --}}
    @php
        $stats = [
            ['key'=>'Hadir','cls'=>'sc-hadir','path'=>'M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['key'=>'Izin', 'cls'=>'sc-izin', 'path'=>'M9 12h6m-6 4h6m-6-8h6m-9-4h12a2 2 0 012 2v16a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2z'],
            ['key'=>'Sakit','cls'=>'sc-sakit','path'=>'M4.5 12.75l6 6 9-13.5'],
            ['key'=>'Alpa', 'cls'=>'sc-alpa', 'path'=>'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
    @endphp
    <div class="stats-grid">
        @foreach($stats as $st)
            @php $pct = $rekapTotal > 0 ? round($rekap[$st['key']] / $rekapTotal * 100, 1) : 0; @endphp
            <div class="stat-card {{ $st['cls'] }}">
                <div class="stat-top">
                    <span class="stat-lbl">{{ $st['key'] }}</span>
                    <div class="stat-ico">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $st['path'] }}"/></svg>
                    </div>
                </div>
                <div class="stat-num">{{ $rekap[$st['key']] }}</div>
                <div class="stat-bar"><div class="stat-bar-fill" style="width:{{ $pct }}%"></div></div>
                <div class="stat-foot"><strong>{{ $pct }}%</strong> dari total presensi</div>
            </div>
        @endforeach

        <div class="stat-card sc-total">
            <div class="stat-top">
                <span class="stat-lbl">Total Aktivitas</span>
                <div class="stat-ico">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1"/></svg>
                </div>
            </div>
            <div class="stat-num">{{ array_sum($rekap) }}</div>
            <div class="stat-bar"><div class="stat-bar-fill" style="width:100%"></div></div>
            <div class="stat-foot"><strong>{{ $semuaSiswa->count() }}</strong> Siswa Terdaftar</div>
        </div>
    </div>

    {{-- MAIN GRID --}}
    <div class="main-grid">

        {{-- KIRI --}}
        <div>

            {{-- GRAFIK TREN --}}
            <div class="panel">
                <div class="panel-hd">
                    <h5 class="panel-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Tren Aktivitas Presensi
                    </h5>
                    <span class="panel-badge">{{ ucfirst(str_replace('_', ' ', $period)) }}</span>
                </div>
                <div class="panel-body">
                    <div class="chart-wrap" style="height:240px">
                        <canvas id="chartTren"></canvas>
                    </div>
                </div>
            </div>

            {{-- TABEL SISWA --}}
            <div class="panel" style="margin-bottom:0">
                <div class="panel-hd">
                    <h5 class="panel-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        Daftar Siswa — {{ $kelas }}
                    </h5>
                    <span class="panel-badge">{{ $rekapSiswa->count() }} siswa</span>
                </div>
                <div class="tbl-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:5%;text-align:center">No</th>
                                <th>Nama & NIS</th>
                                <th style="text-align:center">Hadir</th>
                                <th style="text-align:center">Izin</th>
                                <th style="text-align:center">Sakit</th>
                                <th style="text-align:center">Alpa</th>
                                <th style="text-align:center">Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rekapSiswa as $i => $s)
                                @php
                                    $pctH = $s['total'] > 0 ? round($s['Hadir'] / $s['total'] * 100) : 0;
                                    $barColor = $pctH >= 90 ? 'var(--hadir)' : ($pctH >= 75 ? 'var(--izin)' : ($pctH >= 50 ? 'var(--sakit)' : 'var(--alpa)'));
                                @endphp
                                <tr>
                                    <td style="text-align:center;color:var(--muted);font-weight:600">{{ $i + 1 }}</td>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-ava">{{ strtoupper(substr($s['nama'],0,1)) }}</div>
                                            <div>
                                                <div class="user-name">{{ $s['nama'] }}</div>
                                                <div class="user-nis">{{ $s['nis'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align:center"><span class="pill pill-h">{{ $s['Hadir'] }}</span></td>
                                    <td style="text-align:center"><span class="pill pill-i">{{ $s['Izin'] }}</span></td>
                                    <td style="text-align:center"><span class="pill pill-s">{{ $s['Sakit'] }}</span></td>
                                    <td style="text-align:center"><span class="pill pill-a">{{ $s['Alpa'] }}</span></td>
                                    <td style="text-align:center">
                                        <div class="prog-wrap">
                                            <div class="prog-track">
                                                <div class="prog-fill" style="width:{{ $pctH }}%;background:{{ $barColor }}"></div>
                                            </div>
                                            <span class="prog-lbl">{{ $pctH }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty">
                                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                            <p>Tidak ada data siswa ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KANAN --}}
        <div>

            {{-- DONUT CHART --}}
            <div class="panel">
                <div class="panel-hd">
                    <h5 class="panel-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
                        Komposisi Kehadiran
                    </h5>
                </div>
                <div class="panel-body">
                    <div class="chart-wrap" style="height:200px">
                        <canvas id="chartDonut"></canvas>
                    </div>

                    {{-- Custom legend --}}
                    @php
                        $legendItems = [
                            ['label'=>'Hadir', 'key'=>'Hadir', 'color'=>'#10b981'],
                            ['label'=>'Izin',  'key'=>'Izin',  'color'=>'#3b82f6'],
                            ['label'=>'Sakit', 'key'=>'Sakit', 'color'=>'#f59e0b'],
                            ['label'=>'Alpa',  'key'=>'Alpa',  'color'=>'#f43f5e'],
                        ];
                    @endphp
                    <div class="donut-legend" style="margin-top:1.2rem">
                        @foreach($legendItems as $li)
                            @php $pctLi = $rekapTotal > 0 ? round($rekap[$li['key']] / $rekapTotal * 100, 1) : 0; @endphp
                            <div class="legend-item">
                                <div class="legend-dot" style="background:{{ $li['color'] }}"></div>
                                <span class="legend-label">{{ $li['label'] }}</span>
                                <span class="legend-val">{{ $rekap[$li['key']] }}</span>
                                <span class="legend-pct">{{ $pctLi }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- TOP ALPA --}}
            <div class="panel" style="margin-bottom:0">
                <div class="panel-hd">
                    <h5 class="panel-title" style="color:#f43f5e">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#f43f5e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Siswa Alpa Terbanyak
                    </h5>
                </div>
                <div class="panel-body">
                    <div class="lboard">
                        @forelse($topAlpa as $i => $s)
                            <div class="lboard-item">
                                <div class="lboard-rank">{{ $i + 1 }}</div>
                                <div class="lboard-ava">{{ strtoupper(substr($s['nama'],0,1)) }}</div>
                                <div class="lboard-info">
                                    <div class="lboard-name">{{ $s['nama'] }}</div>
                                    <div class="lboard-kelas">{{ $s['kelas'] }}</div>
                                </div>
                                <div class="lboard-score">{{ $s['Alpa'] }}× Alpa</div>
                            </div>
                        @empty
                            <div class="empty">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                <p style="color:var(--hadir);font-size:12px;margin-top:.4rem">Semua siswa hadir dengan baik.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>{{-- /kanan --}}
    </div>{{-- /main-grid --}}

</div>{{-- /wrap --}}

<footer>&copy; {{ date('Y') }} SMK — Sistem Presensi Digital Kelas XI SIJA 1 &amp; 2</footer>

{{-- CHARTS --}}
<script>
const trenData = @json(array_values($trenHarian));
const rekap    = @json($rekap);

const C = { Hadir:'#10b981', Izin:'#3b82f6', Sakit:'#f59e0b', Alpa:'#f43f5e' };

Chart.defaults.color = '#8FA3C0';
Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

// ── Tren Garis
(function() {
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
                    backgroundColor: '#132D52', titleColor: '#FAFAF8', bodyColor: '#8FA3C0',
                    padding: 12, cornerRadius: 10, boxPadding: 6,
                    borderColor: 'rgba(201,150,60,.25)', borderWidth: 1,
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
                    backgroundColor: '#132D52', padding: 12, cornerRadius: 10,
                    borderColor: 'rgba(201,150,60,.25)', borderWidth: 1,
                    titleFont:{size:12,weight:'700'}, bodyFont:{size:12},
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.parsed} (${Math.round(ctx.parsed/(ctx.dataset.data.reduce((a,b)=>a+b,0)||1)*100)}%)`,
                    },
                },
            },
        },
    });
})();
</script>
</body>
</html>
