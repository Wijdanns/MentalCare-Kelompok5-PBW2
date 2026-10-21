@extends('layouts.app')

@section('title', 'Ulasan | MentalCare')

@section('content')

{{-- ============ HERO + RINGKASAN RATING ============ --}}
<section class="bg-blush-100 px-5 pb-14 pt-14 text-center sm:px-8 sm:pb-20 sm:pt-20">
    <span class="inline-flex rounded-full bg-blush-200/70 px-4 py-2 text-sm font-medium text-primary">Rating &amp; ulasan</span>

    <h1 class="mx-auto mt-6 max-w-3xl text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl">
        Apa kata mereka tentang psikolog kami?
    </h1>

    <p class="mx-auto mt-5 max-w-2xl text-base leading-7 text-gray-600 sm:text-lg sm:leading-8">
        Bagikan pengalamanmu supaya pasien lain lebih mudah memilih psikolog yang tepat.
    </p>

    {{-- Kondisional: ringkasan hanya tampil kalau sudah ada ulasan --}}
    @if ($jumlahUlasan > 0)
        <div class="mt-8 inline-flex items-center gap-4 rounded-2xl bg-white px-6 py-4 shadow-sm">
            <span class="text-4xl font-extrabold text-primary">{{ number_format($rataRata, 1, ',', '.') }}</span>
            <div class="text-left">
                <x-bintang :nilai="round($rataRata)" />
                <p class="mt-1 text-xs text-gray-500">dari {{ $jumlahUlasan }} ulasan</p>
            </div>
        </div>
    @endif
</section>

<section class="mx-auto max-w-3xl px-5 py-12 sm:px-8 sm:py-16">

    {{-- Pesan sukses dari controller --}}
    @if (session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- ============ FORM TULIS ULASAN ============ --}}
    @guest
        <div class="rounded-3xl border border-blush-200 bg-white p-6 text-center sm:p-8">
            <p class="text-gray-600">Masuk dulu untuk menulis ulasan.</p>
            <a href="{{ route('login') }}" class="mt-4 inline-flex rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white transition hover:bg-primary-dark">Masuk</a>
        </div>
    @endguest

    @auth
        @if (auth()->user()->role === 'pasien')
            <div class="rounded-3xl border border-blush-200 bg-white p-6 shadow-xl shadow-primary/10 sm:p-8">
                <h2 class="text-xl font-bold tracking-tight">Tulis ulasanmu</h2>

                @if ($psikologs->isEmpty())
                    <p class="mt-4 text-sm text-gray-500">Belum ada psikolog yang bisa kamu ulas.</p>
                @else
                    <form action="{{ route('ulasan.store') }}" method="POST" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <label for="id_psikolog" class="mb-1 block text-sm font-semibold">Psikolog</label>
                            <select id="id_psikolog" name="id_psikolog"
                                    class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm focus:border-primary focus:outline-none">
                                <option value="">Pilih psikolog</option>
                                @foreach ($psikologs as $psikolog)
                                    {{-- old(): pilihan tetap terpilih kalau validasi gagal --}}
                                    <option value="{{ $psikolog->id }}" @selected((string) old('id_psikolog') === (string) $psikolog->id)>
                                        {{ $psikolog->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_psikolog')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <span class="mb-1 block text-sm font-semibold">Rating</span>
                            <x-input-bintang :nilai="old('rating', 0)" />
                            @error('rating')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="komentar" class="mb-1 block text-sm font-semibold">Komentar</label>
                            <textarea id="komentar" name="komentar" rows="4" placeholder="Ceritakan pengalamanmu (minimal 10 karakter)"
                                      class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-primary focus:outline-none">{{ old('komentar') }}</textarea>
                            @error('komentar')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="w-full rounded-xl bg-primary px-6 py-3.5 font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary-dark sm:w-auto">
                            Kirim ulasan
                        </button>
                    </form>
                @endif
            </div>
        @endif
    @endauth

    {{-- ============ DAFTAR ULASAN ============ --}}
    <div class="mt-12 space-y-5">
        <h2 class="text-xl font-bold tracking-tight">Semua ulasan</h2>

        {{-- tampilan kosong --}}
        @if ($ulasans->isEmpty())
            <p class="rounded-2xl border border-dashed border-blush-200 bg-white p-10 text-center text-gray-500">
                Belum ada ulasan.
            </p>
        @endif

        {{-- Perulangan: satu kartu per ulasan --}}
        @foreach ($ulasans as $ulasan)
            <article class="rounded-2xl border border-blush-200 bg-white p-5 sm:p-6">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-primary text-sm font-bold text-white">
                            {{ strtoupper(mb_substr($ulasan->user?->nama ?? '?', 0, 1)) }}
                        </span>
                        <div>
                            <p class="font-semibold">{{ $ulasan->user?->nama ?? 'Pengguna' }}</p>
                            <p class="text-xs text-gray-500">untuk {{ $ulasan->psikolog?->nama ?? 'Psikolog' }}</p>
                        </div>
                    </div>
                    <p class="shrink-0 text-xs text-gray-400">{{ $ulasan->created_at->locale('id')->translatedFormat('j F Y') }}</p>
                </div>

                <div class="mt-4"><x-bintang :nilai="$ulasan->rating" /></div>

                <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600">{{ $ulasan->komentar }}</p>

                {{-- Edit & hapus hanya untuk pemilik ulasan --}}
                @if (auth()->check() && (int) auth()->id() === (int) $ulasan->id_user)
                    <div class="mt-4 flex items-center gap-4 border-t border-gray-100 pt-4 text-sm font-semibold">
                        <a href="{{ route('ulasan.edit', $ulasan) }}" class="text-primary transition hover:text-primary-dark">Edit</a>

                        <form action="{{ route('ulasan.destroy', $ulasan) }}" method="POST"
                              onsubmit="return confirm('Hapus ulasan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 transition hover:text-red-700">Hapus</button>
                        </form>
                    </div>
                @endif
            </article>
        @endforeach
    </div>

    {{-- Navigasi halaman (paginate) --}}
    <div class="mt-8">
        {{ $ulasans->links() }}
    </div>
</section>

@endsection