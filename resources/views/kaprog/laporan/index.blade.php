@extends('layouts.kaprog')

@section('title', 'Laporan PKL — Rekayasa Perangkat Lunak, Semester Ganjil 2026 | SIPRAK')

@section('content')
<div class="space-y-6 pb-8">
    <!-- Top Breadcrumb & Page Header -->
    <div class="no-print">
        <!-- Breadcrumb Links -->
        <nav class="flex items-center gap-1.5 text-xs font-semibold text-slate-400 mb-2">
            <a href="{{ route('kaprog.murid-pkl.index') }}" class="text-slate-500 hover:text-sky-600 transition">Kaprog RPL</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-500">Rekapitulasi &amp; Laporan</span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-800 font-bold">Laporan PKL Semester Ganjil 2026</span>
        </nav>

        <!-- Title & Action Buttons -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2.5 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                        Laporan PKL — Jurusan RPL, Semester Ganjil 2026
                    </h1>
                    <span class="px-2.5 py-0.5 bg-slate-200/80 text-slate-700 rounded-md text-[10px] font-extrabold uppercase tracking-wider">
                        {{ $docInfo['status_arsip'] }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed max-w-4xl">
                    Rekapitulasi komprehensif pelaksanaan Praktik Kerja Lapangan {{ $summary['total_siswa'] }} siswa ({{ $rekapRombel->pluck('kelas')->join(', ') }}) untuk evaluasi pimpinan dan Waka Hubinmas.
                </p>
            </div>

            <!-- Action Buttons: Pratinjau Cetak & Export Laporan Dropdown -->
            <div class="flex items-center gap-2.5 shrink-0" x-data="{ exportOpen: false }">
                <button type="button"
                        onclick="window.print()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition shadow-2xs">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Pratinjau Cetak</span>
                </button>

                <div class="relative">
                    <button type="button"
                            @click="exportOpen = !exportOpen"
                            class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-[#153f66] text-white text-xs font-bold rounded-xl transition shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Export Laporan</span>
                        <svg class="w-3.5 h-3.5 text-white/80 transition-transform duration-200" :class="exportOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Export Dropdown -->
                    <div x-show="exportOpen"
                         @click.outside="exportOpen = false"
                         x-cloak
                         x-transition
                         class="absolute right-0 mt-2 w-56 bg-white rounded-2xl border border-slate-200 shadow-xl z-50 py-1.5 divide-y divide-slate-100">
                        <div class="py-1">
                            <a href="{{ route('kaprog.laporan.export') }}"
                               class="flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h7a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                </svg>
                                <span>Unduh Spreadsheet (.CSV)</span>
                            </a>
                            <button type="button"
                                    onclick="window.print()"
                                    class="w-full text-left flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span>Simpan sebagai PDF / Cetak</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3 Stat Cards Mandiri (Berdampingan 3 Kolom) -->
    <div class="stat-grid-3">
        <!-- Card 1: TOTAL SISWA PKL -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        TOTAL SISWA PKL
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-2">
                    {{ $summary['total_siswa'] }}
                </div>
            </div>
            <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 text-xs">
                <span class="text-slate-500 font-medium">{{ $summary['mitra_dudi'] }} Mitra DUDI Rekanan</span>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-sky-50 text-sky-700 border border-sky-100 rounded-full font-bold text-[11px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                    <span>{{ $summary['total_siswa'] > 0 ? 'Lengkap (100%)' : 'Belum Ada Siswa' }}</span>
                </span>
            </div>
        </div>

        <!-- Card 2: RATA-RATA KEHADIRAN -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        RATA-RATA KEHADIRAN
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-2">
                    {{ $summary['kehadiran'] }}%
                </div>
            </div>
            <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 text-xs">
                <span class="text-slate-500 font-medium">{{ $summary['jam_terverifikasi'] }}</span>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-teal-50 text-teal-700 border border-teal-100 rounded-full font-bold text-[11px]">
                    <span>{{ $summary['kehadiran_badge'] }}</span>
                </span>
            </div>
        </div>

        <!-- Card 3: SISWA SELESAI & LULUS -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 sm:p-6 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        SISWA SELESAI &amp; LULUS
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-1.5 mt-2">
                    <span class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">{{ $summary['siswa_lulus'] }}</span>
                    <span class="text-base sm:text-lg font-bold text-slate-400">/ {{ $summary['total_siswa'] }}</span>
                </div>
            </div>
            <div class="flex items-center justify-between mt-5 pt-3 border-t border-slate-100 text-xs">
                <span class="text-slate-500 font-medium">{{ $summary['portofolio_bimbingan'] }}</span>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-sky-50 text-sky-700 border border-sky-100 rounded-full font-bold text-[11px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                    <span>{{ $summary['lulus_badge'] }}</span>
                </span>
            </div>
        </div>
    </div>

    <!-- KOTAK 4: Alur Verifikasi & Persetujuan Berkas (Approval Funnel) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h3 class="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                    Alur Verifikasi &amp; Persetujuan Berkas (Approval Funnel)
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Pemantauan gerbang validasi mulai dari registrasi formulir hingga konfirmasi penempatan aktif di DUDI.
                </p>
            </div>
            <span class="inline-flex items-center px-3 py-1 bg-slate-100 text-slate-700 border border-slate-200/80 rounded-lg text-xs font-bold shrink-0 self-start sm:self-auto">
                Status: Finalisasi Batch 1
            </span>
        </div>

        <!-- Funnel Steps List -->
        <div class="bg-slate-50/80 border border-slate-200/70 rounded-2xl p-5 sm:p-6 space-y-4">
            @foreach($funnelSteps as $f)
            <div class="space-y-1.5">
                <!-- Step Title & Count -->
                <div class="flex items-center justify-between text-xs sm:text-[13px] font-bold text-slate-900">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-5 h-5 rounded-full {{ $f['step'] == 5 ? 'bg-emerald-600' : 'bg-[#0f2942]' }} text-white text-[11px] font-extrabold flex items-center justify-center shrink-0">
                            {{ $f['step'] }}
                        </span>
                        <span class="truncate">{{ $f['title'] }}</span>
                    </div>
                    <span class="shrink-0 text-slate-900 ml-2 font-bold">{{ $f['count_text'] }}</span>
                </div>

                <!-- Progress Bar Track -->
                <div class="w-full bg-slate-200/80 h-2 rounded-full overflow-hidden">
                    <div class="{{ $f['bar_color'] }} h-full rounded-full transition-all duration-700"
                         style="width: {{ $f['percentage'] }}%;"></div>
                </div>

                <!-- Sub-description & Drop-off info -->
                <div class="flex items-center justify-between text-[11px] pt-0.5">
                    <span class="text-slate-500 font-normal">{{ $f['subtext'] }}</span>
                    <span class="{{ $f['status_class'] }} font-semibold shrink-0 ml-2">{{ $f['status_label'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- KOTAK 5: Distribusi Nilai Akhir PKL (Asesmen Terpadu DUDI & Sekolah) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 shadow-2xs">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-5">
            <div>
                <h3 class="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                    Distribusi Nilai Akhir PKL (Asesmen Terpadu DUDI &amp; Sekolah)
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Kombinasi 70% asesmen mentor industri (Hard Skill &amp; Work Ethic) dan 30% laporan sidang sekolah.
                </p>
            </div>

            <div class="flex items-center gap-6 sm:text-right shrink-0">
                <div>
                    <div class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        Rata-rata Nilai RPL
                    </div>
                    <div class="text-lg sm:text-xl font-extrabold text-slate-900 mt-0.5">
                        {{ $nilaiDistribusi['rata_rata'] }}
                    </div>
                </div>
                <div>
                    <div class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        Nilai Tertinggi
                    </div>
                    <div class="text-lg sm:text-xl font-extrabold text-sky-600 mt-0.5">
                        {{ $nilaiDistribusi['tertinggi'] }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart Container -->
        <div class="bg-slate-50/80 border border-slate-200/70 rounded-2xl p-6 sm:p-7">
            <!-- Bars Grid -->
            <div class="chart-cols-5 pb-6 border-b border-slate-200/80">
                @foreach($nilaiDistribusi['grades'] as $g)
                <div class="flex flex-col items-center">
                    <!-- Head Count -->
                    <span class="text-xs font-bold {{ $g['is_danger'] ? 'text-rose-600 font-extrabold' : 'text-slate-800' }} mb-2 text-center">
                        {{ $g['siswa'] }} Siswa
                    </span>

                    <!-- Bar Stage: ensures all bars align to the bottom baseline -->
                    <div class="w-full max-w-[76px] h-44 flex items-end justify-center">
                        <div class="w-full {{ $g['height'] }} {{ $g['color'] }} rounded-t-lg transition-all duration-500 shadow-2xs"></div>
                    </div>

                    <!-- Label Below Bar -->
                    <div class="text-center mt-3 pt-1 w-full">
                        <div class="text-xs font-extrabold {{ $g['is_danger'] ? 'text-rose-600' : 'text-slate-900' }}">
                            {{ $g['predikat'] }}
                        </div>
                        <div class="text-[11px] {{ $g['is_danger'] ? 'text-rose-500 font-semibold' : 'text-slate-500' }} mt-0.5">
                            {{ $g['persen'] }} · {{ $g['keterangan'] }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Bottom Note & KKM Standard -->
            <div class="pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2 text-slate-700 font-medium">
                    <svg class="w-4 h-4 text-sky-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span>{{ $nilaiDistribusi['highlight'] }}</span>
                </div>
                <div class="text-slate-500 font-bold shrink-0">
                    KKM Standar Kelulusan: {{ $nilaiDistribusi['kkm'] }}
                </div>
            </div>
        </div>
    </div>

    <!-- KOTAK 6: Rekapitulasi Per Rombongan Belajar (Rombel) Table -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-2xs overflow-hidden">
        <div class="p-6 pb-2">
            <h3 class="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight">
                Rekapitulasi Per Rombongan Belajar (Rombel)
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">
                Rincian capaian akademik, jam kerja, dan kelulusan per kelas bimbingan program RPL.
            </p>
        </div>

        <div class="overflow-x-auto mt-3">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-y border-slate-200 text-[11px] font-bold text-slate-600 uppercase tracking-wider">
                        <th class="py-4 px-6">Kelas / Rombel</th>
                        <th class="py-4 px-6">Wali Kelas</th>
                        <th class="py-4 px-6 text-center">Jml Siswa</th>
                        <th class="py-4 px-6 text-center">Kehadiran (%)</th>
                        <th class="py-4 px-6 text-center">Nilai Rata-rata</th>
                        <th class="py-4 px-6 text-center">Status Kelulusan</th>
                        <th class="py-4 px-6 text-center">Verifikasi Kaprog</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @foreach($rekapRombel as $r)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="py-4 px-6 font-bold text-slate-900">{{ $r['kelas'] }}</td>
                        <td class="py-4 px-6 text-slate-700 font-medium">{{ $r['wali_kelas'] }}</td>
                        <td class="py-4 px-6 text-center text-slate-800 font-semibold">{{ $r['jml_siswa'] }} Siswa</td>
                        <td class="py-4 px-6 text-center font-bold text-emerald-600">{{ $r['kehadiran'] }}</td>
                        <td class="py-4 px-6 text-center font-bold text-slate-900">{{ $r['nilai_rata'] }}</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-50/80 text-sky-800 border border-sky-100 rounded-full font-bold text-[11px]">
                                <span class="w-1.5 h-1.5 rounded-full {{ $r['dot_color'] }}"></span>
                                <span>{{ $r['status'] }}</span>
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <svg class="w-5 h-5 text-sky-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </td>
                    </tr>
                    @endforeach

                    <!-- TOTAL KONSOLIDASI JURUSAN RPL -->
                    <tr class="bg-slate-50/80 border-t-2 border-slate-200 text-xs font-bold">
                        <td class="py-4 px-6 text-slate-900 font-extrabold uppercase">TOTAL KONSOLIDASI JURUSAN {{ $jurusan?->kode ?? 'RPL' }}</td>
                        <td class="py-4 px-6 text-slate-400"></td>
                        <td class="py-4 px-6 text-center text-slate-900 font-extrabold">{{ $summary['total_siswa'] }} Siswa</td>
                        <td class="py-4 px-6 text-center text-emerald-600 font-extrabold">{{ $summary['kehadiran'] }}%</td>
                        <td class="py-4 px-6 text-center text-slate-900 font-extrabold">{{ $nilaiDistribusi['rata_rata'] }}</td>
                        <td class="py-4 px-6 text-center text-slate-900 font-extrabold">{{ $summary['siswa_lulus'] }} Lulus ({{ $summary['lulus_badge'] }})</td>
                        <td class="py-4 px-6 text-center text-sky-600 font-extrabold tracking-wide">FINAL VALID</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Embedded CSS for Clean Grid & Print Layout -->
<style>
/* Stat Cards Grid: 3 columns horizontal */
.stat-grid-3 {
    display: grid !important;
    grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
    gap: 1.25rem !important;
}
@media (max-width: 768px) {
    .stat-grid-3 {
        grid-template-columns: repeat(1, minmax(0, 1fr)) !important;
    }
}

/* 5 Column Bar Chart Grid */
.chart-cols-5 {
    display: grid !important;
    grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
    gap: 1rem !important;
}

/* High Quality Print Styles */
@media print {
    aside, header, .no-print {
        display: none !important;
    }
    .kaprog-main {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    body {
        background-color: #ffffff !important;
        font-size: 10pt !important;
    }
    main {
        padding: 0 !important;
    }
    * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
    .shadow-xs, .shadow-2xs {
        box-shadow: none !important;
    }
    @page {
        size: A4 portrait;
        margin: 1.2cm;
    }
}
</style>
@endsection
