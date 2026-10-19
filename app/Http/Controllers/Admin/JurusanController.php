<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\ExcelExporter;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\LogAktivitas;
use App\Models\PengajuanPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jurusan::with(['kaprog', 'rombels.siswas', 'siswas.pengajuanPkl', 'industris'])
            ->withCount(['rombels', 'siswas']);

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode', 'like', "%{$search}%")
                  ->orWhere('singkatan', 'like', "%{$search}%")
                  ->orWhere('bidang', 'like', "%{$search}%")
                  ->orWhereHas('kaprog', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Bidang filter
        if ($bidang = $request->input('bidang')) {
            if ($bidang !== 'all') {
                $query->where('bidang', $bidang);
            }
        }


        $perPage = (int) $request->input('per_page', 6);
        if (!in_array($perPage, [6, 12, 24, 48])) {
            $perPage = 6;
        }

        $jurusans = (clone $query)->orderByRaw("CASE kode 
            WHEN 'RPL' THEN 1 
            WHEN 'KI' THEN 2 
            WHEN 'TP' THEN 3 
            WHEN 'TPL' THEN 4 
            WHEN 'TEI' THEN 5 
            ELSE 6 END, id")
            ->paginate($perPage)
            ->withQueryString();

        $jurusans->getCollection()->each(function (Jurusan $jurusan) {
            $rombelsXii = $jurusan->rombels->filter(function (Rombel $rombel) {
                return $rombel->tingkat === 'XII' && ($rombel->status ?? 'aktif') === 'aktif';
            });

            $jurusan->setAttribute('rombels_xii_aktual', $rombelsXii->count());
            $jurusan->setAttribute('siswa_xii_aktual', $rombelsXii->sum(
                fn (Rombel $rombel) => $rombel->siswas->count()
            ));
            $jurusan->setAttribute('kuota_industri_aktual', (int) $jurusan->industris->sum('kuota'));
            $jurusan->setAttribute('kuota_terisi_aktual', $jurusan->siswas
                ->filter(fn (Siswa $siswa) => $siswa->pengajuanPkl?->status === 'disetujui')
                ->count());
        });
        // KPI stats
        $totalPrograms = Jurusan::count();
        $allMajors = Jurusan::with('rombels')->get();

        $totalSiswaMagang = Siswa::whereHas('rombel', function ($q) {
            $q->where('tingkat', 'XII')->where('status', 'aktif');
        })->count();

        $totalKemitraan = Industri::count();

        $totalKuota = Industri::sum('kuota');
        $totalTerisi = PengajuanPkl::where('status', 'disetujui')->count();
        $persentaseKeterserapan = $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100, 1) : 0;

        // Filter options
        $bidangList = Jurusan::whereNotNull('bidang')->select('bidang')->distinct()->pluck('bidang');

        $gurus = Guru::where('status_akun', 'aktif')->orderBy('nama')->get();
        $allIndustris = Industri::orderBy('nama')->get();

        $semesterAktif = 'Ganjil';
        $tahunAjaranAktif = '2026/2027';

        return view('admin.jurusan.index', compact(
            'jurusans',
            'totalPrograms',
            'totalSiswaMagang',
            'totalKemitraan',
            'persentaseKeterserapan',
            'bidangList',
            'gurus',
            'allIndustris',
            'perPage',
            'semesterAktif',
            'tahunAjaranAktif'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:jurusan,kode',
            'nama' => 'required|string|max:100',
            'singkatan' => 'nullable|string|max:20',
            'bidang' => 'required|string|max:100',
            'kaprog_guru_id' => 'nullable|exists:guru,id',
            'kuota_industri' => 'nullable|integer|min:0',
            'kuota_terisi' => 'nullable|integer|min:0',
            'badge_color' => 'nullable|in:blue,emerald,red,gray,white',
            'mitra_utama' => 'nullable|string',
            'capaian_kurikulum' => 'nullable|string',
        ]);

        if (empty($validated['singkatan'])) {
            $validated['singkatan'] = $validated['kode'];
        }

        $validated['kuota_industri'] = 0;
        $validated['kuota_terisi'] = 0;

        $validated['mitra_utama'] = [];

        if (empty($validated['badge_color'])) {
            $colors = ['blue', 'emerald', 'red', 'gray', 'white'];
            $usedColors = Jurusan::whereNotNull('badge_color')->pluck('badge_color')->all();
            $validated['badge_color'] = collect($colors)->first(
                fn (string $color) => !in_array($color, $usedColors, true)
            ) ?? $colors[array_rand($colors)];
        }

        $newKaprogId = $validated['kaprog_guru_id'] ?? null;

        $jurusan = DB::transaction(function () use ($validated, $newKaprogId) {
            $created = Jurusan::create($validated);
            if (!empty($newKaprogId)) {
                // If this guru was kaprog of another jurusan, detach
                Jurusan::where('kaprog_guru_id', $newKaprogId)
                    ->where('id', '!=', $created->id)
                    ->update(['kaprog_guru_id' => null]);

                Guru::find($newKaprogId)?->syncAssignments();
            }
            return $created;
        });

        LogAktivitas::catat('Tambah Data', 'Master Jurusan', 'Menambahkan jurusan baru ' . $jurusan->nama . ' (' . $jurusan->kode . ')');

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan ' . $jurusan->nama . ' berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);

        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:jurusan,kode,' . $jurusan->id,
            'nama' => 'required|string|max:100',
            'singkatan' => 'nullable|string|max:20',
            'bidang' => 'required|string|max:100',
            'kaprog_guru_id' => 'nullable|exists:guru,id',
            'kuota_industri' => 'nullable|integer|min:0',
            'kuota_terisi' => 'nullable|integer|min:0',
            'badge_color' => 'nullable|in:blue,emerald,red,gray,white',
            'mitra_utama' => 'nullable|string',
            'capaian_kurikulum' => 'nullable|string',
        ]);

        if (empty($validated['singkatan'])) {
            $validated['singkatan'] = $validated['kode'];
        }
        $validated['kuota_industri'] = 0;
        $validated['kuota_terisi'] = 0;

        $validated['mitra_utama'] = [];

        $oldKaprogId = $jurusan->kaprog_guru_id;
        $newKaprogId = $validated['kaprog_guru_id'] ?? null;

        DB::transaction(function () use ($jurusan, $validated, $oldKaprogId, $newKaprogId) {
            if (!empty($newKaprogId) && $newKaprogId != $oldKaprogId) {
                // If new guru was kaprog of another jurusan, detach
                Jurusan::where('kaprog_guru_id', $newKaprogId)
                    ->where('id', '!=', $jurusan->id)
                    ->update(['kaprog_guru_id' => null]);
            }

            $jurusan->update($validated);

            if ($oldKaprogId && $oldKaprogId != $newKaprogId) {
                Guru::find($oldKaprogId)?->syncAssignments();
            }

            if ($newKaprogId) {
                Guru::find($newKaprogId)?->syncAssignments();
            }
        });

        LogAktivitas::catat('Edit Data', 'Master Jurusan', 'Memperbarui data jurusan ' . $jurusan->nama . ' (' . $jurusan->kode . ')');

        return redirect()->route('admin.jurusan.index')->with('success', 'Data jurusan ' . $jurusan->nama . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $nama = $jurusan->nama . ' (' . $jurusan->kode . ')';
        $kaprogId = $jurusan->kaprog_guru_id;

        DB::transaction(function () use ($jurusan, $nama, $kaprogId) {
            $jurusan->industris()->detach();

            $siswaIds = $jurusan->siswas()->pluck('id');
            if ($siswaIds->isNotEmpty()) {
                DB::table('approval')->whereIn('pengajuan_id', function($q) use ($siswaIds) {
                    $q->select('id')->from('pengajuan_pkl')->whereIn('siswa_id', $siswaIds);
                })->delete();
                DB::table('pembimbing_penugasan')->whereIn('siswa_id', $siswaIds)->delete();
                DB::table('jurnal')->whereIn('siswa_id', $siswaIds)->delete();
                DB::table('absensi')->whereIn('siswa_id', $siswaIds)->delete();
                DB::table('penilaian')->whereIn('siswa_id', $siswaIds)->delete();
                DB::table('pengajuan_pkl')->whereIn('siswa_id', $siswaIds)->delete();
                
                $userIds = DB::table('siswa')->whereIn('id', $siswaIds)->pluck('user_id');
                DB::table('siswa')->whereIn('id', $siswaIds)->delete();
                DB::table('users')->whereIn('id', $userIds)->delete();
            }

            $jurusan->rombels()->delete();
            $jurusan->delete();

            if ($kaprogId) {
                Guru::find($kaprogId)?->syncAssignments();
            }

            LogAktivitas::catat('Hapus Data', 'Master Jurusan', 'Menghapus data jurusan ' . $nama);
        });

        return redirect()->route('admin.jurusan.index')->with('success', "Jurusan {$jurusan->nama} ({$jurusan->kode}) berhasil dihapus.");
    }

    public function bulkDelete(Request $request)
    {
        $ids = array_filter((array) $request->input('ids', []));
        if (!$ids) {
            return back()->with('info', 'Pilih minimal satu data.');
        }

        foreach ($ids as $id) {
            $this->destroy($id);
        }

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }

    public function updateKurikulum(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $validated = $request->validate([
            'capaian_kurikulum' => 'required|string',
        ]);

        $jurusan->update($validated);
        LogAktivitas::catat('Edit Data', 'Kurikulum PKL', 'Memperbarui capaian kurikulum PKL jurusan ' . $jurusan->nama . ' (' . $jurusan->kode . ')');

        return redirect()->route('admin.jurusan.index')->with('success', 'Capaian Kurikulum PKL untuk ' . $jurusan->nama . ' berhasil diperbarui!');
    }

    public function syncIndustri(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $industriIds = $request->input('industri_ids', []);

        $jurusan->industris()->sync($industriIds);
        LogAktivitas::catat('Persetujuan', 'Kemitraan Jurusan', 'Menyinkronkan ' . count($industriIds) . ' mitra industri untuk jurusan ' . $jurusan->nama);

        $topNames = Industri::whereIn('id', $industriIds)->take(3)->pluck('nama')->toArray();
        $jurusan->mitra_utama = $topNames;
        $jurusan->save();

        return redirect()->route('admin.jurusan.index')->with('success', 'Daftar DU/DI mitra ' . $jurusan->nama . ' berhasil disinkronisasi!');
    }

    public function export(): StreamedResponse
    {
        $jurusans = Jurusan::with(['kaprog', 'rombels.siswas', 'industris', 'siswas.pengajuanPkl'])->get();

        $columns = [
            ['label' => 'ID', 'width' => 6, 'type' => 'number', 'align' => 'center'],
            ['label' => 'Kode', 'width' => 12, 'align' => 'center'],
            ['label' => 'Nama Program Keahlian', 'width' => 32],
            ['label' => 'Singkatan', 'width' => 12, 'align' => 'center'],
            ['label' => 'Bidang Keahlian', 'width' => 26],
            ['label' => 'Kaprog (Kepala Program)', 'width' => 28],
            ['label' => 'Jumlah Rombel XII', 'width' => 15, 'type' => 'number', 'align' => 'center'],
            ['label' => 'Kuota Kursi Industri', 'width' => 15, 'type' => 'number', 'align' => 'center'],
            ['label' => 'Kuota Terisi', 'width' => 13, 'type' => 'number', 'align' => 'center'],
            ['label' => 'Sisa Kuota', 'width' => 12, 'type' => 'number', 'align' => 'center'],
            ['label' => 'Persentase Keterserapan', 'width' => 16, 'align' => 'center'],
            ['label' => 'Mitra Utama DU/DI', 'width' => 36],
        ];

        $rows = [];
        foreach ($jurusans as $jurusan) {
            $rombelsXii = $jurusan->rombels->filter(function (Rombel $rombel) {
                return $rombel->tingkat === 'XII' && ($rombel->status ?? 'aktif') === 'aktif';
            });
            $rombelCount = $rombelsXii->count();
            $kuotaTotal = (int) $jurusan->industris->sum('kuota');
            $kuotaTerisi = $jurusan->siswas
                ->filter(fn (Siswa $siswa) => $siswa->pengajuanPkl?->status === 'disetujui')
                ->count();
            $sisaKuota = max(0, $kuotaTotal - $kuotaTerisi);
            $persentase = $kuotaTotal > 0
                ? round(($kuotaTerisi / $kuotaTotal) * 100, 1) . '%'
                : '0%';

            $rows[] = [
                $jurusan->id,
                $jurusan->kode,
                $jurusan->nama,
                $jurusan->singkatan,
                $jurusan->bidang,
                $jurusan->kaprog?->nama ?? '-',
                $rombelCount,
                $kuotaTotal,
                $kuotaTerisi,
                $sisaKuota,
                $persentase,
                $jurusan->industris->pluck('nama')->implode('; '),
            ];
        }

        return ExcelExporter::download(
            'master_data_jurusan_' . date('Ymd_His') . '.xls',
            'Data Jurusan',
            $columns,
            $rows,
            ['title' => 'MASTER DATA JURUSAN / PROGRAM KEAHLIAN', 'brand' => '047857']
        );
    }
}

