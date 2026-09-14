<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'username',
        'email',
        'password_hash',
        'tipe_akun',
        'terakhir_login',
        'dibuat_pada',
    ];

    protected $hidden = [
        'password_hash',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'terakhir_login' => 'datetime',
            'dibuat_pada' => 'datetime',
        ];
    }

    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}