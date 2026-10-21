@extends('layouts.app')

@section('title', 'Jurnal Saya | MentalCare')

@section('content')
<section class="mx-auto max-w-3xl px-5 py-12 sm:px-8 lg:py-16">

    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Jurnal</p>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">Jurnal saya</h1>
            <p class="mt-2 text-gray-600">Ruang pribadimu untuk menulis apa saja. Hanya kamu yang bisa membacanya.</p>
        </div>
        <a href="{{ route('jurnal.create') }}"
           class="rounded-xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary-dark">
            + Tulis jurnal
        </a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-xl bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div>
    @endif

    @if ($total > 0)
        {{-- Filter mood --}}
        <div class="mt-6 flex flex-wrap gap-2">
            <a href="{{ route('jurnal.index') }}"
               class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ $mood ? 'border border-gray-200 bg-white text-gray-700 hover:border-primary hover:text-primary' : 'bg-primary text-white' }}">
                Semua
            </a>
            @foreach (\App\Models\Jurnal::MOOD as $nama => $emoji)
                <a href="{{ route('jurnal.index', ['mood' => $nama]) }}"
                   class="rounded-full px-4 py-1.5 text-sm font-medium transition {{ $mood === $nama ? 'bg-primary text-white' : 'border border-gray-200 bg-white text-gray-700 hover:border-primary hover:text-primary' }}">
                    {{ $emoji }} {{ $nama }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="mt-6 space-y-3">
        @forelse ($jurnals as $item)
            <a href="{{ route('jurnal.show', $item) }}"
               class="block rounded-2xl border border-blush-200 bg-white p-5 transition hover:border-primary hover:shadow-lg">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-semibold text-gray-500">{{ $item->tanggal->translatedFormat('l, d F Y') }}</p>
                    @if ($item->emoji)
                        <span class="shrink-0 rounded-full bg-blush-100 px-2.5 py-1 text-xs font-semibold text-primary">
                            {{ $item->emoji }} {{ $item->mood }}
                        </span>
                    @endif
                </div>

                @if ($item->judul)
                    <h2 class="mt-2 font-bold text-ink">{{ $item->judul }}</h2>
                @endif

                <p class="mt-1 text-sm leading-6 text-gray-600">{{ $item->ringkasan }}</p>
            </a>
        @empty
            <div class="rounded-2xl border border-dashed border-blush-200 bg-white p-10 text-center">
                @if ($total === 0)
                    <p class="text-gray-500">Belum ada jurnal. Mulai menulis kapan pun kamu siap.</p>
                    <a href="{{ route('jurnal.create') }}"
                       class="mt-4 inline-block rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white hover:bg-primary-dark">
                        Tulis jurnal pertamamu
                    </a>
                @else
                    <p class="text-gray-500">Tidak ada jurnal dengan mood ini.</p>
                    <a href="{{ route('jurnal.index') }}" class="mt-3 inline-block text-sm font-semibold text-primary hover:underline">
                        Tampilkan semua
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $jurnals->links() }}</div>
</section>
@endsection