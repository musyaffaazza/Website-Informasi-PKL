<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(GantiSiswaSeeder::class);
    }
}