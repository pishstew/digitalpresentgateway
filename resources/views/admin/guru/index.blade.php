@extends('layouts.app')

@section('content')
<div class="page-bg">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">🧑‍🏫 Manajemen Guru</h1>
        <p class="hero-sub">Kelola data guru sekolah dengan mudah dan efisien</p>
    </div>

    <div class="dash-body" style="max-width: 1100px;">

        @if ($message = Session::get('success'))
            <div class="alert-success">✅ {{ $message }}</div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert-error">❌ {{ $message }}</div>
        @endif

        @if (Session::has('import_errors'))
            <div class="alert-warning">
                <strong>⚠️ Detail error saat import:</strong>
                <ul style="margin: 8px 0 0 16px;">
                    @foreach (Session::get('import_errors') as $err)
                        <li style="font-size: 13px;">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ACTION BAR --}}
        <div style="display: flex; justify-content: flex-start; margin-bottom: 16px;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-slate">⬅️ Dashboard</a>
        </div>

        {{-- FORM TAMBAH --}}
        <div class="form-section">
            <h2>➕ Tambah Data Guru</h2>
            <form action="{{ route('admin.guru.store') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label class="form-label">🆔 NIP</label>
                    <input type="text" name="nip" class="form-input" placeholder="Nomor Induk Pegawai" required>
                </div>
                <div class="form-group">
                    <label class="form-label">👤 Nama Guru</label>
                    <input type="text" name="nama_guru" class="form-input" placeholder="Nama Lengkap" required>
                </div>
                <div class="form-group">
                    <label class="form-label">📚 Mata Pelajaran</label>
                    <select name="kode_mapel" class="form-input" required>
                        <option value="">-- Pilih Mapel --</option>
                        @foreach($mapel as $m)
                            <option value="{{ $m->kode_mapel }}">{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-teal">➕ Tambah Guru</button>
                </div>
            </form>
        </div>

        {{-- IMPORT EXCEL --}}
        <div class="g-card" style="margin-bottom: 20px;">
            <div class="g-card-header">
                <h2>📥 Import Data Guru dari Excel</h2>
            </div>
            <div class="g-card-body">
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 12px;">
                    Upload file Excel sesuai format template untuk menambahkan banyak guru sekaligus.
                    Akun login akan dibuat otomatis untuk setiap guru yang berhasil diimport.
                </p>

                {{-- Info format --}}
                <div style="background: var(--bg-soft); border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 13px;">
                    <strong>📋 Format kolom Excel:</strong>
                    <span style="font-family: monospace; background: #1e293b; color: #7dd3fc; padding: 2px 8px; border-radius: 4px; margin-left: 8px;">
                        NIP | Nama Guru | Kode Mapel
                    </span>
                    <br>
                    <span style="color: var(--text-muted); margin-top: 6px; display: block;">
                        ⚠️ Kode Mapel harus sesuai data yang ada di sistem (contoh: MTK, BIN, ING, dll.)
                        &nbsp;|&nbsp; Data diisi mulai baris ke-4
                    </span>
                </div>

                <div style="display: flex; gap: 12px; align-items: flex-start; flex-wrap: wrap;">
                    {{-- Form Upload --}}
                    <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data"
                          style="display: flex; gap: 10px; align-items: center; flex: 1; min-width: 280px;">
                        @csrf
                        <input type="file" name="file_import" accept=".xlsx,.xls"
                               class="form-input" style="flex: 1; padding: 6px 10px; font-size: 13px;" required>
                        <button type="submit" class="btn btn-teal" style="white-space: nowrap;">
                            📤 Upload & Import
                        </button>
                    </form>

                    {{-- Download Template --}}
                    <a href="{{ route('admin.guru.template-import') }}" class="btn btn-yellow" style="white-space: nowrap;">
                        ⬇️ Download Template
                    </a>
                </div>
            </div>
        </div>

        {{-- SEARCH --}}
        <div class="g-card">
            <div class="g-card-header"><h2>🔍 Cari Guru</h2></div>
            <div class="g-card-body">
                <form method="GET" action="{{ route('admin.guru.index') }}" class="search-section">
                    <input type="text" name="search" class="form-input"
                           placeholder="Cari berdasarkan NIP atau nama guru..."
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-blue">Cari</button>
                </form>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="g-card">
            <div class="g-card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2>📋 Daftar Guru</h2>
                <a href="{{ route('admin.guru.export') }}" class="btn btn-sm btn-yellow">⬇️ Export CSV</a>
            </div>

            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 20%;">NIP</th>
                            <th style="width: 28%;">Nama Guru</th>
                            <th style="width: 22%;">Mata Pelajaran</th>
                            <th style="width: 12%; text-align: center;">Status</th>
                            <th style="width: 13%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guru as $index => $item)
                            @php $userGuru = \App\Models\User::where('nip', $item->nip)->first(); @endphp
                            <tr>
                                <td>{{ $guru->firstItem() + $index }}</td>
                                <td style="font-family: monospace; font-weight: 600;">{{ $item->nip }}</td>
                                <td style="font-weight: 500;">{{ $item->nama_guru }}</td>
                                <td><span class="badge badge-navy">{{ $item->mapel->nama_mapel ?? '-' }}</span></td>
                                <td style="text-align: center;">
                                    @if($userGuru)
                                        <span class="badge {{ $userGuru->is_active ? 'badge-teal' : 'badge-red' }}">
                                            {{ $userGuru->is_active ? '✅ Aktif' : '🚫 Nonaktif' }}
                                        </span>
                                    @else
                                        <span class="badge badge-orange">⚠️ No Akun</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.guru.edit', $item->nip) }}" class="btn btn-sm btn-orange">✏️ Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">📭</div>
                                        <p>Belum ada data guru</p>
                                        <small>Gunakan form di atas untuk menambahkan data guru baru</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $guru->links() }}
            </div>

            <div class="card-footer">
                <span>📊 Total Guru</span>
                <span class="badge badge-blue">{{ $guru->total() }} orang</span>
            </div>
        </div>

    </div>
</div>
@endsection