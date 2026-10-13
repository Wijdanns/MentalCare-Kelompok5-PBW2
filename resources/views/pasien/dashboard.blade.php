@extends('layouts.app')

@section('title', 'Beranda | MentalCare')

@php
    $psikologs = $psikologs ?? collect();
@endphp

@section('content')

{{-- ============ HERO ============ --}}
<section class="mx-auto grid max-w-[1168px] items-center gap-10 px-5 pb-16 pt-10 sm:px-8 sm:pt-14 lg:grid-cols-2 lg:gap-14 lg:pb-32 lg:pt-20">
    <div>
        <span class="inline-flex items-center gap-2 rounded-full bg-blush-200/70 px-4 py-2 text-sm font-medium text-primary">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.8 5.2L19 9l-5.2 1.8L12 16l-1.8-5.2L5 9l5.2-1.8L12 2Zm7 12 .9 2.6 2.6.9-2.6.9L19 21l-.9-2.6-2.6-.9 2.6-.9L19 14Z"/></svg>
            Ruang aman untuk dirimu
        </span>

        <h1 class="mt-6 text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl lg:text-[56px]">
            Kesehatan mentalmu, <span class="text-primary">prioritas kami.</span>
        </h1>

        <p class="mt-5 max-w-lg text-base leading-7 text-gray-600 sm:mt-6 sm:text-lg sm:leading-8">
            Temukan dukungan profesional, ruang untuk bercerita, dan langkah sederhana menuju versi dirimu yang lebih baik.
        </p>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ url('/konsultasi') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-6 py-3.5 font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary-dark sm:w-auto">
                Mulai konsultasi
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
            <a href="{{ route('psikolog.index') }}" class="w-full rounded-xl border border-gray-200 bg-white px-6 py-3.5 text-center font-semibold text-ink transition hover:border-primary hover:text-primary sm:w-auto">
                Lihat psikolog
            </a>
        </div>
    </div>

    <div class="rounded-[32px] bg-blush-200/80 p-3 shadow-2xl shadow-primary/10">
        {{-- Placeholder tanpa gambar. Kalau nanti ada foto
        <img src="{{ asset('images/hero.jpg') }}" alt="Seseorang duduk tenang menghadap pemandangan"
             class="aspect-[473/496] w-full rounded-[22px] object-cover">
        --}}
        <div class="flex aspect-[473/496] w-full items-center justify-center rounded-[22px] bg-gradient-to-br from-blush-100 via-blush-200 to-primary/20">
            <svg class="h-24 w-24 text-primary/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
        </div>
    </div>
</section>

{{-- ============ LAYANAN ============ --}}
<section class="bg-blush-100 py-16 lg:py-24">
    <div class="mx-auto max-w-[1168px] px-5 sm:px-8">
        <div class="text-center">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Layanan kami</p>
            <h2 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl lg:text-4xl">Dukungan yang kamu butuhkan</h2>
            <p class="mt-3 text-gray-600">Pilih cara terbaik untuk mulai memahami dan merawat kondisi mentalmu.</p>
        </div>

        <div class="mt-10 grid gap-5 sm:mt-14 md:grid-cols-3">
            <x-card-layanan judul="Konsultasi Online"
                            deskripsi="Bercerita melalui chat atau video call dengan psikolog pilihanmu." :href="url('/konsultasi')">
                <x-slot name="icon">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/><path d="M8 8h8M8 12h5"/></svg>
                </x-slot>
            </x-card-layanan>

            <x-card-layanan judul="Daftar Psikolog"
                            deskripsi="Temukan psikolog profesional yang sesuai dengan kebutuhanmu." :href="route('psikolog.index')">
                <x-slot name="icon">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                </x-slot>
            </x-card-layanan>

            <x-card-layanan judul="Tes Psikologi"
                            deskripsi="Kenali kondisi emosionalmu melalui tes awal yang mudah dipahami." :href="url('/tes-psikologi')">
                <x-slot name="icon">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M12 5c-2.5 0-4.5 1.6-4.5 3.7 0 .6.1 1 .3 1.5-1.3.5-2.3 1.8-2.3 3.3 0 1.5 1 2.7 2.3 3.2.4 1.3 1.8 2.3 4.2 2.3"/><path d="M12 5c2.5 0 4.5 1.6 4.5 3.7 0 .6-.1 1-.3 1.5 1.3.5 2.3 1.8 2.3 3.3 0 1.5-1 2.7-2.3 3.2-.4 1.3-1.8 2.3-4.2 2.3"/></svg>
                </x-slot>
            </x-card-layanan>
        </div>
    </div>
</section>

{{-- ============ PSIKOLOG PILIHAN ============ --}}
<section class="mx-auto max-w-[1168px] px-5 py-16 sm:px-8 lg:py-24">
    <div class="flex items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Psikolog pilihan</p>
            <h2 class="mt-3 text-2xl font-bold tracking-tight sm:text-3xl lg:text-4xl">Bertemu dengan ahlinya</h2>
        </div>
        <a href="{{ route('psikolog.index') }}" class="inline-flex shrink-0 items-center gap-2 font-semibold text-primary hover:text-primary-dark">
            Lihat semua
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
        </a>
    </div>

    <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($psikologs->take(3) as $psikolog)
            <x-card-psikolog :psikolog="$psikolog" />
        @empty
            <p class="col-span-full rounded-2xl border border-dashed border-blush-200 bg-white p-10 text-center text-gray-500">
                Belum ada psikolog yang ditampilkan.
            </p>
        @endforelse
    </div>
</section>

{{-- Pop-up profil psikolog (dibuka tombol "Lihat profil" di card) --}}
<x-modal-profil-psikolog />

@endsection