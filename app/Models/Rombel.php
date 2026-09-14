<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $table = 'rombel';

    public $timestamps = false;

    protected $fillable = [
        'nama_kode',
        'jurusan_id',
        'wali_kelas_guru_id',
        'tahun_ajaran',
        'status',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_guru_id');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'rombel_id');
    }
}
