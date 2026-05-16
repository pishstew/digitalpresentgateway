@extends('layouts.app')

@section('content')
<style>
/* Premium Dashboard Styles */
.dashboard-container {
    padding: 30px;
    max-width: 1200px;
    margin: 0 auto;
}

.dashboard-header {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    border-radius: 16px;
    padding: 30px;
    color: white;
    margin-bottom: 30px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -10%;
    width: 50%;
    height: 200%;
    background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, rgba(255,255,255,0) 70%);
    transform: rotate(30deg);
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 8px;
    position: relative;
    z-index: 1;
}

.dashboard-subtitle {
    color: #94a3b8;
    font-size: 1rem;
    position: relative;
    z-index: 1;
}

.controls-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 15px;
}

.tabs {
    display: flex;
    background: white;
    padding: 5px;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.tab-link {
    padding: 10px 24px;
    border-radius: 8px;
    text-decoration: none;
    color: #64748b;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.tab-link:hover {
    color: #0f172a;
    background: #f1f5f9;
}

.tab-link.active {
    background: #3b82f6;
    color: white;
    box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
}

.search-box {
    display: flex;
    position: relative;
}

.search-input {
    padding: 12px 20px 12px 45px;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    width: 300px;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.search-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    background: #f8fafc;
    padding: 16px 20px;
    text-align: left;
    font-size: 0.85rem;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #e2e8f0;
}

.data-table td {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    font-size: 0.95rem;
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background 0.2s ease;
}

.data-table tbody tr:hover {
    background: #f8fafc;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 0.8rem;
}

.status-H { background: #dcfce7; color: #16a34a; }
.status-I { background: #fef08a; color: #ca8a04; }
.status-S { background: #ffedd5; color: #ea580c; }
.status-A { background: #fee2e2; color: #dc2626; }
.status-none { background: #f1f5f9; color: #94a3b8; }

.student-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4f46e5;
    font-weight: 700;
}

.student-details {
    display: flex;
    flex-direction: column;
}

.student-name {
    font-weight: 600;
    color: #0f172a;
}

.student-nis {
    font-size: 0.8rem;
    color: #64748b;
}

.date-header {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.day-name {
    font-weight: 700;
}

.day-date {
    font-size: 0.75rem;
    font-weight: 400;
    color: #94a3b8;
    margin-top: 2px;
}

.legend {
    display: flex;
    gap: 15px;
    padding: 20px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: #64748b;
}
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard Walikelas</h1>
        <p class="dashboard-subtitle">Pantau presensi siswa minggu ini ({{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('d M Y') }})</p>
    </div>

    <div class="controls-container">
        <div class="tabs">
            <a href="{{ route('walikelas.dashboard', ['kelas' => 'XI SIJA 1', 'search' => $search]) }}" class="tab-link {{ $kelas == 'XI SIJA 1' ? 'active' : '' }}">XI SIJA 1</a>
            <a href="{{ route('walikelas.dashboard', ['kelas' => 'XI SIJA 2', 'search' => $search]) }}" class="tab-link {{ $kelas == 'XI SIJA 2' ? 'active' : '' }}">XI SIJA 2</a>
        </div>

        <form action="{{ route('walikelas.dashboard') }}" method="GET" class="search-box">
            <input type="hidden" name="kelas" value="{{ $kelas }}">
            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" name="search" class="search-input" placeholder="Cari nama siswa..." value="{{ $search }}">
        </form>
    </div>

    <div class="table-card">
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th style="text-align: center;">Kelas</th>
                        @foreach($days as $index => $day)
                        <th style="text-align: center;">
                            <div class="date-header">
                                <span class="day-name">{{ $day }}</span>
                                <span class="day-date">{{ \Carbon\Carbon::parse($weekDates[$index])->translatedFormat('d M') }}</span>
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $siswa)
                    <tr>
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">
                                    {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
                                </div>
                                <div class="student-details">
                                    <span class="student-name">{{ $siswa->nama_siswa }}</span>
                                    <span class="student-nis">{{ $siswa->nis }}</span>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center; font-weight: 500;">{{ $siswa->kelas }}</td>
                        
                        @foreach($weekDates as $date)
                            @php
                                // Find presensi for this date
                                $presensiToday = $siswa->presensi->firstWhere('tanggal', $date);
                                $status = $presensiToday ? $presensiToday->status : null;
                                
                                $statusClass = 'status-none';
                                $statusText = '-';
                                
                                if ($status) {
                                    $statusClass = 'status-' . strtoupper(substr($status, 0, 1));
                                    $statusText = strtoupper(substr($status, 0, 1));
                                }
                            @endphp
                            <td style="text-align: center;">
                                <div class="status-badge {{ $statusClass }}" title="{{ $status ?? 'Belum ada data' }}">
                                    {{ $statusText }}
                                </div>
                            </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                            <div style="font-size: 3rem; margin-bottom: 10px;">📭</div>
                            <p style="font-weight: 600; font-size: 1.1rem; color: #0f172a;">Tidak ada siswa ditemukan</p>
                            <p>Coba ubah kata kunci pencarian atau pilih kelas lain.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="legend">
            <div class="legend-item"><div class="status-badge status-H" style="width:20px;height:20px;font-size:0.7rem;">H</div> Hadir</div>
            <div class="legend-item"><div class="status-badge status-I" style="width:20px;height:20px;font-size:0.7rem;">I</div> Izin</div>
            <div class="legend-item"><div class="status-badge status-S" style="width:20px;height:20px;font-size:0.7rem;">S</div> Sakit</div>
            <div class="legend-item"><div class="status-badge status-A" style="width:20px;height:20px;font-size:0.7rem;">A</div> Alpha</div>
            <div class="legend-item"><div class="status-badge status-none" style="width:20px;height:20px;font-size:0.7rem;">-</div> Kosong</div>
        </div>
    </div>
</div>
@endsection
