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
}