<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
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
            animation: barShimmer 3s infinite linear;
            position: relative; z-index: 10;
        }
        @keyframes barShimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

        /* ── NAVBAR ── */
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



        /* ── LAYOUT ── */
        .page-wrap {
            position: relative; z-index: 1;
            max-width: 600px;
            margin: 0 auto;
            padding: 28px 18px 72px;
        }

        .greeting { margin-bottom: 24px; }
        .greeting-name {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.3rem, 5vw, 1.75rem);
            font-weight: 700; color: var(--white); line-height: 1.2;
        }
        .greeting-name span { color: var(--gold); }
        .greeting-sub { margin-top: 5px; color: var(--muted); font-size: .88rem; }

        .alert {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 13px 17px; border-radius: 10px;
            font-size: .9rem; font-weight: 500;
            margin-bottom: 16px; line-height: 1.4;
        }
        .alert svg { flex-shrink: 0; margin-top: 1px; }
        .alert-ok  { background: rgba(76,175,138,.12); border: 1px solid rgba(76,175,138,.28); color: #7fe3b8; }
        .alert-err { background: rgba(224,92,92,.12);  border: 1px solid rgba(224,92,92,.28);  color: #f9a8a8; }

        .card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 14px;
            backdrop-filter: blur(14px);
            overflow: hidden;
            margin-bottom: 16px;
        }
        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--gold-border);
            background: rgba(201,150,60,.06);
        }
        .card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; font-weight: 600;
            color: var(--gold-light);
        }
        .card-body { padding: 20px; }

        .btn-role-switch {
            display: flex; align-items: center; gap: 14px;
            padding: 16px; border-radius: 10px;
            text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600; font-size: .95rem;
            border: none; width: 100%; cursor: pointer; transition: all .25s;
        }
        .btn-role-switch:hover { transform: translateY(-1px); text-decoration: none; }
        .role-icon {
            width: 42px; height: 42px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; flex-shrink: 0;
            background: rgba(255,255,255,.15);
        }
        .role-text { display: flex; flex-direction: column; text-align: left; }
        .role-label { font-size: .74rem; font-weight: 500; opacity: .75; }
        .role-name  { font-size: .97rem; font-weight: 700; }
        .role-arrow { margin-left: auto; font-size: 1.2rem; opacity: .6; }
        .btn-walikelas { background: linear-gradient(135deg, #7c3aed, #6d28d9); color: white; box-shadow: 0 4px 14px rgba(124,58,237,.28); }
        .btn-walikelas:hover { box-shadow: 0 6px 18px rgba(124,58,237,.4); color: white; }
        .btn-kakon { background: linear-gradient(135deg, #0891b2, #0e7490); color: white; box-shadow: 0 4px 14px rgba(8,145,178,.28); }
        .btn-kakon:hover { box-shadow: 0 6px 18px rgba(8,145,178,.4); color: white; }

        .token-display {
            background: linear-gradient(135deg, rgba(201,150,60,.15), rgba(168,120,46,.10));
            border: 1px solid var(--gold-border); border-radius: 12px;
            padding: 28px 20px 22px; text-align: center; margin-bottom: 18px;
            position: relative; overflow: hidden;
        }
        .token-display::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(201,150,60,.12), transparent 70%);
        }
        .token-code-big {
            font-family: 'Courier New', monospace;
            font-size: clamp(3rem, 12vw, 4.5rem); font-weight: 800;
            color: var(--gold-light); letter-spacing: clamp(.6rem, 3vw, 1.2rem);
            line-height: 1; position: relative; z-index: 1;
            text-shadow: 0 0 30px rgba(201,150,60,.4);
        }
        .token-hint { margin-top: 10px; font-size: .8rem; color: var(--muted); position: relative; z-index: 1; }

        .status-pill {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 6px 14px; border-radius: 20px;
            font-size: .83rem; font-weight: 600; margin-bottom: 16px;
        }
        .pill-dot { width: 8px; height: 8px; border-radius: 50%; animation: pulseDot 1.5s infinite; }
        @keyframes pulseDot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.35)} }
        .pill-active   { background: rgba(76,175,138,.14); border: 1px solid rgba(76,175,138,.28); color: #7fe3b8; }
        .pill-warning  { background: rgba(251,191,36,.14);  border: 1px solid rgba(251,191,36,.28);  color: #fcd34d; }
        .pill-critical { background: rgba(224,92,92,.14);   border: 1px solid rgba(224,92,92,.28);   color: #f9a8a8; }

        .countdown-wrap {
            background: rgba(255,255,255,.04); border: 1px solid rgba(143,163,192,.12);
            border-radius: 10px; padding: 16px 18px; margin-bottom: 16px;
        }
        .flip-timer { display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 14px; }
        .flip-unit { display: flex; flex-direction: column; align-items: center; gap: 5px; }
        .flip-num {
            background: rgba(11,31,58,.7); border: 1px solid var(--gold-border);
            color: var(--gold-light); font-size: clamp(1.8rem, 6vw, 2.4rem); font-weight: 800;
            font-family: 'Courier New', monospace;
            width: clamp(60px, 15vw, 72px); height: clamp(64px, 16vw, 78px);
            display: flex; align-items: center; justify-content: center;
            border-radius: 10px; position: relative; transition: color .3s;
        }
        .flip-num::after { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: rgba(201,150,60,.2); }
        .flip-label { font-size: .7rem; font-weight: 700; color: var(--muted); letter-spacing: .05em; text-transform: uppercase; }
        .flip-sep { font-size: 2rem; font-weight: 800; color: var(--gold); margin-bottom: 20px; opacity: .7; }

        .progress-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 7px; }
        .progress-pct    { font-size: .83rem; font-weight: 700; color: var(--text-dim); }
        .progress-status { font-size: .78rem; color: var(--muted); }
        .progress-track  { background: rgba(143,163,192,.15); border-radius: 100px; height: 10px; overflow: hidden; }
        .progress-fill {
            height: 100%; border-radius: 100px;
            background: linear-gradient(90deg, var(--gold), #a8782e);
            transition: width 1s linear, background .5s ease;
            position: relative; overflow: hidden;
        }
        .progress-fill::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.25), transparent);
            animation: progressShimmer 2s infinite;
        }
        @keyframes progressShimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(200%)} }

        .expired-overlay { display: none; text-align: center; padding: 14px 0 6px; color: #f9a8a8; font-weight: 700; font-size: .95rem; }

        .info-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 0; border-bottom: 1px solid rgba(143,163,192,.09); font-size: .92rem;
        }
        .info-row:last-child { border-bottom: none; }
        .info-key { color: var(--muted); font-weight: 500; }
        .info-val { font-weight: 700; color: var(--white); text-align: right; }

        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-label { font-size: .78rem; font-weight: 700; color: var(--muted); letter-spacing: .06em; text-transform: uppercase; }
        .form-select {
            padding: 13px 15px; background: rgba(255,255,255,.07);
            border: 1px solid rgba(143,163,192,.25); border-radius: 9px;
            color: var(--white); font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .95rem; outline: none; appearance: none; cursor: pointer;
            transition: all .2s; width: 100%; margin-bottom: 4px;
        }
        .form-select:focus { border-color: var(--gold); background: rgba(201,150,60,.07); }
        .form-select option { background: #112847; color: var(--white); }

        .btn-generate {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, #3d8c5f, #2e6b49);
            color: white; border: none; border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1rem; font-weight: 700; cursor: pointer; transition: all .25s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-generate:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(61,140,95,.3); }
        .btn-generate:disabled { opacity: .45; cursor: not-allowed; transform: none; box-shadow: none; }

        .btn-selesai {
            width: 100%; padding: 15px;
            background: rgba(224,92,92,.12); color: #f9a8a8;
            border: 1.5px solid rgba(224,92,92,.35); border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1rem; font-weight: 700; cursor: pointer; transition: all .25s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 12px;
        }
        .btn-selesai:hover { background: rgba(224,92,92,.22); border-color: rgba(224,92,92,.55); }

        .btn-logout-nav {
            display: flex; align-items: center; gap: 5px;
            padding: 8px 14px;
            background: rgba(224,92,92,.1);
            border: 1px solid rgba(224,92,92,.25);
            border-radius: 7px; color: #f9a8a8;
            font-size: .82rem; font-weight: 600;
            cursor: pointer; transition: all .2s;
        }
        .btn-logout-nav:hover { background: rgba(224,92,92,.18); }

        .menu-item {
            display: flex; align-items: center; gap: 14px; padding: 16px 18px;
            text-decoration: none; color: var(--text-dim);
            font-weight: 600; font-size: .97rem;
            border-bottom: 1px solid rgba(143,163,192,.09); transition: all .2s;
        }
        .menu-item:last-child { border-bottom: none; }
        .menu-item:hover { background: rgba(255,255,255,.04); color: var(--gold-light); text-decoration: none; }
        .menu-icon { width: 40px; height: 40px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .menu-icon-blue  { background: rgba(96,165,250,.12); }
        .menu-icon-green { background: rgba(76,175,138,.12); }
        .menu-arrow { margin-left: auto; color: var(--muted); font-size: 1.1rem; }

        .nav-right-group { display: flex; align-items: center; gap: 10px; }

        @media (max-width: 400px) {
            .page-wrap { padding: 18px 13px 56px; }
            .navbar { padding: 0 13px; height: 56px; }
            .nav-title { font-size: .9rem; }
        }
    </style>

</head>
<body>

@php $role = auth()->user()->role; @endphp

<div class="status-bar"></div>

<nav class="navbar">
    <a href="#" class="nav-brand">
        <div class="nav-logo">S</div>
        <span class="nav-title">SchoolSystem</span>
    </a>
    <div class="nav-right-group">
        @include('layouts.theme-switch')
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout-nav">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M8 2H10.5A1.5 1.5 0 0112 3.5v6A1.5 1.5 0 0110.5 11H8M5 9l3-3-3-3M8 6.5H1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Keluar
            </button>
        </form>

    </div>
</nav>



<div class="page-wrap">

    <div class="greeting">
        <h1 class="greeting-name">
            Halo, <span>{{ $guru->nama_guru ?? auth()->user()->name }}</span>
        </h1>
        <p class="greeting-sub">
            Dashboard Guru
            @if($role === 'walikelas') · Wali Kelas {{ auth()->user()->kelas_wali }}
            @elseif($role === 'kakon') · Kepala Konsentrasi
            @endif
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-ok">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="#4caf8a" stroke-width="1.5"/><path d="M5 8l2.5 2.5 4-4" stroke="#4caf8a" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-err">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="#e05c5c" stroke-width="1.5"/><path d="M8 5v4M8 11v.5" stroke="#e05c5c" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    @if($role === 'walikelas')
    <div class="card">
        <div class="card-header"><h2>Akses Dashboard Lain</h2></div>
        <div class="card-body" style="padding:14px;">
            <a href="{{ route('walikelas.dashboard') }}" class="btn-role-switch btn-walikelas">
                <div class="role-icon">🎓</div>
                <div class="role-text">
                    <span class="role-label">Buka Dashboard</span>
                    <span class="role-name">Wali Kelas {{ auth()->user()->kelas_wali }}</span>
                </div>
                <span class="role-arrow">›</span>
            </a>
        </div>
    </div>
    @elseif($role === 'kakon')
    <div class="card">
        <div class="card-header"><h2>Akses Dashboard Lain</h2></div>
        <div class="card-body" style="padding:14px;">
            <a href="{{ route('kakon.dashboard') }}" class="btn-role-switch btn-kakon">
                <div class="role-icon">🏫</div>
                <div class="role-text">
                    <span class="role-label">Buka Dashboard</span>
                    <span class="role-name">Kepala Konsentrasi</span>
                </div>
                <span class="role-arrow">›</span>
            </a>
        </div>
    </div>
    @endif

    @if($tokenAktif)
    <div class="card">
        <div class="card-header"><h2>Kode Presensi Aktif</h2></div>
        <div class="card-body">
            <div class="token-display">
                <div class="token-code-big" id="tokenCode">{{ $tokenAktif }}</div>
                <div class="token-hint">Tunjukkan kode ini ke siswa</div>
            </div>
            <div style="text-align:center; margin-bottom:16px;">
                <span class="status-pill pill-active" id="statusPill">
                    <span class="pill-dot" id="pillDot" style="background:#4caf8a;"></span>
                    <span id="statusText">Aktif</span>
                </span>
            </div>
            <div class="countdown-wrap">
                <div class="flip-timer">
                    <div class="flip-unit">
                        <div class="flip-num" id="flipMenit">05</div>
                        <div class="flip-label">Menit</div>
                    </div>
                    <div class="flip-sep">:</div>
                    <div class="flip-unit">
                        <div class="flip-num" id="flipDetik">00</div>
                        <div class="flip-label">Detik</div>
                    </div>
                </div>
                <div class="progress-header">
                    <span class="progress-pct" id="progressPct">100%</span>
                    <span class="progress-status" id="progressStatus">Sisa waktu presensi</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" id="progressFill" style="width:100%"></div>
                </div>
            </div>
            <div class="expired-overlay" id="expiredMsg">⏰ Kode telah kedaluwarsa — halaman akan dimuat ulang...</div>
            @php
                $jadwalAktifData = \App\Models\JadwalPelajaran::with('mapel')->where('kode_jam_pelajaran', $jadwalAktif)->first();
            @endphp
            @if($jadwalAktifData)
            <div style="margin-top:18px; margin-bottom:18px;">
                <div class="info-row"><span class="info-key">Kelas</span><span class="info-val">{{ $jadwalAktifData->kelas }}</span></div>
                <div class="info-row"><span class="info-key">Mata Pelajaran</span><span class="info-val">{{ $jadwalAktifData->mapel->nama_mapel ?? '-' }}</span></div>
                <div class="info-row"><span class="info-key">Hari</span><span class="info-val">{{ $jadwalAktifData->hari }}</span></div>
                <div class="info-row"><span class="info-key">Jam Ke</span><span class="info-val">{{ $jadwalAktifData->jam_ke }}</span></div>
            </div>
            @endif
            <form method="POST" action="{{ route('guru.presensi.selesaikan') }}">
                @csrf
                <button type="submit" class="btn-selesai">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M5.5 8l2 2 3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Selesaikan Presensi
                </button>
            </form>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-header"><h2>Generate Kode Absensi</h2></div>
        <div class="card-body">
            <form method="POST" action="{{ route('guru.token.generate') }}">
                @csrf
                <div class="form-group" style="margin-bottom:16px;">
                    <label class="form-label" for="jadwal_id">Pilih Kelas &amp; Jadwal</label>
                    <select name="jadwal_id" id="jadwal_id" class="form-select" required>
                        <option value="" disabled selected>— Pilih Kelas —</option>
                        @forelse($jadwals as $j)
                            <option value="{{ $j->kode_jam_pelajaran }}">
                                {{ $j->kelas }} — {{ $j->mapel->nama_mapel ?? $j->kode_mapel }}
                                ({{ $j->hari }}, Jam ke-{{ $j->jam_ke }})
                            </option>
                        @empty
                            <option value="" disabled>Belum ada jadwal terdaftar</option>
                        @endforelse
                    </select>
                </div>
                <button type="submit" class="btn-generate" @if($jadwals->isEmpty()) disabled @endif>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="2" y="2" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M8 5v6M5 8h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Generate Kode Absensi
                </button>
            </form>
        </div>
    </div>
    @endif

    <div class="card">
        <a href="{{ route('guru.presensi.index') }}" class="menu-item">
            <div class="menu-icon menu-icon-blue">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><rect x="1.5" y="1.5" width="15" height="15" rx="2.5" stroke="#93c5fd" stroke-width="1.5"/><path d="M5 6h8M5 9h8M5 12h5" stroke="#93c5fd" stroke-width="1.3" stroke-linecap="round"/></svg>
            </div>
            <span>Kelola Presensi Siswa</span>
            <span class="menu-arrow">›</span>
        </a>
        <a href="{{ route('guru.jadwal.index') }}" class="menu-item">
            <div class="menu-icon menu-icon-green">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><rect x="1.5" y="2.5" width="15" height="13" rx="2" stroke="#7fe3b8" stroke-width="1.5"/><path d="M1.5 7h15" stroke="#7fe3b8" stroke-width="1.3"/><path d="M6 1.5v2M12 1.5v2" stroke="#7fe3b8" stroke-width="1.3" stroke-linecap="round"/></svg>
            </div>
            <span>Jadwal Mengajar Saya</span>
            <span class="menu-arrow">›</span>
        </a>
    </div>

</div>

@if($tokenAktif && $tokenExpiry)
<script>
    const expiryTime = new Date("{{ $tokenExpiry }}").getTime();
    const totalMs    = 5 * 60 * 1000;
    const elMenit = document.getElementById('flipMenit');
    const elDetik = document.getElementById('flipDetik');
    const elFill  = document.getElementById('progressFill');
    const elPct   = document.getElementById('progressPct');
    const elStatus = document.getElementById('progressStatus');
    const elPill   = document.getElementById('statusPill');
    const elPillDot = document.getElementById('pillDot');
    const elStatusTxt = document.getElementById('statusText');
    const elExpired = document.getElementById('expiredMsg');
    const elToken = document.getElementById('tokenCode');

    function updateCountdown() {
        const now = Date.now();
        const remaining = Math.max(0, expiryTime - now);
        const pct  = Math.round((remaining / totalMs) * 100);
        const mins = Math.floor(remaining / 60000);
        const secs = Math.floor((remaining % 60000) / 1000);
        elMenit.textContent = String(mins).padStart(2, '0');
        elDetik.textContent = String(secs).padStart(2, '0');
        elFill.style.width  = pct + '%';
        elPct.textContent   = pct + '%';
        if (pct > 60) {
            elFill.style.background = 'linear-gradient(90deg, var(--gold), #a8782e)';
            elStatus.textContent = 'Sisa waktu presensi';
            elPill.className = 'status-pill pill-active';
            elPillDot.style.background = '#4caf8a';
            elStatusTxt.textContent = 'Aktif';
            elMenit.style.color = 'var(--gold-light)';
            elDetik.style.color = 'var(--gold-light)';
        } else if (pct > 30) {
            elFill.style.background = 'linear-gradient(90deg, #fbbf24, #f59e0b)';
            elStatus.textContent = 'Segera selesaikan presensi';
            elPill.className = 'status-pill pill-warning';
            elPillDot.style.background = '#fbbf24';
            elStatusTxt.textContent = 'Hampir habis';
            elMenit.style.color = '#fcd34d';
            elDetik.style.color = '#fcd34d';
        } else {
            elFill.style.background = 'linear-gradient(90deg, #e05c5c, #ef4444)';
            elStatus.textContent = '⚠️ Waktu hampir habis!';
            elPill.className = 'status-pill pill-critical';
            elPillDot.style.background = '#e05c5c';
            elStatusTxt.textContent = 'Kritis!';
            elMenit.style.color = '#f9a8a8';
            elDetik.style.color = '#f9a8a8';
        }
        if (remaining <= 0) {
            elMenit.textContent = '00'; elDetik.textContent = '00';
            elFill.style.width = '0%'; elPct.textContent = '0%';
            elStatus.textContent = 'Kedaluwarsa';
            elExpired.style.display = 'block';
            elToken.style.opacity = '0.3';
            setTimeout(() => location.reload(), 2500);
            return;
        }
        setTimeout(updateCountdown, 1000);
    }
    updateCountdown();
</script>
@endif


<footer style="position: relative; z-index: 2; text-align: center; padding: 1.5rem; border-top: 1px solid rgba(255,255,255,.07); font-size: 12px; color: var(--muted); margin-top: auto;">
    &copy; {{ date('Y') }} Dibuat oleh ONEJAY TEAM &mdash; <a href="{{ url('/about') }}" style="color: var(--gold-lt); text-decoration: none; font-weight: 600;">Tentang Kami | About Us</a>
</footer>

<script src="{{ asset('js/theme-mode.js') }}"></script>
</body>
</html>