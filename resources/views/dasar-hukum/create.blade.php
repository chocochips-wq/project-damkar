@extends('layouts.app')

@section('title', 'Tambah Peraturan - Dasar Hukum')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Peraturan Baru</h1>
        <p class="text-sm text-gray-600">Tambahkan peraturan atau undang-undang baru ke database</p>
    </div>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Form Peraturan Baru</h2>
                        <p class="text-sm text-gray-600">Isi data peraturan dengan lengkap dan benar</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form id="hukumForm" class="p-6 space-y-6">
                @csrf

                <!-- Nama Hukum -->
                <div>
                    <label for="nama_hukum" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Peraturan/Undang-Undang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_hukum" name="nama_hukum" 
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="Contoh: Undang-Undang No. 30 Tahun 1997 tentang Pemeriksaan Lingkungan Hidup"
                        required>
                    <p class="text-sm text-gray-500 mt-1">Masukkan nama lengkap peraturan atau undang-undang</p>
                    <div id="nama_hukum_error" class="text-red-600 text-sm mt-2 hidden"></div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('dasar-hukum') }}" class="px-6 py-2.5 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors flex items-center gap-2 ml-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Simpan Peraturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Success Notification -->
    <div id="successNotif" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 transform transition-transform duration-300 translate-x-full z-40">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span id="successNotifText">Berhasil disimpan</span>
    </div>

    <!-- Error Notification -->
    <div id="errorNotif" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 transform transition-transform duration-300 translate-x-full z-40">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
        </svg>
        <span id="errorNotifText">Error</span>
    </div>

    <script>
        function showSuccessNotif(message) {
            const notif = document.getElementById('successNotif');
            const notifText = document.getElementById('successNotifText');
            notifText.textContent = message;
            notif.classList.remove('translate-x-full');
            setTimeout(() => {
                notif.classList.add('translate-x-full');
                setTimeout(() => window.location.href = '{{ route("dasar-hukum") }}', 500);
            }, 1500);
        }

        function showErrorNotif(message) {
            const notif = document.getElementById('errorNotif');
            const notifText = document.getElementById('errorNotifText');
            notifText.textContent = message;
            notif.classList.remove('translate-x-full');
            setTimeout(() => {
                notif.classList.add('translate-x-full');
            }, 3000);
        }

        document.getElementById('hukumForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch('{{ route("dasar-hukum.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    showSuccessNotif(data.message);
                } else {
                    showErrorNotif(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorNotif('Terjadi kesalahan saat menyimpan data');
            }
        });
    </script>
@endsection
