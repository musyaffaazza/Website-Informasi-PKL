<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $rombels = DB::table('rombel')->get();

        $siswa = [
            [
                'username' => 'siswa001',
                'email' => 'ahmad@siswa.sch.id',
                'nis' => '10231',
                'nisn' => '0061234501',
                'nama' => 'Ahmad Fauzan',
                'jenis_kelamin' => 'L',
            ],
            [
                'username' => 'siswa002',
                'email' => 'rizky@siswa.sch.id',
                'nis' => '10232',
                'nisn' => '0061234502',
                'nama' => 'Rizky Ramadhan',
                'jenis_kelamin' => 'L',
            ],
            [
                'username' => 'siswa003',
                'email' => 'siti@siswa.sch.id',
                'nis' => '10233',
                'nisn' => '0061234503',
                'nama' => 'Siti Aisyah',
                'jenis_kelamin' => 'P',
            ],
            [
                'username' => 'siswa004',
                'email' => 'fajar@siswa.sch.id',
                'nis' => '10234',
                'nisn' => '0061234504',
                'nama' => 'Fajar Maulana',
                'jenis_kelamin' => 'L',
            ],
            [
                'username' => 'siswa005',
                'email' => 'nabila@siswa.sch.id',
                'nis' => '10235',
                'nisn' => '0061234505',
                'nama' => 'Nabila Putri',
                'jenis_kelamin' => 'P',
            ],
        ];

        foreach ($siswa as $index => $data) {
            $userId = DB::table('users')->insertGetId([
                'username' => $data['username'],
                'email' => $data['email'],
                'password_hash' => Hash::make('password123'),
                'tipe_akun' => 'siswa',
                'terakhir_login' => null,
                'dibuat_pada' => now(),
            ]);

            $rombel = $rombels[$index % $rombels->count()];

            DB::table('siswa')->insert([
                'user_id' => $userId,
                'nis' => $data['nis'],
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'rombel_id' => $rombel->id,
                'jurusan_id' => $rombel->jurusan_id,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => '2009-01-01',
                'no_hp' => '0812345680' . ($index + 1),
                'email' => $data['email'],
                'nama_ortu' => 'Orang Tua ' . $data['nama'],
                'kontak_darurat' => '0812987654' . ($index + 1),
                'foto_url' => null,
                'status_akun' => 'aktif',
            ]);
        }
    }
}