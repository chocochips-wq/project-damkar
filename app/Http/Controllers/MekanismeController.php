<?php

namespace App\Http\Controllers;

use App\Models\FolderMekanisme;
use App\Models\Mekanisme;
use Illuminate\Http\Request;

class MekanismeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $folderId = $request->get('folder');

        $folders = FolderMekanisme::whereNull('id_parent')->get();
        $currentFolder = null;
        $breadcrumbs = [];

        if ($folderId) {
            $currentFolder = FolderMekanisme::find($folderId);
            if ($currentFolder) {
                $breadcrumbs = $this->getBreadcrumbs($currentFolder);
                $folders = $currentFolder->children;
            }
        }

        $files = Mekanisme::when($folderId, function($query) use ($folderId) {
            return $query->where('id_folder_mek', $folderId);
        })->when($search, function($query) use ($search) {
            return $query->where('nama_file', 'like', '%' . $search . '%');
        })->orderBy('created', 'desc')->paginate(20);

        return view('mekanisme.index', compact('folders', 'files', 'currentFolder', 'breadcrumbs', 'search'));
    }

    public function renameFolder(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $folder = FolderMekanisme::findOrFail($id);
        $folder->nama_folder_mek = $request->name;
        $folder->save();

        return response()->json([
            'success' => true,
            'message' => 'Folder berhasil diubah'
        ]);
    }

    public function deleteFolder($id)
    {
        $folder = FolderMekanisme::findOrFail($id);
        
        if ($folder->children()->count() > 0 || $folder->files()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Folder tidak dapat dihapus karena masih memiliki isi'
            ], 400);
        }

        $folder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Folder berhasil dihapus'
        ]);
    }

    public function renameFile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $file = Mekanisme::findOrFail($id);
        $file->nama_file = $request->name;
        $file->save();

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diubah'
        ]);
    }

    public function deleteFile($id)
    {
        $file = Mekanisme::findOrFail($id);
        $file->delete();

        return response()->json([
            'success' => true,
            'message' => 'File berhasil dihapus'
        ]);
    }

    private function getBreadcrumbs($folder)
    {
        $breadcrumbs = [];
        $current = $folder;
        
        while ($current) {
            array_unshift($breadcrumbs, $current);
            $current = $current->parent;
        }
        
        return $breadcrumbs;
    }
}