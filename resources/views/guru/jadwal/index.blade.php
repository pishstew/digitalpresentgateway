@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #1a2f4e;
        --accent:  #3b82f6;
        --green:   #16a34a;
        --bg:      #f1f5f9;
    }
    .page-bg { background: var(--bg); min-height: 100vh; }

    /* HEADER */
    .header-section {
        background: linear-gradient(135deg, #1a2f4e 0%, #243b5e 100%);
        padding: 30px; border-radius: 12px; color: white;
        margin-bottom: 24px; box-shadow: 0 8px 16px rgba(26,47,78,.3);
        display: flex; justify-content: space-between; align-items: center;
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

    /* INFO GURU */
    .guru-info {
        background: white; border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,.07);
        padding: 20px 24px; margin-bottom: 20px;
        display: flex; align-items: center; gap: 16px;
    }
    .guru-avatar {
        width: 52px; height: 52px; border-radius: 50%;
        background: linear-gradient(135deg, #1a2f4e, #3b82f6);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }
    .guru-info-text h3 { margin: 0 0 4px; font-size: 1rem; font-weight: 700; color: #1e293b; }
    .guru-info-text p  { margin: 0; font-size: 0.85rem; color: #64748b; }

    /* HARI TABS */
    .hari-tabs {
        display: flex; gap: 8px; margin-bottom: 20px;
        overflow-x: auto; padding-bottom: 4px;
    }
    .hari-tab {
        padding: 8px 18px; border-radius: 20px; font-size: 0.85rem;
        font-weight: 600; cursor: pointer; border: none;
        background: white; color: #64748b;
        box-shadow: 0 2px 8px rgba(0,0,0,.07);
        transition: all .2s; white-space: nowrap;
    }
    .hari-tab:hover { background: #eff6ff; color: var(--accent); }
    .hari-tab.active { background: var(--primary); color: white; box-shadow: 0 4px 12px rgba(26,47,78,.3); }
    .hari-tab.today  { border: 2px solid var(--green); }

    /* JADWAL CARD PER HARI */
    .hari-section { display: none; }
    .hari-section.active { display: block; }

    .g-card { background: white; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.07); overflow: hidden; margin-bottom: 16px; }

    .g-card-header {
        padding: 16px 24px; color: white;
        display: flex; align-items: center; gap: 10px;
    }
    .g-card-header.senin    { background: linear-gradient(135deg, #1a2f4e, #243b5e); }
    .g-card-header.selasa   { background: linear-gradient(135deg, #1e40af, #2563eb); }
    .g-card-header.rabu     { background: linear-gradient(135deg, #065f46, #059669); }
    .g-card-header.kamis    { background: linear-gradient(135deg, #92400e, #d97706); }
    .g-card-header.jumat    { background: linear-gradient(135deg, #6b21a8, #9333ea); }

    .g-card-header h2 { margin: 0; font-size: 1.1rem; font-weight: 700; }
    .today-badge {
        background: rgba(255,255,255,.25); padding: 2px 10px;
        border-radius: 12px; font-size: 0.75rem; font-weight: 600;
    }

    /* JADWAL ITEM (card style, bukan tabel) */
    .jadwal-list { padding: 16px; display: flex; flex-direction: column; gap: 12px; }
    .jadwal-item {
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        padding: 16px; display: flex; align-items: center; gap: 16px;
        transition: box-shadow .2s;
    }
    .jadwal-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,.1); }

    .jam-badge {
        background: #1a2f4e; color: white;
        border-radius: 10px; padding: 10px 14px;
        text-align: center; flex-shrink: 0; min-width: 60px;
    }
    .jam-badge .jam-num { font-size: 1.4rem; font-weight: 800; line-height: 1; }
    .jam-badge .jam-lbl { font-size: 0.65rem; color: rgba(255,255,255,.6); margin-top: 2px; }

    .jadwal-detail { flex: 1; }
    .jadwal-mapel { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
    .jadwal-meta  { font-size: 0.82rem; color: #64748b; display: flex; gap: 12px; flex-wrap: wrap; }
    .jadwal-meta span { display: flex; align-items: center; gap: 4px; }

    .badge-kelas {
        background: #eff6ff; color: var(--accent);
        padding: 4px 12px; border-radius: 20px;
        font-size: 0.8rem; font-weight: 700; flex-shrink: 0;
    }

    /* EMPTY */
    .empty-state { text-align: center; padding: 50px 20px; color: #94a3b8; }
    .empty-state .empty-icon { font-size: 3rem; margin-bottom: 12px; }
    .empty-state p { font-size: 0.95rem; font-weight: 500; margin: 0; }

    /* SEMUA TAB - tampilkan semua hari sekaligus */
    .show-all .hari-section { display: block !important; }

    @media(max-width:640px){
        .header-section { flex-direction: column; gap: 16px; }
        .jadwal-item { flex-wrap: wrap; }
    }
</style>

<div class="page-bg py-10">
<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

    {{-- HEADER --}}
    <div class="header-section">
        <div>
            <h1>📅 Jadwal Mengajar</h1>
            <p>{{ $guru->nama_guru ?? auth()->user()->name }} — NIP: {{ $guru->nip ?? '-' }}</p>
        </div>
        <a href="{{ route('guru.dashboard') }}" class="btn-back">⬅ Dashboard</a>
    </div>

    {{-- INFO GURU --}}
    <div class="guru-info">
        <div class="guru-avatar">👨‍🏫</div>
        <div class="guru-info-text">
            <h3>{{ $guru->nama_guru ?? auth()->user()->name }}</h3>
            <p>NIP: {{ $guru->nip ?? '-' }} &nbsp;·&nbsp; {{ $jadwalPerHari->sum(fn($j) => $j->count()) }} sesi per minggu</p>
        </div>
    </div>

    @if($jadwalPerHari->isEmpty())
        {{-- EMPTY STATE --}}
        <div class="g-card">
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>Belum ada jadwal mengajar terdaftar</p>
            </div>
        </div>
    @else
        {{-- TABS HARI --}}
        @php
            $hariKeys   = $jadwalPerHari->keys()->toArray();
            $activeHari = in_array($hariIni, $hariKeys) ? $hariIni : $hariKeys[0];
            $colorMap   = [
                'Senin'  => 'senin',
                'Selasa' => 'selasa',
                'Rabu'   => 'rabu',
                'Kamis'  => 'kamis',
                'Jumat'  => 'jumat',
            ];
            $emojiMap = [
                'Senin'  => '🌙',
                'Selasa' => '🔥',
                'Rabu'   => '🌿',
                'Kamis'  => '⚡',
                'Jumat'  => '🌟',
            ];
        @endphp

        <div class="hari-tabs" id="hariTabs">
            <button class="hari-tab" onclick="showSemua()" id="tab-semua">
                📋 Semua
            </button>
            @foreach($jadwalPerHari as $hari => $items)
                <button
                    class="hari-tab {{ $hari === $activeHari ? 'active' : '' }} {{ $hari === $hariIni ? 'today' : '' }}"
                    onclick="showHari('{{ $hari }}')"
                    id="tab-{{ $hari }}"
                >
                    {{ $emojiMap[$hari] ?? '' }} {{ $hari }}
                    @if($hari === $hariIni)
                        <span style="font-size:0.7rem; opacity:.7;"> (Hari ini)</span>
                    @endif
                </button>
            @endforeach
        </div>

        {{-- JADWAL PER HARI --}}
        <div id="jadwalContainer">
            @foreach($jadwalPerHari as $hari => $items)
                <div class="hari-section {{ $hari === $activeHari ? 'active' : '' }}" id="section-{{ $hari }}">
                    <div class="g-card">
                        <div class="g-card-header {{ $colorMap[$hari] ?? 'senin' }}">
                            <span style="font-size:1.3rem;">{{ $emojiMap[$hari] ?? '📅' }}</span>
                            <h2>{{ $hari }}</h2>
                            @if($hari === $hariIni)
                                <span class="today-badge">Hari ini</span>
                            @endif
                            <span style="margin-left:auto; font-size:0.85rem; opacity:.7;">
                                {{ $items->count() }} sesi
                            </span>
                        </div>
                        <div class="jadwal-list">
                            @foreach($items as $j)
                                <div class="jadwal-item">
                                    <div class="jam-badge">
                                        <div class="jam-num">{{ $j->jam_ke }}</div>
                                        <div class="jam-lbl">JAM KE</div>
                                    </div>
                                    <div class="jadwal-detail">
                                        <div class="jadwal-mapel">
                                            {{ $j->mapel->nama_mapel ?? $j->kode_mapel }}
                                        </div>
                                        <div class="jadwal-meta">
                                            <span>🏫 Kelas {{ $j->kelas }}</span>
                                            <span>📌 Kode: {{ $j->kode_jam_pelajaran }}</span>
                                        </div>
                                    </div>
                                    <div class="badge-kelas">{{ $j->kelas }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
</div>

<script>
    function showHari(hari) {
        // Hapus class semua dari container
        document.getElementById('jadwalContainer').classList.remove('show-all');

        // Semua section disembunyikan
        document.querySelectorAll('.hari-section').forEach(s => s.classList.remove('active'));

        // Semua tab di-reset
        document.querySelectorAll('.hari-tab').forEach(t => t.classList.remove('active'));

        // Tampilkan yang dipilih
        const section = document.getElementById('section-' + hari);
        const tab     = document.getElementById('tab-' + hari);
        if (section) section.classList.add('active');
        if (tab)     tab.classList.add('active');
    }

    function showSemua() {
        document.getElementById('jadwalContainer').classList.add('show-all');
        document.querySelectorAll('.hari-tab').forEach(t => t.classList.remove('active'));
        document.getElementById('tab-semua').classList.add('active');
    }
</script>
@endsection