<?php

namespace App\Http\Controllers;

use App\Models\FolderPerencanaan;
use App\Models\Perencanaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerencanaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $folderId = $request->get('folder');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $folders = FolderPerencanaan::whereNull('id_parent')->get();
        $currentFolder = null;
        $breadcrumbs = [];

        if ($folderId) {
            $currentFolder = FolderPerencanaan::find($folderId);
            if ($currentFolder) {
                $breadcrumbs = $this->getBreadcrumbs($currentFolder);
                $folders = $currentFolder->children;
            }
        }

        $files = Perencanaan::when($folderId, function($query) use ($folderId) {
            return $query->where('id_folder_per', $folderId);
        })->when($search, function($query) use ($search) {
            return $query->where('nama_file', 'like', '%' . $search . '%');
        })->when($startDate, function($query) use ($startDate) {
            return $query->whereDate('created', '>=', $startDate);
        })->when($endDate, function($query) use ($endDate) {
            return $query->whereDate('created', '<=', $endDate);
        })->orderBy('created', 'desc')->paginate(20);

        return view('perencanaan.index', compact('folders', 'files', 'currentFolder', 'breadcrumbs', 'search', 'startDate', 'endDate'));
    }

    public function createFolder(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_folder' => 'required|string|max:255',
                'id_parent' => 'nullable|string'
            ]);

            // Generate folder ID dengan format FLRPR + 5 digit
            $lastFolder = FolderPerencanaan::orderBy('id_folder_per', 'desc')->first();
            $nextNumber = 1;
            if ($lastFolder) {
                $lastId = $lastFolder->id_folder_per;
                // Extract number from FLRPR00001 format
                if (preg_match('/FLRPR(\d+)/', $lastId, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }
            $newId = 'FLRPR' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $folder = new FolderPerencanaan();
            $folder->id_folder_per = $newId;
            $folder->id_parent = $request->id_parent;
            $folder->nama_folder_per = $request->nama_folder;
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
            $path = $file->storeAs('perencanaan', $filename, 'public');

            // Generate file ID dengan format FILEP + 5 digit
            $lastFile = Perencanaan::orderBy('id_perencanaan', 'desc')->first();
            $nextNumber = 1;
            if ($lastFile) {
                $lastId = $lastFile->id_perencanaan;
                // Extract number from FILEP00051 format
                if (preg_match('/FILEP(\d+)/', $lastId, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }
            $newId = 'FILEP' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Generate file ID
            $newFile = new Perencanaan();
            $newFile->id_perencanaan = $newId;
            $newFile->id_folder_per = $request->id_folder ?? null; // Allow null
            $newFile->nama_file = $originalName;
            $newFile->file_path = $path;
            $newFile->link = '/storage/' . $path;
            $newFile->pemilik = Auth::guard('admin')->user()->nama_admin;
            $newFile->created = now();
            $newFile->save();

            \Log::info('File uploaded', ['id' => $newId, 'name' => $originalName, 'folder' => $newFile->id_folder_per]);

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
                        // Generate folder ID dengan format FLRPR + 5 digit
                        $lastFolder = FolderPerencanaan::orderBy('id_folder_per', 'desc')->first();
                        $nextNumber = 1;
                        if ($lastFolder) {
                            $lastId = $lastFolder->id_folder_per;
                            if (preg_match('/FLRPR(\d+)/', $lastId, $matches)) {
                                $nextNumber = intval($matches[1]) + 1;
                            }
                        }
                        $newFolderId = 'FLRPR' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

                        FolderPerencanaan::create([
                            'id_folder_per' => $newFolderId,
                            'id_parent' => $currentParentId,
                            'nama_folder_per' => $folderName,
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
                $storagePath = $file->storeAs('perencanaan', $filename, 'public');

                // Generate file ID dengan format FILEP + 5 digit
                $lastFile = Perencanaan::orderBy('id_perencanaan', 'desc')->first();
                $nextNumber = 1;
                if ($lastFile) {
                    $lastId = $lastFile->id_perencanaan;
                    if (preg_match('/FILEP(\d+)/', $lastId, $matches)) {
                        $nextNumber = intval($matches[1]) + 1;
                    }
                }
                $newFileId = 'FILEP' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

                Perencanaan::create([
                    'id_perencanaan' => $newFileId,
                    'id_folder_per' => $currentParentId,
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

        $folder = FolderPerencanaan::findOrFail($id);
        $folder->nama_folder_per = $request->name;
        $folder->save();

        return response()->json([
            'success' => true,
            'message' => 'Folder berhasil diubah'
        ]);
    }

    public function deleteFolder($id)
    {
        $folder = FolderPerencanaan::findOrFail($id);

        // Recursively delete all child folders
        $this->deleteChildFoldersPeencanaan($folder->id_folder_per);

        // Delete all files in this folder - get only file links first
        $fileLinks = Perencanaan::where('id_folder_per', $folder->id_folder_per)
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
        Perencanaan::where('id_folder_per', $folder->id_folder_per)->forceDelete();

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

        $file = Perencanaan::findOrFail($id);
        $file->nama_file = $request->name;
        $file->save();

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diubah'
        ]);
    }

    public function deleteFile($id)
    {
        $file = Perencanaan::findOrFail($id);

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

    private function deleteChildFoldersPeencanaan($parentId)
    {
        // Get all child folder IDs only (not full model)
        $childIds = FolderPerencanaan::where('id_parent', $parentId)
            ->pluck('id_folder_per')
            ->toArray();
        
        foreach ($childIds as $childId) {
            // Recursively delete this child's children
            $this->deleteChildFoldersPeencanaan($childId);
            
            // Get file links for this child folder
            $fileLinks = Perencanaan::where('id_folder_per', $childId)
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
            Perencanaan::where('id_folder_per', $childId)->forceDelete();
            
            // Delete the child folder
            FolderPerencanaan::where('id_folder_per', $childId)->forceDelete();
        }
    }

    public function downloadFile($id)
    {
        try {
            $file = Perencanaan::findOrFail($id);
            
            // Jika link adalah URL (Google Drive atau external)
            if (str_starts_with($file->link, 'http')) {
                return redirect($file->link);
            }
            
            // Jika file lokal (Public)
            if (Storage::disk('public')->exists($file->link)) {
                return response()->file(Storage::disk('public')->path($file->link));
            }

            // Jika file lokal (Private / Default App Storage)
            if (Storage::exists($file->link)) {
                return response()->file(Storage::path($file->link));
            }
            
            return response()->json(['message' => 'File tidak ditemukan di server.'], 404);
        } catch (\Exception $e) {
            \Log::error('Download Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function addLink(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_file' => 'required|string|max:255',
                'link' => 'required|url',
                'id_folder_per' => 'nullable|string'
            ]);

            // Generate file ID dengan format FILEP + 5 digit
            $lastFile = Perencanaan::orderBy('id_perencanaan', 'desc')->first();
            $nextNumber = 1;
            if ($lastFile) {
                $lastId = $lastFile->id_perencanaan;
                if (preg_match('/FILEP(\d+)/', $lastId, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }
            $newId = 'FILEP' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $file = new Perencanaan();
            $file->id_perencanaan = $newId;
            $file->id_folder_per = $request->id_folder_per;
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
