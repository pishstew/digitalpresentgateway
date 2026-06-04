<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme-mode.css') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* Variabel default (dark mode) — HARUS di body bukan :root
           agar body.light-mode bisa override dengan specificity yang sama */
        body {
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

        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--navy); color: var(--white); min-height: 100vh; }
        body::before {
            content: ''; position: fixed; inset: 0; z-index: 0;
            background: radial-gradient(ellipse 70% 50% at 15% 10%, rgba(201,150,60,.07) 0%, transparent 55%),
                        radial-gradient(ellipse 50% 40% at 85% 85%, rgba(17,40,71,.8) 0%, transparent 60%);
        }
        /* Khusus body::before — hide sepenuhnya di light mode agar tidak ada layer gelap */
        body.light-mode::before {
            background: none !important;
        }
        body::after {
            content: ''; position: fixed; inset: 0; z-index: 0;
            background-image: linear-gradient(rgba(201,150,60,.035) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(201,150,60,.035) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .status-bar {
            height: 3px; background: linear-gradient(90deg, var(--gold), #a8782e, var(--gold));
            background-size: 200% 100%; animation: shimmer 3s infinite linear;
            position: relative; z-index: 10;
        }
        @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

        .navbar {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 16px; height: 56px;
            background: rgba(11,31,58,.92); backdrop-filter: blur(20px); /* light mode override ada di body.light-mode .navbar */
            border-bottom: 1px solid var(--gold-border);
        }
        .nav-brand { display: flex; align-items: center; gap: 9px; text-decoration: none; min-width: 0; }
        .nav-logo {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, var(--gold), #a8782e);
            border-radius: 7px; display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif; font-weight: 700; font-size: .95rem; color: var(--navy); flex-shrink: 0;
        }
        .nav-title { font-family: 'Playfair Display', serif; font-size: .95rem; color: var(--white); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .nav-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
        .btn-nav-link {
            display: flex; align-items: center; gap: 4px; padding: 6px 12px;
            background: var(--glass); border: 1px solid var(--gold-border); border-radius: 7px;
            color: var(--gold-light); text-decoration: none; font-size: .8rem; font-weight: 600;
            transition: all .2s; white-space: nowrap;
        }
        .btn-nav-link:hover { background: var(--glass-b); border-color: var(--gold); color: var(--gold); }
        .btn-logout {
            display: flex; align-items: center; gap: 4px; padding: 6px 12px;
            background: rgba(224,92,92,.1); border: 1px solid rgba(224,92,92,.25);
            border-radius: 7px; color: #f9a8a8; text-decoration: none;
            font-size: .8rem; font-weight: 600; cursor: pointer; transition: all .2s; white-space: nowrap;
        }
        .btn-logout:hover { background: rgba(224,92,92,.18); border-color: rgba(224,92,92,.45); }



        .page-wrap { position: relative; z-index: 1; max-width: 920px; margin: 0 auto; padding: 24px 16px 64px; }

        .greeting { margin-bottom: 24px; }
        .greeting-name { font-family: 'Playfair Display', serif; font-size: clamp(1.3rem, 5vw, 1.7rem); font-weight: 700; color: var(--white); line-height: 1.2; }
        .greeting-name span { color: var(--gold); }
        .greeting-sub { margin-top: 5px; color: var(--muted); font-size: .86rem; }

        .alert { display: flex; align-items: flex-start; gap: 10px; padding: 11px 15px; border-radius: 10px; font-size: .86rem; font-weight: 500; margin-bottom: 18px; line-height: 1.4; }
        .alert svg { flex-shrink: 0; margin-top: 1px; }
        .alert-success { background: rgba(76,175,138,.12); border: 1px solid rgba(76,175,138,.28); color: #7fe3b8; }
        .alert-error   { background: rgba(224,92,92,.12);  border: 1px solid rgba(224,92,92,.28);  color: #f9a8a8; }

        .dash-grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 16px; align-items: start; }

        .card { background: var(--glass); border: 1px solid var(--gold-border); border-radius: 14px; backdrop-filter: blur(14px); overflow: hidden; }
        .card-header { padding: 13px 18px; border-bottom: 1px solid var(--gold-border); background: rgba(201,150,60,.06); }
        .card-header h2 { font-family: 'Playfair Display', serif; font-size: .95rem; font-weight: 600; color: var(--gold-light); }
        .card-body { padding: 20px 20px; }

        .jadwal-list { display: flex; flex-direction: column; gap: 12px; }
        .jadwal-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; border-radius: 12px; border: 1px solid rgba(143,163,192,.15); background: rgba(255,255,255,.03); transition: all .2s; gap: 12px; }
        .jadwal-item.active-jadwal { border-color: var(--gold-border); background: rgba(201,150,60,.06); }
        .jadwal-item.done { border-color: rgba(76,175,138,.2); background: rgba(76,175,138,.04); }
        .jadwal-left { display: flex; align-items: center; gap: 14px; min-width: 0; flex: 1; }
        .jam-box {
            min-width: 48px; width: auto; height: auto;
            padding: 8px 10px;
            border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: .85rem; line-height: 1.3;
            flex-shrink: 0; white-space: nowrap; text-align: center;
        }
        .jam-box.pending { background: rgba(143,163,192,.12); color: var(--muted); }
        .jam-box.selesai { background: rgba(76,175,138,.14); color: #7fe3b8; }
        .jadwal-info { min-width: 0; }
        .jadwal-info h4 { font-size: .88rem; font-weight: 600; color: var(--white); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .jadwal-info p { font-size: .76rem; color: var(--muted); margin-top: 2px; }
        .jadwal-info .done-txt { color: #7fe3b8; font-weight: 600; }

        .btn-pilih { padding: 5px 12px; border-radius: 7px; font-size: .78rem; font-weight: 600; text-decoration: none; border: 1px solid; transition: all .2s; white-space: nowrap; flex-shrink: 0; }
        .btn-pilih.selected { background: var(--gold-dim); border-color: var(--gold-border); color: var(--gold-light); }
        .btn-pilih.unselected { background: var(--glass); border-color: rgba(143,163,192,.2); color: var(--muted); }
        .btn-pilih.unselected:hover { border-color: var(--gold-border); color: var(--gold-light); }
        .badge-done { padding: 4px 9px; background: rgba(76,175,138,.14); border: 1px solid rgba(76,175,138,.25); border-radius: 6px; font-size: .73rem; font-weight: 700; color: #7fe3b8; flex-shrink: 0; }

        .empty-state { text-align: center; padding: 36px 20px; color: var(--muted); }
        .empty-icon { font-size: 2rem; margin-bottom: 10px; }
        .empty-state p { font-size: .87rem; }

        .presensi-target { padding: 13px; background: rgba(201,150,60,.07); border: 1px solid var(--gold-border); border-radius: 10px; margin-bottom: 16px; text-align: center; }
        .presensi-target .target-label { font-size: .71rem; font-weight: 700; color: var(--muted); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 4px; }
        .presensi-target .target-mapel { font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 600; color: var(--white); line-height: 1.3; }
        .presensi-target .target-jam { display: inline-block; margin-top: 5px; padding: 3px 10px; background: var(--gold-dim); border: 1px solid var(--gold-border); border-radius: 20px; font-size: .73rem; font-weight: 700; color: var(--gold-light); }

        .token-card { border-radius: 16px; overflow: hidden; border: 1px solid var(--gold-border); background: var(--glass); }
        .token-header { background: rgba(11,31,58,.7); padding: 20px 24px; border-bottom: 1px solid rgba(255,255,255,.04); }
        .token-header h3 { font-size: 1.05rem; font-weight: 700; color: var(--white); margin-bottom: 6px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .token-header p { font-size: .88rem; color: var(--muted); }
        
        .token-body { padding: 28px 24px; background: rgba(255,255,255,.02); }
        .token-input-container { margin-bottom: 8px; }
        #token_input {
            width: 100%; padding: 20px; font-size: 2.8rem; text-align: center;
            letter-spacing: 0.5em; background: rgba(255,255,255,.03); border: 2px solid rgba(143,163,192,.25);
            border-radius: 12px; outline: none; color: var(--white); font-family: monospace; transition: all .2s;
            font-weight: 600; padding-left: calc(20px + 0.5em); /* balance letter spacing */
        }
        #token_input:focus { border-color: var(--gold); background: rgba(201,150,60,.04); box-shadow: 0 0 0 4px rgba(201,150,60,.12); }
        #token_input::placeholder { color: rgba(143,163,192,.15); letter-spacing: 0.5em; }
        
        .digit-count { text-align: center; font-size: .85rem; color: var(--muted); margin-bottom: 24px; font-weight: 500; }
        
        #submit_token_btn {
            width: 100%; padding: 16px; border: none; border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1rem; font-weight: 700;
            cursor: not-allowed; background: rgba(143,163,192,.12); color: rgba(255,255,255,.4); transition: all .3s;
        }
        #submit_token_btn.ready { background: linear-gradient(135deg, var(--gold), #a8782e); color: var(--navy); cursor: pointer; box-shadow: 0 6px 20px rgba(201,150,60,.25); }
        #submit_token_btn.ready:hover { filter: brightness(1.1); transform: translateY(-2px); }

        .all-done { text-align: center; padding: 28px 16px; }
        .all-done .done-icon { font-size: 2.2rem; margin-bottom: 10px; }
        .all-done h3 { font-family: 'Playfair Display', serif; font-size: 1.05rem; color: var(--white); margin-bottom: 5px; }
        .all-done p { font-size: .83rem; color: var(--muted); margin-bottom: 14px; line-height: 1.5; }
        .btn-riwayat { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; background: var(--gold-dim); border: 1px solid var(--gold-border); border-radius: 8px; color: var(--gold-light); text-decoration: none; font-size: .83rem; font-weight: 600; transition: all .2s; }
        .btn-riwayat:hover { background: rgba(201,150,60,.25); border-color: var(--gold); color: var(--gold); }

        @media (max-width: 680px) { .dash-grid { grid-template-columns: 1fr; } .card-presensi-wrapper { order: -1; } }
        @media (max-width: 400px) { .page-wrap { padding: 18px 12px 56px; } .navbar { padding: 0 12px; } .nav-title { display: none; } }

        /* ============================================================
           LIGHT MODE — Warm Parchment
           Override semua inline style & class spesifik di halaman ini
           ============================================================ */

        body.light-mode {
            --navy:        #F5F0E8;
            --gold:        #A67C3D;
            --gold-light:  #7A5A28;
            --gold-dim:    rgba(166,124,61,.13);
            --gold-border: rgba(166,124,61,.22);
            --muted:       #7A7060;
            --glass:       rgba(253,250,244,.85);
            --glass-b:     rgba(253,250,244,.95);
            --white:       #2C2418;
            --text-dim:    rgba(44,36,24,.72);
            background: #F5F0E8 !important;
            background-color: #F5F0E8 !important;
            color: #2C2418 !important;
        }

        /* Matikan pseudo-element grid pattern dark mode */
        /* body.light-mode::before sudah didefinisikan di atas dekat body::before */
        body.light-mode::after {
            background-image:
                linear-gradient(rgba(166,124,61,.018) 1px, transparent 1px),
                linear-gradient(90deg, rgba(166,124,61,.018) 1px, transparent 1px) !important;
            background-size: 40px 40px !important;
        }

        /* Navbar */
        body.light-mode .navbar {
            background: rgba(253,248,240,.96) !important;
            border-bottom: 1px solid rgba(166,124,61,.22) !important;
            box-shadow: 0 1px 14px rgba(44,36,24,.07) !important;
            backdrop-filter: blur(20px);
        }
        body.light-mode .nav-logo {
            background: linear-gradient(135deg, #A67C3D, #7A5A28) !important;
            color: #fff !important;
        }
        body.light-mode .nav-title { color: #2C2418 !important; }

        body.light-mode .btn-nav-link {
            background: rgba(166,124,61,.10) !important;
            border-color: rgba(166,124,61,.22) !important;
            color: #7A5A28 !important;
        }
        body.light-mode .btn-nav-link:hover {
            background: rgba(166,124,61,.18) !important;
            color: #5A3E18 !important;
        }
        body.light-mode .btn-logout {
            background: rgba(140,94,92,.10) !important;
            border-color: rgba(140,94,92,.22) !important;
            color: #7A3A38 !important;
        }
        body.light-mode .btn-logout:hover {
            background: rgba(140,94,92,.18) !important;
        }

        /* Greeting */
        body.light-mode .greeting-name { color: #2C2418 !important; }
        body.light-mode .greeting-name span { color: #A67C3D !important; }
        body.light-mode .greeting-sub { color: #7A7060 !important; }

        /* Cards */
        body.light-mode .card {
            background: rgba(253,250,244,.85) !important;
            border-color: rgba(166,124,61,.22) !important;
        }
        body.light-mode .card-header {
            background: rgba(166,124,61,.10) !important;
            border-bottom-color: rgba(166,124,61,.22) !important;
        }
        body.light-mode .card-header h2 { color: #7A5A28 !important; }

        /* Jadwal items */
        body.light-mode .jadwal-item {
            background: rgba(44,36,24,.03) !important;
            border-color: rgba(44,36,24,.10) !important;
        }
        body.light-mode .jadwal-item.active-jadwal {
            background: rgba(166,124,61,.08) !important;
            border-color: rgba(166,124,61,.28) !important;
        }
        body.light-mode .jadwal-item.done {
            background: rgba(94,110,74,.07) !important;
            border-color: rgba(94,110,74,.20) !important;
        }
        body.light-mode .jadwal-info h4 { color: #2C2418 !important; }
        body.light-mode .jadwal-info p { color: #7A7060 !important; }
        body.light-mode .jadwal-info .done-txt { color: #5E6E4A !important; }

        /* Jam box — pendek/selesai */
        body.light-mode .jam-box.pending {
            background: rgba(44,36,24,.10) !important;
            color: #7A7060 !important;
        }
        body.light-mode .jam-box.selesai {
            background: rgba(94,110,74,.15) !important;
            color: #5E6E4A !important;
        }

        /* Tombol pilih */
        body.light-mode .btn-pilih.selected {
            background: rgba(166,124,61,.13) !important;
            border-color: rgba(166,124,61,.28) !important;
            color: #7A5A28 !important;
        }
        body.light-mode .btn-pilih.unselected {
            background: rgba(44,36,24,.06) !important;
            border-color: rgba(44,36,24,.14) !important;
            color: #7A7060 !important;
        }
        body.light-mode .btn-pilih.unselected:hover {
            border-color: rgba(166,124,61,.30) !important;
            color: #7A5A28 !important;
        }

        /* Badge done / waktu habis / belum mulai */
        body.light-mode .badge-done {
            background: rgba(94,110,74,.14) !important;
            border-color: rgba(94,110,74,.25) !important;
            color: #5E6E4A !important;
        }
        /* Inline style override untuk badge Waktu Habis */
        body.light-mode span.badge-done[style*="e05c5c"],
        body.light-mode span.badge-done[style*="224,92,92"] {
            background: rgba(140,94,92,.12) !important;
            color: #7A3A38 !important;
            border-color: rgba(140,94,92,.22) !important;
        }
        /* Inline style override untuk badge Belum Mulai */
        body.light-mode span.badge-done[style*="fcd34d"],
        body.light-mode span.badge-done[style*="251,191,36"] {
            background: rgba(166,124,61,.13) !important;
            color: #7A5A28 !important;
            border-color: rgba(166,124,61,.25) !important;
        }

        /* Presensi target box (kanan atas) */
        body.light-mode .presensi-target {
            background: rgba(166,124,61,.08) !important;
            border-color: rgba(166,124,61,.22) !important;
        }
        body.light-mode .presensi-target .target-label { color: #7A7060 !important; }
        body.light-mode .presensi-target .target-mapel { color: #2C2418 !important; }
        body.light-mode .presensi-target .target-jam {
            background: rgba(166,124,61,.13) !important;
            border-color: rgba(166,124,61,.25) !important;
            color: #7A5A28 !important;
        }

        /* Token card — FIX UTAMA: hapus background biru gelap */
        body.light-mode .token-card {
            background: rgba(253,250,244,.90) !important;
            border-color: rgba(166,124,61,.22) !important;
        }
        body.light-mode .token-header {
            background: rgba(166,124,61,.08) !important;
            border-bottom: 1px solid rgba(166,124,61,.18) !important;
        }
        body.light-mode .token-header h3 { color: #2C2418 !important; }
        body.light-mode .token-header p  { color: #7A7060 !important; }
        body.light-mode .token-body {
            background: rgba(253,250,244,.60) !important;
        }

        /* Input token */
        body.light-mode #token_input {
            background: rgba(253,250,244,.95) !important;
            border-color: rgba(166,124,61,.28) !important;
            color: #2C2418 !important;
        }
        body.light-mode #token_input::placeholder { color: rgba(44,36,24,.20) !important; }
        body.light-mode #token_input:focus {
            border-color: #A67C3D !important;
            background: rgba(166,124,61,.05) !important;
            box-shadow: 0 0 0 4px rgba(166,124,61,.12) !important;
        }

        body.light-mode .digit-count { color: #7A7060 !important; }

        /* Submit button */
        body.light-mode #submit_token_btn {
            background: rgba(44,36,24,.10) !important;
            color: rgba(44,36,24,.35) !important;
        }
        body.light-mode #submit_token_btn.ready {
            background: linear-gradient(135deg, #A67C3D, #7A5A28) !important;
            color: #fff !important;
            box-shadow: 0 6px 20px rgba(166,124,61,.28) !important;
        }

        /* Alert */
        body.light-mode .alert-success {
            background: rgba(94,110,74,.10) !important;
            border-color: rgba(94,110,74,.28) !important;
            color: #4A5C38 !important;
        }
        body.light-mode .alert-error {
            background: rgba(140,94,92,.10) !important;
            border-color: rgba(140,94,92,.28) !important;
            color: #7A3A38 !important;
        }

        /* All-done state */
        body.light-mode .all-done h3 { color: #5E6E4A !important; }
        body.light-mode .all-done p  { color: #7A7060 !important; }
        body.light-mode .btn-riwayat {
            background: rgba(166,124,61,.12) !important;
            border-color: rgba(166,124,61,.25) !important;
            color: #7A5A28 !important;
        }
        body.light-mode .btn-riwayat:hover {
            background: rgba(166,124,61,.22) !important;
            color: #5A3E18 !important;
        }

        /* Status bar */
        body.light-mode .status-bar {
            background: linear-gradient(90deg, #A67C3D, #c8a060, #8B6020, #A67C3D) !important;
            background-size: 200% 100% !important;
        }

        /* Footer */
        body.light-mode footer {
            border-top-color: rgba(44,36,24,.10) !important;
            color: #7A7060 !important;
        }
        body.light-mode footer a { color: #A67C3D !important; }

        /* Disabled input (locked/not yet) */
        body.light-mode input[disabled] {
            background: rgba(44,36,24,.06) !important;
            border-color: rgba(44,36,24,.14) !important;
            color: #7A7060 !important;
        }

        /* Token card states — Terkunci & Belum Waktunya */
        body.light-mode .token-header h3[style*="f9a8a8"] {
            color: #7A3A38 !important;
        }
        body.light-mode .token-header h3[style*="fcd34d"] {
            color: #7A5A28 !important;
        }
    </style>
</head>
<body>

<div class="status-bar"></div>

<nav class="navbar">
    <a href="{{ route('siswa.dashboard') }}" class="nav-brand">
        <div class="nav-logo">S</div>
        <span class="nav-title">SchoolSystem</span>
    </a>
    <div class="nav-right">
        <div style="display:flex;align-items:center;gap:7px;"><label class="theme-switch" title="Ganti tema"><input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode"><span class="track"></span><span class="thumb"></span></label><span class="theme-label">Dark</span></div>
        <a href="{{ route('siswa.presensi.index') }}" class="btn-nav-link">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><rect x="1" y="1" width="11" height="11" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 6.5h5M4 4.5h5M4 8.5h3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
            Riwayat
        </a>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M8 2H10.5A1.5 1.5 0 0112 3.5v6A1.5 1.5 0 0110.5 11H8M5 9l3-3-3-3M8 6.5H1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Keluar
            </button>
        </form>

    </div>
</nav>



<div class="page-wrap">

    <div class="greeting">
        <h1 class="greeting-name">Halo, <span>{{ $siswa ? $siswa->nama_siswa : Auth::user()->name }}</span></h1>
        <p class="greeting-sub">Dashboard Siswa — Sistem Presensi Digital</p>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="6" stroke="#4caf8a" stroke-width="1.5"/><path d="M4.5 7l2 2 3-3" stroke="#4caf8a" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ $message }}
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-error">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="6" stroke="#e05c5c" stroke-width="1.5"/><path d="M7 4.5v3M7 9.5v.5" stroke="#e05c5c" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ $message }}
        </div>
    @endif

    <div class="dash-grid">
        <div class="card">
            <div class="card-header"><h2>Jadwal Hari Ini</h2></div>
            <div class="card-body">
                @if($jadwalHariIni->count() > 0)
                    <div class="jadwal-list">
                        @foreach($jadwalHariIni as $jadwal)
                            <div class="jadwal-item {{ $jadwal->sudah_absen ? 'done' : (($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'active-jadwal' : '') }}">
                                <div class="jadwal-left">
                                    <div class="jam-box {{ $jadwal->sudah_absen ? 'selesai' : 'pending' }}">{{ $jadwal->jam_ke }}</div>
                                    <div class="jadwal-info">
                                        <h4>{{ $jadwal->mapel->nama_mapel ?? 'Mapel' }}</h4>
                                        <div style="font-size: 0.75rem; color: var(--muted); margin-bottom: 4px;">{{ $jadwal->jam_mulai ?? '' }} - {{ $jadwal->jam_selesai ?? '' }}</div>
                                        <p>
                                            @if($jadwal->sudah_absen)
                                                <span class="done-txt">✓ Hadir {{ date('H:i', strtotime($jadwal->data_presensi->jam_masuk)) }}</span>
                                            @else
                                                <span>Belum presensi</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if(!$jadwal->sudah_absen)
                                    @if($jadwal->waktu_berakhir ?? false)
                                        <span class="badge-done" style="background: rgba(224,92,92,.15); color: #f9a8a8; border: 1px solid rgba(224,92,92,.3);">Waktu Habis</span>
                                    @elseif(!($jadwal->is_waktunya ?? true))
                                        <span class="badge-done" style="background: rgba(251,191,36,.15); color: #fcd34d; border: 1px solid rgba(251,191,36,.3);">Belum Mulai</span>
                                    @else
                                        <a href="?jadwal_id={{ $jadwal->kode_jam_pelajaran }}" class="btn-pilih {{ ($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'selected' : 'unselected' }}">
                                            {{ ($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'Dipilih' : 'Pilih' }}
                                        </a>
                                    @endif
                                @else
                                    <span class="badge-done">Selesai</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">🏖️</div>
                        <p>Tidak ada jadwal untuk hari ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card-presensi-wrapper">
            @if($activeJadwal)
                <div class="presensi-target">
                    <div class="target-label">Presensi Untuk</div>
                    <div class="target-mapel">{{ $activeJadwal->mapel->nama_mapel }}</div>
                    <span class="target-jam">Jam ke-{{ $activeJadwal->jam_ke }}</span>
                </div>
                @if($activeJadwal->is_waktunya ?? true)
                <form action="{{ route('siswa.presensi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kode_jam_pelajaran" value="{{ $activeJadwal->kode_jam_pelajaran }}">
                    <div class="card token-card">
                        <div class="token-header">
                            <h3>Masukkan Kode Absensi</h3>
                            <p>Masukkan kode 4 digit dari guru Anda</p>
                        </div>
                        <div class="token-body">
                            <div class="token-input-container">
                                <input type="text" name="token" id="token_input" maxlength="4" required placeholder="0000" inputmode="numeric" pattern="[0-9]*" autocomplete="off" oninput="updateTokenUI(this)">
                            </div>
                            <div class="digit-count" id="digit_count">0/4 digit</div>
                            <button type="submit" id="submit_token_btn" disabled>Submit Absensi</button>
                        </div>
                    </div>
                </form>
                @elseif($activeJadwal->waktu_berakhir ?? false)
                <div class="card token-card">
                    <div class="token-header">
                        <h3 style="color: #f9a8a8;">Presensi Terkunci</h3>
                        <p>Waktu presensi untuk mapel ini telah berakhir pada {{ $activeJadwal->jam_selesai }}</p>
                    </div>
                    <div class="token-body">
                        <div class="token-input-container" style="opacity: 0.5;">
                            <input type="text" disabled placeholder="----" style="width: 100%; padding: 20px; font-size: 2.8rem; text-align: center; letter-spacing: 0.5em; background: rgba(255,255,255,.03); border: 2px solid rgba(143,163,192,.15); border-radius: 12px; color: var(--muted); font-family: monospace; font-weight: 600; padding-left: calc(20px + 0.5em); cursor: not-allowed;">
                        </div>
                    </div>
                </div>
                @else
                <div class="card token-card">
                    <div class="token-header">
                        <h3 style="color: #fcd34d;">Belum Waktunya</h3>
                        <p>Presensi untuk mapel ini baru akan dibuka pada {{ $activeJadwal->jam_mulai }}</p>
                    </div>
                    <div class="token-body">
                        <div class="token-input-container" style="opacity: 0.5;">
                            <input type="text" disabled placeholder="----" style="width: 100%; padding: 20px; font-size: 2.8rem; text-align: center; letter-spacing: 0.5em; background: rgba(255,255,255,.03); border: 2px solid rgba(143,163,192,.15); border-radius: 12px; color: var(--muted); font-family: monospace; font-weight: 600; padding-left: calc(20px + 0.5em); cursor: not-allowed;">
                        </div>
                    </div>
                </div>
                @endif
            @else
                <div class="card token-card">
                    <div class="token-header">
                        <h3>Masukkan Kode Absensi</h3>
                        <p>Tidak ada presensi aktif saat ini</p>
                    </div>
                    <div class="token-body">
                        <div class="token-input-container" style="opacity: 0.5;">
                            <input type="text" disabled placeholder="0000" style="width: 100%; padding: 20px; font-size: 2.8rem; text-align: center; letter-spacing: 0.5em; background: rgba(255,255,255,.03); border: 2px solid rgba(143,163,192,.15); border-radius: 12px; color: var(--muted); font-family: monospace; font-weight: 600; padding-left: calc(20px + 0.5em); cursor: not-allowed;">
                        </div>
                        <div class="all-done" style="padding-top: 10px;">
                            <div class="done-icon">🎉</div>
                            <h3 style="color: #7fe3b8;">Semua Selesai!</h3>
                            <p>Anda telah menyelesaikan semua presensi untuk hari ini.</p>
                            <a href="{{ route('siswa.presensi.index') }}" class="btn-riwayat">
                                <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><rect x="1" y="1" width="11" height="11" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 6.5h5M4 4.5h5M4 8.5h3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                                Lihat Riwayat
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function updateTokenUI(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    const btn = document.getElementById('submit_token_btn');
    const count = document.getElementById('digit_count');
    const len = input.value.length;
    
    if (count) count.innerText = len + '/4 digit';
    
    if (len === 4) { btn.disabled = false; btn.classList.add('ready'); }
    else { btn.disabled = true; btn.classList.remove('ready'); }
}

</script>
<footer style="position: relative; z-index: 2; text-align: center; padding: 1.5rem; border-top: 1px solid rgba(255,255,255,.07); font-size: 12px; color: var(--muted); margin-top: auto;">
    &copy; {{ date('Y') }} Dibuat oleh ONEJAY TEAM &mdash; <a href="{{ url('/about') }}" style="color: var(--gold-lt); text-decoration: none; font-weight: 600;">Tentang Kami | About Us</a>
</footer>

<script src="{{ asset('js/theme-mode.js') }}"></script>
</body>
</html>