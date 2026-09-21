<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruRplSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $keepNips = ['198801012026011001', '198901022026011002'];
        $keepIds = DB::table('guru')->whereIn('nip', $keepNips)->pluck('id')->all();

        DB::table('jurusan')->whereNotNull('kaprog_guru_id')->update(['kaprog_guru_id' => null]);
        DB::table('rombel')->whereNotNull('wali_kelas_guru_id')->update(['wali_kelas_guru_id' => null]);
        DB::table('guru_role')->truncate();

        $deleteGuruIds = DB::table('guru')->whereNotIn('id', $keepIds)->pluck('id')->all();
        if ($deleteGuruIds) {
            $deleteUserIds = DB::table('guru')->whereIn('id', $deleteGuruIds)->pluck('user_id')->all();
            DB::table('guru')->whereIn('id', $deleteGuruIds)->delete();
            if ($deleteUserIds) {
                DB::table('users')->whereIn('id', $deleteUserIds)->delete();
            }
        }

        $keepUserIds = DB::table('guru')->pluck('user_id')->all();
        DB::table('users')->where('tipe_akun', 'guru')->whereNotIn('id', $keepUserIds)->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rpl = DB::table('jurusan')->where('kode', 'RPL')->first();

        if (!$rpl) {
            throw new \RuntimeException('Jurusan RPL tidak ditemukan.');
        }

        $guruRpl = [
            [
                'username' => 'hermansyah.skom',
                'email' => 'hermansyah@smkn1gunungputri.sch.id',
                'nip' => '198801012026011001',
                'nama' => 'Hermansyah, S.Kom.',
            ],
            [
                'username' => 'doni.setiawan.skom',
                'email' => 'doni.setiawan@smkn1gunungputri.sch.id',
                'nip' => '198901022026011002',
                'nama' => 'Doni Setiawan, S.Kom.',
            ],
        ];

        foreach ($guruRpl as $data) {
            $user = DB::table('users')->where('username', $data['username'])->first();

            if ($user) {
                $userId = $user->id;
                DB::table('users')->where('id', $userId)->update([
                    'email' => $data['email'],
                    'tipe_akun' => 'guru',
                ]);
            } else {
                $userId = DB::table('users')->insertGetId([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password_hash' => Hash::make('password123'),
                    'tipe_akun' => 'guru',
                    'terakhir_login' => null,
                    'dibuat_pada' => now(),
                ]);
            }

            DB::table('guru')->updateOrInsert(
                ['nip' => $data['nip']],
                [
                    'user_id' => $userId,
                    'nama' => $data['nama'],
                    'jenis_kelamin' => 'Laki-laki',
                    'pendidikan' => 'S1 Ilmu Komputer',
                    'email' => $data['email'],
                    'status_akun' => 'aktif',
                    'roles_list' => json_encode(['Guru Kejuruan RPL']),
                    'kelas_diampu' => 'Rekayasa Perangkat Lunak',
                    'keterangan_diampu' => 'Guru produktif RPL',
                    'jurusan_id' => $rpl->id,
                    'updated_at' => now(),
                ]
            );
        }
    }
}