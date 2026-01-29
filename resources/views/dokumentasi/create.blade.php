@extends('layouts.app')

@section('title', 'Tambah Dokumentasi')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Dokumentasi</h1>
        <p class="text-sm text-gray-600">Tambahkan dokumentasi kegiatan baru</p>
    </div>
@endsection

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-red-800 font-medium mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div class="text-white">
                    <h2 class="text-xl font-bold">Tambah Dokumentasi Baru</h2>
                    <p class="text-red-100">Upload foto dan informasi kegiatan</p>
                </div>
            </div>
        </div>

        <form action="{{ route('dokumentasi.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Nama Kegiatan -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Nama Kegiatan
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm0 2h12v8H4V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="nama_kegiatan"
                        value="{{ old('nama_kegiatan') }}"
                        required
                        maxlength="255"
                        class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                        placeholder="Masukkan nama kegiatan"
                    >
                </div>
            </div>

            <!-- Tanggal Kegiatan -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Tanggal Kegiatan
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input
                        type="date"
                        name="tanggal_kegiatan"
                        value="{{ old('tanggal_kegiatan') }}"
                        required
                        class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    >
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Keterangan
                    <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="keterangan"
                    rows="4"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition"
                    placeholder="Masukkan keterangan kegiatan"
                >{{ old('keterangan') }}</textarea>
            </div>

            <!-- Thumbnail -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Foto Utama (Thumbnail)
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input
                        type="file"
                        name="thumbnail"
                        accept="image/*"
                        required
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                    >
                </div>
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 40MB</p>
            </div>

            <!-- Foto Lainnya (Multiple) -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Foto Lainnya
                    <span class="text-gray-400 font-normal">(Opsional)</span>
                </label>
                <div class="relative">
                    <input
                        type="file"
                        name="photos[]"
                        accept="image/*"
                        multiple
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                    >
                </div>
                <p class="text-xs text-gray-500 mt-1">Anda dapat memilih beberapa foto sekaligus. Format: JPG, PNG, GIF. Masing-masing maksimal 40MB</p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button
                    type="submit"
                    class="flex-1 bg-gradient-to-r from-red-600 to-red-700 text-white py-3 rounded-lg font-semibold hover:from-red-700 hover:to-red-800 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Simpan Dokumentasi
                </button>
                <a
                    href="{{ route('dokumentasi') }}"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
