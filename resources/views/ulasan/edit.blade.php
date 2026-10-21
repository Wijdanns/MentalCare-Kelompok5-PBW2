@extends('layouts.app')

@section('title', 'Edit Ulasan | MentalCare')

@section('content')

<section class="mx-auto max-w-2xl px-5 py-12 sm:px-8 sm:py-16">
    <a href="{{ route('ulasan.index') }}" class="text-sm font-semibold text-primary transition hover:text-primary-dark">&larr; Kembali ke ulasan</a>

    <div class="mt-4 rounded-3xl border border-blush-200 bg-white p-6 shadow-xl shadow-primary/10 sm:p-8">
        <h1 class="text-2xl font-bold tracking-tight">Edit ulasan</h1>
        <p class="mt-1 text-sm text-gray-500">untuk {{ $ulasan->psikolog?->nama ?? 'Psikolog' }}</p>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <p class="font-semibold">Perubahan belum bisa disimpan:</p>
                <ul class="mt-1 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ulasan.update', $ulasan) }}" method="POST" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <span class="mb-1 block text-sm font-semibold">Rating</span>

                <x-input-bintang :nilai="old('rating', $ulasan->rating)" />
                @error('rating')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="komentar" class="mb-1 block text-sm font-semibold">Komentar</label>
                <textarea id="komentar" name="komentar" rows="5"
                          class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm focus:border-primary focus:outline-none">{{ old('komentar', $ulasan->komentar) }}</textarea>
                @error('komentar')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <button type="submit"
                        class="rounded-xl bg-primary px-6 py-3.5 font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary-dark">
                    Simpan perubahan
                </button>
                <a href="{{ route('ulasan.index') }}"
                   class="rounded-xl border border-gray-200 px-6 py-3.5 text-center font-semibold text-gray-700 transition hover:border-primary hover:text-primary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</section>

@endsection