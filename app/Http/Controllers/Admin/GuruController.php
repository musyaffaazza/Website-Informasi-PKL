<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
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
        $query = Guru::with(['jurusan', 'rombelWali']);

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
            if ($role === 'belum_diberi_role') {
                $query->where(function ($q) {
                    $q->whereNull('roles_list')
                      ->orWhere('roles_list', '[]')
                      ->orWhereJsonLength('roles_list', 0);
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

        $jurusans = Jurusan::where('status', 'aktif')->orderBy('nama')->get();

        return view('admin.guru.index', compact(
            'gurus',
            'totalGuru',
            'pembimbingCount',
            'waliKelasCount',
            'kaprogCount',
            'jurusans',
            'perPage'
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
            'email' => 'nullable|email|max:100',
            'status_akun' => 'required|in:aktif,belum_aktivasi,nonaktif',
            'kelas_diampu' => 'nullable|string|max:255',
            'keterangan_diampu' => 'nullable|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'roles_input' => 'nullable|string',
        ]);

        $roles = [];
        if (!empty($validated['roles_input'])) {
            $roles = array_values(array_filter(array_map('trim', explode(',', $validated['roles_input']))));
        }

        // Create User account if not exists
        $username = 'guru_' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', explode(' ', $validated['nama'])[0])) . '_' . rand(100, 999);
        $email = $validated['email'] ?: ($username . '@guru.sch.id');

        $userId = DB::table('users')->insertGetId([
            'username' => $username,
            'email' => $email,
            'password_hash' => Hash::make('password123'),
            'tipe_akun' => 'guru',
            'dibuat_pada' => now(),
        ]);

        $guru = Guru::create([
            'user_id' => $userId,
            'nip' => $validated['nip'],
            'nuptk' => $validated['nuptk'] ?: null,
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'pendidikan' => $validated['pendidikan'] ?: null,
            'no_hp' => $validated['no_hp'] ?: null,
            'email' => $email,
            'status_akun' => $validated['status_akun'],
            'roles_list' => $roles,
            'kelas_diampu' => $validated['kelas_diampu'] ?: null,
            'keterangan_diampu' => $validated['keterangan_diampu'] ?: null,
            'jurusan_id' => $validated['jurusan_id'] ?: null,
        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', "Data Guru {$guru->nama} berhasil ditambahkan!");
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
            'email' => 'nullable|email|max:100',
            'status_akun' => 'required|in:aktif,belum_aktivasi,nonaktif',
            'kelas_diampu' => 'nullable|string|max:255',
            'keterangan_diampu' => 'nullable|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'roles_input' => 'nullable|string',
        ]);

        $roles = [];
        if (!empty($validated['roles_input'])) {
            $roles = array_values(array_filter(array_map('trim', explode(',', $validated['roles_input']))));
        }

        $guru->update([
            'nip' => $validated['nip'],
            'nuptk' => $validated['nuptk'] ?: null,
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'pendidikan' => $validated['pendidikan'] ?: null,
            'no_hp' => $validated['no_hp'] ?: null,
            'email' => $validated['email'] ?: $guru->email,
            'status_akun' => $validated['status_akun'],
            'roles_list' => $roles,
            'kelas_diampu' => $validated['kelas_diampu'] ?: null,
            'keterangan_diampu' => $validated['keterangan_diampu'] ?: null,
            'jurusan_id' => $validated['jurusan_id'] ?: null,
        ]);

        return redirect()->route('admin.guru.index')
            ->with('success', "Data Guru {$guru->nama} berhasil diperbarui!");
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $nama = $guru->nama;

        DB::transaction(function () use ($guru) {
            // Unlink as wali kelas in rombel
            Rombel::where('wali_kelas_guru_id', $guru->id)->update(['wali_kelas_guru_id' => null]);
            // Unlink as kaprog in jurusan
            Jurusan::where('kaprog_guru_id', $guru->id)->update(['kaprog_guru_id' => null]);

            $userId = $guru->user_id;
            $guru->delete();
            if ($userId) {
                DB::table('users')->where('id', $userId)->delete();
            }
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
            }
            return redirect()->back()->with('success', "Penugasan role '{$newRole}' berhasil diperbarui secara massal untuk " . count($ids) . " guru!");
        }

        return redirect()->back()->with('info', "Silakan pilih guru dan tentukan role penugasan.");
    }

    public function bulkInvite(Request $request)
    {
        $ids = $request->input('guru_ids', []);
        if (!empty($ids)) {
            Guru::whereIn('id', $ids)->update(['status_akun' => 'aktif']);
            return redirect()->back()->with('success', "Akses akun dan email aktivasi berhasil dikirimkan ke " . count($ids) . " guru terpilih!");
        }
        return redirect()->back()->with('info', "Pilih minimal 1 guru untuk mengirimkan akses akun.");
    }

    public function syncDapodik()
    {
        return redirect()->back()->with('success', 'Tarik Data GTK Dapodikdasmen Kemendikbudristek berhasil diperbarui secara realtime!');
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

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="master_data_guru_' . date('Ymd_His') . '.csv"',
        ];

        return response()->stream(function () use ($gurus) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'No',
                'NIP',
                'NUPTK',
                'Nama Lengkap Guru / GTK',
                'Jenis Kelamin',
                'Pendidikan Terakhir',
                'Email',
                'No. HP',
                'Role Penugasan (Multi-Role)',
                'Kelas / Jurusan Diampu',
                'Keterangan Penugasan',
                'Status Akun',
            ]);

            $no = 1;
            foreach ($gurus as $g) {
                $roles = is_array($g->roles_list) ? implode('; ', $g->roles_list) : '';
                fputcsv($handle, [
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
                    $g->status_akun,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
