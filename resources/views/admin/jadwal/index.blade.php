@extends('layouts.app')

@section('content')
<div class="page-bg">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">🕐 Manajemen Jadwal Pelajaran</h1>
        <p class="hero-sub">Kelola jadwal pelajaran sekolah dengan mudah dan efisien</p>
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
            <h2>➕ Tambah Jadwal Pelajaran</h2>
            <form action="{{ route('admin.jadwal.store') }}" method="POST" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label class="form-label">📅 Hari</label>
                    <select name="hari" class="form-input" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">⏰ Jam Ke</label>
                    <input type="text" name="jam_ke" class="form-input" placeholder="1-2" required>
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
                <div class="form-group">
                    <label class="form-label">🧑‍🏫 Guru</label>
                    <select name="nip" class="form-input" required>
                        <option value="">-- Pilih Guru --</option>
                        @foreach($guru as $g)
                            <option value="{{ $g->nip }}">{{ $g->nama_guru }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">👥 Kelas</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="kelas" value="XI SIJA 1" required> XI SIJA 1
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="kelas" value="XI SIJA 2" required> XI SIJA 2
                        </label>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-teal">➕ Tambah Jadwal</button>
                </div>
            </form>
        </div>

        {{-- SEARCH --}}
        <div class="g-card">
            <div class="g-card-header"><h2>🔍 Cari Jadwal</h2></div>
            <div class="g-card-body">
                <form method="GET" class="search-section">
                    <input type="text" name="search" class="form-input" placeholder="Cari berdasarkan kelas..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-blue">Cari</button>
                </form>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="g-card">
            <div class="g-card-header"><h2>📋 Daftar Jadwal Pelajaran</h2></div>

            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 13%;">Hari</th>
                            <th style="width: 8%;">Jam Ke</th>
                            <th style="width: 22%;">Mata Pelajaran</th>
                            <th style="width: 24%;">Guru</th>
                            <th style="width: 15%;">Kelas</th>
                            <th style="width: 13%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $index => $item)
                            <tr>
                                <td>{{ $jadwal->firstItem() + $index }}</td>
                                <td><span class="badge badge-violet">{{ $item->hari }}</span></td>
                                <td style="font-weight: 600;">{{ $item->jam_ke }}</td>
                                <td><span class="badge badge-navy">{{ $item->mapel->nama_mapel ?? '-' }}</span></td>
                                <td style="font-weight: 500;">{{ $item->guru->nama_guru ?? '-' }}</td>
                                <td><span class="badge badge-blue">{{ $item->kelas }}</span></td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.jadwal.edit', $item->kode_jam_pelajaran) }}" class="btn btn-sm btn-orange">✏️ Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">📭</div>
                                        <p>Belum ada data jadwal pelajaran</p>
                                        <small>Gunakan form di atas untuk menambahkan data baru</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $jadwal->links() }}
            </div>

            <div class="card-footer">
                <span>📊 Total Jadwal</span>
                <span class="badge badge-blue">{{ $jadwal->total() }} item</span>
            </div>
        </div>

    </div>
</div>
@endsection