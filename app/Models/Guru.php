<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'user_id',
        'nip',
        'nuptk',
        'nama',
        'jenis_kelamin',
        'pendidikan',
        'avatar_url',
        'no_hp',
        'email',
        'status_akun',
        'roles_list',
        'kelas_diampu',
        'keterangan_diampu',
        'jurusan_id',
        'ttd_elektronik_url',
    ];

    protected function casts(): array
    {
        return [
            'roles_list' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function jurusanKaprog()
    {
        return $this->hasOne(Jurusan::class, 'kaprog_guru_id');
    }

    public function rombelWali()
    {
        return $this->hasOne(Rombel::class, 'wali_kelas_guru_id');
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', preg_replace('/[^a-zA-Z\s]/', '', $this->nama));
        $initials = '';
        $count = 0;
        foreach ($words as $w) {
            $w = trim($w);
            if (!empty($w) && !in_array(strtolower($w), ['ir', 'drs', 'dra', 'h', 'hj', 'st', 'mpd', 'spd', 'mkom', 'skom', 'ssi', 'mt'])) {
                $initials .= strtoupper($w[0]);
                $count++;
                if ($count >= 2) break;
            }
        }
        return $initials ?: strtoupper(substr($this->nama, 0, 2));
    }
}
