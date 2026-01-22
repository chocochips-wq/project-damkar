<?php

namespace App\Http\Controllers;

use App\Models\FolderMonitoring;
use App\Models\MonitoringPelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $folderId = $request->get('folder');

        $folders = FolderMonitoring::whereNull('id_parent')->get();
        $currentFolder = null;
        $breadcrumbs = [];

        if ($folderId) {
            $currentFolder = FolderMonitoring::find($folderId);
            if ($currentFolder) {
                $breadcrumbs = $this->getBreadcrumbs($currentFolder);
                $folders = $currentFolder->children;
            }
        }

        $files = MonitoringPelaporan::when($folderId, function($query) use ($folderId) {
            return $query->where('id_folder_mon', $folderId);
        })->when($search, function($query) use ($search) {
            return $query->where('nama_file', 'like', '%' . $search . '%');
        })->orderBy('created', 'desc')->paginate(20);

        return view('monitoring.index', compact('folders', 'files', 'currentFolder', 'breadcrumbs', 'search'));
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'nama_folder' => 'required|string|max:255',
            'id_parent' => 'nullable|string'
        ]);

        $lastFolder = FolderMonitoring::orderBy('id_folder_mon', 'desc')->first();
        $lastNumber = $lastFolder ? intval(substr($lastFolder->id_folder_mon, 5)) : 0;
        $newId = 'FLMON' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        FolderMonitoring::create([
            'id_folder_mon' => $newId,
            'id_parent' => $request->id_parent,
            'nama_folder_mon' => $request->nama_folder,
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
            $path = $file->storeAs('monitoring', $filename, 'public');
            
            // Generate file ID
            $lastFile = MonitoringPelaporan::orderBy('id_monitoring', 'desc')->first();
            $lastNumber = $lastFile ? intval(substr($lastFile->id_monitoring, 5)) : 0;
            $newId = 'FILMN' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

            // Save to database
            MonitoringPelaporan::create([
                'id_monitoring' => $newId,
                'id_folder_mon' => $request->id_folder,
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
                        $lastFolder = FolderMonitoring::orderBy('id_folder_mon', 'desc')->first();
                        $lastNumber = $lastFolder ? intval(substr($lastFolder->id_folder_mon, 5)) : 0;
                        $newFolderId = 'FLMON' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                        
                        FolderMonitoring::create([
                            'id_folder_mon' => $newFolderId,
                            'id_parent' => $currentParentId,
                            'nama_folder_mon' => $folderName,
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
                $storagePath = $file->storeAs('monitoring', $filename, 'public');
                
                $lastFile = MonitoringPelaporan::orderBy('id_monitoring', 'desc')->first();
                $lastNumber = $lastFile ? intval(substr($lastFile->id_monitoring, 5)) : 0;
                $newId = 'FILMN' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
                
                MonitoringPelaporan::create([
                    'id_monitoring' => $newId,
                    'id_folder_mon' => $currentParentId,
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

        $folder = FolderMonitoring::findOrFail($id);
        $folder->nama_folder_mon = $request->name;
        $folder->save();

        return response()->json([
            'success' => true,
            'message' => 'Folder berhasil diubah'
        ]);
    }

    public function deleteFolder($id)
    {
        $folder = FolderMonitoring::findOrFail($id);
        
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

        $file = MonitoringPelaporan::findOrFail($id);
        $file->nama_file = $request->name;
        $file->save();

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diubah'
        ]);
    }

    public function deleteFile($id)
    {
        $file = MonitoringPelaporan::findOrFail($id);
        
        // Delete physical file
        $filePath = str_replace('/storage/', '', $file->link);
        Storage::disk('public')->delete($filePath);
        
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