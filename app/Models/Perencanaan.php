<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Perencanaan extends Model
{
    protected $table = 'tbl_perencanaan';
    protected $primaryKey = 'id_perencanaan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_perencanaan',
        'id_folder_per',
        'nama_file',
        'file_path',
        'link',
        'pemilik',
        'created',
    ];

    protected $casts = [
        'created' => 'datetime',
    ];

    public function folder()
    {
        return $this->belongsTo(FolderPerencanaan::class, 'id_folder_per', 'id_folder_per');
    }

    // Accessor untuk file_url (mengambil dari kolom link)
    public function getFileUrlAttribute()
    {
        $link = $this->link;

        if (!$link && empty($this->file_path)) {
            return null;
        }

        // 1. Cek External URL
        if ($link && (str_starts_with($link, 'http://') || str_starts_with($link, 'https://'))) {
            // Google Drive
            if (str_contains($link, 'drive.google.com')) {
                if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $link, $matches)) {
                    return "https://drive.google.com/file/d/{$matches[1]}/view";
                }
            }
            return $link;
        }

        // 2. Cek Local Storage (berdasarkan kolom file_path jika ada)
        if (!empty($this->file_path)) {
            if (Storage::disk('public')->exists($this->file_path)) {
                return asset('storage/' . $this->file_path);
            }
        }

        // 3. Cek Local Storage (berdasarkan kolom link)
        if ($link) {
            // Bersihkan prefix '/storage/' atau 'storage/' jika ada
            $cleanPath = preg_replace('#^/?storage/#', '', $link);
            $cleanPath = ltrim($cleanPath, '/');

            // 1. Cek PUBLIC Disk (Prioritas Utama - Kembalikan ke behavior normal)
            if (Storage::disk('public')->exists($cleanPath)) {
                return asset('storage/' . $cleanPath);
            }

            // 2. Fallback: cek jika path relatif dari public folder (legacy check)
            if (file_exists(public_path($link))) {
                return asset($link);
            }

            // 3. Cek PRIVATE Disk (Hanya jika tidak ada di publik)
            if (Storage::exists($link)) {
                return route('perencanaan.file.download', ['id' => $this->id_perencanaan]);
            }
        }
        
        return null;
    }
}
