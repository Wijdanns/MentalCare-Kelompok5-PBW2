@extends('layouts.app')

@section('title', 'Artikel | MentalCare')

@php
    // Data dikirim dari controller (BE)
    //   $artikels  : daftar artikel dengan relasi kategori (filter lewat ?kategori=)
    //   $kategoris : daftar model KategoriArtikel (punya nama_kategori), misal KategoriArtikel::orderBy('nama_kategori')->get()
    $artikels = $artikels ?? collect();
    $kategoris = $kategoris ?? collect();

    // Kategori terpilih dibaca dari link: /artikel?kategori=3 (nilai = primary key kategori)
    $kategoriAktif = request('kategori');

    $chipDasar = 'rounded-full border px-5 py-2.5 text-sm font-medium transition';
    $chipAktif = 'border-primary bg-primary text-white';
    $chipBiasa = 'border-gray-200 bg-white text-gray-700 hover:border-primary hover:text-primary';

@endphp

@section('content')

{{-- ============ HERO ============ --}}
<section class="bg-blush-100 px-5 pb-16 pt-14 text-center sm:px-8 sm:pb-24 sm:pt-20">
    <span class="inline-flex rounded-full bg-blush-200/70 px-4 py-2 text-sm font-medium text-primary">Baca &amp; pelajari</span>

    <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl lg:text-[56px]">
        Wawasan untuk menemani prosesmu
    </h1>

    <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-gray-600 sm:text-lg sm:leading-8">
        Artikel ringan dan terpercaya seputar kesehatan mental, hubungan, dan pengembangan diri.
    </p>
</section>

{{-- ============ KATEGORI + DAFTAR ============ --}}
<section class="mx-auto max-w-[1168px] px-5 py-12 sm:px-8 lg:py-16">

    {{-- Chip kategori: dari data, jadi hanya kategori yang sudah ada --}}
    <div class="flex flex-wrap justify-center gap-3">
        <a href="{{ url('/artikel') }}"
           class="{{ $chipDasar }} {{ blank($kategoriAktif) ? $chipAktif : $chipBiasa }}"
           @if (blank($kategoriAktif)) aria-current="true" @endif>Semua</a>

        @foreach ($kategoris as $kategori)
            @php $dipilih = (string) $kategoriAktif === (string) $kategori->getKey(); @endphp
            <a href="{{ url('/artikel') }}?kategori={{ $kategori->getKey() }}"
               class="{{ $chipDasar }} {{ $dipilih ? $chipAktif : $chipBiasa }}"
               @if ($dipilih) aria-current="true" @endif>{{ $kategori->nama_kategori }}</a>
        @endforeach
    </div>

    {{-- Daftar artikel --}}
    <div class="mt-10 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($artikels as $artikel)
            <x-card-artikel :artikel="$artikel" :index="$loop->index" />
        @empty
            <p class="col-span-full rounded-2xl border border-dashed border-blush-200 bg-white p-10 text-center text-gray-500">
                {{ filled($kategoriAktif) ? 'Belum ada artikel untuk kategori ini.' : 'Belum ada artikel yang ditampilkan.' }}
            </p>
        @endforelse
    </div>

    {{-- Paginasi: diurus BE. Kalau controller memakai ->paginate(), tambahkan {{ $artikels->links() }} di sini. --}}
</section>

@endsection