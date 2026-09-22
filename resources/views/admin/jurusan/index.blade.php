@extends('layouts.admin')

@section('title', 'SIPRAK SMKN 1 GUNUNGPUTRI - Master Data Jurusan')

@section('content')
<div x-data="jurusanApp()" class="space-y-6">
    <div class="text-[11px] font-semibold text-slate-400 flex items-center gap-1.5">
        <span>Data Master</span>
        <span class="text-slate-300">&gt;</span>
        <span class="text-slate-600">Master Data Jurusan</span>
    </div>

    <!-- Page Header & Action Buttons -->
    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl font-extrabold text-[#0f2942] tracking-tight">
                    Master Data Jurusan / Program Keahlian
                </h1>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-blue-50 text-blue-600 border border-blue-200 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    SPEKTRUM KURIKULUM MERDEKA
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-2 max-w-4xl leading-relaxed">
                Direktori konsentrasi keahlian vokasi, kepala program keahlian (Kaprog), kuota mitra DU/DI, dan capaian pembelajaran PKL di lingkungan SMKN 1 Gunungputri Bogor.
            </p>
        </div>

        <!-- Top Right Actions -->
        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            <button type="button" 
                    @click="openMatrixModal()"
                    class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Matrika Kemitraan DU/DI</span>
            </button>

            <a href="{{ route('admin.jurusan.export') }}" 
               class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Ekspor Akreditasi</span>
            </a>

            <button type="button" 
                    @click="openCreateModal()"
                    class="flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition active:scale-98">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Jurusan</span>
            </button>
        </div>
    </div>
    <!-- 4 KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Program Keahlian -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        TOTAL PROGRAM KEAHLIAN
                    </div>
                    <div class="text-xl font-extrabold text-slate-900 mt-1">
                        {{ $totalPrograms }} Konsentrasi Keahlian
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>SMK PK - Pusat Keunggulan</span>
            </div>
        </div>

        <!-- Card 2: Siswa Magang Aktif -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        SISWA MAGANG AKTIF
                    </div>
                    <div class="text-xl font-extrabold text-slate-900 mt-1">
                        {{ $totalSiswaMagang }} Siswa
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-xs text-slate-400">
                Tingkat XII ({{ $semesterAktif }} {{ $tahunAjaranAktif }})
            </div>
        </div>

        <!-- Card 3: Total Kemitraan DU/DI -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        TOTAL KEMITRAAN DU/DI
                    </div>
                    <div class="text-xl font-extrabold text-slate-900 mt-1">
                        {{ $totalKemitraan }} Perusahaan
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-xs font-medium text-blue-600">
                Terafiliasi Resmi Hubin SMKN 1
            </div>
        </div>

        <!-- Card 4: Keterserapan Industri -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        KETERSERAPAN INDUSTRI
                    </div>
                    <div class="text-xl font-extrabold text-slate-900 mt-1">
                        {{ $persentaseKeterserapan }}%
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-xs font-semibold text-emerald-600">
                Lulusan Terserap / Mitra Resmi
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-3 shadow-2xs flex flex-wrap items-center justify-between gap-4">
        <div class="relative flex-1 w-full sm:min-w-[280px]">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" 
                   x-model="searchQuery"
                   placeholder="Cari jurusan, nama Kaprog, atau keahlian..." 
                   class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 font-semibold">Bidang:</span>
                <select x-model="selectedBidang" 
                        class="bg-white border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-medium">
                    <option value="all">Semua Bidang Keahlian</option>
                    @foreach($bidangList as $b)
                        <option value="{{ $b }}">{{ $b }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 font-semibold">Status Akreditasi:</span>
                <select x-model="selectedAkreditasi" 
                        class="bg-white border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-medium">
                    <option value="all">Semua Status (A Unggul)</option>
                    @foreach($akreditasiList as $a)
                        <option value="{{ $a }}">{{ $a }}</option>
                    @endforeach
                </select>
            </div>

            <button type="button" 
                    @click="resetFilters()"
                    class="flex items-center gap-1.5 px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
                <span>Reset</span>
            </button>
        </div>
    </div>
    <!-- Jurusan Cards Grid (3 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($jurusans as $jurusan)
        @php
            $kode = strtoupper($jurusan->kode);
            $badgeBg = match($jurusan->badge_color) {
                'green' => 'bg-emerald-500',
                'red' => 'bg-red-500',
                'gray' => 'bg-slate-500',
                'blue' => 'bg-blue-500',
                'white' => 'bg-white border border-slate-300',
                default => 'bg-blue-500'
            };

            $barColor = $badgeBg;

            $totalRombel = $jurusan->rombels->count();
            $kapasitasSiswa = match($kode) {
                'RPL' => 108,
                'TOI' => 72,
                'TP'  => 72,
                'KA'  => 70,
                'TPL' => 36,
                default => $totalRombel * 36
            };

            $kuotaTotal = $jurusan->kuota_industri ?: 100;
            $kuotaTerisi = $jurusan->kuota_terisi ?: 0;
            $sisaKuota = max(0, $kuotaTotal - $kuotaTerisi);
            $persen = $kuotaTotal > 0 ? min(100, round(($kuotaTerisi / $kuotaTotal) * 100)) : 0;

            $statusSerap = match(true) {
                $persen >= 95 => 'Terserap Optimal',
                $persen >= 90 => 'Terserap Baik',
                default => 'Terserap Terpenuhi'
            };

            $mitraList = is_array($jurusan->mitra_utama) ? $jurusan->mitra_utama : [];
            if (empty($mitraList)) {
                $mitraList = $jurusan->industris->take(3)->pluck('nama')->toArray();
            }
        @endphp

        <!-- Single Card -->
        <div x-show="matchesFilter('{{ addslashes(strtolower($jurusan->nama)) }}', '{{ addslashes(strtolower($jurusan->kode)) }}', '{{ addslashes(strtolower($jurusan->kaprog ? $jurusan->kaprog->nama : '')) }}', '{{ addslashes($jurusan->bidang) }}', '{{ addslashes($jurusan->akreditasi) }}')" 
             class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs hover:shadow-md transition duration-200 flex flex-col justify-between">
            
            <div>
                <!-- Card Header -->
                <div class="flex items-start justify-between gap-3 mb-4">
                    <div class="flex items-start gap-3">
                        <div class="w-11 h-11 rounded-xl {{ $badgeBg }} {{ $jurusan->badge_color === 'white' ? 'text-slate-900' : 'text-white' }} font-black text-sm tracking-wider flex items-center justify-center shrink-0 shadow-2xs">
                            {{ $jurusan->kode }}
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-900 text-sm leading-snug">
                                {{ $jurusan->nama }}
                            </h3>
                            <div class="text-[11px] font-medium text-slate-400 mt-0.5">
                                {{ $jurusan->bidang ?? 'Bidang Kejuruan' }}
                            </div>
                        </div>
                    </div>

                    <div class="shrink-0 bg-[#e8f8f0] text-[#059669] border border-[#bbf0d8] rounded-xl px-2.5 py-1 text-center font-bold">
                        <div class="text-xs font-black leading-none">A</div>
                        <div class="text-[8px] font-extrabold tracking-wider leading-none mt-0.5">UNGGUL</div>
                    </div>
                </div>

                <!-- Info Stack with Icons -->
                <div class="space-y-3.5 pt-1">
                    <!-- Item 1: Kaprog -->
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                KEPALA PROGRAM (KAPROG)
                            </div>
                            <div class="text-xs font-bold text-slate-900 mt-0.5">
                                {{ $jurusan->kaprog ? $jurusan->kaprog->nama : 'Belum Ditugaskan' }}
                            </div>
                        </div>
                    </div>

                    <!-- Item 2: Rombel & Kapasitas -->
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div>
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                ROMBEL &amp; KAPASITAS
                            </div>
                            <div class="text-xs font-bold text-slate-900 mt-0.5">
                                {{ $totalRombel }} Rombel ({{ $kapasitasSiswa }} Siswa Tingkat XII)
                            </div>
                        </div>
                    </div>

                    <!-- Item 3: Mitra Utama DU/DI -->
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <div class="flex-1">
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                MITRA UTAMA DU/DI
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($mitraList as $mitra)
                                <span class="inline-block px-2.5 py-1 bg-slate-100/90 text-slate-700 text-[11px] font-medium rounded-lg">
                                    {{ $mitra }}
                                </span>
                                @empty
                                <span class="text-[11px] text-slate-400 italic">Belum ada mitra utama</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Item 4: Quota & Progress Bar -->
                    <div class="pt-1">
                        <div class="flex items-center justify-between text-xs mb-1.5">
                            <span class="text-slate-500 font-medium">Ketersediaan Kuota Industri:</span>
                            <span class="font-extrabold text-slate-900">{{ $kuotaTerisi }} / {{ $kuotaTotal }} Kursi</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500" style="width: {{ $persen }}%;"></div>
                        </div>
                        <div class="flex items-center justify-between text-[11px] mt-1.5">
                            <span class="font-semibold text-emerald-600">{{ $statusSerap }}</span>
                            <span class="text-slate-400">Sisa: {{ $sisaKuota }} Kursi Magang</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Actions -->
            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center gap-2">
                <button type="button" 
                        @click="openKurikulumModal({{ json_encode($jurusan) }})"
                        class="flex-1 py-2 px-2 bg-white hover:bg-slate-50 text-slate-700 text-center text-xs font-semibold border border-slate-200 rounded-xl shadow-2xs transition active:scale-98">
                    Kelola Kurikulum PKL
                </button>

                <button type="button" 
                        @click="openDudiModal({{ json_encode($jurusan) }}, {{ json_encode($jurusan->industris->pluck('id')) }})"
                        class="py-2 px-3 bg-white hover:bg-blue-50 text-blue-600 text-center text-xs font-semibold border border-slate-200 rounded-xl shadow-2xs transition active:scale-98">
                    Daftar DU/DI
                </button>

                <button type="button" 
                        @click="openDetailModal({{ json_encode($jurusan->load(['kaprog', 'rombels', 'industris'])) }})"
                        class="py-2 px-4 bg-[#0f2942] hover:bg-[#1a385c] text-white text-center text-xs font-bold rounded-xl shadow-2xs transition active:scale-98">
                    Detail
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Bottom Information & Pagination Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Menampilkan {{ count($jurusans) }} dari {{ $totalPrograms }} konsentrasi keahlian vokasi SMKN 1 Gunungputri</span>
        </div>

        <div class="flex items-center gap-2">
            <button class="px-3.5 py-1.5 bg-white border border-slate-200 text-slate-400 text-xs font-medium rounded-xl hover:bg-slate-50 transition cursor-default">
                Sebelumnya
            </button>
            <span class="w-7 h-7 flex items-center justify-center bg-[#0f2942] text-white text-xs font-bold rounded-lg shadow-xs">
                1
            </span>
            <button class="px-3.5 py-1.5 bg-white border border-slate-200 text-slate-400 text-xs font-medium rounded-xl hover:bg-slate-50 transition cursor-default">
                Selanjutnya
            </button>
        </div>
    </div>
    <!-- ==================== MODALS ==================== -->

    <!-- Modal 1: Tambah Jurusan -->
    <div x-show="createModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <!-- Backdrop: Dark overlay without blur to avoid any browser blur leakage -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="createModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form action="{{ route('admin.jurusan.store') }}" method="POST">
                    @csrf
                    <div class="p-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Tambah Program Keahlian Baru</h3>
                                    <p class="text-xs text-slate-400">Masukkan identitas konsentrasi keahlian dan Kaprog</p>
                                </div>
                            </div>
                            <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kode Jurusan *</label>
                                <input type="text" name="kode" required placeholder="Contoh: SIJA" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Singkatan</label>
                                <input type="text" name="singkatan" placeholder="Contoh: SIJA" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Konsentrasi Keahlian *</label>
                                <input type="text" name="nama" required placeholder="Contoh: Sistem Informatika Jaringan dan Aplikasi" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Bidang Keahlian *</label>
                                <input type="text" name="bidang" required placeholder="Contoh: Teknologi Informasi & Komunikasi" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Akreditasi *</label>
                                <select name="akreditasi" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="A UNGGUL" selected>A UNGGUL</option>
                                    <option value="A (Amat Baik)">A (Amat Baik)</option>
                                    <option value="B (Baik)">B (Baik)</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kepala Program Keahlian (Kaprog)</label>
                                <select name="kaprog_guru_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="">-- Pilih Guru Sebagai Kaprog --</option>
                                    @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }} (NIP: {{ $guru->nip }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Target Kuota Industri *</label>
                                <input type="number" name="kuota_industri" required value="100" min="1" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kuota Terisi Saat Ini</label>
                                <input type="number" name="kuota_terisi" value="0" min="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Warna Badge</label>
                                <div class="grid grid-cols-5 gap-2">
                                    @foreach(['green'=>['bg-emerald-500','Hijau'],'red'=>['bg-red-500','Merah'],'gray'=>['bg-slate-500','Abu-abu'],'blue'=>['bg-blue-500','Biru'],'white'=>['bg-white border border-slate-300','Putih']] as $val=>$meta)
                                    <label class="cursor-pointer" title="{{ $meta[1] }}">
                                        <input type="radio" name="badge_color" value="{{ $val }}" class="sr-only peer" {{ $val === 'blue' ? 'checked' : '' }}>
                                        <span class="flex h-10 w-full items-center justify-center rounded-xl border border-slate-200 bg-white transition-all peer-checked:border-slate-900 peer-checked:ring-2 peer-checked:ring-slate-900/15">
                                            <span class="h-5 w-5 rounded-full {{ $meta[0] }} shadow-sm"></span>
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Jurusan *</label>
                                <select name="status" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Mitra Utama DU/DI (Pisahkan dengan koma)</label>
                                <input type="text" name="mitra_utama" placeholder="Contoh: PT Telkom Akses, Tokopedia, PT Astra Honda Motor" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Capaian Kurikulum PKL</label>
                                <textarea name="capaian_kurikulum" rows="2" placeholder="Kompetensi inti yang wajib dicapai siswa selama PKL..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="createModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Simpan Jurusan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 2: Detail Jurusan -->
    <div x-show="detailModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <!-- Backdrop: Dark overlay without blur to guarantee crystal clear modal rendering -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="detailModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <div class="p-6">
                    <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#0f2942] text-white font-black text-base flex items-center justify-center shrink-0 shadow-xs"
                                 x-text="activeJurusan?.kode">
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-lg" x-text="activeJurusan?.nama"></h3>
                                <div class="text-xs text-slate-500 mt-0.5" x-text="activeJurusan?.bidang"></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200"
                                  x-text="activeJurusan?.akreditasi"></span>
                            <button type="button" @click="detailModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold ml-2">&times;</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                KEPALA PROGRAM KEAHLIAN
                            </div>
                            <div class="text-xs font-bold text-slate-900" x-text="activeJurusan?.kaprog ? activeJurusan.kaprog.nama : 'Belum Ditentukan'"></div>
                            <div class="text-[11px] text-slate-500 mt-1" x-text="activeJurusan?.kaprog ? 'NIP: ' + activeJurusan.kaprog.nip : ''"></div>
                            <div class="text-[11px] text-slate-500" x-text="activeJurusan?.kaprog?.email ? 'Email: ' + activeJurusan.kaprog.email : ''"></div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                KUOTA &amp; KETERSEDIAAN
                            </div>
                            <div class="text-xs font-bold text-slate-900">
                                <span x-text="activeJurusan?.kuota_terisi || 0"></span> / <span x-text="activeJurusan?.kuota_industri || 0"></span> Kursi Magang
                            </div>
                            <div class="text-[11px] text-emerald-600 font-semibold mt-1">
                                Sisa Kursi Tersedia: <span x-text="Math.max(0, (activeJurusan?.kuota_industri || 0) - (activeJurusan?.kuota_terisi || 0))"></span>
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Status: <span class="capitalize font-bold" :class="activeJurusan?.status === 'aktif' ? 'text-emerald-600' : 'text-rose-600'" x-text="activeJurusan?.status"></span>
                            </div>
                        </div>

                        <div class="sm:col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                                DAFTAR ROMBONGAN BELAJAR (ROMBEL) TINGKAT XII
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="rombel in (activeJurusan?.rombels || [])" :key="rombel.id">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 text-slate-800 text-xs font-medium rounded-lg shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span x-text="rombel.nama_kode"></span>
                                        <span class="text-[10px] text-slate-400" x-text="'(' + rombel.tahun_ajaran + ')'"></span>
                                    </span>
                                </template>
                                <span x-show="!activeJurusan?.rombels?.length" class="text-xs text-slate-400 italic">Belum ada rombel terdaftar.</span>
                            </div>
                        </div>

                        <div class="sm:col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                CAPAIAN PEMBELAJARAN KURIKULUM MERDEKA (PKL)
                            </div>
                            <p class="text-xs text-slate-700 leading-relaxed" x-text="activeJurusan?.capaian_kurikulum || 'Belum diisi capaian kurikulum PKL.'"></p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100">
                    <!-- Hapus Jurusan -->
                    <form :action="'/admin/jurusan/' + activeJurusan?.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurusan ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-1.5 px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-xs font-bold rounded-xl transition shadow-2xs">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Hapus Jurusan</span>
                        </button>
                    </form>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="openEditModal(activeJurusan)" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Edit Jurusan
                        </button>
                        <button type="button" @click="detailModalOpen = false" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal 3: Edit Jurusan -->
    <div x-show="editModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="editModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form :action="'/admin/jurusan/' + editForm.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Edit Program Keahlian</h3>
                                    <p class="text-xs text-slate-400">Perbarui informasi jurusan dan kaprog</p>
                                </div>
                            </div>
                            <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kode Jurusan *</label>
                                <input type="text" name="kode" x-model="editForm.kode" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Singkatan</label>
                                <input type="text" name="singkatan" x-model="editForm.singkatan" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Konsentrasi Keahlian *</label>
                                <input type="text" name="nama" x-model="editForm.nama" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Bidang Keahlian *</label>
                                <input type="text" name="bidang" x-model="editForm.bidang" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Akreditasi *</label>
                                <select name="akreditasi" x-model="editForm.akreditasi" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="A UNGGUL">A UNGGUL</option>
                                    <option value="A (Amat Baik)">A (Amat Baik)</option>
                                    <option value="B (Baik)">B (Baik)</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kepala Program (Kaprog)</label>
                                <select name="kaprog_guru_id" x-model="editForm.kaprog_guru_id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="">-- Tidak Ada Kaprog --</option>
                                    @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->nama }} (NIP: {{ $guru->nip }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Target Kuota Industri *</label>
                                <input type="number" name="kuota_industri" x-model="editForm.kuota_industri" required min="1" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kuota Terisi *</label>
                                <input type="number" name="kuota_terisi" x-model="editForm.kuota_terisi" required min="0" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Jurusan *</label>
                                <select name="status" x-model="editForm.status" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-2">Warna Badge</label>
                                <div class="grid grid-cols-5 gap-2">
                                    @foreach(['green'=>['bg-emerald-500','Hijau'],'red'=>['bg-red-500','Merah'],'gray'=>['bg-slate-500','Abu-abu'],'blue'=>['bg-blue-500','Biru'],'white'=>['bg-white border border-slate-300','Putih']] as $val=>$meta)
                                    <label class="cursor-pointer" title="{{ $meta[1] }}">
                                        <input type="radio" name="badge_color" value="{{ $val }}" x-model="editForm.badge_color" class="sr-only peer">
                                        <span class="flex h-10 w-full items-center justify-center rounded-xl border border-slate-200 bg-white transition-all peer-checked:border-slate-900 peer-checked:ring-2 peer-checked:ring-slate-900/15">
                                            <span class="h-5 w-5 rounded-full {{ $meta[0] }} shadow-sm"></span>
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Mitra Utama DU/DI (Pisahkan koma)</label>
                                <input type="text" name="mitra_utama" x-model="editForm.mitra_utama" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Capaian Kurikulum PKL</label>
                                <textarea name="capaian_kurikulum" x-model="editForm.capaian_kurikulum" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 4: Kelola Kurikulum PKL -->
    <div x-show="kurikulumModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="kurikulumModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-lg transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form :action="'/admin/jurusan/' + activeKurikulumJurusan?.id + '/kurikulum'" method="POST">
                    @csrf
                    <div class="p-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Kelola Kurikulum PKL</h3>
                                    <p class="text-xs text-slate-400" x-text="activeKurikulumJurusan?.nama"></p>
                                </div>
                            </div>
                            <button type="button" @click="kurikulumModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <div class="mt-4 space-y-4">
                            <div class="p-3 bg-blue-50/70 border border-blue-100 rounded-xl text-xs text-blue-700 leading-relaxed">
                                Standar capaian pembelajaran Praktik Kerja Lapangan (PKL) mengacu pada Kepmendikbudristek Spektrum Kurikulum Merdeka SMK/MAK.
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">
                                    Capaian Pembelajaran (CP) &amp; Kompetensi Wajib PKL
                                </label>
                                <textarea name="capaian_kurikulum" 
                                          rows="5" 
                                          x-model="kurikulumText"
                                          required
                                          class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 leading-relaxed"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="kurikulumModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Simpan Kurikulum
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 5: Daftar DU/DI -->
    <div x-show="dudiModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="dudiModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form :action="'/admin/jurusan/' + activeDudiJurusan?.id + '/industri'" method="POST">
                    @csrf
                    <div class="p-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Daftar Kemitraan DU/DI</h3>
                                    <p class="text-xs text-slate-400" x-text="activeDudiJurusan?.nama"></p>
                                </div>
                            </div>
                            <button type="button" @click="dudiModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <div class="mt-4">
                            <p class="text-xs text-slate-500 mb-3">
                                Pilih perusahaan dan institusi industri yang menerima siswa konsentrasi keahlian ini untuk program PKL:
                            </p>

                            <div class="max-h-64 overflow-y-auto space-y-2 pr-2 border border-slate-100 rounded-xl p-3 bg-slate-50/50">
                                @foreach($allIndustris as $ind)
                                <label class="flex items-center justify-between p-2.5 rounded-lg bg-white border border-slate-200 hover:border-blue-300 transition cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox" 
                                               name="industri_ids[]" 
                                               value="{{ $ind->id }}"
                                               :checked="selectedIndustriIds.includes({{ $ind->id }})"
                                               class="rounded text-blue-600 focus:ring-blue-500 h-4 w-4">
                                        <div>
                                            <div class="text-xs font-bold text-slate-800">{{ $ind->nama }}</div>
                                            <div class="text-[10px] text-slate-400">{{ Str::limit($ind->alamat, 45) }}</div>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">
                                        Kuota: {{ $ind->kuota }} Siswa
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="dudiModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Simpan Mitra DU/DI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal 6: Matriks Kemitraan DU/DI -->
    <div x-show="matrixModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="matrixModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <div class="p-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-base">Matriks Afiliasi Kemitraan DU/DI</h3>
                                <p class="text-xs text-slate-400">Pemetaan konsentrasi keahlian dengan perusahaan mitra industri resmi</p>
                            </div>
                        </div>
                        <button type="button" @click="matrixModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                    </div>

                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full text-left text-xs border border-slate-200 rounded-xl overflow-hidden">
                            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase text-[10px]">
                                <tr>
                                    <th class="p-3 border-r border-slate-200">Perusahaan Mitra DU/DI</th>
                                    @foreach($jurusans as $j)
                                    <th class="p-3 text-center border-r border-slate-200">{{ $j->kode }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($allIndustris as $ind)
                                <tr class="hover:bg-slate-50/80">
                                    <td class="p-3 font-semibold text-slate-800 border-r border-slate-200">
                                        {{ $ind->nama }}
                                    </td>
                                    @foreach($jurusans as $j)
                                    @php
                                        $isLinked = $ind->jurusans->contains('id', $j->id) || (is_array($j->mitra_utama) && in_array($ind->nama, $j->mitra_utama));
                                    @endphp
                                    <td class="p-3 text-center border-r border-slate-200">
                                        @if($isLinked)
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs">
                                            ✓
                                        </span>
                                        @else
                                        <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 flex items-center justify-end border-t border-slate-100">
                    <button type="button" @click="matrixModalOpen = false" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                        Tutup Matriks
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function jurusanApp() {
    return {
        searchQuery: '',
        selectedBidang: 'all',
        selectedAkreditasi: 'all',

        createModalOpen: false,
        detailModalOpen: false,
        editModalOpen: false,
        kurikulumModalOpen: false,
        dudiModalOpen: false,
        matrixModalOpen: false,

        activeJurusan: null,
        activeKurikulumJurusan: null,
        kurikulumText: '',
        activeDudiJurusan: null,
        selectedIndustriIds: [],

        editForm: {
            id: null,
            kode: '',
            nama: '',
            singkatan: '',
            bidang: '',
            akreditasi: 'A UNGGUL',
            kaprog_guru_id: '',
            kuota_industri: 100,
            kuota_terisi: 0,
            status: 'aktif',
            badge_color: 'blue',
            mitra_utama: '',
            capaian_kurikulum: '',
        },

        resetFilters() {
            this.searchQuery = '';
            this.selectedBidang = 'all';
            this.selectedAkreditasi = 'all';
        },

        matchesFilter(nama, kode, kaprog, bidang, akreditasi) {
            if (this.searchQuery.trim() !== '') {
                const q = this.searchQuery.toLowerCase().trim();
                const matched = nama.includes(q) || kode.includes(q) || kaprog.includes(q) || bidang.toLowerCase().includes(q);
                if (!matched) return false;
            }

            if (this.selectedBidang !== 'all') {
                if (bidang !== this.selectedBidang) return false;
            }

            if (this.selectedAkreditasi !== 'all') {
                if (akreditasi !== this.selectedAkreditasi) return false;
            }

            return true;
        },

        openCreateModal() {
            this.createModalOpen = true;
        },

        openDetailModal(jurusan) {
            this.activeJurusan = jurusan;
            this.detailModalOpen = true;
        },

        openEditModal(jurusan) {
            this.detailModalOpen = false;
            this.editForm = {
                id: jurusan.id,
                kode: jurusan.kode,
                nama: jurusan.nama,
                singkatan: jurusan.singkatan || jurusan.kode,
                bidang: jurusan.bidang || '',
                akreditasi: jurusan.akreditasi || 'A UNGGUL',
                kaprog_guru_id: jurusan.kaprog_guru_id || '',
                kuota_industri: jurusan.kuota_industri || 0,
                kuota_terisi: jurusan.kuota_terisi || 0,
                status: jurusan.status || 'aktif',
                badge_color: jurusan.badge_color || 'blue',
                mitra_utama: Array.isArray(jurusan.mitra_utama) ? jurusan.mitra_utama.join(', ') : (jurusan.mitra_utama || ''),
                capaian_kurikulum: jurusan.capaian_kurikulum || '',
            };
            this.editModalOpen = true;
        },

        openKurikulumModal(jurusan) {
            this.activeKurikulumJurusan = jurusan;
            this.kurikulumText = jurusan.capaian_kurikulum || '';
            this.kurikulumModalOpen = true;
        },

        openDudiModal(jurusan, linkedIds) {
            this.activeDudiJurusan = jurusan;
            this.selectedIndustriIds = linkedIds || [];
            this.dudiModalOpen = true;
        },

        openMatrixModal() {
            this.matrixModalOpen = true;
        }
    };
}
</script>
@endpush
