<title>Registrasi - MentalCare</title>
<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

  <!-- Card Registrasi -->
  <div class="bg-white p-8 rounded-2xl shadow-sm w-full max-w-sm relative">
 
    <!-- Icon Hati -->
    <div class="w-10 h-10 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center text-lg mb-5">
      ♥
    </div>

    <!-- Judul & Subjudul -->
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Mulai perjalananmu</h2>
    <p class="text-gray-500 text-xs mb-6">Buat akun untuk mengakses layanan MentalCare.</p>

    <!-- Form Registrasi -->
    <form action="{{ route('register') }}" method="POST" class="space-y-4">
      @csrf

      <!-- Input Nama Lengkap -->
      <div>
        <label class="block text-xs font-bold text-gray-800 mb-1">Nama lengkap</label>
        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-pink-500" required>
        @error('nama')
          <span class="block text-xs text-red-500 mt-1">{{ $message }}</span>
        @enderror
      </div>

      <!-- Input Email -->
      <div>
        <label class="block text-xs font-bold text-gray-800 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-pink-500" required>
        @error('email')
          <span class="block text-xs text-red-500 mt-1">{{ $message }}</span>
        @enderror
      </div>

      <!-- Input Password -->
      <div>
        <label class="block text-xs font-bold text-gray-800 mb-1">Kata sandi</label>
        <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-pink-500" required>
        @error('password')
          <span class="block text-xs text-red-500 mt-1">{{ $message }}</span>
        @enderror
      </div>

      <!-- Tombol Daftar Sekarang -->
      <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 rounded-lg text-sm transition duration-200">
        Daftar sekarang
      </button>
    </form>

    <!-- Footer -->
    <p class="text-center text-xs text-gray-500 mt-6">
      Sudah punya akun? <a href="{{ route('login') }}" class="text-rose-600 font-semibold hover:underline">Masuk</a>
    </p>

    <p class="text-center text-xs text-gray-400 mt-3">
      <a href="{{ route('home') }}" class="hover:text-rose-600">&larr; Kembali ke beranda</a>
    </p>
  </div>

</div>