<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $table = 'rombel';

    protected $fillable = [
        'kode_rombel',
        'nama_kode',
        'nama_rombel',
        'tingkat',
        'ruang',
        'jurusan_id',
        'wali_kelas_guru_id',
        'jumlah_siswa',
        'siswa_terdata',
        'status_pkl',
        'tahun_ajaran',
        'semester',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_siswa' => 'integer',
            'siswa_terdata' => 'integer',
        ];
    }

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

    public function getKodeAttribute()
    {
        return $this->kode_rombel ?: $this->nama_kode;
    }

    public function getNamaAttribute()
    {
        return $this->nama_rombel ?: $this->nama_kode;
    }
}
