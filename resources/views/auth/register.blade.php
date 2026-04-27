<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- NAME -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- EMAIL -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- PASSWORD -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- ROLE -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Daftar Sebagai')" />
            <select
                id="role"
                name="role"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
                onchange="toggleNip(this.value)"
            >
                <option value="">-- Pilih Role --</option>
                <option value="guru"  {{ old('role') === 'guru'  ? 'selected' : '' }}>Guru</option>
                <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                {{-- Admin tidak bisa daftar sendiri, hanya dibuat via seeder/manual --}}
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- NIP (hanya tampil jika role = guru) -->
        <div class="mt-4" id="nip-field" style="{{ old('role') === 'guru' ? '' : 'display:none' }}">
            <x-input-label for="nip" :value="__('NIP (Nomor Induk Pegawai)')" />
            <x-text-input
                id="nip"
                class="block mt-1 w-full"
                type="text"
                name="nip"
                :value="old('nip')"
                placeholder="Isi NIP jika mendaftar sebagai Guru"
            />
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <!-- BUTTON -->
        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                href="{{ route('login') }}">
                Sudah punya akun?
            </a>

            <x-primary-button class="ms-4">
                Daftar
            </x-primary-button>
        </div>

    </form>

    <script>
        function toggleNip(role) {
            const nipField = document.getElementById('nip-field');
            nipField.style.display = role === 'guru' ? 'block' : 'none';
        }
    </script>
</x-guest-layout>