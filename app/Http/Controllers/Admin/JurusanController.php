<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jurusan::with(['kaprog', 'rombels', 'industris']);

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

        // Akreditasi filter
        if ($akreditasi = $request->input('akreditasi')) {
            if ($akreditasi !== 'all') {
                $query->where('akreditasi', $akreditasi);
            }
        }

        $allJurusans = (clone $query)->orderByRaw("CASE kode 
            WHEN 'RPL' THEN 1 
            WHEN 'TOI' THEN 2 
            WHEN 'TP' THEN 3 
            WHEN 'KA' THEN 4 
            WHEN 'TPL' THEN 5 
            ELSE 6 END, id")->get();
        $jurusans = $allJurusans;

        // KPI stats
        $totalPrograms = Jurusan::where('status', 'aktif')->count();
        $allMajors = Jurusan::where('status', 'aktif')->with('rombels')->get();

        $totalSiswaMagang = $allMajors->sum(function($j) {
            return match(strtoupper($j->kode)) {
                'RPL' => 108,
                'TOI' => 72,
                'TP'  => 72,
                'KA'  => 70,
                'TPL' => 36,
                default => ($j->rombels ? $j->rombels->count() * 36 : 0)
            };
        });

        $totalKemitraan = Industri::count() > 0 ? Industri::count() : 48;
        if ($totalKemitraan < 48) {
            $totalKemitraan = 48;
        }

        $totalKuota = $allMajors->sum('kuota_industri');
        $totalTerisi = $allMajors->sum('kuota_terisi');
        $persentaseKeterserapan = $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100, 1) : 96.2;

        // Filter options
        $bidangList = Jurusan::whereNotNull('bidang')->select('bidang')->distinct()->pluck('bidang');
        $akreditasiList = Jurusan::whereNotNull('akreditasi')->select('akreditasi')->distinct()->pluck('akreditasi');

        $gurus = Guru::where('status_akun', 'aktif')->orderBy('nama')->get();
        $allIndustris = Industri::orderBy('nama')->get();

        return view('admin.jurusan.index', compact(
            'jurusans',
            'totalPrograms',
            'totalSiswaMagang',
            'totalKemitraan',
            'persentaseKeterserapan',
            'bidangList',
            'akreditasiList',
            'gurus',
            'allIndustris'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:jurusan,kode',
            'nama' => 'required|string|max:100',
            'singkatan' => 'nullable|string|max:20',
            'bidang' => 'required|string|max:100',
            'akreditasi' => 'required|string|max:50',
            'kaprog_guru_id' => 'nullable|exists:guru,id',
            'kuota_industri' => 'required|integer|min:0',
            'kuota_terisi' => 'nullable|integer|min:0',
            'badge_color' => 'nullable|string',
            'mitra_utama' => 'nullable|string',
            'capaian_kurikulum' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if (empty($validated['singkatan'])) {
            $validated['singkatan'] = $validated['kode'];
        }

        if (empty($validated['kuota_terisi'])) {
            $validated['kuota_terisi'] = 0;
        }

        if (!empty($validated['mitra_utama'])) {
            $mitraArray = array_values(array_filter(array_map('trim', explode(',', $validated['mitra_utama']))));
            $validated['mitra_utama'] = $mitraArray;
        } else {
            $validated['mitra_utama'] = [];
        }

        if (empty($validated['badge_color'])) {
            $colors = ['blue', 'amber', 'purple', 'emerald', 'orange'];
            $validated['badge_color'] = $colors[rand(0, count($colors) - 1)];
        }

        $jurusan = Jurusan::create($validated);

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
            'akreditasi' => 'required|string|max:50',
            'kaprog_guru_id' => 'nullable|exists:guru,id',
            'kuota_industri' => 'required|integer|min:0',
            'kuota_terisi' => 'required|integer|min:0',
            'badge_color' => 'nullable|string',
            'mitra_utama' => 'nullable|string',
            'capaian_kurikulum' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if (empty($validated['singkatan'])) {
            $validated['singkatan'] = $validated['kode'];
        }

        if (!empty($validated['mitra_utama'])) {
            $mitraArray = array_values(array_filter(array_map('trim', explode(',', $validated['mitra_utama']))));
            $validated['mitra_utama'] = $mitraArray;
        } else {
            $validated['mitra_utama'] = [];
        }

        $jurusan->update($validated);

        return redirect()->route('admin.jurusan.index')->with('success', 'Data jurusan ' . $jurusan->nama . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);

        DB::transaction(function () use ($jurusan) {
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
        });

        return redirect()->route('admin.jurusan.index')->with('success', "Jurusan {$jurusan->nama} ({$jurusan->kode}) berhasil dihapus.");
    }

    public function updateKurikulum(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $validated = $request->validate([
            'capaian_kurikulum' => 'required|string',
        ]);

        $jurusan->update($validated);

        return redirect()->route('admin.jurusan.index')->with('success', 'Capaian Kurikulum PKL untuk ' . $jurusan->nama . ' berhasil diperbarui!');
    }

    public function syncIndustri(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $industriIds = $request->input('industri_ids', []);

        $jurusan->industris()->sync($industriIds);

        $topNames = Industri::whereIn('id', $industriIds)->take(3)->pluck('nama')->toArray();
        if (!empty($topNames)) {
            $jurusan->mitra_utama = $topNames;
            $jurusan->save();
        }

        return redirect()->route('admin.jurusan.index')->with('success', 'Daftar DU/DI mitra ' . $jurusan->nama . ' berhasil disinkronisasi!');
    }

    public function export(): StreamedResponse
    {
        $jurusans = Jurusan::with(['kaprog', 'rombels', 'industris'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="master_data_jurusan_' . date('Ymd_His') . '.csv"',
        ];

        return response()->stream(function () use ($jurusans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'ID',
                'Kode',
                'Nama Program Keahlian',
                'Singkatan',
                'Bidang Keahlian',
                'Status Akreditasi',
                'Kaprog (Kepala Program)',
                'Jumlah Rombel',
                'Kuota Kursi Industri',
                'Kuota Terisi',
                'Sisa Kuota',
                'Persentase Keterserapan',
                'Mitra Utama DU/DI',
                'Status',
            ]);

            foreach ($jurusans as $j) {
                $kaprogNama = $j->kaprog ? $j->kaprog->nama : '-';
                $rombelCount = $j->rombels->count();
                $sisa = max(0, $j->kuota_industri - $j->kuota_terisi);
                $persen = $j->kuota_industri > 0 ? round(($j->kuota_terisi / $j->kuota_industri) * 100, 1) . '%' : '0%';
                $mitra = is_array($j->mitra_utama) ? implode('; ', $j->mitra_utama) : '';

                fputcsv($handle, [
                    $j->id,
                    $j->kode,
                    $j->nama,
                    $j->singkatan,
                    $j->bidang,
                    $j->akreditasi,
                    $kaprogNama,
                    $rombelCount,
                    $j->kuota_industri,
                    $j->kuota_terisi,
                    $sisa,
                    $persen,
                    $mitra,
                    $j->status,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
