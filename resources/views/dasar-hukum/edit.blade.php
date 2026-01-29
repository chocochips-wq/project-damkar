@extends('layouts.app')

@section('title', 'Edit Peraturan - Dasar Hukum')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Peraturan</h1>
        <p class="text-sm text-gray-600">Perbarui informasi peraturan atau undang-undang</p>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Edit Peraturan</h2>
                        <p class="text-sm text-gray-600">ID: {{ $hukum->id_hukum }}</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form id="hukumForm" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama Hukum -->
                <div>
                    <label for="nama_hukum" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Peraturan/Undang-Undang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_hukum" name="nama_hukum" 
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        value="{{ $hukum->nama_hukum }}"
                        placeholder="Contoh: Undang-Undang No. 30 Tahun 1997 tentang Pemeriksaan Lingkungan Hidup"
                        required>
                    <p class="text-sm text-gray-500 mt-1">Masukkan nama lengkap peraturan atau undang-undang</p>
                    <div id="nama_hukum_error" class="text-red-600 text-sm mt-2 hidden"></div>
                </div>



                <!-- Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button type="button" onclick="window.location.href='{{ route('dasar-hukum') }}'" class="px-6 py-2.5 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </button>
                    <button type="button" id="deleteBtn" class="px-6 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors flex items-center gap-2 ml-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full transform transition-all">
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-5 rounded-t-2xl flex items-center gap-3">
                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-bold">Hapus Peraturan</h3>
            </div>
            <div class="px-6 py-6">
                <p class="text-gray-700 text-center leading-relaxed">Apakah Anda yakin ingin menghapus <strong>{{ $hukum->nama_hukum }}</strong>?<br><span class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</span></p>
            </div>
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex gap-3 justify-end">
                <button id="cancelDeleteBtn" type="button" class="px-5 py-2.5 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium transition-colors">
                    Batal
                </button>
                <button id="confirmDeleteBtn" type="button" class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus
                </button>
            </div>
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

        // Show delete modal
        document.getElementById('deleteBtn').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.remove('hidden');
        });

        // Cancel delete
        document.getElementById('cancelDeleteBtn').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
        });

        // Confirm delete
        document.getElementById('confirmDeleteBtn').addEventListener('click', async function() {
            try {
                const response = await fetch('{{ route("dasar-hukum.destroy", $hukum->id_hukum) }}', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const data = await response.json();
                document.getElementById('deleteModal').classList.add('hidden');

                if (data.success) {
                    showSuccessNotif(data.message);
                } else {
                    showErrorNotif(data.message);
                }
            } catch (error) {
                document.getElementById('deleteModal').classList.add('hidden');
                showErrorNotif('Terjadi kesalahan saat menghapus data');
            }
        });

        // Submit form
        document.getElementById('hukumForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch('{{ route("dasar-hukum.update", $hukum->id_hukum) }}', {
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
