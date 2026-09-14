<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $fillable = [
        'kode',
        'nama',
        'singkatan',
        'bidang',
        'akreditasi',
        'kaprog_guru_id',
        'kuota_industri',
        'kuota_terisi',
        'badge_color',
        'mitra_utama',
        'capaian_kurikulum',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'mitra_utama' => 'array',
            'kuota_industri' => 'integer',
            'kuota_terisi' => 'integer',
        ];
    }

    public function kaprog()
    {
        return $this->belongsTo(Guru::class, 'kaprog_guru_id');
    }

    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'jurusan_id');
    }

    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'jurusan_id');
    }

    public function industris()
    {
        return $this->belongsToMany(Industri::class, 'industri_jurusan', 'jurusan_id', 'industri_id');
    }
}
