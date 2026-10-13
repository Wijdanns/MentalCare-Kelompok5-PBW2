@extends('layouts.app')

@section('title', 'Hasil Tes | MentalCare')

@php
    // Dikirim dari controller (BE)
    //   $hasil      : model HasilTes (total_poin)
    //   $skorMaks   : skor maksimum tes (opsional, untuk tampilan "9 / 15")
    //   $labelHasil : label singkat, misal "Perlu perhatian" (opsional)
    //   $judulHasil : judul hasil (opsional)
    //   $pesanHasil : penjelasan hasil (opsional)
    // Perhitungan skor dan teks hasil sepenuhnya dari BE; FE hanya menampilkan.
    abort_unless(isset($hasil), 404);

    $skorMaks = $skorMaks ?? null;
    $labelHasil = $labelHasil ?? null;
    $judulHasil = $judulHasil ?? null;
    $pesanHasil = $pesanHasil ?? null;
@endphp

@section('content')

<x-hero-tes />

<section class="mx-auto max-w-3xl px-5 py-12 sm:px-8 sm:py-16 lg:py-20">
    <div class="rounded-3xl border border-blush-200 bg-white p-6 text-center shadow-xl shadow-primary/10 sm:p-10">

        <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blush-200/70 text-primary">
            <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
        </span>

        <p class="mt-5 text-xs font-bold uppercase tracking-[0.15em] text-primary">Hasil tesmu</p>

        {{-- Skor --}}
        <div class="mt-3 inline-flex items-center gap-4 rounded-2xl bg-blush-100 px-5 py-3">
            <span class="flex items-baseline gap-2 text-sm text-gray-500">
                Skor
                <span class="text-3xl font-extrabold leading-none text-primary">{{ $hasil->total_poin }}</span>
                @if (filled($skorMaks))
                    <span class="text-sm text-gray-400">/ {{ $skorMaks }}</span>
                @endif
            </span>

            @if (filled($labelHasil))
                <span class="h-6 w-px bg-blush-200"></span>
                <span class="text-sm font-semibold text-primary">{{ $labelHasil }}</span>
            @endif
        </div>

        <h2 class="mx-auto mt-6 max-w-xl text-2xl font-bold leading-snug tracking-tight sm:text-3xl">
            {{ $judulHasil ?? 'Terima kasih sudah menyelesaikan tes' }}
        </h2>

        @if (filled($pesanHasil))
            <p class="mx-auto mt-4 max-w-lg leading-7 text-gray-500">{{ $pesanHasil }}</p>
        @endif

        <p class="mx-auto mt-6 max-w-lg rounded-xl bg-gray-50 px-4 py-3 text-xs leading-5 text-gray-500">
            Hasil ini bukan diagnosis medis, namun dapat menjadi langkah awal untuk lebih memahami keadaan emosionalmu.
        </p>

        <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ url('/konsultasi') }}"
               class="inline-flex items-center justify-center rounded-xl bg-primary px-6 py-3.5 font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary-dark">
                Bicara dengan psikolog
            </a>
            <a href="{{ url('/tes-psikologi') }}"
               class="inline-flex items-center justify-center rounded-xl border border-blush-200 bg-white px-6 py-3.5 font-semibold text-ink transition hover:border-primary hover:text-primary">
                Ulangi tes
            </a>
        </div>
    </div>
</section>

@endsection