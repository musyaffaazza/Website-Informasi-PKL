<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JurusanDisplaySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $kaprogs = [
            [
                'username' => 'kaprog_rpl',
                'nama' => 'Ir. Dian Hendrawan, S.Kom., M.T.',
                'email' => 'dian.hendrawan@smkn1gunungputri.sch.id',
                'nip' => '197805122005011004',
            ],
            [
                'username' => 'kaprog_tkj',
                'nama' => 'Hendro Susanto, S.T.',
                'email' => 'hendro.susanto@smkn1gunungputri.sch.id',
                'nip' => '198004152008011007',
            ],
            [
                'username' => 'kaprog_toi',
                'nama' => 'Drs. H. Suryana, M.Pd.',
                'email' => 'suryana@smkn1gunungputri.sch.id',
                'nip' => '196803201995121001',
            ],
            [
                'username' => 'kaprog_tp',
                'nama' => 'Budi Santoso, S.Pd.',
                'email' => 'budi.santoso@smkn1gunungputri.sch.id',
                'nip' => '198207182009021003',
            ],
            [
                'username' => 'kaprog_ka',
                'nama' => 'Dra. Hj. Nurhayati, M.Pd.',
                'email' => 'nurhayati@smkn1gunungputri.sch.id',
                'nip' => '197011051998022001',
            ],
            [
                'username' => 'kaprog_tpl',
                'nama' => 'Suryadi, S.T.',
                'email' => 'suryadi@smkn1gunungputri.sch.id',
                'nip' => '198402102010011009',
            ],
        ];

        $kaprogIds = [];

        foreach ($kaprogs as $k) {
            $user = DB::table('users')->where('username', $k['username'])->first();
            if (!$user) {
                $userId = DB::table('users')->insertGetId([
                    'username' => $k['username'],
                    'email' => $k['email'],
                    'password_hash' => Hash::make('password123'),
                    'tipe_akun' => 'guru',
                    'dibuat_pada' => now(),
                ]);
            } else {
                $userId = $user->id;
            }

            $guru = DB::table('guru')->where('nip', $k['nip'])->first();
            if (!$guru) {
                $guruId = DB::table('guru')->insertGetId([
                    'user_id' => $userId,
                    'nip' => $k['nip'],
                    'nama' => $k['nama'],
                    'email' => $k['email'],
                    'no_hp' => '0812' . rand(10000000, 99999999),
                    'status_akun' => 'aktif',
                ]);
            } else {
                DB::table('guru')->where('id', $guru->id)->update([
                    'nama' => $k['nama'],
                    'email' => $k['email'],
                ]);
                $guruId = $guru->id;
            }
            $kaprogIds[$k['username']] = $guruId;
        }

        DB::table('industri_jurusan')->delete();

        $definitions = [
            1 => [
                'kode' => 'RPL',
                'nama' => 'Rekayasa Perangkat Lunak',
                'singkatan' => 'RPL',
                'bidang' => 'Teknologi Informasi',
                'akreditasi' => 'A UNGGUL',
                'kaprog_guru_id' => $kaprogIds['kaprog_rpl'],
                'kuota_industri' => 112,
                'kuota_terisi' => 108,
                'badge_color' => 'blue',
                'mitra_utama' => json_encode(['PT Telkom Akses', 'Tokopedia', 'PT Nusantara Digital']),
                'capaian_kurikulum' => 'Pengembangan Perangkat Lunak Berbasis Web, Mobile & Cloud Computing sesuai standar industri 4.0 dan SKKNI.',
                'status' => 'aktif',
            ],
            2 => [
                'kode' => 'TKJ',
                'nama' => 'Teknik Komputer & Jaringan',
                'singkatan' => 'TKJ',
                'bidang' => 'Teknologi Informasi & Komunikasi',
                'akreditasi' => 'A UNGGUL',
                'kaprog_guru_id' => $kaprogIds['kaprog_tkj'],
                'kuota_industri' => 105,
                'kuota_terisi' => 102,
                'badge_color' => 'teal',
                'mitra_utama' => json_encode(['PT Indocyber Global', 'Cybertrend', 'Lintasarta']),
                'capaian_kurikulum' => 'Administrasi Infrastruktur Jaringan, Cloud Architecture, Network Security, dan Troubleshooting Jaringan Terdistribusi.',
                'status' => 'aktif',
            ],
            3 => [
                'kode' => 'KA',
                'nama' => 'Kimia Analisis (4 Tahun)',
                'singkatan' => 'KA',
                'bidang' => 'Teknologi Kimia & Industri',
                'akreditasi' => 'A UNGGUL',
                'kaprog_guru_id' => $kaprogIds['kaprog_ka'],
                'kuota_industri' => 75,
                'kuota_terisi' => 70,
                'badge_color' => 'emerald',
                'mitra_utama' => json_encode(['PT Kalbe Farma', 'PT Indofood CBP', 'Sucofindo']),
                'capaian_kurikulum' => 'Analisis Kimia Terapan, Kontrol Kualitas Laboratorium (QC/QA), Kromatografi & Spektrofotometri Industri.',
                'status' => 'aktif',
            ],
            4 => [
                'kode' => 'TP',
                'nama' => 'Teknik Pemesinan',
                'singkatan' => 'TP',
                'bidang' => 'Teknologi & Rekayasa',
                'akreditasi' => 'A UNGGUL',
                'kaprog_guru_id' => $kaprogIds['kaprog_tp'],
                'kuota_industri' => 76,
                'kuota_terisi' => 72,
                'badge_color' => 'purple',
                'mitra_utama' => json_encode(['Astra Group', 'PT United Tractors', 'Komatsu']),
                'capaian_kurikulum' => 'Operasional Mesin Bubut, Frais Konvensional & Mesin CNC (CAM), serta Pembuatan Komponen Presisi Tinggi.',
                'status' => 'aktif',
            ],
            5 => [
                'kode' => 'TPL',
                'nama' => 'Teknik Pengelasan & Fabrikasi',
                'singkatan' => 'TPL',
                'bidang' => 'Teknologi & Rekayasa',
                'akreditasi' => 'A UNGGUL',
                'kaprog_guru_id' => $kaprogIds['kaprog_tpl'],
                'kuota_industri' => 40,
                'kuota_terisi' => 36,
                'badge_color' => 'orange',
                'mitra_utama' => json_encode(['PT PAL Indonesia', 'PT Barata Indonesia']),
                'capaian_kurikulum' => 'Teknik Las SMAW, GMAW, GTAW Posisi 1G-6G, Non-Destructive Testing (NDT), dan Fabrikasi Konstruksi Logam.',
                'status' => 'aktif',
            ],
            6 => [
                'kode' => 'TOI',
                'nama' => 'Teknik Otomasi Industri',
                'singkatan' => 'TOI',
                'bidang' => 'Rekayasa & Manufaktur',
                'akreditasi' => 'A UNGGUL',
                'kaprog_guru_id' => $kaprogIds['kaprog_toi'],
                'kuota_industri' => 80,
                'kuota_terisi' => 72,
                'badge_color' => 'amber',
                'mitra_utama' => json_encode(['PT Astra Honda Motor', 'PT Bukaka Teknik Utama']),
                'capaian_kurikulum' => 'Sistem Kontrol PLC, SCADA, Pneumatik & Hidrolik Otomasi Pabrik, serta Integrasi Robotik Manufaktur.',
                'status' => 'aktif',
            ],
        ];

        foreach ($definitions as $id => $def) {
            $exist = DB::table('jurusan')->where('id', $id)->first();
            if ($exist) {
                DB::table('jurusan')->where('id', $id)->update(array_merge($def, [
                    'updated_at' => now(),
                ]));
            } else {
                DB::table('jurusan')->insert(array_merge($def, [
                    'id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }

        // Rombels
        DB::table('rombel')->delete();
        $rombels = [
            ['nama_kode' => 'XII RPL 1', 'jurusan_id' => 1, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII RPL 2', 'jurusan_id' => 1, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII RPL 3', 'jurusan_id' => 1, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII TKJ 1', 'jurusan_id' => 2, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII TKJ 2', 'jurusan_id' => 2, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII TKJ 3', 'jurusan_id' => 2, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII TOI 1', 'jurusan_id' => 6, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII TOI 2', 'jurusan_id' => 6, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII TP 1', 'jurusan_id' => 4, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII TP 2', 'jurusan_id' => 4, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII KA 1', 'jurusan_id' => 3, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII KA 2', 'jurusan_id' => 3, 'tahun_ajaran' => '2026/2027'],
            ['nama_kode' => 'XII TPL 1', 'jurusan_id' => 5, 'tahun_ajaran' => '2026/2027'],
        ];

        foreach ($rombels as $r) {
            DB::table('rombel')->insert(array_merge($r, [
                'wali_kelas_guru_id' => null,
                'status' => 'aktif',
            ]));
        }

        // Industry partners
        $allIndustri = [
            'PT Telkom Akses' => ['RPL'],
            'Tokopedia' => ['RPL'],
            'PT Nusantara Digital' => ['RPL', 'TKJ'],
            'PT Indocyber Global' => ['TKJ'],
            'Cybertrend' => ['TKJ'],
            'Lintasarta' => ['TKJ'],
            'PT Astra Honda Motor' => ['TOI', 'TP'],
            'PT Bukaka Teknik Utama' => ['TOI', 'TPL'],
            'Astra Group' => ['TP', 'TOI'],
            'PT United Tractors' => ['TP', 'TPL'],
            'Komatsu' => ['TP'],
            'PT Kalbe Farma' => ['KA'],
            'PT Indofood CBP' => ['KA'],
            'Sucofindo' => ['KA'],
            'PT PAL Indonesia' => ['TPL'],
            'PT Barata Indonesia' => ['TPL'],
        ];

        foreach ($allIndustri as $namaInd => $majorKodes) {
            $ind = DB::table('industri')->where('nama', $namaInd)->first();
            if (!$ind) {
                $indId = DB::table('industri')->insertGetId([
                    'nama' => $namaInd,
                    'alamat' => 'Kawasan Industri Mitra SMKN 1 Gunungputri, Bogor / Jabodetabek',
                    'latitude' => -6.4500000,
                    'longitude' => 106.9000000,
                    'radius_meter' => 100,
                    'kontak_nama' => 'PIC ' . $namaInd,
                    'kontak_no_hp' => '0811' . rand(1000000, 9999999),
                    'kontak_email' => strtolower(str_replace(' ', '', $namaInd)) . '@mitra.co.id',
                    'kuota' => 15,
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $indId = $ind->id;
            }

            foreach ($majorKodes as $mk) {
                $jur = DB::table('jurusan')->where('kode', $mk)->first();
                if ($jur) {
                    $link = DB::table('industri_jurusan')
                        ->where('industri_id', $indId)
                        ->where('jurusan_id', $jur->id)
                        ->first();
                    if (!$link) {
                        DB::table('industri_jurusan')->insert([
                            'industri_id' => $indId,
                            'jurusan_id' => $jur->id,
                        ]);
                    }
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
