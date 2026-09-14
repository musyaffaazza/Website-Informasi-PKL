<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'no_hp',
        'email',
        'status_akun',
        'ttd_elektronik_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jurusanKaprog()
    {
        return $this->hasOne(Jurusan::class, 'kaprog_guru_id');
    }
}
