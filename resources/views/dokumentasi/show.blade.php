@extends('layouts.app')

@section('title', 'Detail Dokumentasi')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <!-- Foto Utama -->
    <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                </svg>
                Foto Utama
            </h3>
            <div class="flex justify-center">
                <img src="{{ $dokumentasi->thumbnail }}"
                    alt="{{ $dokumentasi->nama_kegiatan }}"
                    class="max-w-full h-auto rounded-lg shadow-md"
                    onerror="this.onerror=null; this.src='{{ asset('images/logo-damkar.png') }}';"
                    loading="lazy">
            </div>

            <!-- Debug info (hapus setelah selesai testing) -->
            <div class="mt-4 p-4 bg-gray-100 rounded text-sm">
                <p><strong>Original URL:</strong> <code class="text-xs break-all">{{ $dokumentasi->getOriginal('thumbnail') }}</code></p>
                <p><strong>Processed URL:</strong> <code class="text-xs break-all">{{ $dokumentasi->thumbnail }}</code></p>
            </div>
    </div>

    <!-- Thumbnail -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thumbnail</h3>
        <img src="{{ asset('storage/' . $dokumentasi->thumbnail) }}"
             alt="{{ $dokumentasi->nama_kegiatan }}"
             class="w-full max-w-2xl rounded-lg">
    </div>

    <!-- Files (jika ada) -->
    @if($dokumentasi->files && $dokumentasi->files->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Foto Lainnya</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($dokumentasi->files as $file)
            <div class="border rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $file->file_url) }}"
                     alt="Foto"
                     class="w-full h-48 object-cover">
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
