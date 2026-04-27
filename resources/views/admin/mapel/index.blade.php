@extends('layouts.app')

@section('content')
<div class="page-bg">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">📚 Manajemen Mata Pelajaran</h1>
        <p class="hero-sub">Kelola data mata pelajaran sekolah dengan mudah dan efisien</p>
    </div>

    <div class="dash-body" style="max-width: 1100px;">

        @if ($message = Session::get('success'))
            <div class="alert-success">✅ {{ $message }}</div>
        @endif

        {{-- ACTION BAR --}}
        <div style="display: flex; justify-content: flex-start; margin-bottom: 16px;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-slate">⬅️ Dashboard</a>
        </div>

        {{-- FORM TAMBAH --}}
        <div class="form-section">
            <h2>➕ Tambah Mata Pelajaran</h2>
            <form action="{{ route('admin.mapel.store') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label class="form-label">🔑 Kode Mapel</label>
                    <input type="text" name="kode_mapel" class="form-input" placeholder="Contoh: MPL01" required>
                </div>
                <div class="form-group">
                    <label class="form-label">📖 Nama Mata Pelajaran</label>
                    <input type="text" name="nama_mapel" class="form-input" placeholder="Contoh: Bahasa Indonesia" required>
                </div>
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-teal">➕ Tambah Mapel</button>
                </div>
            </form>
        </div>

        {{-- SEARCH --}}
        <div class="g-card">
            <div class="g-card-header"><h2>🔍 Cari Mata Pelajaran</h2></div>
            <div class="g-card-body">
                <form method="GET" class="search-section">
                    <input type="text" name="search" class="form-input" placeholder="Cari berdasarkan kode atau nama mata pelajaran..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-blue">Cari</button>
                </form>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="g-card">
            <div class="g-card-header"><h2>📋 Daftar Mata Pelajaran</h2></div>

            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Kode Mapel</th>
                            <th style="width: 55%;">Nama Mata Pelajaran</th>
                            <th style="width: 15%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapel as $index => $item)
                            <tr>
                                <td>{{ $mapel->firstItem() + $index }}</td>
                                <td><span class="badge badge-navy" style="font-family: monospace;">{{ $item->kode_mapel }}</span></td>
                                <td style="font-weight: 500;">{{ $item->nama_mapel }}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.mapel.edit', $item->kode_mapel) }}" class="btn btn-sm btn-orange">✏️ Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-icon">📭</div>
                                        <p>Belum ada data mata pelajaran</p>
                                        <small>Gunakan form di atas untuk menambahkan data baru</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $mapel->links() }}
            </div>

            <div class="card-footer">
                <span>📊 Total Mata Pelajaran</span>
                <span class="badge badge-blue">{{ $mapel->total() }} item</span>
            </div>
        </div>

    </div>
</div>
@endsection