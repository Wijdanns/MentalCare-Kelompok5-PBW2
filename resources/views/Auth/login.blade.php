<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MentalCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md relative">
        <!-- Icon Heart & Close -->
        <div class="flex justify-between items-center mb-4">
            <span class="text-pink-500 text-xl">❤️</span>
            <button class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat datang kembali</h2>
        <p class="text-sm text-gray-500 mb-6">Masuk untuk melanjutkan perawatan dirimu.</p>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-3 rounded-lg text-xs mb-4 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
                @error('email')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kata sandi</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>

            <button type="submit"
                class="w-full bg-rose-600 hover:bg-rose-700 text-white font-medium py-3 rounded-xl transition duration-200 text-sm mt-2">
                Masuk
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-6">
            Belum punya akun? <a href="{{ route('register') }}" class="text-rose-600 font-semibold hover:underline">Daftar</a>
        </p>
    </div>

</body>
</html>