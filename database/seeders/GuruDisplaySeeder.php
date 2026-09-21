<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GuruDisplaySeeder extends Seeder
{
    public function run(): void
    {
        $this->call(GuruRplSeeder::class);
    }
}