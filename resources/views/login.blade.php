
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

    <!-- Form -->
    <form class="space-y-4">
      <!-- Input Email -->
      <div>
        <label class="block text-sm font-semibold text-gray-800 mb-1">Email</label>
        <input type="email" placeholder="nama@email.com" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-pink-500">
      </div>

      <!-- Input Password -->
      <div>
        <label class="block text-sm font-semibold text-gray-800 mb-1">Kata sandi</label>
        <input type="password" placeholder="Minimal 8 karakter" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-pink-500">
      </div>

      <!-- Tombol Masuk -->
      <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2.5 rounded-lg text-sm transition duration-200">
        Masuk
      </button>
    </form>

    <p class="text-center text-xs text-gray-500 mt-6">
      Belum punya akun? <a href="/register" class="text-rose-600 font-semibold hover:underline">Daftar</a>
    </p>

  </div>

</div>