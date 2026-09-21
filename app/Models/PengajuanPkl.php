<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPkl extends Model
{
    protected $table = 'pengajuan_pkl';

    protected $fillable = [
        'siswa_id',
        'industri_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'dokumen_url',
        'status',
        'dibuat_pada',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'dibuat_pada' => 'datetime',
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function industri()
    {
        return $this->belongsTo(Industri::class, 'industri_id');
    }

    public function penugasan()
    {
        return $this->hasOne(PembimbingPenugasan::class, 'pengajuan_id');
    }

    public function getKodePengajuanAttribute()
    {
        $year = $this->tanggal_mulai ? $this->tanggal_mulai->format('Y') : date('Y');
        return '#PKL-' . $year . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
