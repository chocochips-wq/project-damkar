<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PEP DAMKAR</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Background pattern halus */
        .bg-pattern {
            background-image:
                radial-gradient(circle at 1px 1px, rgba(0,0,0,0.03) 1px, transparent 0);
            background-size: 20px 20px;
        }

        /* Gradient kiri animasi pelan */
        .animated-gradient {
            background-size: 400% 400%;
            animation: gradientMove 10s linear infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @media (max-width: 768px) {
            .animated-gradient {
                animation: none;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-white to-gray-100 bg-pattern relative overflow-hidden">

    <!-- Shape blur -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-300 opacity-20 rounded-full blur-3xl"></div>
    <div class="absolute top-1/3 -right-32 w-96 h-96 bg-purple-300 opacity-20 rounded-full blur-3xl"></div>

    <div class="relative min-h-screen flex items-center justify-center p-4 sm:p-8">
        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="flex flex-col md:flex-row">

                <!-- LEFT -->
                <div
                    class="w-full md:w-1/2 animated-gradient bg-gradient-to-br from-blue-900 via-purple-800 to-red-600 p-8 sm:p-12 flex items-center justify-center relative overflow-hidden min-h-[400px]">

                    <div class="absolute inset-0 flex items-center justify-center opacity-10">
                        <img src="{{ asset('images/logo-damkar.png') }}"
                            class="w-72 h-72 object-contain select-none">
                    </div>

                    <div class="relative z-10 text-center text-white">
                        <h1 class="text-3xl sm:text-4xl font-bold mb-2 drop-shadow-lg">
                            SELAMAT DATANG DI WEBSITE
                        </h1>
                        <h2 class="text-xl sm:text-2xl font-semibold mb-8 drop-shadow-lg">
                            (DIVISI PEP)
                        </h2>
                        </p>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="w-full md:w-1/2 p-8 sm:p-12 bg-white flex justify-center items-center">
                    <div class="w-full max-w-md">

                        <!-- Logo -->
                        <div class="flex justify-center mb-8">
                            <img src="{{ asset('images/logo-damkar.png') }}"
                                class="h-20 w-20 object-contain">
                        </div>

                        <!-- Title -->
                        <h3 class="text-center text-xl font-bold text-gray-900 mb-8">
                            DINAS PEMADAMAN KEBAKARAN DAN<br>
                            PENYELAMATAN KOTA DEPOK
                        </h3>

                        <!-- Form -->
                        <form action="{{ route('login') }}" method="POST" class="space-y-6">
                            @csrf

                            <div>
                                <label class="text-sm font-semibold text-gray-900">Username</label>
                                <input type="text" name="username_admin" required
                                    class="w-full px-4 py-3 mt-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-gray-900">Password</label>
                                <input type="password" name="password_admin" required
                                    class="w-full px-4 py-3 mt-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            </div>

                            <!-- LINK DAFTAR -->
                            <div class="text-left">
                                <p class="text-sm text-gray-600">
                                    Belum punya akun?
                                    <a href="{{ route('register') }}"
                                        class="text-blue-600 hover:text-blue-700 font-semibold">
                                        Daftar
                                    </a>
                                </p>
                            </div>

                            <button type="submit"
                                class="w-full bg-black text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition shadow-lg">
                                Login
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
