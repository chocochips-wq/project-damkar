<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    protected $table = 'tbl_dokumentasi';
    protected $primaryKey = 'id_kegiatan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_kegiatan',
        'nama_kegiatan',
        'keterangan',
        'tanggal_kegiatan',
        'thumbnail',
        'ekstensi',
        'created',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
        'created' => 'datetime',
    ];

    public function files()
    {
        return $this->hasMany(DokumentasiFile::class, 'id_kegiatan', 'id_kegiatan');
    }

    public function getThumbnailAttribute($value)
    {
        // Jika kosong, return default
        if (!$value) {
            return asset('images/logo-damkar.png');
        }

        // Jika sudah full URL (http:// atau https://)
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {

            // Jika Google Drive link
            if (str_contains($value, 'drive.google.com')) {
                // Format: /file/d/ID/view atau /file/d/ID/preview
                if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $value, $matches)) {
                    $fileId = $matches[1];
                    return "https://drive.google.com/thumbnail?id={$fileId}&sz=w1000";
                }
            }

            // Return URL as is (untuk local URL seperti http://127.0.0.1:8000/...)
            return $value;
        }

        // Jika path relatif dari storage (format: "dokumentasi/filename.jpg")
        if (file_exists(storage_path('app/public/' . $value))) {
            return asset('storage/' . $value);
        }

        // Jika path relatif dari public/images (format: "logo-damkar.png")
        if (file_exists(public_path('images/' . $value))) {
            return asset('images/' . $value);
        }

        // Default image jika tidak ditemukan
        return asset('images/logo-damkar.png');
    }
}
