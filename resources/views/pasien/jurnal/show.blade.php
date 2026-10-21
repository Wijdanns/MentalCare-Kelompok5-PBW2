@extends('layouts.app')

@section('title', ($jurnal->judul ?: 'Jurnal') . ' | MentalCare')

@section('content')
<section class="mx-auto max-w-3xl px-5 py-12 sm:px-8 lg:py-16">

    <a href="{{ route('jurnal.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary">&larr; Semua jurnal</a>

    @if (session('success'))
        <div class="mt-4 rounded-xl bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    <div class="mt-6 flex flex-wrap items-center gap-2 text-xs">
        <span class="font-semibold text-gray-500">{{ $jurnal->tanggal->translatedFormat('l, d F Y') }}</span>
        @if ($jurnal->emoji)
            <span class="rounded-full bg-blush-100 px-2.5 py-1 font-semibold text-primary">{{ $jurnal->emoji }} {{ $jurnal->mood }}</span>
        @endif
    </div>

    @if ($jurnal->judul)
        <h1 class="mt-3 text-3xl font-extrabold leading-tight tracking-tight">{{ $jurnal->judul }}</h1>
    @endif

    {{-- {{ }} + whitespace-pre-line: baris baru tampil, tanda HTML tetap aman --}}
    <div class="mt-6 whitespace-pre-line rounded-2xl border border-blush-200 bg-white p-6 leading-8 text-gray-700 [overflow-wrap:anywhere]">{{ $jurnal->isi }}</div>

    <p class="mt-3 text-xs text-gray-400">
        Ditulis {{ $jurnal->created_at->translatedFormat('d M Y, H:i') }}
        @if ($jurnal->updated_at->gt($jurnal->created_at->addMinute()))
            &middot; diubah {{ $jurnal->updated_at->translatedFormat('d M Y, H:i') }}
        @endif
    </p>

    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('jurnal.edit', $jurnal) }}"
           class="rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-dark">
            Edit
        </a>

        <form method="POST" action="{{ route('jurnal.destroy', $jurnal) }}"
              onsubmit="return confirm('Hapus jurnal ini? Tindakan ini tidak bisa dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="rounded-xl border border-red-200 px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                Hapus
            </button>
        </form>
    </div>
</section>
@endsection