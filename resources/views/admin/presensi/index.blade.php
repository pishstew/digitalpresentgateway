@extends('layouts.app')

@section('content')
<div class="page-bg">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">✅ Data Presensi</h1>
        <p class="hero-sub">Lihat dan kelola data presensi siswa sekolah</p>
    </div>

    <div class="dash-body" style="max-width: 1100px;">

        @if ($message = Session::get('success'))
            <div class="alert-success">✅ {{ $message }}</div>
        @endif

        {{-- ACTION BAR --}}
        <div style="display: flex; justify-content: flex-start; margin-bottom: 16px;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-slate">⬅️ Dashboard</a>
        </div>

        {{-- FILTER KELAS --}}
        <div class="g-card">
            <div class="g-card-header"><h2>📚 Pilih Kelas</h2></div>
            <div class="g-card-body" style="display: flex; gap: 12px;">
                <a href="{{ route('admin.presensi.index', ['kelas' => 'XI SIJA 1']) }}"
                   class="btn btn-lg {{ $kelas === 'XI SIJA 1' ? 'btn-blue' : 'btn-outline' }}" style="flex: 1; justify-content: center;">
                   👥 XI SIJA 1
                </a>
                <a href="{{ route('admin.presensi.index', ['kelas' => 'XI SIJA 2']) }}"
                   class="btn btn-lg {{ $kelas === 'XI SIJA 2' ? 'btn-blue' : 'btn-outline' }}" style="flex: 1; justify-content: center;">
                   👥 XI SIJA 2
                </a>
            </div>
        </div>

        {{-- SEARCH --}}
        <div class="g-card">
            <div class="g-card-header"><h2>🔍 Cari Presensi</h2></div>
            <div class="g-card-body">
                <form method="GET" action="{{ route('admin.presensi.index') }}" class="search-section">
                    <input type="text" name="search" class="form-input" placeholder="Cari berdasarkan nama siswa atau status..." value="{{ request('search') }}">
                    @if($kelas)
                        <input type="hidden" name="kelas" value="{{ $kelas }}">
                    @endif
                    <button type="submit" class="btn btn-blue">Cari</button>
                </form>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="g-card">
            <div class="g-card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2>📋 Daftar Presensi @if($kelas) — {{ $kelas }} @endif</h2>
                <a href="{{ route('admin.presensi.export') }}" class="btn btn-sm btn-teal">⬇️ Export Excel</a>
            </div>

            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 15%;">Kode Presensi</th>
                            <th style="width: 22%;">Nama Siswa</th>
                            <th style="width: 13%;">Kelas</th>
                            <th style="width: 14%;">Tanggal</th>
                            <th style="width: 13%;">Jam Masuk</th>
                            <th style="width: 18%; text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($presensi as $index => $item)
                            <tr>
                                <td>{{ $presensi->firstItem() + $index }}</td>
                                <td style="font-family: monospace; font-weight: 600;">{{ $item->kode_presensi }}</td>
                                <td style="font-weight: 500;">{{ $item->siswa->nama_siswa ?? '-' }}</td>
                                <td><span class="badge badge-navy">{{ $item->jadwal->kelas ?? '-' }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $item->jam_masuk ?? '-' }}</td>
                                <td style="text-align: center;">
                                    @if($item->status === 'Hadir')
                                        <span class="badge badge-teal">Hadir ✓</span>
                                    @elseif($item->status === 'Izin')
                                        <span class="badge badge-yellow">Izin 📝</span>
                                    @elseif($item->status === 'Sakit')
                                        <span class="badge badge-orange">Sakit 🤒</span>
                                    @else
                                        <span class="badge badge-red">Alpa ✗</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">📭</div>
                                        <p>Belum ada data presensi</p>
                                        <small>Data presensi akan ditampilkan di sini</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $presensi->appends(request()->query())->links() }}
            </div>

            <div class="card-footer">
                <span>📊 Total Presensi</span>
                <span class="badge badge-blue">{{ $presensi->total() }} record</span>
            </div>
        </div>

    </div>
</div>
@endsection