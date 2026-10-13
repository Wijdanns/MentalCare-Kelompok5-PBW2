{{-- Pemakaian:
<x-card-layanan judul="..." deskripsi="..." href="#">
    <x-slot name="icon"> <svg>...</svg> </x-slot>
</x-card-layanan>
--}}
@props(['judul', 'deskripsi', 'href' => '#'])

<article class="rounded-3xl border border-blush-200 bg-white p-6 sm:p-7">
    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-blush-200/70 text-primary">
        {{ $icon }}
    </span>
    <h3 class="mt-7 text-xl font-bold">{{ $judul }}</h3>
    <p class="mt-3 leading-7 text-gray-500">{{ $deskripsi }}</p>
    <a href="{{ $href }}" class="mt-4 inline-flex items-center gap-2 font-semibold text-primary hover:text-primary-dark">
        Selengkapnya
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
    </a>
</article>