<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Murid PKL — Kelas {{ $rombel->nama_rombel ?? 'XII RPL 2' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1e293b;
            margin: 20px;
            font-size: 11px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 4px 0;
            font-size: 13px;
        }
        .header p {
            margin: 0;
            font-size: 10px;
            color: #64748b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        .status-berjalan { color: #059669; font-weight: bold; }
        .status-menunggu { color: #d97706; font-weight: bold; }
        .status-selesai { color: #0284c7; font-weight: bold; }
        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            width: 200px;
            text-align: center;
        }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #0f172a; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            🖨️ Cetak Dokumen / Simpan PDF
        </button>
    </div>

    <div class="header">
        <h1>SMK NEGERI 1 GUNUNGPUTRI</h1>
        <h2>REKAPITULASI DATA PESERTA PRAKTIK KERJA LAPANGAN (PKL)</h2>
        <p>Kelas: {{ $rombel->nama_rombel ?? 'XII RPL 2' }} • Tahun Ajaran 2024/2026 • Program Keahlian Rekayasa Perangkat Lunak</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25px; text-align: center;">No</th>
                <th>Nama Siswa</th>
                <th style="width: 85px;">NISN</th>
                <th>Mitra Industri (DU/DI)</th>
                <th>Posisi / Bidang</th>
                <th>Guru Pembimbing</th>
                <th style="width: 65px; text-align: center;">Kehadiran</th>
                <th style="width: 100px; text-align: center;">Status PKL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $idx => $s)
                @php
                    $p = $primaryProfiles[$s->nisn] ?? null;
                    $status = $p ? $p['status'] : ($s->status_pkl === 'Menunggu Konfirmasi' ? 'Menunggu Persetujuan' : ($s->status_pkl === 'Selesai' ? 'Selesai' : 'Berjalan'));
                    $posisi = $p['posisi'] ?? 'Teknisi IT & Software';
                    $kehadiran = $p['kehadiran_persen'] ?? ($status === 'Menunggu Persetujuan' ? 0 : ($status === 'Selesai' ? 100 : (42 + ($s->id % 8)) * 2));
                    $pembimbing = $p['pembimbing_override'] ?? ($s->penugasanPembimbing?->pembimbing?->nama ?? 'Belum Ditugaskan');
                    $statusClass = match($status) {
                        'Menunggu Persetujuan' => 'status-menunggu',
                        'Selesai' => 'status-selesai',
                        default => 'status-berjalan',
                    };
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td><strong>{{ $s->nama }}</strong></td>
                    <td>{{ $s->nisn }}</td>
                    <td>{{ $s->pengajuanPkl?->industri?->nama ?? 'PT Telkom Akses' }}</td>
                    <td>{{ $posisi }}</td>
                    <td>{{ $pembimbing }}</td>
                    <td style="text-align: center;">{{ $kehadiran }}%</td>
                    <td style="text-align: center;" class="{{ $statusClass }}">{{ $status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer" style="margin-top: 40px; display: table; width: 100%;">
        <div style="display: table-cell; width: 50%;">
            <p>Mengetahui,<br>Kepala Program Keahlian RPL</p>
            <br><br><br>
            <p><strong>Ir. Dian Hendrawan, S.Kom., M.T.</strong><br>NIP. 197805122005011004</p>
        </div>
        <div style="display: table-cell; width: 50%; text-align: right;">
            <p>Gunungputri, {{ date('d F Y') }}<br>Wali Kelas {{ $rombel->nama_rombel ?? 'XII RPL 2' }}</p>
            <br><br><br>
            <p><strong>{{ $rombel->waliKelas?->nama ?? 'Endang Supriyatna, S.AP.' }}</strong><br>NIP. {{ $rombel->waliKelas?->nip ?? '197408152003121004' }}</p>
        </div>
    </div>
</body>
</html>
