<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(GuruRplSeeder::class);
    }
}