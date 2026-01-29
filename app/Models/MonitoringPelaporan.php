<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MonitoringPelaporan extends Model
{
    protected $table = 'tbl_monitoring_pelaporan';
    protected $primaryKey = 'id_monitoring';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_monitoring',
        'id_folder_mon',
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
        return $this->belongsTo(FolderMonitoring::class, 'id_folder_mon', 'id_folder_mon');
    }

    // Accessor untuk file_url (mengambil dari kolom link)
    public function getFileUrlAttribute()
    {
        $link = $this->link;

        // Jika link adalah URL (Google Drive atau external)
        if ($link && (str_starts_with($link, 'http://') || str_starts_with($link, 'https://'))) {
            // Google Drive special handling: normalisasi ke /view
            if (str_contains($link, 'drive.google.com')) {
                if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $link, $matches)) {
                    return "https://drive.google.com/file/d/{$matches[1]}/view";
                }
            }
            return $link;
        }

        // 2. Cek Local Storage (berdasarkan kolom file_path)
        if (!empty($this->file_path)) {
           if (Storage::disk('public')->exists($this->file_path)) {
               return asset('storage/' . $this->file_path);
           }
        }

        // 3. Cek Local Storage (berdasarkan kolom link)
        if ($link) {
            $cleanPath = preg_replace('#^/?storage/#', '', $link);
            $cleanPath = ltrim($cleanPath, '/');

            // 1. Cek PUBLIC Disk
            if (Storage::disk('public')->exists($cleanPath)) {
                return asset('storage/' . $cleanPath);
            }

            // 2. Fallback: cek legacy public path
            if (file_exists(public_path($link))) {
                return asset($link);
            }

            // 3. Cek PRIVATE Disk
            if (Storage::exists($link)) {
                return route('monitoring.file.download', $this->id_monitoring);
            }
        }

        return null;

        return null;
    }
}
