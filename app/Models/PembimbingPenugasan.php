<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembimbingPenugasan extends Model
{
    protected $table = 'pembimbing_penugasan';

    public $timestamps = false;

    protected $fillable = [
        'siswa_id',
        'pengajuan_id',
        'pembimbing_guru_id',
        'tanggal_mulai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanPkl::class, 'pengajuan_id');
    }

    public function pembimbing()
    {
        return $this->belongsTo(Guru::class, 'pembimbing_guru_id');
    }
}