@extends('layouts.app')

@section('title', $artikel->judul . ' | MentalCare')

@section('content')
<article class="mx-auto max-w-3xl px-5 py-12 sm:px-8 lg:py-16">

    <a href="{{ route('artikel.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary">&larr; Semua artikel</a>

    <div class="mt-6 flex flex-wrap items-center gap-2 text-xs">
        <a href="{{ route('artikel.index', ['kategori' => $artikel->id_kategori]) }}"
           class="rounded-full bg-blush-100 px-3 py-1 font-semibold text-primary hover:bg-blush-200">
            {{ $artikel->kategori->nama_kategori }}
        </a>
        <span class="text-gray-400">{{ $artikel->waktu_baca }} menit baca</span>
    </div>

    <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">{{ $artikel->judul }}</h1>

    <p class="mt-4 text-sm text-gray-500">
        {{ $artikel->tanggal_publikasi->translatedFormat('d F Y') }}
        @if ($artikel->user) &middot; Ditulis oleh <span class="font-semibold text-ink">{{ $artikel->user->nama }}</span> @endif
    </p>

    @if ($artikel->gambar)
        <img src="{{ $artikel->gambar }}" alt="{{ $artikel->judul }}"
             class="mt-8 aspect-[16/9] w-full rounded-3xl object-cover">
    @endif

    {{-- Isi artikel (HTML dari rich editor, hanya ditulis admin) --}}
    <div class="isi-artikel mt-8">
        {!! $artikel->isi !!}
    </div>

    <p class="mt-10 rounded-2xl border border-blush-200 bg-blush-100 p-5 text-sm leading-6 text-gray-600">
        Artikel ini bersifat edukatif dan bukan pengganti diagnosis atau perawatan profesional.
        Kalau kamu butuh bantuan, kamu bisa
        <a href="{{ route('psikolog.index') }}" class="font-semibold text-primary hover:underline">berbicara dengan psikolog</a>.
    </p>

    {{-- Artikel terkait --}}
    @if ($terkait->isNotEmpty())
        <h2 class="mt-14 text-xl font-bold">Artikel terkait</h2>

        <div class="mt-4 grid gap-4 sm:grid-cols-3">
            @foreach ($terkait as $item)
                <a href="{{ route('artikel.show', $item) }}"
                   class="flex flex-col rounded-2xl border border-blush-200 bg-white p-4 transition hover:border-primary hover:shadow-lg">
                    <span class="text-xs font-semibold text-primary">{{ $item->kategori->nama_kategori }}</span>
                    <span class="mt-2 flex-1 text-sm font-bold leading-snug text-ink">{{ $item->judul }}</span>
                    <span class="mt-3 text-xs text-gray-500">{{ $item->tanggal_publikasi->translatedFormat('d M Y') }}</span>
                </a>
            @endforeach
        </div>
    @endif
</article>

{{-- Gaya dasar untuk isi artikel (tidak butuh plugin Typography) --}}
<style>
    .isi-artikel { font-size: 1.0625rem; line-height: 1.8; color: #374151; overflow-wrap: anywhere; }
    .isi-artikel > * + * { margin-top: 1.1em; }
    .isi-artikel h1, .isi-artikel h2, .isi-artikel h3 { font-weight: 800; line-height: 1.3; color: #111827; margin-top: 1.8em; }
    .isi-artikel h1 { font-size: 1.75rem; }
    .isi-artikel h2 { font-size: 1.5rem; }
    .isi-artikel h3 { font-size: 1.25rem; }
    .isi-artikel a { color: var(--color-primary, #e0004d); text-decoration: underline; }
    .isi-artikel ul { list-style: disc; padding-left: 1.5rem; }
    .isi-artikel ol { list-style: decimal; padding-left: 1.5rem; }
    .isi-artikel li + li { margin-top: .35em; }
    .isi-artikel blockquote { border-left: 4px solid #f3c1d3; padding-left: 1rem; color: #6b7280; font-style: italic; }
    .isi-artikel img { max-width: 100%; height: auto; border-radius: 1rem; }
    .isi-artikel pre, .isi-artikel code { background: #f3f4f6; border-radius: .5rem; font-size: .9em; }
    .isi-artikel pre { padding: 1rem; overflow-x: auto; }
    .isi-artikel code { padding: .1em .35em; }
</style>
@endsection