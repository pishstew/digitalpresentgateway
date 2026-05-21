<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun — SIJA Presensi Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
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
            position: relative; z-index: 2;
            display: flex; align-items: center; gap: 12px;
        }

        .panel-logo {
            width: 44px; height: 44px;
            background: var(--gold);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 20px;
            color: var(--navy);
        }

        .panel-name { font-size: 16px; font-weight: 600; }
        .panel-sub  { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: .6px; }

        .panel-hero { position: relative; z-index: 2; }

        .panel-hero h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem; font-weight: 700; line-height: 1.2;
            color: var(--white); margin-bottom: 1rem;
        }

        .panel-hero h2 em { font-style: normal; color: var(--gold); }

        .panel-hero p {
            font-size: 14px; line-height: 1.8;
            color: var(--muted); max-width: 340px;
        }

        .steps-list {
            position: relative; z-index: 2;
            display: flex; flex-direction: column; gap: 14px;
        }

        .step-item {
            display: flex; align-items: flex-start; gap: 14px;
            padding: 14px 16px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px;
        }

        .step-num {
            width: 26px; height: 26px; flex-shrink: 0;
            background: rgba(201,150,60,.2);
            border: 1px solid rgba(201,150,60,.4);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: var(--gold);
        }

        .step-text { font-size: 13px; color: var(--white); font-weight: 500; }
        .step-sub  { font-size: 11px; color: var(--muted); margin-top: 2px; }

        /* ── RIGHT PANEL ── */
        .right-panel {
            flex: 0 0 100%;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 2rem 1.5rem;
            overflow-y: auto;
        }

        @media (min-width: 900px) {
            .right-panel { flex: 0 0 460px; }
        }

        .register-box {
            width: 100%; max-width: 400px;
            animation: fadeUp .7s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .mobile-brand {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 2rem;
        }

        @media (min-width: 900px) { .mobile-brand { display: none; } }

        .mobile-logo {
            width: 38px; height: 38px; background: var(--gold); border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif; font-weight: 700; font-size: 17px; color: var(--navy);
        }

        .mobile-name { font-size: 14px; font-weight: 600; }
        .mobile-sub  { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; }

        .register-header { margin-bottom: 1.75rem; }

        .register-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem; font-weight: 700;
            color: var(--white); margin-bottom: 6px;
        }

        .register-header p { font-size: 14px; color: var(--muted); }

        /* FORM */
        .form-group { margin-bottom: 1.1rem; }

        .form-group label {
            display: block; font-size: 12px; font-weight: 600;
            color: var(--muted); text-transform: uppercase;
            letter-spacing: .5px; margin-bottom: 7px;
        }

        .form-group input,
        .form-group select {
            width: 100%; padding: 11px 14px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 10px;
            color: var(--white); font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border .2s, box-shadow .2s;
            outline: none;
            appearance: none; -webkit-appearance: none;
        }

        .form-group select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA3C0' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 38px;
        }

        .form-group select option { background: var(--navy-mid); color: var(--white); }

        .form-group input::placeholder { color: rgba(143,163,192,.5); }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(201,150,60,.1);
        }

        .form-group input.error { border-color: rgba(239,68,68,.5); }

        .field-error {
            display: flex; align-items: center; gap: 5px;
            font-size: 12px; color: #fca5a5; margin-top: 5px;
        }

        .nip-note {
            font-size: 11px; color: var(--muted);
            margin-top: 5px; font-style: italic;
        }

        /* role card radio */
        .role-cards {
            display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
            margin-top: 4px;
        }

        .role-card {
            position: relative; cursor: pointer;
        }

        .role-card input[type="radio"] {
            position: absolute; opacity: 0; width: 0; height: 0;
        }

        .role-card-body {
            padding: 12px 14px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 10px;
            transition: all .2s;
            display: flex; align-items: center; gap: 10px;
        }

        .role-card input[type="radio"]:checked + .role-card-body {
            background: rgba(201,150,60,.1);
            border-color: rgba(201,150,60,.5);
        }

        .role-card-dot {
            width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
        }

        .role-card-label { font-size: 13px; font-weight: 600; color: var(--white); }
        .role-card-desc  { font-size: 11px; color: var(--muted); margin-top: 2px; }

        .nip-field { transition: all .3s; overflow: hidden; }

        /* alert */
        .alert-error {
            background: rgba(239,68,68,.1);
            border: 1px solid rgba(239,68,68,.3);
            border-radius: 10px; padding: 12px 16px;
            font-size: 13px; color: #fca5a5; margin-bottom: 1.25rem;
        }

        .btn-submit {
            width: 100%; padding: 13px;
            background: var(--gold); border: none; border-radius: 10px;
            color: var(--navy); font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px; font-weight: 700; cursor: pointer;
            transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 1.25rem;
        }

        .btn-submit:hover { background: var(--gold-lt); transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit svg { transition: transform .2s; }
        .btn-submit:hover svg { transform: translateX(3px); }

        .register-footer {
            margin-top: 1.5rem; text-align: center;
        }

        .register-footer p { font-size: 13px; color: var(--muted); }

        .register-footer a {
            color: var(--gold); text-decoration: none; font-weight: 600;
        }

        .register-footer a:hover { color: var(--gold-lt); }

        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 1.25rem 0; font-size: 12px; color: rgba(143,163,192,.5);
        }

        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px;
            background: rgba(255,255,255,.08);
        }
    </style>
