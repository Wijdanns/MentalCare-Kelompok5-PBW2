@extends('layouts.app')

@section('title', 'Tes Psikologi | MentalCare')

@php
    // Data dikirim dari controller (BE) sebagai $daftarTes (model TesPsikologis: nama_tes, deskripsi).
    $daftarTes = $daftarTes ?? collect();
@endphp

@section('content')

<x-hero-tes />

<section class="mx-auto max-w-3xl space-y-6 px-5 py-12 sm:px-8 sm:py-16 lg:py-20">
    @forelse ($daftarTes as $tes)
        <article class="rounded-3xl border border-blush-200 bg-white p-6 text-center shadow-xl shadow-primary/10 sm:p-10">
            <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blush-200/70 text-primary">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M12 5c-2.5 0-4.5 1.6-4.5 3.7 0 .6.1 1 .3 1.5-1.3.5-2.3 1.8-2.3 3.3 0 1.5 1 2.7 2.3 3.2.4 1.3 1.8 2.3 4.2 2.3"/><path d="M12 5c2.5 0 4.5 1.6 4.5 3.7 0 .6-.1 1-.3 1.5 1.3.5 2.3 1.8 2.3 3.3 0 1.5-1 2.7-2.3 3.2-.4 1.3-1.8 2.3-4.2 2.3"/></svg>
            </span>

            <h2 class="mt-5 text-2xl font-bold tracking-tight sm:text-3xl">{{ $tes->nama_tes }}</h2>

            @if (filled($tes->deskripsi))
                <p class="mx-auto mt-3 max-w-md leading-7 text-gray-500">{{ $tes->deskripsi }}</p>
            @endif

            <a href="{{ url('/tes-psikologi/' . $tes->getKey()) }}"
               class="mt-6 inline-flex items-center gap-2 rounded-xl bg-primary px-7 py-3.5 font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary-dark">
                Mulai tes
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </article>
    @empty
        <p class="rounded-2xl border border-dashed border-blush-200 bg-white p-10 text-center text-gray-500">
            Belum ada tes psikologi yang tersedia.
        </p>
    @endforelse
</section>

@endsection