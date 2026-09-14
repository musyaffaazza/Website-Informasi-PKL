<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengajuanPklSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = DB::table('siswa')->get();
        $industri = DB::table('industri')->get();

        foreach ($siswa as $index => $data) {
            DB::table('pengajuan_pkl')->insert([
                'siswa_id' => $data->id,
                'industri_id' => $industri[$index % $industri->count()]->id,
                'tanggal_mulai' => '2027-01-01',
                'tanggal_selesai' => '2027-03-31',
                'dokumen_url' => null,
                'status' => 'disetujui',
                'dibuat_pada' => now(),
            ]);
        }
    }
}