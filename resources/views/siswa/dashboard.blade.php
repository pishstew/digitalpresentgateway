@extends('layouts.app')

@section('content')
<div class="page-bg">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <h1 class="hero-title">👋 Selamat Datang, {{ $siswa ? $siswa->nama_siswa : Auth::user()->name }}</h1>
        <p class="hero-sub">Dashboard Siswa - Sistem Presensi Digital</p>
    </div>

    <div class="dash-body" style="max-width: 1100px;">

        @if ($message = Session::get('success'))
            <div class="alert-success">✅ {{ $message }}</div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert-error">❌ {{ $message }}</div>
        @endif

        <div class="dash-grid" style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 24px; margin-top: 20px;">
            
            {{-- KOLOM KIRI: DAFTAR JADWAL HARI INI --}}
            <div class="g-card">
                <div class="g-card-header">
                    <h2>📅 Jadwal Hari Ini</h2>
                </div>
                <div class="g-card-body">
                    @if($jadwalHariIni->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach($jadwalHariIni as $jadwal)
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border-radius: 14px; border: 1px solid {{ ($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'var(--blue)' : '#e2e8f0' }}; background: {{ ($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'rgba(59, 130, 246, 0.05)' : 'white' }}; transition: all 0.3s;">
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <div style="width: 45px; height: 45px; border-radius: 10px; background: {{ $jadwal->sudah_absen ? 'rgba(16, 185, 129, 0.1)' : 'rgba(100, 116, 139, 0.1)' }}; display: flex; align-items: center; justify-content: center; font-weight: 800; color: {{ $jadwal->sudah_absen ? '#10b981' : '#64748b' }};">
                                            {{ $jadwal->jam_ke }}
                                        </div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 15px; color: #1e293b;">{{ $jadwal->mapel->nama_mapel ?? 'Mapel' }}</h4>
                                            <p style="margin: 2px 0 0 0; font-size: 12px; color: #64748b;">
                                                @if($jadwal->sudah_absen)
                                                    <span style="color: #10b981; font-weight: 600;">✅ Sudah Hadir ({{ date('H:i', strtotime($jadwal->data_presensi->jam_masuk)) }})</span>
                                                @else
                                                    <span>Belum Presensi</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    @if(!$jadwal->sudah_absen)
                                        <a href="?jadwal_id={{ $jadwal->kode_jam_pelajaran }}" class="btn btn-sm {{ ($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'btn-blue' : 'btn-outline' }}">
                                            {{ ($activeJadwal && $activeJadwal->kode_jam_pelajaran == $jadwal->kode_jam_pelajaran) ? 'Dipilih' : 'Pilih' }}
                                        </a>
                                    @else
                                        <span class="badge badge-green">Selesai</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">🏖️</div>
                            <p>Tidak ada jadwal untuk hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- KOLOM KANAN: FORM PRESENSI --}}
            <div class="g-card">
                <div class="g-card-header" style="text-align: center;">
                    <h2>📝 Masukkan Kode</h2>
                </div>
                <div class="g-card-body" style="padding: 24px;">
                    @if($activeJadwal)
                        <div style="text-align: center; margin-bottom: 20px; padding: 12px; background: rgba(59, 130, 246, 0.05); border-radius: 10px; border: 1px dashed #3b82f6;">
                            <p style="margin: 0; color: #64748b; font-size: 11px; text-transform: uppercase;">Presensi Untuk</p>
                            <h3 style="margin: 3px 0; color: #1e293b; font-size: 16px; font-weight: 700;">{{ $activeJadwal->mapel->nama_mapel }}</h3>
                            <span class="badge badge-blue">Jam ke-{{ $activeJadwal->jam_ke }}</span>
                        </div>

                        <form action="{{ route('siswa.presensi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kode_jam_pelajaran" value="{{ $activeJadwal->kode_jam_pelajaran }}">
                            
                            <div style="border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0;">
                                <div style="background: var(--navy); padding: 12px; text-align: center;">
                                    <h3 style="margin: 0; color: white; font-size: 13px;">Kode 4 Digit</h3>
                                </div>
                                <div style="background-color: white; padding: 20px;">
                                    <input type="text" name="token" id="token_input" maxlength="4" required
                                        style="width: 100%; padding: 12px; font-size: 28px; text-align: center; letter-spacing: 0.5em; border: 2px solid #e2e8f0; border-radius: 10px; outline: none; color: #1e293b; font-family: monospace;" 
                                        placeholder="0000" oninput="updateTokenUI(this)">
                                    
                                    <button type="submit" id="submit_token_btn" disabled
                                        style="width: 100%; margin-top: 15px; padding: 14px; background-color: #cbd5e1; color: white; border: none; border-radius: 10px; font-weight: 700; cursor: not-allowed; transition: all 0.3s;">
                                        Konfirmasi Kehadiran
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="empty-state" style="padding: 20px 0;">
                            <div style="font-size: 50px; margin-bottom: 15px;">🎉</div>
                            <h3 style="color: #1e293b; margin-bottom: 5px;">Semua Selesai!</h3>
                            <p style="color: #64748b; font-size: 13px;">Anda telah menyelesaikan semua presensi untuk hari ini.</p>
                            <a href="{{ route('siswa.presensi.index') }}" class="btn btn-teal btn-sm" style="margin-top: 15px;">Lihat Riwayat</a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>


<script>
    function updateTokenUI(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        const valLength = input.value.length;
        const btn = document.getElementById('submit_token_btn');
        const inputField = document.getElementById('token_input');

        if(valLength === 4) {
            btn.style.backgroundColor = '#10b981';
            btn.style.cursor = 'pointer';
            btn.disabled = false;
        } else {
            btn.style.backgroundColor = '#cbd5e1'; 
            btn.style.cursor = 'not-allowed';
            btn.disabled = true;
        }
    }
</script>

<style>
    @media (max-width: 850px) {
        .dash-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
