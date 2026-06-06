<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIJA Presensi Digital — SMK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme-mode.css') }}">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* Variabel default dark mode — di body agar body.light-mode bisa override */
        body {
            --navy:      #0B1F3A;
            --navy-mid:  #132D52;
            --navy-soft: #1C3D6E;
            --gold:      #C9963C;
            --gold-lt:   #E8B455;
            --gold-dim:  #F5D9A0;
            --white:     #FAFAF8;
            --muted:     #8FA3C0;
            --border:    rgba(201,150,60,.25);
        }

        html, body { height: 100%; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            overflow-x: hidden;
        }

        /* ── BACKGROUND PATTERN ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 70% 10%, rgba(28,61,110,.7) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 10% 80%, rgba(201,150,60,.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* subtle grid lines */
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
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 3rem;
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(8px);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-logo {
            width: 40px;
            height: 40px;
            background: var(--gold);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 18px;
            color: var(--navy);
            flex-shrink: 0;
        }

        .nav-name {
            font-size: 15px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: .3px;
        }

        .nav-sub {
            font-size: 11px;
            color: var(--muted);
            margin-top: 1px;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-outline {
            padding: 8px 20px;
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-outline:hover {
            border-color: var(--gold);
            color: var(--gold-lt);
        }

        .btn-gold {
            padding: 8px 22px;
            background: var(--gold);
            border: 1px solid var(--gold);
            border-radius: 8px;
            color: var(--navy);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-gold:hover {
            background: var(--gold-lt);
            border-color: var(--gold-lt);
        }

        /* ── HERO ── */
        .hero {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            min-height: calc(100vh - 73px);
            padding: 4rem 3rem;
            gap: 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .hero-left {
            flex: 1;
            animation: fadeUp .8s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: rgba(201,150,60,.12);
            border: 1px solid rgba(201,150,60,.3);
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            color: var(--gold-lt);
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-bottom: 2rem;
        }

        .hero-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: .5; transform: scale(.7); }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.4rem, 5vw, 3.8rem);
            font-weight: 700;
            line-height: 1.12;
            color: var(--white);
            margin-bottom: 1.5rem;
        }

        .hero-title span {
            color: var(--gold);
        }

        .hero-desc {
            font-size: 16px;
            line-height: 1.8;
            color: var(--muted);
            max-width: 480px;
            margin-bottom: 2.5rem;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-hero {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            background: var(--gold);
            border-radius: 10px;
            color: var(--navy);
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s;
            letter-spacing: .2px;
        }

        .btn-hero:hover {
            background: var(--gold-lt);
            transform: translateY(-1px);
        }

        .btn-hero svg { transition: transform .2s; }
        .btn-hero:hover svg { transform: translateX(3px); }

        .hero-note {
            font-size: 13px;
            color: var(--muted);
        }

        /* ── STATS ROW ── */
        .stats-row {
            display: flex;
            gap: 2rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }

        .stat {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gold);
            line-height: 1;
        }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        /* ── HERO RIGHT — CARD PANEL ── */
        .hero-right {
            flex: 0 0 400px;
            animation: fadeUp .8s .2s ease both;
        }

        .feature-card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.09);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(16px);
        }

        .feature-card-title {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            margin-bottom: 1.5rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }

        .feature-item:last-child { border-bottom: none; }

        .feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .fi-gold  { background: rgba(201,150,60,.15); }
        .fi-blue  { background: rgba(56,139,253,.12); }
        .fi-teal  { background: rgba(45,212,191,.1); }
        .fi-coral { background: rgba(251,113,133,.1); }

        .feature-icon svg { width: 20px; height: 20px; }

        .feature-text strong {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 3px;
        }

        .feature-text span {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.5;
        }

        /* ── STATUS BAR ── */
        .status-bar {
            margin-top: 1.5rem;
            background: rgba(201,150,60,.08);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 16px;
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

        /* ── FOOTER ── */
        footer {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 1.5rem;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--muted);
        }

        @media (max-width: 768px) {
            nav { padding: 1.2rem 1.5rem; }
            .hero { flex-direction: column; padding: 2.5rem 1.5rem; gap: 2.5rem; min-height: auto; }
            .hero-right { flex: none; width: 100%; }
            .stats-row { gap: 1.5rem; }
        }

        /* ── LIGHT MODE — Warm Parchment ── */
        body.light-mode {
            --navy:      #F5F0E8;
            --navy-mid:  #EDE8DD;
            --navy-soft: #E4DDD1;
            --gold:      #A67C3D;
            --gold-lt:   #7A5A28;
            --gold-dim:  #C8A878;
            --white:     #2C2418;
            --muted:     #7A7060;
            --border:    rgba(166,124,61,.25);
            background: #F5F0E8 !important;
            color: #2C2418 !important;
        }

        body.light-mode::before {
            background: none !important;
        }

        body.light-mode::after {
            background-image:
                linear-gradient(rgba(166,124,61,.018) 1px, transparent 1px),
                linear-gradient(90deg, rgba(166,124,61,.018) 1px, transparent 1px) !important;
        }

        /* Navbar */
        body.light-mode nav {
            background: rgba(253,248,240,.96) !important;
            border-bottom-color: rgba(166,124,61,.22) !important;
            box-shadow: 0 1px 14px rgba(44,36,24,.07);
        }
        body.light-mode .nav-name { color: #2C2418 !important; }
        body.light-mode .nav-sub  { color: #7A7060 !important; }
        body.light-mode .nav-logo {
            background: linear-gradient(135deg, #A67C3D, #7A5A28) !important;
            color: #fff !important;
        }
        body.light-mode .btn-outline {
            border-color: rgba(166,124,61,.30) !important;
            color: #7A5A28 !important;
        }
        body.light-mode .btn-outline:hover {
            border-color: #A67C3D !important;
            color: #5A3E18 !important;
        }
        body.light-mode .btn-gold {
            background: #A67C3D !important;
            border-color: #A67C3D !important;
            color: #fff !important;
        }
        body.light-mode .btn-gold:hover {
            background: #7A5A28 !important;
        }

        /* Hero text */
        body.light-mode .hero-title    { color: #2C2418 !important; }
        body.light-mode .hero-title span { color: #A67C3D !important; }
        body.light-mode .hero-desc     { color: #7A7060 !important; }
        body.light-mode .hero-note     { color: #7A7060 !important; }
        body.light-mode .hero-badge {
            background: rgba(166,124,61,.10) !important;
            border-color: rgba(166,124,61,.28) !important;
            color: #7A5A28 !important;
        }
        body.light-mode .hero-badge::before { background: #A67C3D !important; }

        /* Stats */
        body.light-mode .stats-row { border-top-color: rgba(166,124,61,.22) !important; }
        body.light-mode .stat-num   { color: #A67C3D !important; }
        body.light-mode .stat-label { color: #7A7060 !important; }

        /* Feature card */
        body.light-mode .feature-card {
            background: rgba(253,250,244,.90) !important;
            border-color: rgba(166,124,61,.20) !important;
        }
        body.light-mode .feature-card-title { color: #7A7060 !important; }
        body.light-mode .feature-item {
            border-bottom-color: rgba(44,36,24,.08) !important;
        }
        body.light-mode .feature-text strong { color: #2C2418 !important; }
        body.light-mode .feature-text span   { color: #7A7060 !important; }
        body.light-mode .fi-gold { background: rgba(166,124,61,.12) !important; }
        body.light-mode .fi-blue { background: rgba(56,139,253,.10) !important; }
        body.light-mode .fi-teal { background: rgba(45,212,191,.08) !important; }
        body.light-mode .fi-coral{ background: rgba(251,113,133,.08) !important; }

        /* Status bar (feature card) */
        body.light-mode .status-bar {
            background: rgba(166,124,61,.06) !important;
            border-color: rgba(166,124,61,.20) !important;
        }
        body.light-mode .status-text { color: #7A5A28 !important; }

        /* Btn hero */
        body.light-mode .btn-hero {
            background: #A67C3D !important;
            color: #fff !important;
        }
        body.light-mode .btn-hero:hover { background: #7A5A28 !important; }

        /* Footer */
        body.light-mode footer {
            border-top-color: rgba(44,36,24,.12) !important;
            color: #7A7060 !important;
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

        <div class="nav-links">
            <div style="display:flex;align-items:center;gap:7px;">
                <label class="theme-switch" title="Ganti tema">
                    <input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode">
                    <span class="track"></span>
                    <span class="thumb"></span>
                </label>
                <span class="theme-label" style="font-size:12px;font-weight:500;color:var(--muted);min-width:30px;">Dark</span>
            </div>
            @auth
                @php 
                    $role = auth()->user()->role; 
                    if($role === 'admin') {
                        $dashRoute = route('admin.dashboard');
                        $dashText = 'Dashboard Admin';
                    } elseif(in_array($role, ['guru', 'walikelas', 'kakon'])) {
                        $dashRoute = route('guru.dashboard');
                        $dashText = 'Dashboard Guru';
                    } else {
                        $dashRoute = route('siswa.dashboard');
                        $dashText = 'Dashboard Siswa';
                    }
                @endphp
                <a href="{{ $dashRoute }}" class="btn-gold">{{ $dashText }}</a>
            @else
                <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
            @endauth
        </div>
    </nav>

    {{-- HERO --}}
    <div class="hero">
        <div class="hero-left">
            <div class="hero-badge">Tahun Ajaran 2025 / 2026</div>

            <h1 class="hero-title">
                Presensi Digital<br>
                Kelas <span>XI SIJA</span><br>
                yang Modern
            </h1>

            <p class="hero-desc">
                Platform presensi berbasis kode 4-digit acak untuk siswa kelas XI SIJA. Pantau kehadiran secara real-time, akurat, dan transparan — kapan saja, di mana saja.
            </p>

            <div class="hero-actions">
                @auth
                    @php 
                        $role = auth()->user()->role; 
                        if($role === 'admin') {
                            $dashRoute = route('admin.dashboard');
                        } elseif(in_array($role, ['guru', 'walikelas', 'kakon'])) {
                            $dashRoute = route('guru.dashboard');
                        } else {
                            $dashRoute = route('siswa.dashboard');
                        }
                    @endphp
                    <a href="{{ $dashRoute }}" class="btn-hero">
                        Ke Dashboard
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-hero">
                        Masuk ke Sistem
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endauth
                <span class="hero-note">Gunakan akun yang diberikan oleh sekolah</span>
            </div>

            <div class="stats-row">
                <div class="stat">
                    <span class="stat-num">2</span>
                    <span class="stat-label">Kelas SIJA</span>
                </div>
                <div class="stat">
                    <span class="stat-num">5</span>
                    <span class="stat-label">Role Pengguna</span>
                </div>
                <div class="stat">
                    <span class="stat-num">NUM</span>
                    <span class="stat-label">Token Presensi</span>
                </div>
            </div>
        </div>

        <div class="hero-right">
            <div class="feature-card">
                <p class="feature-card-title">Fitur Sistem</p>

                <div class="feature-item">
                    <div class="feature-icon fi-gold">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#C9963C" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                            <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
                        </svg>
                    </div>
                    <div class="feature-text">
                        <strong>Token 4-digit Presensi</strong>
                        <span>Guru generate token unik, siswa menginputkan token untuk absen secara real-time</span>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon fi-blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div class="feature-text">
                        <strong>Multi-Role Akses</strong>
                        <span>Admin, Guru, Wali Kelas, dan Kepala Konsentrasi dengan dashboard masing-masing</span>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon fi-teal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#2dd4bf" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                            <line x1="6" y1="20" x2="6" y2="14"/>
                        </svg>
                    </div>
                    <div class="feature-text">
                        <strong>Rekap & Monitoring</strong>
                        <span>Wali kelas pantau presensi kelasnya, kakon lihat seluruh data SIJA</span>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-icon fi-coral">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#fb7185" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <div class="feature-text">
                        <strong>Akun Terkelola</strong>
                        <span>Admin kelola akun guru dan siswa, nonaktifkan akun kapan saja</span>
                    </div>
                </div>

                <div class="status-bar">
                    <div class="status-dot"></div>
                    <span class="status-text">Sistem aktif dan berjalan normal</span>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} SMK — Sistem Presensi Digital Kelas XI SIJA 1 &amp; 2
    </footer>

    <script src="{{ asset('js/theme-mode.js') }}"></script>
</body>
</html>