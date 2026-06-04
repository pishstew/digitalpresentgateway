<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Mengajar</title>
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
            --text-dim:    rgba(255,255,255,.80);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            min-height: 100vh;
            font-size: 16px;
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
        .nav-title { font-family: 'Playfair Display', serif; font-size: 1rem; color: var(--white); }
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
            max-width: 820px;
            margin: 0 auto;
            padding: 28px 18px 72px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.4rem, 4vw, 1.85rem);
            font-weight: 700; color: var(--white);
            margin-bottom: 4px;
        }
        .page-title span { color: var(--gold); }
        .page-sub { color: var(--muted); font-size: .9rem; margin-bottom: 24px; }

        /* Info guru strip */
        .guru-strip {
            display: flex; align-items: center; gap: 14px;
            padding: 16px 20px;
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 12px;
            backdrop-filter: blur(14px);
            margin-bottom: 22px;
        }
        .guru-avatar {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; flex-shrink: 0;
        }
        .guru-name { font-size: 1rem; font-weight: 700; color: var(--white); margin-bottom: 3px; }
        .guru-meta { font-size: .84rem; color: var(--muted); }

        /* ── TABS HARI ────────────────────────────── */
        .hari-tabs {
            display: flex; gap: 8px;
            overflow-x: auto; padding-bottom: 4px;
            margin-bottom: 20px;
            scrollbar-width: none;
        }
        .hari-tabs::-webkit-scrollbar { display: none; }
        .hari-tab {
            padding: 10px 20px;
            border-radius: 9px;
            font-size: .9rem; font-weight: 700;
            cursor: pointer; border: 1px solid var(--gold-border);
            background: var(--glass);
            color: var(--muted);
            transition: all .2s; white-space: nowrap;
            flex-shrink: 0;
        }
        .hari-tab:hover { background: var(--glass-b); color: var(--gold-light); }
        .hari-tab.active { background: var(--gold-dim); border-color: var(--gold); color: var(--gold-light); }
        .hari-tab.today {
            border-color: rgba(76,175,138,.5);
            position: relative;
        }
        .hari-tab.today::after {
            content: '';
            position: absolute; bottom: 6px; right: 7px;
            width: 5px; height: 5px; border-radius: 50%;
            background: #7fe3b8;
        }

        /* ── JADWAL SECTION ──────────────────────── */
        .hari-section { display: none; }
        .hari-section.active { display: block; }
        .show-all .hari-section { display: block !important; }

        /* Card hari */
        .hari-card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 14px;
            backdrop-filter: blur(14px);
            overflow: hidden;
            margin-bottom: 16px;
        }
        .hari-card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--gold-border);
            display: flex; align-items: center; gap: 10px;
        }
        /* Warna aksen tiap hari */
        .hari-card-header.senin  { background: rgba(201,150,60,.08); }
        .hari-card-header.selasa { background: rgba(96,165,250,.08); }
        .hari-card-header.rabu   { background: rgba(76,175,138,.08); }
        .hari-card-header.kamis  { background: rgba(251,191,36,.08); }
        .hari-card-header.jumat  { background: rgba(167,139,250,.08); }

        .hari-label {
            font-family: 'Playfair Display', serif;
            font-size: 1.02rem; font-weight: 700; color: var(--gold-light);
        }
        .hari-today-badge {
            padding: 3px 10px;
            background: rgba(76,175,138,.15);
            border: 1px solid rgba(76,175,138,.3);
            border-radius: 20px;
            font-size: .74rem; font-weight: 700;
            color: #7fe3b8;
        }
        .hari-count {
            margin-left: auto;
            font-size: .8rem; color: var(--muted);
        }

        /* Jadwal item */
        .jadwal-list { padding: 14px 16px; display: flex; flex-direction: column; gap: 11px; }
        .jadwal-item {
            display: flex; align-items: center; gap: 16px;
            padding: 16px;
            border-radius: 10px;
            border: 1px solid rgba(143,163,192,.13);
            background: rgba(255,255,255,.03);
            transition: all .2s;
        }
        .jadwal-item:hover {
            border-color: var(--gold-border);
            background: rgba(201,150,60,.04);
        }

        /* Jam ke badge */
        .jam-badge {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border-radius: 10px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .jam-num { font-size: 1.5rem; font-weight: 800; color: var(--navy); line-height: 1; }
        .jam-lbl { font-size: .6rem; font-weight: 700; color: rgba(11,31,58,.65); margin-top: 2px; letter-spacing: .04em; }

        .jadwal-detail { flex: 1; min-width: 0; }
        .jadwal-mapel {
            font-size: 1rem; font-weight: 700; color: var(--white);
            margin-bottom: 5px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .jadwal-meta {
            display: flex; gap: 14px; flex-wrap: wrap;
            font-size: .83rem; color: var(--muted);
        }
        .jadwal-meta span { display: flex; align-items: center; gap: 4px; }

        .kelas-badge {
            padding: 5px 14px;
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            border-radius: 20px;
            font-size: .83rem; font-weight: 700;
            color: var(--gold-light);
            flex-shrink: 0;
        }

        /* Empty state */
        .empty-state { text-align: center; padding: 56px 20px; color: var(--muted); }
        .empty-icon  { font-size: 3rem; margin-bottom: 14px; }
        .empty-state p { font-size: .95rem; }

        /* ── RESPONSIVE ──────────────────────────── */
        @media (max-width: 560px) {
            .jadwal-item { flex-wrap: wrap; gap: 12px; }
            .kelas-badge { order: -1; }
            .jam-badge   { width: 50px; height: 50px; }
            .jam-num     { font-size: 1.3rem; }
        }
        @media (max-width: 400px) {
            .page-wrap { padding: 18px 13px 56px; }
            .navbar    { padding: 0 13px; height: 56px; }
            .nav-title { font-size: .9rem; }
            .hari-tab  { padding: 9px 14px; font-size: .85rem; }
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
    <div style="display:flex;align-items:center;gap:7px;margin-left:auto;"><label class="theme-switch" title="Ganti tema"><input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode"><span class="track"></span><span class="thumb"></span></label><span class="theme-label">Dark</span></div>
</nav>

<div class="page-wrap">

    <h1 class="page-title">Jadwal <span>Mengajar</span></h1>
    <p class="page-sub">Daftar sesi mengajar per minggu</p>

    <!-- Info Guru -->
    <div class="guru-strip">
        <div class="guru-avatar">👨‍🏫</div>
        <div>
            <div class="guru-name">{{ $guru->nama_guru ?? auth()->user()->name }}</div>
            <div class="guru-meta">NIP: {{ $guru->nip ?? '-' }} &nbsp;·&nbsp; {{ $jadwalPerHari->sum(fn($j) => $j->count()) }} sesi per minggu</div>
        </div>
    </div>

    @if($jadwalPerHari->isEmpty())
        <div class="hari-card">
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>Belum ada jadwal mengajar terdaftar</p>
            </div>
        </div>

    @else
        @php
            $hariKeys   = $jadwalPerHari->keys()->toArray();
            $activeHari = in_array($hariIni, $hariKeys) ? $hariIni : $hariKeys[0];
            $emojiMap   = ['Senin'=>'☀️','Selasa'=>'🔥','Rabu'=>'🌿','Kamis'=>'⚡','Jumat'=>'🌟'];
            $colorMap   = ['Senin'=>'senin','Selasa'=>'selasa','Rabu'=>'rabu','Kamis'=>'kamis','Jumat'=>'jumat'];
        @endphp

        <!-- Tab Hari -->
        <div class="hari-tabs" id="hariTabs">
            <button class="hari-tab" onclick="showSemua()" id="tab-semua">
                Semua
            </button>
            @foreach($jadwalPerHari as $hari => $items)
                <button
                    class="hari-tab {{ $hari === $activeHari ? 'active' : '' }} {{ $hari === $hariIni ? 'today' : '' }}"
                    onclick="showHari('{{ $hari }}')"
                    id="tab-{{ $hari }}"
                >
                    {{ $emojiMap[$hari] ?? '' }} {{ $hari }}
                </button>
            @endforeach
        </div>

        <!-- Jadwal per Hari -->
        <div id="jadwalContainer">
            @foreach($jadwalPerHari as $hari => $items)
                <div class="hari-section {{ $hari === $activeHari ? 'active' : '' }}" id="section-{{ $hari }}">
                    <div class="hari-card">
                        <div class="hari-card-header {{ $colorMap[$hari] ?? 'senin' }}">
                            <span style="font-size:1.2rem;">{{ $emojiMap[$hari] ?? '📅' }}</span>
                            <span class="hari-label">{{ $hari }}</span>
                            @if($hari === $hariIni)
                                <span class="hari-today-badge">Hari ini</span>
                            @endif
                            <span class="hari-count">{{ $items->count() }} sesi</span>
                        </div>
                        <div class="jadwal-list">
                            @foreach($items as $j)
                                <div class="jadwal-item">
                                    <div class="jam-badge">
                                        <div class="jam-num">{{ $j->jam_ke }}</div>
                                        <div class="jam-lbl">JAM KE</div>
                                    </div>
                                    <div class="jadwal-detail">
                                        <div class="jadwal-mapel">{{ $j->mapel->nama_mapel ?? $j->kode_mapel }}</div>
                                        <div class="jadwal-meta">
                                            <span>
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><rect x="1" y="2" width="10" height="9" rx="1.5" stroke="currentColor" stroke-width="1.3"/><path d="M1 5h10" stroke="currentColor" stroke-width="1.3"/><path d="M4 1v2M8 1v2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                                                Kelas {{ $j->kelas }}
                                            </span>
                                            <span>
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><circle cx="6" cy="6" r="5" stroke="currentColor" stroke-width="1.3"/><path d="M6 3.5v3l2 1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                                                Kode: {{ $j->kode_jam_pelajaran }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="kelas-badge">{{ $j->kelas }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

<script>
    function showHari(hari) {
        document.getElementById('jadwalContainer').classList.remove('show-all');
        document.querySelectorAll('.hari-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.hari-tab').forEach(t => t.classList.remove('active'));
        const section = document.getElementById('section-' + hari);
        const tab     = document.getElementById('tab-' + hari);
        if (section) section.classList.add('active');
        if (tab)     tab.classList.add('active');
    }
    function showSemua() {
        document.getElementById('jadwalContainer').classList.add('show-all');
        document.querySelectorAll('.hari-tab').forEach(t => t.classList.remove('active'));
        document.getElementById('tab-semua').classList.add('active');
    }
</script>

<script src="{{ asset('js/theme-mode.js') }}"></script>
</body>
</html>