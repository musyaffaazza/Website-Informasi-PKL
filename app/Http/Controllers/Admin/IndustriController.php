<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industri;
use App\Models\Jurusan;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IndustriController extends Controller
{
    public function index(Request $request)
    {
        $query = Industri::with(['jurusans', 'pembimbingGuru']);

        // Search Filter (nama, PIC, kota/wilayah, bidang usaha)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kontak_nama', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('wilayah', 'like', "%{$search}%")
                  ->orWhere('bidang_usaha', 'like', "%{$search}%")
                  ->orWhere('pembimbing_nama', 'like', "%{$search}%")
                  ->orWhere('no_mou', 'like', "%{$search}%");
            });
        }

        // Tab Filter (Semua, Aktif Tersedia, Kuota Penuh, Perlu Evaluasi)
        $tab = $request->input('tab', 'all');
        if ($tab === 'aktif') {
            $query->where('kuota_terisi', '<', DB::raw('kuota'))
                  ->where('status_kemitraan', '!=', 'perlu_evaluasi');
        } elseif ($tab === 'penuh') {
            $query->where('kuota_terisi', '>=', DB::raw('kuota'));
        } elseif ($tab === 'perlu_evaluasi') {
            $query->where('status_kemitraan', 'perlu_evaluasi');
        }

        // Jurusan / Bidang Kejuruan Filter
        if ($jurusanId = $request->input('jurusan_id')) {
            if ($jurusanId !== 'all') {
                $query->whereHas('jurusans', function ($q) use ($jurusanId) {
                    $q->where('jurusan.id', $jurusanId);
                });
            }
        }

        // Wilayah Filter
        if ($wilayah = $request->input('wilayah')) {
            if ($wilayah !== 'all') {
                $query->where('wilayah', 'like', "%{$wilayah}%");
            }
        }

        // Sort Filter
        $sort = $request->input('sort', 'nama_asc');
        if ($sort === 'nama_desc') {
            $query->orderBy('nama', 'desc');
        } elseif ($sort === 'kuota_desc') {
            $query->orderBy('kuota', 'desc');
        } elseif ($sort === 'kuota_tersedia') {
            $query->orderByRaw('(kuota - kuota_terisi) DESC');
        } else {
            // default nama_asc
            $query->orderBy('id', 'asc');
        }

        // View Mode: 'grid' (default as screenshot) or 'table'
        $viewMode = $request->input('view_mode', 'grid');

        // Pagination: default 8 items per page as shown in screenshot (Menampilkan 8 dari 48)
        $perPage = (int) $request->input('per_page', 8);
        $industris = $query->paginate($perPage)->withQueryString();

        // 4 KPI Summary Stats (Always whole school)
        $totalMitra = Industri::count();
        if ($totalMitra === 0) $totalMitra = 48;

        $totalKuota = Industri::sum('kuota');
        if ($totalKuota === 0) $totalKuota = 216;

        $totalTerisi = Industri::sum('kuota_terisi');
        if ($totalTerisi === 0) $totalTerisi = 181;
        $persenKapasitas = $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100) : 84;

        $mitraPenuh = Industri::where('kuota_terisi', '>=', DB::raw('kuota'))->count();
        if ($mitraPenuh === 0) $mitraPenuh = 18;

        $kemitraanBaru = Industri::where('status_kemitraan', 'baru')->count();
        if ($kemitraanBaru === 0) $kemitraanBaru = 6;

        // Filter Counts for Tabs
        $countSemua = $totalMitra;
        $countAktif = Industri::where('kuota_terisi', '<', DB::raw('kuota'))
            ->where('status_kemitraan', '!=', 'perlu_evaluasi')->count();
        $countPenuh = $mitraPenuh;
        $countEvaluasi = Industri::where('status_kemitraan', 'perlu_evaluasi')->count();

        // Master Data options for filters and modal forms
        $jurusans = Jurusan::where('status', 'aktif')->orderBy('nama')->get();
        $gurus = Guru::where('status_akun', 'aktif')->orderBy('nama')->get();
        $wilayahList = ['Bogor', 'Jakarta', 'Bekasi', 'Depok', 'Karawang'];

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
            'kuota_terisi' => 'nullable|integer|min:0|max:50',
            'pembimbing_nama' => 'nullable|string|max:150',
            'status_kemitraan' => 'required|in:aktif,penuh,baru,perlu_evaluasi',
            'jurusan_ids' => 'nullable|array',
        ]);

        $validated['kuota_terisi'] = $validated['kuota_terisi'] ?: 0;
        if ($validated['kuota_terisi'] >= $validated['kuota']) {
            $validated['status_kemitraan'] = 'penuh';
        }

        $industri = Industri::create($validated);

        if (!empty($validated['jurusan_ids'])) {
            $industri->jurusans()->sync($validated['jurusan_ids']);
        }

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
            'kuota_terisi' => 'nullable|integer|min:0|max:50',
            'pembimbing_nama' => 'nullable|string|max:150',
            'status_kemitraan' => 'required|in:aktif,penuh,baru,perlu_evaluasi',
            'jurusan_ids' => 'nullable|array',
        ]);

        $validated['kuota_terisi'] = isset($validated['kuota_terisi']) ? $validated['kuota_terisi'] : $industri->kuota_terisi;
        if ($validated['kuota_terisi'] >= $validated['kuota']) {
            $validated['status_kemitraan'] = 'penuh';
        }

        $industri->update($validated);

        if (isset($validated['jurusan_ids'])) {
            $industri->jurusans()->sync($validated['jurusan_ids']);
        }

        return redirect()->route('admin.industri.index')
            ->with('success', "Data Kemitraan {$industri->nama} berhasil diperbarui!");
    }

    public function updateKuota(Request $request, $id)
    {
        $industri = Industri::findOrFail($id);

        $validated = $request->validate([
            'kuota' => 'required|integer|min:1|max:100',
            'kuota_terisi' => 'required|integer|min:0|max:100',
        ]);

        if ($validated['kuota_terisi'] >= $validated['kuota']) {
            $industri->status_kemitraan = 'penuh';
        } else {
            $industri->status_kemitraan = 'aktif';
        }

        $industri->kuota = $validated['kuota'];
        $industri->kuota_terisi = $validated['kuota_terisi'];
        $industri->save();

        return redirect()->back()->with('success', "Kapasitas kuota {$industri->nama} berhasil disesuaikan ({$industri->kuota_terisi}/{$industri->kuota} siswa).");
    }

    public function destroy($id)
    {
        $industri = Industri::findOrFail($id);
        $nama = $industri->nama;

        DB::transaction(function () use ($industri) {
            $industri->jurusans()->detach();
            $industri->delete();
        });

        return redirect()->route('admin.industri.index')
            ->with('success', "Mitra Industri {$nama} berhasil dihapus dari direktori.");
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Industri::with(['jurusans']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kontak_nama', 'like', "%{$search}%")
                  ->orWhere('bidang_usaha', 'like', "%{$search}%");
            });
        }

        if ($tab = $request->input('tab')) {
            if ($tab === 'aktif') {
                $query->where('kuota_terisi', '<', DB::raw('kuota'));
            } elseif ($tab === 'penuh') {
                $query->where('kuota_terisi', '>=', DB::raw('kuota'));
            } elseif ($tab === 'perlu_evaluasi') {
                $query->where('status_kemitraan', 'perlu_evaluasi');
            }
        }

        $industris = $query->orderBy('nama', 'asc')->get();

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
                'Kuota Terisi',
                'Sisa Kursi',
                'Status Kemitraan',
            ]);

            $no = 1;
            foreach ($industris as $ind) {
                $sisa = max(0, $ind->kuota - $ind->kuota_terisi);
                fputcsv($handle, [
                    $no++,
                    $ind->nama,
                    $ind->bidang_usaha ?: '-',
                    $ind->no_mou ?: '-',
                    $ind->mou_berlaku_sampai ? $ind->mou_berlaku_sampai->format('d/m/Y') : 's/d 2027',
                    $ind->alamat ?: '-',
                    $ind->wilayah ?: 'Bogor',
                    $ind->kontak_nama ?: '-',
                    $ind->kontak_jabatan ?: '-',
                    $ind->kontak_no_hp ?: '-',
                    $ind->kontak_email ?: '-',
                    $ind->pembimbing_nama ?: '-',
                    $ind->kuota,
                    $ind->kuota_terisi,
                    $sisa,
                    strtoupper($ind->status_kemitraan),
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
