@extends('layouts.app')

@php

    // Tombol kembali: ke halaman daftar sebelumnya (kategori/halaman tetap sama), atau ke /artikel
    $sebelumnya = url()->previous();
    $dariDaftar = \Illuminate\Support\Str::startsWith($sebelumnya, url('/artikel'))
        && !\Illuminate\Support\Str::startsWith($sebelumnya, url('/artikel/'));
    $kembali = $dariDaftar ? $sebelumnya : url('/artikel');

    $thumbnail = !empty($artikel->thumbnail)
        ? (\Illuminate\Support\Str::startsWith($artikel->thumbnail, ['http://', 'https://'])
            ? $artikel->thumbnail
            : asset('storage/' . $artikel->thumbnail))
        : null;
@endphp

@section('title', $artikel->judul . ' | MentalCare')

@section('content')

{{-- ============ JUDUL ============ --}}
<section class="bg-blush-100 px-5 py-12 text-center sm:px-8 sm:py-16">
    <h1 class="mx-auto max-w-3xl text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">
        {{ $artikel->judul }}
    </h1>
</section>

{{-- ============ ISI ============ --}}
<article class="mx-auto max-w-3xl px-5 py-10 sm:px-8 sm:py-14">

    {{-- Sampul --}}
    @if ($thumbnail)
        <img src="{{ $thumbnail }}" alt="Sampul {{ $artikel->judul }}"
             class="aspect-[16/9] w-full rounded-3xl object-cover">
    @else
        <div class="flex aspect-[16/9] w-full items-center justify-center rounded-3xl bg-gradient-to-br from-blush-100 to-blush-200">
            <span class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white/80 text-primary shadow-sm">
                <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
            </span>
        </div>
    @endif

    {{-- Isi artikel.
         Ditampilkan sebagai teks biasa (aman), baris kosong jadi pemisah paragraf.
         Kalau admin memakai editor teks kaya (HTML), BE harus membersihkan HTML saat menyimpan,
         lalu ganti baris di bawah dengan {!! $artikel->isi !!} --}}
    <div class="mt-8 whitespace-pre-line text-base leading-8 text-gray-700">{{ $artikel->isi }}</div>

    {{-- Kembali --}}
    <div class="mt-12 border-t border-blush-200 pt-8">
        <a href="{{ $kembali }}"
           class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-3 text-sm font-semibold text-primary transition hover:border-primary">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5m6-6-6 6 6 6"/></svg>
            Kembali ke daftar artikel
        </a>
    </div>
</article>

@endsection