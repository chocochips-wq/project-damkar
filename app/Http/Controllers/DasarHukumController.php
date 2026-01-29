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

    public function create()
    {
        return view('dasar-hukum.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_hukum' => 'required|string|max:255|unique:tbl_dasar_hukum,nama_hukum'
        ], [
            'nama_hukum.required' => 'Nama hukum harus diisi',
            'nama_hukum.unique' => 'Nama hukum sudah terdaftar',
            'nama_hukum.max' => 'Nama hukum maksimal 255 karakter'
        ]);

        try {
            $hukum = new DasarHukum();
            $hukum->id_hukum = $this->generateId();
            $hukum->nama_hukum = $request->nama_hukum;
            $hukum->pemilik = auth()->user()->nama_user ?? 'System';
            $hukum->created = now();
            $hukum->save();

            return response()->json([
                'success' => true,
                'message' => 'Peraturan berhasil ditambahkan'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating dasar hukum', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan peraturan'
            ], 500);
        }
    }

    public function edit($id)
    {
        $hukum = DasarHukum::findOrFail($id);
        return view('dasar-hukum.edit', compact('hukum'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_hukum' => 'required|string|max:255|unique:tbl_dasar_hukum,nama_hukum,' . $id . ',id_hukum'
        ], [
            'nama_hukum.required' => 'Nama hukum harus diisi',
            'nama_hukum.unique' => 'Nama hukum sudah terdaftar',
            'nama_hukum.max' => 'Nama hukum maksimal 255 karakter'
        ]);

        try {
            $hukum = DasarHukum::findOrFail($id);
            $hukum->nama_hukum = $request->nama_hukum;
            $hukum->save();

            return response()->json([
                'success' => true,
                'message' => 'Peraturan berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating dasar hukum', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui peraturan'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $hukum = DasarHukum::findOrFail($id);
            $hukum->delete();

            return response()->json([
                'success' => true,
                'message' => 'Peraturan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting dasar hukum', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus peraturan'
            ], 500);
        }
    }

    private function generateId()
    {
        $prefix = 'HK';
        $latestId = DasarHukum::latest('id_hukum')->first();
        
        if (!$latestId) {
            return $prefix . '00001';
        }

        $number = (int) substr($latestId->id_hukum, strlen($prefix));
        return $prefix . str_pad($number + 1, 5, '0', STR_PAD_LEFT);
    }
}