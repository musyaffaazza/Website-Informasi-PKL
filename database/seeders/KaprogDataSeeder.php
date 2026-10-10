<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Rombel;
use App\Models\Industri;
use App\Models\Siswa;
use App\Models\PengajuanPkl;

class KaprogDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Create or update Kaprog User & Guru
        $kaprogUser = User::where('username', 'kaprog')->orWhere('username', 'kaprog_rpl')->first();
        if (!$kaprogUser) {
            $kaprogUser = User::create([
                'username' => 'kaprog',
                'email' => 'dian.hendrawan@smkn1gunungputri.sch.id',
                'password_hash' => Hash::make('password123'),
                'tipe_akun' => 'guru',
                'dibuat_pada' => now(),
            ]);
        } else {
            $kaprogUser->update([
                'username' => 'kaprog',
                'email' => 'dian.hendrawan@smkn1gunungputri.sch.id',
                'password_hash' => Hash::make('password123'),
                'tipe_akun' => 'guru',
            ]);
        }

        // Also ensure kaprog_rpl username exists as alias or secondary
        $kaprogRplUser = User::where('username', 'kaprog_rpl')->first();
        if (!$kaprogRplUser) {
            User::create([
                'username' => 'kaprog_rpl',
                'email' => 'kaprog.rpl@smkn1gunungputri.sch.id',
                'password_hash' => Hash::make('password123'),
                'tipe_akun' => 'guru',
                'dibuat_pada' => now(),
            ]);
        }

        $guru = Guru::where('nip', '197805122005011004')->orWhere('user_id', $kaprogUser->id)->first();
        if (!$guru) {
            $guru = Guru::create([
                'user_id' => $kaprogUser->id,
                'nip' => '197805122005011004',
                'nama' => 'Ir. Dian Hendrawan, S.Kom., M.T.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S2 Teknik Informatika',
                'email' => 'dian.hendrawan@smkn1gunungputri.sch.id',
                'no_hp' => '081234567890',
                'status_akun' => 'aktif',
                'roles_list' => ['Kaprog', 'Kepala Program Keahlian RPL'],
                'kelas_diampu' => 'Rekayasa Perangkat Lunak',
                'keterangan_diampu' => 'Kepala Program Keahlian Rekayasa Perangkat Lunak',
            ]);
        } else {
            $guru->update([
                'user_id' => $kaprogUser->id,
                'nama' => 'Ir. Dian Hendrawan, S.Kom., M.T.',
                'nip' => '197805122005011004',
                'roles_list' => ['Kaprog', 'Kepala Program Keahlian RPL'],
                'status_akun' => 'aktif',
            ]);
        }

        // 2. Setup Jurusan RPL
        $jurusan = Jurusan::where('kode', 'RPL')->first();
        if (!$jurusan) {
            $jurusan = Jurusan::create([
                'kode' => 'RPL',
                'nama' => 'Rekayasa Perangkat Lunak',
                'singkatan' => 'RPL',
                'bidang' => 'Teknologi Informasi',
                'kaprog_guru_id' => $guru->id,
                'status' => 'aktif',
                'kuota_industri' => 120,
                'kuota_terisi' => 102,
                'badge_color' => 'blue',
            ]);
        } else {
            $jurusan->update([
                'nama' => 'Rekayasa Perangkat Lunak',
                'singkatan' => 'RPL',
                'kaprog_guru_id' => $guru->id,
                'status' => 'aktif',
            ]);
        }
        $guru->update(['jurusan_id' => $jurusan->id]);

        // 3. Setup Rombels (XII RPL 1, XII RPL 2, XII RPL 3)
        $rombelNames = ['XII RPL 1', 'XII RPL 2', 'XII RPL 3'];
        $rombels = [];
        foreach ($rombelNames as $index => $rName) {
            $rombel = Rombel::where('nama_kode', $rName)->orWhere('nama_rombel', $rName)->first();
            if (!$rombel) {
                $rombel = Rombel::create([
                    'kode_rombel' => 'RPL' . ($index + 1),
                    'nama_kode' => $rName,
                    'nama_rombel' => $rName,
                    'tingkat' => 'XII',
                    'ruang' => 'Lab RPL ' . ($index + 1),
                    'jurusan_id' => $jurusan->id,
                    'jumlah_siswa' => 36,
                    'siswa_terdata' => 36,
                    'status_pkl' => 'aktif',
                    'tahun_ajaran' => '2024/2026',
                    'semester' => 'Genap',
                    'status' => 'aktif',
                ]);
            } else {
                $rombel->update([
                    'nama_kode' => $rName,
                    'nama_rombel' => $rName,
                    'tingkat' => 'XII',
                    'jurusan_id' => $jurusan->id,
                    'jumlah_siswa' => 36,
                    'siswa_terdata' => 36,
                    'tahun_ajaran' => '2024/2026',
                    'semester' => 'Genap',
                    'status' => 'aktif',
                ]);
            }
            $rombels[$rName] = $rombel;
        }

        // Setup additional teachers if they don't exist
        $teachersData = [
            ['nama' => 'Drs. Bambang Wijaya', 'nip' => '197503152002121002', 'email' => 'bambang.wijaya@smkn1gunungputri.sch.id', 'gender' => 'Laki-laki', 'role' => 'Pembimbing PKL'],
            ['nama' => 'Siti Rahmawati, S.Kom', 'nip' => '198506202010012015', 'email' => 'siti.rahmawati@smkn1gunungputri.sch.id', 'gender' => 'Perempuan', 'role' => 'Pembimbing PKL'],
            ['nama' => 'Dra. Hj. Nurhayati', 'nip' => '196811241994032001', 'email' => 'nurhayati@smkn1gunungputri.sch.id', 'gender' => 'Perempuan', 'role' => 'Wali Kelas XII RPL 2'],
            ['nama' => 'Ahmad Rofiq, S.Pd', 'nip' => '198204182008011009', 'email' => 'ahmad.rofiq@smkn1gunungputri.sch.id', 'gender' => 'Laki-laki', 'role' => 'Wali Kelas XII RPL 1'],
        ];

        $guruMap = ['Ir. Dian Hendrawan, S.Kom., M.T.' => $guru];
        foreach ($teachersData as $t) {
            $g = Guru::where('nip', $t['nip'])->orWhere('nama', $t['nama'])->first();
            if (!$g) {
                $uName = strtolower(str_replace(['.', ' ', ','], '', $t['nama'])) . rand(10, 99);
                $u = User::create([
                    'username' => $uName,
                    'email' => $t['email'],
                    'password_hash' => Hash::make('password123'),
                    'tipe_akun' => 'guru',
                    'dibuat_pada' => now(),
                ]);

                $g = Guru::create([
                    'user_id' => $u->id,
                    'nip' => $t['nip'],
                    'nama' => $t['nama'],
                    'jenis_kelamin' => $t['gender'],
                    'email' => $t['email'],
                    'status_akun' => 'aktif',
                    'roles_list' => [$t['role']],
                    'jurusan_id' => $jurusan->id,
                ]);
            }
            $guruMap[$t['nama']] = $g;
        }

        // 4. Setup 28 Mitra DU/DI for RPL matching the screenshot
        $industrisData = [
            ['nama' => 'PT Telkom Akses', 'bidang' => 'Telekomunikasi', 'alamat' => 'Jakarta & Bogor Network Area', 'wilayah' => 'Jakarta & Bogor', 'kuota' => 6, 'kuota_terisi' => 6, 'pembimbing' => 'Drs. Bambang Wijaya', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Indocyber Global Teknologi', 'bidang' => 'Software House', 'alamat' => 'Wisma Slipi, Palmerah, Jakarta Barat', 'wilayah' => 'Jakarta Barat', 'kuota' => 6, 'kuota_terisi' => 6, 'pembimbing' => 'Siti Rahmawati, S.Kom', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Nusantara Digital', 'bidang' => 'Cloud Platform', 'alamat' => 'Kawasan Industri Sentul, Kab. Bogor', 'wilayah' => 'Bogor', 'kuota' => 5, 'kuota_terisi' => 5, 'pembimbing' => 'Drs. Bambang Wijaya', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Astra Honda Motor', 'bidang' => 'Automotive & IoT', 'alamat' => 'Kawasan MM2100, Cikarang Barat', 'wilayah' => 'Bekasi / Cikarang', 'kuota' => 6, 'kuota_terisi' => 6, 'pembimbing' => 'Dra. Hj. Nurhayati', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Bank Central Asia Tbk', 'bidang' => 'Fintech & Banking', 'alamat' => 'Wisma BCA, BSD City, Tangerang', 'wilayah' => 'Tangerang', 'kuota' => 4, 'kuota_terisi' => 4, 'pembimbing' => 'Ahmad Rofiq, S.Pd', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Tokopedia (GoTo Group)', 'bidang' => 'E-Commerce & Tech', 'alamat' => 'Tokopedia Tower, Kuningan, Jakarta Selatan', 'wilayah' => 'Jakarta Selatan', 'kuota' => 4, 'kuota_terisi' => 4, 'pembimbing' => 'Siti Rahmawati, S.Kom', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Bukalapak.com Tbk', 'bidang' => 'E-Commerce', 'alamat' => 'Cilandak KKO, Jakarta Selatan', 'wilayah' => 'Jakarta Selatan', 'kuota' => 4, 'kuota_terisi' => 4, 'pembimbing' => 'Drs. Bambang Wijaya', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Shopee International Indonesia', 'bidang' => 'E-Commerce & Logistics', 'alamat' => 'Pacific Century Place, SCBD Jakarta', 'wilayah' => 'Jakarta Selatan', 'kuota' => 5, 'kuota_terisi' => 5, 'pembimbing' => 'Dra. Hj. Nurhayati', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Traveloka Indonesia', 'bidang' => 'Online Travel & Tech', 'alamat' => 'Traveloka Campus, BSD Green Office Park', 'wilayah' => 'Tangerang', 'kuota' => 4, 'kuota_terisi' => 4, 'pembimbing' => 'Ahmad Rofiq, S.Pd', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Dana Indonesia (DANA)', 'bidang' => 'Digital Payment', 'alamat' => 'Capital Place, Jl. Gatot Subroto, Jakarta', 'wilayah' => 'Jakarta Selatan', 'kuota' => 4, 'kuota_terisi' => 4, 'pembimbing' => 'Siti Rahmawati, S.Kom', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Solusi Teknologi Bersama', 'bidang' => 'IT Solutions', 'alamat' => 'Kawasan Industri Sentul, Bogor', 'wilayah' => 'Bogor', 'kuota' => 4, 'kuota_terisi' => 4, 'pembimbing' => 'Drs. Bambang Wijaya', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Mitra Integrasi Informatika', 'bidang' => 'System Integrator', 'alamat' => 'Wisma 46 Kota BNI, Jakarta Pusat', 'wilayah' => 'Jakarta Pusat', 'kuota' => 5, 'kuota_terisi' => 4, 'pembimbing' => 'Ahmad Rofiq, S.Pd', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Enigma Cipta Humanika', 'bidang' => 'IT Bootcamp & Talent', 'alamat' => 'Kebayoran Baru, Jakarta Selatan', 'wilayah' => 'Jakarta Selatan', 'kuota' => 4, 'kuota_terisi' => 3, 'pembimbing' => 'Siti Rahmawati, S.Kom', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Gameloft Indonesia', 'bidang' => 'Game Development', 'alamat' => 'Jakarta Hub & Remote Hybrid', 'wilayah' => 'Jakarta Selatan', 'kuota' => 4, 'kuota_terisi' => 2, 'pembimbing' => 'Dra. Hj. Nurhayati', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'RSUD Cileungsi (Divisi SIMRS)', 'bidang' => 'Healthcare IT', 'alamat' => 'Jl. Raya Cileungsi, Kab. Bogor', 'wilayah' => 'Bogor', 'kuota' => 3, 'kuota_terisi' => 2, 'pembimbing' => 'Ahmad Rofiq, S.Pd', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Agate International', 'bidang' => 'Game & Interactive', 'alamat' => 'Bandung & Virtual Office Jakarta', 'wilayah' => 'Bandung / Hybrid', 'kuota' => 4, 'kuota_terisi' => 2, 'pembimbing' => 'Drs. Bambang Wijaya', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Padepokan Tujuh Sembilan', 'bidang' => 'Software House', 'alamat' => 'Jl. Pelajar Pejuang, Bandung', 'wilayah' => 'Bandung', 'kuota' => 4, 'kuota_terisi' => 3, 'pembimbing' => 'Siti Rahmawati, S.Kom', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Walden Global Services (WGS)', 'bidang' => 'Enterprise Software', 'alamat' => 'Setiabudi, Jakarta Selatan', 'wilayah' => 'Jakarta Selatan', 'kuota' => 3, 'kuota_terisi' => 2, 'pembimbing' => 'Dra. Hj. Nurhayati', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Xapiens Teknologi Indonesia', 'bidang' => 'IT Infrastructure & Cloud', 'alamat' => 'Kuningan Timur, Jakarta Selatan', 'wilayah' => 'Jakarta Selatan', 'kuota' => 4, 'kuota_terisi' => 3, 'pembimbing' => 'Ahmad Rofiq, S.Pd', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Phincon (Phintraco Group)', 'bidang' => 'CRM & Contact Center', 'alamat' => 'Kebon Sirih, Menteng, Jakarta Pusat', 'wilayah' => 'Jakarta Pusat', 'kuota' => 3, 'kuota_terisi' => 2, 'pembimbing' => 'Drs. Bambang Wijaya', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Jasa Raharja (Divisi IT)', 'bidang' => 'BUMN Technology', 'alamat' => 'Jl. HR Rasuna Said, Jakarta Selatan', 'wilayah' => 'Jakarta Selatan', 'kuota' => 3, 'kuota_terisi' => 2, 'pembimbing' => 'Dra. Hj. Nurhayati', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Trinusa Travelindo (Traveloka Tech)', 'bidang' => 'Travel Tech', 'alamat' => 'BSD Green Office Park, Tangerang', 'wilayah' => 'Tangerang', 'kuota' => 4, 'kuota_terisi' => 3, 'pembimbing' => 'Siti Rahmawati, S.Kom', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Duta Visual Nusantara Tivi Tujuh', 'bidang' => 'Broadcasting & Web Media', 'alamat' => 'Jl. Kapten Tendean, Jakarta Selatan', 'wilayah' => 'Jakarta Selatan', 'kuota' => 4, 'kuota_terisi' => 3, 'pembimbing' => 'Ahmad Rofiq, S.Pd', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Biznet Gio Nusantara', 'bidang' => 'Cloud Computing & Hosting', 'alamat' => 'MidPlaza 2, Jl. Jend. Sudirman, Jakarta', 'wilayah' => 'Jakarta Pusat', 'kuota' => 4, 'kuota_terisi' => 3, 'pembimbing' => 'Drs. Bambang Wijaya', 'status_kemitraan' => 'Aktif'],
            ['nama' => 'PT Qasico Teknologi Indonesia', 'bidang' => 'SaaS & ERP Solution', 'alamat' => 'Cibubur Times Square, Bekasi', 'wilayah' => 'Bekasi', 'kuota' => 3, 'kuota_terisi' => 2, 'pembimbing' => 'Siti Rahmawati, S.Kom', 'status_kemitraan' => 'MoU Baru'],
            ['nama' => 'PT Cybertrend Intrabuana', 'bidang' => 'Data Analytics & AI', 'alamat' => 'Pondok Indah Office Tower, Jakarta', 'wilayah' => 'Jakarta Selatan', 'kuota' => 4, 'kuota_terisi' => 2, 'pembimbing' => 'Dra. Hj. Nurhayati', 'status_kemitraan' => 'MoU Baru'],
            ['nama' => 'PT Anabatic Technologies Tbk', 'bidang' => 'IT Security & Integration', 'alamat' => 'Graha Anabatic, Gading Serpong, Tangerang', 'wilayah' => 'Tangerang', 'kuota' => 4, 'kuota_terisi' => 3, 'pembimbing' => 'Ahmad Rofiq, S.Pd', 'status_kemitraan' => 'MoU Baru'],
            ['nama' => 'PT Media Nusantara Citra Tbk', 'bidang' => 'Digital Media & Streaming', 'alamat' => 'MNC Tower, Kebon Sirih, Jakarta Pusat', 'wilayah' => 'Jakarta Pusat', 'kuota' => 4, 'kuota_terisi' => 2, 'pembimbing' => 'Drs. Bambang Wijaya', 'status_kemitraan' => 'MoU Baru'],
        ];

        $industriMap = [];
        foreach ($industrisData as $ind) {
            $pembimbingGuru = $guruMap[$ind['pembimbing']] ?? null;
            $industri = Industri::where('nama', $ind['nama'])->first();
            if (!$industri) {
                $industri = Industri::create([
                    'nama' => $ind['nama'],
                    'bidang_usaha' => $ind['bidang'],
                    'alamat' => $ind['alamat'],
                    'wilayah' => $ind['wilayah'],
                    'no_mou' => 'MOU/SMK1GP/' . rand(100, 999) . '/2024',
                    'kontak_nama' => 'HRD ' . $ind['nama'],
                    'kontak_jabatan' => 'HR Manager',
                    'kontak_no_hp' => '08' . rand(1111111111, 9999999999),
                    'kontak_email' => 'hr@' . strtolower(preg_replace('/[^a-zA-Z]/', '', $ind['nama'])) . '.co.id',
                    'pembimbing_nama' => $ind['pembimbing'],
                    'pembimbing_guru_id' => $pembimbingGuru?->id,
                    'kuota' => $ind['kuota'],
                    'kuota_terisi' => $ind['kuota_terisi'],
                    'status' => 'aktif',
                    'status_kemitraan' => $ind['status_kemitraan'],
                ]);
            } else {
                $industri->update([
                    'nama' => $ind['nama'],
                    'bidang_usaha' => $ind['bidang'],
                    'alamat' => $ind['alamat'],
                    'wilayah' => $ind['wilayah'],
                    'pembimbing_nama' => $ind['pembimbing'],
                    'pembimbing_guru_id' => $pembimbingGuru?->id,
                    'kuota' => $ind['kuota'],
                    'kuota_terisi' => $ind['kuota_terisi'],
                    'status' => 'aktif',
                    'status_kemitraan' => $ind['status_kemitraan'],
                ]);
            }
            // attach to RPL jurusan
            if (!DB::table('industri_jurusan')->where('industri_id', $industri->id)->where('jurusan_id', $jurusan->id)->exists()) {
                DB::table('industri_jurusan')->insert([
                    'industri_id' => $industri->id,
                    'jurusan_id' => $jurusan->id,
                ]);
            }
            $industriMap[$ind['nama']] = $industri;
        }

        // 5. Seed Specific 12 Display Students as in Screenshot
        $primaryStudents = [
            [
                'no' => '01',
                'nama' => 'Raka Pratama',
                'nisn' => '0068212101',
                'nis' => '20240101',
                'rombel' => 'XII RPL 2',
                'industri' => 'PT Telkom Akses',
                'posisi' => 'NOC & Web Infrastructure',
                'kehadiran' => 97.5,
                'status' => 'Aktif Magang',
                'gender' => 'L',
                'avatar_color' => 'blue',
            ],
            [
                'no' => '02',
                'nama' => 'Anisa Nuraini',
                'nisn' => '0068212102',
                'nis' => '20240102',
                'rombel' => 'XII RPL 1',
                'industri' => 'CV Media Solusi Digital',
                'posisi' => 'Frontend React Developer',
                'kehadiran' => 98.2,
                'status' => 'Aktif Magang',
                'gender' => 'P',
                'avatar_color' => 'blue',
            ],
            [
                'no' => '03',
                'nama' => 'Fajar Adriansyah',
                'nisn' => '0068212103',
                'nis' => '20240103',
                'rombel' => 'XII RPL 2',
                'industri' => 'PT Bukaka Teknik',
                'posisi' => 'IoT & Python Scripting',
                'kehadiran' => 82.0,
                'status' => 'Aktif Magang',
                'gender' => 'L',
                'avatar_color' => 'blue',
            ],
            [
                'no' => '04',
                'nama' => 'Dimas Kurniawan',
                'nisn' => '0068212104',
                'nis' => '20240104',
                'rombel' => 'XII RPL 2',
                'industri' => 'PT Astra Honda Motor',
                'posisi' => 'IT Support & Networking',
                'kehadiran' => null,
                'status' => 'Menunggu Konfirmasi',
                'gender' => 'L',
                'avatar_color' => 'amber',
            ],
            [
                'no' => '05',
                'nama' => 'Maya Safitri',
                'nisn' => '0068212105',
                'nis' => '20240105',
                'rombel' => 'XII RPL 3',
                'industri' => 'PT Telkom Akses',
                'posisi' => 'Fiber Optic & QA System',
                'kehadiran' => 96.0,
                'status' => 'Aktif Magang',
                'gender' => 'P',
                'avatar_color' => 'blue',
            ],
            [
                'no' => '06',
                'nama' => 'Farhan Ramadhan',
                'nisn' => '0068212106',
                'nis' => '20240106',
                'rombel' => 'XII RPL 1',
                'industri' => 'PT Indocyber Global',
                'posisi' => 'Backend Laravel Developer',
                'kehadiran' => 95.5,
                'status' => 'Aktif Magang',
                'gender' => 'L',
                'avatar_color' => 'blue',
            ],
            [
                'no' => '07',
                'nama' => 'Nabila Syahfitri',
                'nisn' => '0068212107',
                'nis' => '20240107',
                'rombel' => 'XII RPL 3',
                'industri' => 'Bank Mandiri IT Digital',
                'posisi' => 'Banking QA Automation',
                'kehadiran' => 99.0,
                'status' => 'Aktif Magang',
                'gender' => 'P',
                'avatar_color' => 'blue',
            ],
            [
                'no' => '08',
                'nama' => 'Gilang Pratama',
                'nisn' => '0068212108',
                'nis' => '20240108',
                'rombel' => 'XII RPL 1',
                'industri' => 'PT Tokopedia (GoTo)',
                'posisi' => 'Mobile Android Dev Team',
                'kehadiran' => 93.8,
                'status' => 'Aktif Magang',
                'gender' => 'L',
                'avatar_color' => 'blue',
            ],
            [
                'no' => '09',
                'nama' => 'Siti Aisyah',
                'nisn' => '0068212109',
                'nis' => '20240109',
                'rombel' => 'XII RPL 2',
                'industri' => 'PT Nusantara Digital',
                'posisi' => 'Cloud DevOps Support',
                'kehadiran' => 91.5,
                'status' => 'Aktif Magang',
                'gender' => 'P',
                'avatar_color' => 'blue',
            ],
            [
                'no' => '10',
                'nama' => 'Rizky Maulana',
                'nisn' => '0068212110',
                'nis' => '20240110',
                'rombel' => 'XII RPL 3',
                'industri' => 'PT Solusi Integrasi Sistem',
                'posisi' => 'Database Trainee',
                'kehadiran' => 88.0,
                'status' => 'Aktif Magang',
                'gender' => 'L',
                'avatar_color' => 'blue',
            ],
            [
                'no' => '11',
                'nama' => 'Tasya Melani',
                'nisn' => '0068212111',
                'nis' => '20240111',
                'rombel' => 'XII RPL 1',
                'industri' => 'DUDI Mitra Mandiri',
                'posisi' => 'Jadwal Wawancara DUDI',
                'kehadiran' => null,
                'status' => 'Menunggu Konfirmasi',
                'gender' => 'P',
                'avatar_color' => 'amber',
            ],
            [
                'no' => '12',
                'nama' => 'Yusuf Bachtiar',
                'nisn' => '0068212112',
                'nis' => '20240112',
                'rombel' => 'XII RPL 3',
                'industri' => 'PT Cybertrend Intrabuana',
                'posisi' => 'Junior Data Analyst',
                'kehadiran' => 97.0,
                'status' => 'Selesai PKL',
                'gender' => 'L',
                'avatar_color' => 'blue',
            ],
        ];

        // 6. Delete old RPL siswa if we want fresh accurate 108 students
        $rplRombelIds = array_map(fn($r) => $r->id, $rombels);
        $oldSiswaIds = Siswa::whereIn('rombel_id', $rplRombelIds)->orWhere('jurusan_id', $jurusan->id)->pluck('id')->all();
        if ($oldSiswaIds) {
            PengajuanPkl::whereIn('siswa_id', $oldSiswaIds)->delete();
            $oldUserIds = Siswa::whereIn('id', $oldSiswaIds)->pluck('user_id')->all();
            Siswa::whereIn('id', $oldSiswaIds)->delete();
            User::whereIn('id', $oldUserIds)->delete();
        }

        $defaultHash = Hash::make('password123');

        // Insert the 12 primary students
        $insertedCount = 0;
        foreach ($primaryStudents as $sData) {
            $username = strtolower(str_replace(' ', '.', $sData['nama']));
            $user = User::create([
                'username' => $username,
                'email' => $username . '@smkn1gunungputri.sch.id',
                'password_hash' => $defaultHash,
                'tipe_akun' => 'siswa',
                'dibuat_pada' => now(),
            ]);

            $rombelObj = $rombels[$sData['rombel']];
            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nis' => $sData['nis'],
                'nisn' => $sData['nisn'],
                'nama' => $sData['nama'],
                'rombel_id' => $rombelObj->id,
                'jurusan_id' => $jurusan->id,
                'kampus' => 'Kampus Utama',
                'jenis_kelamin' => $sData['gender'],
                'status_akun' => 'aktif',
                'status_pkl' => $sData['status'] === 'Menunggu Konfirmasi' ? 'Menunggu Konfirmasi' : ($sData['status'] === 'Selesai PKL' ? 'Selesai' : 'Sedang PKL'),
            ]);

            $indObj = $industriMap[$sData['industri']] ?? null;
            if ($indObj) {
                $statusPengajuan = match($sData['status']) {
                    'Menunggu Konfirmasi' => 'menunggu_kaprog',
                    'Selesai PKL' => 'disetujui',
                    default => 'disetujui'
                };

                PengajuanPkl::create([
                    'siswa_id' => $siswa->id,
                    'industri_id' => $indObj->id,
                    'tanggal_mulai' => '2025-01-06',
                    'tanggal_selesai' => '2025-06-30',
                    'status' => $statusPengajuan,
                    'dibuat_pada' => now()->subDays(rand(10, 60)),
                ]);
            }
            $insertedCount++;
        }

        // Generate remaining students to reach exactly 108 students (36 per rombel)
        // 4 more waiting confirmation (total 6 waiting), rest are active/placed (total 102 placed)
        $firstNames = ['Aditia', 'Bagas', 'Cahya', 'Danu', 'Erlangga', 'Fachri', 'Gathan', 'Hafizh', 'Iqbal', 'Jihan', 'Kevin', 'Laras', 'Maulana', 'Naufal', 'Oktavian', 'Panji', 'Qori', 'Raditya', 'Salwa', 'Tegar', 'Umar', 'Vicky', 'Wulan', 'Xavier', 'Yudha', 'Zahra', 'Aldi', 'Bayu', 'Chandra', 'Daffa', 'Eka', 'Fikri', 'Galih', 'Hendra', 'Ilham', 'Joko'];
        $lastNames = ['Kusuma', 'Saputra', 'Hidayat', 'Wibowo', 'Pratama', 'Nugraha', 'Santoso', 'Utomo', 'Firmansyah', 'Putra', 'Setiawan', 'Rahman', 'Gunawan', 'Lestari', 'Mahendra', 'Suryana', 'Sujana', 'Wijaya', 'Permana', 'Ramadhan'];

        $allIndNames = array_keys($industriMap);

        $needsPerRombel = [
            'XII RPL 1' => 32,
            'XII RPL 2' => 32,
            'XII RPL 3' => 32,
        ];

        $extraWaitingCount = 4; // So total waiting is 2 + 4 = 6
        $nisnCounter = 2113;
        $nisCounter = 20240113;

        foreach ($needsPerRombel as $rName => $count) {
            $rombelObj = $rombels[$rName];
            for ($i = 0; $i < $count; $i++) {
                $fName = $firstNames[($insertedCount + $i) % count($firstNames)];
                $lName = $lastNames[($insertedCount + $i * 3) % count($lastNames)];
                $fullName = $fName . ' ' . $lName;
                $nisn = '006821' . str_pad($nisnCounter, 4, '0', STR_PAD_LEFT);
                $nis = (string)$nisCounter;
                $nisnCounter++;
                $nisCounter++;

                $isWaiting = false;
                if ($extraWaitingCount > 0 && ($i == 2 || $i == 7)) {
                    $isWaiting = true;
                    $extraWaitingCount--;
                }

                $statusText = $isWaiting ? 'Menunggu Konfirmasi' : 'Aktif Magang';
                $statusPkl = $isWaiting ? 'Menunggu Konfirmasi' : 'Sedang PKL';
                $statusPengajuan = $isWaiting ? 'menunggu_kaprog' : 'disetujui';

                $username = strtolower(str_replace(' ', '.', $fullName)) . rand(100, 999);
                $user = User::create([
                    'username' => $username,
                    'email' => $username . '@smkn1gunungputri.sch.id',
                    'password_hash' => $defaultHash,
                    'tipe_akun' => 'siswa',
                    'dibuat_pada' => now(),
                ]);

                $siswa = Siswa::create([
                    'user_id' => $user->id,
                    'nis' => $nis,
                    'nisn' => $nisn,
                    'nama' => $fullName,
                    'rombel_id' => $rombelObj->id,
                    'jurusan_id' => $jurusan->id,
                    'kampus' => 'Kampus Utama',
                    'jenis_kelamin' => ($i % 2 == 0) ? 'L' : 'P',
                    'status_akun' => 'aktif',
                    'status_pkl' => $statusPkl,
                ]);

                $chosenInd = $allIndNames[($insertedCount + $i) % count($allIndNames)];
                $indObj = $industriMap[$chosenInd];

                PengajuanPkl::create([
                    'siswa_id' => $siswa->id,
                    'industri_id' => $indObj->id,
                    'tanggal_mulai' => '2025-01-06',
                    'tanggal_selesai' => '2025-06-30',
                    'status' => $statusPengajuan,
                    'dibuat_pada' => now()->subDays(rand(10, 60)),
                ]);

                $insertedCount++;
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
