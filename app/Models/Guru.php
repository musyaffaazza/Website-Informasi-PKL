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

    /**
     * Synchronize roles_list, kelas_diampu, and keterangan_diampu based on
     * actual Rombel (Wali Kelas) and Jurusan (Kaprog) relationships.
     */
    public function syncAssignments(bool $save = true): self
    {
        $roles = is_array($this->roles_list) ? $this->roles_list : [];

        // 1. Clean up & normalize existing roles
        $roles = array_values(array_filter($roles, function ($role) {
            $trimmed = trim((string) $role);
            if (empty($trimmed)) return false;
            if ($trimmed === 'Pembimbing') return false; // will be normalized to 'Pembimbing PKL'
            if (str_starts_with($trimmed, 'Wali Kelas ') && $trimmed !== 'Wali Kelas') return false;
            if ((str_starts_with($trimmed, 'Kepala Program') || str_starts_with($trimmed, 'Kaprog ')) && $trimmed !== 'Kaprog') return false;
            return true;
        }));

        // Normalize Pembimbing to Pembimbing PKL
        if (in_array('Pembimbing', (array)$this->roles_list) && !in_array('Pembimbing PKL', $roles)) {
            $roles[] = 'Pembimbing PKL';
        }

        // 2. Check Wali Kelas assignment from Rombel
        $rombel = Rombel::where('wali_kelas_guru_id', $this->id)->first();
        if ($rombel) {
            if (!in_array('Wali Kelas', $roles)) {
                $roles[] = 'Wali Kelas';
            }
            $rombelNama = $rombel->nama_rombel ?: ($rombel->nama_kode ?: $rombel->kode_rombel);
            $this->kelas_diampu = $rombelNama;
            $this->keterangan_diampu = 'Wali Kelas ' . $rombelNama;

            if ($rombel->jurusan_id && !$this->jurusan_id) {
                $this->jurusan_id = $rombel->jurusan_id;
            }
        }

        // 3. Check Kaprog assignment from Jurusan
        $jurusanKaprog = Jurusan::where('kaprog_guru_id', $this->id)->first();
        if ($jurusanKaprog) {
            if (!in_array('Kaprog', $roles)) {
                $roles[] = 'Kaprog';
            }
            if (!$rombel) {
                $this->kelas_diampu = $jurusanKaprog->nama;
                $this->keterangan_diampu = 'Kepala Program Keahlian ' . $jurusanKaprog->nama;
            }
            $this->jurusan_id = $jurusanKaprog->id;
        }

        // 4. Update kelas_diampu / keterangan_diampu based on active roles
        if (!$rombel && !$jurusanKaprog) {
            if (in_array('Pembimbing PKL', $roles)) {
                $this->kelas_diampu = 'Pembimbing PKL Industri';
                $this->keterangan_diampu = 'Guru Pembimbing PKL DUDI';
            } else {
                $this->kelas_diampu = null;
                $this->keterangan_diampu = null;
            }
        }

        $this->roles_list = array_values(array_unique(array_filter($roles)));

        if ($save) {
            $this->saveQuietly();
        }

        return $this;
    }

    public static function syncAllAssignments(): void
    {
        foreach (static::all() as $guru) {
            $guru->syncAssignments(true);
        }
    }
}
