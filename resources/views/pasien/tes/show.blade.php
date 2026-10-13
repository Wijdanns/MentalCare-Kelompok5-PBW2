@extends('layouts.app')

@section('title', $tes->nama_tes . ' | MentalCare')

@section('content')
<section class="mx-auto max-w-3xl px-5 py-12 sm:px-8 lg:py-16">

    <a href="{{ route('tes.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary">&larr; Semua tes</a>

    <h1 class="mt-4 text-3xl font-extrabold tracking-tight">{{ $tes->nama_tes }}</h1>
    @if ($tes->deskripsi)
        <p class="mt-3 text-gray-600">{{ $tes->deskripsi }}</p>
    @endif

    {{-- Progress (menempel di bawah navbar saat scroll) --}}
    <div class="sticky top-16 z-10 -mx-5 mt-6 border-b border-blush-200 bg-white/95 px-5 py-3 backdrop-blur sm:top-20 sm:mx-0 sm:rounded-xl sm:border sm:px-4">
        <div class="flex items-center justify-between text-xs font-semibold text-gray-600">
            <span>Terjawab <span id="jumlah-terjawab">0</span> dari {{ $tes->pertanyaan->count() }}</span>
            <span id="persen-terjawab">0%</span>
        </div>
        <div class="mt-2 h-2 overflow-hidden rounded-full bg-blush-100">
            <div id="bar-terjawab" class="h-full w-0 rounded-full bg-primary transition-all duration-300"></div>
        </div>
    </div>

    @error('jawaban')
        <div class="mt-6 rounded-xl bg-red-50 p-4 text-sm text-red-700">{{ $message }}</div>
    @enderror

    <form id="form-tes" method="POST" action="{{ route('tes.submit', $tes) }}" class="mt-6 space-y-5">
        @csrf

        @foreach ($tes->pertanyaan as $p)
            <fieldset class="rounded-2xl border border-blush-200 bg-white p-5 sm:p-6">
                <legend class="sr-only">Pertanyaan {{ $loop->iteration }}</legend>

                <p class="font-semibold text-ink">
                    <span class="mr-1 text-primary">{{ $loop->iteration }}.</span>{{ $p->pertanyaan }}
                </p>

                <div class="mt-4 grid gap-2">
                    @foreach ($p->jawabanPsikologis as $j)
                        <label class="block cursor-pointer">
                            <input type="radio"
                                   name="jawaban[{{ $p->id }}]"
                                   value="{{ $j->id }}"
                                   class="peer sr-only"
                                   @checked((int) old('jawaban.' . $p->id) === $j->id)
                                   required>
                            <span class="block rounded-xl border border-gray-200 px-4 py-3 text-sm text-gray-700 transition
                                         hover:border-primary
                                         peer-checked:border-primary peer-checked:bg-blush-100 peer-checked:font-semibold peer-checked:text-primary
                                         peer-focus-visible:ring-2 peer-focus-visible:ring-primary/40">
                                {{ $j->jawaban }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </fieldset>
        @endforeach

        <button type="submit"
                class="w-full rounded-xl bg-primary px-6 py-3.5 font-semibold text-white shadow-lg shadow-primary/30 transition hover:bg-primary-dark">
            Lihat hasil
        </button>

        <p class="text-center text-xs text-gray-400">
            Hasil tes ini adalah skrining awal dan bukan diagnosis.
        </p>
    </form>
</section>
@endsection

@push('scripts')
<script>
    const form = document.getElementById('form-tes');
    const total = {{ $tes->pertanyaan->count() }};

    function updateProgress() {
        const terjawab = new Set(
            [...form.querySelectorAll('input[type=radio]:checked')].map(r => r.name)
        ).size;
        const persen = Math.round((terjawab / total) * 100);

        document.getElementById('jumlah-terjawab').textContent = terjawab;
        document.getElementById('persen-terjawab').textContent = persen + '%';
        document.getElementById('bar-terjawab').style.width = persen + '%';
    }

    form.addEventListener('change', updateProgress);
    updateProgress(); // hitung ulang bila ada jawaban lama (old input)
</script>
@endpush