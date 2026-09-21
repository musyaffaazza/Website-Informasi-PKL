<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\Jurusan;

class SiswaDisplaySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete previous siswa and their users
        Siswa::truncate();
        DB::table('users')->where('tipe_akun', 'siswa')->delete();

        // Get Jurusans and Rombels
        $rpl = Jurusan::where('kode', 'RPL')->first();
        $tkj = Jurusan::where('kode', 'TKJ')->first();
        $toi = Jurusan::where('kode', 'TOI')->first();
        $tp  = Jurusan::where('kode', 'TP')->first();
        $ka  = Jurusan::where('kode', 'KA')->first();
        $tpl = Jurusan::where('kode', 'TPL')->first();

        $rombelMap = Rombel::all()->keyBy('nama_rombel');
        $defaultHash = '$2y$10$Xcsj5WbrZvl5yAcOJuWN0.ZMEI6Y1ObULRMhChhcBXS6Ay04wtB0G';

        // First 10 Featured Students (Page 1 from screenshot)
        $featuredStudents = [
            [
                'nis' => '212210408',
                'nisn' => '0067891234',
                'nama' => 'Raka Pratama',
                'jenis_kelamin' => 'L',
                'kota' => 'Bogor',
                'rombel_nama' => 'XII RPL 1',
                'jurusan_id' => $rpl?->id,
                'kampus' => 'Kampus Pusat',
                'no_hp' => '+62 812-9844-1290',
                'email' => 'raka.pratama@smkn1gunungputri.sch.id',
                'status_akun' => 'aktif',
                'status_pkl' => 'Sudah Ditempatkan',
            ],
            [
                'nis' => '212210409',
                'nisn' => '0067891235',
                'nama' => 'Anisa Nuraini',
                'jenis_kelamin' => 'P',
                'kota' => 'Cibinong',
                'rombel_nama' => 'XII RPL 1',
                'jurusan_id' => $rpl?->id,
                'kampus' => 'Kampus Pusat',
                'no_hp' => '+62 857-1120-4491',
                'email' => 'anisa.nuraini@smkn1gunungputri.sch.id',
                'status_akun' => 'aktif',
                'status_pkl' => 'Sudah Ditempatkan',
            ],
            [
                'nis' => '212210410',
                'nisn' => '0067891236',
                'nama' => 'Farhan Ramadhan',
                'jenis_kelamin' => 'L',
                'kota' => 'Gunungputri',
                'rombel_nama' => 'XII RPL 2',
                'jurusan_id' => $rpl?->id,
                'kampus' => 'Kampus Pusat',
                'no_hp' => '+62 896-7788-2311',
                'email' => 'farhan.ramadhan@smkn1gunungputri.sch.id',
                'status_akun' => 'aktif',
                'status_pkl' => 'Siap Terjun',
            ],
            [
                'nis' => '212210411',
                'nisn' => '0067891237',
                'nama' => 'Dimas Kurniawan',
                'jenis_kelamin' => 'L',
                'kota' => 'Cileungsi',
                'rombel_nama' => 'XII TKJ 1',
                'jurusan_id' => $tkj?->id,
                'kampus' => 'Kampus 2',
                'no_hp' => '+62 821-3344-9090',
                'email' => 'dimas.kurniawan@smkn1gunungputri.sch.id',
                'status_akun' => 'belum_aktivasi',
                'status_pkl' => 'Belum Terpetakan',
            ],
            [
                'nis' => '212210412',
                'nisn' => '0067891238',
                'nama' => 'Nabila Syahfitri',
                'jenis_kelamin' => 'P',
                'kota' => 'Klapanunggal',
                'rombel_nama' => 'XII TKJ 1',
                'jurusan_id' => $tkj?->id,
                'kampus' => 'Kampus 2',
                'no_hp' => '+62 813-8890-1234',
                'email' => 'nabila.syahfitri@smkn1gunungputri.sch.id',
                'status_akun' => 'aktif',
                'status_pkl' => 'Sudah Ditempatkan',
            ],
            [
                'nis' => '212210413',
                'nisn' => '0067891239',
                'nama' => 'Gilang Pratama',
                'jenis_kelamin' => 'L',
                'kota' => 'Citeureup',
                'rombel_nama' => 'XII TOI 1',
                'jurusan_id' => $toi?->id,
                'kampus' => 'Kampus Pusat',
                'no_hp' => '+62 878-1902-8022',
                'email' => 'gilang.pratama@smkn1gunungputri.sch.id',
                'status_akun' => 'aktif',
                'status_pkl' => 'Siap Terjun',
            ],
            [
                'nis' => '212210414',
                'nisn' => '0067891240',
                'nama' => 'Siti Aisyah',
                'jenis_kelamin' => 'P',
                'kota' => 'Bogor',
                'rombel_nama' => 'XII KA 1',
                'jurusan_id' => $ka?->id,
                'kampus' => 'Kampus Pusat',
                'no_hp' => '+62 856-9112-3001',
                'email' => 'siti.aisyah@smkn1gunungputri.sch.id',
                'status_akun' => 'aktif',
                'status_pkl' => 'Sudah Ditempatkan',
            ],
            [
                'nis' => '212210415',
                'nisn' => '0067891241',
                'nama' => 'Rizky Maulana',
                'jenis_kelamin' => 'L',
                'kota' => 'Gunungputri',
                'rombel_nama' => 'XII RPL 2',
                'jurusan_id' => $rpl?->id,
                'kampus' => 'Kampus Pusat',
                'no_hp' => '+62 812-4411-9988',
                'email' => 'rizky.maulana@smkn1gunungputri.sch.id',
                'status_akun' => 'aktif',
                'status_pkl' => 'Siap Terjun',
            ],
            [
                'nis' => '212210416',
                'nisn' => '0067891242',
                'nama' => 'Tasya Melani',
                'jenis_kelamin' => 'P',
                'kota' => 'Cibinong',
                'rombel_nama' => 'XII TKJ 2',
                'jurusan_id' => $tkj?->id,
                'kampus' => 'Kampus 2',
                'no_hp' => '+62 822-7711-6655',
                'email' => 'tasya.melani@smkn1gunungputri.sch.id',
                'status_akun' => 'aktif',
                'status_pkl' => 'Sudah Ditempatkan',
            ],
            [
                'nis' => '212210417',
                'nisn' => '0067891243',
                'nama' => 'Ahmad Fauzi',
                'jenis_kelamin' => 'L',
                'kota' => 'Gunungputri',
                'rombel_nama' => 'XII TOI 1',
                'jurusan_id' => $toi?->id,
                'kampus' => 'Kampus Pusat',
                'no_hp' => '+62 899-0021-3312',
                'email' => 'ahmad.fauzi@smkn1gunungputri.sch.id',
                'status_akun' => 'ditangguhkan',
                'status_pkl' => 'Belum Terpetakan',
            ],
        ];

        // Seed First 10
        foreach ($featuredStudents as $s) {
            $rombel = $rombelMap[$s['rombel_nama']] ?? Rombel::first();
            $jurusanId = $s['jurusan_id'] ?: $rombel->jurusan_id;

            $userId = DB::table('users')->insertGetId([
                'username' => 'siswa_' . $s['nis'],
                'email' => $s['email'],
                'password_hash' => $defaultHash,
                'tipe_akun' => 'siswa',
                'dibuat_pada' => now(),
            ]);

            Siswa::create([
                'user_id' => $userId,
                'nis' => $s['nis'],
                'nisn' => $s['nisn'],
                'nama' => $s['nama'],
                'rombel_id' => $rombel->id,
                'jurusan_id' => $jurusanId,
                'kampus' => $s['kampus'],
                'jenis_kelamin' => $s['jenis_kelamin'],
                'kota' => $s['kota'],
                'no_hp' => $s['no_hp'],
                'email' => $s['email'],
                'status_akun' => $s['status_akun'],
                'status_pkl' => $s['status_pkl'],
            ]);
        }

        // Rombels for remaining groups
        $rombelsXII = Rombel::where('tingkat', 'XII')->get();
        $rombelsXI  = Rombel::where('tingkat', 'XI')->get();
        $rombelsX   = Rombel::where('tingkat', 'X')->get();

        $cities = ['Bogor', 'Cibinong', 'Gunungputri', 'Cileungsi', 'Klapanunggal', 'Citeureup', 'Depok', 'Bekasi'];
        $firstNamesM = ['Aditya', 'Bagus', 'Candra', 'Daffa', 'Erlangga', 'Fajar', 'Galih', 'Hafizh', 'Irfan', 'Jovan', 'Kevin', 'Luthfi', 'Mahesa', 'Naufal', 'Pandu', 'Rafi', 'Satria', 'Tegar', 'Wildan', 'Zaki', 'Aris', 'Bayu', 'Dimas', 'Eka', 'Guntur'];
        $firstNamesF = ['Amanda', 'Bella', 'Clarissa', 'Dhea', 'Elsa', 'Febiola', 'Ghea', 'Hana', 'Indira', 'Jessica', 'Kayla', 'Luna', 'Melati', 'Nadya', 'Olivia', 'Priscillia', 'Rania', 'Salma', 'Tiara', 'Zahra', 'Ayu', 'Citra', 'Fitri', 'Intan', 'Putri'];
        $lastNames = ['Saputra', 'Pratama', 'Hidayat', 'Kusuma', 'Ramadhan', 'Wijaya', 'Setiawan', 'Nugroho', 'Firmansyah', 'Santoso', 'Hakim', 'Maulana', 'Wibowo', 'Siregar', 'Lestari', 'Utami', 'Purnomo', 'Syahputra'];

        $statusesPKL_XII = ['Sudah Ditempatkan', 'Siap Terjun', 'Belum Terpetakan', 'Sedang PKL'];

        // Add students 11 to 432 (All in Tingkat XII)
        // Row 4 is belum_aktivasi, Row 10 is ditangguhkan -> total pending in XII = 12
        for ($i = 11; $i <= 432; $i++) {
            $isMale = ($i % 2 == 1);
            $fn = $isMale ? $firstNamesM[($i) % count($firstNamesM)] : $firstNamesF[($i) % count($firstNamesF)];
            $ln = $lastNames[($i * 3) % count($lastNames)];
            $nama = $fn . ' ' . $ln;

            $nis = (string)(212210407 + $i);
            $nisn = '006789' . str_pad(1233 + $i, 4, '0', STR_PAD_LEFT);

            $rIdx = ($i) % $rombelsXII->count();
            $rombel = $rombelsXII[$rIdx];
            $jurusanId = $rombel->jurusan_id;
            $kampus = ($rombel->jurusan?->kode === 'TKJ') ? 'Kampus 2' : 'Kampus Pusat';
            $kota = $cities[$i % count($cities)];

            $statusPKL = $statusesPKL_XII[$i % count($statusesPKL_XII)];

            // Pending accounts: need 10 more in XII to have 12 in XII
            $statusAkun = 'aktif';
            if ($i <= 100 && $i % 10 == 0) {
                $statusAkun = 'belum_aktivasi';
            }

            $email = strtolower($fn . '.' . $ln) . $i . '@smkn1gunungputri.sch.id';
            $phone = '+62 8' . rand(11, 99) . '-' . rand(1000, 9999) . '-' . str_pad(rand(100, 9999), 4, '0', STR_PAD_LEFT);

            $userId = DB::table('users')->insertGetId([
                'username' => 'siswa_' . $nis,
                'email' => $email,
                'password_hash' => $defaultHash,
                'tipe_akun' => 'siswa',
                'dibuat_pada' => now(),
            ]);

            Siswa::create([
                'user_id' => $userId,
                'nis' => $nis,
                'nisn' => $nisn,
                'nama' => $nama,
                'rombel_id' => $rombel->id,
                'jurusan_id' => $jurusanId,
                'kampus' => $kampus,
                'jenis_kelamin' => $isMale ? 'L' : 'P',
                'kota' => $kota,
                'no_hp' => $phone,
                'email' => $email,
                'status_akun' => $statusAkun,
                'status_pkl' => $statusPKL,
            ]);
        }

        // Remaining students 433 to 1248 (In XI and X)
        $currentPendingCount = Siswa::whereIn('status_akun', ['belum_aktivasi', 'ditangguhkan'])->count();
        $neededPending = 33 - $currentPendingCount;

        for ($i = 433; $i <= 1248; $i++) {
            $isMale = ($i % 2 == 1);
            $fn = $isMale ? $firstNamesM[($i) % count($firstNamesM)] : $firstNamesF[($i) % count($firstNamesF)];
            $ln = $lastNames[($i * 3) % count($lastNames)];
            $nama = $fn . ' ' . $ln;

            $nis = (string)(212210407 + $i);
            $nisn = '007890' . str_pad($i, 4, '0', STR_PAD_LEFT);

            if ($i <= 848) {
                $rIdx = ($i) % $rombelsXI->count();
                $rombel = $rombelsXI[$rIdx];
                $statusPKL = 'Persiapan PKL';
            } else {
                $rIdx = ($i) % $rombelsX->count();
                $rombel = $rombelsX[$rIdx];
                $statusPKL = 'Belum PKL';
            }

            $jurusanId = $rombel->jurusan_id;
            $kampus = ($rombel->jurusan?->kode === 'TKJ') ? 'Kampus 2' : 'Kampus Pusat';
            $kota = $cities[$i % count($cities)];

            $statusAkun = 'aktif';
            if ($neededPending > 0 && ($i % 38 == 0 || $i == 1248)) {
                $statusAkun = 'belum_aktivasi';
                $neededPending--;
            }

            $email = strtolower($fn . '.' . $ln) . $i . '@smkn1gunungputri.sch.id';
            $phone = '+62 8' . rand(11, 99) . '-' . rand(1000, 9999) . '-' . str_pad(rand(100, 9999), 4, '0', STR_PAD_LEFT);

            $userId = DB::table('users')->insertGetId([
                'username' => 'siswa_' . $nis,
                'email' => $email,
                'password_hash' => $defaultHash,
                'tipe_akun' => 'siswa',
                'dibuat_pada' => now(),
            ]);

            Siswa::create([
                'user_id' => $userId,
                'nis' => $nis,
                'nisn' => $nisn,
                'nama' => $nama,
                'rombel_id' => $rombel->id,
                'jurusan_id' => $jurusanId,
                'kampus' => $kampus,
                'jenis_kelamin' => $isMale ? 'L' : 'P',
                'kota' => $kota,
                'no_hp' => $phone,
                'email' => $email,
                'status_akun' => $statusAkun,
                'status_pkl' => $statusPKL,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
