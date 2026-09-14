<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guruData = [
            [
                'username' => 'guru001',
                'email' => 'budi@guru.sch.id',
                'nama' => 'Budi Santoso',
                'nip' => '198501012010011001',
                'no_hp' => '081234567801',
                'role' => 'Pembimbing',
            ],
            [
                'username' => 'guru002',
                'email' => 'siti@guru.sch.id',
                'nama' => 'Siti Rahma',
                'nip' => '198602022011012002',
                'no_hp' => '081234567802',
                'role' => 'Pembimbing',
            ],
            [
                'username' => 'guru003',
                'email' => 'andi@guru.sch.id',
                'nama' => 'Andi Wijaya',
                'nip' => '198703032012011003',
                'no_hp' => '081234567803',
                'role' => 'Kaprog',
            ],
            [
                'username' => 'guru004',
                'email' => 'rina@guru.sch.id',
                'nama' => 'Rina Marlina',
                'nip' => '198804042013012004',
                'no_hp' => '081234567804',
                'role' => 'WaliKelas',
            ],
            [
                'username' => 'guru005',
                'email' => 'dedi@guru.sch.id',
                'nama' => 'Dedi Kurniawan',
                'nip' => '198905052014011005',
                'no_hp' => '081234567805',
                'role' => 'Pembimbing',
            ],
        ];

        foreach ($guruData as $data) {
            $userId = DB::table('users')->insertGetId([
                'username' => $data['username'],
                'email' => $data['email'],
                'password_hash' => Hash::make('password123'),
                'tipe_akun' => 'guru',
                'terakhir_login' => null,
                'dibuat_pada' => now(),
            ]);

            DB::table('guru')->insert([
                'user_id' => $userId,
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'no_hp' => $data['no_hp'],
                'email' => $data['email'],
                'status_akun' => 'aktif',
                'ttd_elektronik_url' => null,
            ]);
        }
    }
}