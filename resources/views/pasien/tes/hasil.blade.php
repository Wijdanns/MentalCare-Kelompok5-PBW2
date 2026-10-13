@extends('layouts.app')

@section('title', 'Hasil ' . $hasil->tesPsikologis->nama_tes . ' | MentalCare')

@section('content')
@php
    $persen = $poinMaks > 0 ? round($hasil->total_poin / $poinMaks * 100) : 0;
@endphp

<section class="mx-auto max-w-3xl px-5 py-12 sm:px-8 lg:py-16">

    <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Hasil tes</p>
    <h1 class="mt-3 text-3xl font-extrabold tracking-tight">{{ $hasil->tesPsikologis->nama_tes }}</h1>
    <p class="mt-2 text-sm text-gray-500">Dikerjakan pada {{ $hasil->created_at->translatedFormat('d F Y, H:i') }}</p>

    {{-- Skor --}}
    <div class="mt-8 rounded-3xl bg-blush-100 p-6 sm:p-8">
        <p class="text-sm font-semibold text-gray-600">Total poin</p>
        <p class="mt-1 text-5xl font-extrabold text-primary">
            {{ $hasil->total_poin }}
            <span class="text-xl font-semibold text-gray-400">/ {{ $poinMaks }}</span>
        </p>

        <div class="mt-5 h-3 overflow-hidden rounded-full bg-white">
            <div class="h-full rounded-full bg-primary" style="width: {{ $persen }}%"></div>
        </div>
        <p class="mt-2 text-xs text-gray-500">{{ $persen }}% dari poin maksimal</p>
    </div>

    {{-- Pernyataan penting --}}
    <div class="mt-5 rounded-2xl border border-blush-200 bg-white p-5 text-sm leading-6 text-gray-600">
        Hasil ini adalah <strong>skrining awal</strong>, bukan diagnosis. Untuk pemahaman yang lebih tepat
        tentang kondisimu, kamu bisa berbicara langsung dengan psikolog profesional.
    </div>

    {{-- Aksi --}}
    <div class="mt-6 flex flex-wrap gap-3">
        {{-- TODO: ganti dengan route booking konsultasi kalau sudah ada --}}
        <a href="{{ url('/konsultasi') }}"
           class="rounded-xl bg-primary px-6 py-3 font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary-dark">
            Konsultasi dengan psikolog
        </a>
        <a href="{{ route('tes.show', $hasil->id_tes) }}"
           class="rounded-xl border border-gray-200 bg-white px-6 py-3 font-semibold text-ink transition hover:border-primary hover:text-primary">
            Ulangi tes
        </a>
        <a href="{{ route('tes.riwayat') }}"
           class="rounded-xl border border-gray-200 bg-white px-6 py-3 font-semibold text-ink transition hover:border-primary hover:text-primary">
            Riwayat tesku
        </a>
    </div>

    {{-- Rincian jawaban --}}
    <h2 class="mt-12 text-xl font-bold">Rincian jawabanmu</h2>

    <div class="mt-4 divide-y divide-blush-200 overflow-hidden rounded-2xl border border-blush-200 bg-white">
        @foreach ($hasil->jawabanUser as $j)
            <div class="flex items-start justify-between gap-4 p-4 sm:p-5">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-ink">
                        <span class="text-primary">{{ $loop->iteration }}.</span>
                        {{ $j->pertanyaanPsikologis->pertanyaan }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600">{{ $j->jawabanPsikologis->jawaban }}</p>
                </div>
                <span class="shrink-0 rounded-full bg-blush-100 px-3 py-1 text-xs font-bold text-primary">
                    {{ $j->poin }} poin
                </span>
            </div>
        @endforeach
    </div>
</section>
@endsection