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

    public function dokumentasi()
    {
        return $this->belongsTo(Dokumentasi::class, 'id_kegiatan', 'id_kegiatan');
    }
}