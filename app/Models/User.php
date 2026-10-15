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
        'avatar_url',
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

    /**
     * Determine whether this account is the administrator account.
     */
    public function isAdminAkun(): bool
    {
        return strtolower((string) $this->username) === 'admin'
            || strtolower((string) $this->email) === 'admin@smkn1gunungputri.sch.id';
    }

    public function getRememberTokenName()
    {
        return '';
    }

    public function guru()
    {
        return $this->hasOne(Guru::class, 'user_id');
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'user_id');
    }
}
