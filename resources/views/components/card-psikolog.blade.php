@props(['psikolog'])

@php
    $inisial = \Illuminate\Support\Str::of($psikolog->nama)
        ->replace(['Dr.', 'M.Psi.', ','], '')
        ->explode(' ')->filter()
        ->map(fn ($kata) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($kata, 0, 1)))
        ->take(2)->implode('');

    $tersedia = (bool) ($psikolog->tersedia ?? false);

    // Tombol "Pilih jadwal" menuju halaman konsultasi dengan psikolog terpilih
    $linkJadwal = url('/konsultasi') . (isset($psikolog->id) ? '?psikolog=' . $psikolog->id : '');

    // Data yang dikirim ke pop-up profil
    $profil = [
        'nama' => $psikolog->nama,
        'email' => $psikolog->email ?? '',
        'spesialisasi' => $psikolog->spesialisasi ?? '',
        'tarif' => 'Rp' . number_format($psikolog->tarif ?? 0, 0, ',', '.'),
        'deskripsi' => $psikolog->deskripsi ?? '',
        'foto' => $psikolog->foto ?? '',
        'inisial' => $inisial,
        'tersedia' => $tersedia,
        'link_jadwal' => $linkJadwal,
    ];
@endphp

<article x-data class="flex h-full flex-col overflow-hidden rounded-3xl border border-blush-200 bg-white">
    @if (!empty($psikolog->foto))
        <img src="{{ $psikolog->foto }}" alt="Foto {{ $psikolog->nama }}"
             class="aspect-[353/256] w-full object-cover" loading="lazy">
    @else
        <div class="flex aspect-[353/256] w-full items-center justify-center bg-gradient-to-br from-blush-100 to-blush-200">
            <span class="flex h-20 w-20 items-center justify-center rounded-full bg-white/80 text-2xl font-bold text-primary">{{ $inisial }}</span>
        </div>
    @endif

    <div class="flex flex-1 flex-col px-5 pb-5 pt-5 sm:px-6 sm:pb-6">
        @if ($tersedia)
            <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-blush-200/70 px-3 py-1 text-xs font-medium text-primary">
                <span class="h-1.5 w-1.5 rounded-full bg-primary"></span> Tersedia
            </span>
        @else
            <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-500">
                <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Tidak tersedia
            </span>
        @endif

        <h3 class="mt-3 text-lg font-bold">{{ $psikolog->nama }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ $psikolog->spesialisasi }}</p>

        <div class="mt-auto">
            <div class="mt-6 flex items-center justify-between gap-3 border-t border-gray-100 pt-4 text-sm">
                <span class="text-gray-500">{{ $psikolog->pengalaman_tahun }} tahun pengalaman</span>
                <span class="font-bold text-primary">Rp{{ number_format($psikolog->tarif, 0, ',', '.') }}</span>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-3 text-sm font-semibold">
                <button type="button" @click="$dispatch('buka-profil', @js($profil))"
                        class="rounded-xl border border-gray-200 px-4 py-3 text-center text-primary transition hover:border-primary">Lihat profil</button>

                @if ($tersedia)
                    <a href="{{ $linkJadwal }}" class="rounded-xl bg-primary px-4 py-3 text-center text-white transition hover:bg-primary-dark">Pilih jadwal</a>
                @else
                    <span class="cursor-not-allowed rounded-xl bg-gray-200 px-4 py-3 text-center text-gray-500">Belum tersedia</span>
                @endif
            </div>
        </div>
    </div>
</article>