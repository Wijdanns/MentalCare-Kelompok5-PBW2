<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MentalCare')</title>

    {{-- Font: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{--
        Tailwind lewat CDN supaya langsung jalan di Laragon tanpa npm.
        Kalau tim pindah ke Vite, hapus 2 tag <script> di bawah, lalu pakai:
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        dan pindahkan warna/font di bawah ke konfigurasi Tailwind.
    --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#E0004D', dark: '#BF0041' },
                        ink: '#2A1520',
                        blush: { 50: '#FFF9FB', 100: '#FEF1F5', 200: '#FBDDE6' },
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    {{-- Alpine.js: dipakai untuk pop-up profil psikolog, filter, dan form konsultasi --}}
    <style>[x-cloak] { display: none !important; }</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="flex min-h-screen flex-col bg-blush-50 font-sans text-ink antialiased">

    @include('partials.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.toggle-wa')

    @include('partials.footer')

    @stack('scripts')
</body>
</html>