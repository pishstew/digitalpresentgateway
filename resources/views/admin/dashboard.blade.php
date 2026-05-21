<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin — SIJA Presensi</title>
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
            background: var(--navy);
            color: var(--white);
            overflow-x: hidden;
        }

        /* ── BACKGROUND ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 70% -10%, rgba(28,61,110,.8) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 10% 80%, rgba(201,150,60,.07) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(201,150,60,.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,150,60,.04) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
        }

        /* ── NAV ── */
        nav {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 2.5rem;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(20px);
            background: rgba(11,31,58,.85);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-logo {
            width: 38px; height: 38px;
            background: var(--gold);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 17px;
            color: var(--navy);
            flex-shrink: 0;
        }

        .nav-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: .3px;
        }

        .nav-sub {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: .6px;
            text-transform: uppercase;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-avatar {
            width: 34px; height: 34px;
            background: var(--navy-soft);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--gold-lt);
        }

        .nav-user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--white);
        }

        .nav-user-role {
            font-size: 10px;
            color: var(--muted);
            letter-spacing: .4px;
        }

        /* ── MAIN WRAPPER ── */
        .dash-wrap {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 2.5rem 4rem;
            animation: fadeUp .7s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 2.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .page-header-left {}

        .page-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px;
            background: rgba(201,150,60,.12);
            border: 1px solid rgba(201,150,60,.28);
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            color: var(--gold-lt);
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .page-badge::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--gold);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .5; transform: scale(.7); }
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1.2;
        }

        .page-title span { color: var(--gold); }

        .page-sub {
            margin-top: .4rem;
            font-size: 14px;
            color: var(--muted);
        }

        .page-date {
            font-size: 13px;
            color: var(--muted);
            text-align: right;
        }

        .page-date strong {
            display: block;
            font-size: 15px;
            color: var(--gold-dim);
            font-weight: 600;
        }

        /* ── ALERT ── */
        .alert-success {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(74,222,128,.08);
            border: 1px solid rgba(74,222,128,.25);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            color: #86efac;
            margin-bottom: 2rem;
        }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--glass);
            border: 1px solid var(--border-w);
            border-radius: 14px;
            padding: 1.4rem 1.2rem;
            text-decoration: none;
            display: block;
            transition: all .25s;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            border-radius: 14px 14px 0 0;
            opacity: 0;
            transition: opacity .25s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(201,150,60,.2);
            background: rgba(255,255,255,.07);
        }

        .stat-card:hover::before { opacity: 1; }

        .sc-blue::before  { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .sc-teal::before  { background: linear-gradient(90deg, #0d9488, #2dd4bf); }
        .sc-violet::before{ background: linear-gradient(90deg, #7c3aed, #a78bfa); }
        .sc-yellow::before{ background: linear-gradient(90deg, #d97706, #fbbf24); }
        .sc-red::before   { background: linear-gradient(90deg, #dc2626, #f87171); }

        .stat-icon-wrap {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .9rem;
        }

        .si-blue   { background: rgba(59,130,246,.15); }
        .si-teal   { background: rgba(13,148,136,.15); }
        .si-violet { background: rgba(124,58,237,.15); }
        .si-yellow { background: rgba(217,119,6,.15); }
        .si-red    { background: rgba(220,38,38,.15); }

        .stat-icon-wrap svg { width: 20px; height: 20px; }

        .stat-count {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--white);
            line-height: 1;
            margin-bottom: .3rem;
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
            letter-spacing: .2px;
        }

        /* span 2 untuk presensi */
        .stat-card.span-2 { grid-column: span 2; }
        .stat-card.span-2 .stat-count { font-size: 2.4rem; }

        /* ── SECTION TITLE ── */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-w);
        }

        /* ── MANAGEMENT GRID ── */
        .mgmt-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .mgmt-card {
            background: var(--glass);
            border: 1px solid var(--border-w);
            border-radius: 14px;
            padding: 1.4rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all .25s;
            group: true;
        }

        .mgmt-card:hover {
            background: rgba(255,255,255,.07);
            border-color: var(--border);
            transform: translateX(4px);
        }

        .mgmt-card:hover .mgmt-chevron { opacity: 1; transform: translateX(3px); }

        .mgmt-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .mgmt-icon svg { width: 22px; height: 22px; }

        .mgmt-text { flex: 1; }

        .mgmt-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 3px;
        }

        .mgmt-desc {
            font-size: 12px;
            color: var(--muted);
        }

        .mgmt-chevron {
            opacity: .3;
            transition: all .2s;
            color: var(--gold);
        }

        .mgmt-chevron svg { width: 18px; height: 18px; }

        /* ── BOTTOM ROW ── */
        .bottom-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1rem;
            align-items: center;
        }

        /* ── STATUS BAR ── */
        .status-bar {
            background: rgba(201,150,60,.07);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #4ade80;
            animation: pulse 2s infinite;
            flex-shrink: 0;
        }

        .status-text {
            font-size: 13px;
            color: var(--gold-dim);
        }

        /* ── LOGOUT BUTTON ── */
        .btn-logout {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            background: rgba(220,38,38,.08);
            border: 1px solid rgba(220,38,38,.25);
            border-radius: 10px;
            color: #f87171;
            font-size: 13px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
        }

        .btn-logout:hover {
            background: rgba(220,38,38,.15);
            border-color: rgba(220,38,38,.4);
            transform: translateY(-1px);
        }

        .btn-logout svg { width: 16px; height: 16px; }

        /* ── FOOTER ── */
        footer {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 1.5rem;
            border-top: 1px solid var(--border-w);
            font-size: 12px;
            color: var(--muted);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .stat-card.span-2 { grid-column: span 2; }
            .mgmt-grid { grid-template-columns: 1fr; }
            .bottom-row { grid-template-columns: 1fr; }
        }

        @media (max-width: 600px) {
            nav { padding: 1rem 1.2rem; }
            .dash-wrap { padding: 1.5rem 1.2rem 3rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: .7rem; }
            .page-title { font-size: 1.5rem; }
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

        <div class="nav-right">
            <div class="nav-user">
                <div class="nav-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="nav-user-name">{{ auth()->user()->name }}</div>
                    <div class="nav-user-role">Administrator</div>
                </div>
            </div>
        </div>
    </nav>

    {{-- MAIN --}}
    <div class="dash-wrap">

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="page-header-left">
                <div class="page-badge">Panel Admin</div>
                <h1 class="page-title">Dashboard <span>Admin</span></h1>
                <p class="page-sub">Kelola seluruh data sistem presensi SIJA</p>
            </div>
            <div class="page-date">
                <span>Tahun Ajaran</span>
                <strong>2025 / 2026</strong>
            </div>
        </div>

        {{-- STATS --}}
        <div class="stats-grid">

            <a href="{{ route('admin.siswa.index') }}" class="stat-card sc-blue">
                <div class="stat-icon-wrap si-blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="stat-count">{{ $siswaCount }}</div>
                <div class="stat-label">Total Siswa</div>
            </a>

            <a href="{{ route('admin.guru.index') }}" class="stat-card sc-teal">
                <div class="stat-icon-wrap si-teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#2dd4bf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="stat-count">{{ $guruCount }}</div>
                <div class="stat-label">Total Guru</div>
            </a>

            <a href="{{ route('admin.mapel.index') }}" class="stat-card sc-violet">
                <div class="stat-icon-wrap si-violet">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <div class="stat-count">{{ $mapelCount }}</div>
                <div class="stat-label">Mata Pelajaran</div>
            </a>

            <a href="{{ route('admin.jadwal.index') }}" class="stat-card sc-yellow">
                <div class="stat-icon-wrap si-yellow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <div class="stat-count">{{ $jadwalCount }}</div>
                <div class="stat-label">Jadwal Pelajaran</div>
            </a>

            <a href="{{ route('admin.presensi.index') }}" class="stat-card sc-red span-2">
                <div class="stat-icon-wrap si-red">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4"/>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                </div>
                <div class="stat-count">{{ $presensiCount }}</div>
                <div class="stat-label">Total Presensi Tercatat</div>
            </a>

        </div>

        {{-- MANAGEMENT --}}
        <div class="section-title">Manajemen Data</div>

        <div class="mgmt-grid">

            <a href="{{ route('admin.siswa.index') }}" class="mgmt-card">
                <div class="mgmt-icon si-blue">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="mgmt-text">
                    <div class="mgmt-name">Data Siswa</div>
                    <div class="mgmt-desc">Kelola data & akun siswa</div>
                </div>
                <div class="mgmt-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </div>
            </a>

            <a href="{{ route('admin.guru.index') }}" class="mgmt-card">
                <div class="mgmt-icon si-teal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#2dd4bf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <div class="mgmt-text">
                    <div class="mgmt-name">Data Guru</div>
                    <div class="mgmt-desc">Kelola data & akun guru</div>
                </div>
                <div class="mgmt-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </div>
            </a>

            <a href="{{ route('admin.mapel.index') }}" class="mgmt-card">
                <div class="mgmt-icon si-violet">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <div class="mgmt-text">
                    <div class="mgmt-name">Mata Pelajaran</div>
                    <div class="mgmt-desc">Tambah & edit mapel</div>
                </div>
                <div class="mgmt-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </div>
            </a>

            <a href="{{ route('admin.jadwal.index') }}" class="mgmt-card">
                <div class="mgmt-icon si-yellow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="mgmt-text">
                    <div class="mgmt-name">Jadwal Pelajaran</div>
                    <div class="mgmt-desc">Atur jadwal per kelas & mapel</div>
                </div>
                <div class="mgmt-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </div>
            </a>

            <a href="{{ route('admin.presensi.index') }}" class="mgmt-card">
                <div class="mgmt-icon si-red">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 11 12 14 22 4"/>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                    </svg>
                </div>
                <div class="mgmt-text">
                    <div class="mgmt-name">Data Presensi</div>
                    <div class="mgmt-desc">Rekap & pantau kehadiran</div>
                </div>
                <div class="mgmt-chevron">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </div>
            </a>

            {{-- Empty slot filler agar grid simetris jika ganjil --}}
            <div style="background: rgba(255,255,255,.02); border: 1px dashed rgba(255,255,255,.06); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                <span style="font-size:12px; color: rgba(143,163,192,.3); letter-spacing:.4px;">— slot tersedia —</span>
            </div>

        </div>

        {{-- BOTTOM ROW --}}
        <div class="bottom-row">
            <div class="status-bar">
                <div class="status-dot"></div>
                <span class="status-text">Sistem aktif dan berjalan normal — Tahun Ajaran 2025/2026</span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

    </div>

    <footer>
        &copy; {{ date('Y') }} SMK — Sistem Presensi Digital Kelas XI SIJA 1 &amp; 2
    </footer>

</body>
</html>