@extends('layouts.app')

@section('title', 'Dokumentasi Kegiatan')

@section('header-title')
    <div class="min-w-0">
        <h1 class="text-lg md:text-2xl font-bold text-gray-900 truncate">Dokumentasi Kegiatan</h1>
        <p class="text-xs md:text-sm text-gray-600 truncate md:whitespace-normal md:line-clamp-none">Kumpulan foto kegiatan</p>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        @include('components.search', ['placeholder' => 'Cari kegiatan...'])
    </div>

    <!-- Gallery Grid -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2 min-w-0">
                <div class="flex items-center gap-2 min-w-0">
                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H4z"/>
                    </svg>
                    <span class="truncate">Galeri Foto</span>
                    @if($dokumentasi->total() > 0)
                        <span class="text-sm text-gray-500 whitespace-nowrap">({{ $dokumentasi->total() }})</span>
                    @endif
                </div>
            </h3>
            <a href="{{ route('dokumentasi.create') }}"
               class="bg-red-600 text-white px-3 py-2 sm:px-4 rounded-lg text-sm font-semibold hover:bg-red-700 transition flex items-center justify-center gap-2 flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span>Tambah Dokumentasi</span>
            </a>
        </div>

        @if($dokumentasi->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5">
                @foreach($dokumentasi as $item)
                    <div class="group bg-white border border-gray-200 rounded-xl overflow-hidden shadow hover:shadow-xl transition-all duration-300">

                        <!-- Thumbnail -->
                            <div class="relative h-64 overflow-hidden">
                                <a href="{{ route('dokumentasi.show', $item->id_kegiatan) }}"
                                class="block w-full h-full">
                                    <img
                                        src="{{ $item->thumbnail }}"
                                        alt="{{ $item->nama_kegiatan }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        onerror="this.onerror=null; this.src='{{ asset('images/logo-damkar.png') }}';"
                                        loading="lazy"
                                    />

                        <!-- Overlay -->
                                    <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">
                                            Lihat Detail
                                        </span>
                                    </div>
                                </a>
                            </div>
                        <!-- Content -->
                        <div class="p-4 space-y-2">
                            <h4 class="font-semibold text-gray-900 line-clamp-2">
                                {{ $item->nama_kegiatan }}
                            </h4>

                            <p class="text-sm text-gray-500 line-clamp-2">
                                {{ $item->keterangan }}
                            </p>

                            <div class="flex flex-wrap items-center gap-3 mt-1 text-xs md:text-sm text-gray-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d M Y') }}
                                </span>

                                <div class="flex gap-2">
                                    <a href="{{ route('dokumentasi.edit', $item->id_kegiatan) }}"
                                       class="text-blue-600 hover:text-blue-700 font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('dokumentasi.destroy', $item->id_kegiatan) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 7h18M3 12h18M3 17h18"/>
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 mb-2">
                    Belum ada dokumentasi
                </h4>
                <p class="text-gray-500">
                    Dokumentasi kegiatan belum tersedia.
                </p>
            </div>
        @endif

        <!-- Pagination -->
        @if($dokumentasi->hasPages())
            <div class="mt-6 border-t pt-4">
                {{ $dokumentasi->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
