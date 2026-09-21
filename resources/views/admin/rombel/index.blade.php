@extends('layouts.admin')

@section('title', 'SIPRAK SMKN 1 GUNUNGPUTRI - Master Data Rombel')
@section('header_search_placeholder', 'Cari rombel, wali kelas, atau ruang...')

@section('content')
<div x-data="rombelApp()" class="space-y-6">

    <!-- Page Header & Title Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl font-extrabold text-[#0f2942] tracking-tight">
                    Master Data Rombel
                </h1>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    DAPODIK TERVERIFIKASI
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 max-w-3xl leading-relaxed">
                Daftar Rombongan Belajar resmi aktif Tahun Ajaran 2024/2025 SMKN 1 Gunungputri untuk pemetaan peserta PKL.
            </p>
        </div>

        <div class="text-left md:text-right shrink-0">
            <div class="text-[11px] font-semibold text-slate-400">Tahun Ajaran Aktif</div>
            <div class="text-xs font-bold text-slate-900 mt-0.5">2024/2025 • Semester Ganjil</div>
        </div>
    </div>

    <!-- 4 KPI Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Rombel Aktif -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-xs font-medium text-slate-500">Total Rombel Aktif</div>
                <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $totalRombelAktif }} Rombel</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Tingkat X, XI, XII</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
        </div>

        <!-- Card 2: Rombel Siap PKL -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-xs font-medium text-slate-500">Rombel Siap PKL</div>
                <div class="text-2xl font-black text-emerald-600 mt-1 leading-tight">{{ $rombelSiapPkl }} Rombel</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Tingkat XII</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
        </div>

        <!-- Card 3: Siswa Terdaftar -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-xs font-medium text-slate-500">Siswa Terdaftar</div>
                <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ number_format($totalSiswaTerdaftar, 0, ',', '.') }} Siswa</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Rata-rata 35–36 siswa/rombel</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 4: Wali Kelas Terpetakan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-xs font-medium text-slate-500">Wali Kelas Terpetakan</div>
                <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $totalWaliKelas }} Guru</div>
                <div class="text-[11px] font-semibold text-emerald-600 mt-1 flex items-center gap-1">
                    <span>✓</span>
                    <span>{{ $persentaseWali }}% Terpenuhi</span>
                </div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter & Action Controls Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs">
        <form action="{{ route('admin.rombel.index') }}" method="GET" id="filterForm" class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            
            <!-- Left Filters: Search + Tingkat + Jurusan -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1">
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
                           placeholder="Cari nama rombel (misal: XII RPL 1), kode rombel..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <!-- Tingkat Dropdown -->
                <div class="relative min-w-[170px]">
                    <select name="tingkat" 
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="all" {{ request('tingkat') == 'all' ? 'selected' : '' }}>Semua Tingkat</option>
                        <option value="XII" {{ request('tingkat', 'XII') == 'XII' ? 'selected' : '' }}>Tingkat XII (PKL)</option>
                        <option value="XI" {{ request('tingkat') == 'XI' ? 'selected' : '' }}>Tingkat XI</option>
                        <option value="X" {{ request('tingkat') == 'X' ? 'selected' : '' }}>Tingkat X</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Program Keahlian / Jurusan Dropdown -->
                <div class="relative min-w-[220px]">
                    <select name="jurusan_id" 
                            onchange="document.getElementById('filterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="all" {{ request('jurusan_id', 'all') == 'all' ? 'selected' : '' }}>Program Keahlian: Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->singkatan ?: $j->kode }} - {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                @if(request('search') || request('tingkat') != 'XII' || (request('jurusan_id') && request('jurusan_id') != 'all'))
                    <a href="{{ route('admin.rombel.index') }}" class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-2">
                        Reset
                    </a>
                @endif
            </div>

            <!-- Right Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <!-- Tambah Rombel Button -->
                <button type="button" 
                        @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition active:scale-98">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>+ Tambah Rombel</span>
                </button>

                <!-- Sinkronisasi Dapodik Button -->
                <button type="button" 
                        @click="syncDapodik()"
                        class="flex items-center gap-2 px-4 py-2.5 bg-[#059669] hover:bg-[#047857] text-white rounded-xl text-xs font-bold shadow-xs transition active:scale-98">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span>Sinkronisasi Dapodik</span>
                </button>

                <!-- Ekspor Excel Button -->
                <a href="{{ route('admin.rombel.export', request()->query()) }}" 
                   class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Ekspor Excel</span>
                </a>
            </div>
        </form>
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
                        <th class="py-3.5 px-4">KODE ROMBEL</th>
                        <th class="py-3.5 px-4">NAMA ROMBEL</th>
                        <th class="py-3.5 px-4">TINGKAT &amp; JURUSAN</th>
                        <th class="py-3.5 px-4">WALI KELAS</th>
                        <th class="py-3.5 px-4">JUMLAH SISWA</th>
                        <th class="py-3.5 px-4">STATUS PKL</th>
                        <th class="py-3.5 pr-6 pl-4 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($rombels as $r)
                        <tr class="hover:bg-slate-50/80 transition group">
                            <!-- Checkbox -->
                            <td class="py-4 pl-5 pr-3">
                                <input type="checkbox" 
                                       value="{{ $r->id }}"
                                       @change="toggleSelect('{{ $r->id }}')"
                                       :checked="selectedIds.includes('{{ $r->id }}')"
                                       class="w-4 h-4 rounded text-blue-600 border-slate-300 focus:ring-blue-500 cursor-pointer">
                            </td>

                            <!-- Kode Rombel -->
                            <td class="py-4 px-4 font-mono font-medium text-slate-700 text-xs">
                                {{ $r->kode_rombel ?: $r->nama_kode }}
                            </td>

                            <!-- Nama Rombel & Ruang -->
                            <td class="py-4 px-4">
                                <div class="font-extrabold text-slate-900 text-[13px] leading-snug">
                                    {{ $r->nama_rombel ?: $r->nama_kode }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    {{ $r->ruang ?: 'Ruang Belajar Utama' }}
                                </div>
                            </td>

                            <!-- Tingkat & Jurusan -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-900 text-xs">
                                    Tingkat {{ $r->tingkat }}
                                </div>
                                <div class="text-[11px] text-slate-500 mt-0.5">
                                    {{ $r->jurusan ? $r->jurusan->nama : '-' }}
                                </div>
                            </td>

                            <!-- Wali Kelas -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-900 text-xs">
                                    {{ $r->waliKelas ? $r->waliKelas->nama : 'Belum Ditugaskan' }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-mono mt-0.5">
                                    NIP: {{ $r->waliKelas ? $r->waliKelas->nip : '-' }}
                                </div>
                            </td>

                            <!-- Jumlah Siswa -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-slate-900 text-xs">
                                    {{ $r->jumlah_siswa }} Siswa
                                </div>
                                <div class="text-[10px] text-emerald-600 font-semibold mt-0.5">
                                    {{ $r->siswa_terdata ?: $r->jumlah_siswa }} Terdata
                                </div>
                            </td>

                            <!-- Status PKL -->
                            <td class="py-4 px-4">
                                @if(str_contains(strtolower($r->status_pkl), 'siap'))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-[#ecfdf5] text-[#059669] border border-emerald-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>{{ $r->status_pkl }}</span>
                                    </span>
                                @elseif(str_contains(strtolower($r->status_pkl), 'sedang'))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        <span>{{ $r->status_pkl }}</span>
                                    </span>
                                @elseif(str_contains(strtolower($r->status_pkl), 'persiapan'))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        <span>{{ $r->status_pkl }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200/80">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        <span>{{ $r->status_pkl }}</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi (Eye, Pencil, Trash) -->
                            <td class="py-4 pr-6 pl-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <!-- View / Detail Button -->
                                    <button type="button" 
                                            @click="openDetailModal({{ $r->toJson() }}, '{{ $r->jurusan ? $r->jurusan->nama : '' }}', '{{ $r->waliKelas ? $r->waliKelas->nama : '' }}', '{{ $r->waliKelas ? $r->waliKelas->nip : '' }}')"
                                            title="Lihat Detail Rombel"
                                            class="p-1.5 text-slate-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <!-- Edit Button -->
                                    <button type="button" 
                                            @click="openEditModal({{ $r->toJson() }})"
                                            title="Edit Rombel"
                                            class="p-1.5 text-slate-400 hover:text-amber-600 rounded-lg hover:bg-amber-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <button type="button" 
                                            @click="confirmDelete('{{ $r->id }}', '{{ $r->nama_rombel ?: $r->nama_kode }}')"
                                            title="Hapus Rombel"
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
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="font-bold text-slate-700 text-sm">Tidak ada data rombel ditemukan</div>
                                <div class="text-xs text-slate-400 mt-1">Silakan ubah filter pencarian atau sinkronisasi dengan Dapodik.</div>
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
                    <strong class="text-slate-800">{{ $rombels->firstItem() ?? 0 }}</strong> - 
                    <strong class="text-slate-800">{{ $rombels->lastItem() ?? 0 }}</strong> dari 
                    <strong class="text-slate-800">{{ $rombels->total() }}</strong> Rombel
                </span>
                <span class="text-slate-300">|</span>
                <div class="flex items-center gap-1.5">
                    <span>Tampilkan:</span>
                    <select onchange="updatePerPage(this.value)" 
                            class="bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="8" {{ request('per_page') == 8 ? 'selected' : '' }}>8 baris per halaman</option>
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 baris per halaman</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris per halaman</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris per halaman</option>
                    </select>
                </div>
            </div>

            <!-- Pagination Numbers -->
            <div class="flex items-center gap-1">
                {{-- Previous Link --}}
                @if ($rombels->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg text-slate-300 font-medium cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $rombels->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold transition">Sebelumnya</a>
                @endif

                {{-- Page Elements --}}
                @foreach ($rombels->getUrlRange(1, $rombels->lastPage()) as $page => $url)
                    @if ($page == $rombels->currentPage())
                        <span class="w-8 h-8 rounded-lg bg-[#0f2942] text-white font-bold flex items-center justify-center shadow-xs">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold flex items-center justify-center transition">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Link --}}
                @if ($rombels->hasMorePages())
                    <a href="{{ $rombels->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold transition">Selanjutnya</a>
                @else
                    <span class="px-3 py-1.5 rounded-lg text-slate-300 font-medium cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Bottom Page Footer Signature -->
    <div class="flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2 pt-2">
        <div>Sistem Informasi Prakerin (SIPRAK) terintegrasi dengan Dapodikdasmen Kemendikbudristek RI</div>
        <div>Terakhir sinkronisasi: Hari ini, 08:30 WIB oleh Endang Supriyatna, S.AP.</div>
    </div>

    <!-- Floating Batch Action Bar -->
    <div x-show="selectedIds.length > 0" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed bottom-8 left-1/2 -translate-x-1/2 bg-[#0f2942] text-white px-5 py-3 rounded-2xl shadow-xl flex items-center gap-4 z-30 border border-slate-700">
        <div class="text-xs font-semibold">
            <span class="text-blue-300 font-bold" x-text="selectedIds.length"></span> rombel dipilih
        </div>
        <div class="h-4 w-px bg-slate-600"></div>
        <button type="button" @click="exportSelected()" class="text-xs font-semibold hover:text-blue-300 flex items-center gap-1.5 transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            <span>Ekspor Pilihan</span>
        </button>
        <button type="button" @click="selectedIds = []" class="text-xs text-slate-400 hover:text-white transition">
            Batal
        </button>
    </div>

    <!-- ==================== MODAL TAMBAH ROMBEL ==================== -->
    <div x-show="isCreateModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="isCreateModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-2xl transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                <form action="{{ route('admin.rombel.store') }}" method="POST">
                    @csrf
                    <div class="p-6 bg-slate-50/70 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900">Tambah Data Rombongan Belajar</h3>
                                <p class="text-xs text-slate-400">Daftarkan kelas rombel baru ke dalam sistem pemetaan PKL</p>
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
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kode Rombel <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       name="kode_rombel" 
                                       required
                                       placeholder="Contoh: RBL-XII-RPL4" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Rombel <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       name="nama_rombel" 
                                       required
                                       placeholder="Contoh: XII RPL 4" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Kelas <span class="text-rose-500">*</span></label>
                                <select name="tingkat" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="XII">Tingkat XII (PKL)</option>
                                    <option value="XI">Tingkat XI</option>
                                    <option value="X">Tingkat X</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Program Keahlian (Jurusan) <span class="text-rose-500">*</span></label>
                                <select name="jurusan_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    @foreach($jurusans as $j)
                                        <option value="{{ $j->id }}">{{ $j->singkatan ?: $j->kode }} - {{ $j->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Ruang Kelas / Laboratorium</label>
                                <input type="text" 
                                       name="ruang" 
                                       placeholder="Contoh: Ruang LAB RPL 04 / Workshop B" 
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Wali Kelas</label>
                                <select name="wali_kelas_guru_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="">-- Pilih Guru Wali Kelas --</option>
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama }} (NIP: {{ $g->nip ?: '-' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kapasitas Siswa <span class="text-rose-500">*</span></label>
                                <input type="number" 
                                       name="jumlah_siswa" 
                                       value="36" 
                                       required min="1" max="50"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Siswa Terdata Saat Ini</label>
                                <input type="number" 
                                       name="siswa_terdata" 
                                       value="36" 
                                       min="0" max="50"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status PKL <span class="text-rose-500">*</span></label>
                                <select name="status_pkl" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="Siap Terjun PKL">Siap Terjun PKL</option>
                                    <option value="Persiapan PKL">Persiapan PKL</option>
                                    <option value="Belum PKL">Belum PKL</option>
                                    <option value="Sedang PKL">Sedang PKL</option>
                                    <option value="Selesai PKL">Selesai PKL</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Aktif Rombel <span class="text-rose-500">*</span></label>
                                <select name="status" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Ajaran <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       name="tahun_ajaran" 
                                       value="2024/2025" 
                                       required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Semester <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       name="semester" 
                                       value="Semester Ganjil" 
                                       required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isCreateModalOpen = false" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Simpan Data Rombel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL EDIT ROMBEL ==================== -->
    <div x-show="isEditModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="isEditModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-2xl transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                <form :action="'{{ url('admin/rombel') }}/' + editData.id" method="POST">
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
                                <h3 class="text-base font-extrabold text-slate-900">Edit Rombongan Belajar</h3>
                                <p class="text-xs text-slate-400">Perbarui informasi rombel <span class="font-bold text-slate-700" x-text="editData.nama_rombel"></span></p>
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
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kode Rombel <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       name="kode_rombel" 
                                       x-model="editData.kode_rombel"
                                       required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Rombel <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       name="nama_rombel" 
                                       x-model="editData.nama_rombel"
                                       required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Kelas <span class="text-rose-500">*</span></label>
                                <select name="tingkat" x-model="editData.tingkat" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="XII">Tingkat XII (PKL)</option>
                                    <option value="XI">Tingkat XI</option>
                                    <option value="X">Tingkat X</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Program Keahlian (Jurusan) <span class="text-rose-500">*</span></label>
                                <select name="jurusan_id" x-model="editData.jurusan_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    @foreach($jurusans as $j)
                                        <option value="{{ $j->id }}">{{ $j->singkatan ?: $j->kode }} - {{ $j->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Ruang Kelas / Laboratorium</label>
                                <input type="text" 
                                       name="ruang" 
                                       x-model="editData.ruang"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Wali Kelas</label>
                                <select name="wali_kelas_guru_id" x-model="editData.wali_kelas_guru_id" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="">-- Pilih Guru Wali Kelas --</option>
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->id }}">{{ $g->nama }} (NIP: {{ $g->nip ?: '-' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kapasitas Siswa <span class="text-rose-500">*</span></label>
                                <input type="number" 
                                       name="jumlah_siswa" 
                                       x-model="editData.jumlah_siswa"
                                       required min="1" max="50"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Siswa Terdata Saat Ini</label>
                                <input type="number" 
                                       name="siswa_terdata" 
                                       x-model="editData.siswa_terdata"
                                       min="0" max="50"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status PKL <span class="text-rose-500">*</span></label>
                                <select name="status_pkl" x-model="editData.status_pkl" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="Siap Terjun PKL">Siap Terjun PKL</option>
                                    <option value="Persiapan PKL">Persiapan PKL</option>
                                    <option value="Belum PKL">Belum PKL</option>
                                    <option value="Sedang PKL">Sedang PKL</option>
                                    <option value="Selesai PKL">Selesai PKL</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Aktif Rombel <span class="text-rose-500">*</span></label>
                                <select name="status" x-model="editData.status" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Ajaran <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       name="tahun_ajaran" 
                                       x-model="editData.tahun_ajaran"
                                       required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Semester <span class="text-rose-500">*</span></label>
                                <input type="text" 
                                       name="semester" 
                                       x-model="editData.semester"
                                       required
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-end gap-3">
                        <button type="button" @click="isEditModalOpen = false" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Perbarui Data Rombel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL DETAIL ROMBEL ==================== -->
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-extrabold text-slate-900" x-text="detailData.nama_rombel || detailData.nama_kode"></h3>
                            <p class="text-xs text-slate-400 font-mono" x-text="detailData.kode_rombel || detailData.nama_kode"></p>
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
                            <span class="text-slate-400 block text-[11px]">Program Keahlian</span>
                            <span class="font-bold text-slate-800" x-text="detailJurusanNama || '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Tingkat</span>
                            <span class="font-bold text-slate-800">Tingkat <span x-text="detailData.tingkat"></span></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Ruang Kelas / Lab</span>
                            <span class="font-bold text-slate-800" x-text="detailData.ruang || '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Status PKL</span>
                            <span class="inline-flex items-center gap-1 font-bold text-emerald-600">
                                <span>•</span>
                                <span x-text="detailData.status_pkl"></span>
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Jumlah Siswa</span>
                            <span class="font-bold text-slate-800"><span x-text="detailData.jumlah_siswa"></span> Siswa (<span x-text="detailData.siswa_terdata"></span> Terdata)</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Tahun Ajaran</span>
                            <span class="font-bold text-slate-800" x-text="detailData.tahun_ajaran + ' (' + (detailData.semester || 'Ganjil') + ')'"></span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white border border-slate-200 flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-slate-100 text-slate-700 font-bold flex items-center justify-center text-sm border border-slate-200 shrink-0">
                            WK
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">WALI KELAS RESMI</div>
                            <div class="font-bold text-slate-900 text-sm truncate" x-text="detailWaliNama || 'Belum Ditentukan'"></div>
                            <div class="text-xs text-slate-500 font-mono" x-text="'NIP: ' + (detailWaliNip || '-')"></div>
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

    <!-- ==================== MODAL KONFIRMASI HAPUS ==================== -->
    <div x-show="isDeleteModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="isDeleteModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all border border-slate-100">
                <form :action="'{{ url('admin/rombel') }}/' + deleteId" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="p-6 text-center">
                        <div class="w-14 h-14 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center mx-auto mb-4 border border-rose-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">Hapus Rombongan Belajar?</h3>
                        <p class="text-xs text-slate-500 mt-2">
                            Apakah Anda yakin ingin menghapus rombel <strong class="text-slate-800" x-text="deleteName"></strong>? Data yang dihapus tidak dapat dipulihkan.
                        </p>
                    </div>

                    <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex items-center justify-center gap-3">
                        <button type="button" @click="isDeleteModalOpen = false" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-xs transition">
                            Ya, Hapus Rombel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function rombelApp() {
        return {
            selectedIds: [],
            allSelected: false,
            isCreateModalOpen: false,
            isEditModalOpen: false,
            isDetailModalOpen: false,
            isDeleteModalOpen: false,
            
            editData: {},
            detailData: {},
            detailJurusanNama: '',
            detailWaliNama: '',
            detailWaliNip: '',

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

            openDetailModal(data, jurusanNama, waliNama, waliNip) {
                this.detailData = Object.assign({}, data);
                this.detailJurusanNama = jurusanNama;
                this.detailWaliNama = waliNama;
                this.detailWaliNip = waliNip;
                this.isDetailModalOpen = true;
            },

            confirmDelete(id, name) {
                this.deleteId = id;
                this.deleteName = name;
                this.isDeleteModalOpen = true;
            },

            syncDapodik() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.rombel.syncDapodik") }}';
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            },

            exportSelected() {
                window.location.href = '{{ route("admin.rombel.export") }}?selected=' + this.selectedIds.join(',');
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
