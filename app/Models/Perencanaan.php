<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

        // Jika link kosong
        if (!$link) {
            return null;
        }

        // Jika sudah full URL (http:// atau https://)
        if (str_starts_with($link, 'http://') || str_starts_with($link, 'https://')) {
            // Jika Google Drive link
            if (str_contains($link, 'drive.google.com')) {
                // Format: /file/d/ID/view atau /file/d/ID/preview
                if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $link, $matches)) {
                    return "https://drive.google.com/file/d/{$matches[1]}/view";
                }
            }
            return $link;
        }

        // Jika path relatif dari storage
        if (file_exists(storage_path('app/public/' . $link))) {
            return asset('storage/' . $link);
        }

        // Jika path relatif dari public
        if (file_exists(public_path($link))) {
            return asset($link);
        }

        return null;
    }
}
