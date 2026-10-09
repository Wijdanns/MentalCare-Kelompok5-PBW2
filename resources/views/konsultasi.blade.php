@extends('layouts.app')

@section('title', 'Konsultasi - MentalCare')

@section('content')
<div x-data="{
    step: 1,
    showModal: false,
    formData: {
      psikolog: '', tanggal: '2026-10-15', jam_mulai: '', jam_selesai: '',
      metode: 'Konsultasi chat', nama: '', alamat: '', email: '',
      jenis_kelamin: '', usia: '', metode_pembayaran: 'Transfer Bank'
    },
    steps: [
      { num: 1, title: 'Atur jadwal', desc: 'Pilih psikolog, tanggal, dan metode sesi.' },
      { num: 2, title: 'Lengkapi data', desc: 'Masukkan data diri dan metode pembayaran.' },
      { num: 3, title: 'Pembayaran', desc: 'Selesaikan pembayaran sesuai petunjuk.' },
      { num: 4, title: 'Selesai', desc: 'Konfirmasi akhir dan jadwal konsultasi.' }
    ],
    setSesi(val) {
      [this.formData.jam_mulai, this.formData.jam_selesai] = val ? val.split('-') : ['', ''];
    }
  }" class="w-full">

  <!-- HERO SECTION -->
  <section class="bg-pink-50/40 text-center py-12 px-4 border-b border-pink-100/50">
    <span class="inline-block bg-pink-100 text-rose-600 text-xs font-semibold px-4 py-1.5 rounded-full mb-4">Konsultasi online</span>
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-3">Ceritakan yang kamu rasakan</h1>
    <p class="text-gray-500 text-sm max-w-lg mx-auto">Pilih psikolog dan jadwal yang paling nyaman. Percakapanmu aman dan dijaga kerahasiannya.</p>
  </section>

  <!-- MAIN CONTAINER -->
  <div class="max-w-5xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-12 gap-8 w-full">

    <!-- LEFT SIDEBAR: STEP INDICATOR (Diperingkas pakai x-for) -->
    <div class="md:col-span-4 space-y-6">
      <div>
        <p class="text-xs font-bold text-rose-600 uppercase tracking-wider mb-1">Proses Pemesanan</p>
        <h2 class="text-2xl font-bold text-gray-900">Mudah dan transparan</h2>
      </div>

      <div class="space-y-4">
        <template x-for="item in steps" :key="item.num">
          <div class="flex items-start gap-3">
            <div :class="step === item.num ? 'bg-rose-600 text-white' : 'bg-pink-100 text-rose-600'" 
                 class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm shrink-0 transition" x-text="item.num"></div>
            <div>
              <p class="font-bold text-sm text-gray-800" x-text="item.title"></p>
              <p class="text-xs text-gray-400" x-text="item.desc"></p>
            </div>
          </div>
        </template>
      </div>
    </div>

    <!-- RIGHT FORM CARD -->
    <div class="md:col-span-8 bg-white p-6 md:p-8 rounded-2xl border border-gray-100 shadow-sm relative">

      <!-- LANGKAH 1: ATUR JADWAL -->
      <div x-show="step === 1" class="space-y-4">
        <div class="flex justify-between items-start mb-2">
          <div>
            <p class="text-xs font-bold text-rose-600 uppercase">LANGKAH 1 DARI 2</p>
            <h3 class="text-xl font-bold text-gray-900">Atur jadwal konsultasi</h3>
          </div>
          <div class="w-9 h-9 bg-pink-100 text-rose-600 rounded-lg flex items-center justify-center">📅</div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1">Pilih psikolog</label>
          <select x-model="formData.psikolog" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500 bg-white">
            <option value="">Pilih psikolog</option>
            <option value="Farhan Akbar, M.Psi.">Farhan Akbar, M.Psi.</option>
            <option value="Dimas Pratama, M.Psi.">Dimas Pratama, M.Psi.</option>
            <option value="Siti Rahma, M.Psi.">Siti Rahma, M.Psi.</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1">Tanggal konsultasi</label>
          <input type="date" x-model="formData.tanggal" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1">Pilih sesi pertemuan</label>
          <select @change="setSesi($event.target.value)" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500 bg-white">
            <option value="">Pilih sesi pertemuan</option>
            <option value="13:00-14:15">Sesi 1 — 13:00 sampai 14:15</option>
            <option value="15:15-16:30">Sesi 2 — 15:15 sampai 16:30</option>
            <option value="17:30-18:45">Sesi 3 — 17:30 sampai 18:45</option>
            <option value="19:45-21:00">Sesi 4 — 19:45 sampai 21:00</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1">Metode sesi</label>
          <select x-model="formData.metode" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500 bg-white">
            <option value="">Pilih metode</option>
            <option value="Online">Online</option>
            <option value="Offline">Offline</option>
          </select>
        </div>

        <button @click="step = 2" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 rounded-lg text-sm flex items-center justify-center gap-2 transition mt-4">
          Lanjutkan pemesanan <span>→</span>
        </button>
      </div>

      <!-- LANGKAH 2: LENGKAPI DATA -->
      <div x-show="step === 2" class="space-y-4" style="display: none;">
        <div class="flex justify-between items-start mb-2">
          <div>
            <p class="text-xs font-bold text-rose-600 uppercase">LANGKAH 2 DARI 2</p>
            <h3 class="text-xl font-bold text-gray-900">Lengkapi data pemesan</h3>
          </div>
          <div class="w-9 h-9 bg-pink-100 text-rose-600 rounded-lg flex items-center justify-center">👤</div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1">Nama lengkap</label>
          <input type="text" x-model="formData.nama" placeholder="Masukkan nama lengkap" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500">
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1">Alamat</label>
          <textarea x-model="formData.alamat" rows="2" placeholder="Masukkan alamat lengkap" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500"></textarea>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1">Email</label>
          <input type="email" x-model="formData.email" placeholder="nama@email.com" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500">
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-800 mb-1">Jenis kelamin</label>
            <select x-model="formData.jenis_kelamin" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500 bg-white">
              <option value="">Pilih jenis kelamin</option>
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-800 mb-1">Usia</label>
            <input type="number" x-model="formData.usia" placeholder="Contoh: 24" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-800 mb-1">Metode pembayaran</label>
          <select x-model="formData.metode_pembayaran" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-rose-500 bg-white">
            <option value="Transfer Bank">Transfer Bank</option>
            <option value="E-Wallet">QRIS</option>
          </select>
        </div>

        <div class="flex items-center gap-3 pt-2">
          <button @click="step = 1" class="w-1/2 border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-2.5 rounded-lg text-sm transition">Kembali</button>
          <button @click="showModal = true" class="w-1/2 bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 rounded-lg text-sm flex items-center justify-center gap-2 transition">
            Konfirmasi Pesanan <span>→</span>
          </button>
        </div>
      </div>

      <!-- LANGKAH 3: INSTRUKSI PEMBAYARAN -->
      <div x-show="step === 3" class="space-y-5" style="display: none;">
        <div class="flex justify-between items-start border-b pb-3">
          <div>
            <p class="text-xs font-bold text-rose-600 uppercase">Pembayaran</p>
            <h3 class="text-xl font-bold text-gray-900">Pembayaran Konsultasi</h3>
          </div>
          <div class="w-9 h-9 bg-pink-100 text-rose-600 rounded-lg flex items-center justify-center">💳</div>
        </div>

        <div class="bg-gray-50 p-4 rounded-xl space-y-3 border border-gray-100 text-sm">
          <div class="flex justify-between text-xs text-gray-500">
            <span>Total Tagihan:</span> <span class="font-bold text-rose-600 text-base">Rp 150.000</span>
          </div>

          <template x-if="formData.metode_pembayaran === 'Transfer Bank'">
            <div class="bg-white p-3 rounded-lg border border-gray-200 space-y-2">
              <p class="text-xs text-gray-500 font-semibold">Transfer ke Bank BCA:</p>
              <div class="flex justify-between items-center bg-gray-50 p-2 rounded border">
                <span class="font-mono font-bold text-gray-800 text-base">123-456-7890</span>
                <span class="text-xs text-rose-600 font-semibold">a.n MentalCare</span>
              </div>
            </div>
          </template>

          <template x-if="formData.metode_pembayaran === 'E-Wallet'">
            <div class="bg-white p-3 rounded-lg border border-gray-200 space-y-2 text-center">
              <p class="text-xs text-gray-500 font-semibold">QRIS:</p>
              <div class="w-32 h-32 bg-gray-200 mx-auto rounded-lg flex items-center justify-center text-xs text-gray-500">
                <img src="{{ asset('QRIS.jpeg') }}" alt="QRIS Code" class="w-28 h-28 object-contain">
              </div>
            </div>
          </template>
        </div>

        <div class="flex items-center gap-3 pt-2">
          <button @click="step = 2" class="w-1/2 border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-2.5 rounded-lg text-sm transition">Kembali</button>
          <button @click="step = 4" class="w-1/2 bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">Saya Sudah Bayar</button>
        </div>
      </div>

      <!-- LANGKAH 4: SELESAI / SUKSES -->
      <div x-show="step === 4" class="text-center py-6 space-y-6" style="display: none;">
        <div class="w-12 h-12 bg-pink-100 text-rose-600 rounded-full flex items-center justify-center text-xl mx-auto">✓</div>
        <div>
          <h3 class="text-xl font-bold text-gray-900 mb-1">Pembayaran Berhasil Diverifikasi!</h3>
          <p class="text-xs text-gray-400 max-w-xs mx-auto">Sesi konsultasi kamu telah dijadwalkan. Link sesi akan dikirimkan melalui email.</p>
        </div>

        <div class="bg-pink-50/40 rounded-xl p-4 text-xs text-left max-w-md mx-auto space-y-3 border border-pink-100/50">
          <div class="flex justify-between py-1 border-b border-pink-100">
            <span class="text-gray-400">Psikolog</span>
            <span class="font-bold text-gray-800" x-text="formData.psikolog || 'Farhan Akbar, M.Psi.'"></span>
          </div>
          <div class="flex justify-between py-1 border-b border-pink-100">
            <span class="text-gray-400">Jadwal</span>
            <span class="font-bold text-gray-800" x-text="`${formData.tanggal}, ${formData.jam_mulai}–${formData.jam_selesai}`"></span>
          </div>
          <div class="flex justify-between py-1">
            <span class="text-gray-400">Metode sesi</span>
            <span class="font-bold text-gray-800" x-text="formData.metode || 'Online'"></span>
          </div>
        </div>

        <button @click="step = 1" class="border border-rose-200 text-rose-600 hover:bg-rose-50 font-semibold px-6 py-2.5 rounded-lg text-sm transition">Buat Jadwal Baru</button>
      </div>

    </div>
  </div>

  <!-- POP-UP MODAL KONFIRMASI -->
  <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm" style="display: none;" x-transition>
    <div @click.away="showModal = false" class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-gray-100 space-y-5">
      <div class="flex justify-between items-center border-b pb-3">
        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Pemesanan</h3>
        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
      </div>

      <p class="text-xs text-gray-500">Periksa rincian pesanan sebelum berlanjut ke tahap pembayaran:</p>

      <div class="bg-pink-50/50 rounded-xl p-4 text-xs space-y-2.5 border border-pink-100">
        <div class="flex justify-between border-b border-pink-100/60 pb-1.5"><span class="text-gray-500">Nama Pemesan</span><span class="font-semibold text-gray-800" x-text="formData.nama || '-'"></span></div>
        <div class="flex justify-between border-b border-pink-100/60 pb-1.5"><span class="text-gray-500">Psikolog</span><span class="font-semibold text-gray-800" x-text="formData.psikolog || '-'"></span></div>
        <div class="flex justify-between border-b border-pink-100/60 pb-1.5"><span class="text-gray-500">Waktu Konsultasi</span><span class="font-semibold text-gray-800" x-text="`${formData.tanggal} (${formData.jam_mulai} - ${formData.jam_selesai})`"></span></div>
        <div class="flex justify-between"><span class="text-gray-500">Metode Pembayaran</span><span class="font-semibold text-rose-600" x-text="formData.metode_pembayaran || '-'"></span></div>
      </div>

      <div class="flex items-center gap-3 pt-2">
        <button @click="showModal = false" class="w-1/2 border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold py-2.5 rounded-lg text-sm transition">Cek Lagi</button>
        <button @click="showModal = false; step = 3" class="w-1/2 bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 rounded-lg text-sm transition">Lanjut Pembayaran</button>
      </div>
    </div>
  </div>

</div>
@endsection