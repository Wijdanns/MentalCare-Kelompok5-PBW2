@extends('layouts.app')

@section('title', $psikolog->nama . ' | MentalCare')

@section('content')
<section class="mx-auto max-w-[1168px] px-5 py-12 sm:px-8 lg:py-16">

    <a href="{{ route('psikolog.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary">&larr; Semua psikolog</a>

    <div class="mt-6 grid gap-8 lg:grid-cols-[360px_1fr] lg:gap-12">

        {{-- Kolom kiri: foto + ringkasan --}}
        <aside>
            <div class="overflow-hidden rounded-3xl bg-blush-200/80 p-3 shadow-2xl shadow-primary/10">
                <img src="{{ $psikolog->foto_profil ? route('foto-psikolog', basename($psikolog->foto_profil)) : 'https://ui-avatars.com/api/?size=600&background=fce7ef&color=e11d48&name=' . urlencode($psikolog->nama) }}" alt="Foto {{ $psikolog->nama }}"
                     class="aspect-[4/5] w-full rounded-[22px] object-cover">
            </div>

            <div class="mt-5 rounded-2xl border border-blush-200 bg-white p-5">
                <p class="text-xs text-gray-500">Biaya per sesi</p>
                <p class="mt-1 text-2xl font-extrabold text-ink">Rp {{ number_format($psikolog->tarif, 0, ',', '.') }}</p>

                <p class="mt-4 text-xs text-gray-500">Email</p>
                <p class="mt-1 break-all text-sm font-medium text-ink">{{ $psikolog->email }}</p>
            </div>
        </aside>

        {{-- Kolom kanan: profil + jadwal --}}
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">{{ $psikolog->nama }}</h1>

                @if ($psikolog->tersedia)
                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">Tersedia</span>
                @else
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500">Belum ada jadwal</span>
                @endif
            </div>

            <p class="mt-2 text-lg font-semibold text-primary">{{ $psikolog->spesialisasi }}</p>

            <h2 class="mt-8 text-lg font-bold">Tentang</h2>
            <p class="mt-2 whitespace-pre-line leading-7 text-gray-600">
                {{ $psikolog->deskripsi_psikolog ?: 'Psikolog ini belum menambahkan deskripsi.' }}
            </p>

            {{-- Jadwal --}}
            <h2 class="mt-10 text-lg font-bold">Jadwal tersedia</h2>

            @guest
                <div class="mt-3 rounded-xl bg-blush-100 p-4 text-sm text-gray-700">
                    <a href="{{ route('login') }}" class="font-semibold text-primary hover:underline">Masuk</a>
                    atau
                    <a href="{{ route('register') }}" class="font-semibold text-primary hover:underline">daftar</a>
                    untuk memesan konsultasi.
                </div>
            @endguest

            <div class="mt-4 space-y-4">
                @forelse ($jadwalPerTanggal as $tanggal => $slots)
                    <div class="rounded-2xl border border-blush-200 bg-white p-5">
                        <p class="font-semibold text-ink">
                            {{ \Illuminate\Support\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                        </p>

                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($slots as $slot)
                                {{-- TODO: ganti dengan route booking konsultasi kalau controllernya sudah ada --}}
                                <a href="{{ auth()->check()
                                            ? url('/konsultasi?jadwal=' . $slot->id)
                                            : route('login') }}"
                                   class="rounded-xl border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition hover:border-primary hover:bg-blush-100 hover:text-primary">
                                    {{ substr($slot->jam_mulai, 0, 5) }} - {{ substr($slot->jam_selesai, 0, 5) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-dashed border-blush-200 bg-white p-8 text-center text-gray-500">
                        Belum ada jadwal tersedia untuk psikolog ini. Coba lagi nanti atau
                        <a href="{{ route('psikolog.index') }}" class="font-semibold text-primary hover:underline">pilih psikolog lain</a>.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection