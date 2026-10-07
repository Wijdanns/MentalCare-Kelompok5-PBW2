{{--
    Field yang dipakai (samakan dengan BE):
    nama, spesialisasi, pengalaman_tahun, tarif, tersedia (true/false), foto (URL gambar)
--}}
@props(['psikolog'])

<article class="flex flex-col overflow-hidden rounded-3xl border border-blush-200 bg-white">
    <img src="{{ $psikolog->foto }}" alt="Foto {{ $psikolog->nama }}"
         class="aspect-[353/256] w-full object-cover" loading="lazy">

    <div class="flex flex-1 flex-col px-5 pb-5 pt-5 sm:px-6 sm:pb-6">
        @if ($psikolog->tersedia)
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

        <div class="mt-6 flex items-center justify-between gap-3 border-t border-gray-100 pt-4 text-sm">
            <span class="text-gray-500">{{ $psikolog->pengalaman_tahun }} tahun pengalaman</span>
            <span class="font-bold text-primary">Rp{{ number_format($psikolog->tarif, 0, ',', '.') }}</span>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-3 text-sm font-semibold">
            {{--  route('psikolog.show', $psikolog->id) --}}
            <a href="#" class="rounded-xl border border-gray-200 px-4 py-3 text-center text-primary transition hover:border-primary">Lihat profil</a>

            @if ($psikolog->tersedia)
                {{-- route ke form konsultasi / pilih jadwal --}}
                <a href="#" class="rounded-xl bg-primary px-4 py-3 text-center text-white transition hover:bg-primary-dark">Pilih jadwal</a>
            @else
                <span class="cursor-not-allowed rounded-xl bg-gray-200 px-4 py-3 text-center text-gray-500">Belum tersedia</span>
            @endif
        </div>
    </div>
</article>