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
}