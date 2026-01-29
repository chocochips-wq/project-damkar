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
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

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
        })->when($startDate, function($query) use ($startDate) {
            return $query->whereDate('created', '>=', $startDate);
        })->when($endDate, function($query) use ($endDate) {
            return $query->whereDate('created', '<=', $endDate);
        })->orderBy('created', 'desc')->paginate(20);

        return view('monitoring.index', compact('folders', 'files', 'currentFolder', 'breadcrumbs', 'search', 'startDate', 'endDate'));
    }

    public function createFolder(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_folder' => 'required|string|max:255',
                'id_parent' => 'nullable|string'
            ]);

            // Generate folder ID dengan format FLMON + 5 digit
            $lastFolder = FolderMonitoring::orderBy('id_folder_mon', 'desc')->first();
            $nextNumber = 1;
            if ($lastFolder) {
                $lastId = $lastFolder->id_folder_mon;
                // Extract number from FLMON00001 format
                if (preg_match('/FLMON(\d+)/', $lastId, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }
            $newId = 'FLMON' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $folder = new FolderMonitoring();
            $folder->id_folder_mon = $newId;
            $folder->id_parent = $request->id_parent;
            $folder->nama_folder_mon = $request->nama_folder;
            $folder->pemilik = Auth::guard('admin')->user()->nama_admin;
            $folder->created = now();
            $folder->save();

            return response()->json([
                'success' => true,
                'message' => 'Folder berhasil dibuat'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadFile(Request $request)
    {
        try {
            $validated = $request->validate([
                'file' => 'required|file|max:51200', // Max 50MB
                'id_folder' => 'nullable|string'
            ]);

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $extension;

            // Store file
            $path = $file->storeAs('monitoring', $filename, 'public');

            // Generate file ID dengan format FILMN + 5 digit
            $lastFile = MonitoringPelaporan::orderBy('id_monitoring', 'desc')->first();
            $nextNumber = 1;
            if ($lastFile) {
                $lastId = $lastFile->id_monitoring;
                // Extract number from FILMN00001 format
                if (preg_match('/FILMN(\d+)/', $lastId, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }
            $newId = 'FILMN' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Generate file ID
            $newFile = new MonitoringPelaporan();
            $newFile->id_monitoring = $newId;
            $newFile->id_folder_mon = $request->id_folder ?? null; // Allow null
            $newFile->nama_file = $originalName;
            $newFile->file_path = $path;
            $newFile->link = '/storage/' . $path;
            $newFile->pemilik = Auth::guard('admin')->user()->nama_admin;
            $newFile->created = now();
            $newFile->save();

            \Log::info('File uploaded', ['id' => $newId, 'name' => $originalName, 'folder' => $newFile->id_folder_mon]);

            return response()->json([
                'success' => true,
                'message' => 'File berhasil diupload'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Upload file error', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload file: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadFolder(Request $request)
    {
        try {
            // Debug: Log what we actually received
            \Log::info('Upload request received', [
                'has_files' => $request->hasFile('files'),
                'has_files_array' => $request->has('files'),
                'all_files' => $request->allFiles(),
                'all_input' => $request->except(['files'])
            ]);

            // Don't validate files* - just check if we have files
            $files = $request->file('files');
            
            // If files is not an array, convert it
            if ($files && !is_array($files)) {
                $files = [$files];
            }
            
            // Handle case where files might be null or not an array
            if (!$files || (is_array($files) && count($files) === 0)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada file yang diupload'
                ], 400);
            }
            
            $paths = $request->input('paths', []);
            $parentId = $request->input('id_parent');

            \Log::info('Upload folder started', [
                'file_count' => count($files),
                'paths_count' => count($paths),
                'parent_id' => $parentId
            ]);

            $folderMap = [];
            $uploadedCount = 0;

            foreach ($files as $index => $file) {
                $relativePath = $paths[$index] ?? $file->getClientOriginalName();
                $pathParts = explode('/', $relativePath);

                \Log::info('Processing file', ['path' => $relativePath, 'parts' => count($pathParts)]);

                // Handle folder structure
                $currentParentId = $parentId;

                // Create folders if needed (except last part which is filename)
                for ($i = 0; $i < count($pathParts) - 1; $i++) {
                    $folderName = $pathParts[$i];
                    $folderKey = $currentParentId . '/' . $folderName;

                    if (!isset($folderMap[$folderKey])) {
                        // Generate folder ID dengan format FLMON + 5 digit
                        $lastFolder = FolderMonitoring::orderBy('id_folder_mon', 'desc')->first();
                        $nextNumber = 1;
                        if ($lastFolder) {
                            $lastId = $lastFolder->id_folder_mon;
                            if (preg_match('/FLMON(\d+)/', $lastId, $matches)) {
                                $nextNumber = intval($matches[1]) + 1;
                            }
                        }
                        $newFolderId = 'FLMON' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

                        FolderMonitoring::create([
                            'id_folder_mon' => $newFolderId,
                            'id_parent' => $currentParentId,
                            'nama_folder_mon' => $folderName,
                            'created' => now(),
                            'pemilik' => Auth::guard('admin')->user()->nama_admin
                        ]);

                        $folderMap[$folderKey] = $newFolderId;
                        \Log::info('Folder created', ['id' => $newFolderId, 'name' => $folderName]);

                        // Small delay to ensure unique timestamps
                        usleep(10000); // 0.01 second
                    }

                    $currentParentId = $folderMap[$folderKey];
                }

                // Upload file
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $storagePath = $file->storeAs('monitoring', $filename, 'public');

                // Generate file ID dengan format FILMN + 5 digit
                $lastFile = MonitoringPelaporan::orderBy('id_monitoring', 'desc')->first();
                $nextNumber = 1;
                if ($lastFile) {
                    $lastId = $lastFile->id_monitoring;
                    if (preg_match('/FILMN(\d+)/', $lastId, $matches)) {
                        $nextNumber = intval($matches[1]) + 1;
                    }
                }
                $newFileId = 'FILMN' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

                MonitoringPelaporan::create([
                    'id_monitoring' => $newFileId,
                    'id_folder_mon' => $currentParentId,
                    'nama_file' => $originalName,
                    'file_path' => $storagePath,
                    'link' => '/storage/' . $storagePath,
                    'created' => now(),
                    'pemilik' => Auth::guard('admin')->user()->nama_admin
                ]);

                $uploadedCount++;
                \Log::info('File uploaded', ['id' => $newFileId, 'name' => $originalName, 'folder' => $currentParentId]);
                usleep(10000); // 0.01 second delay
            }

            \Log::info('Upload folder completed', ['uploaded_count' => $uploadedCount]);

            return response()->json([
                'success' => true,
                'message' => "Berhasil upload {$uploadedCount} file"
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Upload folder validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Upload folder error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
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

        // Recursively delete all child folders
        $this->deleteChildFoldersMonitoring($folder->id_folder_mon);

        // Delete all files in this folder - get only file links first
        $fileLinks = MonitoringPelaporan::where('id_folder_mon', $folder->id_folder_mon)
            ->whereNotNull('link')
            ->pluck('link')
            ->toArray();
        
        // Delete files from storage (if they are actual file paths, not URLs)
        foreach ($fileLinks as $fileLink) {
            try {
                // Only delete if it's a file path, not a URL
                if (!str_starts_with($fileLink, 'http')) {
                    Storage::disk('public')->delete($fileLink);
                }
            } catch (\Exception $e) {
                // Continue even if file doesn't exist
            }
        }
        
        // Delete database records using raw query to save memory
        MonitoringPelaporan::where('id_folder_mon', $folder->id_folder_mon)->forceDelete();

        // Delete the folder itself
        $folder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Folder dan isinya berhasil dihapus'
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

        // Delete physical file if exists
        if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
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

    private function deleteChildFoldersMonitoring($parentId)
    {
        // Get all child folder IDs only (not full model)
        $childIds = FolderMonitoring::where('id_parent', $parentId)
            ->pluck('id_folder_mon')
            ->toArray();
        
        foreach ($childIds as $childId) {
            // Recursively delete this child's children
            $this->deleteChildFoldersMonitoring($childId);
            
            // Get file links for this child folder
            $fileLinks = MonitoringPelaporan::where('id_folder_mon', $childId)
                ->whereNotNull('link')
                ->pluck('link')
                ->toArray();
            
            // Delete files from storage (if they are actual file paths, not URLs)
            foreach ($fileLinks as $fileLink) {
                try {
                    // Only delete if it's a file path, not a URL
                    if (!str_starts_with($fileLink, 'http')) {
                        Storage::disk('public')->delete($fileLink);
                    }
                } catch (\Exception $e) {
                    // Continue even if file doesn't exist
                }
            }
            
            // Delete all files in this child folder using raw query
            MonitoringPelaporan::where('id_folder_mon', $childId)->forceDelete();
            
            // Delete the child folder
            FolderMonitoring::where('id_folder_mon', $childId)->forceDelete();
        }
    }

    public function downloadFile($id)
    {
        try {
            $file = MonitoringPelaporan::findOrFail($id);
            
            // Jika link adalah URL (Google Drive atau external)
            if (str_starts_with($file->link, 'http')) {
                return redirect($file->link);
            }
            
            // 1. Cek berdasarkan file_path (biasanya public)
            if (!empty($file->file_path)) {
                $path = ltrim($file->file_path, '/');
                if (Storage::disk('public')->exists($path)) {
                    return response()->file(Storage::disk('public')->path($path));
                }
            }

            // 2. Cek berdasarkan link (Public)
            if (!empty($file->link)) {
                $cleanPath = preg_replace('#^/?storage/#', '', $file->link);
                $cleanPath = ltrim($cleanPath, '/');
                
                if (Storage::disk('public')->exists($cleanPath)) {
                    return response()->file(Storage::disk('public')->path($cleanPath));
                }

                // 3. Cek Private Storage
                if (Storage::exists($file->link)) {
                    return response()->file(Storage::path($file->link));
                }
            }
            
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function addLink(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_file' => 'required|string|max:255',
                'link' => 'required|url',
                'id_folder_mon' => 'nullable|string'
            ]);

            // Generate file ID dengan format FILMN + 5 digit
            $lastFile = MonitoringPelaporan::orderBy('id_monitoring', 'desc')->first();
            $nextNumber = 1;
            if ($lastFile) {
                $lastId = $lastFile->id_monitoring;
                if (preg_match('/FILMN(\d+)/', $lastId, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }
            $newId = 'FILMN' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $file = new MonitoringPelaporan();
            $file->id_monitoring = $newId;
            $file->id_folder_mon = $request->id_folder_mon;
            $file->nama_file = $validated['nama_file'];
            $file->link = $validated['link'];
            $file->pemilik = Auth::guard('admin')->user()->nama_admin;
            $file->created = now();
            $file->save();

            return response()->json([
                'success' => true,
                'message' => 'Link berhasil ditambahkan'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
