<?php

namespace App\Http\Controllers;

use App\Models\DasarHukum;
use Illuminate\Http\Request;

class DasarHukumController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $dasarHukum = DasarHukum::when($search, function($query) use ($search) {
            return $query->where('nama_hukum', 'like', '%' . $search . '%');
        })->orderBy('id_hukum', 'asc')->paginate(20);

        return view('dasar-hukum.index', compact('dasarHukum', 'search'));
    }
}