<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\LogAktivitas;

class LogAktivitasSeeder extends Seeder
{
    public function run(): void
    {
        LogAktivitas::truncate();

        $userIds = DB::table('users')->pluck('id')->all();
        if (empty($userIds)) {
            return;
        }

        $aksiList = [
            'Login',
            'Logout',
            'Tambah Data',
            'Edit Data',
            'Hapus Data',
            'Ekspor Data',
            'Impor Data',
            'Ubah Status',
            'Cetak Laporan',
            'Upload Dokumen',
        ];

        $modulList = [
            'Jurusan',
            'Rombel',
            'Guru',
            'Siswa',
            'Industri',
            'Pengajuan PKL',
            'Mapping Pembimbing',
            'Penilaian',
            'Absensi',
            'Jurnal',
            'Autentikasi',
        ];

        $deskripsiMap = [
            'Login'           => 'Pengguna berhasil login ke sistem SIPRAK',
            'Logout'          => 'Pengguna keluar dari sistem SIPRAK',
            'Tambah Data'     => 'Menambahkan data baru ke modul',
            'Edit Data'       => 'Mengubah data yang ada di modul',
            'Hapus Data'      => 'Menghapus data dari modul',
            'Ekspor Data'     => 'Mengekspor data ke format CSV/XLS',
            'Impor Data'      => 'Mengimpor data dari file eksternal',
            'Ubah Status'     => 'Mengubah status akun/entitas',
            'Cetak Laporan'   => 'Mencetak laporan dari modul',
            'Upload Dokumen'  => 'Mengunggah dokumen pendukung',
        ];

        $ips = ['127.0.0.1', '192.168.1.10', '192.168.1.25', '10.0.0.5', '172.16.0.1'];
        $agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 14_6) Safari/605.1',
            'Mozilla/5.0 (Linux; Android 14) Mobile Chrome/128.0',
        ];

        $now = now();

        for ($i = 0; $i < 50; $i++) {
            $aksi = $aksiList[array_rand($aksiList)];
            $modul = in_array($aksi, ['Login', 'Logout']) ? 'Autentikasi' : $modulList[array_rand($modulList)];

            LogAktivitas::create([
                'user_id'     => $userIds[array_rand($userIds)],
                'aksi'        => $aksi,
                'modul'       => $modul,
                'deskripsi'   => $deskripsiMap[$aksi] ?? $aksi,
                'ip_address'  => $ips[array_rand($ips)],
                'user_agent'  => $agents[array_rand($agents)],
                'dibuat_pada' => $now->copy()->subMinutes(rand(0, 10080)),
            ]);
        }
    }
}