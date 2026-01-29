<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumentasiFile extends Model
{
    protected $table = 'tbl_dokumentasi_file';
    protected $primaryKey = 'id_file';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_file',
        'id_kegiatan',
        'file_url',
        'ekstensi',
        'created',
    ];

    protected $casts = [
        'created' => 'datetime',
    ];

    /**
     * Accessor untuk mendapatkan URL gambar yang bisa di-embed
     */
    public function getImageUrlAttribute()
    {
        $url = $this->attributes['file_url'] ?? null;
        
        if (!$url) {
            return asset('images/logo-damkar.png');
        }

        // Jika Google Drive link, konversi ke thumbnail URL
        if (str_contains($url, 'drive.google.com')) {
            if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                $fileId = $matches[1];
                return "https://drive.google.com/thumbnail?id={$fileId}&sz=w800";
            }
        }

        // Jika sudah full URL lainnya
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        // Jika path relatif dari storage
        if (file_exists(storage_path('app/public/' . $url))) {
            return asset('storage/' . $url);
        }

        return asset('images/logo-damkar.png');
    }

    public function getThumbnailAttribute($value)
{
    // Jika thumbnail adalah link Google Drive
    if ($value && str_contains($value, 'drive.google.com')) {
        preg_match('/\/d\/(.*?)\//', $value, $matches);

        if (isset($matches[1])) {
            return 'https://drive.google.com/uc?export=view&id=' . $matches[1];
        }
    }

    // Jika thumbnail lokal (opsional, jaga-jaga)
    if ($value && file_exists(storage_path('app/public/dokumentasi/' . $value))) {
        return asset('storage/dokumentasi/' . $value);
    }

    return $value;
}

    public function dokumentasi()
    {
        return $this->belongsTo(Dokumentasi::class, 'id_kegiatan', 'id_kegiatan');
    }
}
