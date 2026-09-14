<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RombelSeeder extends Seeder
{
    public function run(): void
    {
        $pplg = DB::table('jurusan')
            ->where('kode', 'PPLG')
            ->first();

        $elektronika = DB::table('jurusan')
            ->where('kode', 'EL')
            ->first();

        $kimia = DB::table('jurusan')
            ->where('kode', 'KIM')
            ->first();

        $pemesinan = DB::table('jurusan')
            ->where('kode', 'MES')
            ->first();

        $pengelasan = DB::table('jurusan')
            ->where('kode', 'LAS')
            ->first();

        DB::table('rombel')->insert([
            [
                'nama_kode' => 'XI PPLG 1',
                'jurusan_id' => $pplg->id,
                'wali_kelas_guru_id' => null,
                'tahun_ajaran' => '2026/2027',
                'status' => 'aktif',
            ],
            [
                'nama_kode' => 'XI Elektronika 1',
                'jurusan_id' => $elektronika->id,
                'wali_kelas_guru_id' => null,
                'tahun_ajaran' => '2026/2027',
                'status' => 'aktif',
            ],
            [
                'nama_kode' => 'XI Kimia 1',
                'jurusan_id' => $kimia->id,
                'wali_kelas_guru_id' => null,
                'tahun_ajaran' => '2026/2027',
                'status' => 'aktif',
            ],
            [
                'nama_kode' => 'XI Pemesinan 1',
                'jurusan_id' => $pemesinan->id,
                'wali_kelas_guru_id' => null,
                'tahun_ajaran' => '2026/2027',
                'status' => 'aktif',
            ],
            [
                'nama_kode' => 'XI Pengelasan 1',
                'jurusan_id' => $pengelasan->id,
                'wali_kelas_guru_id' => null,
                'tahun_ajaran' => '2026/2027',
                'status' => 'aktif',
            ],
        ]);
    }
}