<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderPerencanaan extends Model
{
    protected $table = 'folder_perencanaan';  // ← PENTING: tanpa tbl_
    protected $primaryKey = 'id_folder_per';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_folder_per',
        'id_parent',
        'nama_folder_per',
        'pemilik',
        'created',
    ];

    protected $casts = [
        'created' => 'datetime',
    ];

    public function children()
    {
        return $this->hasMany(FolderPerencanaan::class, 'id_parent', 'id_folder_per');
    }

    public function parent()
    {
        return $this->belongsTo(FolderPerencanaan::class, 'id_parent', 'id_folder_per');
    }

    public function files()
    {
        return $this->hasMany(Perencanaan::class, 'id_folder_per', 'id_folder_per');
    }

    public function getTotalFilesAttribute()
    {
        $count = $this->files()->count();

        foreach ($this->children as $child) {
            $count += $child->total_files;
        }

        return $count;
    }
}
