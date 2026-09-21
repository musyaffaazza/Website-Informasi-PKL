<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'nis',
        'nisn',
        'nama',
        'rombel_id',
        'jurusan_id',
        'kampus',
        'jenis_kelamin',
        'tanggal_lahir',
        'kota',
        'no_hp',
        'email',
        'nama_ortu',
        'kontak_darurat',
        'foto_url',
        'status_akun',
        'status_pkl',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'rombel_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function pengajuanPkl()
    {
        return $this->hasOne(PengajuanPkl::class, 'siswa_id');
    }

    public function penugasanPembimbing()
    {
        return $this->hasOne(PembimbingPenugasan::class, 'siswa_id');
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', preg_replace('/[^a-zA-Z\s]/', '', $this->nama));
        $initials = '';
        $count = 0;
        foreach ($words as $w) {
            $w = trim($w);
            if (!empty($w)) {
                $initials .= strtoupper($w[0]);
                $count++;
                if ($count >= 2) break;
            }
        }
        return $initials ?: strtoupper(substr($this->nama, 0, 2));
    }
}
