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
            <div class="h-72">
                <canvas id="chartDokumen"></canvas>
            </div>
        </div>

        {{-- DOKUMEN TERBARU --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Perencanaan Terbaru
                </h3>

                <div class="space-y-3">
                    @forelse($recentPerencanaan as $item)
                        <div class="p-4 border rounded-lg hover:bg-purple-50 transition">
                            <p class="font-medium text-gray-900">
                                {{ $item->nama_file }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $item->created->format('d M Y') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada data.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Monitoring Terbaru
                </h3>

                <div class="space-y-3">
                    @forelse($recentMonitoring as $item)
                        <div class="p-4 border rounded-lg hover:bg-blue-50 transition">
                            <p class="font-medium text-gray-900">
                                {{ $item->nama_file }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $item->created->format('d M Y') }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada data.</p>
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

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($statsPerencanaan->pluck('year')) !!},
                datasets: [
                    {
                        label: 'Perencanaan',
                        data: {!! json_encode($statsPerencanaan->pluck('count')) !!},
                        backgroundColor: '#7c3aed'
                    },
                    {
                        label: 'Monitoring',
                        data: {!! json_encode($statsMonitoring->pluck('count')) !!},
                        backgroundColor: '#2563eb'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection