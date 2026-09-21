<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Guru;

class IndustriDisplaySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Industri::truncate();
        DB::table('industri_jurusan')->truncate();

        // Get Jurusans
        $rpl = Jurusan::where('kode', 'RPL')->first();
        $tkj = Jurusan::where('kode', 'TKJ')->first();
        $toi = Jurusan::where('kode', 'TOI')->first();
        $tp  = Jurusan::where('kode', 'TP')->first();
        $ka  = Jurusan::where('kode', 'KA')->first();
        $tpl = Jurusan::where('kode', 'TPL')->first();

        // 4 Featured Companies from Screenshot
        $featured = [
            [
                'nama' => 'PT Nusantara Digital',
                'bidang_usaha' => 'Software House & Cloud',
                'no_mou' => '421.5/MOU-DUDI/SMKELL/2024/014',
                'mou_berlaku_sampai' => '2027-12-31',
                'alamat' => 'Kawasan Industri Sentul, Jl. Babakan Madang No. 88, Kab. Bogor, Jawa Barat 16810',
                'wilayah' => 'Bogor',
                'kontak_nama' => 'Hendra Gunawan, S.T.',
                'kontak_jabatan' => 'Head of Engineering / Mentor DUDI',
                'kontak_no_hp' => '+62 812-3456-7890',
                'kontak_email' => 'internship@nusantaradigital.id',
                'pembimbing_nama' => 'Ir. Dian Hendrawan, S.Kom., M.T. (RPL)',
                'kuota' => 6,
                'kuota_terisi' => 4,
                'status' => 'aktif',
                'status_kemitraan' => 'aktif',
                'jurusans' => [$rpl?->id],
            ],
            [
                'nama' => 'PT Astra Honda Motor',
                'bidang_usaha' => 'Otomotif & Manufaktur',
                'no_mou' => '421.5/MOU-DUDI/SMKELL/2023/008',
                'mou_berlaku_sampai' => '2026-12-31',
                'alamat' => 'Kawasan Industri MM2100, Cikarang Barat, Kab. Bekasi, Jawa Barat 17530',
                'wilayah' => 'Bekasi',
                'kontak_nama' => 'Bambang Triyono, S.T.',
                'kontak_jabatan' => 'Supervisor Assembly Line & Trainer',
                'kontak_no_hp' => '+62 813-8901-2345',
                'kontak_email' => 'hrd.vocational@astra-honda.com',
                'pembimbing_nama' => 'Drs. Mulyadi, M.Pd. (Teknik Pemesinan & TOI)',
                'kuota' => 10,
                'kuota_terisi' => 10,
                'status' => 'aktif',
                'status_kemitraan' => 'penuh',
                'jurusans' => [$tp?->id, $toi?->id],
            ],
            [
                'nama' => 'PT Telkom Akses (Witel Bogor)',
                'bidang_usaha' => 'Telekomunikasi & Jaringan',
                'no_mou' => '421.5/MOU-DUDI/SMKELL/2024/002',
                'mou_berlaku_sampai' => '2027-12-31',
                'alamat' => 'Jl. Pajajaran No. 37, Sukasari, Kota Bogor, Jawa Barat 16143',
                'wilayah' => 'Bogor',
                'kontak_nama' => 'Rian Pratama, S.T.',
                'kontak_jabatan' => 'Fiber Optic Maintenance Manager',
                'kontak_no_hp' => '+62 821-1122-3344',
                'kontak_email' => 'pkl.bogor@telkomakses.co.id',
                'pembimbing_nama' => 'Ahmad Fauzi, S.Pd., Gr. (TKJ)',
                'kuota' => 8,
                'kuota_terisi' => 5,
                'status' => 'aktif',
                'status_kemitraan' => 'aktif',
                'jurusans' => [$tkj?->id],
            ],
            [
                'nama' => 'PT Indocyber Global Teknologi',
                'bidang_usaha' => 'IT Consulting & Cyber',
                'no_mou' => '421.5/MOU-DUDI/SMKELL/2024/019',
                'mou_berlaku_sampai' => '2027-12-31',
                'alamat' => 'APL Tower Lt. 19, Jl. Letjen S. Parman Kav. 28, Jakarta Barat 11470',
                'wilayah' => 'Jakarta',
                'kontak_nama' => 'Clarissa Amanda, S.Kom.',
                'kontak_jabatan' => 'Senior Talent Acquisition Partner',
                'kontak_no_hp' => '+62 21-5698-3321',
                'kontak_email' => 'campus@indocyber.co.id',
                'pembimbing_nama' => 'Siti Nurhaliza, M.Kom. (RPL)',
                'kuota' => 4,
                'kuota_terisi' => 3,
                'status' => 'aktif',
                'status_kemitraan' => 'aktif',
                'jurusans' => [$rpl?->id],
            ],
        ];

        foreach ($featured as $data) {
            $jIds = $data['jurusans'];
            unset($data['jurusans']);
            $item = Industri::create($data);
            if (!empty($jIds)) {
                $item->jurusans()->sync(array_filter($jIds));
            }
        }

        // Remaining Companies up to EXACTLY 48 DU/DI
        // Targets:
        // - Total Kuota Bimbingan = 216 Siswa
        // - Total Kuota Terisi = 181 Siswa (181 / 216 = 83.8% => 84%)
        // - Mitra Kuota Penuh = 18 Industri (Card 2 is penuh -> need 17 more)
        // - Kemitraan Baru = 6 Mitra
        // - Perlu Evaluasi = 4 Mitra
        // - Aktif Tersedia = 30 Industri

        $industriesList = [
            ['nama' => 'PT Komatsu Indonesia', 'bidang' => 'Teknik Pemesinan & Fabrikasi', 'wilayah' => 'Jakarta', 'kuota' => 6, 'terisi' => 6, 'status' => 'penuh', 'jur' => [$tp?->id, $tpl?->id], 'pem' => 'Ir. Joko Waskito (TP)'],
            ['nama' => 'PT Schneider Electric Manufacturing', 'bidang' => 'Otomasi Industri & Elektronika', 'wilayah' => 'Bekasi', 'kuota' => 6, 'terisi' => 6, 'status' => 'penuh', 'jur' => [$toi?->id], 'pem' => 'Mulyadi, M.Pd. (TOI)'],
            ['nama' => 'PT Sucofindo (Persero)', 'bidang' => 'Laboratorium Kimia Analisis', 'wilayah' => 'Bogor', 'kuota' => 4, 'terisi' => 4, 'status' => 'penuh', 'jur' => [$ka?->id], 'pem' => 'Dra. Hj. Nurhayati, M.Pd. (KA)'],
            ['nama' => 'PT Paragon Technology and Innovation', 'bidang' => 'Industri Kimia & Kosmetik', 'wilayah' => 'Jakarta', 'kuota' => 5, 'terisi' => 5, 'status' => 'penuh', 'jur' => [$ka?->id], 'pem' => 'Dra. Hj. Nurhayati, M.Pd. (KA)'],
            ['nama' => 'PT Toyota Motor Manufacturing Indonesia', 'bidang' => 'Otomotif & Manufaktur', 'wilayah' => 'Karawang', 'kuota' => 8, 'terisi' => 8, 'status' => 'penuh', 'jur' => [$tp?->id, $toi?->id], 'pem' => 'Budi Santoso, S.Pd. (TP)'],
            ['nama' => 'PT Bukalapak.com Tbk', 'bidang' => 'Software House & E-Commerce', 'wilayah' => 'Jakarta', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$rpl?->id], 'pem' => 'Ir. Dian Hendrawan, S.Kom., M.T. (RPL)'],
            ['nama' => 'PT Indosat Ooredoo Hutchison', 'bidang' => 'Telekomunikasi & Jaringan', 'wilayah' => 'Jakarta', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tkj?->id], 'pem' => 'Hendro Susanto, S.T. (TKJ)'],
            ['nama' => 'PT Surya Toto Indonesia Tbk', 'bidang' => 'Teknik Fabrikasi & Pemesinan', 'wilayah' => 'Bogor', 'kuota' => 5, 'terisi' => 5, 'status' => 'penuh', 'jur' => [$tpl?->id, $tp?->id], 'pem' => 'Suryadi, S.T. (TPL)'],
            ['nama' => 'PT Panasonic Manufacturing Indonesia', 'bidang' => 'Elektronika & Otomasi Industri', 'wilayah' => 'Jakarta', 'kuota' => 6, 'terisi' => 5, 'status' => 'aktif', 'jur' => [$toi?->id], 'pem' => 'Drs. H. Suryana, M.Pd. (TOI)'],
            ['nama' => 'PT United Tractors Tbk', 'bidang' => 'Alat Berat & Pemesinan', 'wilayah' => 'Jakarta', 'kuota' => 5, 'terisi' => 5, 'status' => 'penuh', 'jur' => [$tp?->id], 'pem' => 'Budi Santoso, S.Pd. (TP)'],
            ['nama' => 'PT Dexa Medica', 'bidang' => 'Farmasi & Kimia Analisis', 'wilayah' => 'Bogor', 'kuota' => 4, 'terisi' => 4, 'status' => 'penuh', 'jur' => [$ka?->id], 'pem' => 'Dra. Hj. Nurhayati, M.Pd. (KA)'],
            ['nama' => 'PT Kalbe Farma Tbk', 'bidang' => 'Farmasi & Kimia Analisis', 'wilayah' => 'Bekasi', 'kuota' => 5, 'terisi' => 5, 'status' => 'penuh', 'jur' => [$ka?->id], 'pem' => 'Dra. Hj. Nurhayati, M.Pd. (KA)'],
            ['nama' => 'PT Bank Mandiri (Persero) Tbk - IT Center', 'bidang' => 'Financial Technology & IT Support', 'wilayah' => 'Jakarta', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$rpl?->id, $tkj?->id], 'pem' => 'Ahmad Fauzi, S.Pd., M.Kom. (RPL)'],
            ['nama' => 'PT XL Axiata Tbk', 'bidang' => 'Telekomunikasi & Cloud Computing', 'wilayah' => 'Jakarta', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tkj?->id], 'pem' => 'Hendro Susanto, S.T. (TKJ)'],
            ['nama' => 'PT Astra Otoparts Tbk', 'bidang' => 'Manufaktur Komponen Otomotif', 'wilayah' => 'Bogor', 'kuota' => 6, 'terisi' => 6, 'status' => 'penuh', 'jur' => [$tp?->id, $toi?->id], 'pem' => 'Drs. Bambang Wijaya, M.Pd. (TP)'],
            ['nama' => 'PT Siemens Indonesia', 'bidang' => 'Otomasi Industri & Power Grid', 'wilayah' => 'Jakarta', 'kuota' => 4, 'terisi' => 4, 'status' => 'penuh', 'jur' => [$toi?->id], 'pem' => 'Drs. H. Suryana, M.Pd. (TOI)'],
            ['nama' => 'PT LG Electronics Indonesia', 'bidang' => 'Manufaktur Elektronika', 'wilayah' => 'Bekasi', 'kuota' => 5, 'terisi' => 5, 'status' => 'penuh', 'jur' => [$toi?->id], 'pem' => 'Mulyadi, M.Pd. (TOI)'],
            ['nama' => 'PT Tokopedia (GoTo Group)', 'bidang' => 'IT Software & Mobile Apps', 'wilayah' => 'Jakarta', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$rpl?->id], 'pem' => 'Ir. Dian Hendrawan, S.Kom., M.T. (RPL)'],
            ['nama' => 'PT Shopee International Indonesia', 'bidang' => 'E-Commerce & Logistik IT', 'wilayah' => 'Jakarta', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$rpl?->id], 'pem' => 'Rina Marlina, S.T. (RPL)'],
            ['nama' => 'PT Cybertrend Intrabuana', 'bidang' => 'Data Science & Cyber Security', 'wilayah' => 'Jakarta', 'kuota' => 3, 'terisi' => 2, 'status' => 'aktif', 'jur' => [$rpl?->id, $tkj?->id], 'pem' => 'Siti Rahmawati, S.Kom. (RPL)'],
            ['nama' => 'PT Lintasarta', 'bidang' => 'Network Infrastructure & ISP', 'wilayah' => 'Jakarta', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tkj?->id], 'pem' => 'Hendro Susanto, S.T. (TKJ)'],
            ['nama' => 'PT Enkei Indonesia', 'bidang' => 'Pengecoran & Pemesinan Velg', 'wilayah' => 'Bekasi', 'kuota' => 5, 'terisi' => 5, 'status' => 'penuh', 'jur' => [$tp?->id], 'pem' => 'Budi Santoso, S.Pd. (TP)'],
            ['nama' => 'PT Showa Indonesia Manufacturing', 'bidang' => 'Komponen Peredam Kejut', 'wilayah' => 'Bekasi', 'kuota' => 5, 'terisi' => 5, 'status' => 'penuh', 'jur' => [$tp?->id], 'pem' => 'Ir. Joko Waskito (TP)'],
            ['nama' => 'PT Yamaha Motor Parts Manufacturing Indonesia', 'bidang' => 'Manufaktur Presisi Logam', 'wilayah' => 'Karawang', 'kuota' => 6, 'terisi' => 6, 'status' => 'penuh', 'jur' => [$tp?->id, $tpl?->id], 'pem' => 'Suryadi, S.T. (TPL)'],
            ['nama' => 'PT Pupuk Kujang (Persero)', 'bidang' => 'Industri Kimia Petrokimia', 'wilayah' => 'Karawang', 'kuota' => 4, 'terisi' => 4, 'status' => 'penuh', 'jur' => [$ka?->id], 'pem' => 'Dra. Hj. Nurhayati, M.Pd. (KA)'],
            ['nama' => 'PT BASF Indonesia', 'bidang' => 'Bahan Kimia Khusus & Analisis', 'wilayah' => 'Bekasi', 'kuota' => 4, 'terisi' => 4, 'status' => 'penuh', 'jur' => [$ka?->id], 'pem' => 'Dra. Hj. Nurhayati, M.Pd. (KA)'],
            ['nama' => 'PT Unilever Indonesia Tbk', 'bidang' => 'Consumer Goods & Quality Assurance', 'wilayah' => 'Bekasi', 'kuota' => 4, 'terisi' => 4, 'status' => 'penuh', 'jur' => [$ka?->id, $toi?->id], 'pem' => 'Drs. H. Suryana, M.Pd. (TOI)'],
            ['nama' => 'PT Bukaka Teknik Utama Tbk', 'bidang' => 'Konstruksi & Fabrikasi Logam', 'wilayah' => 'Bogor', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tpl?->id], 'pem' => 'Suryadi, S.T. (TPL)'],
            ['nama' => 'PT Citra Tubindo Tbk', 'bidang' => 'Pipa Baja & Fabrikasi Minyak', 'wilayah' => 'Jakarta', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tpl?->id], 'pem' => 'Suryadi, S.T. (TPL)'],
            ['nama' => 'PT Barata Indonesia (Persero)', 'bidang' => 'Manufaktur Alat Berat & Pabrikasi', 'wilayah' => 'Bekasi', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tpl?->id, $tp?->id], 'pem' => 'Budi Santoso, S.Pd. (TP)'],
            ['nama' => 'PT Omron Manufacturing of Indonesia', 'bidang' => 'Komponen Otomasi & Sensor', 'wilayah' => 'Bekasi', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$toi?->id], 'pem' => 'Mulyadi, M.Pd. (TOI)'],
            ['nama' => 'PT Meiji Indonesian Pharmaceutical', 'bidang' => 'Laboratorium Farmasi & Kimia', 'wilayah' => 'Depok', 'kuota' => 3, 'terisi' => 2, 'status' => 'aktif', 'jur' => [$ka?->id], 'pem' => 'Dra. Hj. Nurhayati, M.Pd. (KA)'],
            ['nama' => 'PT Kimia Farma (Persero) Tbk', 'bidang' => 'Pengujian Kimia Farmasi', 'wilayah' => 'Depok', 'kuota' => 3, 'terisi' => 2, 'status' => 'aktif', 'jur' => [$ka?->id], 'pem' => 'Dra. Hj. Nurhayati, M.Pd. (KA)'],
            ['nama' => 'PT Biznet Networks', 'bidang' => 'Fiber Optic & Data Center', 'wilayah' => 'Bogor', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tkj?->id], 'pem' => 'Hendro Susanto, S.T. (TKJ)'],
            ['nama' => 'PT First Media Tbk', 'bidang' => 'Broadband Network & Troubleshooting', 'wilayah' => 'Jakarta', 'kuota' => 3, 'terisi' => 2, 'status' => 'aktif', 'jur' => [$tkj?->id], 'pem' => 'Nurhayati, M.Pd. (TKJ)'],
            ['nama' => 'PT Jatis Mobile', 'bidang' => 'Digital Messaging & Software', 'wilayah' => 'Jakarta', 'kuota' => 3, 'terisi' => 2, 'status' => 'aktif', 'jur' => [$rpl?->id], 'pem' => 'Ahmad Fauzi, S.Pd., M.Kom. (RPL)'],
            ['nama' => 'PT Walden Global Services (WGS)', 'bidang' => 'Software Enterprise Development', 'wilayah' => 'Depok', 'kuota' => 3, 'terisi' => 2, 'status' => 'aktif', 'jur' => [$rpl?->id], 'pem' => 'Siti Rahmawati, S.Kom. (RPL)'],
            ['nama' => 'PT Denso Indonesia', 'bidang' => 'Komponen Elektronik & Radiator', 'wilayah' => 'Bekasi', 'kuota' => 5, 'terisi' => 4, 'status' => 'aktif', 'jur' => [$tp?->id, $toi?->id], 'pem' => 'Drs. Bambang Wijaya, M.Pd. (TP)'],
            ['nama' => 'PT Hitachi Astemo Bekasi Auto Parts', 'bidang' => 'Sistem Pengereman Otomotif', 'wilayah' => 'Bekasi', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tp?->id], 'pem' => 'Budi Santoso, S.Pd. (TP)'],
            ['nama' => 'PT Bridgestone Tire Indonesia', 'bidang' => 'Pemesinan Mesin Cetak Ban', 'wilayah' => 'Karawang', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tp?->id], 'pem' => 'Ir. Joko Waskito (TP)'],
            ['nama' => 'PT Gajah Tunggal Tbk', 'bidang' => 'Teknik Pengelasan & Maintenance', 'wilayah' => 'Karawang', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tpl?->id], 'pem' => 'Suryadi, S.T. (TPL)'],
            ['nama' => 'PT Krakatau Posco', 'bidang' => 'Metalurgi & Pengelasan Busur Listrik', 'wilayah' => 'Bekasi', 'kuota' => 4, 'terisi' => 3, 'status' => 'aktif', 'jur' => [$tpl?->id], 'pem' => 'Suryadi, S.T. (TPL)'],
            ['nama' => 'PT Bank Central Asia Tbk - Halo BCA Tech', 'bidang' => 'Infrastruktur Jaringan & Server', 'wilayah' => 'Bogor', 'kuota' => 3, 'terisi' => 2, 'status' => 'aktif', 'jur' => [$tkj?->id], 'pem' => 'Hendro Susanto, S.T. (TKJ)'],
            ['nama' => 'PT NTT Indonesia Technology', 'bidang' => 'Cloud & Enterprise Network', 'wilayah' => 'Jakarta', 'kuota' => 3, 'terisi' => 2, 'status' => 'aktif', 'jur' => [$tkj?->id], 'pem' => 'Nurhayati, M.Pd. (TKJ)'],
        ];

        $idx = 4;
        foreach ($industriesList as $ind) {
            $idx++;
            $mouEnd = ($idx <= 10) ? '2025-06-30' : '2027-12-31';
            $noMou = '421.5/MOU-DUDI/SMKELL/' . rand(2023, 2024) . '/' . str_pad($idx, 3, '0', STR_PAD_LEFT);
            
            // Mark some as 'baru' (Kemitraan Baru = 6)
            $isBaru = ($idx >= 43 && $idx <= 48);
            $statusKemitraan = $ind['status'];
            if ($isBaru) {
                $statusKemitraan = 'baru';
            } elseif ($idx == 41 || $idx == 42 || $idx == 39 || $idx == 40) {
                // Perlu evaluasi = 4
                $statusKemitraan = 'perlu_evaluasi';
            }

            $item = Industri::create([
                'nama' => $ind['nama'],
                'bidang_usaha' => $ind['bidang'],
                'alamat' => 'Kawasan Industri ' . $ind['wilayah'] . ', Jl. Mitra Utama No. ' . rand(1, 99) . ', ' . $ind['wilayah'] . ', Jawa Barat',
                'wilayah' => $ind['wilayah'],
                'no_mou' => $noMou,
                'mou_berlaku_sampai' => $mouEnd,
                'kontak_nama' => 'Bpk. ' . ['Suharyo', 'Darmawan', 'Yulianto', 'Wahyudi', 'Setiawan'][$idx % 5] . ', S.T.',
                'kontak_jabatan' => ['HRD & Training Coordinator', 'Operations Manager', 'Technical Supervisor', 'Talent Acquisition'][$idx % 4],
                'kontak_no_hp' => '+62 8' . rand(11, 99) . '-' . rand(1000, 9999) . '-' . str_pad(rand(100, 9999), 4, '0', STR_PAD_LEFT),
                'kontak_email' => 'hrd@' . strtolower(preg_replace('/[^a-zA-Z]/', '', explode(' ', $ind['nama'])[1] ?? 'company')) . '.co.id',
                'pembimbing_nama' => $ind['pem'],
                'kuota' => $ind['kuota'],
                'kuota_terisi' => $ind['terisi'],
                'status' => 'aktif',
                'status_kemitraan' => $statusKemitraan,
            ]);

            if (!empty($ind['jur'])) {
                $item->jurusans()->sync(array_filter($ind['jur']));
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
