@extends('layouts.admin')

@section('title', 'SIPRAK SMKN 1 GUNUNGPUTRI - Master Data Guru & Role')
@section('header_search_placeholder', 'Cari NISN, nama siswa, PT/DUDI, atau NIP guru...')

@section('content')
<div x-data="guruApp()" class="space-y-6">

    <!-- Breadcrumb & Header Section -->
    <div>
        <div class="text-[11px] font-semibold text-slate-400 mb-1.5 flex items-center gap-1.5">
            <span>Pengaturan &amp; Master Data</span>
            <span class="text-slate-300">&gt;</span>
            <span class="text-slate-600">Data Tenaga Pendidik (TA 2024/2025)</span>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-extrabold text-[#0f2942] tracking-tight">
                        Master Data Guru &amp; Role
                    </h1>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide bg-sky-50 text-sky-700 border border-sky-200 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        DAPODIK TERVERIFIKASI
                    </span>
                </div>
            </div>

            <!-- Top Right Sync Card & Button -->
            <div class="flex items-center gap-3 shrink-0">
                <div class="text-right hidden sm:block">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">SINKRONISASI DAPODIK</div>
                    <div class="text-xs font-bold text-slate-900">Hari ini, 08:45 WIB</div>
                </div>

                <form action="{{ route('admin.guru.syncDapodik') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-2 px-3.5 py-2 bg-white hover:bg-slate-50 text-[#0284c7] border border-slate-200 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                        <svg class="w-3.5 h-3.5 text-[#0284c7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Tarik Data GTK Dapodik</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- 4 KPI Summary Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Guru & GTK -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">TOTAL GURU &amp; GTK</div>
                    <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $totalGuru }} Guru</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">Seluruh Program Keahlian</span>
                <span class="inline-flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    <span>•</span> 100% Terdaftar
                </span>
            </div>
        </div>

        <!-- Card 2: Guru Pembimbing PKL -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">GURU PEMBIMBING PKL</div>
                    <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $pembimbingCount }} Guru</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">Supervisi 108 Siswa On-Site</span>
                <span class="inline-flex items-center gap-1 font-bold text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full">
                    <span>•</span> Aktif Mendampingi
                </span>
            </div>
        </div>

        <!-- Card 3: Wali Kelas (Tingkat XII) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">WALI KELAS (TINGKAT XII)</div>
                    <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $waliKelasCount }} Guru</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">Verifikator Tahap 1</span>
                <span class="inline-flex items-center gap-1 font-bold text-[#0f2942] bg-slate-100 px-2 py-0.5 rounded-full">
                    <span>•</span> 6 Jurusan
                </span>
            </div>
        </div>

        <!-- Card 4: Kepala Program (Kaprog) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">KEPALA PROGRAM (KAPROG)</div>
                    <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $kaprogCount }} Kaprog</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">Otorisator Berkas Tahap 2</span>
                <span class="inline-flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    <span>•</span> Lengkap
                </span>
            </div>
        </div>
    </div>

    <!-- Filters & Action Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs">
        <form action="{{ route('admin.guru.index') }}" method="GET" id="filterForm" class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            
            <!-- Left Filters -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 flex-1 flex-wrap">
                <!-- Search Input -->
                <div class="relative min-w-[260px] sm:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari NIP, nama guru, atau role penugasan..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <!-- Role Filter Dropdown -->
                <div class="relative min-w-[150px]">
                    <select name="role" 
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>Semua Role</option>
                        <option value="Kaprog" {{ request('role') == 'Kaprog' ? 'selected' : '' }}>Kepala Program (Kaprog)</option>
                        <option value="Pembimbing" {{ request('role') == 'Pembimbing' ? 'selected' : '' }}>Pembimbing PKL</option>
                        <option value="Wali Kelas" {{ request('role') == 'Wali Kelas' ? 'selected' : '' }}>Wali Kelas</option>
                        <option value="Guru Penguji" {{ request('role') == 'Guru Penguji' ? 'selected' : '' }}>Guru Penguji</option>
                        <option value="Koordinator Hubin" {{ request('role') == 'Koordinator Hubin' ? 'selected' : '' }}>Koordinator Hubin</option>
                        <option value="Guru Kejuruan" {{ request('role') == 'Guru Kejuruan' ? 'selected' : '' }}>Guru Kejuruan</option>
                        <option value="belum_diberi_role" {{ request('role') == 'belum_diberi_role' ? 'selected' : '' }}>Belum Diberi Role</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Jurusan Filter Dropdown -->
                <div class="relative min-w-[150px]">
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

                <!-- Status Akun Dropdown -->
                <div class="relative min-w-[140px]">
                    <select name="status_akun" 
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="all" {{ request('status_akun', 'all') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="aktif" {{ request('status_akun') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="belum_aktivasi" {{ request('status_akun') == 'belum_aktivasi' ? 'selected' : '' }}>Belum Aktivasi</option>
                        <option value="nonaktif" {{ request('status_akun') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Filter Reset Button -->
                <a href="{{ route('admin.guru.index') }}" 
                   title="Reset Filter"
                   class="p-2.5 rounded-xl border border-slate-200 text-slate-400 hover:text-slate-600 hover:bg-slate-50 transition flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </a>
            </div>

            <!-- Right Actions: Impor, Ekspor, Tambah -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <!-- Impor Data GTK -->
                <button type="button" 
                        @click="openImportModal()"
                        class="flex items-center gap-2 px-3.5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span>Impor Data GTK</span>
                </button>

                <!-- Ekspor XLS -->
                <a href="{{ route('admin.guru.export', request()->query()) }}" 
                   class="flex items-center gap-2 px-3.5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Ekspor XLS</span>
                </a>

                <!-- + Tambah Guru -->
                <button type="button" 
                        @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition active:scale-98">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>+ Tambah Guru</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Collective Action Banner (Shown when items are selected) -->
    <div x-show="selectedIds.length > 0" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="bg-[#eff6ff] border border-blue-200 text-slate-800 px-4 py-3 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-xs">
        
        <div class="flex items-center gap-3">
            <span class="w-6 h-6 rounded-full bg-[#1d4ed8] text-white text-xs font-bold flex items-center justify-center shrink-0" x-text="selectedIds.length">
                3
            </span>
            <div class="text-xs font-semibold text-slate-800">
                <span>Guru dipilih untuk pembaruan kolektif</span>
                <span class="text-slate-400 font-mono text-[11px] ml-1" x-text="selectedNipsText"></span>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="button" 
                    @click="openBulkRoleModal()"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 rounded-xl text-xs font-bold transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <span>Ubah Penugasan Role Masal</span>
            </button>

            <button type="button" 
                    @click="bulkInvite()"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 rounded-xl text-xs font-bold transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Kirim Akses Akun</span>
            </button>

            <button type="button" 
                    @click="exportSelected()"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 rounded-xl text-xs font-bold transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Ekspor Terpilih</span>
            </button>

            <button type="button" @click="clearSelection()" class="text-slate-400 hover:text-slate-600 p-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
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
                        <th class="py-3.5 px-4">NIP / NUPTK</th>
                        <th class="py-3.5 px-4">NAMA GURU</th>
                        <th class="py-3.5 px-4">ROLE (MULTI-PENUGASAN)</th>
                        <th class="py-3.5 px-4">KELAS / JURUSAN DIAMPU</th>
                        <th class="py-3.5 px-4">STATUS AKUN</th>
                        <th class="py-3.5 pr-6 pl-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($gurus as $g)
                        <tr class="hover:bg-slate-50/80 transition group {{ in_array($g->id, [1, 2, 3]) ? 'bg-blue-50/20' : '' }}">
                            <!-- Checkbox -->
                            <td class="py-4 pl-5 pr-3">
                                <input type="checkbox" 
                                       value="{{ $g->id }}"
                                       data-nip="{{ $g->nip }}"
                                       @change="toggleSelect('{{ $g->id }}', '{{ $g->nip }}')"
                                       :checked="selectedIds.includes('{{ $g->id }}')"
                                       class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer">
                            </td>

                            <!-- NIP / NUPTK -->
                            <td class="py-4 px-4 font-mono">
                                <div class="font-bold text-slate-900 text-xs tracking-tight">
                                    {{ $g->nip }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    {{ $g->nuptk ? 'NUPTK: ' . $g->nuptk : 'NUPTK: -' }}
                                </div>
                            </td>

                            <!-- Nama Guru with Avatar -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    @if($g->avatar_url)
                                        <img src="{{ $g->avatar_url }}" alt="{{ $g->nama }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs shrink-0
                                            {{ in_array($g->initials, ['BW', 'HS', 'BS']) ? 'bg-[#0f2942] text-white' : '' }}
                                            {{ in_array($g->initials, ['AF', 'RM']) ? 'bg-sky-100 text-sky-700' : '' }}
                                            {{ in_array($g->initials, ['NH', 'MY']) ? 'bg-indigo-100 text-indigo-700' : '' }}
                                            {{ !in_array($g->initials, ['BW', 'HS', 'BS', 'AF', 'RM', 'NH', 'MY']) ? 'bg-slate-100 text-slate-700 border border-slate-200' : '' }}">
                                            {{ $g->initials }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 text-[13px] leading-snug">
                                            {{ $g->nama }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">
                                            <span>{{ $g->jenis_kelamin }}</span>
                                            @if($g->pendidikan)
                                                <span class="mx-1">•</span>
                                                <span>{{ $g->pendidikan }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Role (Multi-Penugasan) Badges -->
                            <td class="py-4 px-4">
                                <div class="flex flex-wrap items-center gap-1.5 max-w-sm">
                                    @php
                                        $roles = $g->roles_list ?: [];
                                    @endphp

                                    @if(empty($roles))
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                            <span>•</span> Belum Diberi Role
                                        </span>
                                        <button type="button" 
                                                @click="openManageRoleModal({{ $g->toJson() }})"
                                                class="text-xs text-blue-600 hover:text-blue-800 font-bold ml-1 transition">
                                            + Setel Role
                                        </button>
                                    @else
                                        @foreach($roles as $r)
                                            @if(str_contains($r, 'Kaprog'))
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-[#0f2942] text-white shadow-2xs">
                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    </svg>
                                                    <span>{{ $r }}</span>
                                                </span>
                                            @elseif(str_contains($r, 'Wali Kelas'))
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                                    <svg class="w-3 h-3 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                    <span>{{ $r }}</span>
                                                </span>
                                            @elseif(str_contains($r, 'Koordinator'))
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    <span>{{ $r }}</span>
                                                </span>
                                            @elseif(str_contains($r, 'Pembimbing'))
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-[#f0fdf4] text-emerald-700 border border-emerald-200">
                                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                    <span>{{ $r }}</span>
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-medium bg-slate-50 text-slate-700 border border-slate-200">
                                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span>{{ $r }}</span>
                                                </span>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </td>

                            <!-- Kelas / Jurusan Diampu -->
                            <td class="py-4 px-4">
                                @if($g->kelas_diampu && $g->kelas_diampu !== 'Belum teralokasi di Rombel/PKL')
                                    <div class="font-bold text-slate-900 text-xs">
                                        {{ $g->kelas_diampu }}
                                    </div>
                                    @if($g->keterangan_diampu)
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            {{ $g->keterangan_diampu }}
                                        </div>
                                    @endif
                                @else
                                    <div class="text-xs text-slate-400 italic">
                                        Belum teralokasi di Rombel/PKL
                                    </div>
                                @endif
                            </td>

                            <!-- Status Akun (Toggle or Badge) -->
                            <td class="py-4 px-4">
                                @if($g->status_akun === 'aktif')
                                    <div class="flex items-center gap-2">
                                        <button type="button" 
                                                @click="toggleStatus('{{ $g->id }}', 'nonaktif')"
                                                class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-blue-600 transition-colors duration-200 ease-in-out focus:outline-none">
                                            <span class="translate-x-4 pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                        <span class="text-[11px] font-semibold text-emerald-600 flex items-center gap-1">
                                            <span>•</span> Aktif
                                        </span>
                                    </div>
                                @elseif($g->status_akun === 'belum_aktivasi')
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            Belum Aktivasi
                                        </span>
                                        <div class="mt-0.5">
                                            <form action="{{ route('admin.guru.sendEmail', $g->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-[11px] text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                                    Kirim Email
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2">
                                        <button type="button" 
                                                @click="toggleStatus('{{ $g->id }}', 'aktif')"
                                                class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-slate-200 transition-colors duration-200 ease-in-out focus:outline-none">
                                            <span class="translate-x-0 pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                        <span class="text-[11px] font-medium text-slate-400">Nonaktif</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 pr-6 pl-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <!-- Role Penugasan Button -->
                                    <button type="button" 
                                            @click="openManageRoleModal({{ $g->toJson() }})"
                                            title="Kelola Role &amp; Penugasan"
                                            class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>

                                    <!-- Edit Button -->
                                    <button type="button" 
                                            @click="openEditModal({{ $g->toJson() }})"
                                            title="Edit Data Guru"
                                            class="p-1.5 text-slate-400 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" 
                                            @click="confirmDelete('{{ $g->id }}', '{{ $g->nama }}')"
                                            title="Hapus Guru"
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
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="font-bold text-slate-700 text-sm">Tidak ada data guru &amp; GTK ditemukan</div>
                                <div class="text-xs text-slate-400 mt-1">Silakan sesuaikan kata kunci pencarian atau filter role.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
            <div class="flex items-center gap-2 text-slate-500 font-medium">
                <span>
                    Menampilkan 
                    <strong class="text-slate-800">{{ $gurus->firstItem() ?? 0 }}</strong> - 
                    <strong class="text-slate-800">{{ $gurus->lastItem() ?? 0 }}</strong> dari 
                    <strong class="text-slate-800">{{ $gurus->total() }}</strong> Guru &amp; Tenaga Kependidikan
                </span>
                <span class="text-slate-300">•</span>
                <div class="flex items-center gap-1.5">
                    <select onchange="updatePerPage(this.value)" 
                            class="bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 baris per halaman</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris per halaman</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris per halaman</option>
                        <option value="86" {{ request('per_page') == 86 ? 'selected' : '' }}>Semua (86 baris)</option>
                    </select>
                </div>
            </div>

            <!-- Page Navigation -->
            <div class="flex items-center gap-1">
                @if ($gurus->onFirstPage())
                    <span class="px-2.5 py-1.5 rounded-lg text-slate-300 font-medium cursor-not-allowed">&lt; Sebelumnya</span>
                @else
                    <a href="{{ $gurus->previousPageUrl() }}" class="px-2.5 py-1.5 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold transition">&lt; Sebelumnya</a>
                @endif

                @foreach ($gurus->getUrlRange(1, min(5, $gurus->lastPage())) as $page => $url)
                    @if ($page == $gurus->currentPage())
                        <span class="w-8 h-8 rounded-lg bg-[#0f2942] text-white font-bold flex items-center justify-center shadow-xs">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold flex items-center justify-center transition">{{ $page }}</a>
                    @endif
                @endforeach

                @if($gurus->lastPage() > 5)
                    <span class="px-1 text-slate-400 font-bold">...</span>
                    <a href="{{ $gurus->url($gurus->lastPage()) }}" class="w-8 h-8 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold flex items-center justify-center transition">{{ $gurus->lastPage() }}</a>
                @endif

                @if ($gurus->hasMorePages())
                    <a href="{{ $gurus->nextPageUrl() }}" class="px-2.5 py-1.5 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold transition">Selanjutnya &gt;</a>
                @else
                    <span class="px-2.5 py-1.5 rounded-lg text-slate-300 font-medium cursor-not-allowed">Selanjutnya &gt;</span>
                @endif
            </div>
        </div>
    </div>

    <!-- ==================== MODAL TAMBAH GURU ==================== -->
    <div x-show="isCreateModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isCreateModalOpen" 
                 @click="isCreateModalOpen = false" 
                 class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isCreateModalOpen" 
                 class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                
                <form action="{{ route('admin.guru.store') }}" method="POST">
                    @csrf
                    <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900">Tambah Data Guru &amp; GTK</h3>
                                <p class="text-xs text-slate-400">Daftarkan tenaga pendidik baru ke dalam sistem SIPRAK</p>
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
                                <label class="block text-xs font-bold text-slate-700 mb-1">NIP <span class="text-rose-500">*</span></label>
                                <input type="text" name="nip" required placeholder="Contoh: 198503142009022004" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">NUPTK</label>
                                <input type="text" name="nuptk" placeholder="Contoh: 1042 7636 6430 0081" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama" required placeholder="Contoh: Siti Rahmawati, S.Kom." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                <select name="jenis_kelamin" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Pendidikan Terakhir</label>
                                <input type="text" name="pendidikan" placeholder="Contoh: S1 Sistem Informasi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                                <input type="email" name="email" placeholder="guru@smkn1gunungputri.sch.id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Handphone / WhatsApp</label>
                                <input type="text" name="no_hp" placeholder="081234567890" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Role Penugasan (Pisahkan dengan koma)</label>
                                <input type="text" name="roles_input" placeholder="Contoh: Kaprog RPL, Pembimbing PKL, Guru Penguji" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                <p class="text-[10px] text-slate-400 mt-1">Pilihan role umum: Kaprog, Pembimbing PKL, Wali Kelas, Guru Penguji, Koordinator Hubin, Guru Kejuruan.</p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jurusan / Program Keahlian</label>
                                <select name="jurusan_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="">-- Tanpa Jurusan Tertentu --</option>
                                    @foreach($jurusans as $j)
                                        <option value="{{ $j->id }}">{{ $j->singkatan ?: $j->kode }} - {{ $j->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Akun <span class="text-rose-500">*</span></label>
                                <select name="status_akun" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="aktif">Aktif</option>
                                    <option value="belum_aktivasi">Belum Aktivasi</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kelas / Jurusan Diampu</label>
                                <input type="text" name="kelas_diampu" placeholder="Contoh: Rekayasa Perangkat Lunak / XII RPL 1 (Wali Kelas)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Penugasan</label>
                                <input type="text" name="keterangan_diampu" placeholder="Contoh: XII RPL 1, 2, 3 • Supervisi 24 Mitra DUDI" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isCreateModalOpen = false" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Simpan Data Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL EDIT GURU ==================== -->
    <div x-show="isEditModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isEditModalOpen" @click="isEditModalOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isEditModalOpen" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                <form :action="'{{ url('admin/guru') }}/' + editData.id" method="POST">
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
                                <h3 class="text-base font-extrabold text-slate-900">Edit Data Guru</h3>
                                <p class="text-xs text-slate-400">Perbarui data tenaga pendidik <span class="font-bold text-slate-700" x-text="editData.nama"></span></p>
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
                                <label class="block text-xs font-bold text-slate-700 mb-1">NIP <span class="text-rose-500">*</span></label>
                                <input type="text" name="nip" x-model="editData.nip" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">NUPTK</label>
                                <input type="text" name="nuptk" x-model="editData.nuptk" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
                                <input type="text" name="nama" x-model="editData.nama" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                <select name="jenis_kelamin" x-model="editData.jenis_kelamin" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Pendidikan Terakhir</label>
                                <input type="text" name="pendidikan" x-model="editData.pendidikan" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                                <input type="email" name="email" x-model="editData.email" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Handphone / WhatsApp</label>
                                <input type="text" name="no_hp" x-model="editData.no_hp" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Role Penugasan (Pisahkan dengan koma)</label>
                                <input type="text" name="roles_input" x-model="editData.roles_input" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jurusan / Program Keahlian</label>
                                <select name="jurusan_id" x-model="editData.jurusan_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="">-- Tanpa Jurusan Tertentu --</option>
                                    @foreach($jurusans as $j)
                                        <option value="{{ $j->id }}">{{ $j->singkatan ?: $j->kode }} - {{ $j->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Akun <span class="text-rose-500">*</span></label>
                                <select name="status_akun" x-model="editData.status_akun" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="aktif">Aktif</option>
                                    <option value="belum_aktivasi">Belum Aktivasi</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kelas / Jurusan Diampu</label>
                                <input type="text" name="kelas_diampu" x-model="editData.kelas_diampu" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Penugasan</label>
                                <input type="text" name="keterangan_diampu" x-model="editData.keterangan_diampu" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isEditModalOpen = false" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Perbarui Data Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL KELOLA ROLE & PENUGASAN ==================== -->
    <div x-show="isManageRoleModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isManageRoleModalOpen" @click="isManageRoleModalOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isManageRoleModalOpen" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
                <form :action="'{{ url('admin/guru') }}/' + manageData.id" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nip" :value="manageData.nip">
                    <input type="hidden" name="nama" :value="manageData.nama">
                    <input type="hidden" name="jenis_kelamin" :value="manageData.jenis_kelamin || 'Laki-laki'">
                    <input type="hidden" name="status_akun" :value="manageData.status_akun || 'aktif'">

                    <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900">Kelola Role &amp; Penugasan</h3>
                                <p class="text-xs text-slate-400 font-bold" x-text="manageData.nama"></p>
                            </div>
                        </div>
                        <button type="button" @click="isManageRoleModalOpen = false" class="text-slate-400 hover:text-slate-600 p-2 rounded-xl hover:bg-slate-100 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2">Role Penugasan Aktif</label>
                            <div class="space-y-2">
                                <template x-for="r in ['Pembimbing PKL', 'Guru Penguji', 'Koordinator Hubin', 'Guru Kejuruan']" :key="r">
                                    <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer text-xs font-semibold text-slate-700">
                                        <input type="checkbox" :value="r" x-model="selectedManageRoles" class="w-4 h-4 rounded text-blue-600 border-slate-300">
                                        <span x-text="r"></span>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Role Khusus Tambahan (Tulis manual pisah koma)</label>
                            <input type="text" name="roles_input" :value="getCombinedRolesString()" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            <p class="text-[10px] text-slate-400 mt-1">Misal: Kaprog RPL, Wali Kelas XII RPL 1</p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kelas / Jurusan Diampu</label>
                            <input type="text" name="kelas_diampu" x-model="manageData.kelas_diampu" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Penugasan</label>
                            <input type="text" name="keterangan_diampu" x-model="manageData.keterangan_diampu" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isManageRoleModalOpen = false" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Simpan Penugasan Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL UBAH ROLE MASAL ==================== -->
    <div x-show="isBulkRoleModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isBulkRoleModalOpen" @click="isBulkRoleModalOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isBulkRoleModalOpen" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100">
                <form action="{{ route('admin.guru.bulkRole') }}" method="POST">
                    @csrf
                    <template x-for="id in selectedIds" :key="id">
                        <input type="hidden" name="guru_ids[]" :value="id">
                    </template>

                    <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-base font-extrabold text-slate-900">Ubah Penugasan Role Massal</h3>
                        <button type="button" @click="isBulkRoleModalOpen = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <p class="text-xs text-slate-500">
                            Pilih role penugasan yang akan ditambahkan ke <strong class="text-slate-800" x-text="selectedIds.length"></strong> guru yang dipilih:
                        </p>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Role</label>
                            <select name="bulk_role" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Pembimbing PKL">Pembimbing PKL</option>
                                <option value="Guru Penguji">Guru Penguji</option>
                                <option value="Guru Pembimbing">Guru Pembimbing</option>
                                <option value="Guru Kejuruan">Guru Kejuruan</option>
                                <option value="Koordinator Hubin">Koordinator Hubin</option>
                            </select>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isBulkRoleModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold">
                            Terapkan Penugasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL IMPOR DATA GTK ==================== -->
    <div x-show="isImportModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isImportModalOpen" @click="isImportModalOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isImportModalOpen" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100">
                <form action="{{ route('admin.guru.syncDapodik') }}" method="POST">
                    @csrf
                    <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-base font-extrabold text-slate-900">Impor Data GTK / Sinkronisasi Dapodik</h3>
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
                            Tarik data resmi Pendidik dan Tenaga Kependidikan (GTK) langsung dari server Dapodikdasmen Kemdikbudristek RI untuk Tahun Ajaran 2024/2025.
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
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isDeleteModalOpen" @click="isDeleteModalOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="isDeleteModalOpen" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-100">
                <form :action="'{{ url('admin/guru') }}/' + deleteId" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="p-6 text-center">
                        <div class="w-14 h-14 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4 border border-rose-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">Hapus Data Guru?</h3>
                        <p class="text-xs text-slate-500 mt-2">
                            Apakah Anda yakin ingin menghapus <strong class="text-slate-800" x-text="deleteName"></strong> dari sistem? Tindakan ini tidak dapat dibatalkan.
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
    function guruApp() {
        return {
            selectedIds: [],
            selectedNips: [],
            allSelected: false,
            
            isCreateModalOpen: false,
            isEditModalOpen: false,
            isManageRoleModalOpen: false,
            isBulkRoleModalOpen: false,
            isImportModalOpen: false,
            isDeleteModalOpen: false,

            editData: {},
            manageData: {},
            selectedManageRoles: [],

            deleteId: '',
            deleteName: '',

            get selectedNipsText() {
                if (this.selectedNips.length === 0) return '';
                const sample = this.selectedNips.slice(0, 3).map(n => 'NIP: ' + n.substring(0, 8) + '...').join(', ');
                return '• ' + sample;
            },

            toggleSelectAll(e) {
                const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                this.selectedIds = [];
                this.selectedNips = [];
                if (e.target.checked) {
                    checkboxes.forEach(cb => {
                        this.selectedIds.push(cb.value);
                        this.selectedNips.push(cb.dataset.nip);
                    });
                    this.allSelected = true;
                } else {
                    this.allSelected = false;
                }
            },

            toggleSelect(id, nip) {
                const index = this.selectedIds.indexOf(id);
                if (index > -1) {
                    this.selectedIds.splice(index, 1);
                    this.selectedNips.splice(index, 1);
                } else {
                    this.selectedIds.push(id);
                    this.selectedNips.push(nip);
                }
                const totalVisible = document.querySelectorAll('tbody input[type="checkbox"]').length;
                this.allSelected = this.selectedIds.length === totalVisible && totalVisible > 0;
            },

            clearSelection() {
                this.selectedIds = [];
                this.selectedNips = [];
                this.allSelected = false;
            },

            openCreateModal() {
                this.isCreateModalOpen = true;
            },

            openEditModal(data) {
                this.editData = Object.assign({}, data);
                if (Array.isArray(data.roles_list)) {
                    this.editData.roles_input = data.roles_list.join(', ');
                }
                this.isEditModalOpen = true;
            },

            openManageRoleModal(data) {
                this.manageData = Object.assign({}, data);
                this.selectedManageRoles = Array.isArray(data.roles_list) ? [...data.roles_list] : [];
                this.isManageRoleModalOpen = true;
            },

            getCombinedRolesString() {
                return this.selectedManageRoles.join(', ');
            },

            openBulkRoleModal() {
                this.isBulkRoleModalOpen = true;
            },

            openImportModal() {
                this.isImportModalOpen = true;
            },

            confirmDelete(id, name) {
                this.deleteId = id;
                this.deleteName = name;
                this.isDeleteModalOpen = true;
            },

            toggleStatus(id, newStatus) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ url("admin/guru") }}/' + id + '/toggle-status';
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = newStatus;
                form.appendChild(csrf);
                form.appendChild(statusInput);
                document.body.appendChild(form);
                form.submit();
            },

            bulkInvite() {
                if (this.selectedIds.length === 0) return;
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.guru.bulkInvite") }}';
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrf);
                this.selectedIds.forEach(id => {
                    const inp = document.createElement('input');
                    inp.type = 'hidden';
                    inp.name = 'guru_ids[]';
                    inp.value = id;
                    form.appendChild(inp);
                });
                document.body.appendChild(form);
                form.submit();
            },

            exportSelected() {
                window.location.href = '{{ route("admin.guru.export") }}?selected=' + this.selectedIds.join(',');
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
