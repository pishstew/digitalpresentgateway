@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary:  #1a2f4e;
        --accent:   #3b82f6;
        --green:    #16a34a;
        --red:      #dc2626;
        --orange:   #f97316;
        --bg:       #f1f5f9;
        --card-bg:  #ffffff;
        --text:     #1e293b;
        --muted:    #64748b;
    }

    .guru-bg { background: var(--bg); min-height: 100vh; padding: 0; }

    .guru-hero {
        background: linear-gradient(160deg, #1a2f4e 0%, #243b5e 60%, #2d4a72 100%);
        padding: 48px 24px 80px;
        text-align: center;
        position: relative; overflow: hidden;
    }
    .guru-hero::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(circle at 20% 50%, rgba(59,130,246,.15) 0%, transparent 60%),
                    radial-gradient(circle at 80% 20%, rgba(59,130,246,.1) 0%, transparent 50%);
    }
    .hero-avatar {
        width: 72px; height: 72px;
        background: rgba(255,255,255,.12);
        border: 2px solid rgba(255,255,255,.25);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px; font-size: 2rem;
        position: relative; z-index: 1;
    }
    .hero-title { color: white; font-size: 1.5rem; font-weight: 700; margin: 0 0 6px; position: relative; z-index: 1; }
    .hero-sub   { color: rgba(255,255,255,.6); font-size: 0.9rem; position: relative; z-index: 1; }
    .hero-blob  { position: absolute; border-radius: 50%; background: rgba(255,255,255,.04); }
    .hero-blob-1 { top: -40px; right: -40px; width: 220px; height: 220px; }
    .hero-blob-2 { bottom: -60px; left: -60px; width: 260px; height: 260px; }

    .guru-body { max-width: 600px; margin: -40px auto 40px; padding: 0 16px; position: relative; z-index: 2; }

    .g-card { background: var(--card-bg); border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.08); margin-bottom: 16px; overflow: hidden; }
    .g-card-body { padding: 24px; }
    .g-card-title { font-size: 0.85rem; font-weight: 600; color: var(--muted); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 16px; }

    /* TOKEN DISPLAY */
    .token-display {
        background: linear-gradient(135deg, #1a2f4e, #243b5e);
        border-radius: 12px; padding: 32px 24px;
        text-align: center; margin-bottom: 20px;
        position: relative; overflow: hidden;
    }
    .token-display::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(59,130,246,.15), transparent 70%);
    }
    .token-code {
        font-size: 4.5rem; font-weight: 800;
        color: white; letter-spacing: 1.2rem;
        font-family: 'Courier New', monospace;
        line-height: 1; position: relative; z-index: 1;
        text-shadow: 0 0 30px rgba(59,130,246,.5);
    }
    .token-label { color: rgba(255,255,255,.5); font-size: 0.8rem; margin-top: 10px; position: relative; z-index: 1; }

    /* COUNTDOWN WRAPPER */
    .countdown-wrap {
        background: #f8fafc; border-radius: 12px;
        padding: 16px 20px; margin-bottom: 16px;
        border: 1.5px solid #e2e8f0;
    }

    /* FLIP CLOCK STYLE TIMER */
    .flip-timer {
        display: flex; align-items: center; justify-content: center;
        gap: 8px; margin-bottom: 14px;
    }
    .flip-unit {
        display: flex; flex-direction: column; align-items: center; gap: 4px;
    }
    .flip-num {
        background: linear-gradient(180deg, #1a2f4e 50%, #152641 50%);
        color: white; font-size: 2.2rem; font-weight: 800;
        font-family: 'Courier New', monospace;
        width: 64px; height: 72px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,.2);
        transition: color .3s;
        position: relative;
    }
    .flip-num::after {
        content: '';
        position: absolute; top: 50%; left: 0; right: 0;
        height: 1px; background: rgba(0,0,0,.3);
    }
    .flip-label { font-size: 0.7rem; font-weight: 700; color: var(--muted); letter-spacing: .05em; text-transform: uppercase; }
    .flip-sep { font-size: 2rem; font-weight: 800; color: var(--primary); margin-bottom: 20px; }

    /* PROGRESS BAR */
    .progress-section { margin-bottom: 8px; }
    .progress-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; }
    .progress-pct { font-size: 0.8rem; font-weight: 700; color: var(--text); }
    .progress-status { font-size: 0.75rem; color: var(--muted); }

    .progress-track {
        background: #e2e8f0; border-radius: 100px;
        height: 10px; overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0,0,0,.06);
    }
    .progress-fill {
        height: 100%; border-radius: 100px;
        background: linear-gradient(90deg, #16a34a, #3b82f6);
        transition: width 1s linear, background .5s ease;
        position: relative; overflow: hidden;
    }
    .progress-fill::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.3), transparent);
        animation: shimmer 2s infinite;
    }
    @keyframes shimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(200%)} }

    /* STATUS INDICATOR */
    .status-dot {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 0.8rem; font-weight: 600; padding: 4px 10px;
        border-radius: 20px; background: #f0fdf4; color: #16a34a;
        margin-top: 10px;
    }
    .status-dot .dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #16a34a; animation: pulse 1.5s infinite;
    }
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.3)} }

    /* BUTTONS */
    .btn-generate {
        width: 100%; padding: 14px;
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: white; border: none; border-radius: 10px;
        font-size: 1rem; font-weight: 600;
        cursor: pointer; transition: all .2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-generate:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(22,163,74,.35); }
    .btn-generate:disabled { opacity: .5; cursor: not-allowed; transform: none; }

    .btn-selesai {
        width: 100%; padding: 14px;
        background: white; color: var(--red);
        border: 2px solid var(--red); border-radius: 10px;
        font-size: 1rem; font-weight: 600;
        cursor: pointer; transition: all .2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-selesai:hover { background: var(--red); color: white; }

    .btn-logout {
        width: 100%; padding: 14px;
        background: white; color: var(--muted);
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 1rem; font-weight: 600; text-decoration: none;
        cursor: pointer; transition: all .2s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-logout:hover { border-color: #cbd5e1; color: var(--text); }

    /* ALERTS */
    .alert-ok  { background: #f0fdf4; border-left: 4px solid #16a34a; border-radius: 8px; padding: 12px 16px; color: #15803d; font-size: 0.9rem; font-weight: 500; margin-bottom: 16px; }
    .alert-err { background: #fef2f2; border-left: 4px solid var(--red); border-radius: 8px; padding: 12px 16px; color: var(--red); font-size: 0.9rem; font-weight: 500; margin-bottom: 16px; }

    /* INFO ROW */
    .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }
    .info-row:last-child { border-bottom: none; }
    .info-key { color: var(--muted); }
    .info-val { font-weight: 600; color: var(--text); }

    /* SELECT */
    .g-select {
        width: 100%; padding: 12px 16px;
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        font-size: 0.95rem; color: var(--text);
        background: white; appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24'%3E%3Cpath fill='%2364748b' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 16px center;
        cursor: pointer; margin-bottom: 12px; transition: border-color .2s;
    }
    .g-select:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
    .g-label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text); margin-bottom: 6px; }

    /* NAV LINKS */
    .nav-link-jadwal { display: flex; align-items: center; gap: 10px; padding: 14px 16px; text-decoration: none; color: var(--text); font-weight: 500; font-size: 0.95rem; border-radius: 10px; transition: background .2s; }
    .nav-link-jadwal:hover { background: #f8fafc; color: var(--accent); text-decoration: none; }
    .nav-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .nav-icon.blue  { background: #eff6ff; }
    .nav-icon.green { background: #f0fdf4; }

    /* EXPIRED STATE */
    .expired-overlay {
        text-align: center; padding: 16px 0 8px;
        color: var(--red); font-weight: 700; font-size: 1rem;
        display: none;
    }
</style>

<div class="guru-bg">

    {{-- HERO --}}
    <div class="guru-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-avatar">👨‍🏫</div>
        <h1 class="hero-title">Dashboard Guru</h1>
        <p class="hero-sub">Kelola absensi kelas Anda</p>
    </div>

    <div class="guru-body">

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert-ok">✅ {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-err">⚠️ {{ $errors->first() }}</div>
        @endif

        {{-- TOKEN AKTIF --}}
        @if($tokenAktif)
        <div class="g-card">
            <div class="g-card-body">
                <div class="g-card-title">🔑 Kode Presensi Aktif</div>

                {{-- Token Display --}}
                <div class="token-display">
                    <div class="token-code" id="tokenCode">{{ $tokenAktif }}</div>
                    <div class="token-label">Tunjukkan kode ini ke siswa</div>
                </div>

                {{-- Status dot --}}
                <div style="text-align:center; margin-bottom: 16px;">
                    <span class="status-dot" id="statusDot">
                        <span class="dot"></span>
                        <span id="statusText">Aktif</span>
                    </span>
                </div>

                {{-- Countdown --}}
                <div class="countdown-wrap">
                    {{-- Flip timer --}}
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

                    {{-- Progress bar --}}
                    <div class="progress-section">
                        <div class="progress-header">
                            <span class="progress-pct" id="progressPct">100%</span>
                            <span class="progress-status" id="progressStatus">Sisa waktu presensi</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" id="progressFill" style="width:100%"></div>
                        </div>
                    </div>
                </div>

                {{-- Expired overlay --}}
                <div class="expired-overlay" id="expiredMsg">
                    ⏰ Kode telah kedaluwarsa — halaman akan dimuat ulang...
                </div>

                {{-- Selesaikan --}}
                <form method="POST" action="{{ route('guru.presensi.selesaikan') }}">
                    @csrf
                    <button type="submit" class="btn-selesai">✅ Selesaikan Presensi</button>
                </form>
            </div>
        </div>

        {{-- Info sesi aktif --}}
        @php
            $jadwalAktifData = \App\Models\JadwalPelajaran::with('mapel')
                ->where('kode_jam_pelajaran', $jadwalAktif)
                ->first();
        @endphp
        @if($jadwalAktifData)
        <div class="g-card">
            <div class="g-card-body">
                <div class="g-card-title">📋 Sesi Aktif</div>
                <div class="info-row">
                    <span class="info-key">Kelas</span>
                    <span class="info-val">{{ $jadwalAktifData->kelas }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Mata Pelajaran</span>
                    <span class="info-val">{{ $jadwalAktifData->mapel->nama_mapel ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Hari</span>
                    <span class="info-val">{{ $jadwalAktifData->hari }}</span>
                </div>
                <div class="info-row">
                    <span class="info-key">Jam Ke</span>
                    <span class="info-val">{{ $jadwalAktifData->jam_ke }}</span>
                </div>
            </div>
        </div>
        @endif

        @else
        {{-- FORM GENERATE TOKEN --}}
        <div class="g-card">
            <div class="g-card-body">
                <div class="g-card-title">🔐 Generate Token Absensi</div>
                <form method="POST" action="{{ route('guru.token.generate') }}">
                    @csrf
                    <label class="g-label" for="jadwal_id">Kelas & Jadwal</label>
                    <select name="jadwal_id" id="jadwal_id" class="g-select" required>
                        <option value="" disabled selected>Pilih Kelas</option>
                        @forelse($jadwals as $j)
                            <option value="{{ $j->kode_jam_pelajaran }}">
                                {{ $j->kelas }} — {{ $j->mapel->nama_mapel ?? $j->kode_mapel }}
                                ({{ $j->hari }}, Jam ke-{{ $j->jam_ke }})
                            </option>
                        @empty
                            <option value="" disabled>Belum ada jadwal terdaftar</option>
                        @endforelse
                    </select>
                    <button type="submit" class="btn-generate" @if($jadwals->isEmpty()) disabled @endif>
                        🔑 Generate Kode Absensi
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- MENU NAVIGASI --}}
        <div class="g-card">
            <div class="g-card-body" style="padding: 8px;">
                <a href="{{ route('guru.presensi.index') }}" class="nav-link-jadwal">
                    <div class="nav-icon blue">📋</div>
                    <span>Kelola Presensi Siswa</span>
                    <span style="margin-left:auto; color:#94a3b8;">›</span>
                </a>
                <a href="{{ route('guru.jadwal.index') }}" class="nav-link-jadwal">
                    <div class="nav-icon green">📅</div>
                    <span>Jadwal Mengajar Saya</span>
                    <span style="margin-left:auto; color:#94a3b8;">›</span>
                </a>
            </div>
        </div>

        {{-- LOGOUT --}}
        <div class="g-card">
            <div class="g-card-body" style="padding: 8px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">↪ Logout</button>
                </form>
            </div>
        </div>

    </div>
</div>

@if($tokenAktif && $tokenExpiry)
<script>
    const expiryTime = new Date("{{ $tokenExpiry }}").getTime();
    const totalMs    = 5 * 60 * 1000; // 5 menit

    const elMenit     = document.getElementById('flipMenit');
    const elDetik     = document.getElementById('flipDetik');
    const elFill      = document.getElementById('progressFill');
    const elPct       = document.getElementById('progressPct');
    const elStatus    = document.getElementById('progressStatus');
    const elDot       = document.getElementById('statusDot');
    const elStatusTxt = document.getElementById('statusText');
    const elExpired   = document.getElementById('expiredMsg');
    const elToken     = document.getElementById('tokenCode');

    function updateCountdown() {
        const now       = Date.now();
        const remaining = Math.max(0, expiryTime - now);
        const pct       = Math.round((remaining / totalMs) * 100);

        const mins = Math.floor(remaining / 60000);
        const secs = Math.floor((remaining % 60000) / 1000);

        // Update flip timer
        elMenit.textContent = String(mins).padStart(2, '0');
        elDetik.textContent = String(secs).padStart(2, '0');

        // Update progress bar
        elFill.style.width = pct + '%';
        elPct.textContent  = pct + '%';

        // Warna & status berdasarkan sisa waktu
        if (pct > 60) {
            elFill.style.background    = 'linear-gradient(90deg, #16a34a, #3b82f6)';
            elStatus.textContent       = 'Sisa waktu presensi';
            elDot.style.background     = '#f0fdf4';
            elDot.style.color          = '#16a34a';
            elStatusTxt.textContent    = 'Aktif';
        } else if (pct > 30) {
            elFill.style.background    = 'linear-gradient(90deg, #f97316, #fb923c)';
            elStatus.textContent       = 'Segera selesaikan presensi';
            elDot.style.background     = '#fff7ed';
            elDot.style.color          = '#f97316';
            elStatusTxt.textContent    = 'Hampir habis';
            elMenit.style.color        = '#f97316';
            elDetik.style.color        = '#f97316';
        } else {
            elFill.style.background    = 'linear-gradient(90deg, #dc2626, #ef4444)';
            elStatus.textContent       = '⚠️ Waktu hampir habis!';
            elDot.style.background     = '#fef2f2';
            elDot.style.color          = '#dc2626';
            elStatusTxt.textContent    = 'Kritis!';
            elMenit.style.color        = '#dc2626';
            elDetik.style.color        = '#dc2626';
            // Kedip saat kritis
            elToken.style.animation    = 'none';
        }

        if (remaining <= 0) {
            elMenit.textContent        = '00';
            elDetik.textContent        = '00';
            elFill.style.width         = '0%';
            elPct.textContent          = '0%';
            elStatus.textContent       = 'Kedaluwarsa';
            elDot.style.display        = 'none';
            elExpired.style.display    = 'block';
            elToken.style.opacity      = '0.3';
            setTimeout(() => location.reload(), 2500);
            return;
        }

        setTimeout(updateCountdown, 1000);
    }

    updateCountdown();
</script>
@endif
@endsection