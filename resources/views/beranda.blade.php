@extends('layouts.app')

@section('title', 'Beranda')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Beranda</h1>
        <p class="text-sm text-gray-600">Ringkasan data dan statistik sistem</p>
    </div>
@endsection

@section('content')
    <div class="space-y-8">

        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            @include('components.advanced-search', ['placeholder' => 'Cari dokumen atau folder...'])
        </div>

        {{-- STAT BOX --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

            <a href="{{ route('perencanaan') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md hover:border-purple-300 border-2 border-transparent transition cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Perencanaan</p>
                        <h3 class="text-3xl font-bold text-purple-700 mt-2">
                            {{ $totalPerencanaan }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Dokumen perencanaan</p>
            </a>

            <a href="{{ route('monitoring') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md hover:border-blue-300 border-2 border-transparent transition cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Monitoring</p>
                        <h3 class="text-3xl font-bold text-blue-600 mt-2">
                            {{ $totalMonitoring }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Laporan monitoring & pelaporan</p>
            </a>

            <a href="{{ route('mekanisme') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md hover:border-green-300 border-2 border-transparent transition cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Mekanisme</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2">
                            {{ $totalMekanisme }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Dokumen mekanisme & prosedur</p>
            </a>

            <a href="{{ route('dokumentasi') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md hover:border-orange-300 border-2 border-transparent transition cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Dokumentasi</p>
                        <h3 class="text-3xl font-bold text-orange-600 mt-2">
                            {{ $totalDokumentasi }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Dokumentasi kegiatan & foto</p>
            </a>

            <a href="{{ route('dasar-hukum') }}" class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md hover:border-red-300 border-2 border-transparent transition cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Dasar Hukum</p>
                        <h3 class="text-3xl font-bold text-red-600 mt-2">
                            {{ $totalDasarHukum }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17.25S6.5 28 12 28s10-4.745 10-10.75S17.5 6.253 12 6.253z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Peraturan & undang-undang</p>
            </a>

        </div>

        {{-- GRAFIK --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                Grafik Dokumen per Tahun
            </h3>
            <div class="h-96">
                <canvas id="chartDokumen"></canvas>
            </div>
        </div>

    {{-- DOKUMEN TERBARU --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4z"/>
            </svg>
            Perencanaan Terbaru
        </h3>

        <div class="space-y-3">
            @forelse($recentPerencanaan as $item)
                @if($item->file_url)
                    <a href="{{ $item->file_url }}"
                       target="_blank"
                       class="block p-4 border rounded-lg hover:bg-purple-50 hover:border-purple-300 transition group">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 group-hover:text-purple-700 transition line-clamp-2">
                                    {{ $item->nama_file }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">
                                        {{ $item->created->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition flex-shrink-0"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </div>
                    </a>
                @else
                    <div class="block p-4 border rounded-lg bg-gray-50 opacity-60">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 line-clamp-2">
                                    {{ $item->nama_file }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">
                                        {{ $item->created->format('d M Y') }}
                                    </p>
                                </div>
                                <p class="text-xs text-red-500 mt-1">
                                    <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Link tidak tersedia
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm text-gray-500">Tidak ada data.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
            </svg>
            Monitoring Terbaru
        </h3>

        <div class="space-y-3">
            @forelse($recentMonitoring as $item)
                @if($item->file_url)
                    <a href="{{ $item->file_url }}"
                       target="_blank"
                       class="block p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-300 transition group">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 group-hover:text-blue-700 transition line-clamp-2">
                                    {{ $item->nama_file }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">
                                        {{ $item->created->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition flex-shrink-0"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </div>
                    </a>
                @else
                    <div class="block p-4 border rounded-lg bg-gray-50 opacity-60">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 line-clamp-2">
                                    {{ $item->nama_file }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z"/>
                                    </svg>
                                    <p class="text-sm text-gray-500">
                                        {{ $item->created->format('d M Y') }}
                                    </p>
                                </div>
                                <p class="text-xs text-red-500 mt-1">
                                    <svg class="w-3 h-3 inline" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Link tidak tersedia
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm text-gray-500">Tidak ada data.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

<!-- Recent Activities -->
<div class="bg-white rounded-xl shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Aktivitas Terbaru
    </h3>

    <div class="space-y-3 max-h-96 overflow-y-auto">
        @forelse($recentActivities as $activity)
            <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition border-b last:border-b-0">
                <!-- Action Badge -->
                <div class="flex-shrink-0">
                    @if($activity->action === 'create')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Dibuat
                        </span>
                    @elseif($activity->action === 'update')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                            Diperbarui
                        </span>
                    @elseif($activity->action === 'delete')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Dihapus
                        </span>
                    @elseif($activity->action === 'upload')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                            Upload
                        </span>
                    @elseif($activity->action === 'download')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Download
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ ucfirst($activity->action) }}
                        </span>
                    @endif
                </div>

                <!-- Activity Details -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">
                        {{ $activity->description ?? ucfirst($activity->action) . ' ' . $activity->module }}
                    </p>
                    <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                        <span class="px-2 py-0.5 bg-gray-100 rounded">{{ ucfirst($activity->module) }}</span>
                        <span>{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-gray-500">Tidak ada aktivitas terbaru.</p>
            </div>
        @endforelse
    </div>
</div>

</div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chartDokumen');

        // Chart data is placed in a JSON script tag to avoid Blade tokens inside JS source
        // and to keep editors/language servers from mis-parsing Blade directives.
        </script>
    <script id="chart-data" type="application/json">
        {!! json_encode([
            'labels' => $allYears,
            'datasets' => [
                [
                    'label' => 'Perencanaan',
                    'data' => $normalizedPerencanaan,
                    'backgroundColor' => '#7c3aed',
                    'borderColor' => '#7c3aed',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Monitoring',
                    'data' => $normalizedMonitoring,
                    'backgroundColor' => '#2563eb',
                    'borderColor' => '#2563eb',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Mekanisme',
                    'data' => $normalizedMekanisme,
                    'backgroundColor' => '#16a34a',
                    'borderColor' => '#16a34a',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Dokumentasi',
                    'data' => $normalizedDokumentasi,
                    'backgroundColor' => '#ea580c',
                    'borderColor' => '#ea580c',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Dasar Hukum',
                    'data' => $normalizedDasarHukum,
                    'backgroundColor' => '#dc2626',
                    'borderColor' => '#dc2626',
                    'borderWidth' => 1,
                ],
            ],
        ]) !!}
    </script>
    <script>
        const cfgEl = document.getElementById('chart-data');
        const chartData = cfgEl ? JSON.parse(cfgEl.textContent) : { labels: [], datasets: [] };

        new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Dokumen'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Tahun'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyColor: '#fff',
                        bodyFont: {
                            size: 13
                        },
                        borderColor: '#ddd',
                        borderWidth: 1,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y + ' dokumen';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
