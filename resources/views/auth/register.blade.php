<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PEP DAMKAR</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(59,130,246,.08), transparent 40%),
                radial-gradient(circle at bottom right, rgba(220,38,38,.08), transparent 40%),
                #f9fafb;
        }
    </style>
</head>

<body>
<div class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-8 sm:p-10">

        <!-- Header -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo-damkar.png') }}"
                 class="h-16 mx-auto mb-4">

            <h2 class="text-2xl font-bold text-gray-900">
                Daftar Akun Baru
            </h2>

            <p class="text-sm text-gray-600 mt-1">
                PEP – Dinas Pemadaman Kebakaran dan Penyelamatan Kota Depok
            </p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-600">
            {{ $errors->first() }}
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
                <input type="text" name="nama_admin" required
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Username</label>
                <input type="text" name="username_admin" required
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Password</label>
                <input type="password" name="password_admin" required
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Konfirmasi Password</label>
                <input type="password" name="password_admin_confirmation" required
                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <button type="submit"
                class="w-full bg-gradient-to-r from-purple-700 to-red-600 text-white py-3 rounded-lg font-semibold hover:opacity-90 shadow-lg">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold">Login</a>
        </p>

    </div>
</div>
</body>
</html>
