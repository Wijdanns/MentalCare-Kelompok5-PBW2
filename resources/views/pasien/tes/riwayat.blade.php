@extends('layouts.app')

@section('title', 'Riwayat Tes | MentalCare')

@section('content')
<section class="mx-auto max-w-3xl px-5 py-12 sm:px-8 lg:py-16">

    <a href="{{ route('tes.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary">&larr; Semua tes</a>

    <h1 class="mt-4 text-3xl font-extrabold tracking-tight">Riwayat tesku</h1>
    <p class="mt-2 text-gray-600">Semua tes yang pernah kamu kerjakan.</p>

    <div class="mt-8 space-y-3">
        @forelse ($riwayat as $item)
            <a href="{{ route('tes.hasil', $item) }}"
               class="flex items-center justify-between gap-4 rounded-2xl border border-blush-200 bg-white p-5 transition hover:border-primary hover:shadow-lg">
                <div class="min-w-0">
                    <p class="truncate font-semibold text-ink">{{ $item->tesPsikologis->nama_tes }}</p>
                    <p class="mt-1 text-xs text-gray-500">{{ $item->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
                <div class="flex shrink-0 items-center gap-3">
                    <span class="rounded-full bg-blush-100 px-3 py-1 text-sm font-bold text-primary">
                        {{ $item->total_poin }} poin
                    </span>
                    <svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                </div>
            </a>
        @empty
            <div class="rounded-2xl border border-dashed border-blush-200 bg-white p-10 text-center">
                <p class="text-gray-500">Kamu belum pernah mengerjakan tes.</p>
                <a href="{{ route('tes.index') }}"
                   class="mt-4 inline-block rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary-dark">
                    Mulai tes pertamamu
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $riwayat->links() }}
    </div>
</section>
@endsection