<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use App\Models\PengajuanPkl;
use App\Models\Jurusan;
use App\Models\Guru;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndustriController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->withRealtimeKuota(
            Industri::with(['jurusans', 'pembimbingGuru'])
        );

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('industri.nama', 'like', "%{$search}%")
                    ->orWhere('industri.kontak_nama', 'like', "%{$search}%")
                    ->orWhere('industri.alamat', 'like', "%{$search}%")
                    ->orWhere('industri.wilayah', 'like', "%{$search}%")
                    ->orWhere('industri.bidang_usaha', 'like', "%{$search}%")
                    ->orWhere('industri.pembimbing_nama', 'like', "%{$search}%")
                    ->orWhere('industri.no_mou', 'like', "%{$search}%");
            });
        }

        $tab = $request->input('tab', 'all');
        $this->applyQuotaTabFilter($query, $tab);

        if ($jurusanId = $request->input('jurusan_id')) {
            if ($jurusanId !== 'all') {
                $query->whereHas('jurusans', function ($q) use ($jurusanId) {
                    $q->where('jurusan.id', $jurusanId);
                });
            }
        }

        if ($wilayah = $request->input('wilayah')) {
            if ($wilayah !== 'all') {
                $query->where('industri.wilayah', 'like', "%{$wilayah}%");
            }
        }

        $sort = $request->input('sort', 'nama_asc');
        if ($sort === 'nama_desc') {
            $query->orderBy('industri.nama', 'desc');
        } elseif ($sort === 'kuota_desc') {
            $query->orderBy('industri.kuota', 'desc');
        } elseif ($sort === 'kuota_tersedia') {
            $query->orderByRaw('(industri.kuota - COALESCE(penempatan_pkl.total, 0)) DESC');
        } else {
            $query->orderBy('industri.nama', 'asc');
        }

        $viewMode = $request->input('view_mode', 'grid');
        $perPage = (int) $request->input('per_page', 8);
        if (!in_array($perPage, [8, 10, 25, 50, 100])) {
            $perPage = 8;
        }

        $industris = $query->paginate($perPage)->withQueryString();
        $industris->getCollection()->transform(function (Industri $industri) {
            $industri->setAttribute('kuota_terisi', (int) $industri->kuota_terisi_aktual);

            return $industri;
        });

        $totalMitra = Industri::count();
        $totalKuota = Industri::sum('kuota');
        $totalTerisi = PengajuanPkl::where('status', 'disetujui')
            ->whereNotNull('industri_id')
            ->count();
        $persenKapasitas = $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100) : 0;

        $quotaMetricsQuery = $this->withRealtimeKuota(Industri::query());
        $mitraPenuh = (clone $quotaMetricsQuery)
            ->whereRaw('COALESCE(penempatan_pkl.total, 0) >= industri.kuota')
            ->count('industri.id');
        $countAktif = (clone $quotaMetricsQuery)
            ->whereRaw('COALESCE(penempatan_pkl.total, 0) < industri.kuota')
            ->where('industri.status_kemitraan', '!=', 'perlu_evaluasi')
            ->count('industri.id');

        $kemitraanBaru = Industri::where('status_kemitraan', 'baru')->count();
        $countSemua = $totalMitra;
        $countPenuh = $mitraPenuh;
        $countEvaluasi = Industri::where('status_kemitraan', 'perlu_evaluasi')->count();

        $jurusans = Jurusan::where('status', 'aktif')->orderBy('nama')->get();
        $gurus = Guru::where('status_akun', 'aktif')->orderBy('nama')->get();
        $wilayahList = Industri::whereNotNull('wilayah')
            ->where('wilayah', '!=', '')
            ->select('wilayah')
            ->distinct()
            ->orderBy('wilayah')
            ->pluck('wilayah');

        return view('admin.industri.index', compact(
            'industris',
            'totalMitra',
            'totalKuota',
            'totalTerisi',
            'persenKapasitas',
            'mitraPenuh',
            'kemitraanBaru',
            'countSemua',
            'countAktif',
            'countPenuh',
            'countEvaluasi',
            'jurusans',
            'gurus',
            'wilayahList',
            'tab',
            'viewMode',
            'perPage'
        ));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'bidang_usaha' => 'required|string|max:150',
            'alamat' => 'required|string',
            'wilayah' => 'required|string|max:100',
            'no_mou' => 'nullable|string|max:100',
            'mou_berlaku_sampai' => 'nullable|date',
            'kontak_nama' => 'required|string|max:100',
            'kontak_jabatan' => 'nullable|string|max:100',
            'kontak_no_hp' => 'required|string|max:25',
            'kontak_email' => 'required|email|max:100',
            'kuota' => 'required|integer|min:1|max:50',
            'pembimbing_nama' => 'nullable|string|max:150',
            'status_kemitraan' => 'required|in:aktif,baru,perlu_evaluasi',
            'jurusan_ids' => 'nullable|array',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_url'] = $request->file('logo')->store('logos', 'public');
        }
        unset($validated['logo']);

        $industri = Industri::create($validated);

        if (!empty($validated['jurusan_ids'])) {
            $industri->jurusans()->sync($validated['jurusan_ids']);
        }

        LogAktivitas::catat('Tambah Data', 'Master Industri', 'Menambahkan mitra industri baru ' . $industri->nama);

        return redirect()->route('admin.industri.index')
            ->with('success', "Mitra Industri {$industri->nama} berhasil ditambahkan!");
    }
    public function update(Request $request, $id)
    {
        $industri = Industri::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'bidang_usaha' => 'required|string|max:150',
            'alamat' => 'required|string',
            'wilayah' => 'required|string|max:100',
            'no_mou' => 'nullable|string|max:100',
            'mou_berlaku_sampai' => 'nullable|date',
            'kontak_nama' => 'required|string|max:100',
            'kontak_jabatan' => 'nullable|string|max:100',
            'kontak_no_hp' => 'required|string|max:25',
            'kontak_email' => 'required|email|max:100',
            'kuota' => 'required|integer|min:1|max:50',
            'pembimbing_nama' => 'nullable|string|max:150',
            'status_kemitraan' => 'required|in:aktif,baru,perlu_evaluasi',
            'jurusan_ids' => 'nullable|array',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($industri->logo_url) {
                Storage::disk('public')->delete($industri->logo_url);
            }
            $validated['logo_url'] = $request->file('logo')->store('logos', 'public');
        }
        unset($validated['logo']);

        $industri->update($validated);

        if (isset($validated['jurusan_ids'])) {
            $industri->jurusans()->sync($validated['jurusan_ids']);
        }

        LogAktivitas::catat('Edit Data', 'Master Industri', 'Memperbarui data mitra industri ' . $industri->nama);

        return redirect()->route('admin.industri.index')
            ->with('success', "Data Kemitraan {$industri->nama} berhasil diperbarui!");
    }
    public function updateKuota(Request $request, $id)
    {
        $industri = Industri::findOrFail($id);
        $validated = $request->validate([
            'kuota' => 'required|integer|min:1|max:100',
        ]);

        $terisiAktual = $industri->pengajuanPkl()
            ->where('status', 'disetujui')
            ->count();

        if ($validated['kuota'] < $terisiAktual) {
            return redirect()->back()->withErrors([
                'kuota' => "Kuota tidak boleh lebih kecil dari {$terisiAktual} siswa yang sudah disetujui penempatannya.",
            ]);
        }

        $industri->update(['kuota' => $validated['kuota']]);

        LogAktivitas::catat(
            'Edit Data',
            'Master Industri',
            'Memperbarui daya tampung industri ' . $industri->nama . " ({$terisiAktual}/{$industri->kuota} siswa terisi aktual)"
        );

        return redirect()->back()->with(
            'success',
            "Daya tampung {$industri->nama} berhasil diperbarui. Jumlah terisi dihitung otomatis dari penempatan PKL yang disetujui ({$terisiAktual} siswa)."
        );
    }
    public function destroy($id)
    {
        $industri = Industri::findOrFail($id);
        $nama = $industri->nama;

        DB::transaction(function () use ($industri, $nama) {
            $industri->jurusans()->detach();
            $industri->delete();
            LogAktivitas::catat('Hapus Data', 'Master Industri', 'Menghapus mitra industri ' . $nama);
        });

        return redirect()->route('admin.industri.index')
            ->with('success', "Mitra Industri {$nama} berhasil dihapus dari direktori.");
    }

    public function bulkDelete(Request $request)
    {
        $ids = array_filter((array) $request->input('ids', []));
        if (!$ids) {
            return back()->with('info', 'Pilih minimal satu data.');
        }

        DB::transaction(function () use ($ids) {
            $industris = Industri::whereIn('id', $ids)->get();
            foreach ($industris as $industri) {
                $industri->jurusans()->detach();
                if ($industri->logo_url) {
                    Storage::disk('public')->delete($industri->logo_url);
                }
                $industri->delete();
            }
            LogAktivitas::catat('Hapus Data', 'Master Industri', 'Menghapus ' . $industris->count() . ' mitra industri');
        });

        return back()->with('success', count($ids) . ' data berhasil dihapus.');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = $this->withRealtimeKuota(Industri::with(['jurusans']));

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('industri.nama', 'like', "%{$search}%")
                    ->orWhere('industri.kontak_nama', 'like', "%{$search}%")
                    ->orWhere('industri.bidang_usaha', 'like', "%{$search}%");
            });
        }

        $this->applyQuotaTabFilter($query, $request->input('tab', 'all'));

        $industris = $query->orderBy('industri.nama', 'asc')->get();
        $industris->each(function (Industri $industri) {
            $industri->setAttribute('kuota_terisi', (int) $industri->kuota_terisi_aktual);
        });

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="master_data_industri_' . date('Ymd_His') . '.csv"',
        ];

        return response()->stream(function () use ($industris) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'No',
                'Nama Industri / DU-DI',
                'Bidang Usaha',
                'No. MoU Kemitraan',
                'Masa Berlaku MoU',
                'Alamat Lengkap',
                'Wilayah',
                'Nama PIC / Mentor',
                'Jabatan PIC',
                'No. HP / WA',
                'Email PIC',
                'Pembimbing Sekolah',
                'Kuota Total',
                'Kuota Terisi Aktual',
                'Sisa Kursi',
                'Status Kemitraan',
            ]);

            foreach ($industris as $index => $industri) {
                $terisiAktual = (int) $industri->kuota_terisi;
                $sisa = max(0, $industri->kuota - $terisiAktual);

                fputcsv($handle, [
                    $index + 1,
                    $industri->nama,
                    $industri->bidang_usaha ?: '-',
                    $industri->no_mou ?: '-',
                    $industri->mou_berlaku_sampai ? $industri->mou_berlaku_sampai->format('d/m/Y') : '-',
                    $industri->alamat ?: '-',
                    $industri->wilayah ?: 'Bogor',
                    $industri->kontak_nama ?: '-',
                    $industri->kontak_jabatan ?: '-',
                    $industri->kontak_no_hp ?: '-',
                    $industri->kontak_email ?: '-',
                    $industri->pembimbing_nama ?: '-',
                    $industri->kuota,
                    $terisiAktual,
                    $sisa,
                    strtoupper($industri->status_kemitraan),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    private function withRealtimeKuota($query)
    {
        $penempatanDisetujui = PengajuanPkl::query()
            ->select('industri_id', DB::raw('COUNT(*) as total'))
            ->where('status', 'disetujui')
            ->whereNotNull('industri_id')
            ->groupBy('industri_id');

        return $query
            ->leftJoinSub($penempatanDisetujui, 'penempatan_pkl', function ($join) {
                $join->on('penempatan_pkl.industri_id', '=', 'industri.id');
            })
            ->select('industri.*')
            ->selectRaw('COALESCE(penempatan_pkl.total, 0) as kuota_terisi_aktual');
    }

    private function applyQuotaTabFilter($query, string $tab): void
    {
        if ($tab === 'aktif') {
            $query->whereRaw('COALESCE(penempatan_pkl.total, 0) < industri.kuota')
                ->where('industri.status_kemitraan', '!=', 'perlu_evaluasi');
        } elseif ($tab === 'penuh') {
            $query->whereRaw('COALESCE(penempatan_pkl.total, 0) >= industri.kuota');
        } elseif ($tab === 'perlu_evaluasi') {
            $query->where('industri.status_kemitraan', 'perlu_evaluasi');
        }
    }
}
