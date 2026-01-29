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
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

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
        })->when($startDate, function($query) use ($startDate) {
            return $query->whereDate('created', '>=', $startDate);
        })->when($endDate, function($query) use ($endDate) {
            return $query->whereDate('created', '<=', $endDate);
        })->orderBy('created', 'desc')->paginate(20);

        return view('mekanisme.index', compact('folders', 'files', 'currentFolder', 'breadcrumbs', 'search', 'startDate', 'endDate'));
    }

    public function createFolder(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_folder' => 'required|string|max:255',
                'id_parent' => 'nullable|string'
            ]);

            // Generate folder ID dengan format FLMEK + 5 digit
            $lastFolder = FolderMekanisme::orderBy('id_folder_mek', 'desc')->first();
            $nextNumber = 1;
            if ($lastFolder) {
                $lastId = $lastFolder->id_folder_mek;
                // Extract number from FLMEK00001 format
                if (preg_match('/FLMEK(\d+)/', $lastId, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }
            $newId = 'FLMEK' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $folder = new FolderMekanisme();
            $folder->id_folder_mek = $newId;
            $folder->id_parent = $request->id_parent;
            $folder->nama_folder_mek = $request->nama_folder;
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
            $path = $file->storeAs('mekanisme', $filename, 'public');

            // Generate file ID dengan format FILMK + 5 digit
            $lastFile = Mekanisme::orderBy('id_mekanisme', 'desc')->first();
            $nextNumber = 1;
            if ($lastFile) {
                $lastId = $lastFile->id_mekanisme;
                // Extract number from FILMK00001 format
                if (preg_match('/FILMK(\d+)/', $lastId, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }
            $newId = 'FILMK' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            // Generate file ID
            $newFile = new Mekanisme();
            $newFile->id_mekanisme = $newId;
            $newFile->id_folder_mek = $request->id_folder ?? null; // Allow null
            $newFile->nama_file = $originalName;
            $newFile->file_path = $path;
            $newFile->link = '/storage/' . $path;
            $newFile->pemilik = Auth::guard('admin')->user()->nama_admin;
            $newFile->created = now();
            $newFile->save();

            \Log::info('File uploaded', ['id' => $newId, 'name' => $originalName, 'folder' => $newFile->id_folder_mek]);

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
                        // Generate folder ID dengan format FLMEK + 5 digit
                        $lastFolder = FolderMekanisme::orderBy('id_folder_mek', 'desc')->first();
                        $nextNumber = 1;
                        if ($lastFolder) {
                            $lastId = $lastFolder->id_folder_mek;
                            if (preg_match('/FLMEK(\d+)/', $lastId, $matches)) {
                                $nextNumber = intval($matches[1]) + 1;
                            }
                        }
                        $newFolderId = 'FLMEK' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

                        FolderMekanisme::create([
                            'id_folder_mek' => $newFolderId,
                            'id_parent' => $currentParentId,
                            'nama_folder_mek' => $folderName,
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
                $storagePath = $file->storeAs('mekanisme', $filename, 'public');

                // Generate file ID dengan format FILMK + 5 digit
                $lastFile = Mekanisme::orderBy('id_mekanisme', 'desc')->first();
                $nextNumber = 1;
                if ($lastFile) {
                    $lastId = $lastFile->id_mekanisme;
                    if (preg_match('/FILMK(\d+)/', $lastId, $matches)) {
                        $nextNumber = intval($matches[1]) + 1;
                    }
                }
                $newFileId = 'FILMK' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

                Mekanisme::create([
                    'id_mekanisme' => $newFileId,
                    'id_folder_mek' => $currentParentId,
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

        // Recursively delete all child folders
        $this->deleteChildFoldersMekanisme($folder->id_folder_mek);

        // Delete all files in this folder - get only file links first
        $fileLinks = Mekanisme::where('id_folder_mek', $folder->id_folder_mek)
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
        Mekanisme::where('id_folder_mek', $folder->id_folder_mek)->forceDelete();

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

    private function deleteChildFoldersMekanisme($parentId)
    {
        // Get all child folder IDs only (not full model)
        $childIds = FolderMekanisme::where('id_parent', $parentId)
            ->pluck('id_folder_mek')
            ->toArray();
        
        foreach ($childIds as $childId) {
            // Recursively delete this child's children
            $this->deleteChildFoldersMekanisme($childId);
            
            // Get file links for this child folder
            $fileLinks = Mekanisme::where('id_folder_mek', $childId)
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
            Mekanisme::where('id_folder_mek', $childId)->forceDelete();
            
            // Delete the child folder
            FolderMekanisme::where('id_folder_mek', $childId)->forceDelete();
        }
    }

    public function downloadFile($id)
    {
        try {
            $file = Mekanisme::findOrFail($id);
            
            // Jika link adalah URL (Google Drive atau external)
            if (str_starts_with($file->link, 'http')) {
                return redirect($file->link);
            }
            
            // Jika file lokal
            if (Storage::disk('public')->exists($file->link)) {
                return Storage::disk('public')->download($file->link, $file->nama_file);
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
                'id_folder_mek' => 'nullable|string'
            ]);

            // Generate file ID dengan format FILMK + 5 digit
            $lastFile = Mekanisme::orderBy('id_mekanisme', 'desc')->first();
            $nextNumber = 1;
            if ($lastFile) {
                $lastId = $lastFile->id_mekanisme;
                if (preg_match('/FILMK(\d+)/', $lastId, $matches)) {
                    $nextNumber = intval($matches[1]) + 1;
                }
            }
            $newId = 'FILMK' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $file = new Mekanisme();
            $file->id_mekanisme = $newId;
            $file->id_folder_mek = $request->id_folder_mek;
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
