<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ExcelExporter;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['rombel', 'jurusan']);

        // Search Filter (Nama, NIS, NISN, Email, Kota, No HP)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('kota', 'like', "%{$search}%")
                  ->orWhere('kampus', 'like', "%{$search}%")
                  ->orWhereHas('rombel', function ($sub) use ($search) {
                      $sub->where('nama_rombel', 'like', "%{$search}%")
                          ->orWhere('kode_rombel', 'like', "%{$search}%");
                  })
                  ->orWhereHas('jurusan', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%")
                          ->orWhere('kode', 'like', "%{$search}%");
                  });
            });
        }
        $query->whereHas('rombel', fn ($q) => $q->where('tingkat', 'XII'));

        // Jurusan Filter
        if ($jurusanId = $request->input('jurusan_id')) {
            if ($jurusanId !== 'all') {
                $query->where('jurusan_id', $jurusanId);
            }
        }

        // Status Akun Filter
        if ($statusAkun = $request->input('status_akun')) {
            if ($statusAkun !== 'all') {
                $query->where('status_akun', $statusAkun);
            }
        }

        // Status PKL Filter
        if ($statusPkl = $request->input('status_pkl')) {
            if ($statusPkl !== 'all') {
                $query->where('status_pkl', $statusPkl);
            }
        }

        // Pagination
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $siswas = (clone $query)->orderBy('id', 'asc')->paginate($perPage)->withQueryString();

        // 4 KPI Summary Stats (Always whole school)
        $totalSiswa = Siswa::count();

        $siapPklXII = Siswa::whereHas('rombel', function ($q) {
            $q->where('tingkat', 'XII');
        })->count();

        $akunAktif = Siswa::where('status_akun', 'aktif')->count();

        $belumAktivasi = Siswa::whereIn('status_akun', ['belum_aktivasi', 'ditangguhkan'])->count();

        $persenAktivasi = $totalSiswa > 0 ? round(($akunAktif / $totalSiswa) * 100, 1) : 0;

        $jurusans = Jurusan::where('status', 'aktif')->orderBy('nama')->get();
        $rombels = Rombel::where('status', 'aktif')->where('tingkat', 'XII')->orderBy('id', 'asc')->get();

        $tahunAjaranAktif = '2026/2027';

        return view('admin.siswa.index', compact(
            'siswas',
            'totalSiswa',
            'siapPklXII',
            'akunAktif',
            'belumAktivasi',
            'persenAktivasi',
            'jurusans',
            'rombels',
            'perPage',
            'tahunAjaranAktif'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:30|unique:siswa,nis',
            'nisn' => 'required|string|max:30|unique:siswa,nisn',
            'nama' => 'required|string|max:100',
            'rombel_id' => 'required|exists:rombel,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'jenis_kelamin' => 'required|in:L,P',
            'kota' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:25',
            'email' => 'required|email|max:100',
            'password' => 'nullable|string|min:6',
            'status_pkl' => 'required|string|max:50',
        ]);

        $rombel = Rombel::findOrFail($validated['rombel_id']);
        $jurusanId = $rombel->jurusan_id;

        $username = 'siswa_' . $validated['nis'];
        if (DB::table('users')->where('username', $username)->exists()) {
            $username = 'siswa_' . $validated['nisn'];
        }

        $password = !empty($validated['password']) ? $validated['password'] : 'password123';

        // Check if user with this email already exists, otherwise create new
        $existingUser = DB::table('users')->where('email', $validated['email'])->first();
        if ($existingUser) {
            $userId = $existingUser->id;
            if (!empty($validated['password'])) {
                DB::table('users')->where('id', $userId)->update([
                    'password_hash' => Hash::make($password),
                ]);
            }
        } else {
            $userId = DB::table('users')->insertGetId([
                'username' => $username,
                'email' => $validated['email'],
                'password_hash' => Hash::make($password),
                'tipe_akun' => 'siswa',
                'dibuat_pada' => now(),
            ]);
        }

        $siswa = Siswa::create([
            'user_id' => $userId,
            'nis' => $validated['nis'],
            'nisn' => $validated['nisn'],
            'nama' => $validated['nama'],
            'rombel_id' => $validated['rombel_id'],
            'jurusan_id' => $jurusanId,
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'kota' => $validated['kota'] ?: 'Bogor',
            'no_hp' => $validated['no_hp'] ?: null,
            'email' => $validated['email'],
            'status_akun' => 'aktif',
            'status_pkl' => $validated['status_pkl'],
        ]);

        LogAktivitas::catat('Tambah Data', 'Master Siswa', 'Menambahkan data siswa baru ' . $siswa->nama . ' (NIS: ' . $siswa->nis . ')');

        return redirect()->route('admin.siswa.index')
            ->with('success', "Data Siswa {$siswa->nama} beserta akun login berhasil ditambahkan!");
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'required|string|max:30|unique:siswa,nis,' . $id,
            'nisn' => 'required|string|max:30|unique:siswa,nisn,' . $id,
            'nama' => 'required|string|max:100',
            'rombel_id' => 'required|exists:rombel,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'jenis_kelamin' => 'required|in:L,P',
            'kota' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:25',
            'email' => 'required|email|max:100',
            'password' => 'nullable|string|min:6',
            'status_pkl' => 'required|string|max:50',
        ]);

        $rombel = Rombel::findOrFail($validated['rombel_id']);
        $jurusanId = $rombel->jurusan_id;

        // Update / Sync User account credentials
        if ($siswa->user_id) {
            $userUpdate = ['email' => $validated['email']];
            if (!empty($validated['password'])) {
                $userUpdate['password_hash'] = Hash::make($validated['password']);
            }
            DB::table('users')->where('id', $siswa->user_id)->update($userUpdate);
        } else {
            $username = 'siswa_' . $validated['nis'];
            if (DB::table('users')->where('username', $username)->exists()) {
                $username = 'siswa_' . $validated['nisn'];
            }
            $userId = DB::table('users')->insertGetId([
                'username' => $username,
                'email' => $validated['email'],
                'password_hash' => Hash::make(!empty($validated['password']) ? $validated['password'] : 'password123'),
                'tipe_akun' => 'siswa',
                'dibuat_pada' => now(),
            ]);
            $siswa->user_id = $userId;
        }

        $siswa->update([
            'nis' => $validated['nis'],
            'nisn' => $validated['nisn'],
            'nama' => $validated['nama'],
            'rombel_id' => $validated['rombel_id'],
            'jurusan_id' => $jurusanId,
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'kota' => $validated['kota'] ?: $siswa->kota,
            'no_hp' => $validated['no_hp'] ?: $siswa->no_hp,
            'email' => $validated['email'],
            'status_pkl' => $validated['status_pkl'],
        ]);

        LogAktivitas::catat('Edit Data', 'Master Siswa', 'Memperbarui data siswa ' . $siswa->nama . ' (NIS: ' . $siswa->nis . ')');

        return redirect()->route('admin.siswa.index')
            ->with('success', "Data Siswa {$siswa->nama} dan akun login berhasil diperbarui!");
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $nama = $siswa->nama;

        DB::transaction(function () use ($siswa, $nama) {
            $userId = $siswa->user_id;
            $siswa->delete();
            if ($userId) {
                DB::table('users')->where('id', $userId)->delete();
            }
            LogAktivitas::catat('Hapus Data', 'Master Siswa', 'Menghapus data siswa ' . $nama);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', "Data Siswa {$nama} berhasil dihapus dari sistem.");
    }

    public function bulkActivate(Request $request)
    {
        $ids = $request->input('siswa_ids', []);
        if (!empty($ids)) {
            Siswa::whereIn('id', $ids)->update(['status_akun' => 'aktif']);
            LogAktivitas::catat('Otorisasi', 'Master Siswa', 'Mengaktifkan akun massal untuk ' . count($ids) . ' siswa');
            return redirect()->back()->with('success', "Akses akun berhasil diaktifkan dan dikirim ulang untuk " . count($ids) . " siswa terpilih!");
        }
        return redirect()->back()->with('info', "Pilih minimal 1 siswa terlebih dahulu.");
    }

    public function bulkRombel(Request $request)
    {
        $ids = $request->input('siswa_ids', []);
        $rombelId = $request->input('target_rombel_id');

        if (!empty($ids) && !empty($rombelId)) {
            $rombel = Rombel::find($rombelId);
            if ($rombel) {
                Siswa::whereIn('id', $ids)->update([
                    'rombel_id' => $rombel->id,
                    'jurusan_id' => $rombel->jurusan_id
                ]);
                LogAktivitas::catat('Edit Data', 'Master Siswa', 'Memindahkan ' . count($ids) . ' siswa ke rombel ' . $rombel->nama_rombel);
                return redirect()->back()->with('success', "Rombongan belajar berhasil disetel ke {$rombel->nama_rombel} untuk " . count($ids) . " siswa!");
            }
        }
        return redirect()->back()->with('info', "Silakan pilih siswa dan rombel tujuan.");
    }

    public function bulkDelete(Request $request)
    {
        $ids = array_filter((array) $request->input('ids', $request->input('siswa_ids', [])));
        if (!$ids) {
            return back()->with('info', 'Pilih minimal satu data.');
        }

        DB::transaction(function () use ($ids) {
            $siswas = Siswa::whereIn('id', $ids)->get();
            foreach ($siswas as $siswa) {
                $userId = $siswa->user_id;
                $siswa->delete();
                if ($userId) {
                    DB::table('users')->where('id', $userId)->delete();
                }
            }
            LogAktivitas::catat('Hapus Data', 'Master Siswa', 'Menghapus ' . $siswas->count() . ' data siswa');
        });

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }

    public function invitePending()
    {
        $count = Siswa::whereIn('status_akun', ['belum_aktivasi', 'ditangguhkan'])->count();
        Siswa::whereIn('status_akun', ['belum_aktivasi', 'ditangguhkan'])->update(['status_akun' => 'aktif']);
        LogAktivitas::catat('Otorisasi', 'Master Siswa', 'Mengirimkan undangan dan mengaktifkan ' . $count . ' akun siswa');
        return redirect()->back()->with('success', "Undangan aktivasi akun berhasil dikirimkan secara serentak ke {$count} siswa belum aktif!");
    }


    public function export(Request $request): StreamedResponse
    {
        $query = Siswa::with(['rombel', 'jurusan']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $query->whereHas('rombel', fn ($q) => $q->where('tingkat', 'XII'));


        if ($statusAkun = $request->input('status_akun')) {
            if ($statusAkun !== 'all') {
                $query->where('status_akun', $statusAkun);
            }
        }

        if ($statusPkl = $request->input('status_pkl')) {
            if ($statusPkl !== 'all') {
                $query->where('status_pkl', $statusPkl);
            }
        }

        $siswas = $query->orderBy('id', 'asc')->get();

        $columns = [
            ['label' => 'No', 'width' => 6, 'type' => 'number', 'align' => 'center'],
            ['label' => 'NIS', 'width' => 16, 'align' => 'center'],
            ['label' => 'NISN', 'width' => 18, 'align' => 'center'],
            ['label' => 'Nama Lengkap Siswa', 'width' => 32],
            ['label' => 'Jenis Kelamin', 'width' => 14, 'align' => 'center'],
            ['label' => 'Kota Asal', 'width' => 18],
            ['label' => 'Kelas & Rombel', 'width' => 20, 'align' => 'center'],
            ['label' => 'Konsentrasi Keahlian', 'width' => 28],
            ['label' => 'Kampus', 'width' => 18],
            ['label' => 'No. HP Siswa', 'width' => 16, 'align' => 'center'],
            ['label' => 'Email Siswa', 'width' => 30],
            ['label' => 'Status Akun', 'width' => 14, 'align' => 'center'],
            ['label' => 'Status PKL', 'width' => 18, 'align' => 'center'],
        ];

        $no = 1;
        $rows = [];
        foreach ($siswas as $s) {
            $rows[] = [
                $no++,
                $s->nis,
                $s->nisn,
                $s->nama,
                $s->jenis_kelamin,
                $s->kota ?: '-',
                $s->rombel ? $s->rombel->nama_rombel : '-',
                $s->jurusan ? $s->jurusan->nama : '-',
                $s->kampus ?: 'Kampus Pusat',
                $s->no_hp ?: '-',
                $s->email ?: '-',
                ucfirst($s->status_akun),
                $s->status_pkl,
            ];
        }

        return ExcelExporter::download(
            'master_data_siswa_' . date('Ymd_His') . '.xls',
            'Data Siswa',
            $columns,
            $rows,
            ['title' => 'MASTER DATA SISWA', 'brand' => '1D4ED8']
        );
    }
}
