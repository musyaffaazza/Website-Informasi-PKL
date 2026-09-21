<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;
use App\Models\Jurusan;

class GuruDisplaySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Get Jurusan IDs
        $rpl = Jurusan::where('kode', 'RPL')->first();
        $toi = Jurusan::where('kode', 'TOI')->first();
        $tp  = Jurusan::where('kode', 'TP')->first();
        $ka  = Jurusan::where('kode', 'KA')->first();
        $tpl = Jurusan::where('kode', 'TPL')->first();

        // 10 Teachers from the screenshot (Page 1)
        $featuredGurus = [
            [
                'nip' => '197805122005011008',
                'nuptk' => '9438 7566 5820 0012',
                'nama' => 'Ir. Dian Hendrawan, S.Kom., M.T.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S2 Teknik Informatika',
                'avatar_url' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80',
                'roles_list' => ['Kaprog RPL', 'Pembimbing PKL', 'Guru Penguji'],
                'kelas_diampu' => 'Rekayasa Perangkat Lunak',
                'keterangan_diampu' => 'XII RPL 1, 2, 3 • Supervisi 24 Mitra',
                'status_akun' => 'aktif',
                'jurusan_id' => $rpl ? $rpl->id : null,
            ],
            [
                'nip' => '198503142009022004',
                'nuptk' => '1042 7636 6430 0081',
                'nama' => 'Siti Rahmawati, S.Kom.',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan' => 'S1 Sistem Informasi',
                'avatar_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100&auto=format&fit=crop&q=80',
                'roles_list' => ['Wali Kelas XII RPL 1', 'Pembimbing PKL'],
                'kelas_diampu' => 'XII RPL 1 (Wali Kelas)',
                'keterangan_diampu' => '36 Siswa Binaan • 8 Mitra DUDI',
                'status_akun' => 'aktif',
                'jurusan_id' => $rpl ? $rpl->id : null,
            ],
            [
                'nip' => '197211041998021002',
                'nuptk' => '6549 7506 5220 0003',
                'nama' => 'Drs. Bambang Wijaya, M.Pd.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S2 Manajemen Pendidikan',
                'avatar_url' => null,
                'roles_list' => ['Wali Kelas XII RPL 2', 'Pembimbing PKL'],
                'kelas_diampu' => 'XII RPL 2 (Wali Kelas)',
                'keterangan_diampu' => '35 Siswa Binaan • 6 Mitra DUDI',
                'status_akun' => 'aktif',
                'jurusan_id' => $rpl ? $rpl->id : null,
            ],
            [
                'nip' => '196908151994121001',
                'nuptk' => '4351 7476 4920 0011',
                'nama' => 'Drs. H. Suryana, M.Pd.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S2 Kurikulum & Pembelajaran',
                'avatar_url' => null,
                'roles_list' => ['Koordinator Hubin', 'Pembimbing PKL'],
                'kelas_diampu' => 'Koordinator Seluruh Jurusan',
                'keterangan_diampu' => 'Kemitraan 74 DUDI Mitra Nasional',
                'status_akun' => 'aktif',
                'jurusan_id' => $toi ? $toi->id : null,
            ],
            [
                'nip' => '198710202011011007',
                'nuptk' => '8740 7656 6620 0042',
                'nama' => 'Ahmad Fauzi, S.Pd., M.Kom.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S2 Ilmu Komputer',
                'avatar_url' => null,
                'roles_list' => ['Wali Kelas XII RPL 3', 'Pembimbing PKL'],
                'kelas_diampu' => 'XII RPL 3 (Wali Kelas)',
                'keterangan_diampu' => '36 Siswa Binaan • 7 Mitra DUDI',
                'status_akun' => 'aktif',
                'jurusan_id' => $rpl ? $rpl->id : null,
            ],
            [
                'nip' => '199004082015032003',
                'nuptk' => '2341 7686 6930 0019',
                'nama' => 'Rina Marlina, S.T.',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan' => 'S1 Teknik Informatika',
                'avatar_url' => null,
                'roles_list' => ['Pembimbing PKL', 'Guru Kejuruan RPL'],
                'kelas_diampu' => 'XII RPL 1 & XII RPL 2',
                'keterangan_diampu' => 'Supervisi 14 Siswa PT Astra Otoparts',
                'status_akun' => 'aktif',
                'jurusan_id' => $rpl ? $rpl->id : null,
            ],
            [
                'nip' => '199109032019031008',
                'nuptk' => '9042 7696 7020 0008',
                'nama' => 'Budi Santoso, S.Pd.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S1 Pendidikan Teknik Mesin',
                'avatar_url' => null,
                'roles_list' => ['Guru Pembimbing'],
                'kelas_diampu' => 'Teknik Pemesinan (TP)',
                'keterangan_diampu' => 'Supervisi 12 Siswa Kawasan Menara',
                'status_akun' => 'aktif',
                'jurusan_id' => $tp ? $tp->id : null,
            ],
            [
                'nip' => '197103111997031004',
                'nuptk' => '3219 7496 5120 0014',
                'nama' => 'Drs. M. Yusuf',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S1 Pendidikan Kimia',
                'avatar_url' => null,
                'roles_list' => [],
                'kelas_diampu' => 'Belum teralokasi di Rombel/PKL',
                'keterangan_diampu' => null,
                'status_akun' => 'nonaktif',
                'jurusan_id' => $ka ? $ka->id : null,
            ],
        ];

        // Clear existing guru to ensure 86 clean records matching the stats
        Guru::truncate();

        $savedCount = 0;
        foreach ($featuredGurus as $g) {
            $savedCount++;
            $username = 'guru_' . $savedCount;
            $email = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $g['nama'])[0])) . $savedCount . '@guru.sch.id';

            $user = DB::table('users')->where('username', $username)->first();
            if (!$user) {
                $userId = DB::table('users')->insertGetId([
                    'username' => $username,
                    'email' => $email,
                    'password_hash' => Hash::make('password123'),
                    'tipe_akun' => 'guru',
                    'dibuat_pada' => now(),
                ]);
            } else {
                $userId = $user->id;
            }

            Guru::create([
                'user_id' => $userId,
                'nip' => $g['nip'],
                'nuptk' => $g['nuptk'],
                'nama' => $g['nama'],
                'jenis_kelamin' => $g['jenis_kelamin'],
                'pendidikan' => $g['pendidikan'],
                'avatar_url' => $g['avatar_url'],
                'no_hp' => '0812' . rand(10000000, 99999999),
                'email' => $email,
                'status_akun' => $g['status_akun'],
                'roles_list' => $g['roles_list'],
                'kelas_diampu' => $g['kelas_diampu'],
                'keterangan_diampu' => $g['keterangan_diampu'],
                'jurusan_id' => $g['jurusan_id'],
            ]);
        }

        // Remaining Kaprogs (Total 5 Kaprogs: RPL, TOI, TP, KA, TPL)
        $otherKaprogs = [
            [
                'nip' => '197011051998022001',
                'nuptk' => '2145 7486 5230 0010',
                'nama' => 'Dra. Hj. Nurhayati, M.Pd.',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan' => 'S2 Kimia Terapan',
                'roles_list' => ['Kaprog KA', 'Pembimbing PKL'],
                'kelas_diampu' => 'Kimia Analisis',
                'keterangan_diampu' => 'XII KA 1, 2 • Supervisi 16 Mitra',
                'status_akun' => 'aktif',
                'jurusan_id' => $ka ? $ka->id : null,
            ],
            [
                'nip' => '198402102010011009',
                'nuptk' => '8432 7626 5120 0025',
                'nama' => 'Suryadi, S.T.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S1 Teknik Pengelasan',
                'roles_list' => ['Kaprog TPL', 'Pembimbing PKL'],
                'kelas_diampu' => 'Teknik Pengelasan & Fabrikasi',
                'keterangan_diampu' => 'XII TPL 1 • Supervisi 12 Mitra',
                'status_akun' => 'aktif',
                'jurusan_id' => $tpl ? $tpl->id : null,
            ],
            [
                'nip' => '197906142006041011',
                'nuptk' => '5431 7576 5010 0033',
                'nama' => 'Mulyadi, M.Pd.',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S2 Otomasi Sistem',
                'roles_list' => ['Kaprog TOI', 'Pembimbing PKL'],
                'kelas_diampu' => 'Teknik Otomasi Industri',
                'keterangan_diampu' => 'XII TOI 1, 2 • Supervisi 20 Mitra',
                'status_akun' => 'aktif',
                'jurusan_id' => $toi ? $toi->id : null,
            ],
            [
                'nip' => '198209252009021004',
                'nuptk' => '9123 7606 5920 0041',
                'nama' => 'Ir. Joko Waskito',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan' => 'S2 Teknik Mesin Industri',
                'roles_list' => ['Kaprog TP', 'Pembimbing PKL'],
                'kelas_diampu' => 'Teknik Pemesinan',
                'keterangan_diampu' => 'XII TP 1, 2 • Supervisi 22 Mitra',
                'status_akun' => 'aktif',
                'jurusan_id' => $tp ? $tp->id : null,
            ],
        ];

        foreach ($otherKaprogs as $g) {
            $savedCount++;
            $username = 'guru_' . $savedCount;
            $email = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $g['nama'])[0])) . $savedCount . '@guru.sch.id';

            $user = DB::table('users')->where('username', $username)->first();
            if (!$user) {
                $userId = DB::table('users')->insertGetId([
                    'username' => $username,
                    'email' => $email,
                    'password_hash' => Hash::make('password123'),
                    'tipe_akun' => 'guru',
                    'dibuat_pada' => now(),
                ]);
            } else {
                $userId = $user->id;
            }

            Guru::create([
                'user_id' => $userId,
                'nip' => $g['nip'],
                'nuptk' => $g['nuptk'],
                'nama' => $g['nama'],
                'jenis_kelamin' => $g['jenis_kelamin'],
                'pendidikan' => $g['pendidikan'],
                'avatar_url' => null,
                'no_hp' => '0812' . rand(10000000, 99999999),
                'email' => $email,
                'status_akun' => $g['status_akun'],
                'roles_list' => $g['roles_list'],
                'kelas_diampu' => $g['kelas_diampu'],
                'keterangan_diampu' => $g['keterangan_diampu'],
                'jurusan_id' => $g['jurusan_id'],
            ]);
        }

        // Generate remaining teachers to reach EXACTLY 86 Guru & GTK:
        // Currently savedCount is 14.
        // We need:
        // - Total Pembimbing PKL: 34 (We currently have 11 with Pembimbing PKL. Need 23 more)
        // - Total Wali Kelas (Tingkat XII): 18 (We currently have 5 with Wali Kelas XII. Need 13 more)
        // - Total Kaprog: 5 (We already have 5: RPL, TOI, TP, KA, TPL)

        $firstNamesM = ['Agus', 'Bambang', 'Cahyono', 'Denny', 'Eko', 'Ferry', 'Gunawan', 'Hendra', 'Iwan', 'Junaedi', 'Kurniawan', 'Lukman', 'Maulana', 'Nugroho', 'Oki', 'Panji', 'Raden', 'Samsul', 'Tri', 'Untung', 'Wahyu', 'Yanto', 'Zaenal', 'Arief', 'Bagus', 'Dharma'];
        $firstNamesF = ['Anisa', 'Citra', 'Dian', 'Endang', 'Fitri', 'Gita', 'Hani', 'Intan', 'Juita', 'Kartika', 'Lia', 'Mega', 'Nita', 'Putri', 'Ratna', 'Sari', 'Tari', 'Utari', 'Vina', 'Wulan', 'Yulia', 'Zulfa', 'Desi', 'Eka', 'Febri', 'Grace'];
        $lastNames = ['Pratama', 'Hidayat', 'Kusuma', 'Saputra', 'Wibowo', 'Nugraha', 'Setiawan', 'Wijaya', 'Siregar', 'Lestari', 'Utami', 'Purnomo', 'Syahputra', 'Santoso', 'Ramadhan', 'Firmansyah', 'Budiman', 'Hakim', 'Nasution', 'Kurnia', 'Suryadi', 'Handayani'];
        $degrees = ['S.Pd.', 'S.Kom.', 'S.T.', 'M.Pd.', 'M.Kom.', 'S.Si.', 'M.T.'];

        $jurusanIds = [$rpl?->id, $toi?->id, $tp?->id, $ka?->id, $tpl?->id];
        $jurusanNames = ['Rekayasa Perangkat Lunak', 'Teknik Otomasi Industri', 'Teknik Pemesinan', 'Kimia Analisis', 'Teknik Pengelasan & Fabrikasi'];

        $pembimbingTarget = 34;
        $waliKelasTarget = 18;

        while ($savedCount < 86) {
            $savedCount++;
            $isMale = ($savedCount % 2 == 1);
            $fn = $isMale ? $firstNamesM[($savedCount) % count($firstNamesM)] : $firstNamesF[($savedCount) % count($firstNamesF)];
            $ln = $lastNames[($savedCount * 3) % count($lastNames)];
            $deg = $degrees[($savedCount) % count($degrees)];
            $fullName = $fn . ' ' . $ln . ', ' . $deg;

            $nip = '19' . rand(70, 99) . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . '20' . rand(10, 23) . ($isMale ? '1' : '2') . str_pad(rand(1, 30), 3, '0', STR_PAD_LEFT);
            $nuptk = rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . str_pad($savedCount, 4, '0', STR_PAD_LEFT);

            $jIdx = $savedCount % count($jurusanIds);
            $currentJId = $jurusanIds[$jIdx];
            $currentJName = $jurusanNames[$jIdx];

            // Allocate roles
            $currentPembimbingCount = Guru::whereJsonContains('roles_list', 'Pembimbing PKL')->orWhereJsonContains('roles_list', 'Guru Pembimbing')->count();
            // Note: need to count from array
            $currentWaliCount = 0; // calculated below

            $roles = [];
            $kelasDiampu = null;
            $ketDiampu = null;

            if ($savedCount <= 27) {
                // Add Wali Kelas XII to reach 18
                $rombelNum = ($savedCount % 3) + 1;
                $jurShort = ['RPL', 'TOI', 'TP', 'KA', 'TPL'][$jIdx];
                $roles[] = 'Wali Kelas XII ' . $jurShort . ' ' . $rombelNum;
                $kelasDiampu = 'XII ' . $jurShort . ' ' . $rombelNum . ' (Wali Kelas)';
                $ketDiampu = '35 Siswa Binaan';
            }

            if ($savedCount <= 37) {
                // Add Pembimbing PKL to reach 34
                $roles[] = 'Pembimbing PKL';
                if (!$kelasDiampu) {
                    $kelasDiampu = $currentJName;
                    $ketDiampu = 'Supervisi ' . rand(10, 20) . ' Siswa DUDI Mitra';
                }
            } elseif ($savedCount <= 50) {
                $roles[] = 'Guru Kejuruan ' . ['RPL', 'TOI', 'TP', 'KA', 'TPL'][$jIdx];
                $kelasDiampu = $currentJName;
                $ketDiampu = 'Pengampu Mata Pelajaran Produktif';
            } elseif ($savedCount <= 70) {
                $roles[] = 'Guru Penguji';
                $kelasDiampu = $currentJName;
                $ketDiampu = 'Asesor Kompetensi Keahlian';
            } else {
                // Belum diberi role or Guru Umum
                if ($savedCount % 3 == 0) {
                    $roles = [];
                    $kelasDiampu = 'Belum teralokasi di Rombel/PKL';
                    $ketDiampu = null;
                } else {
                    $roles[] = 'Guru Pembimbing';
                    $kelasDiampu = $currentJName;
                    $ketDiampu = 'Pendamping Program Magang';
                }
            }

            $statusAkun = 'aktif';
            if ($savedCount == 84 || $savedCount == 85) {
                $statusAkun = 'belum_aktivasi';
            } elseif ($savedCount == 86) {
                $statusAkun = 'nonaktif';
            }

            $username = 'guru_' . $savedCount;
            $email = strtolower($fn . '.' . $ln . $savedCount . '@guru.sch.id');

            $user = DB::table('users')->where('username', $username)->first();
            if (!$user) {
                $userId = DB::table('users')->insertGetId([
                    'username' => $username,
                    'email' => $email,
                    'password_hash' => Hash::make('password123'),
                    'tipe_akun' => 'guru',
                    'dibuat_pada' => now(),
                ]);
            } else {
                $userId = $user->id;
            }

            Guru::create([
                'user_id' => $userId,
                'nip' => $nip,
                'nuptk' => $nuptk,
                'nama' => $fullName,
                'jenis_kelamin' => $isMale ? 'Laki-laki' : 'Perempuan',
                'pendidikan' => ($savedCount % 3 == 0) ? 'S2 Pendidikan Vokasi' : 'S1 Pendidikan',
                'avatar_url' => null,
                'no_hp' => '0812' . rand(10000000, 99999999),
                'email' => $email,
                'status_akun' => $statusAkun,
                'roles_list' => $roles,
                'kelas_diampu' => $kelasDiampu,
                'keterangan_diampu' => $ketDiampu,
                'jurusan_id' => $currentJId,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
