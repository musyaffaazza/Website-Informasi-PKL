<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    protected $table = 'industri';

    protected $fillable = [
        'nama',
        'alamat',
        'latitude',
        'longitude',
        'radius_meter',
        'kontak_nama',
        'kontak_no_hp',
        'kontak_email',
        'kuota',
        'mou_url',
        'mou_berlaku_sampai',
        'status',
    ];

    public function jurusans()
    {
        return $this->belongsToMany(Jurusan::class, 'industri_jurusan', 'industri_id', 'jurusan_id');
    }
}
