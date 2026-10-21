@extends('layouts.app')

@section('title', 'Dashboard Pasien | MentalCare')

@section('content')
<div class="mx-auto max-w-[1168px] px-5 py-10 sm:px-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Dashboard Pasien</h1>
            <p class="text-xs text-gray-500 mt-1">Selamat datang! Kelola jadwal konsultasi dan ulasan sesi di sini.</p>
        </div>
        <a href="{{ url('/konsultasi') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-5 py-2.5 text-xs font-semibold text-white shadow-md shadow-primary/20 transition hover:bg-primary-dark">
            + Buat Konsultasi Baru
        </a>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="mt-6 p-4 text-xs text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    {{-- SECTION RIWAYAT KONSULTASI & FORM ULASAN --}}
    <div class="mt-8 space-y-4">
        <h2 class="text-lg font-bold text-gray-800">Riwayat Konsultasi & Ulasan</h2>

        @forelse($riwayatKonsultasi ?? [] as $item)
            <div class="p-5 bg-white rounded-2xl border border-gray-100 shadow-sm space-y-4">
                {{-- Header Riwayat --}}
                <div class="flex justify-between items-start border-b pb-3">
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">
                            {{ $item->psikolog->nama ?? 'Psikolog MentalCare' }}
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Waktu Pesan: {{ $item->created_at ? $item->created_at->format('d M Y, H:i') : '-' }}
                        </p>
                    </div>
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-700 capitalize">
                        {{ $item->status_konsultasi ?? 'Selesai' }}
                    </span>
                </div>

                {{-- Rincian Singkat --}}
                <div class="text-xs text-gray-600 flex justify-between">
                    <span>Total Biaya: <strong>Rp {{ number_format($item->total_biaya ?? 0, 0, ',', '.') }}</strong></span>
                    <span>Metode Pembayaran: {{ $item->pembayaran->metode_pembayaran ?? 'Transfer Bank' }}</span>
                </div>

                {{-- LOGIKA FITUR ULASAN & RATING --}}
                <div class="pt-2 border-t border-gray-100">
                    @if($item->reviewPsikolog)
                        {{-- KONDISI A: JIKA PASIEN SUDAH MEMBERI ULASAN --}}
                        <div class="p-3.5 bg-pink-50/50 border border-pink-100 rounded-xl space-y-1 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-amber-500 font-bold">⭐ {{ $item->reviewPsikolog->rating }}/5</span>
                                <span class="text-[10px] text-gray-400">Ulasan Tersimpan</span>
                            </div>
                            <p class="text-gray-700 italic">"{{ $item->reviewPsikolog->ulasan }}"</p>
                        </div>
                    @else
                        {{-- KONDISI B: JIKA PASIEN BELUM MEMBERI ULASAN (FORM DITAMPILKAN) --}}
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-3">
                            <div class="flex items-center gap-1.5 font-bold text-gray-800 text-xs">
                                <span>⭐</span>
                                <span>Beri Ulasan Sesi Ini</span>
                            </div>

                            <form action="{{ route('review.store', $item->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <div class="sm:col-span-1">
                                        <label class="block text-gray-600 font-medium text-[11px] mb-1">Rating</label>
                                        <select name="rating" class="w-full px-2.5 py-2 border border-gray-200 rounded-lg text-xs bg-white focus:outline-none focus:ring-1 focus:ring-primary" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                            <option value="3">⭐⭐⭐ (3/5)</option>
                                            <option value="2">⭐⭐ (2/5)</option>
                                            <option value="1">⭐ (1/5)</option>
                                        </select>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-gray-600 font-medium text-[11px] mb-1">Ulasan Pengalaman</label>
                                        <input type="text" name="ulasan" placeholder="Bagaimana pengalaman konsultasimu dengan psikolog ini?" class="w-full px-2.5 py-2 border border-gray-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-primary" required>
                                    </div>
                                </div>
                                <button type="submit" class="w-full sm:w-auto px-5 bg-primary hover:bg-primary-dark text-white font-semibold py-2 rounded-lg text-xs transition shadow-sm">
                                    Kirim Ulasan & Rating
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-10 text-center text-xs text-gray-400 bg-white rounded-2xl border border-dashed border-gray-200">
                Belum ada riwayat konsultasi. Yuk, buat jadwal konsultasi pertamamu!
            </div>
        @endforelse
    </div>
</div>
@endsection