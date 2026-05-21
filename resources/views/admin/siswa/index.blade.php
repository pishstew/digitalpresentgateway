<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Siswa — SIJA Presensi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --navy: #0B1F3A; --navy-mid: #132D52; --navy-soft: #1C3D6E;
            --gold: #C9963C; --gold-lt: #E8B455; --gold-dim: #F5D9A0;
            --white: #FAFAF8; --muted: #8FA3C0;
            --border: rgba(201,150,60,.25); --border-w: rgba(255,255,255,.07);
            --glass: rgba(255,255,255,.04);
        }
        html, body { min-height: 100%; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--navy); color: var(--white); overflow-x: hidden; }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: radial-gradient(ellipse 80% 60% at 70% -10%, rgba(28,61,110,.8) 0%, transparent 60%),
                        radial-gradient(ellipse 50% 40% at 10% 80%, rgba(201,150,60,.07) 0%, transparent 50%);
            pointer-events: none; z-index: 0;
        }
        body::after {
            content: ''; position: fixed; inset: 0;
            background-image: linear-gradient(rgba(201,150,60,.04) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(201,150,60,.04) 1px, transparent 1px);
            background-size: 60px 60px; pointer-events: none; z-index: 0;
        }

        /* NAV */
        nav {
            position: sticky; top: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.1rem 2.5rem; border-bottom: 1px solid var(--border);
            backdrop-filter: blur(20px); background: rgba(11,31,58,.85);
        }
        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-logo {
            width: 38px; height: 38px; background: var(--gold); border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif; font-weight: 700; font-size: 17px; color: var(--navy);
        }
        .nav-name { font-size: 14px; font-weight: 600; color: var(--white); }
        .nav-sub  { font-size: 10px; color: var(--muted); letter-spacing: .6px; text-transform: uppercase; }
        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .nav-back {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px; background: var(--glass); border: 1px solid var(--border-w);
            border-radius: 8px; color: var(--muted); font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all .2s;
        }
        .nav-back:hover { background: rgba(255,255,255,.08); color: var(--white); border-color: var(--border); }
        .nav-back svg { width: 15px; height: 15px; }

        /* WRAP */
        .wrap {
            position: relative; z-index: 2; max-width: 1150px; margin: 0 auto;
            padding: 2.5rem 2.5rem 4rem; animation: fadeUp .7s ease both;
        }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(22px); } to { opacity: 1; transform: translateY(0); } }

        /* PAGE HEADER */
        .page-header { margin-bottom: 2rem; }
        .page-badge {
            display: inline-flex; align-items: center; gap: 8px; padding: 5px 12px;
            background: rgba(201,150,60,.12); border: 1px solid rgba(201,150,60,.28); border-radius: 100px;
            font-size: 11px; font-weight: 600; color: var(--gold-lt); letter-spacing: .5px;
            text-transform: uppercase; margin-bottom: 1rem;
        }
        .page-badge::before {
            content: ''; width: 6px; height: 6px; border-radius: 50%;
            background: var(--gold); animation: pulse 2s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(.7)} }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.9rem; font-weight: 700; color: var(--white); }
        .page-title span { color: var(--gold); }
        .page-sub { margin-top: .35rem; font-size: 14px; color: var(--muted); }

        /* ALERTS */
        .alert {
            display: flex; align-items: flex-start; gap: 10px;
            border-radius: 10px; padding: 13px 16px; font-size: 13px; margin-bottom: 1.2rem;
        }
        .alert svg { width: 16px; height: 16px; flex-shrink: 0; margin-top: 1px; }
        .alert-success { background: rgba(74,222,128,.08); border: 1px solid rgba(74,222,128,.22); color: #86efac; }
        .alert-error   { background: rgba(248,113,113,.08); border: 1px solid rgba(248,113,113,.22); color: #fca5a5; }
        .alert-warning { background: rgba(251,191,36,.08);  border: 1px solid rgba(251,191,36,.22);  color: #fde68a; }
        .alert ul { margin: 6px 0 0 16px; line-height: 1.7; }

        /* SEC TITLE */
        .sec-title {
            font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700;
            color: var(--white); margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;
        }
        .sec-title::after { content: ''; flex: 1; height: 1px; background: var(--border-w); }

        /* CARD */
        .card { background: var(--glass); border: 1px solid var(--border-w); border-radius: 16px; margin-bottom: 1.2rem; overflow: hidden; }
        .card-head {
            padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-w);
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-head-title { font-size: 14px; font-weight: 600; color: var(--white); display: flex; align-items: center; gap: 9px; }
        .card-head-title svg { width: 16px; height: 16px; color: var(--gold); }
        .card-body { padding: 1.5rem; }

        /* FORM */
        .form-label {
            display: block; font-size: 11px; font-weight: 700; color: var(--muted);
            letter-spacing: .4px; text-transform: uppercase; margin-bottom: 7px;
        }
        .form-input {
            width: 100%; background: rgba(255,255,255,.05); border: 1px solid var(--border-w);
            border-radius: 9px; padding: 10px 13px; font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif; color: var(--white);
            transition: border-color .2s, background .2s; outline: none;
        }
        .form-input::placeholder { color: rgba(143,163,192,.5); }
        .form-input:focus { border-color: var(--gold); background: rgba(255,255,255,.08); }
        .form-input.error { border-color: #f87171; }
        .input-hint { display: flex; justify-content: space-between; align-items: center; min-height: 20px; margin-top: 5px; }
        .hint-text  { font-size: 12px; color: var(--muted); }
        .hint-count { font-size: 12px; font-weight: 600; color: var(--muted); }
        .form-err   { font-size: 12px; color: #f87171; margin-top: 4px; }

        /* BUTTONS */
        .btn {
            display: inline-flex; align-items: center; gap: 7px; padding: 10px 18px;
            border-radius: 9px; font-size: 13px; font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif; cursor: pointer;
            border: 1px solid transparent; text-decoration: none; white-space: nowrap; transition: all .2s;
        }
        .btn svg { width: 15px; height: 15px; }
        .btn-gold   { background: var(--gold); border-color: var(--gold); color: var(--navy); }
        .btn-gold:hover { background: var(--gold-lt); }
        .btn-teal   { background: rgba(13,148,136,.15); border-color: rgba(13,148,136,.3); color: #2dd4bf; }
        .btn-teal:hover { background: rgba(13,148,136,.25); }
        .btn-yellow { background: rgba(217,119,6,.12); border-color: rgba(217,119,6,.28); color: #fbbf24; }
        .btn-yellow:hover { background: rgba(217,119,6,.22); }
        .btn-orange { background: rgba(234,88,12,.12); border-color: rgba(234,88,12,.28); color: #fb923c; }
        .btn-orange:hover { background: rgba(234,88,12,.22); }
        .btn-sm { padding: 7px 13px; font-size: 12px; }

        /* FILTER TABS */
        .filter-tabs { display: flex; gap: 6px; }
        .filter-tab {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600;
            text-decoration: none; border: 1px solid var(--border-w);
            color: var(--muted); background: var(--glass); transition: all .2s;
        }
        .filter-tab:hover { background: rgba(255,255,255,.07); color: var(--white); }
        .filter-tab.active { background: rgba(201,150,60,.12); border-color: var(--border); color: var(--gold-lt); }
        .filter-dot { width: 6px; height: 6px; border-radius: 50%; }

        /* FORMAT INFO */
        .format-info { background: rgba(255,255,255,.03); border: 1px solid var(--border-w); border-radius: 9px; padding: 12px 16px; margin-bottom: 1rem; font-size: 13px; }
        .format-info strong { color: var(--gold-dim); }
        .code-tag { font-family: monospace; background: rgba(96,165,250,.1); border: 1px solid rgba(96,165,250,.2); color: #93c5fd; padding: 2px 9px; border-radius: 5px; font-size: 12px; margin-left: 6px; }
        .format-note { margin-top: 7px; font-size: 12px; color: var(--muted); line-height: 1.7; }
        .import-row { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .import-file {
            flex: 1; min-width: 220px; background: rgba(255,255,255,.04);
            border: 1px dashed rgba(255,255,255,.15); border-radius: 9px; padding: 9px 13px;
            font-size: 13px; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--white); cursor: pointer;
        }
        .import-file::file-selector-button {
            background: rgba(201,150,60,.15); border: 1px solid var(--border); border-radius: 6px;
            padding: 4px 10px; font-size: 12px; font-weight: 600; color: var(--gold-lt); cursor: pointer; margin-right: 10px;
        }

        /* SEARCH */
        .search-row { display: flex; gap: 10px; }
        .search-row .form-input { flex: 1; }

        /* TABLE */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: rgba(201,150,60,.06); border-bottom: 1px solid var(--border); }
        th { padding: 11px 16px; text-align: left; font-size: 11px; font-weight: 700; color: var(--muted); letter-spacing: .6px; text-transform: uppercase; }
        td { padding: 13px 16px; font-size: 13px; color: var(--white); border-bottom: 1px solid var(--border-w); }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.03); }
        .mono { font-family: monospace; font-size: 13px; letter-spacing: .5px; color: var(--gold-dim); }

        /* BADGE */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; }
        .badge-teal   { background: rgba(13,148,136,.12); border: 1px solid rgba(45,212,191,.2); color: #2dd4bf; }
        .badge-teal::before { background: #2dd4bf; }
        .badge-red    { background: rgba(220,38,38,.1);  border: 1px solid rgba(248,113,113,.2); color: #f87171; }
        .badge-red::before { background: #f87171; }
        .badge-orange { background: rgba(234,88,12,.1);  border: 1px solid rgba(251,146,60,.2);  color: #fb923c; }
        .badge-orange::before { background: #fb923c; }
        .badge-blue   { background: rgba(59,130,246,.1); border: 1px solid rgba(96,165,250,.2); color: #93c5fd; }
        .badge-s1     { background: rgba(124,58,237,.1); border: 1px solid rgba(167,139,250,.2); color: #a78bfa; }
        .badge-s1::before { background: #a78bfa; }
        .badge-s2     { background: rgba(236,72,153,.1); border: 1px solid rgba(244,114,182,.2); color: #f9a8d4; }
        .badge-s2::before { background: #f9a8d4; }

        /* EMPTY */
        .empty { text-align: center; padding: 3.5rem 2rem; color: var(--muted); font-size: 14px; }
        .empty-icon { font-size: 2.5rem; margin-bottom: .8rem; opacity: .4; }
        .empty small { display: block; margin-top: .4rem; font-size: 12px; opacity: .7; }

        /* TABLE FOOTER */
        .table-footer {
            padding: 12px 16px; border-top: 1px solid var(--border-w);
            display: flex; align-items: center; justify-content: space-between;
            font-size: 13px; color: var(--muted);
        }
        .pagi { padding: 14px 16px; border-top: 1px solid var(--border-w); }

        footer { position: relative; z-index: 2; text-align: center; padding: 1.5rem; border-top: 1px solid var(--border-w); font-size: 12px; color: var(--muted); }

        @media (max-width: 768px) {
            nav { padding: 1rem 1.2rem; }
            .wrap { padding: 1.5rem 1.2rem 3rem; }
            .filter-tabs { flex-wrap: wrap; }
            th:nth-child(4), td:nth-child(4) { display: none; }
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-brand">
        <div class="nav-logo">S</div>
        <div>
            <div class="nav-name">SIJA Presensi</div>
            <div class="nav-sub">Sistem Informasi Akademik</div>
        </div>
    </div>
    <div class="nav-actions">
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-gold btn-sm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah Siswa
        </a>
        <a href="{{ route('admin.dashboard') }}" class="nav-back">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Dashboard
        </a>
    </div>
</nav>

<div class="wrap">

    @if(Session::has('success'))
        <div class="alert alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <span>{{ Session::get('success') }}</span>
        </div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>{{ Session::get('error') }}</span>
        </div>
    @endif
    @if(Session::has('import_errors'))
        <div class="alert alert-warning">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <div>
                <strong>Detail error saat import:</strong>
                <ul>@foreach(Session::get('import_errors') as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-badge">Manajemen Data</div>
        <h1 class="page-title">Data <span>Siswa</span></h1>
        <p class="page-sub">Kelola data dan akun siswa seluruh kelas SIJA</p>
    </div>

    {{-- IMPORT --}}
    <div class="sec-title">Import dari Excel</div>
    <div class="card">
        <div class="card-head">
            <div class="card-head-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Upload File Excel
            </div>
            <a href="{{ route('admin.siswa.template-import') }}" class="btn btn-yellow btn-sm">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Download Template
            </a>
        </div>
        <div class="card-body">
            <div class="format-info">
                <strong>Format kolom Excel:</strong>
                <span class="code-tag">A: NIS (11 digit) &nbsp;|&nbsp; B: Nama Siswa &nbsp;|&nbsp; C: Kelas</span>
                <div class="format-note">
                    ⚠️ Kolom Kelas hanya boleh diisi <strong style="color:var(--gold-dim)">XI SIJA 1</strong> atau <strong style="color:var(--gold-dim)">XI SIJA 2</strong>
                    &nbsp;·&nbsp; NIS harus tepat <strong style="color:var(--gold-dim)">11 digit angka</strong>
                    &nbsp;·&nbsp; Data dimulai dari baris ke-4
                </div>
            </div>
            <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="import-row">
                    <input type="file" name="file_import" accept=".xlsx,.xls" class="import-file" required>
                    <button type="submit" class="btn btn-teal">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                        Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="sec-title">Daftar Siswa</div>
    <div class="card">
        <div class="card-head">
            <div class="card-head-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Semua Siswa Terdaftar
            </div>
            <div class="filter-tabs">
                <a href="{{ route('admin.siswa.index') }}"
                   class="filter-tab {{ !request('kelas') ? 'active' : '' }}">
                    Semua
                </a>
                <a href="{{ route('admin.siswa.index', ['kelas' => 'XI SIJA 1']) }}"
                   class="filter-tab {{ request('kelas') === 'XI SIJA 1' ? 'active' : '' }}">
                    <span class="filter-dot" style="background:#a78bfa"></span>
                    XI SIJA 1
                </a>
                <a href="{{ route('admin.siswa.index', ['kelas' => 'XI SIJA 2']) }}"
                   class="filter-tab {{ request('kelas') === 'XI SIJA 2' ? 'active' : '' }}">
                    <span class="filter-dot" style="background:#f9a8d4"></span>
                    XI SIJA 2
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:20%">NIS</th>
                        <th style="width:32%">Nama Siswa</th>
                        <th style="width:17%">Kelas</th>
                        <th style="width:13%; text-align:center">Status</th>
                        <th style="width:13%; text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $item)
                        @php $userSiswa = \App\Models\User::where('email', 'siswa.' . $item->nis . '@sija.sch.id')->first(); @endphp
                        <tr>
                            <td style="color:var(--muted)">{{ $siswa->firstItem() + $index }}</td>
                            <td><span class="mono">{{ $item->nis }}</span></td>
                            <td style="font-weight:500">{{ $item->nama_siswa }}</td>
                            <td>
                                <span class="badge {{ $item->kelas === 'XI SIJA 1' ? 'badge-s1' : 'badge-s2' }}">
                                    {{ $item->kelas }}
                                </span>
                            </td>
                            <td style="text-align:center">
                                @if($userSiswa)
                                    <span class="badge {{ $userSiswa->is_active ? 'badge-teal' : 'badge-red' }}">
                                        {{ $userSiswa->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                @else
                                    <span class="badge badge-orange">No Akun</span>
                                @endif
                            </td>
                            <td style="text-align:center">
                                <a href="{{ route('admin.siswa.edit', $item->nis) }}" class="btn btn-orange btn-sm">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty">
                                    <div class="empty-icon">📭</div>
                                    <p>Belum ada data siswa</p>
                                    <small>Gunakan tombol "Tambah Siswa" atau import Excel di atas</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($siswa->hasPages())
            <div class="pagi">{{ $siswa->appends(request()->query())->links() }}</div>
        @endif

        <div class="table-footer">
            <span>Total siswa terdaftar</span>
            <span class="badge badge-blue" style="font-size:12px; padding:4px 12px;">{{ $siswa->total() }} orang</span>
        </div>
    </div>

</div>

<footer>&copy; {{ date('Y') }} SMK — Sistem Presensi Digital Kelas XI SIJA 1 &amp; 2</footer>
</body>
</html>