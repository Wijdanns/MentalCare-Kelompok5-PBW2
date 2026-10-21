@extends('layouts.app')

@section('title', ($jurnal->exists ? 'Edit' : 'Tulis') . ' Jurnal | MentalCare')

@section('content')
@php $moodSekarang = (string) old('mood', $jurnal->mood); @endphp

<section class="mx-auto max-w-3xl px-5 py-12 sm:px-8 lg:py-16">

    <a href="{{ $jurnal->exists ? route('jurnal.show', $jurnal) : route('jurnal.index') }}"
       class="text-sm font-medium text-gray-500 hover:text-primary">&larr; Kembali</a>

    <h1 class="mt-4 text-3xl font-extrabold tracking-tight">{{ $jurnal->exists ? 'Edit jurnal' : 'Tulis jurnal' }}</h1>
    <p class="mt-2 text-sm text-gray-500">Tulis apa pun yang ada di pikiranmu. Tidak ada aturan.</p>

    <form method="POST"
          action="{{ $jurnal->exists ? route('jurnal.update', $jurnal) : route('jurnal.store') }}"
          class="mt-8 space-y-6">
        @csrf
        @if ($jurnal->exists) @method('PUT') @endif

        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-semibold text-gray-800">Tanggal</label>
            <input type="date" name="tanggal" max="{{ today()->toDateString() }}"
                   value="{{ old('tanggal', $jurnal->tanggal?->toDateString()) }}"
                   class="mt-2 rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:outline-none" required>
            @error('tanggal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Mood --}}
        <div>
            <p class="text-sm font-semibold text-gray-800">Bagaimana perasaanmu? <span class="font-normal text-gray-400">(opsional)</span></p>
            <div class="mt-2 flex flex-wrap gap-2">
                <label class="cursor-pointer">
                    <input type="radio" name="mood" value="" class="peer sr-only" @checked($moodSekarang === '')>
                    <span class="block rounded-full border border-gray-200 px-4 py-1.5 text-sm text-gray-600 transition peer-checked:border-primary peer-checked:bg-blush-100 peer-checked:font-semibold peer-checked:text-primary">Lewati</span>
                </label>
                @foreach (\App\Models\Jurnal::MOOD as $nama => $emoji)
                    <label class="cursor-pointer">
                        <input type="radio" name="mood" value="{{ $nama }}" class="peer sr-only" @checked($moodSekarang === $nama)>
                        <span class="block rounded-full border border-gray-200 px-4 py-1.5 text-sm text-gray-700 transition hover:border-primary peer-checked:border-primary peer-checked:bg-blush-100 peer-checked:font-semibold peer-checked:text-primary">
                            {{ $emoji }} {{ $nama }}
                        </span>
                    </label>
                @endforeach
            </div>
            @error('mood') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Judul --}}
        <div>
            <label class="block text-sm font-semibold text-gray-800">Judul <span class="font-normal text-gray-400">(opsional)</span></label>
            <input type="text" name="judul" maxlength="255" value="{{ old('judul', $jurnal->judul) }}"
                   placeholder="Beri judul kalau mau"
                   class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:border-primary focus:outline-none">
            @error('judul') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Isi --}}
        <div>
            <label class="block text-sm font-semibold text-gray-800">Ceritamu</label>
            <textarea name="isi" rows="14" maxlength="20000" required placeholder="Hari ini aku merasa..."
                      class="mt-2 w-full rounded-xl border border-gray-200 px-4 py-3 text-sm leading-7 focus:border-primary focus:outline-none">{{ old('isi', $jurnal->isi) }}</textarea>
            @error('isi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button type="submit"
                    class="rounded-xl bg-primary px-6 py-3 font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary-dark">
                Simpan
            </button>
            <a href="{{ $jurnal->exists ? route('jurnal.show', $jurnal) : route('jurnal.index') }}"
               class="rounded-xl border border-gray-200 px-6 py-3 font-semibold text-gray-600 transition hover:border-primary hover:text-primary">
                Batal
            </a>
        </div>

        <p class="text-xs leading-5 text-gray-400">
            Jurnal ini hanya bisa dibaca olehmu. Kalau kamu sedang merasa berat dan butuh teman bicara,
            <a href="{{ route('psikolog.index') }}" class="font-semibold text-primary hover:underline">psikolog kami siap membantu</a>.
        </p>
    </form>
</section>
@endsection