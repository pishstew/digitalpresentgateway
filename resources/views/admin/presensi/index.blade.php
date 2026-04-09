@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-blue: #003366;
        --secondary-blue: #0055cc;
        --light-blue: #e6f0ff;
        --dark-blue: #001f44;
        --gold-accent: #ffcc00;
    }

    /* Background Gradient */
    .page-bg {
        background: linear-gradient(135deg, #f0f4f8 0%, #e6f0ff 100%);
        min-height: 100vh;
    }

    /* Header Styling */
    .header-section {
        background: linear-gradient(135deg, #003366 0%, #0055cc 100%);
        padding: 30px;
        border-radius: 12px;
        color: white;
        margin-bottom: 30px;
        box-shadow: 0 8px 16px rgba(0, 51, 102, 0.3);
    }

    .header-section h1 {
        color: white;
        margin-bottom: 8px;
        font-size: 2.5rem;
        margin-top: 0;
    }

    .header-section p {
        color: #e6f0ff;
        font-size: 1.1rem;
        margin: 0;
    }

    /* Search Form */
    .search-section {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }

    .search-section input {
        flex: 1;
        padding: 10px 16px;
        border: 2px solid #cce6ff;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-section input:focus {
        border-color: var(--secondary-blue);
        outline: none;
        box-shadow: 0 0 8px rgba(0, 85, 204, 0.2);
    }

    .search-section button {
        padding: 10px 20px;
        background: linear-gradient(135deg, #003366 0%, #0055cc 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 8px rgba(0, 51, 102, 0.3);
    }

    .search-section button:hover {
        background: linear-gradient(135deg, #0055cc 0%, #003366 100%);
        transform: translateY(-2px);
    }

    /* Card Container */
    .card-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 51, 102, 0.15);
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #003366 0%, #0055cc 50%, #0077ff 100%);
        padding: 20px 30px;
        color: white;
    }

    .card-header h2 {
        margin: 0;
        font-size: 1.5rem;
    }

    /* Table Styling */
    .table-container {
        overflow-x: auto;
    }

    .table-wrapper {
        width: 100%;
        border-collapse: collapse;
    }

    .table-wrapper thead {
        background: linear-gradient(90deg, #e6f0ff 0%, #cce6ff 100%);
    }

    .table-wrapper th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--primary-blue);
        border-bottom: 2px solid var(--primary-blue);
    }

    .table-wrapper td {
        padding: 14px 20px;
        border-bottom: 1px solid #e0e7ff;
        color: #333;
    }

    .table-wrapper tbody tr {
        transition: all 0.3s ease;
    }

    .table-wrapper tbody tr:hover {
        background-color: #fffacd;
        box-shadow: inset 0 0 8px rgba(255, 204, 0, 0.2);
    }

    .table-wrapper tbody tr:nth-child(even) {
        background-color: #f5f9ff;
    }

    /* Badge Styles */
    .badge-status {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .badge-hadir {
        background: linear-gradient(135deg, #00cc66 0%, #00aa55 100%);
        color: white;
    }

    .badge-izin {
        background: linear-gradient(135deg, #ffa500 0%, #ff9500 100%);
        color: white;
    }

    .badge-sakit {
        background: linear-gradient(135deg, #ff6b6b 0%, #ff5252 100%);
        color: white;
    }

    .badge-alpa {
        background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
        color: white;
    }

    .badge-kelas {
        background: linear-gradient(135deg, #003366 0%, #0055cc 100%);
        color: white;
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0, 51, 102, 0.2);
    }

    /* Tombol Kembali ke Dashboard */
    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 3px 8px rgba(108, 117, 125, 0.3);
        margin-bottom: 20px;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(108, 117, 125, 0.4);
        text-decoration: none;
        color: white;
    }

    /* Card Footer */
    .card-footer {
        background: linear-gradient(90deg, #f5f9ff 0%, #e6f0ff 100%);
        padding: 16px 30px;
        border-top: 2px solid #cce6ff;
        color: var(--primary-blue);
        font-weight: 600;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state p:first-child {
        font-size: 1.3rem;
        font-weight: bold;
        color: #666;
        margin-bottom: 8px;
    }

    .empty-state p:last-child {
        color: #999;
        font-size: 0.95rem;
    }

    /* Success Alert */
    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border-left: 4px solid #28a745;
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .alert-success p {
        color: #155724;
        margin: 0;
        font-weight: 500;
    }

    /* Tombol Kembali ke Dashboard */
    .btn-back {
        background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 3px 8px rgba(108, 117, 125, 0.3);
        margin-bottom: 20px;
    }

    .btn-back:hover {
        background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(108, 117, 125, 0.4);
        text-decoration: none;
        color: white;
    }

    /* Kelas Filter Button */
    .btn-kelas {
        flex: 1;
        text-align: center;
        padding: 12px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid #0055cc;
        background: white;
        color: #0055cc;
        cursor: pointer;
        font-size: 1rem;
        box-shadow: 0 2px 4px rgba(0, 85, 204, 0.1);
    }

    .btn-kelas:hover {
        background: linear-gradient(135deg, #0055cc 0%, #003366 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 85, 204, 0.2);
    }

    .btn-kelas.active {
        background: linear-gradient(135deg, #0055cc 0%, #003366 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(0, 85, 204, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            text-align: center;
        }

        .header-section h1 {
            font-size: 1.8rem;
        }

        .table-wrapper th,
        .table-wrapper td {
            padding: 10px 12px;
            font-size: 0.85rem;
        }
    }
</style>

<div class="page-bg py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header Section with Gradient -->
        <div class="header-section mb-8" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>✅ Data Presensi</h1>
                <p>Lihat dan kelola data presensi siswa sekolah</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-back">
                ⬅️ Kembali ke Dashboard
            </a>
        </div>

        <!-- Success Alert -->
        @if ($message = Session::get('success'))
            <div class="alert-success">
                <p>✅ {{ $message }}</p>
            </div>
        @endif

        <!-- Kelas Filter Section -->
        <div class="card-container mb-8">
            <div class="card-header">
                <h2>📚 Pilih Kelas</h2>
            </div>
            <div style="padding: 20px 30px;">
                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('presensi.index', ['kelas' => 'XI SIJA 1']) }}" 
                       class="btn-kelas @if($kelas === 'XI SIJA 1') active @endif">
                        👥 XI SIJA 1
                    </a>
                    <a href="{{ route('presensi.index', ['kelas' => 'XI SIJA 2']) }}" 
                       class="btn-kelas @if($kelas === 'XI SIJA 2') active @endif">
                        👥 XI SIJA 2
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="card-container mb-8">
            <div class="card-header">
                <h2>🔍 Cari Presensi</h2>
            </div>
            <div style="padding: 20px 30px;">
                <form method="GET" class="search-section">
                    <input type="text" name="search" placeholder="Cari berdasarkan nama siswa atau status..." value="{{ request('search') }}">
                    @if($kelas)
                        <input type="hidden" name="kelas" value="{{ $kelas }}">
                    @endif
                    <button type="submit">Cari</button>
                </form>
            </div>
        </div>

        <!-- Card Container -->
        <div class="card-container">
            <!-- Card Header -->
            <div class="card-header">
                <h2>📋 Daftar Presensi @if($kelas) - {{ $kelas }} @endif</h2>
            </div>

            <!-- Table -->
            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 15%;">Kode Presensi</th>
                            <th style="width: 25%;">Nama Siswa</th>
                            <th style="width: 15%;">Kelas</th>
                            <th style="width: 15%;">Tanggal</th>
                            <th style="width: 15%;">Jam Masuk</th>
                            <th style="width: 10%; text-align: center;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($presensi as $index => $item)
                            <tr>
                                <td>{{ $presensi->firstItem() + $index }}</td>
                                <td style="font-family: monospace; font-weight: 500;">{{ $item->kode_presensi }}</td>
                                <td style="font-weight: 500;">{{ $item->siswa->nama_siswa ?? '-' }}</td>
                                <td>
                                    <span class="badge-kelas">{{ $item->jadwal->kelas ?? '-' }}</span>
                                </td>
                                <td style="font-weight: 500;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                <td style="font-weight: 500;">{{ $item->jam_masuk ?? '-' }}</td>
                                <td style="text-align: center;">
                                    @if($item->status === 'Hadir')
                                        <span class="badge-status badge-hadir">Hadir ✓</span>
                                    @elseif($item->status === 'Izin')
                                        <span class="badge-status badge-izin">Izin 📝</span>
                                    @elseif($item->status === 'Sakit')
                                        <span class="badge-status badge-sakit">Sakit 🤒</span>
                                    @else
                                        <span class="badge-status badge-alpa">Alpa ✗</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <p>📭 Belum ada data presensi</p>
                                        <p>Data presensi akan ditampilkan di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Card Footer -->
            <div class="card-footer">
                <span>📊 Total Presensi:</span>
                <span style="color: var(--secondary-blue); font-size: 1.2rem; margin-left: 8px;">{{ $presensi->total() }}</span>
                <span style="margin-left: 4px;">record</span>
                <a href="{{ route('presensi.export') }}" class="btn btn-success">
                Export Excel
                </a>
            </div>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $presensi->appends(request()->query())->links() }}
        </div>
    </div>
</div>

@endsection