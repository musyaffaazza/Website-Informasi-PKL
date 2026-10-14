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
use App\Models\PembimbingPenugasan;

class WaliKelasSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Setup Jurusan RPL
        $jurusan = Jurusan::where('kode', 'RPL')->first();
        if (!$jurusan) {
            $jurusan = Jurusan::create([
                'kode' => 'RPL',
                'nama' => 'Rekayasa Perangkat Lunak',
                'singkatan' => 'RPL',
                'bidang' => 'Teknologi Informasi',
                'status' => 'aktif',
                'kuota_industri' => 120,
                'kuota_terisi' => 102,
                'badge_color' => 'blue',
            ]);
        }

        // 2. Setup Wali Kelas User & Guru
        $waliUser = User::where('username', 'walikelas')->orWhere('email', 'endang.supriyatna@smkn1gunungputri.sch.id')->first();
        if (!$waliUser) {
            $waliUser = User::create([
                'username' => 'walikelas',
                'email' => 'endang.supriyatna@smkn1gunungputri.sch.id',
                'password_hash' => Hash::make('password123'),
                'tipe_akun' => 'guru',
                'dibuat_pada' => now(),
            ]);
        } else {
            $waliUser->update([
                'password_hash' => Hash::make('password123'),
                'tipe_akun' => 'guru',
            ]);
        }

        $waliGuru = Guru::where('nip', '197508142002122003')->orWhere('user_id', $waliUser->id)->first();
        if (!$waliGuru) {
            $waliGuru = Guru::create([
                'user_id' => $waliUser->id,
                'nip' => '197508142002122003',
                'nama' => 'Dra. Hj. Nurhayati, M.Pd.',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan' => 'S2 Manajemen Pendidikan',
                'email' => 'nurhayati@smkn1gunungputri.sch.id',
                'no_hp' => '081234567891',
                'status_akun' => 'aktif',
                'roles_list' => ['Wali Kelas'],
                'kelas_diampu' => 'XII RPL 2',
                'keterangan_diampu' => 'Wali Kelas XII RPL 2',
                'jurusan_id' => $jurusan->id,
            ]);
        } else {
            $waliGuru->update([
                'user_id' => $waliUser->id,
                'nip' => '197508142002122003',
                'nama' => 'Dra. Hj. Nurhayati, M.Pd.',
                'roles_list' => ['Wali Kelas'],
                'kelas_diampu' => 'XII RPL 2',
                'keterangan_diampu' => 'Wali Kelas XII RPL 2',
                'status_akun' => 'aktif',
                'jurusan_id' => $jurusan->id,
            ]);
        }

        // 3. Setup Rombel XII RPL 2
        $rombel = Rombel::where('nama_kode', 'XII RPL 2')->orWhere('nama_rombel', 'XII RPL 2')->first();
        if (!$rombel) {
            $rombel = Rombel::create([
                'kode_rombel' => 'XII-RPL-2',
                'nama_kode' => 'XII RPL 2',
                'nama_rombel' => 'XII RPL 2',
                'tingkat' => 'XII',
                'ruang' => 'Lab RPL 2',
                'jurusan_id' => $jurusan->id,
                'wali_kelas_guru_id' => $waliGuru->id,
                'jumlah_siswa' => 36,
                'siswa_terdata' => 36,
                'status_pkl' => 'aktif',
                'tahun_ajaran' => '2024/2026',
                'semester' => 'Genap',
                'status' => 'aktif',
            ]);
        } else {
            $rombel->update([
                'nama_kode' => 'XII RPL 2',
                'nama_rombel' => 'XII RPL 2',
                'wali_kelas_guru_id' => $waliGuru->id,
                'jumlah_siswa' => 36,
                'siswa_terdata' => 36,
                'status_pkl' => 'aktif',
                'jurusan_id' => $jurusan->id,
            ]);
        }

        // 4. Setup Guru Pembimbing
        $pembimbingList = [
            ['nama' => 'Drs. Bambang Wijaya', 'nip' => '197503152002121002', 'email' => 'bambang.wijaya@smkn1gunungputri.sch.id'],
            ['nama' => 'Budi Santoso, S.Kom', 'nip' => '198107222006041008', 'email' => 'budi.santoso@smkn1gunungputri.sch.id'],
            ['nama' => 'Ir. Eko Prasetyo', 'nip' => '197904122005021005', 'email' => 'eko.prasetyo@smkn1gunungputri.sch.id'],
            ['nama' => 'Dra. Hj. Nurhayati', 'nip' => '196811241994032001', 'email' => 'nurhayati@smkn1gunungputri.sch.id'],
        ];

        $guruMap = [];
        foreach ($pembimbingList as $p) {
            $g = Guru::where('nip', $p['nip'])->orWhere('nama', $p['nama'])->first();
            if (!$g) {
                $uName = strtolower(str_replace(['.', ' ', ','], '', $p['nama'])) . rand(10, 99);
                $u = User::create([
                    'username' => $uName,
                    'email' => $p['email'],
                    'password_hash' => Hash::make('password123'),
                    'tipe_akun' => 'guru',
                    'dibuat_pada' => now(),
                ]);

                $g = Guru::create([
                    'user_id' => $u->id,
                    'nip' => $p['nip'],
                    'nama' => $p['nama'],
                    'jenis_kelamin' => 'Laki-laki',
                    'email' => $p['email'],
                    'status_akun' => 'aktif',
                    'roles_list' => ['Pembimbing PKL'],
                    'jurusan_id' => $jurusan->id,
                ]);
            }
            $guruMap[$p['nama']] = $g;
        }

        // 5. Setup Industri Mitra
        $industrisData = [
            ['nama' => 'PT Telkom Akses', 'bidang' => 'Telekomunikasi / Network Support', 'alamat' => 'Bogor & Cibinong Network Area', 'wilayah' => 'Bogor'],
            ['nama' => 'PT Bukaka Teknik Utama', 'bidang' => 'Engineering & Web Development', 'alamat' => 'Jl. Raya Narogong Km 19.5, Cileungsi', 'wilayah' => 'Bogor'],
            ['nama' => 'CV Media Solusi Digital', 'bidang' => 'UI/UX & Web Frontend', 'alamat' => 'Jl. Raya Pajajaran No. 42, Bogor', 'wilayah' => 'Bogor'],
            ['nama' => 'PT Nusantara Digital', 'bidang' => 'Software & Cloud Service', 'alamat' => 'Kawasan Industri Sentul, Bogor', 'wilayah' => 'Bogor'],
            ['nama' => 'PT Astra Honda Motor', 'bidang' => 'Automotive & Enterprise IT', 'alamat' => 'Kawasan MM2100, Cikarang', 'wilayah' => 'Bekasi'],
            ['nama' => 'PT Solusi Inovasi Teknologi', 'bidang' => 'QA & Software Development', 'alamat' => 'Cyber 2 Tower, Kuningan', 'wilayah' => 'Jakarta Selatan'],
            ['nama' => 'PT Indocyber Global Teknologi', 'bidang' => 'Backend Developer Java / Node.js', 'alamat' => 'Graha Indocyber, Jakarta Barat', 'wilayah' => 'Jakarta Barat'],
            ['nama' => 'PT Solusi Net Pratama', 'bidang' => 'Network Engineer & Cloud Support', 'alamat' => 'Sentul Industrial Estate, Bogor', 'wilayah' => 'Bogor'],
            ['nama' => 'PT Tokopedia (GoTo Group)', 'bidang' => 'E-Commerce Tech', 'alamat' => 'Kuningan, Jakarta Selatan', 'wilayah' => 'Jakarta Selatan'],
            ['nama' => 'PT Bank Central Asia Tbk', 'bidang' => 'Fintech & Banking Solution', 'alamat' => 'BSD City, Tangerang', 'wilayah' => 'Tangerang'],
            ['nama' => 'PT Walden Global Services', 'bidang' => 'IT Consultant', 'alamat' => 'Setiabudi, Jakarta Selatan', 'wilayah' => 'Jakarta Selatan'],
        ];

        $industriMap = [];
        foreach ($industrisData as $ind) {
            $item = Industri::where('nama', $ind['nama'])->first();
            if (!$item) {
                $item = Industri::create([
                    'nama' => $ind['nama'],
                    'bidang_usaha' => $ind['bidang'],
                    'alamat' => $ind['alamat'],
                    'wilayah' => $ind['wilayah'],
                    'kontak_nama' => 'HRD ' . $ind['nama'],
                    'kontak_no_hp' => '081234567890',
                    'kontak_email' => 'hr@' . strtolower(preg_replace('/[^a-z0-9]/', '', $ind['nama'])) . '.com',
                    'latitude' => -6.4827100,
                    'longitude' => 106.9123400,
                    'kuota' => 10,
                    'kuota_terisi' => 8,
                    'status' => 'aktif',
                    'status_kemitraan' => 'Aktif',
                ]);
            }
            if (!DB::table('industri_jurusan')->where('industri_id', $item->id)->where('jurusan_id', $jurusan->id)->exists()) {
                DB::table('industri_jurusan')->insert([
                    'industri_id' => $item->id,
                    'jurusan_id' => $jurusan->id,
                ]);
            }
            $industriMap[$ind['nama']] = $item;
        }

        // 6. Delete previous students in XII RPL 2 to ensure clean 36 students
        $oldSiswas = Siswa::where('rombel_id', $rombel->id)->get();
        foreach ($oldSiswas as $os) {
            PengajuanPkl::where('siswa_id', $os->id)->delete();
            PembimbingPenugasan::where('siswa_id', $os->id)->delete();
            DB::table('approval')->where('pengajuan_id', $os->pengajuanPkl?->id)->delete();
            DB::table('absensi')->where('siswa_id', $os->id)->delete();
            DB::table('jurnal')->where('siswa_id', $os->id)->delete();
            DB::table('penilaian')->where('siswa_id', $os->id)->delete();
            $osUserId = $os->user_id;
            $os->delete();
            if ($osUserId) {
                User::where('id', $osUserId)->delete();
            }
        }

        // 7. Seed 36 Students for XII RPL 2
        // Primary 7 students from screenshot
        $primary = [
            [
                'nama' => 'Raka Pratama',
                'nisn' => '0068192341',
                'nis' => '24251201',
                'industri' => 'PT Telkom Akses',
                'posisi' => 'Network Support',
                'pembimbing' => 'Drs. Bambang Wijaya',
                'kehadiran_persen' => 96,
                'kehadiran_hari' => '48 / 50 hari',
                'hadir_count' => 48,
                'total_hari' => 50,
                'status' => 'Berjalan',
                'catatan' => null,
            ],
            [
                'nama' => 'Siti Nur Haliza',
                'nisn' => '0067341290',
                'nis' => '24251202',
                'industri' => 'PT Bukaka Teknik Utama',
                'posisi' => 'Junior Web Dev',
                'pembimbing' => 'Budi Santoso, S.Kom',
                'kehadiran_persen' => 94,
                'kehadiran_hari' => '47 / 50 hari',
                'hadir_count' => 47,
                'total_hari' => 50,
                'status' => 'Berjalan',
                'catatan' => null,
            ],
            [
                'nama' => 'Dimas Kurniawan',
                'nisn' => '0064019283',
                'nis' => '24251203',
                'industri' => 'CV Media Solusi Digital',
                'posisi' => 'UI Designer',
                'pembimbing' => null, // Pembimbing Belum Ditugaskan
                'kehadiran_persen' => 0,
                'kehadiran_hari' => 'Belum Mulai',
                'hadir_count' => 0,
                'total_hari' => 0,
                'status' => 'Menunggu Persetujuan',
                'catatan' => 'Berkas MoU & Form 1A Baru',
            ],
            [
                'nama' => 'Maya Safitri',
                'nisn' => '0061928473',
                'nis' => '24251204',
                'industri' => 'PT Nusantara Digital',
                'posisi' => 'Frontend Dev',
                'pembimbing' => 'Drs. Bambang Wijaya',
                'kehadiran_persen' => 98,
                'kehadiran_hari' => '49 / 50 hari',
                'hadir_count' => 49,
                'total_hari' => 50,
                'status' => 'Berjalan',
                'catatan' => null,
            ],
            [
                'nama' => 'Fajar Adriansyah',
                'nisn' => '0062910482',
                'nis' => '24251205',
                'industri' => 'PT Astra Honda Motor',
                'posisi' => 'IT Support',
                'pembimbing' => 'Ir. Eko Prasetyo',
                'kehadiran_persen' => 86,
                'kehadiran_hari' => '43 / 50 hari',
                'hadir_count' => 43,
                'total_hari' => 50,
                'status' => 'Berjalan',
                'catatan' => null,
            ],
            [
                'nama' => 'Bagas Prakoso',
                'nisn' => '0063920194',
                'nis' => '24251206',
                'industri' => 'PT Solusi Inovasi Teknologi',
                'posisi' => 'QA Tester',
                'pembimbing' => 'Dra. Hj. Nurhayati',
                'kehadiran_persen' => 100,
                'kehadiran_hari' => '50 / 50 hari',
                'hadir_count' => 50,
                'total_hari' => 50,
                'status' => 'Selesai',
                'catatan' => 'Sidang PKL: Terjadwal 24 Mei',
            ],
            [
                'nama' => 'Anisa Rahmawati',
                'nisn' => '0065182901',
                'nis' => '24251207',
                'industri' => 'PT Indocyber Global Teknologi',
                'posisi' => 'Backend Dev',
                'pembimbing' => 'Budi Santoso, S.Kom',
                'kehadiran_persen' => 0,
                'kehadiran_hari' => 'Belum Mulai',
                'hadir_count' => 0,
                'total_hari' => 0,
                'status' => 'Menunggu Persetujuan',
                'catatan' => 'Surat Rekomendasi Perusahaan',
            ],
        ];

        // 29 additional students:
        // We need exactly:
        // - Sedang Berjalan: 31 (primary has 4: Raka, Siti, Maya, Fajar. We need 27 more!)
        // - Menunggu Persetujuan: 3 (primary has 2: Dimas, Anisa. We need 1 more!)
        // - Selesai PKL: 2 (primary has 1: Bagas. We need 1 more!)
        // Total = 4 + 27 + 2 + 1 + 1 + 1 = 36!
        $namesPool = [
            'Aditia Nugraha', 'Alif Pratama', 'Bayu Setiawan', 'Candra Wijaya', 'Daffa Ramadhan',
            'Denny Saputra', 'Erlangga Putra', 'Farhan Hidayat', 'Galih Kurnia', 'Hafizh Santoso',
            'Ilham Maulana', 'Jihan Safira', 'Kevin Alexander', 'Laras Salsabila', 'Muhammad Rizky',
            'Nabila Putri', 'Oktavian Dwi', 'Panji Asmoro', 'Qori Amelia', 'Raditya Pratama',
            'Rian Hidayat', 'Salwa Nurul', 'Tegar Prasetya', 'Umar Faruq', 'Vina Melati',
            'Wahyu Saputra', 'Xavier Daniswara', 'Yusuf Bachtiar', 'Zahra Aulia'
        ];

        $positionsPool = [
            'Frontend Dev', 'Backend Dev', 'Fullstack Web', 'Mobile Flutter Dev',
            'UI/UX Designer', 'Network Engineer', 'IT Helpdesk', 'Database Support', 'QA Analyst'
        ];

        $pembimbingNames = ['Drs. Bambang Wijaya', 'Budi Santoso, S.Kom', 'Ir. Eko Prasetyo', 'Dra. Hj. Nurhayati'];
        $indKeys = array_keys($industriMap);

        $studentsToInsert = $primary;

        $nisnCounter = 65200000;
        $nisCounter = 24251208;

        foreach ($namesPool as $idx => $n) {
            // Index 0 -> 1 more Menunggu Persetujuan (Total 3)
            // Index 1 -> 1 more Selesai (Total 2)
            // Index 2..28 -> Berjalan (Total 27 + 4 = 31)
            if ($idx === 0) {
                $status = 'Menunggu Persetujuan';
                $kehadiran = 0;
                $kehadiranHari = 'Belum Mulai';
                $hadir = 0;
                $totalH = 0;
                $pembimbingName = null;
                $catatan = 'Portofolio Sertifikasi Mikrotik MTCNA';
                $curNama = 'Farhan Maulana';
                $curNisn = '0067341908';
                $curInd = 'PT Solusi Net Pratama';
                $curPos = 'Network Engineer & Cloud Support';
            } elseif ($idx === 1) {
                $status = 'Selesai';
                $kehadiran = 100;
                $kehadiranHari = '50 / 50 hari';
                $hadir = 50;
                $totalH = 50;
                $pembimbingName = $pembimbingNames[$idx % count($pembimbingNames)];
                $catatan = 'Lulus Uji Kompetensi PKL';
                $curNama = $n;
                $curNisn = '00' . ($nisnCounter + $idx);
                $curInd = $indKeys[$idx % count($indKeys)];
                $curPos = $positionsPool[$idx % count($positionsPool)];
            } else {
                $status = 'Berjalan';
                $hadir = rand(42, 49);
                $totalH = 50;
                $kehadiran = round(($hadir / $totalH) * 100);
                $kehadiranHari = "{$hadir} / {$totalH} hari";
                $pembimbingName = $pembimbingNames[$idx % count($pembimbingNames)];
                $catatan = null;
                $curNama = $n;
                $curNisn = '00' . ($nisnCounter + $idx);
                $curInd = $indKeys[$idx % count($indKeys)];
                $curPos = $positionsPool[$idx % count($positionsPool)];
            }

            $studentsToInsert[] = [
                'nama' => $curNama,
                'nisn' => $curNisn,
                'nis' => (string)($nisCounter + $idx),
                'industri' => $curInd,
                'posisi' => $curPos,
                'pembimbing' => $pembimbingName,
                'kehadiran_persen' => $kehadiran,
                'kehadiran_hari' => $kehadiranHari,
                'hadir_count' => $hadir,
                'total_hari' => $totalH,
                'status' => $status,
                'catatan' => $catatan,
            ];
        }

        $defaultHash = Hash::make('password123');

        foreach ($studentsToInsert as $sData) {
            $uName = strtolower(str_replace(' ', '.', $sData['nama'])) . rand(10, 99);
            $user = User::create([
                'username' => $uName,
                'email' => $uName . '@smkn1gunungputri.sch.id',
                'password_hash' => $defaultHash,
                'tipe_akun' => 'siswa',
                'dibuat_pada' => now(),
            ]);

            $statusPkl = match ($sData['status']) {
                'Menunggu Persetujuan' => 'Menunggu Konfirmasi',
                'Selesai' => 'Selesai',
                default => 'Sedang PKL',
            };

            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nis' => $sData['nis'],
                'nisn' => $sData['nisn'],
                'nama' => $sData['nama'],
                'rombel_id' => $rombel->id,
                'jurusan_id' => $jurusan->id,
                'kampus' => 'Kampus Utama',
                'jenis_kelamin' => in_array($sData['nama'], ['Siti Nur Haliza', 'Maya Safitri', 'Anisa Rahmawati', 'Jihan Safira', 'Laras Salsabila', 'Nabila Putri', 'Qori Amelia', 'Salwa Nurul', 'Vina Melati', 'Zahra Aulia']) ? 'P' : 'L',
                'status_akun' => 'aktif',
                'status_pkl' => $statusPkl,
            ]);

            $indObj = $industriMap[$sData['industri']] ?? null;
            if ($indObj) {
                $statusPengajuan = match ($sData['status']) {
                    'Menunggu Persetujuan' => 'menunggu_walikelas',
                    'Selesai' => 'disetujui',
                    default => 'disetujui',
                };

                $pengajuan = PengajuanPkl::create([
                    'siswa_id' => $siswa->id,
                    'industri_id' => $indObj->id,
                    'tanggal_mulai' => '2025-01-06',
                    'tanggal_selesai' => '2025-06-30',
                    'status' => $statusPengajuan,
                    'dibuat_pada' => now()->subDays(rand(10, 60)),
                ]);

                // Pembimbing Penugasan
                if ($sData['pembimbing']) {
                    $guruPembimbing = $guruMap[$sData['pembimbing']] ?? null;
                    if ($guruPembimbing) {
                        PembimbingPenugasan::create([
                            'siswa_id' => $siswa->id,
                            'pengajuan_id' => $pengajuan->id,
                            'pembimbing_guru_id' => $guruPembimbing->id,
                            'tanggal_mulai' => '2025-01-06',
                        ]);
                    }
                }

                // Approval record
                $approvalStatus = match ($sData['status']) {
                    'Menunggu Persetujuan' => 'menunggu',
                    default => 'disetujui',
                };

                DB::table('approval')->insert([
                    'pengajuan_id' => $pengajuan->id,
                    'guru_id' => $waliGuru->id,
                    'tahap' => 'walikelas',
                    'status' => $approvalStatus,
                    'catatan' => $sData['catatan'] ?: 'Dokumen PKL terverifikasi oleh Wali Kelas.',
                    'diproses_pada' => $approvalStatus === 'disetujui' ? now()->subDays(15) : null,
                ]);

                // Selesai -> Penilaian record
                if ($sData['status'] === 'Selesai') {
                    $guruEvaluator = $guruMap[$sData['pembimbing']] ?? $waliGuru;
                    DB::table('penilaian')->insert([
                        'siswa_id' => $siswa->id,
                        'pengajuan_id' => $pengajuan->id,
                        'guru_id' => $guruEvaluator->id,
                        'nilai_pembimbing' => 92.00,
                        'nilai_industri' => 95.00,
                        'nilai_akhir' => 93.50,
                        'catatan' => 'Tuntas seluruh target kompetensi dan sidang laporan PKL.',
                        'dinilai_pada' => now()->subDays(2),
                    ]);
                }

                // Seed journals for Raka Pratama
                if ($sData['nama'] === 'Raka Pratama') {
                    DB::table('jurnal')->insert([
                        [
                            'siswa_id' => $siswa->id,
                            'guru_id' => $waliGuru->id,
                            'tanggal' => '2026-09-07',
                            'kegiatan' => 'Pemeliharaan Server Rack, Patching Kabel Patch Cord Cat6, dan Pengujian Konektivitas Switch Core',
                            'deskripsi' => 'Pada hari ini, saya mendampingi tim teknis divisi Network Operations Center (NOC) PT Telkom Akses Bogor dalam melakukan perawatan rutin dan manajemen perkabelan di ruang server data center lantai 2.',
                            'hasil' => 'Identifikasi & Labeling Port: Memeriksa dan memperbarui label port ethernet pada patch panel 24-port Cat6 sesuai denah topologi rak C-04. Re-patching Kabel Patch Cord: Mengganti 12 unit kabel patch cord yang sudah aus dengan kabel baru warna biru standar ANSI/TIA-568-C.2 dan merapikannya melalui cable management duct vertical. Testing & Verifikasi Koneksi: Melakukan ping test dan trace route dari switch distribution menuju core router gateway untuk memastikan packet loss 0% dan latency berada di bawah 2ms. Pencatatan Logbook Fisik Ruang Server: Mengisi buku kendali inventaris ruangan bersama mentor industri Bpk. Hendra Kurniawan.',
                            'kendala' => 'Terdapat 1 konektor RJ-45 yang crimping-nya longgar pada port 18 switch B.',
                            'solusi' => 'Telah diterminasi ulang menggunakan crimping tool dan kabel tester LAN dengan hasil 8 pin menyala normal.',
                            'bukti_url' => 'Dokumentasi_Server_Rack_07092026.jpg',
                            'status' => 'diajukan',
                            'dibuat_pada' => '2026-09-07 16:30:00',
                        ],
                        [
                            'siswa_id' => $siswa->id,
                            'guru_id' => $waliGuru->id,
                            'tanggal' => '2026-09-04',
                            'kegiatan' => 'Konfigurasi VLAN & Port Security pada Switch Distribution',
                            'deskripsi' => 'Membantu tim NOC dalam segmentasi jaringan VLAN untuk divisi operasional kantor.',
                            'hasil' => 'Isolasi trafik per VLAN berhasil diimplementasikan pada 24 port.',
                            'kendala' => 'Tidak ada kendala.',
                            'solusi' => 'Berjalan normal sesuai SOP Telkom Akses.',
                            'bukti_url' => 'vlan_config.jpg',
                            'status' => 'disetujui',
                            'dibuat_pada' => '2026-09-04 16:30:00',
                        ],
                        [
                            'siswa_id' => $siswa->id,
                            'guru_id' => $waliGuru->id,
                            'tanggal' => '2026-09-03',
                            'kegiatan' => 'Monitoring Bandwidth & Traffic Menggunakan PRTG Network Monitor',
                            'deskripsi' => 'Pemantauan grafik utilisasi link fiber optic dan latency gateway.',
                            'hasil' => 'Data grafik tersimpan di dashboard NOC.',
                            'kendala' => 'Lonjakan trafik sesaat pada jam makan siang.',
                            'solusi' => 'Traffic shaping otomatis berjalan normal.',
                            'bukti_url' => 'prtg_traffic.jpg',
                            'status' => 'disetujui',
                            'dibuat_pada' => '2026-09-03 16:30:00',
                        ],
                        [
                            'siswa_id' => $siswa->id,
                            'guru_id' => $waliGuru->id,
                            'tanggal' => '2026-09-02',
                            'kegiatan' => 'Pemasangan Access Point Wi-Fi 6 di Area Perkantoran Lantai 3',
                            'deskripsi' => 'Deploy 4 unit AP dan terminasi kabel PoE Cat6.',
                            'hasil' => 'Cakupan sinyal Wi-Fi mencapai -55 dBm di seluruh area kerja.',
                            'kendala' => 'Jalur ducting plafon sempit.',
                            'solusi' => 'Menggunakan wire puller berhati-hati.',
                            'bukti_url' => 'ap_install.jpg',
                            'status' => 'disetujui',
                            'dibuat_pada' => '2026-09-02 16:30:00',
                        ],
                        [
                            'siswa_id' => $siswa->id,
                            'guru_id' => $waliGuru->id,
                            'tanggal' => '2026-09-01',
                            'kegiatan' => 'Backup Konfigurasi Router & Switch Berkala Awal Bulan',
                            'deskripsi' => 'Mengunduh running-config dari 15 perangkat jaringan ke TFTP server.',
                            'hasil' => 'File arsip konfigurasi tersimpan aman di server NAS.',
                            'kendala' => 'Tidak ada kendala.',
                            'solusi' => 'Selesai tepat waktu.',
                            'bukti_url' => 'backup_config.jpg',
                            'status' => 'disetujui',
                            'dibuat_pada' => '2026-09-01 16:30:00',
                        ],
                    ]);

                    // Seed attendance (Absensi) matching exactly the screenshot
                    // September 2026 (16 days hadir + 1 day sakit)
                    $septemberAbsensis = [
                        ['tanggal' => '2026-09-01', 'status' => 'hadir', 'jam_masuk' => '07:42:00', 'jam_keluar' => '17:05:00', 'keterangan' => 'Perawatan Kabel Jaringan', 'bukti_url' => null],
                        ['tanggal' => '2026-09-02', 'status' => 'hadir', 'jam_masuk' => '07:50:00', 'jam_keluar' => '17:02:00', 'keterangan' => 'Instalasi AP Wi-Fi 6', 'bukti_url' => null],
                        ['tanggal' => '2026-09-03', 'status' => 'hadir', 'jam_masuk' => '07:44:00', 'jam_keluar' => '17:15:00', 'keterangan' => 'Monitoring PRTG', 'bukti_url' => null],
                        ['tanggal' => '2026-09-04', 'status' => 'hadir', 'jam_masuk' => '07:38:00', 'jam_keluar' => '16:45:00', 'keterangan' => 'Konfigurasi VLAN', 'bukti_url' => null],
                        ['tanggal' => '2026-09-07', 'status' => 'hadir', 'jam_masuk' => '07:40:00', 'jam_keluar' => '17:10:00', 'keterangan' => 'Maintenance Server Rack Lantai 2', 'bukti_url' => null],
                        ['tanggal' => '2026-09-08', 'status' => 'hadir', 'jam_masuk' => '07:45:00', 'jam_keluar' => '17:00:00', 'keterangan' => 'Dokumentasi Switch Core', 'bukti_url' => null],
                        ['tanggal' => '2026-09-09', 'status' => 'sakit', 'jam_masuk' => null, 'jam_keluar' => null, 'keterangan' => 'Surat Dokter Terunggah', 'bukti_url' => 'Surat_Dokter_Klinik_Medika.pdf'],
                        ['tanggal' => '2026-09-10', 'status' => 'hadir', 'jam_masuk' => '07:49:00', 'jam_keluar' => '17:05:00', 'keterangan' => 'Supervisi Jaringan Ruang NOC', 'bukti_url' => null],
                        ['tanggal' => '2026-09-11', 'status' => 'hadir', 'jam_masuk' => '07:35:00', 'jam_keluar' => '17:20:00', 'keterangan' => 'Verifikasi Konektivitas OLT & Core', 'bukti_url' => null],
                        ['tanggal' => '2026-09-14', 'status' => 'hadir', 'jam_masuk' => '07:41:00', 'jam_keluar' => '17:00:00', 'keterangan' => 'Inspeksi Ruang Rack', 'bukti_url' => null],
                        ['tanggal' => '2026-09-15', 'status' => 'hadir', 'jam_masuk' => '07:44:00', 'jam_keluar' => '17:12:00', 'keterangan' => 'Crimping Patch Cord Cat6', 'bukti_url' => null],
                        ['tanggal' => '2026-09-16', 'status' => 'hadir', 'jam_masuk' => '07:48:00', 'jam_keluar' => '17:00:00', 'keterangan' => 'Pengujian Throughput', 'bukti_url' => null],
                        ['tanggal' => '2026-09-17', 'status' => 'hadir', 'jam_masuk' => '07:40:00', 'jam_keluar' => '17:15:00', 'keterangan' => 'Pembersihan Filter Server', 'bukti_url' => null],
                        ['tanggal' => '2026-09-18', 'status' => 'hadir', 'jam_masuk' => '07:39:00', 'jam_keluar' => '16:50:00', 'keterangan' => 'Penarikan kabel FO Patchcord', 'bukti_url' => null],
                        ['tanggal' => '2026-09-21', 'status' => 'hadir', 'jam_masuk' => '07:42:00', 'jam_keluar' => '17:00:00', 'keterangan' => 'Maintenance Switch Core', 'bukti_url' => null],
                        ['tanggal' => '2026-09-22', 'status' => 'hadir', 'jam_masuk' => '07:45:00', 'jam_keluar' => '17:05:00', 'keterangan' => 'Logbook selesai terverifikasi', 'bukti_url' => null],
                    ];

                    foreach ($septemberAbsensis as $ab) {
                        DB::table('absensi')->updateOrInsert(
                            ['siswa_id' => $siswa->id, 'tanggal' => $ab['tanggal']],
                            [
                                'status' => $ab['status'],
                                'jam_masuk' => $ab['jam_masuk'],
                                'jam_keluar' => $ab['jam_keluar'],
                                'keterangan' => $ab['keterangan'],
                                'bukti_url' => $ab['bukti_url'],
                                'dibuat_pada' => $ab['tanggal'] . ' 07:30:00',
                            ]
                        );
                    }

                    // August 2026 entries
                    $currentAug = \Carbon\Carbon::parse('2026-08-01');
                    while ($currentAug->month == 8) {
                        if (!$currentAug->isWeekend() && $currentAug->day != 17) { // 17 Aug holiday
                            DB::table('absensi')->updateOrInsert(
                                ['siswa_id' => $siswa->id, 'tanggal' => $currentAug->format('Y-m-d')],
                                [
                                    'status' => 'hadir',
                                    'jam_masuk' => '07:45:00',
                                    'jam_keluar' => '17:00:00',
                                    'keterangan' => 'Presensi Kerja NOC Area Bogor',
                                    'bukti_url' => null,
                                    'dibuat_pada' => $currentAug->format('Y-m-d') . ' 07:30:00',
                                ]
                            );
                        }
                        $currentAug->addDay();
                    }

                    // July 2026 entries (Orientation & initial PKL deployment starting 15 July)
                    $currentJul = \Carbon\Carbon::parse('2026-07-15');
                    while ($currentJul->month == 7) {
                        if (!$currentJul->isWeekend()) {
                            DB::table('absensi')->updateOrInsert(
                                ['siswa_id' => $siswa->id, 'tanggal' => $currentJul->format('Y-m-d')],
                                [
                                    'status' => 'hadir',
                                    'jam_masuk' => '07:50:00',
                                    'jam_keluar' => '17:00:00',
                                    'keterangan' => 'Orientasi Lapangan & Onboarding NOC',
                                    'bukti_url' => null,
                                    'dibuat_pada' => $currentJul->format('Y-m-d') . ' 07:30:00',
                                ]
                            );
                        }
                        $currentJul->addDay();
                    }
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
