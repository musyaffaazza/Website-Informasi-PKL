<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembimbingPenugasanSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = DB::table('siswa')->get();
        $pengajuan = DB::table('pengajuan_pkl')->get();

        $guru = DB::table('guru')->get();

        foreach ($siswa as $index => $data) {
            DB::table('pembimbing_penugasan')->insert([
                'siswa_id' => $data->id,
                'pengajuan_id' => $pengajuan[$index]->id,
                'pembimbing_guru_id' => $guru[$index % $guru->count()]->id,
                'tanggal_mulai' => '2027-01-01',
            ]);
        }
    }
}