<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lupa Password — SIJA Presensi Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:      #0B1F3A;
            --navy-mid:  #132D52;
            --gold:      #C9963C;
            --gold-lt:   #E8B455;
            --white:     #FAFAF8;
            --muted:     #8FA3C0;
            --border:    rgba(201,150,60,.22);
            --input-bg:  rgba(255,255,255,.05);
            --input-border: rgba(255,255,255,.12);
            --input-focus:  rgba(201,150,60,.5);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 70% 50% at 30% 20%, rgba(201,150,60,.07) 0%, transparent 60%),
                radial-gradient(ellipse 50% 60% at 80% 80%, rgba(28,61,110,.5) 0%, transparent 60%),
                linear-gradient(rgba(201,150,60,.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(201,150,60,.025) 1px, transparent 1px);
            background-size: auto, auto, 50px 50px, 50px 50px;
            pointer-events: none;
        }

        .card {
            position: relative; z-index: 2;
            width: 100%; max-width: 420px;
            background: rgba(19,45,82,.6);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: fadeUp .65s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .card-brand {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 2rem;
        }

        .card-logo {
            width: 40px; height: 40px; background: var(--gold); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif; font-weight: 700; font-size: 18px; color: var(--navy);
        }

        .brand-name { font-size: 15px; font-weight: 600; }
        .brand-sub  { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; }

        .card-icon {
            width: 56px; height: 56px;
            background: rgba(201,150,60,.12);
            border: 1px solid rgba(201,150,60,.3);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.5rem;
        }

        .card-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem; font-weight: 700;
            color: var(--white); margin-bottom: 8px;
        }

        .card-header p {
            font-size: 14px; color: var(--muted); line-height: 1.7;
            margin-bottom: 1.75rem;
        }

        /* alert */
        .alert-status {
            background: rgba(74,222,128,.08);
            border: 1px solid rgba(74,222,128,.25);
            border-radius: 10px; padding: 12px 16px;
            font-size: 13px; color: #86efac; margin-bottom: 1.25rem;
            display: flex; align-items: flex-start; gap: 10px;
        }

        .form-group { margin-bottom: 1.25rem; }

        .form-group label {
            display: block; font-size: 12px; font-weight: 600;
            color: var(--muted); text-transform: uppercase;
            letter-spacing: .5px; margin-bottom: 7px;
        }

        .form-group input {
            width: 100%; padding: 12px 14px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 10px;
            color: var(--white); font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: border .2s, box-shadow .2s; outline: none;
        }

        .form-group input::placeholder { color: rgba(143,163,192,.5); }

        .form-group input:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(201,150,60,.1);
        }

        .field-error {
            display: flex; align-items: center; gap: 5px;
            font-size: 12px; color: #fca5a5; margin-top: 5px;
        }

        .btn-submit {
            width: 100%; padding: 13px;
            background: var(--gold); border: none; border-radius: 10px;
            color: var(--navy); font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px; font-weight: 700; cursor: pointer;
            transition: all .2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        .btn-submit:hover { background: var(--gold-lt); transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit svg { transition: transform .2s; }
        .btn-submit:hover svg { transform: translateX(3px); }

        .card-footer {
            margin-top: 1.5rem; text-align: center;
        }

        .card-footer a {
            color: var(--gold); font-size: 13px; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: 5px;
        }

        .card-footer a:hover { color: var(--gold-lt); }
    </style>
</head>
<body>

    <div class="card">

        <div class="card-brand">
            <div class="card-logo">S</div>
            <div>
                <div class="brand-name">SIJA Presensi</div>
                <div class="brand-sub">Sistem Informasi Akademik</div>
            </div>
        </div>

        <div class="card-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#C9963C" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="3"/>
                <path d="M22 7l-10 7L2 7"/>
            </svg>
        </div>

        <div class="card-header">
            <h1>Lupa Password?</h1>
            <p>Tidak masalah. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mereset password.</p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="alert-status">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="email@sija.sch.id"
                       required autofocus autocomplete="username">
                @error('email')
                    <div class="field-error">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                Kirim Tautan Reset
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>
        </form>

        <div class="card-footer">
            <a href="{{ route('login') }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                Kembali ke halaman masuk
            </a>
        </div>

    </div>

</body>
</html>