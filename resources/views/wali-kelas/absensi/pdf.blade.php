<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi PKL — {{ $siswa->nama ?? 'Raka Pratama' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 25px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f2942;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .header h1 {
            font-size: 16px;
            margin: 0;
            color: #0f2942;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0 0 0;
            color: #64748b;
            font-size: 10px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 6px;
            font-size: 10px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table th, .data-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
        }
        .data-table th {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
        }
        .badge-hadir { background-color: #ecfdf5; color: #047857; }
        .badge-sakit { background-color: #e0e7ff; color: #4338ca; }
        .signature-section {
            margin-top: 30px;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .sig-box {
            display: inline-block;
            width: 45%;
            text-align: center;
        }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background-color: #0f2942; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: bold;">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    <div class="header">
        <h1>Laporan Rekapitulasi Presensi Kehadiran Siswa PKL</h1>
        <p>SMK NEGERI 1 GUNUNGPUTRI — TAHUN AJARAN 2024/2025</p>
        <p>Periode: {{ $periodeTitle ?? 'September 2026' }} ({{ $periodeGasalGenap ?? 'Semester Gasal' }})</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Nama Siswa</strong></td>
            <td width="35%">: {{ $siswa->nama }}</td>
            <td width="18%"><strong>Mitra DU/DI</strong></td>
            <td width="32%">: {{ $siswa->pengajuanPkl?->industri?->nama ?? 'PT Telkom Akses Area Bogor' }}</td>
        </tr>
        <tr>
            <td><strong>NISN / NIS</strong></td>
            <td>: {{ $siswa->nisn }} / {{ $siswa->nis ?: '212210408' }}</td>
            <td><strong>Unit / Divisi</strong></td>
            <td>: Network Operations Center (NOC)</td>
        </tr>
        <tr>
            <td><strong>Kelas / Jurusan</strong></td>
            <td>: XII RPL 2 (Rekayasa Perangkat Lunak)</td>
            <td><strong>Pembimbing Sekolah</strong></td>
            <td>: {{ $siswa->penugasanPembimbing?->pembimbing?->nama ?? 'Drs. Bambang Wijaya, M.Pd.' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="15%">Tanggal</th>
                <th width="12%">Check-in</th>
                <th width="12%">Check-out</th>
                <th width="12%">Durasi</th>
                <th width="15%">Status</th>
                <th width="30%">Keterangan & Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensis as $idx => $ab)
                @php
                    $isHadir = ($ab->status === 'hadir');
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($ab->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>{{ $ab->jam_masuk ? substr($ab->jam_masuk, 0, 5) . ' WIB' : '—' }}</td>
                    <td>{{ $ab->jam_keluar ? substr($ab->jam_keluar, 0, 5) . ' WIB' : '—' }}</td>
                    <td>
                        @if($ab->jam_masuk && $ab->jam_keluar)
                            @php
                                $dIn = \Carbon\Carbon::parse($ab->jam_masuk);
                                $dOut = \Carbon\Carbon::parse($ab->jam_keluar);
                                $min = $dIn->diffInMinutes($dOut);
                            @endphp
                            {{ floor($min / 60) }}j {{ sprintf('%02d', $min % 60) }}m
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $isHadir ? 'badge-hadir' : 'badge-sakit' }}">
                            {{ $isHadir ? 'Hadir Tepat' : 'Izin Sakit' }}
                        </span>
                    </td>
                    <td>{{ $ab->keterangan ?: 'Presensi di unit kantor NOC' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 25px; padding: 10px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;">
        <strong>Catatan Supervisi:</strong>
        <p style="margin: 4px 0 0 0; font-style: italic; color: #475569;">
            "Kedisiplinan ananda Raka sangat memuaskan di unit NOC PT Telkom Akses. Tidak terdapat keterlambatan maupun ketidakhadiran tanpa izin."
        </p>
    </div>

    <table style="width: 100%; margin-top: 30px;">
        <tr>
            <td style="width: 50%; text-align: center;">
                Mengetahui,<br>
                <strong>Mentor Lapangan DU/DI</strong><br><br><br><br>
                <u>Hendra Kurniawan, S.T.</u><br>
                Senior Network Engineer
            </td>
            <td style="width: 50%; text-align: center;">
                Bogor, 22 September 2026<br>
                <strong>Guru Pembimbing PKL</strong><br><br><br><br>
                <u>Drs. Bambang Wijaya, M.Pd.</u><br>
                NIP. 197503152002121002
            </td>
        </tr>
    </table>
</body>
</html>
