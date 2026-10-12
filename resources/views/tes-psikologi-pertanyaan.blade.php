@extends('layouts.app')

@php
    // $tes dikirim dari controller (BE): TesPsikologis::with('pertanyaan.jawabanPsikologis').
    abort_unless(isset($tes), 404);

    // Hanya id dan teks yang dikirim ke browser. Poin TIDAK dikirim: skor dihitung BE.
    $daftar = $tes->pertanyaan->map(fn ($p) => [
        'id' => $p->getKey(),
        'teks' => $p->pertanyaan,
        'pilihan' => $p->jawabanPsikologis->map(fn ($j) => [
            'id' => $j->getKey(),
            'teks' => $j->jawaban,
        ])->values(),
    ])->values();
@endphp

@section('title', ($tes->nama_tes ?? 'Tes Psikologi') . ' | MentalCare')

@section('content')

<x-hero-tes />

<section class="mx-auto max-w-3xl px-5 py-12 sm:px-8 sm:py-16 lg:py-20">
    <div class="rounded-3xl border border-blush-200 bg-white p-6 shadow-xl shadow-primary/10 sm:p-10">

        @if ($daftar->isEmpty())
            <div class="py-6 text-center">
                <p class="text-gray-500">Tes ini belum memiliki pertanyaan.</p>
                <a href="{{ url('/tes-psikologi') }}"
                   class="mt-5 inline-flex rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-primary transition hover:border-primary">
                    Kembali ke daftar tes
                </a>
            </div>
        @else
            <div x-data="tesPsikologi">

                {{-- Progress --}}
                <div class="h-2 w-full overflow-hidden rounded-full bg-blush-200/60" role="progressbar"
                     :aria-valuenow="nomor + 1" aria-valuemin="1" :aria-valuemax="total">
                    <div class="h-full rounded-full bg-primary transition-all duration-300" :style="'width: ' + persen + '%'"></div>
                </div>

                <p class="mt-6 text-center text-sm text-gray-500">
                    Pertanyaan <span class="font-bold text-ink" x-text="nomor + 1"></span> dari <span x-text="total"></span>
                </p>

                {{-- Pertanyaan --}}
                <h2 class="mt-3 text-center text-xl font-bold leading-snug tracking-tight sm:text-2xl" x-text="soal.teks" aria-live="polite"></h2>

                {{-- Pilihan jawaban --}}
                <div class="mt-8 space-y-3">
                    <template x-for="pilihan in soal.pilihan" :key="pilihan.id">
                        <button type="button" @click="pilih(pilihan.id)" :disabled="terkunci"
                                :class="jawaban[soal.id] === pilihan.id
                                    ? 'border-primary bg-blush-100 font-semibold text-primary'
                                    : 'border-blush-200 bg-white text-gray-700 hover:border-primary hover:bg-blush-50'"
                                class="w-full rounded-xl border px-5 py-4 text-center text-base transition disabled:cursor-wait"
                                x-text="pilihan.teks"></button>
                    </template>

                    <p x-show="soal.pilihan.length === 0" x-cloak class="rounded-xl border border-dashed border-blush-200 p-6 text-center text-sm text-gray-500">
                        Pertanyaan ini belum memiliki pilihan jawaban.
                    </p>
                </div>

                <p x-show="selesai" x-cloak class="mt-6 text-center text-sm text-gray-500">Menghitung hasilmu...</p>

                {{-- Dikirim ke BE setelah pertanyaan terakhir dijawab: jawaban[id_pertanyaan] = id_jawaban --}}
                <form x-ref="form" method="POST" action="{{ url('/tes-psikologi/' . $tes->getKey()) }}">
                    @csrf
                    <template x-for="item in terkirim" :key="item[0]">
                        <input type="hidden" :name="'jawaban[' + item[0] + ']'" :value="item[1]">
                    </template>
                </form>
            </div>
        @endif
    </div>
</section>

@endsection

@if ($daftar->isNotEmpty())
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('tesPsikologi', () => ({
                daftar: @js($daftar),
                nomor: 0,
                jawaban: {},
                terkunci: false,
                selesai: false,

                get total() { return this.daftar.length; },
                get soal() { return this.daftar[this.nomor]; },
                get persen() { return Math.round(((this.nomor + 1) / this.total) * 100); },
                get terkirim() { return Object.entries(this.jawaban); },

                pilih(idPilihan) {
                    if (this.terkunci) return;
                    this.terkunci = true;
                    this.jawaban[this.soal.id] = idPilihan;

                    // Jeda singkat supaya pilihan terlihat, lalu lanjut
                    setTimeout(() => {
                        if (this.nomor + 1 < this.total) {
                            this.nomor++;
                            this.terkunci = false;
                        } else {
                            this.selesai = true;
                            this.$nextTick(() => this.$refs.form.submit());
                        }
                    }, 250);
                },
            }));
        });
    </script>
    @endpush
@endif