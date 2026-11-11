<title>Login - MentalCare</title>
<script src="https://cdn.tailwindcss.com"></script>
<div class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

  <!-- Card Login -->
  <div class="bg-white p-8 rounded-2xl shadow-sm w-full max-w-sm relative">

    <!-- Icon Hati -->
    <div class="w-10 h-10 bg-pink-100 text-pink-600 rounded-full flex items-center justify-center text-lg mb-5">
      ♥
    </div>

    <!-- Judul -->
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat datang kembali</h2>
    <p class="text-gray-500 text-sm mb-6">Masuk untuk melanjutkan perawatan dirimu.</p>

    <!-- Notifikasi Success -->
    @if(session('success'))
      <div class="mb-4 text-xs text-green-600 bg-green-50 p-2 rounded">
        {{ session('success') }}
      </div>
    @endif

    <!-- Form (novalidate: matikan popup bawaan browser, validasi pakai Laravel) -->
    <form action="{{ route('login') }}" method="POST" class="space-y-4" novalidate>
      @csrf

      <!-- Input Email -->
      <div>
        <label class="block text-sm font-semibold text-gray-800 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
          class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-pink-500 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }}">
        @error('email')
          <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Input Password -->
      <div>
        <label class="block text-sm font-semibold text-gray-800 mb-1">Kata sandi</label>
        <input type="password" name="password" placeholder="Minimal 8 karakter"
          class="w-full px-3 py-2 border rounded-lg text-sm focus:outline-none focus:border-pink-500 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }}">
        @error('password')
          <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Tombol Masuk -->
      <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 rounded-lg text-sm transition duration-200">
        Masuk
      </button>
    </form>

    <p class="text-center text-xs text-gray-500 mt-6">
      Belum punya akun? <a href="{{ route('register') }}" class="text-rose-600 font-semibold hover:underline">Daftar</a>
    </p>

    <p class="text-center text-xs text-gray-400 mt-3">
      <a href="{{ route('home') }}" class="hover:text-rose-600">&larr; Kembali ke beranda</a>
    </p>
  </div>

</div>