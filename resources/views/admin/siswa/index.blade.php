@extends('layouts.app')

@section('content')
<div class="page-bg">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">👥 Manajemen Siswa</h1>
        <p class="hero-sub">Kelola data siswa sekolah dengan mudah dan efisien</p>
    </div>

    <div class="dash-body" style="max-width: 1100px;">

        @if ($message = Session::get('success'))
            <div class="alert-success">✅ {{ $message }}</div>
        @endif

        {{-- ACTION BAR --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 10px;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-slate">⬅️ Dashboard</a>
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-teal">➕ Tambah Siswa</a>
        </div>

        {{-- CARD --}}
        <div class="g-card">
            <div class="g-card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <h2>📋 Daftar Siswa</h2>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <a href="{{ route('admin.siswa.index') }}"
                       class="btn btn-sm {{ !request('kelas') ? 'btn-yellow' : 'btn-outline' }}">
                       📚 Semua
                    </a>
                    <a href="{{ route('admin.siswa.index', ['kelas' => 'XI SIJA 1']) }}"
                       class="btn btn-sm {{ request('kelas') == 'XI SIJA 1' ? 'btn-yellow' : 'btn-outline' }}">
                       🎓 XI SIJA 1
                    </a>
                    <a href="{{ route('admin.siswa.index', ['kelas' => 'XI SIJA 2']) }}"
                       class="btn btn-sm {{ request('kelas') == 'XI SIJA 2' ? 'btn-yellow' : 'btn-outline' }}">
                       🎓 XI SIJA 2
                    </a>
                </div>
            </div>

            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 18%;">NIS</th>
                            <th style="width: 28%;">Nama Siswa</th>
                            <th style="width: 17%;">Kelas</th>
                            <th style="width: 17%; text-align: center;">Status</th>
                            <th style="width: 15%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $index => $item)
                            @php $userSiswa = \App\Models\User::where('email', 'siswa.' . $item->nis . '@sija.sch.id')->first(); @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td style="font-family: monospace; font-weight: 600;">{{ $item->nis }}</td>
                                <td style="font-weight: 500;">{{ $item->nama_siswa }}</td>
                                <td><span class="badge badge-navy">{{ $item->kelas }}</span></td>
                                <td style="text-align: center;">
                                    @if($userSiswa)
                                        <span class="badge {{ $userSiswa->is_active ? 'badge-teal' : 'badge-red' }}">
                                            {{ $userSiswa->is_active ? '✅ Aktif' : '🚫 Nonaktif' }}
                                        </span>
                                    @else
                                        <span class="badge badge-orange">⚠️ No Akun</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.siswa.edit', $item->nis) }}" class="btn btn-sm btn-orange">✏️ Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">📭</div>
                                        <p>Belum ada data siswa</p>
                                        <small>Klik tombol "Tambah Siswa" untuk menambahkan data baru</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap">
                {{ $siswa->appends(request()->query())->links() }}
            </div>

            <div class="card-footer">
                <span>📊 Total Siswa</span>
                <span class="badge badge-blue">{{ $siswa->total() }} orang</span>
            </div>
        </div>

    </div>
</div>
@endsection@extends('layouts.app')

@section('content')
<div class="page-bg">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">🎓 Manajemen Siswa</h1>
        <p class="hero-sub">Kelola data siswa sekolah dengan mudah dan efisien</p>
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-slate">⬅️ Dashboard</a>
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-teal">➕ Tambah Siswa</a>
        </div>

        {{-- IMPORT EXCEL --}}
        <div class="g-card" style="margin-bottom: 20px;">
            <div class="g-card-header">
                <h2>📥 Import Data Siswa dari Excel</h2>
            </div>
            <div class="g-card-body">
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 12px;">
                    Upload file Excel sesuai format template untuk menambahkan banyak siswa sekaligus.
                    Akun login akan dibuat otomatis untuk setiap siswa yang berhasil diimport.
                </p>

                {{-- Info format --}}
                <div style="background: var(--bg-soft); border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 13px;">
                    <strong>📋 Format kolom Excel:</strong>
                    <span style="font-family: monospace; background: #1e293b; color: #7dd3fc; padding: 2px 8px; border-radius: 4px; margin-left: 8px;">
                        NIS | Nama Siswa | Kelas
                    </span>
                    <br>
                    <span style="color: var(--text-muted); margin-top: 6px; display: block;">
                        ⚠️ Kolom Kelas hanya boleh diisi: <strong>XI SIJA 1</strong> atau <strong>XI SIJA 2</strong>
                        &nbsp;|&nbsp; Data diisi mulai baris ke-4
                    </span>
                </div>

                <div style="display: flex; gap: 12px; align-items: flex-start; flex-wrap: wrap;">
                    {{-- Form Upload --}}
                    <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data"
                          style="display: flex; gap: 10px; align-items: center; flex: 1; min-width: 280px;">
                        @csrf
                        <input type="file" name="file_import" accept=".xlsx,.xls"
                               class="form-input" style="flex: 1; padding: 6px 10px; font-size: 13px;" required>
                        <button type="submit" class="btn btn-teal" style="white-space: nowrap;">
                            📤 Upload & Import
                        </button>
                    </form>

                    {{-- Download Template --}}
                    <a href="{{ route('admin.siswa.template-import') }}" class="btn btn-yellow" style="white-space: nowrap;">
                        ⬇️ Download Template
                    </a>
                </div>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="g-card">
            <div class="g-card-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h2>📋 Daftar Siswa</h2>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.siswa.index') }}"
                       class="btn btn-sm {{ !request('kelas') ? 'btn-yellow' : 'btn-slate' }}">🏫 Semua</a>
                    <a href="{{ route('admin.siswa.index', ['kelas' => 'XI SIJA 1']) }}"
                       class="btn btn-sm {{ request('kelas') == 'XI SIJA 1' ? 'btn-yellow' : 'btn-slate' }}">🎓 XI SIJA 1</a>
                    <a href="{{ route('admin.siswa.index', ['kelas' => 'XI SIJA 2']) }}"
                       class="btn btn-sm {{ request('kelas') == 'XI SIJA 2' ? 'btn-yellow' : 'btn-slate' }}">🎓 XI SIJA 2</a>
                </div>
            </div>

            <div class="table-container">
                <table class="table-wrapper">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 20%;">NIS</th>
                            <th style="width: 32%;">Nama Siswa</th>
                            <th style="width: 18%;">Kelas</th>
                            <th style="width: 12%; text-align: center;">Status</th>
                            <th style="width: 13%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $index => $item)
                            @php $userSiswa = \App\Models\User::where('email', 'siswa.' . $item->nis . '@sija.sch.id')->first(); @endphp
                            <tr>
                                <td>{{ $siswa->firstItem() + $index }}</td>
                                <td style="font-family: monospace; font-weight: 600;">{{ $item->nis }}</td>
                                <td style="font-weight: 500;">{{ $item->nama_siswa }}</td>
                                <td><span class="badge badge-navy">{{ $item->kelas }}</span></td>
                                <td style="text-align: center;">
                                    @if($userSiswa)
                                        <span class="badge {{ $userSiswa->is_active ? 'badge-teal' : 'badge-red' }}">
                                            {{ $userSiswa->is_active ? '✅ Aktif' : '🚫 Nonaktif' }}
                                        </span>
                                    @else
                                        <span class="badge badge-orange">⚠️ No Akun</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.siswa.edit', $item->nis) }}" class="btn btn-sm btn-orange">✏️ Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
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

            <div class="pagination-wrap">
                {{ $siswa->links() }}
            </div>

            <div class="card-footer">
                <span>📊 Total Siswa</span>
                <span class="badge badge-blue">{{ $siswa->total() }} orang</span>
            </div>
        </div>

    </div>
</div>
@endsection