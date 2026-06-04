<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — SIJA Presensi Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme-mode.css') }}">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* Variabel default dark — di body agar body.light-mode bisa override */
        body {
            --navy:      #0B1F3A;
            --navy-mid:  #132D52;
            --navy-soft: #1C3D6E;
            --gold:      #C9963C;
            --gold-lt:   #E8B455;
            --gold-dim:  #F5D9A0;
            --white:     #FAFAF8;
            --muted:     #8FA3C0;
            --border:    rgba(201,150,60,.22);
            --input-bg:  rgba(255,255,255,.05);
            --input-border: rgba(255,255,255,.12);
            --input-focus:  rgba(201,150,60,.5);
        }

        html, body { height: 100%; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            display: none;
            flex: 1;
            background: var(--navy-mid);
            border-right: 1px solid var(--border);
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 900px) {
            .left-panel { display: flex; flex-direction: column; justify-content: space-between; padding: 3rem; }
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 30%, rgba(201,150,60,.08) 0%, transparent 55%),
                linear-gradient(rgba(201,150,60,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,150,60,.03) 1px, transparent 1px);
            background-size: auto, 50px 50px, 50px 50px;
            pointer-events: none;
        }

        .panel-brand {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .panel-logo {
            width: 44px;
            height: 44px;
            background: var(--gold);
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 20px;
            color: var(--navy);
        }

        .panel-name {
            font-size: 16px;
            font-weight: 600;
        }

        .panel-sub {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .panel-hero {
            position: relative;
            z-index: 2;
        }

        .panel-hero h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            line-height: 1.2;
            color: var(--white);
            margin-bottom: 1rem;
        }

        .panel-hero h2 em {
            font-style: normal;
            color: var(--gold);
        }

        .panel-hero p {
            font-size: 14px;
            line-height: 1.8;
            color: var(--muted);
            max-width: 340px;
        }

        .panel-roles {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .role-chip {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px;
        }

        .role-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .role-chip-text { font-size: 13px; color: var(--white); font-weight: 500; }
        .role-chip-sub  { font-size: 11px; color: var(--muted); margin-top: 1px; }

        /* ── RIGHT PANEL — LOGIN FORM ── */
        .right-panel {
            flex: 0 0 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }

        @media (min-width: 900px) {
            .right-panel { flex: 0 0 440px; }
        }

        .login-box {
            width: 100%;
            max-width: 380px;
            animation: fadeUp .7s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            margin-bottom: 2rem;
        }

        /* mobile: tunjukkan logo di login box */
        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 2rem;
        }

        @media (min-width: 900px) {
            .mobile-brand { display: none; }
        }

        .mobile-logo {
            width: 38px; height: 38px;
            background: var(--gold);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 17px;
            color: var(--navy);
        }

        .mobile-name { font-size: 14px; font-weight: 600; }
        .mobile-sub  { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; }

        .login-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 14px;
            color: var(--muted);
        }

        /* ── ALERT ── */
        .alert-error {
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.3);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            color: #fca5a5;
            margin-bottom: 1.5rem;
        }

        .alert-status {
            background: rgba(74,222,128,.08);
            border: 1px solid rgba(74,222,128,.25);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 13px;
            color: #86efac;
            margin-bottom: 1.5rem;
        }

        /* ── FORM ── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 8px;
            letter-spacing: .3px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 16px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 10px;
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color .2s, background .2s;
        }

        input::placeholder { color: rgba(143,163,192,.5); }

        input:focus {
            border-color: var(--gold);
            background: rgba(201,150,60,.06);
        }

        input.error { border-color: rgba(239,68,68,.6); }

        .field-error {
            font-size: 12px;
            color: #fca5a5;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* remember me */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13px;
            color: var(--muted);
            margin: 0;
            font-weight: 400;
        }

        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--gold);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
            transition: color .2s;
        }

        .forgot-link:hover { color: var(--gold-lt); }

        /* submit */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--gold);
            border: none;
            border-radius: 10px;
            color: var(--navy);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: var(--gold-lt);
            transform: translateY(-1px);
        }

        .btn-submit:active { transform: translateY(0); }

        .btn-submit svg { transition: transform .2s; }
        .btn-submit:hover svg { transform: translateX(3px); }

        /* divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.5rem 0;
            font-size: 12px;
            color: rgba(143,163,192,.5);
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,.08);
        }

        /* footer note */
        .login-footer {
            margin-top: 1.5rem;
            text-align: center;
        }

        .login-footer p {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.7;
        }

        .login-footer a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
        }

        .login-footer a:hover { color: var(--gold-lt); }

        /* password toggle */
        .pw-wrapper {
            position: relative;
        }

        .pw-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            color: var(--muted);
            transition: color .2s;
            display: flex;
            align-items: center;
        }

        .pw-toggle:hover { color: var(--gold); }
        .pw-wrapper input { padding-right: 44px; }

        /* ── LIGHT MODE — Warm Parchment ── */
        body.light-mode {
            --navy:         #F5F0E8;
            --navy-mid:     #EDE8DD;
            --navy-soft:    #E4DDD1;
            --gold:         #A67C3D;
            --gold-lt:      #7A5A28;
            --gold-dim:     #C8A878;
            --white:        #2C2418;
            --muted:        #7A7060;
            --border:       rgba(166,124,61,.25);
            --input-bg:     rgba(253,250,244,.90);
            --input-border: rgba(166,124,61,.25);
            --input-focus:  rgba(166,124,61,.40);
            background: #F5F0E8 !important;
            color: #2C2418 !important;
        }

        /* Left panel */
        body.light-mode .left-panel {
            background: #EDE8DD !important;
            border-right-color: rgba(166,124,61,.22) !important;
        }
        body.light-mode .left-panel::before {
            background:
                radial-gradient(ellipse 80% 60% at 20% 30%, rgba(166,124,61,.08) 0%, transparent 55%),
                linear-gradient(rgba(166,124,61,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(166,124,61,.025) 1px, transparent 1px) !important;
        }
        body.light-mode .panel-logo {
            background: linear-gradient(135deg, #A67C3D, #7A5A28) !important;
            color: #fff !important;
        }
        body.light-mode .panel-name  { color: #2C2418 !important; }
        body.light-mode .panel-sub   { color: #7A7060 !important; }
        body.light-mode .panel-hero h2 { color: #2C2418 !important; }
        body.light-mode .panel-hero h2 em { color: #A67C3D !important; }
        body.light-mode .panel-hero p  { color: #7A7060 !important; }

        /* Role chips */
        body.light-mode .role-chip {
            background: rgba(44,36,24,.04) !important;
            border-color: rgba(166,124,61,.18) !important;
        }
        body.light-mode .role-chip-text { color: #2C2418 !important; }
        body.light-mode .role-chip-sub  { color: #7A7060 !important; }

        /* Right panel */
        body.light-mode .right-panel { background: #F5F0E8 !important; }

        /* Mobile brand */
        body.light-mode .mobile-logo {
            background: linear-gradient(135deg, #A67C3D, #7A5A28) !important;
            color: #fff !important;
        }
        body.light-mode .mobile-name { color: #2C2418 !important; }
        body.light-mode .mobile-sub  { color: #7A7060 !important; }

        /* Login header */
        body.light-mode .login-header h1 { color: #2C2418 !important; }
        body.light-mode .login-header p  { color: #7A7060 !important; }

        /* Form elements */
        body.light-mode label { color: #7A7060 !important; }
        body.light-mode input[type="email"],
        body.light-mode input[type="password"],
        body.light-mode input[type="text"] {
            background: rgba(253,250,244,.90) !important;
            border-color: rgba(166,124,61,.25) !important;
            color: #2C2418 !important;
        }
        body.light-mode input::placeholder { color: rgba(122,112,96,.45) !important; }
        body.light-mode input:focus {
            border-color: #A67C3D !important;
            background: rgba(166,124,61,.05) !important;
            box-shadow: 0 0 0 3px rgba(166,124,61,.12) !important;
        }
        body.light-mode .pw-toggle { color: #7A7060 !important; }
        body.light-mode .pw-toggle:hover { color: #A67C3D !important; }

        /* Remember / forgot */
        body.light-mode .remember-label { color: #7A7060 !important; }
        body.light-mode .forgot-link { color: #A67C3D !important; }
        body.light-mode .forgot-link:hover { color: #7A5A28 !important; }

        /* Submit btn */
        body.light-mode .btn-submit {
            background: #A67C3D !important;
            color: #fff !important;
        }
        body.light-mode .btn-submit:hover { background: #7A5A28 !important; }

        /* Divider */
        body.light-mode .divider { color: rgba(122,112,96,.5) !important; }
        body.light-mode .divider::before,
        body.light-mode .divider::after { background: rgba(44,36,24,.10) !important; }

        /* Footer note */
        body.light-mode .login-footer p { color: #7A7060 !important; }
        body.light-mode .login-footer a { color: #A67C3D !important; }
        body.light-mode .login-footer a:hover { color: #7A5A28 !important; }

        /* Alerts */
        body.light-mode .alert-error {
            background: rgba(140,94,92,.10) !important;
            border-color: rgba(140,94,92,.28) !important;
            color: #7A3A38 !important;
        }
        body.light-mode .alert-status {
            background: rgba(94,110,74,.10) !important;
            border-color: rgba(94,110,74,.28) !important;
            color: #4A5C38 !important;
        }

        /* Theme switch wrapper di login */
        body.light-mode .login-theme-btn { color: #7A7060 !important; }
    </style>
</head>
<body>

    {{-- THEME SWITCH — pojok kanan atas --}}
    <div style="position:fixed;top:14px;right:16px;z-index:999;display:flex;align-items:center;gap:7px;">
        <label class="theme-switch" title="Ganti tema">
            <input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode">
            <span class="track"></span>
            <span class="thumb"></span>
        </label>
        <span class="theme-label login-theme-btn" style="font-size:12px;font-weight:500;color:var(--muted);min-width:30px;">Dark</span>
    </div>

    {{-- LEFT PANEL --}}
    <div class="left-panel">
        <div class="panel-brand">
            <div class="panel-logo">S</div>
            <div>
                <div class="panel-name">SIJA Presensi</div>
                <div class="panel-sub">Sistem Informasi Jaringan dan Aplikasi</div>
            </div>
        </div>

        <div class="panel-hero">
            <h2>Selamat Datang<br>di <em>Presensi Digital</em></h2>
            <p>Platform presensi berbasis kode 4-digit acak untuk siswa kelas XI SIJA. Masuk dengan akun yang diberikan oleh sekolah.</p>
        </div>

        <div class="panel-roles">
            <div class="role-chip">
                <div class="role-dot" style="background:#C9963C;"></div>
                <div>
                    <div class="role-chip-text">Admin</div>
                    <div class="role-chip-sub">Kelola guru, siswa & sistem</div>
                </div>
            </div>
            <div class="role-chip">
                <div class="role-dot" style="background:#60a5fa;"></div>
                <div>
                    <div class="role-chip-text">Guru / Wali Kelas / Kakon</div>
                    <div class="role-chip-sub">Generate token, pantau presensi</div>
                </div>
            </div>
            <div class="role-chip">
                <div class="role-dot" style="background:#2dd4bf;"></div>
                <div>
                    <div class="role-chip-text">Siswa</div>
                    <div class="role-chip-sub">Absen via token QR</div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="login-box">

            <div class="mobile-brand">
                <div class="mobile-logo">S</div>
                <div>
                    <div class="mobile-name">SIJA Presensi</div>
                    <div class="mobile-sub">Sistem Informasi Akademik</div>
                </div>
            </div>

            <div class="login-header">
                <h1>Masuk</h1>
                <p>Gunakan email dan password akun Anda</p>
            </div>

            {{-- Session status --}}
            @if (session('status'))
                <div class="alert-status">{{ session('status') }}</div>
            @endif

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="email@sija.sch.id"
                           class="{{ $errors->has('email') ? 'error' : '' }}"
                           required autofocus autocomplete="username">
                    @error('email')
                        <div class="field-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="pw-wrapper">
                        <input type="password" id="password" name="password"
                               placeholder="Masukkan password"
                               class="{{ $errors->has('password') ? 'error' : '' }}"
                               required autocomplete="current-password">
                        <button type="button" class="pw-toggle" onclick="togglePw()" aria-label="Tampilkan password">
                            <svg id="eyeIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="field-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="remember-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    Masuk ke Sistem
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>

            <div class="login-footer">
                <p>Belum punya akun? Hubungi admin sekolah<br>untuk mendapatkan akun login Anda.</p>
            </div>

        </div>
    </div>

    <script>
        function togglePw() {
            const pw  = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            const show = pw.type === 'password';
            pw.type = show ? 'text' : 'password';
            eye.innerHTML = show
                ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
                : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    </script>
    <script src="{{ asset('js/theme-mode.js') }}"></script>
</body>
</html>