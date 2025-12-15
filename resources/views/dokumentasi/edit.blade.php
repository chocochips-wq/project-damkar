@extends('layouts.app')

@section('title', 'Edit Dokumentasi')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Dokumentasi</h1>
        <p class="text-sm text-gray-600">Edit informasi dokumentasi kegiatan</p>
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
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div class="text-white">
                    <h2 class="text-xl font-bold">Edit Dokumentasi</h2>
                    <p class="text-blue-100">Update informasi kegiatan</p>
                </div>
            </div>
        </div>

        <form action="{{ route('dokumentasi.update', $dokumentasi->id_kegiatan) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

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
                        value="{{ old('nama_kegiatan', $dokumentasi->nama_kegiatan) }}"
                        required
                        maxlength="255"
                        class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
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
                        value="{{ old('tanggal_kegiatan', $dokumentasi->tanggal_kegiatan->format('Y-m-d')) }}"
                        required
                        class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
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
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                    placeholder="Masukkan keterangan kegiatan"
                >{{ old('keterangan', $dokumentasi->keterangan) }}</textarea>
            </div>

            <!-- Current Thumbnail -->
            @if($dokumentasi->thumbnail)
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Thumbnail Saat Ini
                    </label>
                    <div class="w-32 h-32 border-2 border-gray-300 rounded-lg overflow-hidden">
                        <img src="{{ $dokumentasi->thumbnail }}" alt="Current thumbnail" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            <!-- Thumbnail -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Ganti Foto Thumbnail
                </label>
                <div class="relative">
                    <input
                        type="file"
                        name="thumbnail"
                        accept="image/*"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    >
                </div>
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti. Format: JPG, PNG, GIF. Maksimal 2MB</p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button
                    type="submit"
                    class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Dokumentasi
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
