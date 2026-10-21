<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Konsultasi - MentalCare</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <div class="max-w-2xl mx-auto px-4 py-10">
        
        <!-- Header Kartu -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center mb-6">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xl mx-auto mb-3">
                ✓
            </div>
            <h1 class="text-xl font-bold text-gray-800">Pesanan Konsultasi Berhasil Dibuat!</h1>
            <p class="text-sm text-gray-500 mt-1">Berikut adalah detail ringkasan pesanan konsultasi kamu.</p>
        </div>

        <!-- Detail Pesanan -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <h3 class="font-bold text-gray-800 border-b pb-2 text-sm">Detail Sesi & Psikolog</h3>
            
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-xs text-gray-400">Nama Psikolog</span>
                    <span class="font-semibold text-gray-700">{{ $konsultasi->psikolog->nama ?? 'Psikolog MentalCare' }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400">Metode</span>
                    <span class="font-semibold text-gray-700 capitalize">{{ $konsultasi->metode ?? 'Online' }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400">Status Pembayaran</span>
                    <span class="inline-block px-2.5 py-0.5 bg-amber-100 text-amber-800 rounded-full text-xs font-medium mt-0.5">
                        {{ ucfirst($konsultasi->status_pembayaran ?? 'Menunggu Konfirmasi') }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400">Total Biaya</span>
                    <span class="font-semibold text-rose-600">Rp {{ number_format($konsultasi->biaya ?? 150000, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Form Rating & Ulasan Psikolog (Fitur Tambahan UTS) -->
        <div class="mt-6 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-xl">⭐</span>
                <h3 class="font-bold text-gray-800 text-base">Beri Ulasan Sesi Konsultasi</h3>
            </div>

            {{-- Pesan Sukses setelah submit --}}
            @if(session('success'))
                <div class="p-3 mb-4 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('review.store', $konsultasi->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih Rating Bintang</label>
                    <select name="rating" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-rose-500" required>
                        <option value="5">⭐⭐⭐⭐⭐ (5/5) - Sangat Memuaskan</option>
                        <option value="4">⭐⭐⭐⭐ (4/5) - Memuaskan</option>
                        <option value="3">⭐⭐⭐ (3/5) - Cukup Baik</option>
                        <option value="2">⭐⭐ (2/5) - Kurang Memuaskan</option>
                        <option value="1">⭐ (1/5) - Perlu Perbaikan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Ulasan / Catatan Pengalaman</label>
                    <textarea name="ulasan" rows="3" placeholder="Bagaimana pengalaman konsultasimu bersama psikolog ini?" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
                </div>

                <button type="submit" class="w-full bg-rose-600 text-white font-semibold text-xs py-2.5 rounded-xl hover:bg-rose-700 transition shadow-sm">
                    Kirim Ulasan & Rating
                </button>
            </form>
        </div>

        <!-- Tombol Kembali ke Dashboard/Home -->
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-xs text-gray-500 hover:text-gray-800 underline">← Kembali ke Beranda Utama</a>
        </div>

    </div>

</body>
</html>