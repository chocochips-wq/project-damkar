<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FolderMonitoring extends Model
{
    protected $table = 'folder_monitoring';
    protected $primaryKey = 'id_folder_mon';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_folder_mon',
        'id_parent',
        'nama_folder_mon',
        'created',
        'pemilik',
    ];

    protected $casts = [
        'created' => 'datetime',
    ];

    public function children()
    {
        return $this->hasMany(FolderMonitoring::class, 'id_parent', 'id_folder_mon');
    }

    public function parent()
    {
        return $this->belongsTo(FolderMonitoring::class, 'id_parent', 'id_folder_mon');
    }

    public function files()
    {
        return $this->hasMany(MonitoringPelaporan::class, 'id_folder_mon', 'id_folder_mon');
    }
}