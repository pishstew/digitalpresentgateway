@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #1a2f4e;
        --accent:  #3b82f6;
        --green:   #16a34a;
        --red:     #dc2626;
        --orange:  #f97316;
        --bg:      #f1f5f9;
    }

    .page-bg { background: var(--bg); min-height: 100vh; }

    .header-section {
        background: linear-gradient(135deg, #1a2f4e 0%, #243b5e 100%);
        padding: 30px; border-radius: 12px; color: white;
        margin-bottom: 24px; box-shadow: 0 8px 16px rgba(26,47,78,.3);
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 16px;
    }
    .header-section h1 { color: white; font-size: 1.8rem; font-weight: 700; margin: 0 0 6px; }
    .header-section p  { color: rgba(255,255,255,.6); margin: 0; font-size: 0.9rem; }

    .btn-back {
        background: rgba(255,255,255,.15); color: white;
        padding: 10px 18px; border-radius: 8px; text-decoration: none;
        font-weight: 600; font-size: 0.9rem; border: 1px solid rgba(255,255,255,.25);
        transition: all .2s; white-space: nowrap;
    }
    .btn-back:hover { background: rgba(255,255,255,.25); color: white; text-decoration: none; }

    /* filter card */
    .g-card { background: white; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.07); margin-bottom: 20px; overflow: hidden; }
    .g-card-header { background: linear-gradient(135deg, #1a2f4e, #243b5e); padding: 16px 24px; color: white; }
    .g-card-header h2 { margin: 0; font-size: 1.1rem; font-weight: 600; }
    .g-card-body { padding: 20px 24px; }

    .filter-row { display: flex; gap: 12px; flex-wrap: wrap; }
    .filter-row select, .filter-row input[type=date] {
        padding: 10px 14px; border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-size: 0.9rem; color: #1e293b; background: white;
        appearance: none; cursor: pointer;
    }
    .filter-row select:focus, .filter-row input:focus { outline: none; border-color: var(--accent); }

    /* search */
    .search-row { display: flex; gap: 10px; }
    .search-row input {
        flex: 1; padding: 10px 16px; border: 1.5px solid #e2e8f0;
        border-radius: 8px; font-size: 0.9rem; color: #1e293b;
    }
    .search-row input:focus { outline: none; border-color: var(--accent); }
    .btn-search {
        padding: 10px 20px; background: var(--accent);
        color: white; border: none; border-radius: 8px;
        font-weight: 600; cursor: pointer; transition: all .2s;
    }
    .btn-search:hover { background: #2563eb; }

    /* stats */
    .stats-row { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; }
    .stat-box {
        flex: 1; min-width: 130px; padding: 16px;
        border-radius: 10px; text-align: center;
    }
    .stat-box .stat-num { font-size: 2rem; font-weight: 800; line-height: 1; }
    .stat-box .stat-lbl { font-size: 0.78rem; font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: .05em; }
    .stat-hadir  { background: #f0fdf4; color: var(--green); }
    .stat-belum  { background: #fef2f2; color: var(--red); }
    .stat-total  { background: #eff6ff; color: var(--accent); }

    /* tabs */
    .tabs { display: flex; gap: 4px; margin-bottom: 16px; }
    .tab {
        padding: 8px 20px; border-radius: 8px; font-size: 0.9rem;
        font-weight: 600; cursor: pointer; border: none;
        background: #f1f5f9; color: #64748b; text-decoration: none;
        transition: all .2s;
    }
    .tab.active { background: var(--accent); color: white; }
    .tab:hover { background: #e2e8f0; color: #1e293b; }
    .tab.active:hover { background: #2563eb; color: white; }

    /* table */
    .tbl { width: 100%; border-collapse: collapse; }
    .tbl thead { background: linear-gradient(90deg, #f0f4f8, #e2e8f0); }
    .tbl th { padding: 14px 16px; text-align: left; font-weight: 600; color: var(--primary); border-bottom: 2px solid #dde4ef; font-size: 0.85rem; }
    .tbl td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; color: #334155; }
    .tbl tbody tr { transition: background .15s; }
    .tbl tbody tr:hover { background: #fffbeb; }
    .tbl tbody tr.row-belum { background: #fff5f5; }
    .tbl tbody tr.row-belum:hover { background: #fee2e2; }

    /* badge */
    .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .badge-hadir  { background: #dcfce7; color: #15803d; }
    .badge-izin   { background: #fef9c3; color: #a16207; }
    .badge-sakit  { background: #fee2e2; color: #b91c1c; }
    .badge-alpa   { background: #f1f5f9; color: #475569; }
    .badge-belum  { background: #fef2f2; color: var(--red); border: 1px dashed var(--red); }

    /* update form inline */
    .status-form { display: flex; gap: 6px; align-items: center; }
    .status-select {
        padding: 5px 10px; border: 1.5px solid #e2e8f0; border-radius: 6px;
        font-size: 0.82rem; color: #334155; cursor: pointer;
    }
    .btn-update {
        padding: 5px 12px; background: var(--accent); color: white;
        border: none; border-radius: 6px; font-size: 0.82rem;
        font-weight: 600; cursor: pointer; transition: background .2s;
    }
    .btn-update:hover { background: #2563eb; }

    .empty-state { text-align: center; padding: 48px 20px; color: #94a3b8; }
    .empty-state p { font-size: 1rem; font-weight: 500; }

    .alert-ok  { background: #f0fdf4; border-left: 4px solid var(--green); border-radius: 8px; padding: 12px 16px; color: #15803d; font-size: 0.9rem; font-weight: 500; margin-bottom: 16px; }

    @media(max-width:640px){
        .header-section { flex-direction: column; }
        .filter-row { flex-direction: column; }
        .stats-row  { gap: 8px; }
    }
</style>

<div class="page-bg py-10">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="header-section mb-6">
            <div>
                <h1>📋 Rekap Presensi</h1>
                <p>Lihat kehadiran siswa & perbarui status</p>
            </div>
            <a href="{{ route('guru.dashboard') }}" class="btn-back">⬅ Dashboard</a>
        </div>

        @if(session('success'))
            <div class="alert-ok">✅ {{ session('success') }}</div>
        @endif

        {{-- Filter --}}
        <div class="g-card">
            <div class="g-card-header"><h2>🔽 Filter Kelas & Tanggal</h2></div>
            <div class="g-card-body">
                <form method="GET" action="{{ route('guru.presensi.index') }}">
                    <div class="filter-row">
                        <select name="jadwal_id" onchange="this.form.submit()" style="flex:1; min-width:200px;">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($jadwals as $j)
                                <option value="{{ $j->id }}" @selected($j->id == $jadwalId)>
                                    {{ $j->kelas }} — {{ $j->mapel->nama_mapel ?? $j->kode_mapel }}
                                    ({{ $j->jam_mulai }})
                                </option>
                            @endforeach
                        </select>
                        <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
                    </div>
                </form>
            </div>
        </div>

        @if($jadwal)

        {{-- Statistik --}}
        @php
            $totalSiswa  = $semuaSiswa->count();
            $jumlahHadir = $presensiHadir->count();
            $jumlahBelum = $totalSiswa - $jumlahHadir;
        @endphp

        <div class="stats-row">
            <div class="stat-box stat-total">
                <div class="stat-num">{{ $totalSiswa }}</div>
                <div class="stat-lbl">Total Siswa</div>
            </div>
            <div class="stat-box stat-hadir">
                <div class="stat-num">{{ $jumlahHadir }}</div>
                <div class="stat-lbl">Hadir</div>
            </div>
            <div class="stat-box stat-belum">
                <div class="stat-num">{{ $jumlahBelum }}</div>
                <div class="stat-lbl">Belum / Alpa</div>
            </div>
        </div>

        {{-- Search --}}
        <div class="g-card">
            <div class="g-card-body" style="padding: 16px 24px;">
                <form method="GET" action="{{ route('guru.presensi.index') }}" class="search-row">
                    <input type="hidden" name="jadwal_id" value="{{ $jadwalId }}">
                    <input type="hidden" name="tanggal"   value="{{ $tanggal }}">
                    <input type="text" name="search" placeholder="🔍 Cari nama siswa atau NIS..." value="{{ $search }}">
                    <button type="submit" class="btn-search">Cari</button>
                </form>
            </div>
        </div>

        {{-- Tab: Semua / Hadir / Belum --}}
        <div class="tabs">
            <a href="{{ request()->fullUrlWithQuery(['tab'=>'semua']) }}"
               class="tab @if(!request('tab') || request('tab')=='semua') active @endif">Semua</a>
            <a href="{{ request()->fullUrlWithQuery(['tab'=>'hadir']) }}"
               class="tab @if(request('tab')=='hadir') active @endif">✅ Hadir</a>
            <a href="{{ request()->fullUrlWithQuery(['tab'=>'belum']) }}"
               class="tab @if(request('tab')=='belum') active @endif">❌ Belum</a>
        </div>

        {{-- Tabel --}}
        <div class="g-card">
            <div class="g-card-header">
                <h2>📌 {{ $jadwal->kelas }} — {{ $jadwal->mapel->nama_mapel ?? '' }} — {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</h2>
            </div>
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Jam Masuk</th>
                            <th style="text-align:center">Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $tab = request('tab', 'semua');
                            $no  = 1;
                        @endphp

                        {{-- Siswa yang SUDAH hadir --}}
                        @foreach($presensiHadir as $p)
                            @if($tab == 'belum') @continue @endif
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td style="font-family:monospace;">{{ $p->nis }}</td>
                                <td style="font-weight:500;">{{ $p->siswa->nama_siswa ?? '-' }}</td>
                                <td>{{ $p->jam_masuk ?? '-' }}</td>
                                <td style="text-align:center;">
                                    @if($p->status === 'Hadir')
                                        <span class="badge badge-hadir">Hadir ✓</span>
                                    @elseif($p->status === 'Izin')
                                        <span class="badge badge-izin">Izin 📝</span>
                                    @elseif($p->status === 'Sakit')
                                        <span class="badge badge-sakit">Sakit 🤒</span>
                                    @else
                                        <span class="badge badge-alpa">Alpa ✗</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Update status (untuk kasus curang) --}}
                                    <form method="POST" action="{{ route('guru.presensi.update', $p->id) }}" class="status-form">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="jadwal_id" value="{{ $jadwalId }}">
                                        <input type="hidden" name="tanggal"   value="{{ $tanggal }}">
                                        <select name="status" class="status-select">
                                            <option value="Hadir"  @selected($p->status=='Hadir')>Hadir</option>
                                            <option value="Izin"   @selected($p->status=='Izin')>Izin</option>
                                            <option value="Sakit"  @selected($p->status=='Sakit')>Sakit</option>
                                            <option value="Alpa"   @selected($p->status=='Alpa')>Alpa</option>
                                        </select>
                                        <button type="submit" class="btn-update">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        {{-- Siswa yang BELUM presensi --}}
                        @if($tab !== 'hadir')
                            @foreach($semuaSiswa as $siswa)
                                @if(in_array($siswa->nis, $nisHadir)) @continue @endif
                                @if($search && stripos($siswa->nama_siswa, $search) === false && stripos($siswa->nis, $search) === false) @continue @endif
                                <tr class="row-belum">
                                    <td>{{ $no++ }}</td>
                                    <td style="font-family:monospace;">{{ $siswa->nis }}</td>
                                    <td style="font-weight:500;">{{ $siswa->nama_siswa }}</td>
                                    <td style="color:#94a3b8;">—</td>
                                    <td style="text-align:center;">
                                        <span class="badge badge-belum">Belum</span>
                                    </td>
                                    <td style="color:#94a3b8; font-size:0.82rem;">—</td>
                                </tr>
                            @endforeach
                        @endif

                        @if($no === 1)
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <p>📭 Tidak ada data yang ditampilkan</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @else
        <div class="g-card">
            <div class="g-card-body">
                <div class="empty-state">
                    <p>👆 Pilih kelas terlebih dahulu</p>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection