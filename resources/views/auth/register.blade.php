<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- NAME -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
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
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input 
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
            />
        </div>

        <!-- ROLE -->
        <div class="mt-4">
            <x-input-label value="Role" />
            <select name="role" class="block mt-1 w-full border rounded p-2" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="guru">Guru</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- NIP -->
        <div class="mt-4">
            <x-input-label value="NIP (khusus guru)" />
            <input 
                type="text"
                name="nip"
                value="{{ old('nip') }}"
                class="block mt-1 w-full border rounded p-2"
                placeholder="Isi jika guru"
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
                Register
            </x-primary-button>
        </div>

    </form>
</x-guest-layout>