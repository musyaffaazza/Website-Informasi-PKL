@extends('layouts.wali-kelas')

@section('title', 'Rekap Absensi — ' . ($selectedSiswa->nama ?? 'Raka Pratama') . ' | SIPRAK')

@section('content')
<div class="space-y-6" x-data="{
    modalSupervisi: false,
    selectedDate: '{{ $selectedDate }}',
    filterText: '{{ request('q') }}'
}">

    <!-- Alert Notification -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-emerald-800 text-xs font-semibold shadow-2xs">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">✕</button>
    </div>
    @endif

    <!-- Top Breadcrumb & Actions Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-1.5">
                <a href="{{ route('wali-kelas.murid.index') }}" class="text-slate-500 hover:text-slate-800 transition">Wali Kelas</a>
                <span class="text-slate-300">›</span>
                <span class="text-slate-500">Absensi Murid</span>
                <span class="text-slate-300">›</span>
                <span class="text-sky-600 font-bold">{{ $selectedSiswa->nama ?? 'Raka Pratama' }}</span>
            </nav>

            <!-- Title & Sub Badges -->
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                <span>Rekap Absensi — {{ $selectedSiswa->nama ?? 'Raka Pratama' }}</span>
            </h1>

            <div class="flex flex-wrap items-center gap-2.5 mt-2 text-xs">
                <!-- NIS Badge -->
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white border border-slate-200/90 text-slate-700 font-semibold shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                    </svg>
                    <span>NIS: <strong class="font-bold text-slate-900 font-mono">{{ $nisSiswa }}</strong></span>
                </span>

                <!-- Kelas Badge -->
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white border border-slate-200/90 text-slate-700 font-semibold shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                    </svg>
                    <span>Kelas: <strong class="font-bold text-slate-900">{{ $rombelAktifNama ?? 'XII RPL 2' }}</strong></span>
                </span>

                <!-- Mitra Badge -->
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white border border-slate-200/90 text-slate-700 font-semibold shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Mitra: <strong class="font-bold text-slate-900">{{ $industriNama }}</strong></span>
                </span>

                <!-- Ganti Siswa Dropdown -->
                <div class="relative" x-data="{ openSiswa: false }">
                    <button @click="openSiswa = !openSiswa"
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-sky-50 border border-sky-200 text-sky-700 text-xs font-bold hover:bg-sky-100 transition shadow-2xs">
                        <span>Pilih Siswa Lain</span>
                        <svg class="w-3 h-3 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openSiswa"
                         x-cloak
                         @click.away="openSiswa = false"
                         class="absolute left-0 mt-2 w-64 bg-white border border-slate-200 rounded-xl shadow-xl z-30 max-h-72 overflow-y-auto divide-y divide-slate-100">
                        <div class="p-2 text-[10px] font-bold uppercase text-slate-400 tracking-wider">Pilih Siswa Rombel</div>
                        @foreach($rombelStudents as $s)
                        <a href="{{ route('wali-kelas.absensi.index', ['siswa_id' => $s->id]) }}"
                           class="flex items-center justify-between px-3 py-2 text-xs hover:bg-slate-50 {{ $s->id == $selectedSiswa->id ? 'bg-sky-50 font-bold text-sky-800' : 'text-slate-700' }}">
                            <span>{{ $s->nama }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $s->nisn }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Month Navigation & PDF Button -->
        <div class="flex items-center gap-3 shrink-0">
            <!-- Month Navigator Card -->
            <div class="flex items-center bg-white border border-slate-200/90 rounded-xl p-1 shadow-2xs">
                <a href="{{ route('wali-kelas.absensi.index', array_merge(request()->query(), ['siswa_id' => $selectedSiswa->id, 'periode' => $prevPeriode])) }}"
                   title="Bulan Sebelumnya ({{ \Carbon\Carbon::parse($prevPeriode . '-01')->translatedFormat('F Y') }})"
                   class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="px-3 text-center min-w-[130px]">
                    <div class="text-xs font-black text-slate-900 leading-tight">{{ $periodeTitle }}</div>
                    <div class="text-[10px] font-semibold text-slate-400">{{ $periodeGasalGenap }}</div>
                </div>
                <a href="{{ route('wali-kelas.absensi.index', array_merge(request()->query(), ['siswa_id' => $selectedSiswa->id, 'periode' => $nextPeriode])) }}"
                   title="Bulan Berikutnya ({{ \Carbon\Carbon::parse($nextPeriode . '-01')->translatedFormat('F Y') }})"
                   class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Download PDF Button -->
            <a href="{{ route('wali-kelas.absensi.pdf', ['siswa_id' => $selectedSiswa->id, 'periode' => $periode]) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0f2942] hover:bg-[#143657] text-white text-xs font-bold shadow-xs transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Unduh Laporan PDF</span>
            </a>
        </div>
    </div>

    <!-- Attendance Stats Row (5 Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4">
        <!-- Big Card: Kehadiran Kumulatif (span 4) -->
        <div class="lg:col-span-4 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                        KEHADIRAN KUMULATIF
                    </span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                        Sangat Disiplin
                    </span>
                </div>

                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ $persenHadir }}%</span>
                    <span class="text-xs font-bold text-slate-400">/ 100% Target</span>
                </div>
                <div class="text-xs text-slate-500 font-medium mt-1">
                    {{ $kehadiranHariText }}
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-2.5 mt-3 overflow-hidden">
                    <div class="bg-sky-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ min($persenHadir, 100) }}%"></div>
                </div>

                <div class="flex items-center justify-between text-[11px] font-bold mt-2">
                    <span class="text-slate-400">Ambang Kelulusan: 85%</span>
                    <span class="{{ $persenHadir >= 85 ? 'text-emerald-600' : 'text-amber-600' }}">{{ $marginText }}</span>
                </div>
            </div>

            <!-- Footer Compliance Notice -->
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2 text-xs font-bold text-sky-800">
                <svg class="w-4 h-4 text-sky-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Memenuhi Syarat Kelulusan Akhir PKL</span>
            </div>
        </div>

        <!-- Card 2: Hadir Tepat (span 2) -->
        <div class="lg:col-span-2 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">HADIR TEPAT</span>
                    <div class="w-5 h-5 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900 tracking-tight mt-3">{{ $totalHadir }}</div>
                <div class="text-xs text-slate-500 font-medium mt-1">Hari Kerja</div>
            </div>
            <div class="mt-4">
                <span class="inline-block px-2.5 py-1 rounded-lg bg-sky-50 text-sky-700 text-[11px] font-bold">
                    Presensi Valid
                </span>
            </div>
        </div>

        <!-- Card 3: Izin / Sakit (span 2) -->
        <div class="lg:col-span-2 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">IZIN / SAKIT</span>
                    <div class="w-5 h-5 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900 tracking-tight mt-3">{{ $totalIzinSakit }}</div>
                <div class="text-xs text-slate-500 font-medium mt-1">Hari Tercatat</div>
            </div>
            <div class="mt-4">
                <span class="inline-block px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-bold">
                    1x Izin Dokter
                </span>
            </div>
        </div>

        <!-- Card 4: Alpa (span 2) -->
        <div class="lg:col-span-2 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">ALPA</span>
                    <div class="w-5 h-5 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900 tracking-tight mt-3">{{ $totalAlpa }}</div>
                <div class="text-xs text-slate-500 font-medium mt-1">Hari (Nihil)</div>
            </div>
            <div class="mt-4">
                <span class="inline-block px-2.5 py-1 rounded-lg bg-sky-50 text-sky-700 text-[11px] font-bold">
                    Tanpa Pelanggaran
                </span>
            </div>
        </div>

        <!-- Card 5: Rata-rata (span 2) -->
        <div class="lg:col-span-2 bg-white border border-slate-200/90 rounded-2xl p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">RATA-RATA</span>
                    <div class="w-5 h-5 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900 tracking-tight mt-3">{{ $rataJamText }}</div>
                <div class="text-xs text-slate-500 font-medium mt-1">Jam / Hari</div>
            </div>
            <div class="mt-4">
                <span class="inline-block px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700 text-[11px] font-bold">
                    {{ $rataMasukText }}
                </span>
            </div>
        </div>
    </div>

    <!-- Calendar Matrix Card (Matriks Kehadiran Bulanan) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-2xs overflow-hidden">
        <!-- Matrix Header -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-700 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Matriks Kehadiran Bulanan</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Jadwal Shift NOC: 08:00 - 17:00 WIB (Senin - Jumat)</p>
                </div>
            </div>

            <!-- Month Filter Tabs -->
            <div class="flex items-center bg-slate-100 p-1 rounded-xl text-xs font-semibold self-start sm:self-auto">
                @foreach($monthTabs as $tab)
                    @if($tab['is_active'])
                        <span class="px-3.5 py-1.5 rounded-lg bg-white text-slate-900 font-bold shadow-xs transition">
                            {{ $tab['label'] }}
                        </span>
                    @else
                        <a href="{{ route('wali-kelas.absensi.index', array_merge(request()->query(), ['siswa_id' => $selectedSiswa->id, 'periode' => $tab['periode']])) }}"
                           class="px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition cursor-pointer">
                            {{ $tab['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- 7-Column Calendar Grid -->
        <div class="p-5 sm:p-6 overflow-x-auto">
            <div class="min-w-[700px]">
                <!-- Day Names Header -->
                <div class="grid grid-cols-7 gap-3 mb-3 text-center">
                    <div class="text-[11px] font-black text-slate-400 uppercase tracking-wider py-1">SEN</div>
                    <div class="text-[11px] font-black text-slate-400 uppercase tracking-wider py-1">SEL</div>
                    <div class="text-[11px] font-black text-slate-400 uppercase tracking-wider py-1">RAB</div>
                    <div class="text-[11px] font-black text-slate-400 uppercase tracking-wider py-1">KAM</div>
                    <div class="text-[11px] font-black text-slate-400 uppercase tracking-wider py-1">JUM</div>
                    <div class="text-[11px] font-black text-slate-400 uppercase tracking-wider py-1">SAB</div>
                    <div class="text-[11px] font-black text-slate-400 uppercase tracking-wider py-1">MIN</div>
                </div>

                <!-- Days Matrix -->
                <div class="grid grid-cols-7 gap-3">
                    @foreach($calendarGrid as $cell)
                        @php
                            $isDaySelected = ($cell['date'] === $selectedDate);
                        @endphp

                        @if($cell['status'] === 'prev_month')
                            <!-- Muted / Previous Month (31 Agustus) -->
                            <div class="p-3 rounded-xl bg-slate-50/60 border border-slate-100 flex flex-col justify-between min-h-[92px] opacity-40">
                                <div class="text-xs font-bold text-slate-400">{{ $cell['day'] }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ $cell['sub_text'] }}</div>
                            </div>

                        @elseif($cell['status'] === 'weekend')
                            <!-- Weekend Cell -->
                            <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-100 flex flex-col justify-between min-h-[92px]">
                                <div class="text-xs font-bold text-slate-400">{{ $cell['day'] }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">Akhir Pekan</div>
                            </div>

                        @elseif($cell['status'] === 'terjadwal')
                            <!-- Terjadwal Future Days -->
                            <div class="p-3 rounded-xl bg-white border border-dashed border-slate-200 flex flex-col justify-between min-h-[92px]">
                                <div class="text-xs font-bold text-slate-400">{{ $cell['day'] }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">Terjadwal</div>
                            </div>

                        @elseif($cell['status'] === 'sakit')
                            <!-- Izin / Sakit -->
                            <a href="{{ route('wali-kelas.absensi.index', ['siswa_id' => $selectedSiswa->id, 'periode' => $periode, 'tanggal' => $cell['date']]) }}"
                               class="p-3 rounded-xl bg-indigo-50/50 border border-indigo-200/80 flex flex-col justify-between min-h-[92px] hover:border-indigo-400 transition cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-black text-indigo-900">{{ $cell['day'] }}</span>
                                    <div class="w-4 h-4 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-indigo-900 leading-tight">Izin Sakit</div>
                                    <div class="text-[9px] text-indigo-600 font-medium mt-0.5">Surat Dokter Valid</div>
                                </div>
                            </a>

                        @elseif($isDaySelected)
                            <!-- ACTIVE SELECTED DAY (11 September 2026 - Navy Pill) -->
                            <a href="{{ route('wali-kelas.absensi.index', ['siswa_id' => $selectedSiswa->id, 'periode' => $periode, 'tanggal' => $cell['date']]) }}"
                               class="p-3 rounded-xl bg-[#0f2942] text-white border-2 border-[#143657] shadow-md flex flex-col justify-between min-h-[92px] transition cursor-pointer ring-2 ring-[#0f2942]/30">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-black text-white">{{ $cell['day'] }}</span>
                                    <div class="w-4 h-4 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-white tracking-tight">{{ $cell['main_text'] }}</div>
                                    <div class="text-[9px] font-bold text-sky-300 flex items-center gap-1 mt-0.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                                        Aktif Terpilih
                                    </div>
                                </div>
                            </a>

                        @else
                            <!-- Normal Hadir Day -->
                            <a href="{{ route('wali-kelas.absensi.index', ['siswa_id' => $selectedSiswa->id, 'periode' => $periode, 'tanggal' => $cell['date']]) }}"
                               class="p-3 rounded-xl bg-sky-50/30 border border-sky-100 hover:border-sky-300 hover:bg-sky-50/70 flex flex-col justify-between min-h-[92px] transition cursor-pointer">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-black text-slate-800">{{ $cell['day'] }}</span>
                                    <div class="w-4 h-4 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-[11px] font-bold text-slate-800 tracking-tight leading-tight">{{ $cell['main_text'] }}</div>
                                    <div class="text-[9px] font-semibold text-sky-700 flex items-center gap-1 mt-0.5">
                                        <span class="w-1 h-1 rounded-full bg-sky-500"></span>
                                        GPS Valid
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Selected Day Verification Detail Banner -->
        <div class="mx-5 sm:mx-6 mb-5 p-4 rounded-2xl bg-linear-to-r from-sky-50/70 to-slate-50/80 border border-sky-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <!-- Date Pill Badge -->
                <div class="w-12 h-12 rounded-xl bg-white border border-sky-200/80 shadow-2xs flex flex-col items-center justify-center shrink-0">
                    <span class="text-[9px] font-extrabold uppercase text-sky-600">{{ $selectedCarbon->translatedFormat('D') }}</span>
                    <span class="text-base font-black text-slate-900 leading-none">{{ $selectedCarbon->format('d') }}</span>
                </div>

                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">
                            Verifikasi Harian: {{ $selectedCarbon->translatedFormat('l, d F Y') }}
                        </h3>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-800 border border-sky-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span>
                            Hadir Lengkap
                        </span>
                    </div>
                    <div class="text-xs text-slate-600 mt-0.5">
                        Check-in: <strong class="font-bold text-slate-900">{{ $checkInText }}</strong> •
                        Check-out: <strong class="font-bold text-slate-900">{{ $checkOutText }}</strong> •
                        Total: <strong class="font-bold text-slate-900">9 Jam 45 Menit</strong>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 self-end md:self-auto shrink-0">
                <div class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>NOC PT Telkom Akses Bogor</span>
                </div>

                <a href="{{ route('wali-kelas.jurnal.index', ['siswa_id' => $selectedSiswa->id, 'tanggal' => $selectedDate]) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-800 hover:bg-slate-50 shadow-2xs transition">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>Lihat Log Jurnal Siswa</span>
                </a>
            </div>
        </div>

        <!-- Legend and Regulation Note -->
        <div class="px-5 sm:px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-xs">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-1.5 text-slate-600 font-semibold">
                    <span class="w-3 h-3 rounded-md bg-[#0f2942]"></span>
                    <span>Hadir Tepat (GPS Valid)</span>
                </div>
                <div class="flex items-center gap-1.5 text-slate-600 font-semibold">
                    <span class="w-3 h-3 rounded-md bg-indigo-100 border border-indigo-200"></span>
                    <span>Izin / Sakit (Surat Sah)</span>
                </div>
                <div class="flex items-center gap-1.5 text-slate-600 font-semibold">
                    <span class="w-3 h-3 rounded-md bg-rose-100 border border-rose-200"></span>
                    <span>Alpa (Tanpa Keterangan)</span>
                </div>
                <div class="flex items-center gap-1.5 text-slate-600 font-semibold">
                    <span class="w-3 h-3 rounded-md bg-slate-200"></span>
                    <span>Hari Libur / Akhir Pekan</span>
                </div>
            </div>

            <div class="text-[11px] text-slate-400 italic">
                *Regulasi Kemendikbud: Kehadiran siswa ≥ 85% untuk validasi sertifikat PKL.
            </div>
        </div>
    </div>

    <!-- Detailed Attendance List Table (Daftar Detail Presensi Harian) -->
    <div class="bg-white border border-slate-200/90 rounded-2xl shadow-2xs overflow-hidden">
        <!-- Table Header & Filter Bar -->
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Daftar Detail Presensi Harian</h3>
                <p class="text-xs text-slate-500 mt-0.5">Data tervalidasi sensor biometrik & geolokasi mobile app SIPRAK</p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Search Box -->
                <form action="{{ route('wali-kelas.absensi.index', $selectedSiswa->id) }}" method="GET" class="relative">
                    <input type="hidden" name="periode" value="{{ $periode }}">
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Cari tanggal / catatan..."
                           class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0f2942]/20 w-52 sm:w-64 transition">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </form>

                <!-- Filter Button -->
                <button type="button"
                        onclick="alert('Filter lanjutan: Status Presensi, Rentang Tanggal, Validasi GPS')"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-2xs transition cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Filter</span>
                </button>
            </div>
        </div>

        <!-- Table View -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                        <th class="py-3.5 px-5">TANGGAL</th>
                        <th class="py-3.5 px-4">CHECK-IN</th>
                        <th class="py-3.5 px-4">CHECK-OUT</th>
                        <th class="py-3.5 px-4">DURASI KERJA</th>
                        <th class="py-3.5 px-5">STATUS PRESENSI</th>
                        <th class="py-3.5 px-5">GEOLOKASI / AREA</th>
                        <th class="py-3.5 px-5">KETERANGAN / BERKAS</th>
                        <th class="py-3.5 px-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($septemberList as $row)
                        @php
                            $cDate = \Carbon\Carbon::parse($row->tanggal);
                            $isSakit = ($row->status === 'sakit');
                            $weekNumber = 8 + (int)$cDate->format('W') - 35; // approx week 9-12
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <!-- Tanggal -->
                            <td class="py-4 px-5">
                                <div class="font-extrabold text-slate-900 text-xs">
                                    {{ $cDate->translatedFormat('l, d M Y') }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-medium">Minggu ke-{{ $weekNumber }}</div>
                            </td>

                            <!-- Check-in -->
                            <td class="py-4 px-4 font-bold text-slate-800">
                                {{ $row->jam_masuk ? substr($row->jam_masuk, 0, 5) . ' WIB' : '—' }}
                            </td>

                            <!-- Check-out -->
                            <td class="py-4 px-4 font-bold text-slate-800">
                                {{ $row->jam_keluar ? substr($row->jam_keluar, 0, 5) . ' WIB' : '—' }}
                            </td>

                            <!-- Durasi Kerja -->
                            <td class="py-4 px-4 text-slate-600 font-semibold">
                                @if($row->jam_masuk && $row->jam_keluar)
                                    @php
                                        $tIn = \Carbon\Carbon::parse($row->jam_masuk);
                                        $tOut = \Carbon\Carbon::parse($row->jam_keluar);
                                        $diffMinutes = $tIn->diffInMinutes($tOut);
                                        $h = floor($diffMinutes / 60);
                                        $m = $diffMinutes % 60;
                                    @endphp
                                    {{ $h }}j {{ sprintf('%02d', $m) }}m
                                @else
                                    —
                                @endif
                            </td>

                            <!-- Status Presensi -->
                            <td class="py-4 px-5">
                                @if($isSakit)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                        Izin (Sakit)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                        Hadir Tepat Waktu
                                    </span>
                                @endif
                            </td>

                            <!-- Geolokasi / Area -->
                            <td class="py-4 px-5">
                                @if($isSakit)
                                    <div class="text-xs text-slate-700 font-medium">Rumah Tinggal (Surat Terunggah)</div>
                                @else
                                    <div class="text-xs text-slate-800 font-semibold flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-sky-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>NOC Bogor</span>
                                        <span class="text-[10px] text-slate-400 font-mono">(-6.5950, 106.8166)</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Keterangan / Berkas -->
                            <td class="py-4 px-5">
                                @if($row->bukti_url)
                                    <a href="#" onclick="alert('Membuka lampiran surat: {{ $row->bukti_url }}'); return false;"
                                       class="inline-flex items-center gap-1 text-xs font-bold text-sky-700 hover:text-sky-900 underline">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        <span>{{ $row->bukti_url }}</span>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-700">{{ $row->keterangan ?: 'Logbook selesai terverifikasi' }}</span>
                                @endif
                            </td>

                            <!-- Aksi Menu -->
                            <td class="py-4 px-4 text-center">
                                <button type="button"
                                        onclick="alert('Detail presensi tanggal {{ $cDate->format('d M Y') }}')"
                                        class="p-1 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition cursor-pointer">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400 text-xs font-semibold">
                                Tidak ada data presensi yang sesuai kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500 font-semibold">
            <div>
                Menampilkan {{ min(count($septemberList), 4) }} dari {{ count($septemberList) }} riwayat entri {{ $periodeTitle }}
            </div>
            <div class="flex items-center gap-1 self-end sm:self-auto">
                <button type="button" class="w-7 h-7 rounded-lg bg-[#0f2942] text-white font-bold flex items-center justify-center text-xs">1</button>
                <button type="button" class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs">2</button>
                <button type="button" class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs">3</button>
                <span class="px-1 text-slate-400">...</span>
                <button type="button" class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-xs">5</button>
            </div>
        </div>
    </div>

    <!-- Catatan Supervisi Guru Pembimbing / Wali Kelas (Bottom Box) -->
    <div class="p-5 sm:p-6 rounded-2xl bg-sky-50/50 border border-sky-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="w-11 h-11 rounded-full bg-[#0f2942] text-white font-black text-sm flex items-center justify-center shrink-0 shadow-xs">
                BW
            </div>
            <div class="space-y-1">
                <div class="text-xs sm:text-sm font-extrabold text-slate-900">
                    Catatan Wali Kelas & Guru Pembimbing ({{ $pembimbingNama }})
                </div>
                <div class="text-xs text-slate-700 leading-relaxed italic">
                    “{{ $catatanSupervisi }}”
                </div>
            </div>
        </div>

        <button type="button"
                @click="modalSupervisi = true"
                class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-800 hover:bg-slate-50 shadow-2xs transition shrink-0 cursor-pointer self-start sm:self-auto">
            Tambah Catatan Supervisi
        </button>
    </div>

    <!-- Modal Catatan Supervisi -->
    <div x-show="modalSupervisi"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="modalSupervisi = false"
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-sky-600"></span>
                    <h3 class="text-sm font-extrabold text-slate-900">Catatan Supervisi Kehadiran Siswa</h3>
                </div>
                <button type="button" @click="modalSupervisi = false" class="text-slate-400 hover:text-slate-700">✕</button>
            </div>

            <form action="{{ route('wali-kelas.absensi.supervisi', $selectedSiswa->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Catatan Evaluasi / Rekomendasi Supervisi:
                    </label>
                    <textarea name="catatan"
                              rows="4"
                              required
                              placeholder="Tuliskan catatan supervisi kehadiran siswa..."
                              class="w-full px-3.5 py-2.5 text-xs text-slate-800 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0f2942]/20">{{ $catatanSupervisi }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                    <button type="button"
                            @click="modalSupervisi = false"
                            class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 rounded-xl bg-[#0f2942] hover:bg-[#143657] text-white text-xs font-bold shadow-xs transition">
                        Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

