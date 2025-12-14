<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonitoringPelaporan extends Model
{
    protected $table = 'tbl_monitoring_pelaporan';
    protected $primaryKey = 'id_monitoring';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_monitoring',
        'id_folder_mon',
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
        return $this->belongsTo(FolderMonitoring::class, 'id_folder_mon', 'id_folder_mon');
    }
}