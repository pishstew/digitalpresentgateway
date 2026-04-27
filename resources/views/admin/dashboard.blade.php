@extends('layouts.app')

@section('content')
<div class="page-bg">

    {{-- HERO --}}
    <div class="page-hero">
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo SMK Negeri 6 Malang">
        </div>
        <h1 class="hero-title">Dashboard Admin</h1>
        <p class="hero-sub">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    <div class="dash-body">

        @if(session('success'))
            <div class="alert-success">✅ {{ session('success') }}</div>
        @endif

        {{-- STATISTIK --}}
        <div class="stats-grid">
            <a href="{{ route('admin.siswa.index') }}" class="stat-card s-blue">
                <div class="stat-icon s-blue">👥</div>
                <div class="stat-count">{{ $siswaCount }}</div>
                <div class="stat-label">Total Siswa</div>
            </a>
            <a href="{{ route('admin.guru.index') }}" class="stat-card s-teal">
                <div class="stat-icon s-teal">🧑‍🏫</div>
                <div class="stat-count">{{ $guruCount }}</div>
                <div class="stat-label">Total Guru</div>
            </a>
            <a href="{{ route('admin.mapel.index') }}" class="stat-card s-violet">
                <div class="stat-icon s-violet">📚</div>
                <div class="stat-count">{{ $mapelCount }}</div>
                <div class="stat-label">Mata Pelajaran</div>
            </a>
            <a href="{{ route('admin.jadwal.index') }}" class="stat-card s-yellow">
                <div class="stat-icon s-yellow">🕐</div>
                <div class="stat-count">{{ $jadwalCount }}</div>
                <div class="stat-label">Jadwal Pelajaran</div>
            </a>
            <a href="{{ route('admin.presensi.index') }}" class="stat-card s-red" style="grid-column: span 2;">
                <div class="stat-icon s-red">✅</div>
                <div class="stat-count">{{ $presensiCount }}</div>
                <div class="stat-label">Total Presensi</div>
            </a>
        </div>

        {{-- MENU MANAJEMEN --}}
        <div class="g-card">
            <div class="g-card-header">
                <h2>📋 Manajemen Data</h2>
            </div>
            <div class="g-card-body" style="padding: 8px 16px 16px;">
                <a href="{{ route('admin.siswa.index') }}" class="nav-menu-link">
                    <div class="nav-menu-icon nav-icon-blue">👥</div>
                    <span>Data Siswa</span>
                    <span class="nav-menu-chevron">›</span>
                </a>
                <div class="nav-menu-divider"></div>

                <a href="{{ route('admin.guru.index') }}" class="nav-menu-link">
                    <div class="nav-menu-icon nav-icon-teal">🧑‍🏫</div>
                    <span>Data Guru</span>
                    <span class="nav-menu-chevron">›</span>
                </a>
                <div class="nav-menu-divider"></div>

                <a href="{{ route('admin.mapel.index') }}" class="nav-menu-link">
                    <div class="nav-menu-icon nav-icon-violet">📚</div>
                    <span>Mata Pelajaran</span>
                    <span class="nav-menu-chevron">›</span>
                </a>
                <div class="nav-menu-divider"></div>

                <a href="{{ route('admin.jadwal.index') }}" class="nav-menu-link">
                    <div class="nav-menu-icon nav-icon-yellow">🕐</div>
                    <span>Jadwal Pelajaran</span>
                    <span class="nav-menu-chevron">›</span>
                </a>
                <div class="nav-menu-divider"></div>

                <a href="{{ route('admin.presensi.index') }}" class="nav-menu-link">
                    <div class="nav-menu-icon nav-icon-red">✅</div>
                    <span>Data Presensi</span>
                    <span class="nav-menu-chevron">›</span>
                </a>
            </div>
        </div>

        {{-- LOGOUT --}}
        <div class="g-card">
            <div class="g-card-body" style="padding: 12px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-red btn-full">
                        ↪ Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection