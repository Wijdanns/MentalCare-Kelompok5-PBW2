@extends('layouts.app')

@section('title', 'Jurnal Mood | MentalCare')

@section('content')
@php
    $moodOptions = [
        'Sangat Baik' => ['emoji' => '😊', 'badge' => 'bg-emerald-100 text-emerald-700', 'checked' => 'peer-checked:border-emerald-500 peer-checked:bg-emerald-50'],
        'Baik'        => ['emoji' => '🙂', 'badge' => 'bg-teal-100 text-teal-700',       'checked' => 'peer-checked:border-teal-500 peer-checked:bg-teal-50'],
        'Biasa'       => ['emoji' => '😐', 'badge' => 'bg-slate-200 text-slate-700',     'checked' => 'peer-checked:border-slate-500 peer-checked:bg-slate-100'],
        'Cemas'       => ['emoji' => '😰', 'badge' => 'bg-amber-100 text-amber-700',     'checked' => 'peer-checked:border-amber-500 peer-checked:bg-amber-50'],
        'Sedih'       => ['emoji' => '😢', 'badge' => 'bg-sky-100 text-sky-700',         'checked' => 'peer-checked:border-sky-500 peer-checked:bg-sky-50'],
    ];
    $total      = $moods->count();
    $todayCount = $moods->filter(fn ($m) => $m->created_at->isToday())->count();
    $topMood    = $total ? $moods->groupBy('mood')->sortByDesc(fn ($g) => $g->count())->keys()->first() : null;
@endphp

