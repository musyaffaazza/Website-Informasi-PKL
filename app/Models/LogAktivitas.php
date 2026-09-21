<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'aksi',
        'modul',
        'deskripsi',
        'ip_address',
        'user_agent',
        'dibuat_pada',
    ];

    protected function casts(): array
    {
        return [
            'dibuat_pada' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function catat(string $aksi, ?string $modul = null, ?string $deskripsi = null, int $userId = 1): void
    {
        static::create([
            'user_id'    => $userId,
            'aksi'       => $aksi,
            'modul'      => $modul,
            'deskripsi'  => $deskripsi,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'dibuat_pada' => now(),
        ]);
    }
}