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
                'username' => 'kaprog_tei',
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
                'username' => 'kaprog_ki',
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

        $definitions = [
            1 => [
                'kode' => 'RPL',
                'nama' => 'Rekayasa Perangkat Lunak',
                'singkatan' => 'RPL',
                'bidang' => 'Teknologi Informasi',
                'kaprog_guru_id' => $kaprogIds['kaprog_rpl'] ?? null,
                'kuota_industri' => 0,
                'kuota_terisi' => 0,
                'badge_color' => 'blue',
                'mitra_utama' => json_encode([]),
                'capaian_kurikulum' => 'Pengembangan Perangkat Lunak Berbasis Web, Mobile & Cloud Computing sesuai standar industri 4.0 dan SKKNI.',
                'status' => 'aktif',
            ],
            3 => [
                'kode' => 'KI',
                'nama' => 'Kimia Industri',
                'singkatan' => 'KI',
                'bidang' => 'Teknologi Kimia & Industri',
                'kaprog_guru_id' => $kaprogIds['kaprog_ki'] ?? null,
                'kuota_industri' => 0,
                'kuota_terisi' => 0,
                'badge_color' => 'emerald',
                'mitra_utama' => json_encode([]),
                'capaian_kurikulum' => 'Analisis Kimia Terapan, Kontrol Kualitas Laboratorium (QC/QA), Kromatografi & Spektrofotometri Industri.',
                'status' => 'aktif',
            ],
            4 => [
                'kode' => 'TP',
                'nama' => 'Teknik Pemesinan',
                'singkatan' => 'TP',
                'bidang' => 'Teknologi & Rekayasa',
                'kaprog_guru_id' => $kaprogIds['kaprog_tp'] ?? null,
                'kuota_industri' => 0,
                'kuota_terisi' => 0,
                'badge_color' => 'red',
                'mitra_utama' => json_encode([]),
                'capaian_kurikulum' => 'Operasional Mesin Bubut, Frais Konvensional & Mesin CNC (CAM), serta Pembuatan Komponen Presisi Tinggi.',
                'status' => 'aktif',
            ],
            5 => [
                'kode' => 'TPL',
                'nama' => 'Teknik Pengelasan & Fabrikasi',
                'singkatan' => 'TPL',
                'bidang' => 'Teknologi & Rekayasa',
                'kaprog_guru_id' => $kaprogIds['kaprog_tpl'] ?? null,
                'kuota_industri' => 0,
                'kuota_terisi' => 0,
                'badge_color' => 'gray',
                'mitra_utama' => json_encode([]),
                'capaian_kurikulum' => 'Teknik Las SMAW, GMAW, GTAW Posisi 1G-6G, Non-Destructive Testing (NDT), dan Fabrikasi Konstruksi Logam.',
                'status' => 'aktif',
            ],
            6 => [
                'kode' => 'TEI',
                'nama' => 'Teknik Elektronika Industri',
                'singkatan' => 'TEI',
                'bidang' => 'Rekayasa & Manufaktur',
                'kaprog_guru_id' => $kaprogIds['kaprog_tei'] ?? null,
                'kuota_industri' => 0,
                'kuota_terisi' => 0,
                'badge_color' => 'white',
                'mitra_utama' => json_encode([]),
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

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}