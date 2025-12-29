<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function create()
    {
        return view('dokumentasi.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_kegiatan' => 'required|string|max:255',
        'keterangan' => 'required|string',
        'tanggal_kegiatan' => 'required|date',
        'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $thumbnailPath = null;
    if ($request->hasFile('thumbnail')) {
        // Simpan ke storage/app/public/dokumentasi
        $file = $request->file('thumbnail');
        $filename = time() . '_' . $file->getClientOriginalName();
        $thumbnailPath = $file->storeAs('dokumentasi', $filename, 'public');
        // Hasil: "dokumentasi/timestamp_filename.jpg"
    }

    Dokumentasi::create([
        'id_kegiatan' => substr(uniqid(), 0, 10),
        'nama_kegiatan' => $request->nama_kegiatan,
        'keterangan' => $request->keterangan,
        'tanggal_kegiatan' => $request->tanggal_kegiatan,
        'thumbnail' => $thumbnailPath, // Simpan path relatif
        'ekstensi' => $request->file('thumbnail')->getClientOriginalExtension(),
        'created' => now(),
    ]);

    return redirect()->route('dokumentasi')->with('success', 'Dokumentasi berhasil ditambahkan!');
}

    public function show($id)
{
    $dokumentasi = Dokumentasi::with('files')
        ->where('id_kegiatan', $id)
        ->firstOrFail();

    return view('dokumentasi.show', compact('dokumentasi'));
}

    public function edit($id)
    {
        $dokumentasi = Dokumentasi::where('id_kegiatan', $id)->firstOrFail();
        return view('dokumentasi.edit', compact('dokumentasi'));
    }

    public function update(Request $request, $id)
    {
        $dokumentasi = Dokumentasi::where('id_kegiatan', $id)->firstOrFail();

        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $thumbnailPath = $dokumentasi->thumbnail;
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            $thumbnailPath = $request->file('thumbnail')->store('dokumentasi', 'public');
        }

        $dokumentasi->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'keterangan' => $request->keterangan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'thumbnail' => $thumbnailPath,
            'ekstensi' => $request->hasFile('thumbnail') ? $request->file('thumbnail')->getClientOriginalExtension() : $dokumentasi->ekstensi,
        ]);

        return redirect()->route('dokumentasi')->with('success', 'Dokumentasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::where('id_kegiatan', $id)->firstOrFail();

        // Delete thumbnail
        if ($dokumentasi->thumbnail && Storage::disk('public')->exists($dokumentasi->thumbnail)) {
            Storage::disk('public')->delete($dokumentasi->thumbnail);
        }

        // Delete related files
        foreach ($dokumentasi->files as $file) {
            if ($file->file_url && Storage::disk('public')->exists($file->file_url)) {
                Storage::disk('public')->delete($file->file_url);
            }
        }

        $dokumentasi->delete();

        return redirect()->route('dokumentasi')->with('success', 'Dokumentasi berhasil dihapus!');
    }
}
