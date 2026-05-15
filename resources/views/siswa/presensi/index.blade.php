@extends('layouts.app')

@section('content')
<div class="page-bg">
    <div class="page-hero">
        <h1 class="hero-title">Riwayat Presensi Saya</h1>
        <p class="hero-sub">Daftar lengkap kehadiran Anda</p>
    </div>

    <div class="dash-body" style="max-width: 1100px;">
        <div class="g-card" style="margin-bottom: 20px;">
            <div class="g-card-body" style="padding: 20px;">
                <form action="{{ route('siswa.presensi.search') }}" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;">Tanggal</label>
                        <input type="date" name="tanggal" class="form-input" value="{{ request('tanggal') }}" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--border-color, #ccc);">
                    </div>
                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px;">Status</label>
                        <select name="status" class="form-input" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid var(--border-color, #ccc);">
                            <option value="">Semua Status</option>
                            <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                            <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                        </select>
                    </div>
                    <div style="display: flex; align-items: flex-end;">
                        <button type="submit" class="btn btn-teal">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="g-card">
            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Mata Pelajaran</th>
                            <th>Jam Ke</th>
                            <th>Jam Masuk</th>
                            <th style="text-align: center;">Status</th>
                            <th>Token (Kode)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($presensi as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                                <td style="font-weight: 500;">{{ $item->jadwal->mapel->nama_mapel ?? '-' }}</td>
                                <td>Jam ke-{{ $item->jadwal->jam_ke ?? '-' }}</td>
                                <td>{{ $item->jam_masuk }}</td>
                                <td style="text-align: center;">
                                    @if($item->status == 'Hadir')
                                        <span class="badge badge-teal">Hadir</span>
                                    @elseif($item->status == 'Izin')
                                        <span class="badge badge-blue">Izin</span>
                                    @elseif($item->status == 'Sakit')
                                        <span class="badge badge-orange">Sakit</span>
                                    @else
                                        <span class="badge badge-red">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->token ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">📭</div>
                                        <p>Tidak ada data presensi ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($presensi->hasPages())
                <div style="padding: 15px; border-top: 1px solid var(--border-color, #eee);">
                    {{ $presensi->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
