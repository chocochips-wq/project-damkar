<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;

class DokumentasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $dokumentasi = Dokumentasi::when($search, function($query) use ($search) {
            return $query->where('nama_kegiatan', 'like', '%' . $search . '%')
                        ->orWhere('keterangan', 'like', '%' . $search . '%');
        })->orderBy('tanggal_kegiatan', 'desc')->paginate(12);

        return view('dokumentasi.index', compact('dokumentasi', 'search'));
    }

    public function show($id)
    {
        $dokumentasi = Dokumentasi::with('files')->findOrFail($id);
        return view('dokumentasi.show', compact('dokumentasi'));
    }
}