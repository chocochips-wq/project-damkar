<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mekanisme extends Model
{
    protected $table = 'tbl_mekanisme';
    protected $primaryKey = 'id_mekanisme';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_mekanisme',
        'id_folder_mek',
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
        return $this->belongsTo(FolderMekanisme::class, 'id_folder_mek', 'id_folder_mek');
    }

    // Accessor untuk file_url
    public function getFileUrlAttribute()
    {
        $link = $this->link;

        // Jika link adalah URL (Google Drive atau external)
        if ($link && (str_starts_with($link, 'http://') || str_starts_with($link, 'https://'))) {
            if (str_contains($link, 'drive.google.com')) {
                if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $link, $matches)) {
                    return "https://drive.google.com/file/d/{$matches[1]}/view";
                }
            }
            return $link;
        }

        // 2. Cek Local Storage (berdasarkan kolom file_path)
        if (!empty($this->file_path)) {
           if (\Illuminate\Support\Facades\Storage::disk('public')->exists($this->file_path)) {
               return asset('storage/' . $this->file_path);
           }
        }

        // 3. Cek Local Storage (berdasarkan kolom link)
        if ($link) {
            $cleanPath = preg_replace('#^/?storage/#', '', $link);
            $cleanPath = ltrim($cleanPath, '/');

            // 1. Cek PUBLIC Disk
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
                return asset('storage/' . $cleanPath);
            }

            // 2. Fallback: cek legacy public path
            if (file_exists(public_path($link))) {
                return asset($link);
            }

            // 3. Cek PRIVATE Disk
            if (\Illuminate\Support\Facades\Storage::exists($link)) {
                return route('mekanisme.file.download', $this->id_mekanisme);
            }
        }

        return null;
    }
}