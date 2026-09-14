<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jurusan')->insert([
            [
                'kode' => 'PPLG',
                'nama' => 'Pengembangan Perangkat Lunak dan Gim',
                'singkatan' => 'PPLG',
                'kaprog_guru_id' => null,
                'status' => 'aktif',
            ],
            [
                'kode' => 'EL',
                'nama' => 'Elektronika',
                'singkatan' => 'Elektronika',
                'kaprog_guru_id' => null,
                'status' => 'aktif',
            ],
            [
                'kode' => 'KIM',
                'nama' => 'Kimia',
                'singkatan' => 'Kimia',
                'kaprog_guru_id' => null,
                'status' => 'aktif',
            ],
            [
                'kode' => 'MES',
                'nama' => 'Pemesinan',
                'singkatan' => 'Pemesinan',
                'kaprog_guru_id' => null,
                'status' => 'aktif',
            ],
            [
                'kode' => 'LAS',
                'nama' => 'Pengelasan',
                'singkatan' => 'Pengelasan',
                'kaprog_guru_id' => null,
                'status' => 'aktif',
            ],
        ]);
    }
}