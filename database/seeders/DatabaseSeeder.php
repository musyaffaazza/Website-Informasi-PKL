<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            JurusanSeeder::class,
            GuruSeeder::class,
            RombelSeeder::class,
            SiswaSeeder::class,
            IndustriSeeder::class,
            PengajuanPklSeeder::class,
            PembimbingPenugasanSeeder::class,
        ]);

        if (!DB::table('users')->where('username', 'admin')->exists()) {
            DB::table('users')->insert([
                'username' => 'admin',
                'email' => 'admin@smkn1gunungputri.sch.id',
                'password_hash' => Hash::make('admin123'),
                'tipe_akun' => 'guru',
                'terakhir_login' => null,
                'dibuat_pada' => now(),
            ]);
        }
    }
}