</head>
<body>

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
            <h2>Buat <em>Akun Baru</em><br>Bergabunglah</h2>
            <p>Daftarkan diri Anda sebagai guru atau siswa untuk mengakses sistem presensi digital SIJA.</p>
        </div>

        <div class="steps-list">
            <div class="step-item">
                <div class="step-num">1</div>
                <div>
                    <div class="step-text">Isi Data Diri</div>
                    <div class="step-sub">Nama lengkap dan email aktif</div>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div>
                    <div class="step-text">Pilih Role</div>
                    <div class="step-sub">Guru atau Siswa</div>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div>
                    <div class="step-text">Akun Aktif</div>
                    <div class="step-sub">Login dan mulai gunakan sistem</div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="register-box">

            <div class="mobile-brand">
                <div class="mobile-logo">S</div>
                <div>
                    <div class="mobile-name">SIJA Presensi</div>
                    <div class="mobile-sub">Sistem Informasi Akademik</div>
                </div>
            </div>

            <div class="register-header">
                <h1>Daftar Akun</h1>
                <p>Lengkapi formulir berikut untuk membuat akun</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nama --}}
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                           class="{{ $errors->has('name') ? 'error' : '' }}"
                           required autofocus>
                    @error('name')
                        <div class="field-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}" placeholder="email@sija.sch.id"
                           class="{{ $errors->has('email') ? 'error' : '' }}"
                           required>
                    @error('email')
                        <div class="field-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Minimal 8 karakter"
                           class="{{ $errors->has('password') ? 'error' : '' }}"
                           required>
                    @error('password')
                        <div class="field-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="Ulangi password" required>
                </div>

                {{-- Role --}}
                <div class="form-group">
                    <label>Daftar Sebagai</label>
                    <div class="role-cards">
                        <label class="role-card">
                            <input type="radio" name="role" value="guru"
                                   {{ old('role') === 'guru' ? 'checked' : '' }}
                                   onchange="toggleNip(this.value)">
                            <div class="role-card-body">
                                <div class="role-card-dot" style="background:#60a5fa;"></div>
                                <div>
                                    <div class="role-card-label">Guru</div>
                                    <div class="role-card-desc">Tenaga pengajar</div>
                                </div>
                            </div>
                        </label>
                        <label class="role-card">
                            <input type="radio" name="role" value="siswa"
                                   {{ old('role') === 'siswa' ? 'checked' : '' }}
                                   onchange="toggleNip(this.value)">
                            <div class="role-card-body">
                                <div class="role-card-dot" style="background:#2dd4bf;"></div>
                                <div>
                                    <div class="role-card-label">Siswa</div>
                                    <div class="role-card-desc">Peserta didik</div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <div class="field-error" style="margin-top:6px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- NIP (hanya untuk guru) --}}
                <div class="form-group nip-field" id="nip-field"
                     style="{{ old('role') === 'guru' ? '' : 'display:none' }}">
                    <label for="nip">NIP <span style="color:var(--gold);">*</span></label>
                    <input type="text" id="nip" name="nip"
                           value="{{ old('nip') }}"
                           placeholder="Nomor Induk Pegawai"
                           class="{{ $errors->has('nip') ? 'error' : '' }}">
                    <div class="nip-note">Wajib diisi jika mendaftar sebagai Guru</div>
                    @error('nip')
                        <div class="field-error">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn-submit">
                    Buat Akun
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </form>

            <div class="register-footer">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            </div>

        </div>
    </div>

    <script>
        function toggleNip(role) {
            const nipField = document.getElementById('nip-field');
            nipField.style.display = role === 'guru' ? 'block' : 'none';
        }
    </script>
</body>
</html>