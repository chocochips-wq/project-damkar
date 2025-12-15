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
        // Jika thumbnail adalah link Google Drive
        if ($value && str_contains($value, 'drive.google.com')) {
            // Format 1: /file/d/ID/view
            if (preg_match('/\/d\/([^\/]+)\//', $value, $matches)) {
                return 'https://drive.google.com/uc?export=view&id=' . $matches[1];
            }
            // Format 2: ?id=ID
            if (preg_match('/[?&]id=([^&]+)/', $value, $matches)) {
                return 'https://drive.google.com/uc?export=view&id=' . $matches[1];
            }
        }

        // Jika thumbnail lokal di public/images
        if ($value && file_exists(public_path('images/' . $value))) {
            return asset('images/' . $value);
        }

        // Jika di storage
        if ($value && file_exists(storage_path('app/public/dokumentasi/' . $value))) {
            return asset('storage/dokumentasi/' . $value);
        }

        // Default image jika tidak ditemukan
        return asset('images/logo-damkar.png');
    }
}
