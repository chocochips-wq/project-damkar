<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 't_admin';
    protected $primaryKey = 'id_admin';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_admin',
        'nama_admin',
        'username_admin',
        'password_admin',
        'is_delete_admin',
    ];

    protected $hidden = [
        'password_admin',
    ];

    public function getAuthPassword()
    {
        return $this->password_admin;
    }
}