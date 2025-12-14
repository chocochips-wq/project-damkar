<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderMekanisme extends Model
{
    protected $table = 'folder_mekanisme';
    protected $primaryKey = 'id_folder_mek';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_folder_mek',
        'id_parent',
        'nama_folder_mek',
        'created',
        'pemilik',
    ];

    protected $casts = [
        'created' => 'datetime',
    ];

    public function children()
    {
        return $this->hasMany(FolderMekanisme::class, 'id_parent', 'id_folder_mek');
    }

    public function parent()
    {
        return $this->belongsTo(FolderMekanisme::class, 'id_parent', 'id_folder_mek');
    }

    public function files()
    {
        return $this->hasMany(Mekanisme::class, 'id_folder_mek', 'id_folder_mek');
    }
}