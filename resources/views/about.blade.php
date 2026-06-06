<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - ONEJAY TEAM</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:        #0B1F3A;
            --navy-mid:    #112240;
            --gold:        #C9963C;
            --gold-light:  #E8B45A;
            --gold-border: rgba(201,150,60,.28);
            --muted:       #8FA3C0;
            --white:       #FFFFFF;
            --glass:       rgba(255,255,255,.04);
            --glass-hover: rgba(255,255,255,.08);
        }
        
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            background: var(--navy);
            color: var(--white);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* ── BACKGROUND ── */
        body::before {
            content: ''; position: fixed; inset: 0; z-index: 0;
            background: radial-gradient(ellipse 80% 60% at 50% 0%, rgba(201,150,60,.08) 0%, transparent 60%);
            pointer-events: none;
        }
        body::after {
            content: ''; position: fixed; inset: 0; z-index: 0;
            background-image: linear-gradient(rgba(201,150,60,.04) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(201,150,60,.04) 1px, transparent 1px);
            background-size: 44px 44px; pointer-events: none;
        }

        /* ── NAVBAR ── */
        .navbar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 40px; height: 70px;
            background: rgba(11,31,58,.85); backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--gold-border);
            position: sticky; top: 0; z-index: 100;
        }
        .nav-brand { display: flex; align-items: center; gap: 14px; text-decoration: none; }
        .nav-logo {
            width: 38px; height: 38px; border-radius: 10px; background: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif; font-size: 1.2rem; font-weight: 800; color: var(--navy);
        }
        .nav-title { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; color: var(--white); }
        .nav-title span { color: var(--gold); }
        .btn-back {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 18px; border-radius: 10px;
            background: var(--glass); border: 1px solid var(--gold-border);
            color: var(--gold-light); font-size: .85rem; font-weight: 600;
            text-decoration: none; transition: all .2s;
        }
        .btn-back:hover { background: rgba(201,150,60,.15); }

        /* ── MAIN CONTENT ── */
        .container {
            position: relative; z-index: 1;
            max-width: 1300px; margin: 0 auto;
            padding: 60px 30px; flex: 1;
            text-align: center;
        }
        
        .header-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem; font-weight: 800;
            margin-bottom: 15px; color: var(--white);
        }
        .header-title span { color: var(--gold); }
        .header-desc {
            font-size: 1.1rem; color: var(--muted);
            max-width: 600px; margin: 0 auto 50px;
            line-height: 1.6;
        }

        /* ── TEAM GRID ── */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
            margin-bottom: 60px;
            align-items: stretch;
        }

        .team-card {
            background: var(--glass);
            border: 1px solid var(--gold-border);
            border-radius: 20px;
            padding: 32px 26px;
            backdrop-filter: blur(12px);
            transition: all .3s;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .team-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--gold), var(--gold-light));
            opacity: 0; transition: opacity .3s;
        }
        .team-card:hover {
            transform: translateY(-5px);
            background: var(--glass-hover);
            box-shadow: 0 15px 35px rgba(0,0,0,.2);
        }
        .team-card:hover::before { opacity: 1; }
        .member-details { width: 100%; flex: 1; }

        /* ── PHOTO PLACEHOLDER ── */
        .photo-wrap {
            width: 140px; height: 140px; margin: 0 auto 20px;
            border-radius: 50%;
            background: rgba(11,31,58,.8);
            border: 3px solid var(--gold);
            padding: 5px;
            position: relative;
        }
        .photo-inner {
            width: 100%; height: 100%;
            border-radius: 50%;
            background-color: var(--navy-mid);
            background-image: url('https://ui-avatars.com/api/?name=Team+Member&background=112240&color=C9963C&size=200'); /* Ganti dengan URL foto asli */
            background-size: cover;
            background-position: center;
        }
        
        .member-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem; font-weight: 700;
            color: var(--gold-light); margin-bottom: 5px;
        }
        .member-role {
            font-size: .9rem; font-weight: 600;
            color: var(--muted); letter-spacing: .05em; text-transform: uppercase;
            margin-bottom: 15px;
        }
        .member-desc {
            font-size: .9rem; color: var(--muted); line-height: 1.5;
        }

        /* ── MEMBER DETAILS ── */
        .member-details {
            text-align: left; margin-top: 20px; font-size: 0.85rem;
            background: rgba(0,0,0,.2); padding: 15px;
            border-radius: 12px; border: 1px solid rgba(255,255,255,.05);
        }
        .detail-row {
            display: grid; grid-template-columns: 110px 10px 1fr;
            padding: 6px 0; border-bottom: 1px dashed rgba(255,255,255,.1);
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { font-weight: 600; color: var(--gold-light); }
        .detail-separator { color: var(--muted); text-align: center; }
        .detail-value { color: var(--white); word-break: break-word; }

        /* ── FOOTER ── */
        .footer {
            text-align: center; padding: 30px;
            border-top: 1px solid rgba(255,255,255,.07);
            color: var(--muted); font-size: .85rem;
            position: relative; z-index: 1;
        }

        @media(max-width: 1024px) {
            .team-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media(max-width: 640px) {
            .team-grid { grid-template-columns: 1fr; }
            .header-title { font-size: 2.5rem; }
            .navbar { padding: 0 20px; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="{{ url('/') }}" class="nav-brand">
            <div class="nav-logo">S</div>
            <span class="nav-title">School<span>System</span></span>
        </a>
        <a href="javascript:history.back()" class="btn-back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </nav>

    <div class="container">
        <h1 class="header-title">Tentang <span>ONEJAY TEAM</span></h1>
        <p class="header-desc">
            Kami adalah pengembang di balik SchoolSystem. Sistem presensi digital cerdas yang dirancang untuk mempermudah manajemen sekolah Anda.
        </p>

        <!-- AREA UNTUK MENGISI DATA TIM (BISA DITAMBAH/DIKURANGI) -->
        <div class="team-grid">
            
            <!-- Anggota 1 -->
            <div class="team-card">
                <div class="photo-wrap">
                    <!-- Ganti link background-image dengan asset laravel: url('{{ asset('images/foto-1.jpg') }}') -->
                    <div class="photo-inner" style="background-image: url('{{ asset('images/sonia.jpg') }}');"></div>
                </div>
                <h3 class="member-name">Sonia Sinta Putri</h3>
                <div class="member-role">Project Manager / Ketua</div>
                
                <div class="member-details">
                    <div class="detail-row"><div class="detail-label">Nama</div><div class="detail-separator">:</div><div class="detail-value">Sonia Sinta Putri</div></div>
                    <div class="detail-row"><div class="detail-label">NIS</div><div class="detail-separator">:</div><div class="detail-value">18458/133/065</div></div>
                    <div class="detail-row"><div class="detail-label">NISN</div><div class="detail-separator">:</div><div class="detail-value">0093605694</div></div>
                    <div class="detail-row"><div class="detail-label">TTL</div><div class="detail-separator">:</div><div class="detail-value">Malang, 20 Juli 2009</div></div>
                    <div class="detail-row"><div class="detail-label">Kelas & Jurusan</div><div class="detail-separator">:</div><div class="detail-value">XI SIJA 2</div></div>
                    <div class="detail-row"><div class="detail-label">Email</div><div class="detail-separator">:</div><div class="detail-value">soniasinta248@gmail.com</div></div>
                    <div class="detail-row"><div class="detail-label">No Telepon</div><div class="detail-separator">:</div><div class="detail-value">0812-2861-453</div></div>
                    <div class="detail-row"><div class="detail-label">Sosmed</div><div class="detail-separator">:</div><div class="detail-value"><a href="https://www.instagram.com/soniasintaa?igsh=MXF0aGEycGFvN3pmOQ==" target="_blank" style="color: var(--gold-light); text-decoration: none;">@soniasintaa</a></div></div>
                    <div class="detail-row"><div class="detail-label">Jobdesk</div><div class="detail-separator">:</div><div class="detail-value">Project Manager / Ketua</div></div>
                </div>
            </div>

            <!-- Anggota 2 -->
            <div class="team-card">
                <div class="photo-wrap">
                    <div class="photo-inner" style="background-image: url('{{ asset('images/nafis.jpg') }}');"></div>
                </div>
                <h3 class="member-name">Nafis Achmad Ma'ruf</h3>
                <div class="member-role">UI/UX Designer</div>

                <div class="member-details">
                    <div class="detail-row"><div class="detail-label">Nama</div><div class="detail-separator">:</div><div class="detail-value">Nafis Achmad Ma'ruf</div></div>
                    <div class="detail-row"><div class="detail-label">NIS</div><div class="detail-separator">:</div><div class="detail-value">18438/113/065</div></div>
                    <div class="detail-row"><div class="detail-label">NISN</div><div class="detail-separator">:</div><div class="detail-value">0085736091</div></div>
                    <div class="detail-row"><div class="detail-label">TTL</div><div class="detail-separator">:</div><div class="detail-value">Malang, 14 Desember 2008</div></div>
                    <div class="detail-row"><div class="detail-label">Kelas & Jurusan</div><div class="detail-separator">:</div><div class="detail-value">XI SIJA 2</div></div>
                    <div class="detail-row"><div class="detail-label">Email</div><div class="detail-separator">:</div><div class="detail-value">nachmadmaruf@gmail.com</div></div>
                    <div class="detail-row"><div class="detail-label">No Telepon</div><div class="detail-separator">:</div><div class="detail-value">0897-9229-494</div></div>
                    <div class="detail-row"><div class="detail-label">Sosmed</div><div class="detail-separator">:</div><div class="detail-value"><a href="https://www.instagram.com/dearestfishy/?__pwa=1" target="_blank" style="color: var(--gold-light); text-decoration: none;">@dearestfishy</a></div></div>
                    <div class="detail-row"><div class="detail-label">Jobdesk</div><div class="detail-separator">:</div><div class="detail-value">UI/UX Designer</div></div>
                </div>
            </div>

            <!-- Anggota 3 -->
            <div class="team-card">
                <div class="photo-wrap">
                    <div class="photo-inner" style="background-image: url('{{ asset('images/shofa.jpg') }}');"></div>
                </div>
                <h3 class="member-name">Shofa Annisatus Zahra</h3>
                <div class="member-role">Project Coordinator</div>

                <div class="member-details">
                    <div class="detail-row"><div class="detail-label">Nama</div><div class="detail-separator">:</div><div class="detail-value">Shofa Annisatus Zahra</div></div>
                    <div class="detail-row"><div class="detail-label">NIS</div><div class="detail-separator">:</div><div class="detail-value">18453/128/065</div></div>
                    <div class="detail-row"><div class="detail-label">NISN</div><div class="detail-separator">:</div><div class="detail-value">0083796148 </div></div>
                    <div class="detail-row"><div class="detail-label">TTL</div><div class="detail-separator">:</div><div class="detail-value">Malang, 14 Juli 2008</div></div>
                    <div class="detail-row"><div class="detail-label">Kelas & Jurusan</div><div class="detail-separator">:</div><div class="detail-value">XI SIJA 2</div></div>
                    <div class="detail-row"><div class="detail-label">Email</div><div class="detail-separator">:</div><div class="detail-value">sahrasofa99@gmail.com</div></div>
                    <div class="detail-row"><div class="detail-label">No Telepon</div><div class="detail-separator">:</div><div class="detail-value">0856-4524-3705</div></div>
                    <div class="detail-row"><div class="detail-label">Sosmed</div><div class="detail-separator">:</div><div class="detail-value"><a href="https://www.instagram.com/shfaaa_zhra?igsh=MXE0aW84Z2NuN3JwbQ==" target="_blank" style="color: var(--gold-light); text-decoration: none;">@shfaaa_zhra</a></div></div>
                    <div class="detail-row"><div class="detail-label">Jobdesk</div><div class="detail-separator">:</div><div class="detail-value">Project Coordinator</div></div>
                </div>
            </div>

            <!-- Tambahkan kotak anggota di bawah ini jika tim lebih dari 3 orang -->

        </div>
    </div>

    <footer class="footer">
        &copy; {{ date('Y') }} Dibuat oleh <strong>ONEJAY TEAM</strong>
    </footer>

</body>
</html>
