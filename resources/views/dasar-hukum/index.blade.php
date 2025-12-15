@extends('layouts.app')

@section('title', 'Dasar Hukum')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dasar Hukum</h1>
        <p class="text-sm text-gray-600">Regulasi dan peraturan yang mendasari kegiatan pemadaman kebakaran</p>
    </div>
@endsection

@section('content')
    <div class="space-y-6">

        <!-- Search Bar -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            @include('components.search', ['placeholder' => 'Cari peraturan atau undang-undang...'])
        </div>

        <!-- Stats Card -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Dokumen</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $dasarHukum->total() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Undang-Undang</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $dasarHukum->filter(function($item) { return str_contains($item->nama_hukum, 'Undang-Undang'); })->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Peraturan Pemerintah</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $dasarHukum->filter(function($item) { return str_contains($item->nama_hukum, 'Peraturan Pemerintah'); })->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Peraturan Daerah</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $dasarHukum->filter(function($item) { return str_contains($item->nama_hukum, 'Peraturan Daerah'); })->count() }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                            <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Daftar Peraturan</h3>
                            <p class="text-sm text-gray-600">Regulasi lengkap terkait pemadaman kebakaran dan penyelamatan</p>
                        </div>
                    </div>
                    @if($dasarHukum->total() > 0)
                        <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold">
                            {{ $dasarHukum->total() }} Dokumen
                        </span>
                    @endif
                </div>
            </div>

            <!-- List -->
            <div class="divide-y divide-gray-200">
                @forelse($dasarHukum as $index => $hukum)
                    <div class="p-6 hover:bg-gray-50 transition group">
                        <div class="flex items-start gap-4">
                            <!-- Number Badge -->
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md group-hover:shadow-lg transition">
                                <span class="text-white font-bold text-lg">{{ $dasarHukum->firstItem() + $index }}</span>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-3">
                                    <h4 class="text-base font-semibold text-gray-900 leading-relaxed group-hover:text-blue-600 transition">
                                        {{ $hukum->nama_hukum }}
                                    </h4>

                                    <!-- Badge Type -->
                                    @if(str_contains($hukum->nama_hukum, 'Undang-Undang'))
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold whitespace-nowrap">
                                            UU
                                        </span>
                                    @elseif(str_contains($hukum->nama_hukum, 'Peraturan Pemerintah'))
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold whitespace-nowrap">
                                            PP
                                        </span>
                                    @elseif(str_contains($hukum->nama_hukum, 'Peraturan Presiden'))
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold whitespace-nowrap">
                                            Perpres
                                        </span>
                                    @elseif(str_contains($hukum->nama_hukum, 'Peraturan Menteri'))
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold whitespace-nowrap">
                                            Permen
                                        </span>
                                    @elseif(str_contains($hukum->nama_hukum, 'Peraturan Daerah'))
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold whitespace-nowrap">
                                            Perda
                                        </span>
                                    @elseif(str_contains($hukum->nama_hukum, 'Peraturan Walikota'))
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold whitespace-nowrap">
                                            Perwali
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold whitespace-nowrap">
                                            Lainnya
                                        </span>
                                    @endif
                                </div>

                                <!-- Meta Info -->
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $hukum->pemilik }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $hukum->created->format('d M Y') }}
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $hukum->created->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada data</h4>
                        <p class="text-gray-500">
                            @if(request('search'))
                                Tidak ada hasil untuk "{{ request('search') }}"
                            @else
                                Belum ada dasar hukum yang ditambahkan
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($dasarHukum->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $dasarHukum->appends(['search' => request('search')])->links() }}
                </div>
            @endif
        </div>

        <!-- Info Card -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 mb-2">Informasi Dasar Hukum</h4>
                    <p class="text-sm text-blue-800 leading-relaxed">
                        Dasar hukum di atas merupakan landasan pelaksanaan tugas dan fungsi
                        <strong>Dinas Pemadaman Kebakaran dan Penyelamatan Kota Depok</strong>.
                        Seluruh kegiatan operasional berpedoman pada regulasi yang tercantum di atas
                        untuk memastikan pelayanan yang profesional dan sesuai dengan ketentuan yang berlaku.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
