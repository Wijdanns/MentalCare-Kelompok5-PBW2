@php
    $on  = 'text-primary';
    $off = 'text-gray-700 hover:text-primary';
@endphp

<header class="sticky top-0 z-50 border-b border-blush-200/70 bg-white/95 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-[1168px] items-center justify-between px-5 sm:h-20 sm:px-8">

        <x-logo />

        {{-- Menu desktop --}}
        <nav class="hidden items-center gap-9 text-sm font-medium lg:flex">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? $on : $off }}">Beranda</a>
            <a href="{{ url('/konsultasi') }}" class="{{ request()->is('konsultasi*') ? $on : $off }}">Konsultasi</a>
            <a href="{{ url('/psikolog') }}" class="{{ request()->is('psikolog*') ? $on : $off }}">Psikolog</a>

            {{-- Artikel + dropdown (muncul saat hover / fokus keyboard) --}}
            <div class="group relative">
                <a href="{{ url('/artikel') }}" class="flex items-center gap-1 {{ request()->is('artikel*') ? $on : $off }}">
                    Artikel
                    <svg class="h-3.5 w-3.5 transition group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </a>
                <div class="invisible absolute left-0 top-full pt-4 opacity-0 transition group-focus-within:visible group-focus-within:opacity-100 group-hover:visible group-hover:opacity-100">
                    <div class="w-48 rounded-xl border border-blush-200 bg-white p-2 shadow-lg">
                        {{-- TODO: sesuaikan dengan jenis artikel dari BE --}}
                        <a href="#" class="block rounded-lg px-3 py-2 text-gray-700 hover:bg-blush-100 hover:text-primary">Semua artikel</a>
                        <a href="#" class="block rounded-lg px-3 py-2 text-gray-700 hover:bg-blush-100 hover:text-primary">Jenis artikel</a>
                    </div>
                </div>
            </div>

            <a href="#" class="{{ request()->is('tes*') ? $on : $off }}">Tes Psikologi</a>
        </nav>

        {{-- Tombol auth desktop --}}
        <div class="hidden items-center gap-6 text-sm font-semibold lg:flex">
            @guest
                <a href="/login" class="text-primary hover:text-primary-dark">Masuk</a>
                <a href="/register" class="rounded-xl bg-primary px-5 py-3 text-white transition hover:bg-primary-dark">Daftar</a>
            @endguest

            @auth
                @php
                    $user = auth()->user();
                    $isAdmin = $user->role === 'admin';
                @endphp

                {{-- Profil + dropdown (hover / fokus keyboard) --}}
                <div class="group relative">
                    <button type="button"
                            class="flex items-center gap-2 rounded-full border border-blush-200 bg-white py-1 pl-1 pr-3 transition hover:border-primary">
                        @if ($user->profil)
                            <img src="{{ asset('storage/' . $user->profil) }}" alt="{{ $user->nama }}"
                                class="h-9 w-9 rounded-full object-cover">
                        @else
                            <span class="flex h-9 w-9 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">
                                {{ strtoupper(mb_substr($user->nama, 0, 1)) }}
                            </span>
                        @endif
                        <span class="max-w-[110px] truncate text-sm font-semibold text-ink">{{ $user->nama }}</span>
                        <svg class="h-3.5 w-3.5 text-gray-400 transition group-hover:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>

                    <div class="invisible absolute right-0 top-full pt-3 opacity-0 transition group-focus-within:visible group-focus-within:opacity-100 group-hover:visible group-hover:opacity-100">
                        <div class="w-56 overflow-hidden rounded-xl border border-blush-200 bg-white shadow-lg">
                            <div class="border-b border-blush-200 px-4 py-3">
                                <p class="truncate text-sm font-semibold text-ink">{{ $user->nama }}</p>
                                <p class="truncate text-xs font-normal text-gray-500">{{ $user->email }}</p>
                            </div>

                            <div class="p-2 font-medium">
                                @if ($isAdmin)
                                    <a href="{{ url('/admin') }}" class="block rounded-lg px-3 py-2 text-gray-700 hover:bg-blush-100 hover:text-primary">Panel Admin</a>
                                @else
                                    <a href="{{ route('pasien.dashboard') }}" class="block rounded-lg px-3 py-2 text-gray-700 hover:bg-blush-100 hover:text-primary">Akun saya</a>
                                    {{-- TODO: tambah "Riwayat Konsultasi" dan "Hasil Tes" kalau halamannya sudah ada --}}
                                @endif

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-red-600 hover:bg-red-50">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endauth
        </div>

        {{-- Tombol hamburger (mobile) --}}
        <button id="menu-btn" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="mobile-menu"
                class="rounded-lg p-2 text-ink hover:bg-blush-100 lg:hidden">
            <svg id="icon-open" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            <svg id="icon-close" class="hidden h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
        </button>
    </div>

    {{-- Menu mobile --}}
    <div id="mobile-menu" class="hidden border-t border-blush-200 bg-white lg:hidden">
        <nav class="mx-auto flex max-w-[1168px] flex-col gap-1 px-5 py-4 sm:px-8 text-sm font-medium">
            <a href="{{ url('/') }}" class="rounded-lg px-3 py-2.5 {{ request()->is('/') ? 'bg-blush-100 text-primary' : 'text-gray-700' }}">Beranda</a>
            <a href="{{ url('/konsultasi') }}" class="rounded-lg px-3 py-2.5 text-gray-700">Konsultasi</a>
            <a href="{{ url('/psikolog') }}" class="rounded-lg px-3 py-2.5 text-gray-700">Psikolog</a>

            <details class="group">
                <summary class="flex cursor-pointer list-none items-center justify-between rounded-lg px-3 py-2.5 text-gray-700 [&::-webkit-details-marker]:hidden">
                    Artikel
                    <svg class="h-4 w-4 transition group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </summary>
                <div class="ml-3 flex flex-col border-l border-blush-200 pl-3">

                    <a href="#" class="rounded-lg px-3 py-2 text-gray-600">Semua artikel</a>
                    <a href="#" class="rounded-lg px-3 py-2 text-gray-600">Jenis artikel</a>
                </div>
            </details>
            <a href="{{ url('/tes-psikologi') }}" class="rounded-lg px-3 py-2.5 text-gray-700">Tes Psikologi</a>
            <div class="mt-3 border-t border-blush-200 pt-4">
                @guest
                    <div class="flex gap-3">
                        <a href="{{ url('/login') }}" class="flex-1 rounded-xl border border-primary px-4 py-2.5 text-center font-semibold text-primary">Masuk</a>
                        <a href="{{ url('/register') }}" class="flex-1 rounded-xl bg-primary px-4 py-2.5 text-center font-semibold text-white">Daftar</a>
                    </div>
                @endguest

                @auth
                    @php $user = auth()->user(); @endphp

                    <div class="mb-3 flex items-center gap-3 px-3">
                        @if ($user->profil)
                            <img src="{{ asset('storage/' . $user->profil) }}" alt="{{ $user->nama }}" class="h-10 w-10 rounded-full object-cover">
                        @else
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-primary font-bold text-white">
                                {{ strtoupper(mb_substr($user->nama, 0, 1)) }}
                            </span>
                        @endif
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-ink">{{ $user->nama }}</p>
                            <p class="truncate text-xs font-normal text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>

                    <a href="{{ $user->role === 'admin' ? url('/admin') : route('pasien.dashboard') }}"
                    class="block rounded-lg px-3 py-2.5 text-gray-700 hover:bg-blush-100">
                        {{ $user->role === 'admin' ? 'Panel Admin' : 'Akun saya' }}
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full rounded-lg px-3 py-2.5 text-left text-red-600 hover:bg-red-50">Keluar</button>
                    </form>
                @endauth
            </div>
        </nav>
    </div>
</header>

@push('scripts')
<script>
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const iconOpen = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    menuBtn.addEventListener('click', () => {
        const open = mobileMenu.classList.toggle('hidden') === false;
        menuBtn.setAttribute('aria-expanded', open);
        menuBtn.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
        iconOpen.classList.toggle('hidden', open);
        iconClose.classList.toggle('hidden', !open);
    });
</script>
@endpush