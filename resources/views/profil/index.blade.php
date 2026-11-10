@extends('layouts.app')

@section('title', 'Akun Saya | MentalCare')

@section('content')
<section class="mx-auto max-w-[1168px] px-5 py-10 sm:px-8">
    <h1 class="text-3xl font-extrabold text-ink">Akun Saya</h1>

    @if(session('success'))
        <div class="mt-4 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-8 grid gap-8 lg:grid-cols-3">
        {{-- Card Informasi Profil & Form Edit --}}
        <div class="space-y-6 lg:col-span-1">
            <div class="rounded-2xl border border-blush-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col items-center text-center">
                    @if ($user->profil)
                        <img src="{{ asset('storage/' . $user->profil) }}" alt="{{ $user->nama }}" class="h-24 w-24 rounded-full object-cover shadow">
                    @else
                        <span class="flex h-24 w-24 items-center justify-center rounded-full bg-primary text-3xl font-bold text-white shadow">
                            {{ strtoupper(mb_substr($user->nama, 0, 1)) }}
                        </span>
                    @endif
                    <h2 class="mt-4 text-xl font-bold text-ink">{{ $user->nama }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    <span class="mt-2 inline-block rounded-full bg-blush-100 px-3 py-1 text-xs font-semibold capitalize text-primary">
                        {{ $user->role }}
                    </span>
                </div>

                <hr class="my-6 border-blush-200">

                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="mt-1 w-full rounded-xl border border-gray-200 p-3 text-sm focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ubah Foto Profil</label>
                        <input type="file" name="profil" accept="image/*" class="mt-1 w-full text-xs text-gray-500 file:mr-3 file:rounded-xl file:border-0 file:bg-blush-100 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary hover:file:bg-blush-200">
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-primary py-2.5 text-sm font-semibold text-white transition hover:bg-primary-dark">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        {{-- Tab Riwayat --}}
        <div class="space-y-8 lg:col-span-2">
            {{-- Riwayat Konsultasi --}}
            <div class="rounded-2xl border border-blush-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-ink">Riwayat Konsultasi</h3>

                <div class="mt-4 space-y-4">
                    @forelse ($riwayatKonsultasi as $konsultasi)
                        <div class="flex flex-wrap items-center justify-between gap-4 rounded-xl border border-blush-200/70 p-4 hover:border-primary/50 transition">
                            <div class="flex items-center gap-3">
                                <img src="{{ $konsultasi->psikolog->foto }}" alt="{{ $konsultasi->psikolog->nama }}" class="h-12 w-12 rounded-full object-cover">
                                <div>
                                    <h4 class="font-bold text-ink">{{ $konsultasi->psikolog->nama }}</h4>
                                    <p class="text-xs text-gray-500">
                                        {{ $konsultasi->jadwal ? \Carbon\Carbon::parse($konsultasi->jadwal->tanggal)->format('d M Y') . ' (' . $konsultasi->jadwal->jam_mulai . ')' : '-' }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold
                                    {{ $konsultasi->status_konsultasi === 'Dikonfirmasi' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $konsultasi->status_konsultasi === 'Menunggu Pembayaran' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $konsultasi->status_konsultasi === 'Batal' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $konsultasi->status_konsultasi }}
                                </span>
                                <p class="mt-1 text-sm font-bold text-primary">Rp {{ number_format($konsultasi->total_biaya, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="rounded-xl border border-dashed border-blush-200 p-6 text-center text-sm text-gray-500">
                            Belum ada riwayat konsultasi.
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- Riwayat Tes Psikologi --}}
            <div class="rounded-2xl border border-blush-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-ink">Riwayat Tes Psikologi</h3>

                <div class="mt-4 space-y-4">
                    @forelse ($riwayatTes as $tes)
                        <div class="flex items-center justify-between rounded-xl border border-blush-200/70 p-4">
                            <div>
                                <h4 class="font-bold text-ink">{{ $tes->tesPsikologis->nama_tes ?? 'Tes Psikologi' }}</h4>
                                <p class="text-xs text-gray-500">Tanggal: {{ $tes->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500">Total Poin</span>
                                <p class="text-lg font-bold text-primary">{{ $tes->total_poin }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="rounded-xl border border-dashed border-blush-200 p-6 text-center text-sm text-gray-500">
                            Belum ada riwayat tes psikologi.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection