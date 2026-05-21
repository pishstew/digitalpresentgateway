<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas – {{ $kelas }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
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

        .page-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .search-wrap { position: relative; }
        .search-wrap svg { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
        .search-input {
            padding: 10px 16px 10px 42px;
            background: var(--glass); border: 1px solid var(--gold-border);
            border-radius: 12px; color: var(--white); font-size: .9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            width: 260px; transition: all .2s;
        }
        .search-input::placeholder { color: var(--text-dim); }
        .search-input:focus { outline: none; border-color: var(--gold); background: var(--glass-hover); box-shadow: 0 0 0 3px rgba(201,150,60,.12); }

        .week-nav { display: flex; align-items: center; gap: 8px; }
        .week-btn {
            width: 38px; height: 38px; border-radius: 10px;
            background: var(--glass); border: 1px solid var(--gold-border);
            color: var(--muted); cursor: pointer; font-size: 1rem;
            display: flex; align-items: center; justify-content: center;
            transition: all .2s; text-decoration: none;
        }
        .week-btn:hover { background: var(--gold-pale); color: var(--gold); border-color: var(--gold); text-decoration: none; }
        .week-label {
            padding: 8px 16px; background: var(--gold-pale); border: 1px solid var(--gold-border);
            border-radius: 10px; font-size: .82rem; font-weight: 600; color: var(--gold-light);
            font-family: 'JetBrains Mono', monospace; white-space: nowrap;
        }

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

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="page-title-group">
                <div class="page-eyebrow">Presensi Mingguan</div>
                <h1 class="page-title">Dashboard <span>Wali Kelas</span></h1>
                <div class="page-period">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('d M') }}
                    –
                    {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('d M Y') }}
                </div>
            </div>

            <div class="page-actions">
                {{-- Week navigation --}}
                <div class="week-nav">
                    <a href="{{ route('walikelas.dashboard', ['week' => \Carbon\Carbon::parse($startOfWeek)->subWeek()->format('Y-m-d'), 'search' => $search]) }}" class="week-btn">‹</a>
                    <span class="week-label">Minggu ini</span>
                    <a href="{{ route('walikelas.dashboard', ['week' => \Carbon\Carbon::parse($startOfWeek)->addWeek()->format('Y-m-d'), 'search' => $search]) }}" class="week-btn">›</a>
                </div>

                {{-- Search --}}
                <form action="{{ route('walikelas.dashboard') }}" method="GET" class="search-wrap">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="search" class="search-input" placeholder="Cari siswa…" value="{{ $search ?? '' }}">
                </form>
            </div>
        </div>

        {{-- ═══ STAT CARDS ═══ --}}
        @php
            $totalSiswa = $siswas->count();
            // Hitung rekap presensi minggu ini
            $allPresensi = $siswas->flatMap(fn($s) => $s->presensi->filter(fn($p) => $p->tanggal >= $startOfWeek && $p->tanggal <= $endOfWeek));
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
                <div class="stat-pct">Minggu ini</div>
            </div>
            <div class="stat-card c-sakit">
                <div class="stat-icon" style="color:var(--sick);">🩺</div>
                <div class="stat-value" style="color:var(--sick);">{{ $totalS }}</div>
                <div class="stat-label">Sakit</div>
                <div class="stat-pct">Minggu ini</div>
            </div>
            <div class="stat-card c-alpha">
                <div class="stat-icon" style="color:var(--danger);">⚠</div>
                <div class="stat-value" style="color:var(--danger);">{{ $totalA }}</div>
                <div class="stat-label">Alpha</div>
                <div class="stat-pct">Perlu perhatian</div>
            </div>
        </div>

        {{-- ═══ TABLE ═══ --}}
        <div class="table-section">
            <div class="table-section-header">
                <div style="display:flex;align-items:center;gap:12px;">
                    <h2 class="table-section-title">Rekap Presensi</h2>
                    <span class="table-count">{{ $totalSiswa }} siswa</span>
                </div>
                <div style="font-size:.8rem;color:var(--muted);">
                    Klik badge untuk detail
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
        &copy; {{ date('Y') }} <span>SekolahApp</span> · Dashboard Wali Kelas · {{ $kelas }}
    </footer>

</div>
</body>
</html>