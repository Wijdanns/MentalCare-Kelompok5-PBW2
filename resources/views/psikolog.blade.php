@extends('layouts.app')

@section('title', 'Psikolog | MentalCare')

@php
    // Data psikolog dikirim dari controller (BE) sebagai $psikologs
    $psikologs = $psikologs ?? collect();

    // Chip filter. Nilai 'kategori' di data psikolog harus salah satu slug ini (huruf kecil).
    $kategoriList = [
        'semua' => 'Semua',
        'kecemasan' => 'Kecemasan',
        'relasi' => 'Relasi',
        'karier' => 'Karier',
        'keluarga' => 'Keluarga',
    ];

    $kategoriAda = $psikologs
        ->map(fn ($p) => \Illuminate\Support\Str::lower($p->kategori ?? ''))
        ->unique()->values();
@endphp

@section('content')

{{-- ============ HERO ============ --}}
<section class="bg-blush-100 px-5 pb-16 pt-14 text-center sm:px-8 sm:pb-24 sm:pt-20">
    <span class="inline-flex rounded-full bg-blush-200/70 px-4 py-2 text-sm font-medium text-primary">Psikolog terverifikasi</span>

    <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl lg:text-[56px]">
        Temukan teman bercerita yang tepat
    </h1>

    <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-gray-600 sm:text-lg sm:leading-8">
        Kenali profil dan bidang keahlian psikolog profesional kami sebelum menentukan pilihan.
    </p>
</section>

{{-- ============ FILTER + DAFTAR ============ --}}
<section x-data="{ kategori: 'semua', ada: @js($kategoriAda) }"
         class="mx-auto max-w-[1168px] px-5 py-12 sm:px-8 lg:py-16">

    <div class="flex flex-wrap justify-center gap-3">
        @foreach ($kategoriList as $slug => $label)
            <button type="button" @click="kategori = '{{ $slug }}'"
                    :class="kategori === '{{ $slug }}'
                        ? 'border-primary bg-primary text-white'
                        : 'border-gray-200 bg-white text-gray-700 hover:border-primary hover:text-primary'"
                    class="rounded-full border px-5 py-2.5 text-sm font-medium transition">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($psikologs as $psikolog)
            <div x-show="kategori === 'semua' || kategori === @js(\Illuminate\Support\Str::lower($psikolog->kategori ?? ''))">
                <x-card-psikolog :psikolog="$psikolog" />
            </div>
        @empty
            <p class="col-span-full rounded-2xl border border-dashed border-blush-200 bg-white p-10 text-center text-gray-500">
                Belum ada psikolog yang ditampilkan.
            </p>
        @endforelse

        @if ($psikologs->isNotEmpty())
            <p x-show="kategori !== 'semua' && !ada.includes(kategori)" x-cloak
               class="col-span-full rounded-2xl border border-dashed border-blush-200 bg-white p-10 text-center text-gray-500">
                Belum ada psikolog untuk kategori ini.
            </p>
        @endif
    </div>
</section>

{{-- Pop-up profil psikolog (dibuka tombol "Lihat profil" di card) --}}
<x-modal-profil-psikolog />

@endsection