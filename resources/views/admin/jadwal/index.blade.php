<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Jadwal — SIJA Presensi</title>
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
        .nav-back {
            display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px;
            background: var(--glass); border: 1px solid var(--border-w); border-radius: 8px;
            color: var(--muted); font-size: 13px; font-weight: 500; text-decoration: none; transition: all .2s;
        }
        .nav-back:hover { background: rgba(255,255,255,.08); color: var(--white); border-color: var(--border); }
        .nav-back svg { width: 15px; height: 15px; }

        /* WRAP */
        .wrap {
            position: relative; z-index: 2; max-width: 1150px; margin: 0 auto;
            padding: 2.5rem 2.5rem 4rem; animation: fadeUp .7s ease both;
        }
        @keyframes fadeUp { from { opacity:0; transform:translateY(22px); } to { opacity:1; transform:translateY(0); } }

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

        /* FORM TAMBAH */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr) auto;
            gap: 12px; align-items: flex-end;
        }
        .form-col { display: flex; flex-direction: column; }
        .form-label {
            display: block; font-size: 11px; font-weight: 700; color: var(--muted);
            letter-spacing: .4px; text-transform: uppercase; margin-bottom: 7px;
        }
        .form-input {
            width: 100%; background: rgba(255,255,255,.05); border: 1px solid var(--border-w);
            border-radius: 9px; padding: 10px 13px; font-size: 13px;
            font-family: 'Plus Jakarta Sans', sans-serif; color: var(--white);
            transition: border-color .2s, background .2s; outline: none; appearance: none;
        }
        .form-input::placeholder { color: rgba(143,163,192,.5); }
        .form-input:focus { border-color: var(--gold); background: rgba(255,255,255,.08); }
        .form-input.error { border-color: #f87171; }
        select.form-input option { background: #132D52; color: var(--white); }
        .form-err { font-size: 12px; color: #f87171; margin-top: 4px; }

        /* RADIO KELAS inline */
        .radio-inline { display: flex; gap: 8px; margin-top: 4px; }
        .radio-pill {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px; background: rgba(255,255,255,.04);
            border: 1px solid var(--border-w); border-radius: 8px;
            cursor: pointer; transition: all .2s; font-size: 13px; font-weight: 500; color: var(--white);
            white-space: nowrap;
        }
        .radio-pill:has(input:checked) { background: rgba(201,150,60,.12); border-color: var(--border); color: var(--gold-lt); }
        .radio-pill input { accent-color: var(--gold); width: 14px; height: 14px; cursor: pointer; }

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
        .btn-orange { background: rgba(234,88,12,.12); border-color: rgba(234,88,12,.28); color: #fb923c; }
        .btn-orange:hover { background: rgba(234,88,12,.22); }
        .btn-sm { padding: 7px 13px; font-size: 12px; }

        /* SEARCH */
        .search-row { display: flex; gap: 10px; }
        .search-row .form-input { flex: 1; }

        /* HARI TAG colors */
        .hari-senin   { background: rgba(59,130,246,.12);  border: 1px solid rgba(96,165,250,.2);  color: #93c5fd; }
        .hari-selasa  { background: rgba(13,148,136,.12);  border: 1px solid rgba(45,212,191,.2);  color: #2dd4bf; }
        .hari-rabu    { background: rgba(124,58,237,.12);  border: 1px solid rgba(167,139,250,.2); color: #a78bfa; }
        .hari-kamis   { background: rgba(217,119,6,.12);   border: 1px solid rgba(251,191,36,.2);  color: #fde68a; }
        .hari-jumat   { background: rgba(236,72,153,.12);  border: 1px solid rgba(244,114,182,.2); color: #f9a8d4; }

        /* TABLE */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: rgba(201,150,60,.06); border-bottom: 1px solid var(--border); }
        th { padding: 11px 16px; text-align: left; font-size: 11px; font-weight: 700; color: var(--muted); letter-spacing: .6px; text-transform: uppercase; }
        td { padding: 12px 16px; font-size: 13px; color: var(--white); border-bottom: 1px solid var(--border-w); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.03); }

        /* JAM KE badge */
        .jam-badge {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 8px;
            background: rgba(201,150,60,.12); border: 1px solid var(--border);
            font-size: 13px; font-weight: 700; color: var(--gold-lt);
        }

        /* BADGE */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 100px; font-size: 11px; font-weight: 600; }
        .badge-mapel  { background: rgba(99,179,237,.08); border: 1px solid rgba(99,179,237,.2); color: #93c5fd; }
        .badge-s1     { background: rgba(124,58,237,.1);  border: 1px solid rgba(167,139,250,.2); color: #a78bfa; }
        .badge-s2     { background: rgba(236,72,153,.1);  border: 1px solid rgba(244,114,182,.2); color: #f9a8d4; }
        .badge-blue   { background: rgba(59,130,246,.1);  border: 1px solid rgba(96,165,250,.2);  color: #93c5fd; }

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

        @media (max-width: 900px) {
            nav { padding: 1rem 1.2rem; }
            .wrap { padding: 1.5rem 1.2rem 3rem; }
            .form-grid { grid-template-columns: 1fr 1fr; }
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
    <a href="{{ route('admin.dashboard') }}" class="nav-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Dashboard
    </a>
</nav>

<div class="wrap">

    @if(Session::has('success'))
        <div class="alert alert-success">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <span>{{ Session::get('success') }}</span>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div><strong>Terjadi Kesalahan:</strong>
                <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="page-header">
        <div class="page-badge">Manajemen Data</div>
        <h1 class="page-title">Jadwal <span>Pelajaran</span></h1>
        <p class="page-sub">Atur jadwal pelajaran per kelas, hari, dan mata pelajaran</p>
    </div>

    {{-- FORM TAMBAH --}}
    <div class="sec-title">Tambah Jadwal Baru</div>
    <div class="card">
        <div class="card-head">
            <div class="card-head-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Input Jadwal Pelajaran
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf
                <div class="form-grid">

                    {{-- Hari --}}
                    <div class="form-col">
                        <label class="form-label">Hari</label>
                        <select name="hari" class="form-input @error('hari') error @enderror" required>
                            <option value="">-- Pilih Hari --</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $h)
                                <option value="{{ $h }}" {{ old('hari') === $h ? 'selected' : '' }}>{{ $h }}</option>
                            @endforeach
                        </select>
                        @error('hari')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Jam Ke --}}
                    <div class="form-col">
                        <label class="form-label">Jam Ke</label>
                        <input type="number" name="jam_ke"
                               class="form-input @error('jam_ke') error @enderror"
                               placeholder="1, 2, 3 ..."
                               value="{{ old('jam_ke') }}" min="1" required>
                        @error('jam_ke')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Mapel --}}
                    <div class="form-col">
                        <label class="form-label">Mata Pelajaran</label>
                        <select name="kode_mapel" class="form-input @error('kode_mapel') error @enderror" required>
                            <option value="">-- Pilih Mapel --</option>
                            @foreach($mapel as $m)
                                <option value="{{ $m->kode_mapel }}" {{ old('kode_mapel') === $m->kode_mapel ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('kode_mapel')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Guru --}}
                    <div class="form-col">
                        <label class="form-label">Guru</label>
                        <select name="nip" class="form-input @error('nip') error @enderror" required>
                            <option value="">-- Pilih Guru --</option>
                            @foreach($guru as $g)
                                <option value="{{ $g->nip }}" {{ old('nip') === $g->nip ? 'selected' : '' }}>
                                    {{ $g->nama_guru }}
                                </option>
                            @endforeach
                        </select>
                        @error('nip')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="form-col">
                        <label class="form-label">Kelas</label>
                        <div class="radio-inline">
                            <label class="radio-pill">
                                <input type="radio" name="kelas" value="XI SIJA 1"
                                       {{ old('kelas') === 'XI SIJA 1' ? 'checked' : '' }} required>
                                SIJA 1
                            </label>
                            <label class="radio-pill">
                                <input type="radio" name="kelas" value="XI SIJA 2"
                                       {{ old('kelas') === 'XI SIJA 2' ? 'checked' : '' }}>
                                SIJA 2
                            </label>
                        </div>
                        @error('kelas')<div class="form-err">{{ $message }}</div>@enderror
                    </div>

                    {{-- Tombol --}}
                    <div>
                        <button type="submit" class="btn btn-gold" style="width:100%">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="sec-title">Daftar Jadwal</div>
    <div class="card">
        <div class="card-head">
            <div class="card-head-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Semua Jadwal Terdaftar
            </div>
        </div>

        {{-- SEARCH --}}
        <div style="padding: 12px 16px; border-bottom: 1px solid var(--border-w);">
            <form method="GET" action="{{ route('admin.jadwal.index') }}" class="search-row">
                <input type="text" name="search" class="form-input"
                       placeholder="Cari berdasarkan kelas, hari, atau guru..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-teal btn-sm">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Cari
                </button>
            </form>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:13%">Hari</th>
                        <th style="width:8%; text-align:center">Jam</th>
                        <th style="width:22%">Mata Pelajaran</th>
                        <th style="width:25%">Guru</th>
                        <th style="width:15%">Kelas</th>
                        <th style="width:12%; text-align:center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $index => $item)
                        @php
                            $hariClass = [
                                'Senin'  => 'hari-senin',
                                'Selasa' => 'hari-selasa',
                                'Rabu'   => 'hari-rabu',
                                'Kamis'  => 'hari-kamis',
                                'Jumat'  => 'hari-jumat',
                            ][$item->hari] ?? '';
                        @endphp
                        <tr>
                            <td style="color:var(--muted)">{{ $jadwal->firstItem() + $index }}</td>
                            <td>
                                <span class="badge {{ $hariClass }}">{{ $item->hari }}</span>
                            </td>
                            <td style="text-align:center">
                                <span class="jam-badge">{{ $item->jam_ke }}</span>
                            </td>
                            <td>
                                <span class="badge badge-mapel">{{ $item->mapel->nama_mapel ?? '—' }}</span>
                            </td>
                            <td style="font-weight:500; font-size:13px">{{ $item->guru->nama_guru ?? '—' }}</td>
                            <td>
                                <span class="badge {{ $item->kelas === 'XI SIJA 1' ? 'badge-s1' : 'badge-s2' }}">
                                    {{ $item->kelas }}
                                </span>
                            </td>
                            <td style="text-align:center">
                                <a href="{{ route('admin.jadwal.edit', $item->kode_jam_pelajaran) }}" class="btn btn-orange btn-sm">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty">
                                    <div class="empty-icon">📭</div>
                                    <p>Belum ada data jadwal pelajaran</p>
                                    <small>Gunakan form di atas untuk menambahkan jadwal baru</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jadwal->hasPages())
            <div class="pagi">{{ $jadwal->links() }}</div>
        @endif

        <div class="table-footer">
            <span>Total jadwal terdaftar</span>
            <span class="badge badge-blue" style="font-size:12px; padding:4px 12px;">{{ $jadwal->total() }} item</span>
        </div>
    </div>

</div>

<footer>&copy; {{ date('Y') }} SMK — Sistem Presensi Digital Kelas XI SIJA 1 &amp; 2</footer>
</body>
</html>