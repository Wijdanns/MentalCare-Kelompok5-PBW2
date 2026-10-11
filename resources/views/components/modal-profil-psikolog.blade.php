{{--
    Pop-up profil psikolog. Pasang SATU kali per halaman: <x-modal-profil-psikolog />
    Dibuka oleh tombol "Lihat profil" di <x-card-psikolog> lewat event 'buka-profil'.
--}}
<div x-data="{ open: false, p: {} }"
     @buka-profil.window="p = $event.detail; open = true"
     @keydown.escape.window="open = false"
     x-effect="document.body.classList.toggle('overflow-hidden', open)">

    <div x-show="open" x-cloak x-transition.opacity
         @click.self="open = false"
         class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 p-4 backdrop-blur-[2px]"
         role="dialog" aria-modal="true" :aria-label="'Profil ' + p.nama">

        <div class="flex max-h-[90vh] w-full max-w-[672px] flex-col overflow-hidden rounded-3xl bg-white shadow-2xl sm:flex-row">

            {{-- Foto --}}
            <div class="h-56 shrink-0 sm:h-auto sm:w-[220px]">
                <template x-if="p.foto">
                    <img :src="p.foto" :alt="'Foto ' + p.nama" class="h-full w-full object-cover">
                </template>
                <template x-if="!p.foto">
                    <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-blush-100 to-blush-200">
                        <span class="flex h-24 w-24 items-center justify-center rounded-full bg-white/80 text-3xl font-bold text-primary" x-text="p.inisial"></span>
                    </div>
                </template>
            </div>

            {{-- Isi --}}
            <div class="relative flex-1 overflow-y-auto p-6 sm:p-8">
                <button type="button" @click="open = false" aria-label="Tutup"
                        class="absolute right-4 top-4 flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 transition hover:border-primary hover:text-primary">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
                </button>

                <span x-show="p.tersedia" class="inline-flex items-center gap-1.5 rounded-full bg-blush-200/70 px-3 py-1 text-xs font-medium text-primary">
                    <span class="h-1.5 w-1.5 rounded-full bg-primary"></span> Tersedia untuk konsultasi
                </span>
                <span x-show="!p.tersedia" class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-500">
                    <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span> Tidak tersedia
                </span>

                <h3 class="mt-4 pr-10 text-2xl font-bold tracking-tight" x-text="p.nama"></h3>
                <p class="mt-1 text-sm text-gray-500" x-show="p.email" x-text="p.email"></p>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl bg-blush-100 p-4">
                        <p class="text-xs text-gray-500">Spesialisasi</p>
                        <p class="mt-1.5 font-semibold" x-text="p.spesialisasi"></p>
                    </div>
                    <div class="rounded-2xl bg-blush-100 p-4">
                        <p class="text-xs text-gray-500">Biaya konsultasi</p>
                        <p class="mt-1.5 font-bold text-primary"><span x-text="p.tarif"></span> / sesi</p>
                    </div>
                </div>

                <h4 class="mt-6 font-bold">Tentang psikolog</h4>
                <p class="mt-2 text-sm leading-7 text-gray-600" x-text="p.deskripsi || 'Belum ada deskripsi.'"></p>

                <div class="mt-6 flex gap-3 text-sm font-semibold">
                    <template x-if="p.tersedia">
                        <a :href="p.link_jadwal" class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-primary px-5 py-3 text-white transition hover:bg-primary-dark">
                            Pilih jadwal
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </a>
                    </template>
                    <template x-if="!p.tersedia">
                        <span class="flex-1 cursor-not-allowed rounded-xl bg-gray-200 px-5 py-3 text-center text-gray-500">Belum tersedia</span>
                    </template>
                    <button type="button" @click="open = false" class="rounded-xl border border-gray-200 px-5 py-3 text-gray-700 transition hover:border-primary hover:text-primary">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>