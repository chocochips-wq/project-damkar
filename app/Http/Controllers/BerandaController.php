<?php

namespace App\Http\Controllers;

use App\Models\Perencanaan;
use App\Models\MonitoringPelaporan;
use App\Models\Mekanisme;
use App\Models\Dokumentasi;
use App\Models\DasarHukum;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Recent data untuk display list
        $recentPerencanaan = Perencanaan::when($search, function($query) use ($search) {
            return $query->where('nama_file', 'like', '%' . $search . '%');
        })->orderBy('created', 'desc')->limit(10)->get();

        $recentMonitoring = MonitoringPelaporan::when($search, function($query) use ($search) {
            return $query->where('nama_file', 'like', '%' . $search . '%');
        })->orderBy('created', 'desc')->limit(10)->get();

        // Stats per tahun untuk semua modul
        $statsPerencanaan = Perencanaan::selectRaw('YEAR(created) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $statsMonitoring = MonitoringPelaporan::selectRaw('YEAR(created) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $statsMekanisme = Mekanisme::selectRaw('YEAR(created) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $statsDokumentasi = Dokumentasi::selectRaw('YEAR(created) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $statsDasarHukum = DasarHukum::selectRaw('YEAR(created) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // Kumpulkan semua tahun unik
        $allYears = collect()
            ->merge($statsPerencanaan->pluck('year'))
            ->merge($statsMonitoring->pluck('year'))
            ->merge($statsMekanisme->pluck('year'))
            ->merge($statsDokumentasi->pluck('year'))
            ->merge($statsDasarHukum->pluck('year'))
            ->unique()
            ->sort()
            ->values();

        // Normalisasi data
        $normalizedPerencanaan = $this->normalizeData($statsPerencanaan, $allYears);
        $normalizedMonitoring = $this->normalizeData($statsMonitoring, $allYears);
        $normalizedMekanisme = $this->normalizeData($statsMekanisme, $allYears);
        $normalizedDokumentasi = $this->normalizeData($statsDokumentasi, $allYears);
        $normalizedDasarHukum = $this->normalizeData($statsDasarHukum, $allYears);

        // Total count
        $totalPerencanaan = Perencanaan::count();
        $totalMonitoring = MonitoringPelaporan::count();
        $totalMekanisme = Mekanisme::count();
        $totalDokumentasi = Dokumentasi::count();
        $totalDasarHukum = DasarHukum::count();

        // Get recent activities
        $recentActivities = ActivityLog::getRecent(15);

        return view('beranda', compact(
            'recentPerencanaan',
            'recentMonitoring',
            'statsPerencanaan',
            'statsMonitoring',
            'allYears',
            'normalizedPerencanaan',
            'normalizedMonitoring',
            'normalizedMekanisme',
            'normalizedDokumentasi',
            'normalizedDasarHukum',
            'totalPerencanaan',
            'totalMonitoring',
            'totalMekanisme',
            'totalDokumentasi',
            'totalDasarHukum',
            'recentActivities',
            'search'
        ));
    }

    /**
     * Normalisasi data agar setiap tahun memiliki nilai
     */
    private function normalizeData($stats, $allYears)
    {
        $normalized = [];
        foreach ($allYears as $year) {
            $found = $stats->firstWhere('year', $year);
            $normalized[] = $found ? $found->count : 0;
        }
        return $normalized;
    }
}
