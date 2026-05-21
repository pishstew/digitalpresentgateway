<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
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
        .nav-right { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
        .btn-nav-link {
            display: flex; align-items: center; gap: 4px;
            padding: 6px 12px;
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 7px;
            color: var(--gold-light);
            text-decoration: none;
            font-size: .8rem; font-weight: 600;
            transition: all .2s;
            white-space: nowrap;
        }
        .btn-nav-link:hover { background: var(--glass-b); border-color: var(--gold); color: var(--gold); }
        /* Hide label on very small screens */
        .btn-nav-link .label-text { display: inline; }
        .btn-logout {
            display: flex; align-items: center; gap: 4px;
            padding: 6px 12px;
            background: rgba(224,92,92,.1);
            border: 1px solid rgba(224,92,92,.25);
            border-radius: 7px;
            color: #f9a8a8;
            text-decoration: none;
            font-size: .8rem; font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            white-space: nowrap;
        }
        .btn-logout:hover { background: rgba(224,92,92,.18); border-color: rgba(224,92,92,.45); }

        /* Page wrap */
        .page-wrap {
            position: relative; z-index: 1;
            max-width: 920px;
            margin: 0 auto;
            padding: 24px 16px 64px;
        }

        /* Greeting */
        .greeting { margin-bottom: 24px; }
        .greeting-name {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.3rem, 5vw, 1.7rem);
            font-weight: 700; color: var(--white); line-height: 1.2;
        }
        .greeting-name span { color: var(--gold); }
        .greeting-sub { margin-top: 5px; color: var(--muted); font-size: .86rem; }

        /* Alert */
        .alert {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 11px 15px;
            border-radius: 10px;
            font-size: .86rem; font-weight: 500;
            margin-bottom: 18px;
            line-height: 1.4;
        }
        .alert svg { flex-shrink: 0; margin-top: 1px; }
        .alert-success { background: rgba(76,175,138,.12); border: 1px solid rgba(76,175,138,.28); color: #7fe3b8; }
        .alert-error   { background: rgba(224,92,92,.12);  border: 1px solid rgba(224,92,92,.28);  color: #f9a8a8; }

        /* Grid 2 col */
        .dash-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 16px;
            align-items: start;
        }

        /* Card */
        .card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 14px;
            backdrop-filter: blur(14px);
            overflow: hidden;
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

        /* Jadwal item */
        .jadwal-list { display: flex; flex-direction: column; gap: 9px; }
        .jadwal-item {
            display: flex; align-items: center; justify-content: space-between;
            padding: 11px 13px;
            border-radius: 10px;
            border: 1px solid rgba(143,163,192,.15);
            background: rgba(255,255,255,.03);
            transition: all .2s;
            gap: 10px;
        }
        .jadwal-item.active-jadwal {
            border-color: var(--gold-border);
            background: rgba(201,150,60,.06);
        }
        .jadwal-item.done {
            border-color: rgba(76,175,138,.2);
            background: rgba(76,175,138,.04);
        }
        .jadwal-left { display: flex; align-items: center; gap: 10px; min-width: 0; flex: 1; }
        .jam-box {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: .95rem;
            flex-shrink: 0;
        }
        .jam-box.pending { background: rgba(143,163,192,.12); color: var(--muted); }
        .jam-box.selesai { background: rgba(76,175,138,.14); color: #7fe3b8; }
        .jadwal-info { min-width: 0; }
        .jadwal-info h4 {
            font-size: .88rem; font-weight: 600; color: var(--white);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .jadwal-info p  { font-size: .76rem; color: var(--muted); margin-top: 2px; }
        .jadwal-info .done-txt { color: #7fe3b8; font-weight: 600; }

        .btn-pilih {
            padding: 5px 12px;
            border-radius: 7px;
            font-size: .78rem; font-weight: 600;
            text-decoration: none;
            border: 1px solid;
            transition: all .2s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .btn-pilih.selected {
            background: var(--gold-dim);
            border-color: var(--gold-border);
            color: var(--gold-light);
        }
        .btn-pilih.unselected {
            background: var(--glass);
            border-color: rgba(143,163,192,.2);
            color: var(--muted);
        }
        .btn-pilih.unselected:hover { border-color: var(--gold-border); color: var(--gold-light); }
        .badge-done {
            padding: 4px 9px;
            background: rgba(76,175,138,.14);
            border: 1px solid rgba(76,175,138,.25);
            border-radius: 6px;
            font-size: .73rem; font-weight: 700;
            color: #7fe3b8;
            flex-shrink: 0;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 36px 20px;
            color: var(--muted);
        }
        .empty-icon { font-size: 2rem; margin-bottom: 10px; }
        .empty-state p { font-size: .87rem; }

        /* Form presensi */
        .presensi-target {
            padding: 13px;
            background: rgba(201,150,60,.07);
            border: 1px solid var(--gold-border);
            border-radius: 10px;
            margin-bottom: 16px;
            text-align: center;
        }
        .presensi-target .target-label {
            font-size: .71rem; font-weight: 700;
            color: var(--muted);
            letter-spacing: .06em; text-transform: uppercase;
            margin-bottom: 4px;
        }
        .presensi-target .target-mapel {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; font-weight: 600;
            color: var(--white);
            line-height: 1.3;
        }
        .presensi-target .target-jam {
            display: inline-block;
            margin-top: 5px;
            padding: 3px 10px;
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            border-radius: 20px;
            font-size: .73rem; font-weight: 700;
            color: var(--gold-light);
        }

        /* Token input */
        .token-wrap {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(143,163,192,.15);
        }
        .token-header {
            background: rgba(255,255,255,.05);
            padding: 9px;
            text-align: center;
            border-bottom: 1px solid rgba(143,163,192,.12);
        }
        .token-header span {
            font-size: .75rem; font-weight: 700;
            color: var(--muted);
            letter-spacing: .06em; text-transform: uppercase;
        }
        .token-body { padding: 16px; }
        #token_input {
            width: 100%;
            padding: 12px;
            font-size: clamp(1.6rem, 6vw, 2rem);
            text-align: center;
            letter-spacing: .5em;
            background: rgba(255,255,255,.06);
            border: 1.5px solid rgba(143,163,192,.2);
            border-radius: 10px;
            outline: none;
            color: var(--white);
            font-family: monospace;
            transition: all .2s;
        }
        #token_input:focus {
            border-color: var(--gold);
            background: rgba(201,150,60,.06);
            box-shadow: 0 0 0 3px rgba(201,150,60,.10);
        }
        #token_input::placeholder { color: rgba(143,163,192,.3); letter-spacing: .5em; }

        #submit_token_btn {
            width: 100%;
            margin-top: 12px;
            padding: 13px;
            border: none; border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .88rem; font-weight: 700;
            cursor: not-allowed;
            background: rgba(143,163,192,.15);
            color: var(--muted);
            transition: all .3s;
        }
        #submit_token_btn.ready {
            background: linear-gradient(135deg, var(--gold), #a8782e);
            color: var(--navy);
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(201,150,60,.28);
        }
        #submit_token_btn.ready:hover { filter: brightness(1.08); transform: translateY(-1px); }

        /* Selesai semua */
        .all-done {
            text-align: center;
            padding: 28px 16px;
        }
        .all-done .done-icon { font-size: 2.2rem; margin-bottom: 10px; }
        .all-done h3 { font-family: 'Playfair Display', serif; font-size: 1.05rem; color: var(--white); margin-bottom: 5px; }
        .all-done p { font-size: .83rem; color: var(--muted); margin-bottom: 14px; line-height: 1.5; }
        .btn-riwayat {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px;
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            border-radius: 8px;
            color: var(--gold-light);
            text-decoration: none;
            font-size: .83rem; font-weight: 600;
            transition: all .2s;
        }
        .btn-riwayat:hover { background: rgba(201,150,60,.25); border-color: var(--gold); color: var(--gold); }

        /* ── RESPONSIVE ─────────────────────────────────── */

        /* Tablet & below: stack columns */
        @media (max-width: 680px) {
            .dash-grid {
                grid-template-columns: 1fr;
            }
            /* On mobile, form presensi goes FIRST for quick access */
            .card-presensi { order: -1; }
        }

        /* Small mobile */
        @media (max-width: 400px) {
            .page-wrap { padding: 18px 12px 56px; }
            .navbar { padding: 0 12px; }
            .nav-title { display: none; }
            .btn-nav-link .label-text { display: none; }
            .btn-nav-link, .btn-logout { padding: 6px 10px; }
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
    <div class="nav-right">
        <a href="{{ route('siswa.presensi.index') }}" class="btn-nav-link">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><rect x="1" y="1" width="11" height="11" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 6.5h5M4 4.5h5M4 8.5h3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
            <span class="label-text">Riwayat</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><path d="M8 2H10.5A1.5 1.5 0 0112 3.5v6A1.5 1.5 0 0110.5 11H8M5 9l3-3-3-3M8 6.5H1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="label-text">Keluar</span>
            </button>
        </form>
    </div>
</nav>

<div class="page-wrap">

    <!-- Greeting -->
    <div class="greeting">
        <h1 class="greeting-name">Halo, <span>{{ $siswa ? $siswa->nama_siswa : Auth::user()->name }}</span></h1>
        <p class="greeting-sub">Dashboard Siswa — Sistem Presensi Digital</p>
    </div>

    <!-- Alerts -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" style="flex-shrink:0;margin-top:1px"><circle cx="7" cy="7" r="6" stroke="#4caf8a" stroke-width="1.5"/><path d="M4.5 7l2 2 3-3" stroke="#4caf8a" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ $message }}
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-error">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" style="flex-shrink:0;margin-top:1px"><circle cx="7" cy="7" r="6" stroke="#e05c5c" stroke-width="1.5"/><path d="M7 4.5v3M7 9.5v.5" stroke="#e05c5c" stroke-width="1.5" stroke-linecap="round"/></svg>
            {{ $message }}
        </div>
    @endif

    <!-- Grid -->
    <div class="dash-grid">

        <!-- Kolom Kiri: Jadwal Hari Ini -->
        <div class="card">
            <div class="card-header">
                <h2>Jadwal Hari Ini</h2>
            </div>
            <div class="card-body">
                @if($jadwalHariIni->count() > 0)
                    <div class="jadwal-list">
                        @foreach($jadwalHariIni as $jadwal)
                            <div class="jadwal-item {{ $jadwal->sudah_absen ? 'done' : (($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'active-jadwal' : '') }}">
                                <div class="jadwal-left">
                                    <div class="jam-box {{ $jadwal->sudah_absen ? 'selesai' : 'pending' }}">
                                        {{ $jadwal->jam_ke }}
                                    </div>
                                    <div class="jadwal-info">
                                        <h4>{{ $jadwal->mapel->nama_mapel ?? 'Mapel' }}</h4>
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
                                    <a href="?jadwal_id={{ $jadwal->kode_jam_pelajaran }}"
                                       class="btn-pilih {{ ($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'selected' : 'unselected' }}">
                                        {{ ($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'Dipilih' : 'Pilih' }}
                                    </a>
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

        <!-- Kolom Kanan: Form Presensi -->
        <div class="card card-presensi">
            <div class="card-header" style="text-align:center;">
                <h2>Masukkan Kode Presensi</h2>
            </div>
            <div class="card-body">
                @if($activeJadwal)
                    <div class="presensi-target">
                        <div class="target-label">Presensi Untuk</div>
                        <div class="target-mapel">{{ $activeJadwal->mapel->nama_mapel }}</div>
                        <span class="target-jam">Jam ke-{{ $activeJadwal->jam_ke }}</span>
                    </div>

                    <form action="{{ route('siswa.presensi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kode_jam_pelajaran" value="{{ $activeJadwal->kode_jam_pelajaran }}">
                        <div class="token-wrap">
                            <div class="token-header">
                                <span>Kode 4 Digit</span>
                            </div>
                            <div class="token-body">
                                <input type="text" name="token" id="token_input"
                                    maxlength="4" required
                                    placeholder="0000"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    autocomplete="off"
                                    oninput="updateTokenUI(this)">
                                <button type="submit" id="submit_token_btn" disabled>
                                    Konfirmasi Kehadiran
                                </button>
                            </div>
                        </div>
                    </form>

                @else
                    <div class="all-done">
                        <div class="done-icon">🎉</div>
                        <h3>Semua Selesai!</h3>
                        <p>Anda telah menyelesaikan semua presensi untuk hari ini.</p>
                        <a href="{{ route('siswa.presensi.index') }}" class="btn-riwayat">
                            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"><rect x="1" y="1" width="11" height="11" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M4 6.5h5M4 4.5h5M4 8.5h3" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
                            Lihat Riwayat
                        </a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    function updateTokenUI(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        const btn = document.getElementById('submit_token_btn');
        if (input.value.length === 4) {
            btn.disabled = false;
            btn.classList.add('ready');
        } else {
            btn.disabled = true;
            btn.classList.remove('ready');
        }
    }
</script>

</body>
</html>