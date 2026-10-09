<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - MentalCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md relative">
        <div class="flex justify-between items-center mb-4">
            <span class="text-pink-500 text-xl">❤️</span>
            <button class="text-gray-400 hover:text-gray-600 text-xl font-bold">&times;</button>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-1">Mulai perjalananmu</h2>
        <p class="text-sm text-gray-500 mb-6">Buat akun untuk mengakses layanan MentalCare.</p>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
                @error('nama')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

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
                @error('password')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-rose-600 hover:bg-rose-700 text-white font-medium py-3 rounded-xl transition duration-200 text-sm mt-2">
                Daftar sekarang
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-rose-600 font-semibold hover:underline">Masuk</a>
        </p>
    </div>

</body>
</html>