<div class="mx-auto max-w-3xl px-4 py-10">

    {{-- Header --}}
    <div class="mb-6 rounded-3xl bg-gradient-to-br from-rose-600 to-rose-400 p-8 text-white shadow-lg">
        <h1 class="mb-1 text-2xl font-bold">Jurnal Suasana Hati</h1>
        <p class="text-white/90">Catat perasaanmu setiap hari untuk memantau kesehatan mentalmu.</p>
    </div>

    {{-- Ringkasan --}}
    <div class="mb-6 grid grid-cols-2 gap-3 md:grid-cols-3">
        <div class="col-span-2 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-rose-100 md:col-span-1">
            <div class="text-xs text-gray-500">Total catatan</div>
            <div class="text-2xl font-bold text-gray-800">{{ $total }}</div>
        </div>
        <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-rose-100">
            <div class="text-xs text-gray-500">Dicatat hari ini</div>
            <div class="text-2xl font-bold text-gray-800">{{ $todayCount }}</div>
        </div>
        <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-rose-100">
            <div class="text-xs text-gray-500">Mood paling sering</div>
            <div class="text-lg font-bold text-gray-800">{{ $topMood ? $moodOptions[$topMood]['emoji'].' '.$topMood : '-' }}</div>
        </div>
    </div>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div id="flash" class="mb-6 flex items-center justify-between rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="document.getElementById('flash').remove()" class="text-xl leading-none" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Form tambah mood --}}
    <div class="mb-6 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-rose-100">
        <h2 class="mb-4 text-lg font-bold text-gray-800">Bagaimana perasaanmu hari ini?</h2>

        <form action="{{ route('pasien.mood.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-2 sm:grid-cols-5">
                @foreach($moodOptions as $label => $opt)
                    <label class="cursor-pointer">
                        <input type="radio" name="mood" value="{{ $label }}" class="peer sr-only" @checked(old('mood') === $label)>
                        <div class="flex flex-col items-center gap-1 rounded-2xl border-2 border-gray-200 bg-white px-2 py-4 text-center text-sm font-semibold text-gray-500 transition hover:-translate-y-0.5 hover:border-rose-300 peer-focus-visible:ring-2 peer-focus-visible:ring-rose-300 {{ $opt['checked'] }} peer-checked:text-gray-800 peer-checked:shadow-md">
                            <span class="text-3xl">{{ $opt['emoji'] }}</span>
                            {{ $label }}
                        </div>
                    </label>
                @endforeach
            </div>
            @error('mood')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="mt-5">
                <label for="catatan" class="mb-2 block text-sm font-semibold text-gray-700">
                    Catatan singkat <span class="font-normal text-gray-400">(opsional)</span>
                </label>
                <input type="text" id="catatan" name="catatan" maxlength="255" value="{{ old('catatan') }}"
                       placeholder="Apa yang membuatmu merasa begitu?"
                       class="w-full rounded-xl border-2 px-4 py-3 outline-none transition focus:border-rose-500 {{ $errors->has('catatan') ? 'border-red-500' : 'border-gray-200' }}">
                @error('catatan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="mt-5 w-full rounded-xl bg-gradient-to-r from-rose-600 to-rose-400 py-3 text-base font-bold text-white shadow-md transition hover:-translate-y-0.5 hover:shadow-lg">
                Simpan Mood
            </button>
        </form>
    </div>

    {{-- Riwayat mood (hanya milik user yang login) --}}
    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-rose-100">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-800">Riwayat Mood Saya</h2>
            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700">{{ $total }} catatan</span>
        </div>

        <div class="space-y-3">
            @forelse($moods as $item)
                @php
                    $opt        = $moodOptions[$item->mood] ?? $moodOptions['Biasa'];
                    $bag        = 'update_' . $item->id;
                    $hasErr     = $errors->hasBag($bag);
                    $valMood    = $hasErr ? old('mood') : $item->mood;
                    $valCatatan = $hasErr ? old('catatan') : $item->catatan;
                @endphp

                <div class="flex items-start gap-4 rounded-2xl border border-rose-100 p-4 transition hover:shadow-md">
                    <div class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl text-2xl {{ $opt['badge'] }}">{{ $opt['emoji'] }}</div>

                    <div class="min-w-0 flex-1">
                        <div class="mb-1 flex flex-wrap items-center gap-2">
                            <span class="rounded-full px-3 py-0.5 text-xs font-bold {{ $opt['badge'] }}">{{ $item->mood }}</span>
                            <span class="text-xs text-gray-500">
                                {{ $item->created_at->format('d M Y, H:i') }} · {{ $item->created_at->diffForHumans() }}
                                @if($item->updated_at->gt($item->created_at))
                                    · <em>diedit</em>
                                @endif
                            </span>
                        </div>
                        @if($item->catatan)
                            <p class="break-words text-sm text-gray-700">{{ $item->catatan }}</p>
                        @else
                            <p class="text-sm italic text-gray-400">Tanpa catatan</p>
                        @endif
                    </div>

                    <div class="flex shrink-0 gap-1.5">
                        <button type="button"
                                onclick="document.getElementById('editModal{{ $item->id }}').showModal()"
                                class="rounded-lg border border-sky-200 px-3 py-1.5 text-xs font-semibold text-sky-600 transition hover:bg-sky-600 hover:text-white">
                            Edit
                        </button>

                        <form action="{{ route('pasien.mood.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus catatan ini?')"
                                    class="rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-semibold text-rose-600 transition hover:bg-rose-600 hover:text-white">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Modal edit --}}
                <dialog id="editModal{{ $item->id }}"
                        class="w-full max-w-md rounded-3xl p-0 shadow-2xl backdrop:bg-black/40">
                    <form action="{{ route('pasien.mood.update', $item->id) }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')

                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-800">Edit Mood</h3>
                            <button type="button" onclick="this.closest('dialog').close()"
                                    class="text-2xl leading-none text-gray-400 hover:text-gray-600" aria-label="Tutup">&times;</button>
                        </div>

                        <div class="mb-4">
                            <label for="editMood{{ $item->id }}" class="mb-2 block text-sm font-semibold text-gray-700">Mood</label>
                            <select name="mood" id="editMood{{ $item->id }}"
                                    class="w-full rounded-xl border-2 bg-white px-4 py-3 outline-none focus:border-rose-500 {{ $errors->getBag($bag)->has('mood') ? 'border-red-500' : 'border-gray-200' }}">
                                <option value="">-- Pilih Mood --</option>
                                @foreach($moodOptions as $label => $o)
                                    <option value="{{ $label }}" @selected($valMood === $label)>{{ $o['emoji'] }} {{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->getBag($bag)->has('mood'))
                                <p class="mt-1 text-sm text-red-600">{{ $errors->getBag($bag)->first('mood') }}</p>
                            @endif
                        </div>

                        <div class="mb-6">
                            <label for="editCatatan{{ $item->id }}" class="mb-2 block text-sm font-semibold text-gray-700">Catatan</label>
                            <input type="text" name="catatan" id="editCatatan{{ $item->id }}" maxlength="255"
                                   value="{{ $valCatatan }}"
                                   class="w-full rounded-xl border-2 px-4 py-3 outline-none focus:border-rose-500 {{ $errors->getBag($bag)->has('catatan') ? 'border-red-500' : 'border-gray-200' }}">
                            @if($errors->getBag($bag)->has('catatan'))
                                <p class="mt-1 text-sm text-red-600">{{ $errors->getBag($bag)->first('catatan') }}</p>
                            @endif
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="this.closest('dialog').close()"
                                    class="rounded-xl bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                                Batal
                            </button>
                            <button type="submit"
                                    class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-bold text-white hover:bg-rose-700">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </dialog>
            @empty
                <div class="py-10 text-center text-gray-500">
                    <div class="mb-2 text-5xl">🌱</div>
                    <p>Belum ada catatan mood.<br>Yuk catat perasaanmu hari ini!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($moods as $item)
            @if($errors->hasBag('update_' . $item->id))
                document.getElementById('editModal{{ $item->id }}').showModal();
            @endif
        @endforeach
    });
</script>
@endsection