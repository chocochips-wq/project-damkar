@extends('layouts.app')

@section('title', 'Detail Dokumentasi')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $dokumentasi->nama_kegiatan }}</h1>
            <p class="text-gray-600 mt-1">Tanggal: {{ $dokumentasi->tanggal_kegiatan->format('d F Y') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('dokumentasi') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <a href="{{ route('dokumentasi.export-pdf', $dokumentasi->id_kegiatan) }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2m0 0v-8m0 8l-6-4m6 4l6-4"/>
                </svg>
                Export PDF
            </a>
        </div>
    </div>

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
    </div>

    <!-- Keterangan -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Keterangan</h3>
        <p class="text-gray-700 leading-relaxed">
            {!! nl2br(e($dokumentasi->keterangan)) !!}
        </p>
    </div>

    <!-- Files (jika ada) -->
    @if($dokumentasi->files && $dokumentasi->files->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Foto Lainnya ({{ $dokumentasi->files->count() }} foto)</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($dokumentasi->files as $file)
            <div class="group border rounded-lg overflow-hidden relative cursor-pointer">
                {{-- Determine image source --}}
                @if(str_starts_with($file->file_url, 'http'))
                    {{-- Google Drive atau URL external --}}
                    <img src="{{ $file->file_url }}"
                         alt="Foto"
                         class="w-full h-48 object-cover"
                         onerror="this.style.display='none'">
                @else
                    {{-- File lokal --}}
                    <img src="{{ asset('storage/' . $file->file_url) }}"
                         alt="Foto"
                         class="w-full h-48 object-cover"
                         onerror="this.style.display='none'">
                @endif
                <a href="{{ route('dokumentasi.file.download', $file->id_file) }}" 
                   class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="text-center py-8">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-gray-500">Tidak ada foto tambahan</p>
        </div>
    </div>
    @endif
</div>
@endsection
