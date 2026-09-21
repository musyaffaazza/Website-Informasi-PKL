<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Rombel;
use App\Models\PengajuanPkl;
use App\Models\PembimbingPenugasan;

class MappingPembimbingDisplaySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        PembimbingPenugasan::truncate();
        PengajuanPkl::truncate();

        $rpl = Jurusan::where('kode', 'RPL')->first();
        $toi = Jurusan::where('kode', 'TOI')->first();
        $tp  = Jurusan::where('kode', 'TP')->first();
        $ka  = Jurusan::where('kode', 'KA')->first();
        $tpl = Jurusan::where('kode', 'TPL')->first();

        // Sample / Featured students from Screenshot
        $featuredRows = [
            [
                'nama' => 'Ahmad Fauzan',
                'nis' => '18231',
                'nisn' => '0081018231',
                'rombel_nama' => 'XI PPLG 1',
                'jurusan_id' => $rpl?->id,
                'industri_nama' => 'PT Teknologi Nusantara',
                'guru_nama' => 'Budi Santoso, S.Kom.',
                'guru_nip' => '1987654321',
                'is_mapped' => true,
                'tanggal_mulai' => '2027-01-01',
                'kode_pengajuan' => '#PKL-2027-0104',
            ],
            [
                'nama' => 'Rizky Ramadhan',
                'nis' => '18232',
                'nisn' => '0081018232',
                'rombel_nama' => 'XI PPLG 1',
                'jurusan_id' => $rpl?->id,
                'industri_nama' => 'CV Digital Indonesia',
                'guru_nama' => 'Siti Rahma, S.Kom.',
                'guru_nip' => '1989021401',
                'is_mapped' => true,
                'tanggal_mulai' => '2027-01-01',
                'kode_pengajuan' => '#PKL-2027-0105',
            ],
            [
                'nama' => 'Dimas Pratama',
                'nis' => '18235',
                'nisn' => '0081018235',
                'rombel_nama' => 'XI PPLG 2',
                'jurusan_id' => $rpl?->id,
                'industri_nama' => 'PT Telkom Akses (Witel Bogor)',
                'guru_nama' => null,
                'guru_nip' => null,
                'is_mapped' => false,
                'tanggal_mulai' => '2027-01-05',
                'kode_pengajuan' => '#PKL-2027-0106',
            ],
            [
                'nama' => 'Tasya Melani Putri',
                'nis' => '18249',
                'nisn' => '0081018249',
                'rombel_nama' => 'XI PPLG 1',
                'jurusan_id' => $rpl?->id,
                'industri_nama' => 'PT Indocyber Global Teknologi',
                'guru_nama' => 'Ir. Dian Hendrawan, S.Kom., M.T.',
                'guru_nip' => '197804152002',
                'is_mapped' => true,
                'tanggal_mulai' => '2027-01-01',
                'kode_pengajuan' => '#PKL-2027-0108',
            ],
            [
                'nama' => 'Farhan Naufal',
                'nis' => '18242',
                'nisn' => '0081018242',
                'rombel_nama' => 'XI PPLG 2',
                'jurusan_id' => $rpl?->id,
                'industri_nama' => 'PT Tokopedia (GoTo Group)',
                'guru_nama' => null,
                'guru_nip' => null,
                'is_mapped' => false,
                'tanggal_mulai' => '2027-01-05',
                'kode_pengajuan' => '#PKL-2027-0110',
            ],
            [
                'nama' => 'Siti Aisyah',
                'nis' => '18245',
                'nisn' => '0081018245',
                'rombel_nama' => 'XI PPLG 1',
                'jurusan_id' => $rpl?->id,
                'industri_nama' => 'PT Astra Honda Motor',
                'guru_nama' => 'Hendro Susanto, S.T.',
                'guru_nip' => '198305102005',
                'is_mapped' => true,
                'tanggal_mulai' => '2027-01-01',
                'kode_pengajuan' => '#PKL-2027-0112',
            ],
        ];

        // Ensure Rombels XI PPLG 1 & XI PPLG 2 exist
        $rombelPplg1 = Rombel::firstOrCreate(['nama_rombel' => 'XI PPLG 1'], [
            'nama_kode' => 'XI PPLG 1',
            'kode_rombel' => 'XI-PPLG-1',
            'tingkat' => 'XI',
            'jurusan_id' => $rpl?->id,
            'tahun_ajaran' => '2024/2025',
            'ruang' => 'Lab RPL 1',
            'jumlah_siswa' => 36,
        ]);

        $rombelPplg2 = Rombel::firstOrCreate(['nama_rombel' => 'XI PPLG 2'], [
            'nama_kode' => 'XI PPLG 2',
            'kode_rombel' => 'XI-PPLG-2',
            'tingkat' => 'XI',
            'jurusan_id' => $rpl?->id,
            'tahun_ajaran' => '2024/2025',
            'ruang' => 'Lab RPL 2',
            'jumlah_siswa' => 36,
        ]);

        $defaultHash = '$2y$10$Xcsj5WbrZvl5yAcOJuWN0.ZMEI6Y1ObULRMhChhcBXS6Ay04wtB0G';

        // Insert / Update Featured Students
        foreach ($featuredRows as $data) {
            $rombel = $data['rombel_nama'] === 'XI PPLG 1' ? $rombelPplg1 : $rombelPplg2;
            
            $existingUser = DB::table('users')->where('username', 'siswa_' . $data['nis'])->first();
            $email = strtolower(str_replace(' ', '.', $data['nama'])) . '.' . $data['nis'] . '@smkn1gunungputri.sch.id';
            $userId = $existingUser ? $existingUser->id : DB::table('users')->insertGetId([
                'username' => 'siswa_' . $data['nis'],
                'email' => $email,
                'password_hash' => $defaultHash,
                'tipe_akun' => 'siswa',
                'dibuat_pada' => now(),
            ]);

            $siswa = Siswa::updateOrCreate(
                ['nis' => $data['nis']],
                [
                    'user_id' => $userId,
                    'nisn' => $data['nisn'],
                    'nama' => $data['nama'],
                    'rombel_id' => $rombel->id,
                    'jurusan_id' => $data['jurusan_id'],
                    'jenis_kelamin' => in_array($data['nama'], ['Tasya Melani Putri', 'Siti Aisyah']) ? 'P' : 'L',
                    'kota' => 'Bogor',
                    'kampus' => 'Kampus Pusat',
                    'status_akun' => 'aktif',
                    'status_pkl' => 'Sudah Ditempatkan',
                ]
            );

            // Find or create industry
            $industri = Industri::firstOrCreate(
                ['nama' => $data['industri_nama']],
                [
                    'alamat' => 'Kawasan Industri Sentul, Bogor, Jawa Barat',
                    'wilayah' => 'Bogor',
                    'kontak_nama' => 'Bpk. Hendra Gunawan',
                    'kontak_no_hp' => '081234567890',
                    'kontak_email' => 'hrd@industri.co.id',
                    'kuota' => 10,
                    'kuota_terisi' => 6,
                    'status' => 'aktif',
                    'status_kemitraan' => 'aktif',
                ]
            );

            // Create Pengajuan PKL
            $pengajuan = PengajuanPkl::create([
                'siswa_id' => $siswa->id,
                'industri_id' => $industri->id,
                'tanggal_mulai' => $data['tanggal_mulai'],
                'tanggal_selesai' => '2027-03-31',
                'status' => 'disetujui',
                'dibuat_pada' => now(),
            ]);

            // Assign Guru Pembimbing if mapped
            if ($data['is_mapped']) {
                $guru = Guru::where('nama', 'like', '%' . explode(' ', $data['guru_nama'])[0] . '%')->first();
                if (!$guru) {
                    $guru = Guru::firstOrCreate(
                        ['nip' => $data['guru_nip']],
                        [
                            'nama' => $data['guru_nama'],
                            'jurusan_id' => $rpl?->id,
                            'status_akun' => 'aktif',
                            'no_hp' => '081298765432',
                            'email' => strtolower(str_replace(' ', '.', explode(',', $data['guru_nama'])[0])) . '@smkn1gunungputri.sch.id',
                        ]
                    );
                }

                PembimbingPenugasan::create([
                    'siswa_id' => $siswa->id,
                    'pengajuan_id' => $pengajuan->id,
                    'pembimbing_guru_id' => $guru->id,
                    'tanggal_mulai' => $data['tanggal_mulai'],
                ]);
            }
        }

        // Generate additional students with approved PKL to reach exactly 128 total siswa PKL (112 sudah memiliki pembimbing, 16 belum)
        $allSiswas = Siswa::whereNotIn('nis', array_column($featuredRows, 'nis'))->get();
        $industris = Industri::all();
        $gurus = Guru::where('status_akun', 'aktif')->get();

        $curCount = count($featuredRows);
        $targetTotal = 128;
        $targetMapped = 112;

        $mappedCount = 4; // 4 in featured
        $unmappedCount = 2; // 2 in featured

        foreach ($allSiswas as $s) {
            if ($curCount >= $targetTotal) break;
            $curCount++;

            $ind = $industris->random();
            $p = PengajuanPkl::create([
                'siswa_id' => $s->id,
                'industri_id' => $ind->id,
                'tanggal_mulai' => '2027-01-01',
                'tanggal_selesai' => '2027-03-31',
                'status' => 'disetujui',
                'dibuat_pada' => now(),
            ]);

            if ($mappedCount < $targetMapped) {
                $mappedCount++;
                $g = $gurus->random();
                PembimbingPenugasan::create([
                    'siswa_id' => $s->id,
                    'pengajuan_id' => $p->id,
                    'pembimbing_guru_id' => $g->id,
                    'tanggal_mulai' => '2027-01-01',
                ]);
            } else {
                $unmappedCount++;
            }
        }

        // If we still need more students to reach 128
        $remainingNeeded = $targetTotal - $curCount;
        for ($i = 1; $i <= $remainingNeeded; $i++) {
            $curCount++;
            $rombel = ($i % 2 == 0) ? $rombelPplg1 : $rombelPplg2;
            $jurusan = $rpl;
            $nis = 18300 + $i;
            
            $existingUser = DB::table('users')->where('username', 'siswa_' . $nis)->first();
            $userId = $existingUser ? $existingUser->id : DB::table('users')->insertGetId([
                'username' => 'siswa_' . $nis,
                'email' => 'siswa' . $nis . '@smkn1gunungputri.sch.id',
                'password_hash' => $defaultHash,
                'tipe_akun' => 'siswa',
                'dibuat_pada' => now(),
            ]);

            $s = Siswa::create([
                'user_id' => $userId,
                'nis' => (string)$nis,
                'nisn' => '0089' . str_pad($nis, 6, '0', STR_PAD_LEFT),
                'nama' => 'Siswa PKL ' . $i,
                'rombel_id' => $rombel->id,
                'jurusan_id' => $jurusan?->id,
                'jenis_kelamin' => ($i % 2 == 0) ? 'P' : 'L',
                'kota' => 'Bogor',
                'kampus' => 'Kampus Pusat',
                'status_akun' => 'aktif',
                'status_pkl' => 'Sudah Ditempatkan',
            ]);

            $ind = $industris->random();
            $p = PengajuanPkl::create([
                'siswa_id' => $s->id,
                'industri_id' => $ind->id,
                'tanggal_mulai' => '2027-01-01',
                'tanggal_selesai' => '2027-03-31',
                'status' => 'disetujui',
                'dibuat_pada' => now(),
            ]);

            if ($mappedCount < $targetMapped) {
                $mappedCount++;
                $g = $gurus->random();
                PembimbingPenugasan::create([
                    'siswa_id' => $s->id,
                    'pengajuan_id' => $p->id,
                    'pembimbing_guru_id' => $g->id,
                    'tanggal_mulai' => '2027-01-01',
                ]);
            } else {
                $unmappedCount++;
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
