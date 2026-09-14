<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
    }
}