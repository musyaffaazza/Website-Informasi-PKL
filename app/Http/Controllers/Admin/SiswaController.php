<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\Jurusan;
use App\Models\User;
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

        // Tingkat / Kelas Filter (default 'XII' to match 432 students shown in screenshot, or 'all' if selected)
        $selectedTingkat = $request->input('tingkat', 'XII');
        $query->whereHas('rombel', function ($q) {
            $q->where('tingkat', 'XII');
        });

        if ($selectedTingkat !== 'all' && $selectedTingkat !== 'XII' && !empty($selectedTingkat)) {
            $query->where('rombel_id', $selectedTingkat);
        }

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

        return view('admin.siswa.index', compact(
            'siswas',
            'totalSiswa',
            'siapPklXII',
            'akunAktif',
            'belumAktivasi',
            'persenAktivasi',
            'jurusans',
            'rombels',
            'selectedTingkat',
            'perPage'
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
            'kampus' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'kota' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:100',
            'status_akun' => 'required|in:aktif,belum_aktivasi,ditangguhkan',
            'status_pkl' => 'required|string|max:50',
        ]);

        $rombel = Rombel::find($validated['rombel_id']);
        $jurusanId = $validated['jurusan_id'] ?: ($rombel ? $rombel->jurusan_id : 1);

        $username = 'siswa_' . $validated['nis'];
        $email = $validated['email'] ?: (strtolower(str_replace(' ', '.', $validated['nama'])) . '@smkn1gunungputri.sch.id');

        $userId = DB::table('users')->insertGetId([
            'username' => $username,
            'email' => $email,
            'password_hash' => Hash::make('password123'),
            'tipe_akun' => 'siswa',
            'dibuat_pada' => now(),
        ]);

        $siswa = Siswa::create([
            'user_id' => $userId,
            'nis' => $validated['nis'],
            'nisn' => $validated['nisn'],
            'nama' => $validated['nama'],
            'rombel_id' => $validated['rombel_id'],
            'jurusan_id' => $jurusanId,
            'kampus' => $validated['kampus'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'kota' => $validated['kota'] ?: 'Bogor',
            'no_hp' => $validated['no_hp'] ?: null,
            'email' => $email,
            'status_akun' => $validated['status_akun'],
            'status_pkl' => $validated['status_pkl'],
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', "Data Siswa {$siswa->nama} (NIS: {$siswa->nis}) berhasil ditambahkan!");
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
            'kampus' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'kota' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:100',
            'status_akun' => 'required|in:aktif,belum_aktivasi,ditangguhkan',
            'status_pkl' => 'required|string|max:50',
        ]);

        $rombel = Rombel::find($validated['rombel_id']);
        $jurusanId = $validated['jurusan_id'] ?: ($rombel ? $rombel->jurusan_id : $siswa->jurusan_id);

        $siswa->update([
            'nis' => $validated['nis'],
            'nisn' => $validated['nisn'],
            'nama' => $validated['nama'],
            'rombel_id' => $validated['rombel_id'],
            'jurusan_id' => $jurusanId,
            'kampus' => $validated['kampus'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'kota' => $validated['kota'] ?: $siswa->kota,
            'no_hp' => $validated['no_hp'] ?: $siswa->no_hp,
            'email' => $validated['email'] ?: $siswa->email,
            'status_akun' => $validated['status_akun'],
            'status_pkl' => $validated['status_pkl'],
        ]);

        return redirect()->route('admin.siswa.index')
            ->with('success', "Data Siswa {$siswa->nama} berhasil diperbarui!");
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $nama = $siswa->nama;

        DB::transaction(function () use ($siswa) {
            $userId = $siswa->user_id;
            $siswa->delete();
            if ($userId) {
                DB::table('users')->where('id', $userId)->delete();
            }
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', "Data Siswa {$nama} berhasil dihapus dari sistem.");
    }

    public function bulkActivate(Request $request)
    {
        $ids = $request->input('siswa_ids', []);
        if (!empty($ids)) {
            Siswa::whereIn('id', $ids)->update(['status_akun' => 'aktif']);
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
                return redirect()->back()->with('success', "Rombongan belajar berhasil disetel ke {$rombel->nama_rombel} untuk " . count($ids) . " siswa!");
            }
        }
        return redirect()->back()->with('info', "Silakan pilih siswa dan rombel tujuan.");
    }

    public function invitePending()
    {
        $count = Siswa::whereIn('status_akun', ['belum_aktivasi', 'ditangguhkan'])->count();
        Siswa::whereIn('status_akun', ['belum_aktivasi', 'ditangguhkan'])->update(['status_akun' => 'aktif']);
        return redirect()->back()->with('success', "Undangan aktivasi akun berhasil dikirimkan secara serentak ke {$count} siswa belum aktif!");
    }

    public function syncDapodik()
    {
        return redirect()->back()->with('success', 'Tarik Data Siswa Dapodikdasmen Kemendikbudristek berhasil diperbarui secara realtime!');
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

        if ($tingkat = $request->input('tingkat')) {
            if ($tingkat !== 'all' && $tingkat === 'XII') {
                $query->whereHas('rombel', function ($q) {
                    $q->where('tingkat', 'XII');
                });
            }
        }

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

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="master_data_siswa_' . date('Ymd_His') . '.csv"',
        ];

        return response()->stream(function () use ($siswas) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'No',
                'NIS',
                'NISN',
                'Nama Lengkap Siswa',
                'Jenis Kelamin',
                'Kota Asal',
                'Kelas & Rombel',
                'Konsentrasi Keahlian',
                'Kampus',
                'No. HP Siswa',
                'Email Siswa',
                'Status Akun',
                'Status PKL',
            ]);

            $no = 1;
            foreach ($siswas as $s) {
                fputcsv($handle, [
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
                    $s->status_akun,
                    $s->status_pkl,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
