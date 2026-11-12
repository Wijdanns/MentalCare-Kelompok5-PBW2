@extends('layouts.app')

@section('title', 'Riwayat Konsultasi - MentalCare')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10 w-full">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Konsultasi Saya</h1>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($konsultasi->isEmpty())
        <div class="text-center py-10 bg-white rounded-xl border border-gray-100">
            <p class="text-gray-500">Kamu belum pernah membuat janji konsultasi.</p>
            <a href="{{ route('konsultasi.index') }}" class="mt-4 inline-block bg-rose-600 text-white px-5 py-2 rounded-lg text-sm">Buat Jadwal Sekarang</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($konsultasi as $k)
                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="font-bold text-gray-900">{{ $k->psikolog->nama }}</h3>
                            <span class="text-xs px-2 py-1 rounded font-semibold 
                                {{ $k->status_konsultasi == 'Menunggu Pembayaran' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $k->status_konsultasi == 'Dikonfirmasi' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $k->status_konsultasi == 'Selesai' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $k->status_konsultasi == 'Batal' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $k->status_konsultasi }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">
                            📅 {{ \Carbon\Carbon::parse($k->jadwal->tanggal)->translatedFormat('d F Y') }} | 
                            ⏰ {{ \Carbon\Carbon::parse($k->jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($k->jadwal->jam_selesai)->format('H:i') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Total Tagihan: Rp {{ number_format($k->total_biaya, 0, ',', '.') }}</p>
                    </div>

                    <!-- Tombol Lanjut Pembayaran (muncul jika status masih menunggu dan bukti belum ada) -->
                    @if($k->status_konsultasi == 'Menunggu Pembayaran' && empty($k->pembayaran->bukti_pembayaran))
                        <a href="{{ route('konsultasi.konfirmasi', $k->id) }}" class="bg-rose-600 hover:bg-rose-700 text-white font-semibold px-5 py-2 rounded-lg text-sm transition text-center w-full md:w-auto">
                            Lanjut Pembayaran
                        </a>
                    @elseif(!empty($k->pembayaran->bukti_pembayaran) && $k->status_konsultasi == 'Menunggu Pembayaran')
                        <div class="px-4 py-2 bg-gray-50 border border-gray-200 text-gray-600 rounded-lg text-sm text-center w-full md:w-auto">
                            Bukti sedang dicek
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection