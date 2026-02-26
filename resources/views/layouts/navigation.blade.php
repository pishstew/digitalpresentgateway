<nav x-data="{ open: false }" class="bg-blue-200 border-b border-blue-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('siswa.index') }}" class="text-blue-900 font-bold text-xl">
                        📚 Presensi Sekolah
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('siswa.index') }}" class="text-blue-900 {{ request()->routeIs('siswa.*') ? 'bg-blue-300' : 'hover:bg-blue-100' }} px-3 py-2 rounded-md text-sm font-medium transition">
                        👥 Siswa
                    </a>
                    <a href="{{ route('guru.index') }}" class="text-blue-900 {{ request()->routeIs('guru.*') ? 'bg-blue-300' : 'hover:bg-blue-100' }} px-3 py-2 rounded-md text-sm font-medium transition">
                        🧑‍🏫 Guru
                    </a>
                    <a href="{{ route('mapel.index') }}" class="text-blue-900 {{ request()->routeIs('mapel.*') ? 'bg-blue-300' : 'hover:bg-blue-100' }} px-3 py-2 rounded-md text-sm font-medium transition">
                        📖 Mapel
                    </a>
                    <a href="{{ route('jadwal.index') }}" class="text-blue-900 {{ request()->routeIs('jadwal.*') ? 'bg-blue-300' : 'hover:bg-blue-100' }} px-3 py-2 rounded-md text-sm font-medium transition">
                        🕐 Jadwal
                    </a>
                    <a href="{{ route('presensi.index') }}" class="text-blue-900 {{ request()->routeIs('presensi.*') ? 'bg-blue-300' : 'hover:bg-blue-100' }} px-3 py-2 rounded-md text-sm font-medium transition">
                        ✅ Presensi
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative">
                    <button onclick="toggleDropdown()" class="inline-flex items-center px-4 py-2 text-blue-900 bg-blue-100 hover:bg-blue-300 rounded-lg transition">
                        👤 {{ Auth::user()->name }}
                        <svg class="ms-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-50">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="text-sm font-bold text-gray-900">{{ Auth::user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="p-0">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 font-semibold transition">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-blue-900 hover:bg-blue-300 focus:outline-none transition">
                    
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-100">

        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('siswa.index') }}" class="block text-blue-900 px-4 py-2 rounded hover:bg-blue-200 {{ request()->routeIs('siswa.*') ? 'bg-blue-300' : '' }}">
                👥 Siswa
            </a>
            <a href="{{ route('guru.index') }}" class="block text-blue-900 px-4 py-2 rounded hover:bg-blue-200 {{ request()->routeIs('guru.*') ? 'bg-blue-300' : '' }}">
                🧑‍🏫 Guru
            </a>
            <a href="{{ route('mapel.index') }}" class="block text-blue-900 px-4 py-2 rounded hover:bg-blue-200 {{ request()->routeIs('mapel.*') ? 'bg-blue-300' : '' }}">
                📖 Mapel
            </a>
            <a href="{{ route('jadwal.index') }}" class="block text-blue-900 px-4 py-2 rounded hover:bg-blue-200 {{ request()->routeIs('jadwal.*') ? 'bg-blue-300' : '' }}">
                🕐 Jadwal
            </a>
            <a href="{{ route('presensi.index') }}" class="block text-blue-900 px-4 py-2 rounded hover:bg-blue-200 {{ request()->routeIs('presensi.*') ? 'bg-blue-300' : '' }}">
                ✅ Presensi
            </a>
        </div>

        <div class="pt-4 pb-1 border-t border-blue-300">
            <div class="px-4">
                <div class="font-medium text-base text-blue-900">
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-blue-700">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block text-red-600 hover:text-red-700 hover:bg-red-100 px-4 py-2 rounded font-semibold">
                        🚪 Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('userDropdown');
    const button = e.target.closest('button');
    if (!button || !button.textContent.includes('👤')) {
        dropdown.classList.add('hidden');
    }
});
</script>