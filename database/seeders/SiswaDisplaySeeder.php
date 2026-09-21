<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiswaDisplaySeeder extends Seeder
{
    public function run(): void
    {
        $this->call(GantiSiswaSeeder::class);
    }
}