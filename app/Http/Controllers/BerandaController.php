<?php

namespace App\Http\Controllers;

use App\Models\Perencanaan;
use App\Models\MonitoringPelaporan;
use App\Models\Mekanisme;
use App\Models\Dokumentasi;
use App\Models\DasarHukum;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $recentPerencanaan = Perencanaan::when($search, function($query) use ($search) {
            return $query->where('nama_file', 'like', '%' . $search . '%');
        })->orderBy('created', 'desc')->limit(10)->get();

        $recentMonitoring = MonitoringPelaporan::when($search, function($query) use ($search) {
            return $query->where('nama_file', 'like', '%' . $search . '%');
        })->orderBy('created', 'desc')->limit(10)->get();

        $statsPerencanaan = Perencanaan::selectRaw('YEAR(created) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->limit(5)
            ->get();

        $statsMonitoring = MonitoringPelaporan::selectRaw('YEAR(created) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->limit(5)
            ->get();

        $totalPerencanaan = Perencanaan::count();
        $totalMonitoring = MonitoringPelaporan::count();
        $totalMekanisme = Mekanisme::count();
        $totalDokumentasi = Dokumentasi::count();
        $totalDasarHukum = DasarHukum::count();

        return view('beranda', compact(
            'recentPerencanaan',
            'recentMonitoring',
            'statsPerencanaan',
            'statsMonitoring',
            'totalPerencanaan',
            'totalMonitoring',
            'totalMekanisme',
            'totalDokumentasi',
            'totalDasarHukum',
            'search'
        ));
    }
}