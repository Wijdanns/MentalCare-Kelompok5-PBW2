@extends('layouts.app')

@section('title', 'Daftar Psikolog | MentalCare')

@section('content')
<section class="mx-auto max-w-[1168px] px-5 py-12 sm:px-8 lg:py-16">

    <p class="text-xs font-bold uppercase tracking-[0.2em] text-primary">Psikolog</p>
    <h1 class="mt-3 text-3xl font-extrabold tracking-tight sm:text-4xl">Temukan psikolog yang cocok</h1>
    <p class="mt-3 max-w-xl text-gray-600">
        Cari berdasarkan nama atau bidang yang kamu butuhkan, lalu lihat jadwal yang tersedia.
    </p>

    {{-- Filter --}}
    <form method="GET" action="{{ route('psikolog.index') }}"
          class="mt-8 grid gap-3 rounded-2xl border border-blush-200 bg-white p-4 md:grid-cols-[1fr_240px_auto_auto] md:items-center">

        <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau spesalisasi..."
               class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:outline-none">

        <select name="spesialis"
                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm focus:border-primary focus:outline-none">
            <option value="">Semua spesialisasi</option>
            @foreach ($daftarSpesialis as $item)
                <option value="{{ $item }}" @selected($spesialis === $item)>{{ $item }}</option>
            @endforeach
        </select>

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="tersedia" value="1" @checked(request()->boolean('tersedia'))
                   class="rounded border-gray-300 text-primary focus:ring-primary">
            Ada jadwal
        </label>

        <div class="flex gap-2">
            <button type="submit"
                    class="rounded-xl bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-primary-dark">
                Cari
            </button>
            @if ($q !== '' || $spesialis !== '' || request()->boolean('tersedia'))
                <a href="{{ route('psikolog.index') }}"
                   class="rounded-xl border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-600 transition hover:border-primary hover:text-primary">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <p class="mt-6 text-sm text-gray-500">
        Menampilkan {{ $psikologs->total() }} psikolog
    </p>

    {{-- Daftar --}}
    <div class="mt-4 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($psikologs as $psikolog)
            <article class="flex flex-col overflow-hidden rounded-2xl border border-blush-200 bg-white transition hover:border-primary hover:shadow-lg">

                <a href="{{ route('psikolog.show', $psikolog) }}" class="block bg-blush-100">
                    <img src="{{ $psikolog->foto_profil ? route('foto-psikolog', basename($psikolog->foto_profil)) : 'https://ui-avatars.com/api/?size=600&background=fce7ef&color=e11d48&name=' . urlencode($psikolog->nama) }}" alt="Foto {{ $psikolog->nama }}"
                         class="aspect-[4/3] w-full object-cover" loading="lazy">
                </a>

                <div class="flex flex-1 flex-col p-5">
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="font-bold leading-snug text-ink">
                            <a href="{{ route('psikolog.show', $psikolog) }}" class="hover:text-primary">{{ $psikolog->nama }}</a>
                        </h2>

                        @if ($psikolog->tersedia)
                            <span class="shrink-0 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">Tersedia</span>
                        @else
                            <span class="shrink-0 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-500">Penuh</span>
                        @endif
                    </div>

                    <p class="mt-1 text-sm font-medium text-primary">{{ $psikolog->spesialisasi }}</p>

                    @if ($psikolog->deskripsi_psikolog)
                        <p class="mt-3 flex-1 text-sm leading-6 text-gray-600">
                            {{ \Illuminate\Support\Str::limit($psikolog->deskripsi_psikolog, 100) }}
                        </p>
                    @else
                        <div class="flex-1"></div>
                    @endif

                    <div class="mt-5 flex items-center justify-between border-t border-blush-200 pt-4">
                        <div>
                            <p class="text-xs text-gray-500">Biaya per sesi</p>
                            <p class="font-bold text-ink">Rp {{ number_format($psikolog->tarif, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('psikolog.show', $psikolog) }}"
                           class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white transition hover:bg-primary-dark">
                            Lihat profil
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border border-dashed border-blush-200 bg-white p-10 text-center">
                <p class="text-gray-500">Tidak ada psikolog yang sesuai dengan pencarianmu.</p>
                <a href="{{ route('psikolog.index') }}" class="mt-3 inline-block text-sm font-semibold text-primary hover:underline">
                    Tampilkan semua psikolog
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $psikologs->links() }}
    </div>
</section>
@endsection