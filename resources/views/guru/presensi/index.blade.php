<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Presensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --text-dim:    rgba(255,255,255,.80);
            /* Status colors */
            --green:  #4caf8a;
            --blue:   #60a5fa;
            --yellow: #fbbf24;
            --red:    #e05c5c;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            min-height: 100vh;
            font-size: 16px; /* base lebih besar untuk lansia */
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

        /* Status bar shimmer */
        .status-bar {
            height: 3px;
            background: linear-gradient(90deg, var(--gold), #a8782e, var(--gold));
            background-size: 200% 100%;
            animation: shimmer 3s infinite linear;
            position: relative; z-index: 10;
        }
        @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }

        /* ── NAVBAR ──────────────────────────────── */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 20px; height: 62px;
            background: rgba(11,31,58,.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gold-border);
        }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 1.05rem; color: var(--navy);
            flex-shrink: 0;
        }
        .nav-title {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; color: var(--white);
        }
        .btn-back {
            display: flex; align-items: center; gap: 6px;
            padding: 9px 16px;
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 8px;
            color: var(--gold-light);
            text-decoration: none;
            font-size: .88rem; font-weight: 600;
            transition: all .2s; white-space: nowrap;
        }
        .btn-back:hover { background: var(--glass-b); border-color: var(--gold); color: var(--gold); }

        /* ── LAYOUT ──────────────────────────────── */
        .page-wrap {
            position: relative; z-index: 1;
            max-width: 960px;
            margin: 0 auto;
            padding: 28px 18px 72px;
        }

        /* Page title */
        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.4rem, 4vw, 1.85rem);
            font-weight: 700; color: var(--white);
            margin-bottom: 4px;
        }
        .page-title span { color: var(--gold); }
        .page-sub { color: var(--muted); font-size: .9rem; margin-bottom: 26px; }

        /* Alert success */
        .alert-ok {
            display: flex; align-items: center; gap: 10px;
            padding: 13px 18px;
            background: rgba(76,175,138,.12);
            border: 1px solid rgba(76,175,138,.28);
            border-radius: 10px;
            color: #7fe3b8;
            font-size: .9rem; font-weight: 500;
            margin-bottom: 20px;
        }

        /* ── CARD ────────────────────────────────── */
        .card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 14px;
            backdrop-filter: blur(14px);
            overflow: hidden;
            margin-bottom: 18px;
        }
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--gold-border);
            background: rgba(201,150,60,.06);
        }
        .card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; font-weight: 600;
            color: var(--gold-light);
        }
        .card-body { padding: 20px; }

        /* ── FILTER ──────────────────────────────── */
        .filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .form-group { display: flex; flex-direction: column; gap: 7px; }
        .form-label {
            font-size: .78rem; font-weight: 700;
            color: var(--muted);
            letter-spacing: .06em; text-transform: uppercase;
        }
        .form-select, .form-input {
            padding: 13px 15px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(143,163,192,.25);
            border-radius: 9px;
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .95rem; /* lebih besar untuk keterbacaan */
            outline: none;
            transition: all .2s;
            width: 100%;
            appearance: none; cursor: pointer;
        }
        .form-select:focus, .form-input:focus {
            border-color: var(--gold);
            background: rgba(201,150,60,.07);
            box-shadow: 0 0 0 3px rgba(201,150,60,.10);
        }
        .form-select option { background: #112847; color: var(--white); }
        input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(.5); cursor: pointer; }

        /* ── STATISTIK ───────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 18px;
        }
        .stat-box {
            border-radius: 12px;
            padding: 18px 16px;
            text-align: center;
            border: 1px solid;
        }
        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem; font-weight: 700; line-height: 1;
        }
        .stat-lbl {
            font-size: .77rem; font-weight: 700;
            margin-top: 5px; text-transform: uppercase; letter-spacing: .05em;
        }
        .stat-total { background: rgba(96,165,250,.10); border-color: rgba(96,165,250,.25); color: #93c5fd; }
        .stat-hadir { background: rgba(76,175,138,.10); border-color: rgba(76,175,138,.25); color: #7fe3b8; }
        .stat-belum { background: rgba(224,92,92,.10);  border-color: rgba(224,92,92,.25);  color: #f9a8a8; }

        /* ── SEARCH ──────────────────────────────── */
        .search-wrap {
            display: flex; gap: 10px;
        }
        .search-input {
            flex: 1;
            padding: 12px 15px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(143,163,192,.25);
            border-radius: 9px;
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .95rem;
            outline: none;
            transition: all .2s;
        }
        .search-input:focus { border-color: var(--gold); background: rgba(201,150,60,.07); }
        .search-input::placeholder { color: rgba(143,163,192,.45); }
        .btn-search {
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border: none; border-radius: 9px;
            color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem; font-weight: 700;
            cursor: pointer;
            transition: all .2s; white-space: nowrap;
        }
        .btn-search:hover { filter: brightness(1.08); }

        /* ── TABS ────────────────────────────────── */
        .tabs {
            display: flex; gap: 8px; margin-bottom: 16px;
            overflow-x: auto; padding-bottom: 2px;
        }
        .tab {
            padding: 10px 22px;
            border-radius: 9px;
            font-size: .9rem; font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--gold-border);
            background: var(--glass);
            color: var(--muted);
            transition: all .2s; white-space: nowrap;
            cursor: pointer;
        }
        .tab:hover { background: var(--glass-b); color: var(--gold-light); }
        .tab.active { background: var(--gold-dim); border-color: var(--gold); color: var(--gold-light); }

        /* ── DESKTOP TABLE ───────────────────────── */
        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; min-width: 540px; }
        thead tr {
            background: rgba(201,150,60,.08);
            border-bottom: 1px solid var(--gold-border);
        }
        thead th {
            padding: 13px 16px;
            text-align: left;
            font-size: .77rem; font-weight: 700;
            color: var(--gold);
            letter-spacing: .07em; text-transform: uppercase;
            white-space: nowrap;
        }
        tbody tr { border-bottom: 1px solid rgba(143,163,192,.09); transition: background .15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.03); }
        tbody tr.row-belum { background: rgba(224,92,92,.04); }
        tbody tr.row-belum:hover { background: rgba(224,92,92,.07); }
        tbody td {
            padding: 14px 16px;
            font-size: .92rem; /* lebih besar */
            color: var(--text-dim);
            vertical-align: middle;
        }

        /* ── MOBILE CARD LIST ────────────────────── */
        .mobile-list { display: none; }
        .mobile-item {
            padding: 16px 18px;
            border-bottom: 1px solid rgba(143,163,192,.09);
        }
        .mobile-item:last-child { border-bottom: none; }
        .mobile-row-top {
            display: flex; align-items: center;
            justify-content: space-between; gap: 10px;
            margin-bottom: 8px;
        }
        .mobile-nama { font-size: .97rem; font-weight: 600; color: var(--white); }
        .mobile-nis  { font-size: .8rem; color: var(--muted); font-family: monospace; }
        .mobile-meta { font-size: .82rem; color: var(--muted); margin-bottom: 10px; }

        /* Status form inline */
        .status-form { display: flex; gap: 7px; align-items: center; }
        .status-select {
            flex: 1;
            padding: 9px 12px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(143,163,192,.2);
            border-radius: 7px;
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .88rem;
            appearance: none; cursor: pointer; outline: none;
        }
        .status-select option { background: #112847; }
        .btn-update {
            padding: 9px 16px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border: none; border-radius: 7px;
            color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .85rem; font-weight: 700;
            cursor: pointer; transition: all .2s; white-space: nowrap;
        }
        .btn-update:hover { filter: brightness(1.08); }

        /* ── BADGES ──────────────────────────────── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 7px;
            font-size: .8rem; font-weight: 700;
            white-space: nowrap;
        }
        .badge-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .badge-hadir { background: rgba(76,175,138,.14); border: 1px solid rgba(76,175,138,.3); color: #7fe3b8; }
        .badge-izin  { background: rgba(96,165,250,.14); border: 1px solid rgba(96,165,250,.3); color: #93c5fd; }
        .badge-sakit { background: rgba(251,191,36,.14);  border: 1px solid rgba(251,191,36,.3);  color: #fcd34d; }
        .badge-alpa  { background: rgba(224,92,92,.14);   border: 1px solid rgba(224,92,92,.3);   color: #f9a8a8; }
        .badge-belum { background: rgba(224,92,92,.10); border: 1px dashed rgba(224,92,92,.4); color: #f9a8a8; }

        /* Empty */
        .empty-state { text-align: center; padding: 48px 20px; color: var(--muted); }
        .empty-icon  { font-size: 2.5rem; margin-bottom: 12px; }
        .empty-state p { font-size: .95rem; }

        /* Pilih kelas dulu */
        .pick-first {
            text-align: center; padding: 56px 20px; color: var(--muted);
        }
        .pick-first .pick-icon { font-size: 3rem; margin-bottom: 14px; }
        .pick-first p { font-size: 1rem; font-weight: 500; }

        /* ── RESPONSIVE ──────────────────────────── */
        @media (max-width: 620px) {
            .filter-grid { grid-template-columns: 1fr; }
            .stats-grid  { grid-template-columns: repeat(3, 1fr); gap: 9px; }
            .stat-num    { font-size: 1.8rem; }

            /* Card view on mobile */
            .table-wrap  { display: none; }
            .mobile-list { display: block; }

            .tabs { gap: 6px; }
            .tab  { padding: 9px 14px; font-size: .85rem; }
        }
        @media (max-width: 400px) {
            .page-wrap { padding: 18px 13px 56px; }
            .navbar    { padding: 0 13px; height: 56px; }
            .nav-title { font-size: .9rem; }
            .stats-grid { gap: 7px; }
            .stat-num   { font-size: 1.6rem; }
            .stat-lbl   { font-size: .68rem; }
        }
    </style>
</head>
<body>

<div class="status-bar"></div>

<!-- Navbar -->
<nav class="navbar">
    <a href="{{ route('guru.dashboard') }}" class="nav-brand">
        <div class="nav-logo">S</div>
        <span class="nav-title">SchoolSystem</span>
    </a>
    <a href="{{ route('guru.dashboard') }}" class="btn-back">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11L5 7l4-4"/></svg>
        Dashboard
    </a>
</nav>

<div class="page-wrap">

    <h1 class="page-title">Rekap <span>Presensi</span></h1>
    <p class="page-sub">Lihat kehadiran siswa dan perbarui status</p>

    @if(session('success'))
        <div class="alert-ok">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="#4caf8a" stroke-width="1.5"/><path d="M5 8l2.5 2.5 4-4" stroke="#4caf8a" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filter Kelas & Tanggal -->
    <div class="card">
        <div class="card-header"><h2>Pilih Kelas &amp; Tanggal</h2></div>
        <div class="card-body">
            <form method="GET" action="{{ route('guru.presensi.index') }}">
                <div class="filter-grid">
                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <select name="jadwal_id" class="form-select" onchange="this.form.submit()">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($jadwals as $j)
                                <option value="{{ $j->id }}" @selected($j->id == $jadwalId)>
                                    {{ $j->kelas }} — {{ $j->mapel->nama_mapel ?? $j->kode_mapel }} ({{ $j->jam_mulai }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-input" value="{{ $tanggal }}" onchange="this.form.submit()">
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($jadwal)

        {{-- Statistik --}}
        @php
            $totalSiswa  = $semuaSiswa->count();
            $jumlahHadir = $presensiHadir->count();
            $jumlahBelum = $totalSiswa - $jumlahHadir;
        @endphp

        <div class="stats-grid">
            <div class="stat-box stat-total">
                <div class="stat-num">{{ $totalSiswa }}</div>
                <div class="stat-lbl">Total Siswa</div>
            </div>
            <div class="stat-box stat-hadir">
                <div class="stat-num">{{ $jumlahHadir }}</div>
                <div class="stat-lbl">Hadir</div>
            </div>
            <div class="stat-box stat-belum">
                <div class="stat-num">{{ $jumlahBelum }}</div>
                <div class="stat-lbl">Belum / Alpa</div>
            </div>
        </div>

        <!-- Cari Siswa -->
        <div class="card">
            <div class="card-body" style="padding:16px 20px;">
                <form method="GET" action="{{ route('guru.presensi.index') }}" class="search-wrap">
                    <input type="hidden" name="jadwal_id" value="{{ $jadwalId }}">
                    <input type="hidden" name="tanggal"   value="{{ $tanggal }}">
                    <input type="text" name="search" class="search-input"
                        placeholder="Cari nama siswa atau NIS..."
                        value="{{ $search }}">
                    <button type="submit" class="btn-search">Cari</button>
                </form>
            </div>
        </div>

        <!-- Tab Filter -->
        <div class="tabs">
            <a href="{{ request()->fullUrlWithQuery(['tab'=>'semua']) }}"
               class="tab {{ (!request('tab') || request('tab')=='semua') ? 'active' : '' }}">
                Semua ({{ $totalSiswa }})
            </a>
            <a href="{{ request()->fullUrlWithQuery(['tab'=>'hadir']) }}"
               class="tab {{ request('tab')=='hadir' ? 'active' : '' }}">
                Hadir ({{ $jumlahHadir }})
            </a>
            <a href="{{ request()->fullUrlWithQuery(['tab'=>'belum']) }}"
               class="tab {{ request('tab')=='belum' ? 'active' : '' }}">
                Belum ({{ $jumlahBelum }})
            </a>
        </div>

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-header">
                <h2>{{ $jadwal->kelas }} — {{ $jadwal->mapel->nama_mapel ?? '' }} — {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}</h2>
            </div>

            {{-- Desktop: tabel --}}
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jam Masuk</th>
                            <th style="text-align:center">Status</th>
                            <th>Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $tab = request('tab', 'semua'); $no = 1; @endphp

                        {{-- Sudah hadir --}}
                        @foreach($presensiHadir as $p)
                            @if($tab == 'belum') @continue @endif
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td style="font-family:monospace; color:var(--muted);">{{ $p->nis }}</td>
                                <td style="font-weight:600; color:var(--white);">{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                <td>{{ $p->jam_masuk ?? '-' }}</td>
                                <td style="text-align:center;">
                                    @if($p->status === 'Hadir')
                                        <span class="badge badge-hadir"><span class="badge-dot" style="background:var(--green);"></span>Hadir</span>
                                    @elseif($p->status === 'Izin')
                                        <span class="badge badge-izin"><span class="badge-dot" style="background:var(--blue);"></span>Izin</span>
                                    @elseif($p->status === 'Sakit')
                                        <span class="badge badge-sakit"><span class="badge-dot" style="background:var(--yellow);"></span>Sakit</span>
                                    @else
                                        <span class="badge badge-alpa"><span class="badge-dot" style="background:var(--red);"></span>Alpa</span>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('guru.presensi.update', $p->id) }}" class="status-form">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="jadwal_id" value="{{ $jadwalId }}">
                                        <input type="hidden" name="tanggal"   value="{{ $tanggal }}">
                                        <select name="status" class="status-select">
                                            <option value="Hadir"  @selected($p->status=='Hadir')>Hadir</option>
                                            <option value="Izin"   @selected($p->status=='Izin')>Izin</option>
                                            <option value="Sakit"  @selected($p->status=='Sakit')>Sakit</option>
                                            <option value="Alpa"   @selected($p->status=='Alpa')>Alpa</option>
                                        </select>
                                        <button type="submit" class="btn-update">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Belum presensi --}}
                        @if($tab !== 'hadir')
                            @foreach($semuaSiswa as $siswa)
                                @if(in_array($siswa->nis, $nisHadir)) @continue @endif
                                @if($search && stripos($siswa->nama_siswa, $search) === false && stripos($siswa->nis, $search) === false) @continue @endif
                                <tr class="row-belum">
                                    <td>{{ $no++ }}</td>
                                    <td style="font-family:monospace; color:var(--muted);">{{ $siswa->nis }}</td>
                                    <td style="font-weight:600; color:var(--white);">{{ $siswa->nama_siswa }}</td>
                                    <td style="color:var(--muted);">—</td>
                                    <td style="text-align:center;"><span class="badge badge-belum">Belum</span></td>
                                    <td style="color:var(--muted); font-size:.82rem;">—</td>
                                </tr>
                            @endforeach
                        @endif

                        @if($no === 1)
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">📭</div>
                                        <p>Tidak ada data yang ditampilkan</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Mobile: card list --}}
            <div class="mobile-list">
                @php $tab = request('tab', 'semua'); $no = 1; @endphp

                @foreach($presensiHadir as $p)
                    @if($tab == 'belum') @continue @endif
                    <div class="mobile-item">
                        <div class="mobile-row-top">
                            <div>
                                <div class="mobile-nama">{{ $p->siswa->nama_siswa ?? '-' }}</div>
                                <div class="mobile-nis">NIS: {{ $p->nis }}</div>
                            </div>
                            @if($p->status === 'Hadir')
                                <span class="badge badge-hadir"><span class="badge-dot" style="background:var(--green);"></span>Hadir</span>
                            @elseif($p->status === 'Izin')
                                <span class="badge badge-izin"><span class="badge-dot" style="background:var(--blue);"></span>Izin</span>
                            @elseif($p->status === 'Sakit')
                                <span class="badge badge-sakit"><span class="badge-dot" style="background:var(--yellow);"></span>Sakit</span>
                            @else
                                <span class="badge badge-alpa"><span class="badge-dot" style="background:var(--red);"></span>Alpa</span>
                            @endif
                        </div>
                        <div class="mobile-meta">Jam masuk: {{ $p->jam_masuk ?? '—' }}</div>
                        <form method="POST" action="{{ route('guru.presensi.update', $p->id) }}" class="status-form">
                            @csrf @method('PUT')
                            <input type="hidden" name="jadwal_id" value="{{ $jadwalId }}">
                            <input type="hidden" name="tanggal"   value="{{ $tanggal }}">
                            <select name="status" class="status-select">
                                <option value="Hadir"  @selected($p->status=='Hadir')>Hadir</option>
                                <option value="Izin"   @selected($p->status=='Izin')>Izin</option>
                                <option value="Sakit"  @selected($p->status=='Sakit')>Sakit</option>
                                <option value="Alpa"   @selected($p->status=='Alpa')>Alpa</option>
                            </select>
                            <button type="submit" class="btn-update">Simpan</button>
                        </form>
                    </div>
                @endforeach

                @if($tab !== 'hadir')
                    @foreach($semuaSiswa as $siswa)
                        @if(in_array($siswa->nis, $nisHadir)) @continue @endif
                        @if($search && stripos($siswa->nama_siswa, $search) === false && stripos($siswa->nis, $search) === false) @continue @endif
                        <div class="mobile-item" style="background:rgba(224,92,92,.04);">
                            <div class="mobile-row-top">
                                <div>
                                    <div class="mobile-nama">{{ $siswa->nama_siswa }}</div>
                                    <div class="mobile-nis">NIS: {{ $siswa->nis }}</div>
                                </div>
                                <span class="badge badge-belum">Belum</span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>

    @else
        <div class="card">
            <div class="card-body">
                <div class="pick-first">
                    <div class="pick-icon">👆</div>
                    <p>Silakan pilih kelas terlebih dahulu</p>
                </div>
            </div>
        </div>
    @endif

</div>
</body>
</html>