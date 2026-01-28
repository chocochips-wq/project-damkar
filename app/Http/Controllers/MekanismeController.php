<?php

namespace App\Http\Controllers;

use App\Models\FolderMekanisme;
use App\Models\Mekanisme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function createFolder(Request $request)
    {
        $request->validate([
            'nama_folder' => 'required|string|max:255',
            'id_parent' => 'nullable|string'
        ]);

        $lastFolder = FolderMekanisme::orderBy('id_folder_mek', 'desc')->first();
        $lastNumber = $lastFolder ? intval(substr($lastFolder->id_folder_mek, 5)) : 0;
        $newId = 'FLMEK' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        FolderMekanisme::create([
            'id_folder_mek' => $newId,
            'id_parent' => $request->id_parent,
            'nama_folder_mek' => $request->nama_folder,
            'created' => now(),
            'pemilik' => Auth::guard('admin')->user()->nama_admin
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Folder berhasil dibuat'
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200', // Max 50MB
            'id_folder' => 'nullable|string'
        ]);

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $extension;

            // Store file
            $path = $file->storeAs('mekanisme', $filename, 'public');

            // Generate file ID
            $lastFile = Mekanisme::orderBy('id_mekanisme', 'desc')->first();
            $lastNumber = $lastFile ? intval(substr($lastFile->id_mekanisme, 5)) : 0;
            $newId = 'FILMK' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

            // Save to database
            Mekanisme::create([
                'id_mekanisme' => $newId,
                'id_folder_mek' => $request->id_folder,
                'nama_file' => $originalName,
                'link' => '/storage/' . $path,
                'created' => now(),
                'pemilik' => Auth::guard('admin')->user()->nama_admin
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File berhasil diupload'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadFolder(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:51200',
            'paths.*' => 'required|string',
            'id_parent' => 'nullable|string'
        ]);

        try {
            $files = $request->file('files');
            $paths = $request->input('paths');
            $parentId = $request->input('id_parent');

            $folderMap = [];
            $uploadedCount = 0;

            foreach ($files as $index => $file) {
                $relativePath = $paths[$index];
                $pathParts = explode('/', $relativePath);

                // Handle folder structure
                $currentParentId = $parentId;

                // Create folders if needed (except last part which is filename)
                for ($i = 0; $i < count($pathParts) - 1; $i++) {
                    $folderName = $pathParts[$i];
                    $folderKey = $currentParentId . '/' . $folderName;

                    if (!isset($folderMap[$folderKey])) {
                        // Create new folder
                        $lastFolder = FolderMekanisme::orderBy('id_folder_mek', 'desc')->first();
                        $lastNumber = $lastFolder ? intval(substr($lastFolder->id_folder_mek, 5)) : 0;
                        $newFolderId = 'FLMEK' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

                        FolderMekanisme::create([
                            'id_folder_mek' => $newFolderId,
                            'id_parent' => $currentParentId,
                            'nama_folder_mek' => $folderName,
                            'created' => now(),
                            'pemilik' => Auth::guard('admin')->user()->nama_admin
                        ]);

                        $folderMap[$folderKey] = $newFolderId;
                    }

                    $currentParentId = $folderMap[$folderKey];
                }

                // Upload file
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $storagePath = $file->storeAs('mekanisme', $filename, 'public');

                $lastFile = Mekanisme::orderBy('id_mekanisme', 'desc')->first();
                $lastNumber = $lastFile ? intval(substr($lastFile->id_mekanisme, 5)) : 0;
                $newId = 'FILMK' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

                Mekanisme::create([
                    'id_mekanisme' => $newId,
                    'id_folder_mek' => $currentParentId,
                    'nama_file' => $originalName,
                    'link' => '/storage/' . $storagePath,
                    'created' => now(),
                    'pemilik' => Auth::guard('admin')->user()->nama_admin
                ]);

                $uploadedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil upload {$uploadedCount} file"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload folder: ' . $e->getMessage()
            ], 500);
        }
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

        // Delete physical file
        $filePath = str_replace('/storage/', '', $file->link);
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

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
