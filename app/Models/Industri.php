<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    protected $table = 'industri';

    protected $fillable = [
        'nama',
        'bidang_usaha',
        'alamat',
        'wilayah',
        'no_mou',
        'latitude',
        'longitude',
        'radius_meter',
        'kontak_nama',
        'kontak_jabatan',
        'kontak_no_hp',
        'kontak_email',
        'pembimbing_nama',
        'pembimbing_guru_id',
        'kuota',
        'kuota_terisi',
        'mou_url',
        'mou_berlaku_sampai',
        'status',
        'status_kemitraan',
    ];

    protected function casts(): array
    {
        return [
            'kuota' => 'integer',
            'kuota_terisi' => 'integer',
            'mou_berlaku_sampai' => 'date',
        ];
    }

    public function jurusans()
    {
        return $this->belongsToMany(Jurusan::class, 'industri_jurusan', 'industri_id', 'jurusan_id');
    }

    public function pembimbingGuru()
    {
        return $this->belongsTo(Guru::class, 'pembimbing_guru_id');
    }

    public function getInitialsAttribute()
    {
        $cleanName = preg_replace('/^(PT|CV|UD|PD|Koperasi|Yayasan)\.?\s+/i', '', $this->nama);
        $words = explode(' ', trim($cleanName));
        $initials = '';
        foreach ($words as $w) {
            $w = trim($w);
            if (!empty($w)) {
                $initials .= strtoupper($w[0]);
                if (strlen($initials) >= 2) break;
            }
        }
        return $initials ?: strtoupper(substr($this->nama, 0, 2));
    }
}
