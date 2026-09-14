<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('industri')->insert([
            [
                'nama' => 'PT Teknologi Nusantara',
                'alamat' => 'Jl. Sudirman No. 10, Jakarta',
                'latitude' => -6.2088000,
                'longitude' => 106.8456000,
                'radius_meter' => 100,
                'kontak_nama' => 'Budi Hartono',
                'kontak_no_hp' => '081234560001',
                'kontak_email' => 'hr@teknusantara.co.id',
                'kuota' => 10,
                'mou_url' => null,
                'mou_berlaku_sampai' => '2027-12-31',
                'status' => 'aktif',
            ],
            [
                'nama' => 'CV Digital Indonesia',
                'alamat' => 'Jl. Gatot Subroto No. 20, Jakarta',
                'latitude' => -6.2297000,
                'longitude' => 106.8272000,
                'radius_meter' => 100,
                'kontak_nama' => 'Dewi Lestari',
                'kontak_no_hp' => '081234560002',
                'kontak_email' => 'hr@digitalindo.co.id',
                'kuota' => 8,
                'mou_url' => null,
                'mou_berlaku_sampai' => '2027-12-31',
                'status' => 'aktif',
            ],
            [
                'nama' => 'PT Elektronika Jaya',
                'alamat' => 'Jl. Industri No. 15, Bekasi',
                'latitude' => -6.2383000,
                'longitude' => 106.9756000,
                'radius_meter' => 100,
                'kontak_nama' => 'Agus Setiawan',
                'kontak_no_hp' => '081234560003',
                'kontak_email' => 'hr@elektronikajaya.co.id',
                'kuota' => 12,
                'mou_url' => null,
                'mou_berlaku_sampai' => '2027-12-31',
                'status' => 'aktif',
            ],
            [
                'nama' => 'PT Kimia Sejahtera',
                'alamat' => 'Jl. Raya Bogor No. 30, Depok',
                'latitude' => -6.4025000,
                'longitude' => 106.7942000,
                'radius_meter' => 150,
                'kontak_nama' => 'Rudi Kurnia',
                'kontak_no_hp' => '081234560004',
                'kontak_email' => 'hr@kimia-sejahtera.co.id',
                'kuota' => 10,
                'mou_url' => null,
                'mou_berlaku_sampai' => '2027-12-31',
                'status' => 'aktif',
            ],
            [
                'nama' => 'PT Industri Mandiri',
                'alamat' => 'Jl. Cakung Industri No. 5, Jakarta Timur',
                'latitude' => -6.1867000,
                'longitude' => 106.9388000,
                'radius_meter' => 100,
                'kontak_nama' => 'Hendra Wijaya',
                'kontak_no_hp' => '081234560005',
                'kontak_email' => 'hr@industrimandiri.co.id',
                'kuota' => 15,
                'mou_url' => null,
                'mou_berlaku_sampai' => '2027-12-31',
                'status' => 'aktif',
            ],
        ]);
    }
}