<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIJA Presensi') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{--
            Anti-flash: body.light-mode diset SEBELUM render jika user pilih light.
            Default dark — tidak perlu class apapun (sesuai body:not(.light-mode) di CSS).
        --}}
        <script>
            (function () {
                if (localStorage.getItem('sija-theme') === 'light') {
                    document.addEventListener('DOMContentLoaded', function () {
                        document.body.classList.add('light-mode');
                    });
                }
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="stylesheet" href="{{ asset('css/theme-mode.css') }}">
        <link rel="stylesheet" href="{{ asset('css/smk-style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/forms-style.css') }}">
    </head>

    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                @yield('content')
            </main>
        </div>

        {{-- theme-mode.js menangani logika toggle untuk semua halaman --}}
        <script src="{{ asset('js/theme-mode.js') }}"></script>
    </body>
</html>