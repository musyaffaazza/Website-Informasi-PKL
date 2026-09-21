<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;

class GantiSiswaSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('penilaian')->truncate();
        DB::table('pembimbing_penugasan')->truncate();
        DB::table('absensi')->truncate();
        DB::table('jurnal')->truncate();
        DB::table('approval')->truncate();
        DB::table('pengajuan_pkl')->truncate();
        Siswa::truncate();
        DB::table('users')->where('tipe_akun', 'siswa')->delete();

        $tkj = DB::table('jurusan')->where('kode', 'TKJ')->first();
        if ($tkj) {
            DB::table('industri_jurusan')->where('jurusan_id', $tkj->id)->delete();
            DB::table('rombel')->where('jurusan_id', $tkj->id)->delete();
            DB::table('jurusan')->where('id', $tkj->id)->delete();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rombel = DB::table('rombel')
            ->where('nama_kode', 'XII RPL 1')
            ->first();

        if (!$rombel) {
            $rombel = DB::table('rombel')->first();
        }

        if (!$rombel) {
            throw new \RuntimeException('Tidak ada rombel untuk menempatkan siswa baru.');
        }

        $jurusan = DB::table('jurusan')->where('id', $rombel->jurusan_id)->first();

        $defaultHash = Hash::make('password123');
        $now = now();

        $siswaBaru = [
            [
                'username'       => 'aza.musyaffa',
                'email'          => 'azza.musyaffa@smkn1gunungputri.sch.id',
                'nis'            => '2026001',
                'nisn'           => '0080000001',
                'nama'           => 'Azza Musyaffa',
                'jenis_kelamin'  => 'L',
                'status_akun'    => 'aktif',
                'status_pkl'     => 'Siap Terjun',
            ],
            [
                'username'       => 'ariel.saputra',
                'email'          => 'ariel.saputra@smkn1gunungputri.sch.id',
                'nis'            => '2026002',
                'nisn'           => '0080000002',
                'nama'           => 'Ariel Saputra',
                'jenis_kelamin'  => 'L',
                'status_akun'    => 'aktif',
                'status_pkl'     => 'Siap Terjun',
            ],
            [
                'username'       => 'wahyu.ramadhan',
                'email'          => 'wahyu.ramadhan@smkn1gunungputri.sch.id',
                'nis'            => '2026003',
                'nisn'           => '0080000003',
                'nama'           => 'Wahyu Ramadhan',
                'jenis_kelamin'  => 'L',
                'status_akun'    => 'aktif',
                'status_pkl'     => 'Siap Terjun',
            ],
            [
                'username'       => 'thalita',
                'email'          => 'thalita@smkn1gunungputri.sch.id',
                'nis'            => '2026004',
                'nisn'           => '0080000004',
                'nama'           => 'Thalita',
                'jenis_kelamin'  => 'P',
                'status_akun'    => 'aktif',
                'status_pkl'     => 'Siap Terjun',
            ],
            [
                'username'       => 'putri.lestari',
                'email'          => 'putri.lestari@smkn1gunungputri.sch.id',
                'nis'            => '2026005',
                'nisn'           => '0080000005',
                'nama'           => 'Putri Lestari',
                'jenis_kelamin'  => 'P',
                'status_akun'    => 'aktif',
                'status_pkl'     => 'Siap Terjun',
            ],
        ];

        foreach ($siswaBaru as $data) {
            $userId = DB::table('users')->insertGetId([
                'username'       => $data['username'],
                'email'          => $data['email'],
                'password_hash'  => $defaultHash,
                'tipe_akun'      => 'siswa',
                'terakhir_login' => null,
                'dibuat_pada'    => $now,
            ]);

            Siswa::create([
                'user_id'       => $userId,
                'nis'           => $data['nis'],
                'nisn'          => $data['nisn'],
                'nama'          => $data['nama'],
                'rombel_id'     => $rombel->id,
                'jurusan_id'    => $jurusan->id,
                'kampus'        => 'Kampus Pusat',
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => '2009-01-01',
                'kota'          => 'Bogor',
                'no_hp'         => null,
                'email'         => $data['email'],
                'status_akun'   => $data['status_akun'],
                'status_pkl'    => $data['status_pkl'],
            ]);
        }
    }
}