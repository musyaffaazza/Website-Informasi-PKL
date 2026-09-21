@extends('layouts.admin')

@section('title', 'SIPRAK SMKN 1 GUNUNGPUTRI - Master Data Siswa')
@section('header_search_placeholder', 'Cari NISN, nama siswa, DUDI...')

@section('content')
<div x-data="siswaApp()" class="space-y-6">

    <!-- Breadcrumb & Header Section -->
    <div>
        <div class="text-[11px] font-semibold text-slate-400 mb-1.5 flex items-center gap-1.5">
            <span>Data Master</span>
            <span class="text-slate-300">&gt;</span>
            <span class="text-slate-600">Master Data Siswa (TA {{ $tahunAjaranAktif }})</span>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-extrabold text-[#0f2942] tracking-tight">
                        Master Data Siswa
                    </h1>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide bg-sky-50 text-sky-700 border border-sky-200 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        DAPODIK TERVERIFIKASI
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1 max-w-3xl leading-relaxed">
                    Kelola data induk siswa tingkat akhir SMK Negeri 1 Gunungputri untuk persiapan dan penempatan PKL.
                </p>
            </div>

            <!-- Top Right Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <!-- Tarik Data Dapodik -->
                <form action="{{ route('admin.siswa.syncDapodik') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-2 px-3.5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                        <svg class="w-3.5 h-3.5 text-[#0284c7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Tarik Data Dapodik</span>
                    </button>
                </form>

                <!-- Impor Excel -->
                <button type="button" 
                        @click="isImportModalOpen = true"
                        class="flex items-center gap-2 px-3.5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span>Impor Excel</span>
                </button>

                <!-- Ekspor CSV/Excel -->
                <a href="{{ route('admin.siswa.export', request()->query()) }}" 
                   class="flex items-center gap-2 px-3.5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Ekspor CSV/Excel</span>
                </a>

                <!-- + Tambah Siswa -->
                <button type="button" 
                        @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition active:scale-98">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Siswa</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 4 KPI Summary Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: TOTAL SISWA -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">TOTAL SISWA</div>
                    <div class="text-3xl font-black text-slate-900 mt-1 leading-tight">{{ number_format($totalSiswa, 0, ',', '.') }}</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">Seluruh Tingkat XII</span>
                <span class="inline-flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>100% Terdata</span>
                </span>
            </div>
        </div>

        <!-- Card 2: SISWA SIAP PKL (TINGKAT XII) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">SISWA SIAP PKL (TINGKAT XII)</div>
                    <div class="text-3xl font-black text-[#0284c7] mt-1 leading-tight">{{ $siapPklXII }} <span class="text-sm font-bold text-slate-500">Siswa</span></div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">6 Konsentrasi Keahlian</span>
                <span class="text-slate-600 font-semibold">Periode {{ $tahunAjaranAktif }}</span>
            </div>
        </div>

        <!-- Card 3: AKUN SISWA AKTIF -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">AKUN SISWA AKTIF</div>
                    <div class="text-3xl font-black text-slate-900 mt-1 leading-tight">{{ number_format($akunAktif, 0, ',', '.') }} <span class="text-sm font-bold text-slate-500">Siswa</span></div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mb-1.5">
                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $persenAktivasi }}%"></div>
                </div>
                <div class="text-[11px] text-emerald-600 font-semibold">
                    {{ $persenAktivasi }}% telah aktivasi
                </div>
            </div>
        </div>

        <!-- Card 4: BELUM AKTIVASI / PENDING -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">BELUM AKTIVASI / PENDING</div>
                    <div class="text-3xl font-black text-[#e11d48] mt-1 leading-tight">{{ $belumAktivasi }} <span class="text-sm font-bold text-slate-500">Siswa</span></div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 border border-rose-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <form action="{{ route('admin.siswa.invitePending') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold flex items-center gap-1">
                        <span>Perlu tindak lanjut:</span>
                        <span class="underline">Kirim Undangan</span>
                        <span>&rarr;</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filter & Toolbar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs">
        <form action="{{ route('admin.siswa.index') }}" method="GET" id="filterForm" class="flex flex-col xl:flex-row xl:items-center justify-between gap-3">
            
            <!-- Left Filters -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 flex-1 flex-wrap">
                <!-- Search Input -->
                <div class="relative w-full sm:min-w-[240px] sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama siswa, NISN, atau email..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <!-- Dropdown 1: Semua Tingkat/Kelas -->
                <div class="relative w-full sm:min-w-[160px] sm:flex-1">
                    <select name="tingkat" 
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="XII" {{ request('tingkat', 'XII') == 'XII' ? 'selected' : '' }}>Semua Kelas (Tingkat XII)</option>
                        @foreach($rombels as $r)
                            <option value="{{ $r->id }}" {{ request('tingkat') == $r->id ? 'selected' : '' }}>{{ $r->nama_rombel }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Dropdown 2: Semua Jurusan -->
                <div class="relative w-full sm:min-w-[150px] sm:flex-1">
                    <select name="jurusan_id" 
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="all" {{ request('jurusan_id', 'all') == 'all' ? 'selected' : '' }}>Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->singkatan ?: $j->kode }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Dropdown 3: Semua Status Akun -->
                <div class="relative w-full sm:min-w-[140px] sm:flex-1">
                    <select name="status_akun" 
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="all" {{ request('status_akun', 'all') == 'all' ? 'selected' : '' }}>Semua Status Akun</option>
                        <option value="aktif" {{ request('status_akun') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="belum_aktivasi" {{ request('status_akun') == 'belum_aktivasi' ? 'selected' : '' }}>Belum Aktivasi</option>
                        <option value="ditangguhkan" {{ request('status_akun') == 'ditangguhkan' ? 'selected' : '' }}>Ditangguhkan</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Dropdown 4: Semua Status PKL -->
                <div class="relative w-full sm:min-w-[145px] sm:flex-1">
                    <select name="status_pkl" 
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="all" {{ request('status_pkl', 'all') == 'all' ? 'selected' : '' }}>Semua Status PKL</option>
                        <option value="Sudah Ditempatkan" {{ request('status_pkl') == 'Sudah Ditempatkan' ? 'selected' : '' }}>Sudah Ditempatkan</option>
                        <option value="Siap Terjun" {{ request('status_pkl') == 'Siap Terjun' ? 'selected' : '' }}>Siap Terjun</option>
                        <option value="Belum Terpetakan" {{ request('status_pkl') == 'Belum Terpetakan' ? 'selected' : '' }}>Belum Terpetakan</option>
                        <option value="Sedang PKL" {{ request('status_pkl') == 'Sedang PKL' ? 'selected' : '' }}>Sedang PKL</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Reset Button -->
                <a href="{{ route('admin.siswa.index') }}" 
                   title="Reset Filter"
                   class="p-2.5 rounded-xl border border-slate-200 text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </a>
            </div>
        </form>
    </div>

    <!-- Collective Action Bar (Selected Items) -->
    <div x-show="selectedIds.length > 0" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="bg-[#eff6ff] border border-blue-200 text-slate-800 px-4 py-3 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
        
        <div class="flex items-center gap-2">
            <input type="checkbox" checked class="w-4 h-4 rounded text-blue-600 border-slate-300">
            <span class="text-xs font-bold text-slate-800"><span x-text="selectedIds.length"></span> siswa terpilih</span>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Kirim Ulang Aktivasi -->
            <button type="button" 
                    @click="bulkActivate()"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 rounded-xl text-xs font-bold transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Kirim Ulang Aktivasi</span>
            </button>

            <!-- Export Pilihan -->
            <button type="button" 
                    @click="exportSelected()"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 rounded-xl text-xs font-bold transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Export Pilihan</span>
            </button>

            <!-- Setel Rombel Masal -->
            <button type="button" 
                    @click="openBulkRombelModal()"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 rounded-xl text-xs font-bold transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Setel Rombel Masal</span>
            </button>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 pl-5 pr-3 w-10">
                            <input type="checkbox" 
                                   @change="toggleSelectAll($event)"
                                   :checked="allSelected"
                                   class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer">
                        </th>
                        <th class="py-3.5 px-3 w-12 text-center">NO</th>
                        <th class="py-3.5 px-4">NIS / NISN</th>
                        <th class="py-3.5 px-4">NAMA SISWA</th>
                        <th class="py-3.5 px-4">KELAS &amp; ROMBEL</th>
                        <th class="py-3.5 px-4">KONSENTRASI KEAHLIAN</th>
                        <th class="py-3.5 px-4">KONTAK SISWA</th>
                        <th class="py-3.5 px-4">STATUS AKUN</th>
                        <th class="py-3.5 px-4">STATUS PKL</th>
                        <th class="py-3.5 pr-6 pl-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($siswas as $index => $s)
                        <tr class="hover:bg-slate-50/80 transition group {{ in_array($s->id, [1, 2, 3]) ? 'bg-blue-50/20' : '' }}">
                            <!-- Checkbox -->
                            <td class="py-4 pl-5 pr-3">
                                <input type="checkbox" 
                                       value="{{ $s->id }}"
                                       @change="toggleSelect('{{ $s->id }}')"
                                       :checked="selectedIds.includes('{{ $s->id }}')"
                                       class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer">
                            </td>

                            <!-- No -->
                            <td class="py-4 px-3 text-center text-slate-400 font-medium text-xs">
                                {{ ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1 }}
                            </td>

                            <!-- NIS / NISN -->
                            <td class="py-4 px-4 font-mono">
                                <div class="font-extrabold text-slate-900 text-xs tracking-tight">
                                    {{ $s->nis }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    {{ $s->nisn }}
                                </div>
                            </td>

                            <!-- Nama Siswa with Initials Avatar -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs shrink-0
                                        {{ in_array($s->initials, ['RP', 'FR', 'GP', 'RM']) ? 'bg-sky-100 text-sky-700' : '' }}
                                        {{ in_array($s->initials, ['AN', 'NS', 'SA', 'TM']) ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ in_array($s->initials, ['DK', 'AF']) ? 'bg-slate-100 text-slate-700 border border-slate-200' : '' }}
                                        {{ !in_array($s->initials, ['RP', 'FR', 'GP', 'RM', 'AN', 'NS', 'SA', 'TM', 'DK', 'AF']) ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : '' }}">
                                        {{ $s->initials }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-[13px] leading-snug">
                                            {{ $s->nama }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">
                                            <span>{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                            <span class="mx-1">•</span>
                                            <span>{{ $s->kota ?: 'Bogor' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kelas & Rombel Badge -->
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-sky-50 text-sky-800 border border-sky-200">
                                    {{ $s->rombel ? $s->rombel->nama_rombel : '-' }}
                                </span>
                            </td>

                            <!-- Konsentrasi Keahlian -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-800 text-xs">
                                    {{ $s->jurusan ? $s->jurusan->nama : '-' }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    {{ $s->kampus ?: 'Kampus Pusat' }}
                                </div>
                            </td>

                            <!-- Kontak Siswa -->
                            <td class="py-4 px-4 font-mono">
                                <div class="text-xs font-semibold text-slate-700">
                                    {{ $s->no_hp ?: '-' }}
                                </div>
                                <div class="text-[11px] text-slate-400 truncate max-w-[180px] mt-0.5 font-sans" title="{{ $s->email }}">
                                    {{ $s->email ?: '-' }}
                                </div>
                            </td>

                            <!-- Status Akun -->
                            <td class="py-4 px-4">
                                @if($s->status_akun === 'aktif')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-[#ecfdf5] text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Aktif</span>
                                    </span>
                                @elseif($s->status_akun === 'belum_aktivasi')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>Belum Aktivasi</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        <span>Ditangguhkan</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Status PKL -->
                            <td class="py-4 px-4">
                                @if($s->status_pkl === 'Sudah Ditempatkan')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-[#ecfdf5] text-[#059669] border border-emerald-200/80">
                                        Sudah Ditempatkan
                                    </span>
                                @elseif($s->status_pkl === 'Siap Terjun')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-200/80">
                                        Siap Terjun
                                    </span>
                                @elseif($s->status_pkl === 'Belum Terpetakan')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                        Belum Terpetakan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ $s->status_pkl }}
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 pr-6 pl-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <!-- Detail / Eye -->
                                    <button type="button" 
                                            @click="openDetailModal({{ $s->toJson() }}, '{{ $s->rombel ? $s->rombel->nama_rombel : '' }}', '{{ $s->jurusan ? $s->jurusan->nama : '' }}')"
                                            title="Lihat Detail Siswa"
                                            class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <!-- Edit / Pencil -->
                                    <button type="button" 
                                            @click="openEditModal({{ $s->toJson() }})"
                                            title="Edit Data Siswa"
                                            class="p-1.5 text-slate-400 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <!-- Delete / Trash -->
                                    <button type="button" 
                                            @click="confirmDelete('{{ $s->id }}', '{{ $s->nama }}')"
                                            title="Hapus Data Siswa"
                                            class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="font-bold text-slate-700 text-sm">Tidak ada data siswa ditemukan</div>
                                <div class="text-xs text-slate-400 mt-1">Silakan sesuaikan kata kunci pencarian atau filter rombel/jurusan.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination & Showing Info Footer -->
        <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
            <div class="flex items-center gap-2 text-slate-500 font-medium">
                <span>
                    Menampilkan 
                    <strong class="text-slate-800">{{ $siswas->firstItem() ?? 0 }}-{{ $siswas->lastItem() ?? 0 }}</strong> dari 
                    <strong class="text-slate-800">{{ $siswas->total() }}</strong> siswa ({{ $totalSiswa }} total murid)
                </span>
                <span class="text-slate-300">•</span>
                <div class="flex items-center gap-1.5">
                    <span>Tampilkan:</span>
                    <select onchange="updatePerPage(this.value)" 
                            class="bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per halaman</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per halaman</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per halaman</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per halaman</option>
                    </select>
                </div>
            </div>

            <!-- Page Navigation -->
            <div class="flex items-center gap-1">
                @if ($siswas->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg text-slate-300 font-medium cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $siswas->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold transition">Sebelumnya</a>
                @endif

                @foreach ($siswas->getUrlRange(1, min(4, $siswas->lastPage())) as $page => $url)
                    @if ($page == $siswas->currentPage())
                        <span class="w-8 h-8 rounded-lg bg-[#0f2942] text-white font-bold flex items-center justify-center shadow-xs">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold flex items-center justify-center transition">{{ $page }}</a>
                    @endif
                @endforeach

                @if($siswas->lastPage() > 4)
                    <span class="px-1 text-slate-400 font-bold">...</span>
                    <a href="{{ $siswas->url($siswas->lastPage()) }}" class="w-8 h-8 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold flex items-center justify-center transition">{{ $siswas->lastPage() }}</a>
                @endif

                @if ($siswas->hasMorePages())
                    <a href="{{ $siswas->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold transition">Selanjutnya</a>
                @else
                    <span class="px-3 py-1.5 rounded-lg text-slate-300 font-medium cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>

    <!-- ==================== MODAL TAMBAH SISWA ==================== -->
    <div x-show="isCreateModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="isCreateModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-2xl transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                <form action="{{ route('admin.siswa.store') }}" method="POST">
                    @csrf
                    <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900">Tambah Data Siswa Baru</h3>
                                <p class="text-xs text-slate-400">Daftarkan data siswa ke dalam sistem induk PKL SMKN 1 Gunungputri</p>
                            </div>
                        </div>
                        <button type="button" @click="isCreateModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">NIS <span class="text-rose-500">*</span></label>
                                <input type="text" name="nis" required placeholder="Contoh: 212210450" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">NISN <span class="text-rose-500">*</span></label>
                                <input type="text" name="nisn" required placeholder="Contoh: 0067891290" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama" required placeholder="Contoh: Raka Pratama" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                <select name="jenis_kelamin" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kota / Domisili</label>
                                <input type="text" name="kota" placeholder="Contoh: Bogor / Gunungputri" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kelas &amp; Rombel <span class="text-rose-500">*</span></label>
                                <select name="rombel_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    @foreach($rombels as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama_rombel }} ({{ $r->tingkat }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Handphone / WhatsApp</label>
                                <input type="text" name="no_hp" placeholder="+62 812-xxxx-xxxx" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email Siswa</label>
                                <input type="email" name="email" placeholder="siswa@smkn1gunungputri.sch.id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Akun <span class="text-rose-500">*</span></label>
                                <select name="status_akun" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="aktif">Aktif</option>
                                    <option value="belum_aktivasi">Belum Aktivasi</option>
                                    <option value="ditangguhkan">Ditangguhkan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status PKL <span class="text-rose-500">*</span></label>
                                <select name="status_pkl" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="Sudah Ditempatkan">Sudah Ditempatkan</option>
                                    <option value="Siap Terjun">Siap Terjun</option>
                                    <option value="Belum Terpetakan">Belum Terpetakan</option>
                                    <option value="Sedang PKL">Sedang PKL</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isCreateModalOpen = false" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Simpan Data Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL EDIT SISWA ==================== -->
    <div x-show="isEditModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="isEditModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-2xl transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                <form :action="'{{ url('admin/siswa') }}/' + editData.id" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900">Edit Data Siswa</h3>
                                <p class="text-xs text-slate-400">Perbarui data siswa <span class="font-bold text-slate-700" x-text="editData.nama"></span></p>
                            </div>
                        </div>
                        <button type="button" @click="isEditModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">NIS <span class="text-rose-500">*</span></label>
                                <input type="text" name="nis" x-model="editData.nis" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">NISN <span class="text-rose-500">*</span></label>
                                <input type="text" name="nisn" x-model="editData.nisn" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama" x-model="editData.nama" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                <select name="jenis_kelamin" x-model="editData.jenis_kelamin" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kota / Domisili</label>
                                <input type="text" name="kota" x-model="editData.kota" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kelas &amp; Rombel <span class="text-rose-500">*</span></label>
                                <select name="rombel_id" x-model="editData.rombel_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    @foreach($rombels as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama_rombel }} ({{ $r->tingkat }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Handphone / WhatsApp</label>
                                <input type="text" name="no_hp" x-model="editData.no_hp" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email Siswa</label>
                                <input type="email" name="email" x-model="editData.email" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Akun <span class="text-rose-500">*</span></label>
                                <select name="status_akun" x-model="editData.status_akun" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="aktif">Aktif</option>
                                    <option value="belum_aktivasi">Belum Aktivasi</option>
                                    <option value="ditangguhkan">Ditangguhkan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status PKL <span class="text-rose-500">*</span></label>
                                <select name="status_pkl" x-model="editData.status_pkl" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="Sudah Ditempatkan">Sudah Ditempatkan</option>
                                    <option value="Siap Terjun">Siap Terjun</option>
                                    <option value="Belum Terpetakan">Belum Terpetakan</option>
                                    <option value="Sedang PKL">Sedang PKL</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isEditModalOpen = false" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Perbarui Data Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL DETAIL SISWA ==================== -->
    <div x-show="isDetailModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="isDetailModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-xl transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-900" x-text="detailData.nama"></h3>
                            <p class="text-xs text-slate-400 font-mono">NIS: <span x-text="detailData.nis"></span> • NISN: <span x-text="detailData.nisn"></span></p>
                        </div>
                    </div>
                    <button type="button" @click="isDetailModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-3 bg-slate-50/70 p-4 rounded-2xl border border-slate-100 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Kelas &amp; Rombel</span>
                            <span class="font-bold text-slate-800" x-text="detailRombelNama || '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Program Keahlian</span>
                            <span class="font-bold text-slate-800" x-text="detailJurusanNama || '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Lokasi Kampus</span>
                            <span class="font-bold text-slate-800" x-text="detailData.kampus || 'Kampus Pusat'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Domisili Asal</span>
                            <span class="font-bold text-slate-800" x-text="detailData.kota || '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Status PKL</span>
                            <span class="inline-flex items-center gap-1 font-bold text-emerald-600" x-text="detailData.status_pkl"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Status Akun</span>
                            <span class="font-bold text-slate-800 capitalize" x-text="detailData.status_akun"></span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200 text-xs space-y-2">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">KONTAK LENGKAP SISWA</div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Nomor WhatsApp:</span>
                            <span class="font-bold font-mono text-slate-900" x-text="detailData.no_hp || '-'"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Email Akun:</span>
                            <span class="font-semibold text-blue-600" x-text="detailData.email || '-'"></span>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end">
                    <button type="button" @click="isDetailModalOpen = false" class="px-5 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL SETEL ROMBEL MASAL ==================== -->
    <div x-show="isBulkRombelModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="isBulkRombelModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                <form action="{{ route('admin.siswa.bulkRombel') }}" method="POST">
                    @csrf
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="siswa_ids[]" :value="id">
                    </template>

                    <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-base font-extrabold text-slate-900">Setel Rombel Massal</h3>
                        <button type="button" @click="isBulkRombelModalOpen = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <p class="text-xs text-slate-500">
                            Pilih rombongan belajar baru untuk <strong class="text-slate-800" x-text="selectedIds.length"></strong> siswa terpilih:
                        </p>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Rombongan Belajar</label>
                            <select name="target_rombel_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($rombels as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_rombel }} - {{ $r->jurusan ? $r->jurusan->nama : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isBulkRombelModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold">
                            Terapkan Rombel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL IMPOR EXCEL ==================== -->
    <div x-show="isImportModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="isImportModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                <form action="{{ route('admin.siswa.syncDapodik') }}" method="POST">
                    @csrf
                    <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-base font-extrabold text-slate-900">Impor Data Siswa / Sinkronisasi Dapodik</h3>
                        <button type="button" @click="isImportModalOpen = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4 text-center">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                        </div>
                        <p class="text-xs text-slate-600">
                            Sinkronisasi dan tarik data resmi peserta didik langsung dari server Dapodikdasmen Kemendikbudristek RI untuk Tahun Ajaran {{ $tahunAjaranAktif }}.
                        </p>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-center gap-3">
                        <button type="button" @click="isImportModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Tarik Data Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL KONFIRMASI HAPUS ==================== -->
    <div x-show="isDeleteModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="isDeleteModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                <form :action="'{{ url('admin/siswa') }}/' + deleteId" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="p-6 text-center">
                        <div class="w-14 h-14 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4 border border-rose-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">Hapus Data Siswa?</h3>
                        <p class="text-xs text-slate-500 mt-2">
                            Apakah Anda yakin ingin menghapus data siswa <strong class="text-slate-800" x-text="deleteName"></strong>? Data yang dihapus tidak dapat dipulihkan.
                        </p>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-center gap-3">
                        <button type="button" @click="isDeleteModalOpen = false" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Ya, Hapus Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function siswaApp() {
        return {
            selectedIds: [],
            allSelected: false,
            
            isCreateModalOpen: false,
            isEditModalOpen: false,
            isDetailModalOpen: false,
            isBulkRombelModalOpen: false,
            isImportModalOpen: false,
            isDeleteModalOpen: false,

            editData: {},
            detailData: {},
            detailRombelNama: '',
            detailJurusanNama: '',

            deleteId: '',
            deleteName: '',

            toggleSelectAll(e) {
                const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                this.selectedIds = [];
                if (e.target.checked) {
                    checkboxes.forEach(cb => {
                        this.selectedIds.push(cb.value);
                    });
                    this.allSelected = true;
                } else {
                    this.allSelected = false;
                }
            },

            toggleSelect(id) {
                const index = this.selectedIds.indexOf(id);
                if (index > -1) {
                    this.selectedIds.splice(index, 1);
                } else {
                    this.selectedIds.push(id);
                }
                const totalVisible = document.querySelectorAll('tbody input[type="checkbox"]').length;
                this.allSelected = this.selectedIds.length === totalVisible && totalVisible > 0;
            },

            openCreateModal() {
                this.isCreateModalOpen = true;
            },

            openEditModal(data) {
                this.editData = Object.assign({}, data);
                this.isEditModalOpen = true;
            },

            openDetailModal(data, rombelNama, jurusanNama) {
                this.detailData = Object.assign({}, data);
                this.detailRombelNama = rombelNama;
                this.detailJurusanNama = jurusanNama;
                this.isDetailModalOpen = true;
            },

            confirmDelete(id, name) {
                this.deleteId = id;
                this.deleteName = name;
                this.isDeleteModalOpen = true;
            },

            openBulkRombelModal() {
                this.isBulkRombelModalOpen = true;
            },

            bulkActivate() {
                if (this.selectedIds.length === 0) return;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.siswa.bulkActivate") }}';
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrf);
                this.selectedIds.forEach(id => {
                    const inp = document.createElement('input');
                    inp.type = 'hidden';
                    inp.name = 'siswa_ids[]';
                    inp.value = id;
                    form.appendChild(inp);
                });
                document.body.appendChild(form);
                form.submit();
            },

            exportSelected() {
                window.location.href = '{{ route("admin.siswa.export") }}?selected=' + this.selectedIds.join(',');
            }
        }
    }

    function updatePerPage(val) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', val);
        url.searchParams.set('page', 1);
        window.location.href = url.toString();
    }
</script>
@endpush
@endsection
