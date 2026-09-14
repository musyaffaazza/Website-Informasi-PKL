<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'nama',
        'rombel_id',
        'jurusan_id',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_hp',
        'email',
        'nama_ortu',
        'kontak_darurat',
        'foto_url',
        'status_akun',
    ];

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
