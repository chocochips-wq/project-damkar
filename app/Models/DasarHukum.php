<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DasarHukum extends Model
{
    protected $table = 'tbl_dasar_hukum';
    protected $primaryKey = 'id_hukum';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_hukum',
        'nama_hukum',
        'created',
        'pemilik',
    ];

    protected $casts = [
        'created' => 'datetime',
    ];
}