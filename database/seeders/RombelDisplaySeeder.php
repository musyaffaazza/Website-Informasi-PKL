<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Jurusan;
use App\Models\Guru;
use App\Models\Rombel;

class RombelDisplaySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Jurusan exists
        $jurusanDefs = [
            'RPL' => ['nama' => 'Rekayasa Perangkat Lunak', 'singkatan' => 'RPL', 'bidang' => 'Teknologi Informasi'],
            'TKJ' => ['nama' => 'Teknik Komputer & Jaringan', 'singkatan' => 'TKJ', 'bidang' => 'Teknologi Informasi & Komunikasi'],
            'TOI' => ['nama' => 'Teknik Otomasi Industri', 'singkatan' => 'TOI', 'bidang' => 'Teknologi & Rekayasa'],
            'TP'  => ['nama' => 'Teknik Pemesinan', 'singkatan' => 'TP', 'bidang' => 'Teknologi & Rekayasa'],
            'KA'  => ['nama' => 'Kimia Analisis', 'singkatan' => 'KA', 'bidang' => 'Teknologi Kimia & Industri'],
            'TPL' => ['nama' => 'Teknik Pengelasan & Fabrikasi', 'singkatan' => 'TPL', 'bidang' => 'Teknologi & Rekayasa'],
        ];

        foreach ($jurusanDefs as $code => $data) {
            $j = Jurusan::where('kode', $code)->first();
            if (!$j) {
                Jurusan::create([
                    'kode' => $code,
                    'nama' => $data['nama'],
                    'singkatan' => $data['singkatan'],
                    'bidang' => $data['bidang'],
                    'akreditasi' => 'A UNGGUL',
                    'kuota_industri' => 100,
                    'kuota_terisi' => 95,
                    'status' => 'aktif',
                ]);
            } else {
                $j->update([
                    'nama' => $data['nama'],
                    'singkatan' => $data['singkatan'],
                    'bidang' => $data['bidang'],
                ]);
            }
        }

        $jurusans = Jurusan::all()->keyBy('kode');

        // 2. Ensure Wali Kelas (Guru) from screenshot
        $waliKelasList = [
            // Row 1 - 8 screenshot
            ['nip' => '19850312 201001 2 018', 'nama' => 'Siti Rahmawati, S.Kom.'],
            ['nip' => '19740510 199903 1 005', 'nama' => 'Drs. Bambang Wijaya, M.Pd.'],
            ['nip' => '19881119 201402 1 002', 'nama' => 'Ahmad Fauzi, S.Pd., M.Kom.'],
            ['nip' => '19800721 200801 2 015', 'nama' => 'Nurhayati, M.Pd.'],
            ['nip' => '19830214 201101 1 009', 'nama' => 'Hendro Susanto, S.T.'],
            ['nip' => '19780415 200501 1 008', 'nama' => 'Mulyadi, M.Pd.'],
            ['nip' => '19820925 200902 1 004', 'nama' => 'Budi Santoso, S.Pd.'],
            ['nip' => '19760108 200312 1 003', 'nama' => 'Ir. Joko Waskito'],
            // Remaining XII
            ['nip' => '19790614 200604 1 011', 'nama' => 'Drs. H. Suryana, M.Pd.'],
            ['nip' => '19840210 201001 1 009', 'nama' => 'Suryadi, S.T.'],
            ['nip' => '19780512 200501 1 004', 'nama' => 'Ir. Dian Hendrawan, S.Kom., M.T.'],
            ['nip' => '19701105 199802 2 001', 'nama' => 'Dra. Hj. Nurhayati, M.Pd.'],
            // XI (12 Guru)
            ['nip' => '19860101 201101 1 001', 'nama' => 'Ari Wibowo, S.Pd.'],
            ['nip' => '19870202 201201 2 002', 'nama' => 'Dewi Lestari, S.Kom.'],
            ['nip' => '19880303 201301 1 003', 'nama' => 'Fajar Pratama, S.T.'],
            ['nip' => '19890404 201401 2 004', 'nama' => 'Gita Gutawa, M.Pd.'],
            ['nip' => '19900505 201501 1 005', 'nama' => 'Hadi Sucipto, S.Pd.'],
            ['nip' => '19910606 201601 2 006', 'nama' => 'Indah Permatasari, S.Si.'],
            ['nip' => '19920707 201701 1 007', 'nama' => 'Joko Susilo, S.T.'],
            ['nip' => '19930808 201801 2 008', 'nama' => 'Kartika Sari, S.Pd.'],
            ['nip' => '19940909 201901 1 009', 'nama' => 'Lukman Hakim, M.Kom.'],
            ['nip' => '19951010 202001 2 010', 'nama' => 'Maya Anggraini, S.Pd.'],
            ['nip' => '19961111 202101 1 011', 'nama' => 'Nugroho Adi, S.T.'],
            ['nip' => '19971212 202201 2 012', 'nama' => 'Oktavia Ramadhani, S.Si.'],
            // X (12 Guru)
            ['nip' => '19851111 201001 1 013', 'nama' => 'Prasetyo Utomo, M.Pd.'],
            ['nip' => '19861212 201101 2 014', 'nama' => 'Qori Sandioriva, S.Pd.'],
            ['nip' => '19871010 201201 1 015', 'nama' => 'Rizky Febian, S.Kom.'],
            ['nip' => '19880909 201301 2 016', 'nama' => 'Siti Nurhaliza, M.Pd.'],
            ['nip' => '19890808 201401 1 017', 'nama' => 'Taufik Hidayat, S.T.'],
            ['nip' => '19900707 201501 2 018', 'nama' => 'Umi Kalsum, S.Pd.'],
            ['nip' => '19910606 201601 1 019', 'nama' => 'Vicky Prasetyo, S.Si.'],
            ['nip' => '19920505 201701 2 020', 'nama' => 'Winda Viska, S.Pd.'],
            ['nip' => '19930404 201801 1 021', 'nama' => 'Yoga Pratama, M.Kom.'],
            ['nip' => '19940303 201901 2 022', 'nama' => 'Zaskia Gotik, S.Pd.'],
            ['nip' => '19950202 202001 1 023', 'nama' => 'Agus Salim, S.T.'],
            ['nip' => '19960101 202101 2 024', 'nama' => 'Bella Shofie, S.Si.'],
        ];

        $guruMap = [];
        foreach ($waliKelasList as $index => $w) {
            $nipClean = str_replace(' ', '', $w['nip']);
            $guru = Guru::where('nip', $w['nip'])->orWhere('nip', $nipClean)->first();
            if (!$guru) {
                $username = 'wali_' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $w['nama'])[0])) . '_' . ($index + 1);
                $email = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $w['nama'])[0])) . ($index + 1) . '@guru.sch.id';

                $userId = DB::table('users')->insertGetId([
                    'username' => $username,
                    'email' => $email,
                    'password_hash' => Hash::make('password123'),
                    'tipe_akun' => 'guru',
                    'dibuat_pada' => now(),
                ]);

                $guru = Guru::create([
                    'user_id' => $userId,
                    'nip' => $w['nip'],
                    'nama' => $w['nama'],
                    'status_akun' => 'aktif',
                    'email' => $email,
                    'no_hp' => '0812' . rand(10000000, 99999999),
                ]);
            } else {
                $guru->update([
                    'nip' => $w['nip'],
                    'nama' => $w['nama'],
                ]);
            }
            $guruMap[$w['nama']] = $guru->id;
        }

        // 3. 36 Rombel Data
        $rombelsData = [
            // Tingkat XII (PKL) - 12 Rombel
            [
                'kode_rombel' => 'RBL-XII-RPL1',
                'nama_rombel' => 'XII RPL 1',
                'tingkat' => 'XII',
                'jurusan_kode' => 'RPL',
                'ruang' => 'Ruang LAB RPL 01',
                'wali_kelas' => 'Siti Rahmawati, S.Kom.',
                'jumlah_siswa' => 36,
                'siswa_terdata' => 36,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-RPL2',
                'nama_rombel' => 'XII RPL 2',
                'tingkat' => 'XII',
                'jurusan_kode' => 'RPL',
                'ruang' => 'Ruang LAB RPL 02',
                'wali_kelas' => 'Drs. Bambang Wijaya, M.Pd.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-RPL3',
                'nama_rombel' => 'XII RPL 3',
                'tingkat' => 'XII',
                'jurusan_kode' => 'RPL',
                'ruang' => 'Ruang Teori RPL 03',
                'wali_kelas' => 'Ahmad Fauzi, S.Pd., M.Kom.',
                'jumlah_siswa' => 36,
                'siswa_terdata' => 36,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-TKJ1',
                'nama_rombel' => 'XII TKJ 1',
                'tingkat' => 'XII',
                'jurusan_kode' => 'TKJ',
                'ruang' => 'Ruang Jaringan 1',
                'wali_kelas' => 'Nurhayati, M.Pd.',
                'jumlah_siswa' => 36,
                'siswa_terdata' => 36,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-TKJ2',
                'nama_rombel' => 'XII TKJ 2',
                'tingkat' => 'XII',
                'jurusan_kode' => 'TKJ',
                'ruang' => 'Ruang Jaringan 2',
                'wali_kelas' => 'Hendro Susanto, S.T.',
                'jumlah_siswa' => 36,
                'siswa_terdata' => 36,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-TOI1',
                'nama_rombel' => 'XII TOI 1',
                'tingkat' => 'XII',
                'jurusan_kode' => 'TOI',
                'ruang' => 'Workshop Otomasi B',
                'wali_kelas' => 'Mulyadi, M.Pd.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-TOI2',
                'nama_rombel' => 'XII TOI 2',
                'tingkat' => 'XII',
                'jurusan_kode' => 'TOI',
                'ruang' => 'Workshop Otomasi A',
                'wali_kelas' => 'Drs. H. Suryana, M.Pd.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-TP1',
                'nama_rombel' => 'XII TP 1',
                'tingkat' => 'XII',
                'jurusan_kode' => 'TP',
                'ruang' => 'Bengkel Mesin Bubut',
                'wali_kelas' => 'Budi Santoso, S.Pd.',
                'jumlah_siswa' => 36,
                'siswa_terdata' => 36,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-TP2',
                'nama_rombel' => 'XII TP 2',
                'tingkat' => 'XII',
                'jurusan_kode' => 'TP',
                'ruang' => 'Bengkel Mesin CNC',
                'wali_kelas' => 'Suryadi, S.T.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-KA1',
                'nama_rombel' => 'XII KA 1',
                'tingkat' => 'XII',
                'jurusan_kode' => 'KA',
                'ruang' => 'Laboratorium Kimia Terpadu',
                'wali_kelas' => 'Ir. Joko Waskito',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-KA2',
                'nama_rombel' => 'XII KA 2',
                'tingkat' => 'XII',
                'jurusan_kode' => 'KA',
                'ruang' => 'Laboratorium Kimia Organik',
                'wali_kelas' => 'Dra. Hj. Nurhayati, M.Pd.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Siap Terjun PKL',
            ],
            [
                'kode_rombel' => 'RBL-XII-TPL1',
                'nama_rombel' => 'XII TPL 1',
                'tingkat' => 'XII',
                'jurusan_kode' => 'TPL',
                'ruang' => 'Workshop Fabrikasi Logam',
                'wali_kelas' => 'Ir. Dian Hendrawan, S.Kom., M.T.',
                'jumlah_siswa' => 36,
                'siswa_terdata' => 36,
                'status_pkl' => 'Siap Terjun PKL',
            ],

            // Tingkat XI - 12 Rombel (Persiapan PKL)
            [
                'kode_rombel' => 'RBL-XI-RPL1',
                'nama_rombel' => 'XI RPL 1',
                'tingkat' => 'XI',
                'jurusan_kode' => 'RPL',
                'ruang' => 'Ruang Teori RPL 01',
                'wali_kelas' => 'Ari Wibowo, S.Pd.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-RPL2',
                'nama_rombel' => 'XI RPL 2',
                'tingkat' => 'XI',
                'jurusan_kode' => 'RPL',
                'ruang' => 'Ruang Teori RPL 02',
                'wali_kelas' => 'Dewi Lestari, S.Kom.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-RPL3',
                'nama_rombel' => 'XI RPL 3',
                'tingkat' => 'XI',
                'jurusan_kode' => 'RPL',
                'ruang' => 'Ruang Multimedia RPL',
                'wali_kelas' => 'Fajar Pratama, S.T.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-TKJ1',
                'nama_rombel' => 'XI TKJ 1',
                'tingkat' => 'XI',
                'jurusan_kode' => 'TKJ',
                'ruang' => 'Ruang Jaringan 3',
                'wali_kelas' => 'Gita Gutawa, M.Pd.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-TKJ2',
                'nama_rombel' => 'XI TKJ 2',
                'tingkat' => 'XI',
                'jurusan_kode' => 'TKJ',
                'ruang' => 'Ruang Server & Cyber',
                'wali_kelas' => 'Hadi Sucipto, S.Pd.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-TOI1',
                'nama_rombel' => 'XI TOI 1',
                'tingkat' => 'XI',
                'jurusan_kode' => 'TOI',
                'ruang' => 'Ruang PLC & Elektronika',
                'wali_kelas' => 'Indah Permatasari, S.Si.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-TOI2',
                'nama_rombel' => 'XI TOI 2',
                'tingkat' => 'XI',
                'jurusan_kode' => 'TOI',
                'ruang' => 'Workshop Robotika Industri',
                'wali_kelas' => 'Joko Susilo, S.T.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-TP1',
                'nama_rombel' => 'XI TP 1',
                'tingkat' => 'XI',
                'jurusan_kode' => 'TP',
                'ruang' => 'Bengkel Perkakas Mesin 1',
                'wali_kelas' => 'Kartika Sari, S.Pd.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-TP2',
                'nama_rombel' => 'XI TP 2',
                'tingkat' => 'XI',
                'jurusan_kode' => 'TP',
                'ruang' => 'Bengkel Perkakas Mesin 2',
                'wali_kelas' => 'Lukman Hakim, M.Kom.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-KA1',
                'nama_rombel' => 'XI KA 1',
                'tingkat' => 'XI',
                'jurusan_kode' => 'KA',
                'ruang' => 'Laboratorium Mikrobiologi',
                'wali_kelas' => 'Maya Anggraini, S.Pd.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-KA2',
                'nama_rombel' => 'XI KA 2',
                'tingkat' => 'XI',
                'jurusan_kode' => 'KA',
                'ruang' => 'Laboratorium Pengujian Mutu',
                'wali_kelas' => 'Nugroho Adi, S.T.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Persiapan PKL',
            ],
            [
                'kode_rombel' => 'RBL-XI-TPL1',
                'nama_rombel' => 'XI TPL 1',
                'tingkat' => 'XI',
                'jurusan_kode' => 'TPL',
                'ruang' => 'Bengkel Las SMAW & GTAW',
                'wali_kelas' => 'Oktavia Ramadhani, S.Si.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Persiapan PKL',
            ],

            // Tingkat X - 12 Rombel (Belum PKL)
            [
                'kode_rombel' => 'RBL-X-RPL1',
                'nama_rombel' => 'X RPL 1',
                'tingkat' => 'X',
                'jurusan_kode' => 'RPL',
                'ruang' => 'Ruang Teori X-01',
                'wali_kelas' => 'Prasetyo Utomo, M.Pd.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-RPL2',
                'nama_rombel' => 'X RPL 2',
                'tingkat' => 'X',
                'jurusan_kode' => 'RPL',
                'ruang' => 'Ruang Teori X-02',
                'wali_kelas' => 'Qori Sandioriva, S.Pd.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-RPL3',
                'nama_rombel' => 'X RPL 3',
                'tingkat' => 'X',
                'jurusan_kode' => 'RPL',
                'ruang' => 'Ruang Teori X-03',
                'wali_kelas' => 'Rizky Febian, S.Kom.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-TKJ1',
                'nama_rombel' => 'X TKJ 1',
                'tingkat' => 'X',
                'jurusan_kode' => 'TKJ',
                'ruang' => 'Ruang Teori X-04',
                'wali_kelas' => 'Siti Nurhaliza, M.Pd.',
                'jumlah_siswa' => 35,
                'siswa_terdata' => 35,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-TKJ2',
                'nama_rombel' => 'X TKJ 2',
                'tingkat' => 'X',
                'jurusan_kode' => 'TKJ',
                'ruang' => 'Ruang Teori X-05',
                'wali_kelas' => 'Taufik Hidayat, S.T.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-TOI1',
                'nama_rombel' => 'X TOI 1',
                'tingkat' => 'X',
                'jurusan_kode' => 'TOI',
                'ruang' => 'Ruang Teori X-06',
                'wali_kelas' => 'Umi Kalsum, S.Pd.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-TOI2',
                'nama_rombel' => 'X TOI 2',
                'tingkat' => 'X',
                'jurusan_kode' => 'TOI',
                'ruang' => 'Ruang Teori X-07',
                'wali_kelas' => 'Vicky Prasetyo, S.Si.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-TP1',
                'nama_rombel' => 'X TP 1',
                'tingkat' => 'X',
                'jurusan_kode' => 'TP',
                'ruang' => 'Ruang Teori X-08',
                'wali_kelas' => 'Winda Viska, S.Pd.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-TP2',
                'nama_rombel' => 'X TP 2',
                'tingkat' => 'X',
                'jurusan_kode' => 'TP',
                'ruang' => 'Ruang Teori X-09',
                'wali_kelas' => 'Yoga Pratama, M.Kom.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-KA1',
                'nama_rombel' => 'X KA 1',
                'tingkat' => 'X',
                'jurusan_kode' => 'KA',
                'ruang' => 'Ruang Teori X-10',
                'wali_kelas' => 'Zaskia Gotik, S.Pd.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-KA2',
                'nama_rombel' => 'X KA 2',
                'tingkat' => 'X',
                'jurusan_kode' => 'KA',
                'ruang' => 'Ruang Teori X-11',
                'wali_kelas' => 'Agus Salim, S.T.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Belum PKL',
            ],
            [
                'kode_rombel' => 'RBL-X-TPL1',
                'nama_rombel' => 'X TPL 1',
                'tingkat' => 'X',
                'jurusan_kode' => 'TPL',
                'ruang' => 'Ruang Teori X-12',
                'wali_kelas' => 'Bella Shofie, S.Si.',
                'jumlah_siswa' => 34,
                'siswa_terdata' => 34,
                'status_pkl' => 'Belum PKL',
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Rombel::truncate();

        foreach ($rombelsData as $r) {
            $jurusan = $jurusans[$r['jurusan_kode']] ?? null;
            if (!$jurusan) {
                continue;
            }

            $waliKelasId = $guruMap[$r['wali_kelas']] ?? null;

            Rombel::create([
                'kode_rombel' => $r['kode_rombel'],
                'nama_kode' => $r['nama_rombel'],
                'nama_rombel' => $r['nama_rombel'],
                'tingkat' => $r['tingkat'],
                'ruang' => $r['ruang'],
                'jurusan_id' => $jurusan->id,
                'wali_kelas_guru_id' => $waliKelasId,
                'jumlah_siswa' => $r['jumlah_siswa'],
                'siswa_terdata' => $r['siswa_terdata'],
                'status_pkl' => $r['status_pkl'],
                'tahun_ajaran' => '2024/2025',
                'semester' => 'Semester Ganjil',
                'status' => 'aktif',
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
