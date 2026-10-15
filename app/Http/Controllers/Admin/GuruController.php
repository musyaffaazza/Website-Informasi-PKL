<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ExcelExporter;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\PembimbingPenugasan;
use App\Models\LogAktivitas;
use App\Models\Rombel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with(['jurusan', 'rombelWali.jurusan', 'jurusanKaprog']);

        // Search Filter (NIP, NUPTK, Nama, Role, Kelas Diampu)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('kelas_diampu', 'like', "%{$search}%")
                  ->orWhere('keterangan_diampu', 'like', "%{$search}%")
                  ->orWhere('roles_list', 'like', "%{$search}%")
                  ->orWhereHas('jurusan', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%")
                          ->orWhere('kode', 'like', "%{$search}%");
                  });
            });
        }

        // Role Filter
        if ($role = $request->input('role')) {
            if ($role === 'belum_diberi_role' || $role === 'Guru') {
                $query->where(function ($q) {
                    $q->whereNull('roles_list')
                      ->orWhere('roles_list', '[]')
                      ->orWhereJsonLength('roles_list', 0)
                      ->orWhereJsonContains('roles_list', 'Guru')
                      ->orWhere('roles_list', 'like', '%Guru%');
                });
            } elseif ($role !== 'all') {
                $query->where(function ($q) use ($role) {
                    $q->whereJsonContains('roles_list', $role)
                      ->orWhere('roles_list', 'like', "%{$role}%");
                });
            }
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

        // Pagination
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 86, 100])) {
            $perPage = 10;
        }

        $gurus = (clone $query)->orderBy('id', 'asc')->paginate($perPage)->withQueryString();

        // 4 KPI Summary Stats
        $totalGuru = Guru::count();

        $pembimbingCount = 0;
        $waliKelasCount = 0;
        $kaprogCount = 0;

        foreach (Guru::all() as $g) {
            $roles = $g->roles_list ?: [];
            $isP = false;
            $isW = false;
            $isK = false;
            foreach ($roles as $r) {
                if (str_contains($r, 'Pembimbing') && !$isP) { $pembimbingCount++; $isP = true; }
                if (str_contains($r, 'Wali Kelas') && !$isW) { $waliKelasCount++; $isW = true; }
                if (str_contains($r, 'Kaprog') && !$isK) { $kaprogCount++; $isK = true; }
            }
        }

        $jurusans = Jurusan::where('status', 'aktif')->with('kaprog')->orderBy('nama')->get();
        $totalJurusan = $jurusans->count();
        $totalSiswaBimbingan = PembimbingPenugasan::whereHas('pengajuan', function ($q) {
            $q->where('status', 'disetujui');
        })->count();

        return view('admin.guru.index', compact(
            'gurus',
            'totalGuru',
            'pembimbingCount',
            'waliKelasCount',
            'kaprogCount',
            'jurusans',
            'perPage',
            'totalJurusan',
            'totalSiswaBimbingan'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|max:30|unique:guru,nip',
            'nuptk' => 'nullable|string|max:50',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pendidikan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email|max:100',
            'password' => 'nullable|string|min:6',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'roles_input' => 'nullable|string',
        ]);

        $roles = [];
        if (!empty($validated['roles_input'])) {
            $roles = array_values(array_filter(array_map('trim', explode(',', $validated['roles_input']))));
        }

        $isKaprogRole = in_array('Kaprog', $roles);
        $jurusanId = $validated['jurusan_id'] ?? null;

        // Validasi jika role Kaprog dan memilih jurusan yang sudah memiliki Kaprog lain
        if ($isKaprogRole && $jurusanId) {
            $targetJurusan = Jurusan::find($jurusanId);
            if ($targetJurusan && $targetJurusan->kaprog_guru_id) {
                $existingKaprog = Guru::find($targetJurusan->kaprog_guru_id);
                $existingName = $existingKaprog ? $existingKaprog->nama : 'Guru lain';
                return back()->withInput()->withErrors([
                    'jurusan_id' => "Jurusan {$targetJurusan->nama} sudah memiliki Kepala Program Keahlian ({$existingName}). Dalam 1 jurusan hanya boleh ada 1 Kaprog. Silakan pilih jurusan lain atau kosongkan pilihan jurusan."
                ]);
            }
        }

        // Create or find User account
        $username = 'guru_' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $validated['nama'])[0])) . '_' . substr($validated['nip'], -4);
        if (DB::table('users')->where('username', $username)->exists()) {
            $username .= '_' . rand(10, 99);
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
                'tipe_akun' => 'guru',
                'dibuat_pada' => now(),
            ]);
        }

        $guru = Guru::create([
            'user_id' => $userId,
            'nip' => $validated['nip'],
            'nuptk' => $validated['nuptk'] ?? null,
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'pendidikan' => $validated['pendidikan'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'email' => $validated['email'],
            'status_akun' => 'aktif',
            'roles_list' => $roles,
            'jurusan_id' => $jurusanId,
        ]);

        if ($isKaprogRole && $jurusanId) {
            Jurusan::where('id', $jurusanId)->update(['kaprog_guru_id' => $guru->id]);
        }

        $guru->syncAssignments();

        LogAktivitas::catat('Tambah Data', 'Master Guru', 'Menambahkan data guru baru ' . $guru->nama . ' (' . $guru->nip . ')');

        return redirect()->route('admin.guru.index')
            ->with('success', "Data Guru {$guru->nama} beserta akun login berhasil ditambahkan!");
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated = $request->validate([
            'nip' => 'required|string|max:30|unique:guru,nip,' . $id,
            'nuptk' => 'nullable|string|max:50',
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'pendidikan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'required|email|max:100',
            'password' => 'nullable|string|min:6',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'roles_input' => 'nullable|string',
        ]);

        $roles = [];
        if (!empty($validated['roles_input'])) {
            $roles = array_values(array_filter(array_map('trim', explode(',', $validated['roles_input']))));
        }

        $isKaprogRole = in_array('Kaprog', $roles);
        $jurusanId = $validated['jurusan_id'] ?? null;

        // Validasi jika role Kaprog dan memilih jurusan yang sudah memiliki Kaprog lain
        if ($isKaprogRole && $jurusanId) {
            $targetJurusan = Jurusan::find($jurusanId);
            if ($targetJurusan && $targetJurusan->kaprog_guru_id && $targetJurusan->kaprog_guru_id != $guru->id) {
                $existingKaprog = Guru::find($targetJurusan->kaprog_guru_id);
                $existingName = $existingKaprog ? $existingKaprog->nama : 'Guru lain';
                return back()->withInput()->withErrors([
                    'jurusan_id' => "Jurusan {$targetJurusan->nama} sudah memiliki Kepala Program Keahlian ({$existingName}). Dalam 1 jurusan hanya boleh ada 1 Kaprog. Silakan pilih jurusan lain atau kosongkan pilihan jurusan."
                ]);
            }
        }

        // Update / Sync User account credentials
        if ($guru->user_id) {
            $userUpdate = ['email' => $validated['email']];
            if (!empty($validated['password'])) {
                $userUpdate['password_hash'] = Hash::make($validated['password']);
            }
            DB::table('users')->where('id', $guru->user_id)->update($userUpdate);
        } else {
            $username = 'guru_' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $validated['nama'])[0])) . '_' . substr($validated['nip'], -4);
            if (DB::table('users')->where('username', $username)->exists()) {
                $username .= '_' . rand(10, 99);
            }
            $userId = DB::table('users')->insertGetId([
                'username' => $username,
                'email' => $validated['email'],
                'password_hash' => Hash::make(!empty($validated['password']) ? $validated['password'] : 'password123'),
                'tipe_akun' => 'guru',
                'dibuat_pada' => now(),
            ]);
            $guru->user_id = $userId;
        }

        $guru->update([
            'nip' => $validated['nip'],
            'nuptk' => $validated['nuptk'] ?? null,
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'pendidikan' => $validated['pendidikan'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'email' => $validated['email'],
            'roles_list' => $roles,
            'jurusan_id' => $jurusanId,
        ]);

        // Sinkronisasi kaprog_guru_id pada tabel Jurusan
        if ($isKaprogRole && $jurusanId) {
            // Lepas dari jurusan lama jika sebelumnya kaprog jurusan lain
            $oldJurusans = Jurusan::where('kaprog_guru_id', $guru->id)->where('id', '!=', $jurusanId)->get();
            foreach ($oldJurusans as $oldJ) {
                $oldJ->update(['kaprog_guru_id' => null]);
            }
            // Tetapkan sebagai kaprog di jurusan target
            Jurusan::where('id', $jurusanId)->update(['kaprog_guru_id' => $guru->id]);
        } elseif (!$isKaprogRole || !$jurusanId) {
            // Jika role Kaprog dihapus atau jurusan dikosongkan, lepas penugasan kaprog dari jurusan
            Jurusan::where('kaprog_guru_id', $guru->id)->update(['kaprog_guru_id' => null]);
        }

        $guru->syncAssignments();

        LogAktivitas::catat('Edit Data', 'Master Guru', 'Memperbarui data guru ' . $guru->nama . ' (' . $guru->nip . ')');

        return redirect()->route('admin.guru.index')
            ->with('success', "Data Guru {$guru->nama} dan akun login berhasil diperbarui!");
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $nama = $guru->nama;

        DB::transaction(function () use ($guru, $nama) {
            // Unlink as wali kelas in rombel
            Rombel::where('wali_kelas_guru_id', $guru->id)->update(['wali_kelas_guru_id' => null]);
            // Unlink as kaprog in jurusan
            Jurusan::where('kaprog_guru_id', $guru->id)->update(['kaprog_guru_id' => null]);

            $userId = $guru->user_id;
            $guru->delete();
            if ($userId) {
                DB::table('users')->where('id', $userId)->delete();
            }
            LogAktivitas::catat('Hapus Data', 'Master Guru', 'Menghapus data guru ' . $nama);
        });

        return redirect()->route('admin.guru.index')
            ->with('success', "Data Guru {$nama} berhasil dihapus dari sistem.");
    }

    public function toggleStatus(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $newStatus = $guru->status_akun === 'aktif' ? 'nonaktif' : 'aktif';
        if ($request->has('status')) {
            $newStatus = $request->input('status');
        }
        $guru->status_akun = $newStatus;
        $guru->save();
        LogAktivitas::catat('Ubah Status', 'Master Guru', 'Mengubah status akun guru ' . $guru->nama . ' menjadi ' . ucfirst($newStatus));

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status_akun' => $guru->status_akun]);
        }

        return redirect()->back()->with('success', "Status akun {$guru->nama} diubah menjadi " . ucfirst($newStatus) . ".");
    }

    public function sendEmail($id)
    {
        $guru = Guru::findOrFail($id);
        $guru->status_akun = 'aktif';
        $guru->save();
        LogAktivitas::catat('Otorisasi', 'Master Guru', 'Mengirimkan email aktivasi dan mengaktifkan akun guru ' . $guru->nama);

        return redirect()->back()->with('success', "Email aktivasi akun dan kredensial SIPRAK berhasil dikirimkan ke {$guru->nama} ({$guru->email})!");
    }

    public function bulkRole(Request $request)
    {
        $ids = $request->input('guru_ids', []);
        $newRole = $request->input('bulk_role', '');

        if (!empty($ids) && !empty($newRole)) {
            $gurus = Guru::whereIn('id', $ids)->get();
            foreach ($gurus as $g) {
                $roles = $g->roles_list ?: [];
                if (!in_array($newRole, $roles)) {
                    $roles[] = $newRole;
                }
                $g->roles_list = $roles;
                $g->save();
                $g->syncAssignments();
            }
            LogAktivitas::catat('Ubah Status', 'Master Guru', 'Memperbarui role massal (' . $newRole . ') untuk ' . count($ids) . ' guru');
            return redirect()->back()->with('success', "Penugasan role '{$newRole}' berhasil diperbarui secara massal untuk " . count($ids) . " guru!");
        }

        return redirect()->back()->with('info', "Silakan pilih guru dan tentukan role penugasan.");
    }

    public function bulkInvite(Request $request)
    {
        $ids = $request->input('guru_ids', []);
        if (!empty($ids)) {
            Guru::whereIn('id', $ids)->update(['status_akun' => 'aktif']);
            LogAktivitas::catat('Otorisasi', 'Master Guru', 'Mengaktifkan akun dan mengirimkan undangan massal ke ' . count($ids) . ' guru');
            return redirect()->back()->with('success', "Akses akun dan email aktivasi berhasil dikirimkan ke " . count($ids) . " guru terpilih!");
        }
        return redirect()->back()->with('info', "Pilih minimal 1 guru untuk mengirimkan akses akun.");
    }

    public function bulkDelete(Request $request)
    {
        $ids = array_filter((array) $request->input('ids', $request->input('guru_ids', [])));
        if (!$ids) {
            return back()->with('info', 'Pilih minimal satu data.');
        }

        DB::transaction(function () use ($ids) {
            $gurus = Guru::whereIn('id', $ids)->get();
            foreach ($gurus as $guru) {
                Rombel::where('wali_kelas_guru_id', $guru->id)->update(['wali_kelas_guru_id' => null]);
                Jurusan::where('kaprog_guru_id', $guru->id)->update(['kaprog_guru_id' => null]);
                $userId = $guru->user_id;
                $guru->delete();
                if ($userId) {
                    DB::table('users')->where('id', $userId)->delete();
                }
            }
            LogAktivitas::catat('Hapus Data', 'Master Guru', 'Menghapus ' . $gurus->count() . ' data guru');
        });

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }


    public function export(Request $request): StreamedResponse
    {
        $query = Guru::with(['jurusan']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($statusAkun = $request->input('status_akun')) {
            if ($statusAkun !== 'all') {
                $query->where('status_akun', $statusAkun);
            }
        }

        $gurus = $query->orderBy('id', 'asc')->get();

        $columns = [
            ['label' => 'No', 'width' => 6, 'type' => 'number', 'align' => 'center'],
            ['label' => 'NIP', 'width' => 22, 'align' => 'center'],
            ['label' => 'NUPTK', 'width' => 22, 'align' => 'center'],
            ['label' => 'Nama Lengkap Guru / GTK', 'width' => 34],
            ['label' => 'Jenis Kelamin', 'width' => 14, 'align' => 'center'],
            ['label' => 'Pendidikan Terakhir', 'width' => 26],
            ['label' => 'Email', 'width' => 30],
            ['label' => 'No. HP', 'width' => 16, 'align' => 'center'],
            ['label' => 'Role Penugasan', 'width' => 30],
            ['label' => 'Kelas / Jurusan Diampu', 'width' => 24, 'align' => 'center'],
            ['label' => 'Keterangan Penugasan', 'width' => 28],
            ['label' => 'Status Akun', 'width' => 14, 'align' => 'center'],
        ];

        $no = 1;
        $rows = [];
        foreach ($gurus as $g) {
            $roles = is_array($g->roles_list) ? implode('; ', $g->roles_list) : '';

            $rows[] = [
                $no++,
                $g->nip,
                $g->nuptk ?: '-',
                $g->nama,
                $g->jenis_kelamin,
                $g->pendidikan ?: '-',
                $g->email ?: '-',
                $g->no_hp ?: '-',
                $roles ?: 'Belum Diberi Role',
                $g->kelas_diampu ?: 'Belum teralokasi',
                $g->keterangan_diampu ?: '-',
                ucfirst($g->status_akun),
            ];
        }

        return ExcelExporter::download(
            'master_data_guru_' . date('Ymd_His') . '.xls',
            'Data Guru',
            $columns,
            $rows,
            ['title' => 'MASTER DATA GURU & TENAGA KEPENDIDIKAN', 'brand' => '0F2942']
        );
    }
}

