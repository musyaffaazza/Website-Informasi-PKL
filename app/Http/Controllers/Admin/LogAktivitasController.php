<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');
        $this->applyFilters($query, $request);

        $perPage = (int) $request->input('per_page', 8);
        if (!in_array($perPage, [8, 10, 25, 50, 100])) {
            $perPage = 8;
        }

        $logs = $query->orderBy('dibuat_pada', 'desc')
                      ->paginate($perPage)
                      ->withQueryString();

        $totalLog = LogAktivitas::count();
        $logHariIni = LogAktivitas::whereDate('dibuat_pada', today())->count();
        $penggunaAktif = LogAktivitas::distinct('user_id')->count('user_id');
        $otorisasiCount = LogAktivitas::whereIn('aksi', ['Ubah Status', 'Persetujuan', 'Menyetujui'])->count();
        $mutasiCount = LogAktivitas::whereIn('aksi', ['Tambah Data', 'Edit Data', 'Hapus Data', 'Impor Data', 'Ekspor Data'])->count();
        $securityCount = LogAktivitas::where('modul', 'Autentikasi')->count();

        $modulList = LogAktivitas::select('modul')
                        ->whereNotNull('modul')
                        ->distinct()
                        ->orderBy('modul')
                        ->pluck('modul');

        $aksiList = LogAktivitas::select('aksi')
                        ->distinct()
                        ->orderBy('aksi')
                        ->pluck('aksi');

        return view('admin.log-aktivitas.index', compact(
            'logs',
            'totalLog',
            'logHariIni',
            'penggunaAktif',
            'otorisasiCount',
            'mutasiCount',
            'securityCount',
            'modulList',
            'aksiList',
            'perPage'
        ));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = LogAktivitas::with('user')->orderBy('dibuat_pada', 'desc');
        $this->applyFilters($query, $request);
        $logs = $query->get();
        $filename = 'log_aktivitas_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'No', 'Pengguna', 'Tipe', 'Aksi', 'Modul', 'Deskripsi', 'IP Address', 'Waktu',
            ]);
            foreach ($logs as $i => $log) {
                fputcsv($handle, [
                    $i + 1,
                    $log->user?->username ?? '-',
                    $log->user?->tipe_akun ?? '-',
                    $log->aksi,
                    $log->modul ?? '-',
                    $log->deskripsi ?? '-',
                    $log->ip_address ?? '-',
                    $log->dibuat_pada?->format('d/m/Y H:i') ?? '-',
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function applyFilters($query, Request $request): void
    {
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('aksi', 'like', "%{$search}%")
                  ->orWhere('modul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($sub) use ($search) {
                      $sub->where('username', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($role = $request->input('role')) {
            if ($role !== 'all') {
                $query->whereHas('user', fn ($user) => $user->where('tipe_akun', $role));
            }
        }

        if ($modul = $request->input('modul')) {
            if ($modul !== 'all') {
                $query->where('modul', $modul);
            }
        }

        if ($aksi = $request->input('aksi')) {
            if ($aksi !== 'all') {
                $query->where('aksi', $aksi);
            }
        }

        if ($from = $request->input('from')) {
            $query->whereDate('dibuat_pada', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('dibuat_pada', '<=', $to);
        }
    }
}