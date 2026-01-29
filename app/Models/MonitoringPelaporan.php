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

        // Jika ada link yang sudah berupa URL lengkap
        if ($link) {
            if (str_starts_with($link, 'http://') || str_starts_with($link, 'https://')) {
                // Google Drive special handling: normalisasi ke /view
                if (str_contains($link, 'drive.google.com')) {
                    if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $link, $matches)) {
                        return "https://drive.google.com/file/d/{$matches[1]}/view";
                    }
                }
                return $link;
            }

            // Jika disimpan sebagai asset path '/storage/...' atau 'storage/...',
            // cek apakah file benar-benar ada di storage; jika ya, arahkan ke route download lokal,
            // jika tidak ada, anggap link tidak tersedia.
            if (str_starts_with($link, '/storage/') || str_starts_with($link, 'storage/')) {
                $candidate = ltrim(preg_replace('#^/storage/#', '', $link), '/');
                $candidate = ltrim(preg_replace('#^storage/#', '', $candidate), '/');
                if ($candidate && Storage::disk('public')->exists($candidate)) {
                    return route('monitoring.file.download', $this->id_monitoring);
                }
                return null;
            }
        }

        // Fallback: jika ada kolom file_path (lokal di storage/app/public)
        if (!empty($this->file_path)) {
            $path = ltrim($this->file_path, '/');
            if (Storage::disk('public')->exists($path)) {
                return route('monitoring.file.download', $this->id_monitoring);
            }
        }

        // Cek apakah link (sebagai path relatif) ada di storage
        if ($link && file_exists(storage_path('app/public/' . ltrim($link, '/')))) {
            return route('monitoring.file.download', $this->id_monitoring);
        }

        return null;

        // Jika path relatif dari public
        if (file_exists(public_path($link))) {
            return asset($link);
        }

        return null;
    }
}
