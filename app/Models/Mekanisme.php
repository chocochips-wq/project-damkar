<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mekanisme extends Model
{
    protected $table = 'tbl_mekanisme';
    protected $primaryKey = 'id_mekanisme';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_mekanisme',
        'id_folder_mek',
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
        return $this->belongsTo(FolderMekanisme::class, 'id_folder_mek', 'id_folder_mek');
    }
}