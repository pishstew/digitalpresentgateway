@php $role = Auth::user()->role; @endphp

<style>
/* ── TOPBAR ──────────────────────────────────────────── */
.topbar {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    height: 60px;
    background: rgba(15, 23, 42, 0.97);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(255,255,255,.07);
    display: flex; align-items: center;
    padding: 0 20px; gap: 14px;
}

.topbar-brand {
    display: flex; align-items: center; gap: 10px;
    text-decoration: none; flex-shrink: 0;
}
.topbar-brand-icon {
    width: 34px; height: 34px; border-radius: 9px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; box-shadow: 0 4px 12px rgba(59,130,246,.4);
}
.topbar-brand-text {
    font-size: 0.95rem; font-weight: 700; color: white;
    letter-spacing: -.01em;
}
.topbar-brand:hover { text-decoration: none; }

.topbar-divider { width: 1px; height: 26px; background: rgba(255,255,255,.1); flex-shrink: 0; }

.role-badge {
    padding: 3px 9px; border-radius: 20px;
    font-size: 0.68rem; font-weight: 700; letter-spacing: .06em;
    text-transform: uppercase; flex-shrink: 0;
}
.role-badge.admin  { background: rgba(239,68,68,.15);  color: #f87171; border: 1px solid rgba(239,68,68,.2); }
.role-badge.guru   { background: rgba(59,130,246,.15); color: #60a5fa; border: 1px solid rgba(59,130,246,.2); }
.role-badge.siswa  { background: rgba(34,197,94,.15);  color: #4ade80; border: 1px solid rgba(34,197,94,.2); }
.role-badge.walikelas { background: rgba(168,85,247,.15); color: #c084fc; border: 1px solid rgba(168,85,247,.2); }

/* Nav links — center */
.topbar-nav {
    display: flex; align-items: center; gap: 2px;
    margin: 0 auto;
}
.topbar-nav-link {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 13px; border-radius: 8px;
    text-decoration: none; color: rgba(255,255,255,.5);
    font-size: 0.855rem; font-weight: 500;
    transition: all .16s ease; white-space: nowrap;
    position: relative;
}
.topbar-nav-link:hover { color: white; background: rgba(255,255,255,.07); text-decoration: none; }
.topbar-nav-link.active { color: white; background: rgba(59,130,246,.18); }
.topbar-nav-link.active::after {
    content: ''; position: absolute; bottom: -1px; left: 14px; right: 14px;
    height: 2px; background: #3b82f6; border-radius: 2px 2px 0 0;
}
.nav-em { font-size: 0.95rem; line-height: 1; }

/* User button */
.topbar-right { margin-left: auto; flex-shrink: 0; position: relative; }
.user-btn {
    display: flex; align-items: center; gap: 8px;
    padding: 5px 10px 5px 5px; border-radius: 10px;
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.09);
    cursor: pointer; transition: all .16s; color: white;
    white-space: nowrap;
}
.user-btn:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.14); }
.user-avatar {
    width: 30px; height: 30px; border-radius: 8px;
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.82rem; font-weight: 800; color: white; flex-shrink: 0;
}
.user-name { font-size: 0.84rem; font-weight: 600; color: white; max-width: 130px; overflow: hidden; text-overflow: ellipsis; }
.chevron-icon { color: rgba(255,255,255,.35); transition: transform .2s; font-size: 0.6rem; }
.user-btn.open .chevron-icon { transform: rotate(180deg); }

/* Dropdown */
.user-dropdown {
    position: absolute; top: calc(100% + 8px); right: 0;
    width: 210px; background: #1e293b;
    border: 1px solid rgba(255,255,255,.09); border-radius: 12px;
    box-shadow: 0 24px 48px rgba(0,0,0,.5);
    overflow: hidden; display: none; z-index: 200;
    animation: dropIn .14s ease;
}
.user-dropdown.show { display: block; }
@keyframes dropIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }
.dd-header { padding: 13px 15px; border-bottom: 1px solid rgba(255,255,255,.07); }
.dd-name  { font-size: 0.875rem; font-weight: 700; color: white; }
.dd-email { font-size: 0.73rem; color: rgba(255,255,255,.35); margin-top: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.dd-logout { width: 100%; text-align: left; padding: 11px 15px; background: none; border: none; color: #f87171; font-size: 0.855rem; font-weight: 600; cursor: pointer; transition: background .14s; display: flex; align-items: center; gap: 8px; }
.dd-logout:hover { background: rgba(239,68,68,.1); }

/* Hamburger */
.hamburger { display: none; flex-direction: column; justify-content: center; gap: 5px; width: 36px; height: 36px; border-radius: 8px; background: none; border: none; cursor: pointer; padding: 0 7px; transition: background .15s; flex-shrink: 0; }
.hamburger:hover { background: rgba(255,255,255,.08); }
.hamburger span { display: block; height: 2px; background: rgba(255,255,255,.65); border-radius: 2px; transition: all .25s cubic-bezier(.4,0,.2,1); }
.hamburger span:nth-child(1) { width: 18px; }
.hamburger span:nth-child(2) { width: 22px; }
.hamburger span:nth-child(3) { width: 14px; }
.hamburger.open span:nth-child(1) { width: 20px; transform: translateY(7px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.hamburger.open span:nth-child(3) { width: 20px; transform: translateY(-7px) rotate(-45deg); }

/* ── SIDEBAR (mobile drawer) ─────────────────────────── */
.sidebar-overlay {
    display: none; position: fixed; inset: 0; z-index: 90;
    background: rgba(0,0,0,.55); backdrop-filter: blur(3px);
    transition: opacity .25s;
}
.sidebar-overlay.show { display: block; }

.sidebar {
    position: fixed; top: 60px; left: -270px; bottom: 0; z-index: 95;
    width: 260px; background: #0f172a;
    border-right: 1px solid rgba(255,255,255,.07);
    padding: 12px 10px 24px; overflow-y: auto;
    transition: left .28s cubic-bezier(.4,0,.2,1);
}
.sidebar.open { left: 0; }

.sb-label {
    font-size: 0.66rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; color: rgba(255,255,255,.22);
    padding: 0 10px; margin: 16px 0 5px;
}
.sb-link {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 10px; border-radius: 8px;
    text-decoration: none; color: rgba(255,255,255,.5);
    font-size: 0.875rem; font-weight: 500;
    transition: all .16s; margin-bottom: 1px;
}
.sb-link:hover { color: white; background: rgba(255,255,255,.07); text-decoration: none; }
.sb-link.active { color: white; background: rgba(59,130,246,.18); }
.sb-link .sb-em { font-size: 1.05rem; line-height: 1; }
.sb-logout { width: 100%; background: none; border: none; cursor: pointer; color: rgba(248,113,113,.75); text-align: left; }
.sb-logout:hover { color: #f87171; background: rgba(239,68,68,.08); }

/* push content below fixed topbar */
body { padding-top: 60px !important; margin: 0; }

/* ── RESPONSIVE ──────────────────────────────────────── */
@media (max-width: 820px) {
    .topbar-nav  { display: none; }
    .hamburger   { display: flex; }
}
@media (max-width: 500px) {
    .user-name { display: none; }
    .topbar-brand-text { display: none; }
}
</style>

{{-- ── TOPBAR ── --}}
<header class="topbar">

    {{-- Hamburger --}}
    <button class="hamburger" id="hamburger" onclick="toggleSidebar()" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>

    {{-- Brand --}}
    @if($role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="topbar-brand">
    @elseif($role === 'guru')
        <a href="{{ route('guru.dashboard') }}" class="topbar-brand">
    @elseif($role === 'walikelas')
        <a href="{{ route('walikelas.dashboard') }}" class="topbar-brand">
    @elseif($role === 'kakon')
        <a href="{{ route('kakon.dashboard') }}" class="topbar-brand">
    @else
        <a href="{{ route('siswa.dashboard') }}" class="topbar-brand">
    @endif
        <div class="topbar-brand-icon">📚</div>
        <span class="topbar-brand-text">Presensi Sekolah</span>
    </a>

    <div class="topbar-divider"></div>
    <span class="role-badge {{ $role }}">{{ ucfirst($role) }}</span>

    {{-- Center nav --}}
    <nav class="topbar-nav">
        @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}"      class="topbar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="nav-em">🏠</span>Dashboard</a>
            <a href="{{ route('admin.siswa.index') }}"    class="topbar-nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}"><span class="nav-em">👥</span>Siswa</a>
            <a href="{{ route('admin.guru.index') }}"     class="topbar-nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}"><span class="nav-em">🧑‍🏫</span>Guru</a>
            <a href="{{ route('admin.mapel.index') }}"    class="topbar-nav-link {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}"><span class="nav-em">📖</span>Mapel</a>
            <a href="{{ route('admin.jadwal.index') }}"   class="topbar-nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}"><span class="nav-em">🕐</span>Jadwal</a>
            <a href="{{ route('admin.presensi.index') }}" class="topbar-nav-link {{ request()->routeIs('admin.presensi.*') ? 'active' : '' }}"><span class="nav-em">✅</span>Presensi</a>

        @elseif($role === 'guru')
            <a href="{{ route('guru.dashboard') }}"       class="topbar-nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"><span class="nav-em">🏠</span>Dashboard</a>
            <a href="{{ route('guru.jadwal.index') }}"    class="topbar-nav-link {{ request()->routeIs('guru.jadwal.*') ? 'active' : '' }}"><span class="nav-em">📅</span>Jadwal Saya</a>
            <a href="{{ route('guru.presensi.index') }}"  class="topbar-nav-link {{ request()->routeIs('guru.presensi.*') ? 'active' : '' }}"><span class="nav-em">✅</span>Presensi</a>

        @elseif($role === 'siswa')
            <a href="{{ route('siswa.dashboard') }}"      class="topbar-nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"><span class="nav-em">🏠</span>Dashboard</a>
            <a href="{{ route('siswa.presensi.index') }}" class="topbar-nav-link {{ request()->routeIs('siswa.presensi.*') ? 'active' : '' }}"><span class="nav-em">✅</span>Presensi Saya</a>
            
        @elseif($role === 'walikelas')
            <a href="{{ route('walikelas.dashboard') }}"  class="topbar-nav-link {{ request()->routeIs('walikelas.dashboard') ? 'active' : '' }}"><span class="nav-em">📊</span>Dashboard Walikelas</a>
        
        @elseif($role === 'kakon')
            <a href="{{ route('kakon.dashboard') }}"  class="topbar-nav-link {{ request()->routeIs('kakon.dashboard') ? 'active' : '' }}"><span class="nav-em">📊</span>Dashboard Kakon</a>
        @endif
    </nav>

    {-- Theme Switch --}
    <div style="display:flex;align-items:center;gap:7px;flex-shrink:0;">
        <label class="theme-switch" title="Ganti tema">
            <input type="checkbox" class="dpg-theme-checkbox" aria-label="Toggle dark/light mode">
            <span class="track"></span>
            <span class="thumb"></span>
        </label>
        <span class="theme-label" style="font-size:.72rem;font-weight:600;letter-spacing:.04em;text-transform:uppercase;color:rgba(255,255,255,.45);white-space:nowrap;user-select:none;">Dark</span>
    </div>

        {-- User dropdown --}
    <div class="topbar-right">
        <div class="user-btn" id="userBtn" onclick="toggleUserMenu()">
            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <span class="user-name">{{ Auth::user()->name }}</span>
            <svg class="chevron-icon" width="10" height="6" viewBox="0 0 10 6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                <path d="M1 1l4 4 4-4"/>
            </svg>
        </div>
        <div class="user-dropdown" id="userDropdown">
            <div class="dd-header">
                <div class="dd-name">{{ Auth::user()->name }}</div>
                <div class="dd-email">{{ Auth::user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dd-logout">🚪 Keluar dari akun</button>
            </form>
        </div>
    </div>
</header>

{{-- ── SIDEBAR MOBILE ── --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<nav class="sidebar" id="sidebar">
    <div class="sb-label">Navigasi</div>

    @if($role === 'admin')
        <a href="{{ route('admin.dashboard') }}"      class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="sb-em">🏠</span>Dashboard</a>
        <a href="{{ route('admin.siswa.index') }}"    class="sb-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}"><span class="sb-em">👥</span>Siswa</a>
        <a href="{{ route('admin.guru.index') }}"     class="sb-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}"><span class="sb-em">🧑‍🏫</span>Guru</a>
        <a href="{{ route('admin.mapel.index') }}"    class="sb-link {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}"><span class="sb-em">📖</span>Mapel</a>
        <a href="{{ route('admin.jadwal.index') }}"   class="sb-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}"><span class="sb-em">🕐</span>Jadwal</a>
        <a href="{{ route('admin.presensi.index') }}" class="sb-link {{ request()->routeIs('admin.presensi.*') ? 'active' : '' }}"><span class="sb-em">✅</span>Presensi</a>

    @elseif($role === 'guru')
        <a href="{{ route('guru.dashboard') }}"       class="sb-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}"><span class="sb-em">🏠</span>Dashboard</a>
        <a href="{{ route('guru.jadwal.index') }}"    class="sb-link {{ request()->routeIs('guru.jadwal.*') ? 'active' : '' }}"><span class="sb-em">📅</span>Jadwal Saya</a>
        <a href="{{ route('guru.presensi.index') }}"  class="sb-link {{ request()->routeIs('guru.presensi.*') ? 'active' : '' }}"><span class="sb-em">✅</span>Presensi</a>

    @elseif($role === 'siswa')
        <a href="{{ route('siswa.dashboard') }}"      class="sb-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"><span class="sb-em">🏠</span>Dashboard</a>
        <a href="{{ route('siswa.presensi.index') }}" class="sb-link {{ request()->routeIs('siswa.presensi.*') ? 'active' : '' }}"><span class="sb-em">✅</span>Presensi Saya</a>

    @elseif($role === 'walikelas')
        <a href="{{ route('walikelas.dashboard') }}"  class="sb-link {{ request()->routeIs('walikelas.dashboard') ? 'active' : '' }}"><span class="sb-em">📊</span>Dashboard Walikelas</a>

    @elseif($role === 'kakon')
        <a href="{{ route('kakon.dashboard') }}" class="sb-link {{ request()->routeIs('kakon.dashboard') ? 'active' : '' }}"><span class="sb-em">📊</span>Dashboard Kakon</a>
    @endif

    <div class="sb-label" style="margin-top:24px;">Akun</div>
    <div class="dd-header" style="background:rgba(255,255,255,.03); border-radius:8px; border:1px solid rgba(255,255,255,.06); margin-bottom:8px;">
        <div class="dd-name">{{ Auth::user()->name }}</div>
        <div class="dd-email">{{ Auth::user()->email }}</div>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sb-link sb-logout"><span class="sb-em">🚪</span>Keluar</button>
    </form>
</nav>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('show');
    document.getElementById('hamburger').classList.toggle('open');
}
function toggleUserMenu() {
    document.getElementById('userDropdown').classList.toggle('show');
    document.getElementById('userBtn').classList.toggle('open');
}
document.addEventListener('click', function(e) {
    const btn = document.getElementById('userBtn');
    const dd  = document.getElementById('userDropdown');
    if (btn && !btn.contains(e.target)) {
        dd.classList.remove('show');
        btn.classList.remove('open');
    }
});
</script>