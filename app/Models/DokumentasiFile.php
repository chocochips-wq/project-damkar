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
