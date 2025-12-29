@extends('layouts.app')

@section('title', 'Beranda')

@section('header-title')
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Beranda</h1>
        <p class="text-sm text-gray-600">
            Ringkasan data
        </p>
    </div>
@endsection

@section('content')
    <div class="space-y-8">

        <!-- Search Bar -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            @include('components.search', ['placeholder' => 'Cari dokumen atau folder...'])
        </div>

        {{-- STAT BOX --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

            <div class="bg-white rounded-xl shadow-sm p-6">
                <p class="text-sm text-gray-500">Perencanaan</p>
                <h3 class="text-3xl font-bold text-purple-700 mt-2">
                    {{ $totalPerencanaan }}
                </h3>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <p class="text-sm text-gray-500">Monitoring</p>
                <h3 class="text-3xl font-bold text-blue-600 mt-2">
                    {{ $totalMonitoring }}
                </h3>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <p class="text-sm text-gray-500">Mekanisme</p>
                <h3 class="text-3xl font-bold text-green-600 mt-2">
                    {{ $totalMekanisme }}
                </h3>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <p class="text-sm text-gray-500">Dokumentasi</p>
                <h3 class="text-3xl font-bold text-orange-600 mt-2">
                    {{ $totalDokumentasi }}
                </h3>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <p class="text-sm text-gray-500">Dasar Hukum</p>
                <h3 class="text-3xl font-bold text-red-600 mt-2">
                    {{ $totalDasarHukum }}
                </h3>
            </div>

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

</div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('chartDokumen');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($allYears) !!},
                datasets: [
                    {
                        label: 'Perencanaan',
                        data: {!! json_encode($normalizedPerencanaan) !!},
                        backgroundColor: '#7c3aed',
                        borderColor: '#7c3aed',
                        borderWidth: 1
                    },
                    {
                        label: 'Monitoring',
                        data: {!! json_encode($normalizedMonitoring) !!},
                        backgroundColor: '#2563eb',
                        borderColor: '#2563eb',
                        borderWidth: 1
                    },
                    {
                        label: 'Mekanisme',
                        data: {!! json_encode($normalizedMekanisme) !!},
                        backgroundColor: '#16a34a',
                        borderColor: '#16a34a',
                        borderWidth: 1
                    },
                    {
                        label: 'Dokumentasi',
                        data: {!! json_encode($normalizedDokumentasi) !!},
                        backgroundColor: '#ea580c',
                        borderColor: '#ea580c',
                        borderWidth: 1
                    },
                    {
                        label: 'Dasar Hukum',
                        data: {!! json_encode($normalizedDasarHukum) !!},
                        backgroundColor: '#dc2626',
                        borderColor: '#dc2626',
                        borderWidth: 1
                    }
                ]
            },
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
