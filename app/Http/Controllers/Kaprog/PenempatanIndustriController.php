<?php

namespace App\Http\Controllers\Kaprog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Industri;
use App\Models\Guru;
use App\Models\Siswa;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PenempatanIndustriController extends Controller
{
    /**
     * Display the list of partner industries with quota metrics matching the design.
     */
    public function index(Request $request)
    {
        $jurusan = Jurusan::where('kode', 'RPL')->first();
        $jurusanId = $jurusan?->id ?? 1;

        $perPage = (int) $request->get('per_page', 16);
        $search = $request->get('search');
        $sektor = $request->get('sektor');
        $wilayah = $request->get('wilayah');
        $sort = $request->get('sort', 'penuh');

        // Base scope: only industries linked to jurusan RPL
        $baseScope = fn($q) => $q->whereHas('jurusans', fn($jq) => $jq->where('jurusan.id', $jurusanId));

        $query = Industri::whereHas('jurusans', fn($jq) => $jq->where('jurusan.id', $jurusanId));

        // Search filter
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%")
                  ->orWhere('wilayah', 'LIKE', "%{$search}%")
                  ->orWhere('bidang_usaha', 'LIKE', "%{$search}%")
                  ->orWhere('pembimbing_nama', 'LIKE', "%{$search}%");
            });
        }

        // Sektor filter
        if (!empty($sektor)) {
            $query->where('bidang_usaha', 'LIKE', "%{$sektor}%");
        }

        // Wilayah filter
        if (!empty($wilayah)) {
            $query->where('wilayah', 'LIKE', "%{$wilayah}%");
        }

        // Sorting
        switch ($sort) {
            case 'tersedia':
                $query->orderByRaw('(kuota - kuota_terisi) DESC');
                break;
            case 'nama':
                $query->orderBy('nama', 'ASC');
                break;
            case 'kuota_terbanyak':
                $query->orderBy('kuota', 'DESC');
                break;
            case 'penuh':
            default:
                $query->orderByRaw('(kuota_terisi / kuota) DESC')->orderBy('kuota', 'DESC');
                break;
        }

        // Stats: scoped to RPL only
        $allIndustris = Industri::whereHas('jurusans', fn($jq) => $jq->where('jurusan.id', $jurusanId))->get();
        $totalMitra = $allIndustris->count();
        $aktifMitra = $allIndustris->where('status_kemitraan', '!=', 'MoU Baru')->count();
        $mouBaruMitra = $allIndustris->where('status_kemitraan', 'MoU Baru')->count();
        $totalKapasitas = (int) $allIndustris->sum('kuota');
        $totalTerisi = (int) $allIndustris->sum('kuota_terisi');
        $totalSiswa = Siswa::where('jurusan_id', $jurusanId)->count();
        $terplotPercent = $totalSiswa > 0 ? round(($totalTerisi / $totalSiswa) * 100, 1) : 0;
        $siswaSeleksi = max(0, $totalSiswa - $totalTerisi);
        $mitraPenuhCount = $allIndustris->filter(fn($i) => $i->kuota > 0 && $i->kuota_terisi >= $i->kuota)->count();

        $industris = $query->paginate($perPage)->appends($request->query());

        $gurus = Guru::where('status_akun', 'aktif')->orderBy('nama')->get();

        return view('kaprog.penempatan-industri.index', compact(
            'jurusan',
            'industris',
            'totalMitra',
            'aktifMitra',
            'mouBaruMitra',
            'totalKapasitas',
            'totalTerisi',
            'totalSiswa',
            'terplotPercent',
            'siswaSeleksi',
            'mitraPenuhCount',
            'gurus',
            'perPage'
        ));
    }

    /**
     * Store new industry quota / partner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'bidang_usaha' => 'required|string|max:255',
            'wilayah' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kuota' => 'required|integer|min:1|max:50',
            'pembimbing_nama' => 'nullable|string|max:255',
            'status_kemitraan' => 'nullable|string',
        ]);

        $jurusan = Jurusan::where('kode', 'RPL')->first();

        $industri = Industri::create([
            'nama' => $request->nama,
            'bidang_usaha' => $request->bidang_usaha,
            'wilayah' => $request->wilayah,
            'alamat' => $request->alamat,
            'kuota' => $request->kuota,
            'kuota_terisi' => 0,
            'pembimbing_nama' => $request->pembimbing_nama ?? 'Drs. Bambang Wijaya',
            'status' => 'aktif',
            'status_kemitraan' => $request->status_kemitraan ?? 'Aktif',
            'no_mou' => 'MOU/SMK1GP/' . rand(100, 999) . '/2025',
        ]);

        if ($jurusan) {
            $industri->jurusans()->syncWithoutDetaching([$jurusan->id]);
        }

        return redirect()->route('kaprog.penempatan-industri.index')->with('success', 'Kuota mitra industri ' . $industri->nama . ' berhasil ditambahkan!');
    }

    /**
     * Export recap matrix of industry placements to CSV.
     */
    public function export(): StreamedResponse
    {
        $industris = Industri::orderByRaw('(kuota_terisi / kuota) DESC')->get();
        $fileName = 'rekap_penempatan_industri_rpl_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function() use ($industris) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8

            fputcsv($output, [
                'No',
                'Nama Mitra DU/DI',
                'Sektor Kejuruan',
                'Wilayah / Lokasi',
                'Kapasitas Kuota',
                'Siswa Terisi',
                'Sisa Kuota',
                'Persentase Keterisian',
                'Guru Pembimbing',
                'Status Kemitraan'
            ]);

            foreach ($industris as $index => $ind) {
                $percent = $ind->kuota > 0 ? round(($ind->kuota_terisi / $ind->kuota) * 100, 1) : 0;
                $sisa = max(0, $ind->kuota - $ind->kuota_terisi);

                fputcsv($output, [
                    $index + 1,
                    $ind->nama,
                    $ind->bidang_usaha,
                    $ind->alamat ?: $ind->wilayah,
                    $ind->kuota,
                    $ind->kuota_terisi,
                    $sisa,
                    $percent . '%',
                    $ind->pembimbing_nama ?: 'Belum Ditugaskan',
                    $ind->status_kemitraan ?: 'Aktif'
                ]);
            }

            fclose($output);
        }, 200, $headers);
    }
}
