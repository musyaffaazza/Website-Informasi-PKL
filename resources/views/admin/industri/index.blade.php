@extends('layouts.admin')

@section('title', 'SIPRAK SMKN 1 GUNUNGPUTRI - Master Data Industri & Kemitraan DU/DI')
@section('header_search_placeholder', 'Cari nama mitra industri, PIC, bidang usaha, atau wilayah...')

@section('content')
<div x-data="industriApp()" class="space-y-6">

    <!-- Breadcrumb & Header Section -->
    <div>
        <div class="text-[11px] font-semibold text-slate-400 mb-1.5 flex items-center gap-1.5">
            <span>Pengaturan &amp; Master Data</span>
            <span class="text-slate-300">&gt;</span>
            <span class="text-slate-600">Direktori Kemitraan DU/DI (TA {{ $tahunAjaranAktif }})</span>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-extrabold text-[#0f2942] tracking-tight">
                        Master Data Industri &amp; Mitra DU/DI
                    </h1>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide bg-sky-50 text-sky-700 border border-sky-200 shadow-2xs">
                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        DU/DI RESMI HUBIN TERVERIFIKASI
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1 max-w-3xl leading-relaxed">
                    Direktori kemitraan vokasi resmi SMK Negeri 1 Gunungputri dengan Dunia Usaha &amp; Dunia Industri (DU/DI), kuota penempatan PKL, monitoring MoU, dan pembimbing lapangan.
                </p>
            </div>

            <!-- Top Right Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <!-- Ekspor CSV -->
                <a href="{{ route('admin.industri.export', request()->query()) }}" 
                   class="flex items-center gap-2 px-3.5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Ekspor CSV / MoU</span>
                </a>

                <!-- + Tambah Mitra Industri -->
                <button type="button" 
                        @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition active:scale-98">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>+ Tambah Mitra Industri</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 4 KPI Summary Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Mitra DU/DI -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">TOTAL MITRA DU/DI</div>
                    <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $totalMitra }} Perusahaan</div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">Seluruh Wilayah &amp; Jurusan</span>
                <span class="inline-flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                    <span>•</span> {{ $totalMitra }} Mitra Terdata
                </span>
            </div>
        </div>

        <!-- Card 2: Total Kuota Penerimaan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">TOTAL KUOTA PENERIMAAN</div>
                    <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $totalKuota }} <span class="text-sm font-bold text-slate-500">Kursi</span></div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">Tingkat XII Siap PKL</span>
                <span class="font-semibold text-blue-600">Daya Tampung Maksimal</span>
            </div>
        </div>

        <!-- Card 3: Kapasitas Kuota Terisi -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">KAPASITAS KUOTA TERISI</div>
                    <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $totalTerisi }} / {{ $totalKuota }} <span class="text-sm font-bold text-slate-500">Siswa</span></div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden mb-1.5">
                    <div class="bg-[#059669] h-2 rounded-full transition-all duration-500" style="width: {{ $persenKapasitas }}%"></div>
                </div>
                <div class="flex items-center justify-between text-[11px]">
                    <span class="text-emerald-600 font-bold">{{ $persenKapasitas }}% Kapasitas Terpenuhi</span>
                    <span class="text-slate-400">Sisa: {{ max(0, $totalKuota - $totalTerisi) }} Kursi</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Mitra Kuota Penuh -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">MITRA KUOTA PENUH</div>
                    <div class="text-2xl font-black text-[#d97706] mt-1 leading-tight">{{ $mitraPenuh }} <span class="text-sm font-bold text-slate-500">Industri</span></div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">{{ $kemitraanBaru }} Kemitraan Baru</span>
                <span class="inline-flex items-center gap-1 font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">
                    Siap Plotting
                </span>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 overflow-x-auto pb-px">
        <a href="{{ route('admin.industri.index', array_merge(request()->except('page'), ['tab' => 'all'])) }}"
           class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold border-b-2 transition whitespace-nowrap {{ $tab === 'all' ? 'border-[#0f2942] text-[#0f2942]' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
            <span>Semua Mitra</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $tab === 'all' ? 'bg-[#0f2942] text-white' : 'bg-slate-100 text-slate-600' }}">
                {{ $countSemua }}
            </span>
        </a>

        <a href="{{ route('admin.industri.index', array_merge(request()->except('page'), ['tab' => 'aktif'])) }}"
           class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold border-b-2 transition whitespace-nowrap {{ $tab === 'aktif' ? 'border-[#059669] text-[#059669]' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
            <span>Aktif Tersedia</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $tab === 'aktif' ? 'bg-[#059669] text-white' : 'bg-emerald-50 text-emerald-700 border border-emerald-200' }}">
                {{ $countAktif }}
            </span>
        </a>

        <a href="{{ route('admin.industri.index', array_merge(request()->except('page'), ['tab' => 'penuh'])) }}"
           class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold border-b-2 transition whitespace-nowrap {{ $tab === 'penuh' ? 'border-[#d97706] text-[#d97706]' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
            <span>Kuota Penuh</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $tab === 'penuh' ? 'bg-[#d97706] text-white' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                {{ $countPenuh }}
            </span>
        </a>

        <a href="{{ route('admin.industri.index', array_merge(request()->except('page'), ['tab' => 'perlu_evaluasi'])) }}"
           class="flex items-center gap-2 px-4 py-2.5 text-xs font-bold border-b-2 transition whitespace-nowrap {{ $tab === 'perlu_evaluasi' ? 'border-[#e11d48] text-[#e11d48]' : 'border-transparent text-slate-500 hover:text-slate-800 hover:border-slate-300' }}">
            <span>Perlu Evaluasi</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold {{ $tab === 'perlu_evaluasi' ? 'bg-[#e11d48] text-white' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                {{ $countEvaluasi }}
            </span>
        </a>
    </div>

    <!-- Filters & Action Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs">
        <form action="{{ route('admin.industri.index') }}" method="GET" id="filterForm" class="flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="hidden" name="view_mode" :value="viewMode">

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
                           placeholder="Cari nama PT, bidang usaha, PIC, atau alamat..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <!-- Jurusan Filter -->
                <div class="min-w-[170px]">
                    <select name="jurusan_id" 
                            onchange="this.form.submit()"
                            class="w-full bg-white border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-medium">
                        <option value="all">Semua Konsentrasi</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->kode }} - {{ Str::limit($j->nama, 24) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Wilayah Filter -->
                <div class="min-w-[140px]">
                    <select name="wilayah" 
                            onchange="this.form.submit()"
                            class="w-full bg-white border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-medium">
                        <option value="all">Semua Wilayah</option>
                        @foreach($wilayahList as $w)
                            <option value="{{ $w }}" {{ request('wilayah') == $w ? 'selected' : '' }}>
                                Wilayah {{ $w }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort Filter -->
                <div class="min-w-[150px]">
                    <select name="sort" 
                            onchange="this.form.submit()"
                            class="w-full bg-white border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-medium">
                        <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama Mitra (A - Z)</option>
                        <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Mitra (Z - A)</option>
                        <option value="kuota_desc" {{ request('sort') == 'kuota_desc' ? 'selected' : '' }}>Kuota Terbanyak</option>
                        <option value="kuota_tersedia" {{ request('sort') == 'kuota_tersedia' ? 'selected' : '' }}>Sisa Kursi Terbanyak</option>
                    </select>
                </div>

                <!-- Reset Button -->
                @if(request()->hasAny(['search', 'jurusan_id', 'wilayah', 'sort']) && (request('search') || request('jurusan_id') !== 'all' || request('wilayah') !== 'all' || request('sort') !== 'nama_asc'))
                <a href="{{ route('admin.industri.index', ['tab' => $tab]) }}" 
                   class="flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Reset</span>
                </a>
                @endif
            </div>

            <!-- Right Controls: View Switcher (Grid / Table) -->
            <div class="flex items-center gap-2 self-end xl:self-auto shrink-0">
                <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200">
                    <button type="button" 
                            @click="setViewMode('grid')"
                            :class="viewMode === 'grid' ? 'bg-white text-[#0f2942] shadow-xs' : 'text-slate-400 hover:text-slate-700'"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>Grid</span>
                    </button>
                    <button type="button" 
                            @click="setViewMode('table')"
                            :class="viewMode === 'table' ? 'bg-white text-[#0f2942] shadow-xs' : 'text-slate-400 hover:text-slate-700'"
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        <span>Tabel</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- ==================== MAIN CONTENT: GRID OR TABLE ==================== -->

    <!-- VIEW 1: GRID CARDS (Default) -->
    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse($industris as $ind)
        @php
            $sisaKuota = max(0, $ind->kuota - $ind->kuota_terisi);
            $persenInd = $ind->kuota > 0 ? min(100, round(($ind->kuota_terisi / $ind->kuota) * 100)) : 0;
            
            // Status Tag Info
            $isPenuh = $ind->kuota_terisi >= $ind->kuota || $ind->status_kemitraan === 'penuh';
            $isEvaluasi = $ind->status_kemitraan === 'perlu_evaluasi';
            $isBaru = $ind->status_kemitraan === 'baru';
            
            $statusBadgeClass = match(true) {
                $isEvaluasi => 'bg-rose-50 text-rose-700 border-rose-200',
                $isPenuh => 'bg-amber-50 text-amber-700 border-amber-200',
                $isBaru => 'bg-blue-50 text-blue-700 border-blue-200',
                default => 'bg-emerald-50 text-emerald-700 border-emerald-200'
            };

            $statusText = match(true) {
                $isEvaluasi => 'PERLU EVALUASI',
                $isPenuh => 'KUOTA PENUH',
                $isBaru => 'MITRA BARU',
                default => 'AKTIF TERSEDIA'
            };

            $barColor = match(true) {
                $isEvaluasi => 'bg-rose-500',
                $isPenuh => 'bg-amber-500',
                $persenInd >= 80 => 'bg-blue-600',
                default => 'bg-emerald-500'
            };
        @endphp

        <!-- Single Industri Card -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-5 shadow-2xs hover:shadow-md transition duration-200 flex flex-col justify-between">
            <div>
                <!-- Top Card Header -->
                <div class="flex items-start justify-between gap-3 mb-4">
                    <div class="flex items-start gap-3 min-w-0">
                        <!-- Company Avatar / Initials -->
                        <div class="w-12 h-12 rounded-xl bg-[#0f2942] text-white font-extrabold text-sm tracking-wider flex items-center justify-center shrink-0 shadow-xs">
                            {{ $ind->initials }}
                        </div>

                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-900 text-sm leading-snug truncate" title="{{ $ind->nama }}">
                                {{ $ind->nama }}
                            </h3>
                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                <span class="text-[11px] font-semibold text-slate-500">
                                    {{ $ind->bidang_usaha ?: 'Industri & Teknologi' }}
                                </span>
                                <span class="text-slate-300">•</span>
                                <span class="text-[11px] font-medium text-slate-400">
                                    {{ $ind->wilayah ?: 'Bogor' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Pill -->
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-extrabold border shrink-0 {{ $statusBadgeClass }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $isPenuh ? 'bg-amber-500' : ($isEvaluasi ? 'bg-rose-500' : 'bg-emerald-500') }}"></span>
                        <span>{{ $statusText }}</span>
                    </span>
                </div>

                <!-- Info Grid / Stack -->
                <div class="space-y-3 pt-1 border-t border-slate-100">
                    <!-- Row 1: Nomor MoU & Masa Berlaku -->
                    <div class="flex items-start gap-2.5 pt-2">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div class="min-w-0 flex-1">
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                NO. MOU &amp; MASA BERLAKU
                            </div>
                            <div class="text-xs font-semibold text-slate-800 mt-0.5 truncate" title="{{ $ind->no_mou ?: '421.5/MOU-DUDI/SMKELL/2024' }}">
                                {{ $ind->no_mou ?: '421.5/MOU-DUDI/SMKELL/2024' }}
                            </div>
                            <div class="text-[10px] text-slate-400 mt-0.5">
                                Berlaku s/d: <span class="font-medium text-slate-600">{{ $ind->mou_berlaku_sampai ? $ind->mou_berlaku_sampai->format('d F Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Alamat & Wilayah -->
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div class="min-w-0 flex-1">
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                ALAMAT &amp; KAWASAN
                            </div>
                            <div class="text-xs text-slate-700 mt-0.5 line-clamp-1" title="{{ $ind->alamat }}">
                                {{ $ind->alamat ?: 'Kawasan Industri Sentul, Bogor, Jawa Barat' }}
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Jurusan Afiliasi PKL -->
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"/>
                        </svg>
                        <div class="min-w-0 flex-1">
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                KONSENTRASI KEAHLIAN / JURUSAN
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($ind->jurusans as $jur)
                                @php
                                    $jkode = strtoupper($jur->kode);
                                    $jtagColor = match($jkode) {
                                        'RPL' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'TOI' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'TP'  => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'KA'  => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'TPL' => 'bg-orange-50 text-orange-700 border-orange-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200'
                                    };
                                @endphp
                                <span class="inline-block px-2 py-0.5 text-[10px] font-bold rounded-lg border {{ $jtagColor }}">
                                    {{ $jur->kode }}
                                </span>
                                @empty
                                <span class="text-[11px] text-slate-400 italic">Semua Jurusan Terkait</span>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: PIC / Kontak Mentor -->
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <div class="min-w-0 flex-1">
                            <div class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                PIC &amp; MENTOR INDUSTRI
                            </div>
                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                <span class="text-xs font-bold text-slate-900">{{ $ind->kontak_nama }}</span>
                                @if($ind->kontak_jabatan)
                                <span class="text-[10px] text-slate-500 font-medium">({{ $ind->kontak_jabatan }})</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap items-center gap-3 text-[11px] text-slate-500 mt-1">
                                <a href="tel:{{ $ind->kontak_no_hp }}" class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $ind->kontak_no_hp }}</span>
                                </a>
                                <span>•</span>
                                <a href="mailto:{{ $ind->kontak_email }}" class="inline-flex items-center gap-1 text-slate-600 hover:text-blue-600 truncate max-w-[200px]" title="{{ $ind->kontak_email }}">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="truncate">{{ $ind->kontak_email }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Row 5: Kuota & Kapasitas Progress Bar -->
                    <div class="pt-2 bg-slate-50/80 p-3 rounded-xl border border-slate-100">
                        <div class="flex items-center justify-between text-xs mb-1.5">
                            <span class="text-slate-600 font-semibold">Kapasitas Kuota PKL:</span>
                            <span class="font-extrabold text-slate-900">{{ $ind->kuota_terisi }} / {{ $ind->kuota }} Siswa</span>
                        </div>
                        <div class="w-full bg-slate-200/80 rounded-full h-2 overflow-hidden">
                            <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500" style="width: {{ $persenInd }}%;"></div>
                        </div>
                        <div class="flex items-center justify-between text-[11px] mt-1.5">
                            @if($isPenuh)
                            <span class="font-bold text-amber-600">Kuota Terisi Penuh</span>
                            @else
                            <span class="font-bold text-emerald-600">Sisa {{ $sisaKuota }} Kursi Tersedia</span>
                            @endif
                            <span class="text-slate-400">{{ $persenInd }}% Terisi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Bottom Action Buttons -->
            <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between gap-2">
                <button type="button" 
                        @click="openKuotaModal({{ json_encode($ind) }})"
                        class="py-2 px-3 bg-white hover:bg-slate-50 text-slate-700 text-center text-xs font-semibold border border-slate-200 rounded-xl shadow-2xs transition active:scale-98 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    <span>Ubah Kuota</span>
                </button>

                <div class="flex items-center gap-2">
                    <button type="button" 
                            @click="openEditModal({{ json_encode($ind->load('jurusans')) }})"
                            class="py-2 px-3.5 bg-white hover:bg-blue-50 text-blue-600 text-center text-xs font-semibold border border-slate-200 rounded-xl shadow-2xs transition active:scale-98">
                        Edit
                    </button>

                    <button type="button" 
                            @click="openDetailModal({{ json_encode($ind->load(['jurusans', 'pembimbingGuru'])) }})"
                            class="py-2 px-4 bg-[#0f2942] hover:bg-[#1a385c] text-white text-center text-xs font-bold rounded-xl shadow-2xs transition active:scale-98">
                        Detail
                    </button>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-span-full bg-white rounded-2xl border border-slate-200/80 p-12 text-center shadow-2xs">
            <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-slate-800">Tidak ada data mitra industri ditemukan</h3>
            <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                Coba sesuaikan kata kunci pencarian, filter jurusan, atau filter wilayah yang dipilih.
            </p>
            <div class="mt-5 flex items-center justify-center gap-3">
                <a href="{{ route('admin.industri.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                    Reset Filter
                </a>
                <button type="button" @click="openCreateModal()" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs transition">
                    + Tambah Mitra Baru
                </button>
            </div>
        </div>
        @endforelse
    </div>

    <!-- VIEW 2: TABLE VIEW -->
    <div x-show="viewMode === 'table'" class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">No</th>
                        <th class="py-3.5 px-4">Perusahaan &amp; Bidang</th>
                        <th class="py-3.5 px-4">Wilayah &amp; MoU</th>
                        <th class="py-3.5 px-4">Jurusan</th>
                        <th class="py-3.5 px-4">PIC / Kontak</th>
                        <th class="py-3.5 px-4 text-center">Kuota &amp; Terisi</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($industris as $index => $ind)
                    @php
                        $sisaKuota = max(0, $ind->kuota - $ind->kuota_terisi);
                        $persenInd = $ind->kuota > 0 ? min(100, round(($ind->kuota_terisi / $ind->kuota) * 100)) : 0;
                        $isPenuh = $ind->kuota_terisi >= $ind->kuota || $ind->status_kemitraan === 'penuh';
                        $isEvaluasi = $ind->status_kemitraan === 'perlu_evaluasi';
                        $isBaru = $ind->status_kemitraan === 'baru';
                        
                        $statusBadgeClass = match(true) {
                            $isEvaluasi => 'bg-rose-50 text-rose-700 border-rose-200',
                            $isPenuh => 'bg-amber-50 text-amber-700 border-amber-200',
                            $isBaru => 'bg-blue-50 text-blue-700 border-blue-200',
                            default => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                        };

                        $statusText = match(true) {
                            $isEvaluasi => 'Evaluasi',
                            $isPenuh => 'Penuh',
                            $isBaru => 'Baru',
                            default => 'Aktif'
                        };
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="py-3.5 px-4 font-bold text-slate-400">
                            {{ ($industris->currentPage() - 1) * $industris->perPage() + $index + 1 }}
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#0f2942] text-white font-extrabold text-xs flex items-center justify-center shrink-0">
                                    {{ $ind->initials }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900">{{ $ind->nama }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $ind->bidang_usaha ?: 'Industri' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-slate-800">{{ $ind->wilayah ?: 'Bogor' }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">{{ $ind->no_mou ?: '-' }}</div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="flex flex-wrap gap-1 max-w-[150px]">
                                @foreach($ind->jurusans as $jur)
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ $jur->kode }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-slate-800">{{ $ind->kontak_nama }}</div>
                            <div class="text-[10px] text-slate-400">{{ $ind->kontak_no_hp }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="font-extrabold text-slate-900">{{ $ind->kuota_terisi }} / {{ $ind->kuota }}</div>
                            <div class="text-[10px] font-bold {{ $isPenuh ? 'text-amber-600' : 'text-emerald-600' }}">
                                {{ $isPenuh ? 'Penuh' : 'Sisa ' . $sisaKuota }}
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $statusBadgeClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button" 
                                        @click="openDetailModal({{ json_encode($ind->load(['jurusans', 'pembimbingGuru'])) }})"
                                        class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition" 
                                        title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>

                                <button type="button" 
                                        @click="openEditModal({{ json_encode($ind->load('jurusans')) }})"
                                        class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition" 
                                        title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <button type="button" 
                                        @click="openKuotaModal({{ json_encode($ind) }})"
                                        class="p-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 transition" 
                                        title="Ubah Kuota">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-slate-400 text-xs">
                            Tidak ada data mitra industri yang sesuai dengan filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom Information & Pagination Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
            <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>
                Menampilkan <span class="font-bold text-slate-900">{{ $industris->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-900">{{ $industris->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-900">{{ $industris->total() }}</span> mitra industri DU/DI
            </span>
        </div>

        <!-- Pagination Links -->
        <div>
            {{ $industris->links() }}
        </div>
    </div>

    <!-- ==================== MODALS ==================== -->

    <!-- Modal 1: Tambah Mitra Industri -->
    <div x-show="createModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="createModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form action="{{ route('admin.industri.store') }}" method="POST">
                    @csrf
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Tambah Mitra Industri (DU/DI) Baru</h3>
                                    <p class="text-xs text-slate-400">Masukkan profil perusahaan, kontak PIC, dan kapasitas kuota PKL</p>
                                </div>
                            </div>
                            <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <!-- Form Fields Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <!-- Nama Industri -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Perusahaan / DU-DI *</label>
                                <input type="text" name="nama" required placeholder="Contoh: PT Astra Honda Motor" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Bidang Usaha -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Bidang Usaha *</label>
                                <input type="text" name="bidang_usaha" required placeholder="Contoh: Otomotif & Manufaktur" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Wilayah -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Wilayah / Kota *</label>
                                <select name="wilayah" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    @foreach($wilayahList as $w)
                                    <option value="{{ $w }}">{{ $w }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap Kantor / Pabrik *</label>
                                <textarea name="alamat" rows="2" required placeholder="Kawasan Industri, nama jalan, no gedung..." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></textarea>
                            </div>

                            <!-- No MoU -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor MoU Kemitraan</label>
                                <input type="text" name="no_mou" placeholder="Contoh: 421.5/MOU-DUDI/SMKELL/2024/020" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Masa Berlaku MoU -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Masa Berlaku MoU Sampai</label>
                                <input type="date" name="mou_berlaku_sampai" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Jurusan Afiliasi Checkboxes -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Program Keahlian Terkait (PKL)</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                    @foreach($jurusans as $j)
                                    <label class="flex items-center gap-2 text-xs text-slate-700 font-medium cursor-pointer">
                                        <input type="checkbox" name="jurusan_ids[]" value="{{ $j->id }}" class="rounded text-blue-600 focus:ring-blue-500 h-4 w-4">
                                        <span>{{ $j->kode }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Kontak PIC Nama -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama PIC / Mentor Lapangan *</label>
                                <input type="text" name="kontak_nama" required placeholder="Contoh: Hendra Gunawan, S.T." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Kontak Jabatan -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan PIC</label>
                                <input type="text" name="kontak_jabatan" placeholder="Contoh: Head of HR & Training" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- No HP / WA -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">No. HP / WhatsApp *</label>
                                <input type="text" name="kontak_no_hp" required placeholder="+62 812-xxxx-xxxx" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Email PIC -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi PIC *</label>
                                <input type="email" name="kontak_email" required placeholder="hrd@perusahaan.co.id" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Total Kuota -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Total Kuota Penerimaan Siswa *</label>
                                <input type="number" name="kuota" required value="6" min="1" max="50" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Kuota Terisi -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kuota Terisi Saat Ini</label>
                                <input type="number" name="kuota_terisi" value="0" min="0" max="50" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Pembimbing Sekolah -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Pembimbing Sekolah</label>
                                <input type="text" name="pembimbing_nama" placeholder="Contoh: Ir. Dian Hendrawan, M.T." class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Status Kemitraan -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Kemitraan *</label>
                                <select name="status_kemitraan" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="aktif" selected>Aktif Tersedia</option>
                                    <option value="penuh">Kuota Penuh</option>
                                    <option value="baru">Kemitraan Baru</option>
                                    <option value="perlu_evaluasi">Perlu Evaluasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="createModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Simpan Mitra Industri
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 2: Detail Mitra Industri -->
    <div x-show="detailModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="detailModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#0f2942] text-white font-black text-sm flex items-center justify-center shrink-0 shadow-xs"
                                 x-text="activeIndustri?.initials || 'PT'">
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-lg" x-text="activeIndustri?.nama"></h3>
                                <div class="text-xs text-slate-500 mt-0.5" x-text="(activeIndustri?.bidang_usaha || '') + ' • Wilayah ' + (activeIndustri?.wilayah || 'Bogor')"></div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase bg-emerald-50 text-emerald-700 border border-emerald-200"
                                  x-text="activeIndustri?.status_kemitraan?.replace('_', ' ') || 'Aktif'"></span>
                            <button type="button" @click="detailModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold ml-2">&times;</button>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                        <!-- Box 1: Legalitas & MoU -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                LEGALITAS &amp; DOKUMEN MOU
                            </div>
                            <div class="text-xs font-bold text-slate-900" x-text="activeIndustri?.no_mou || '421.5/MOU-DUDI/SMKELL/2024'"></div>
                            <div class="text-[11px] text-slate-500 mt-1">
                                Masa Berlaku: <span class="font-semibold text-slate-800" x-text="activeIndustri?.mou_berlaku_sampai ? new Date(activeIndustri.mou_berlaku_sampai).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-'"></span>
                            </div>
                            <div class="text-[11px] text-emerald-600 font-semibold mt-0.5">
                                Status Dokumen: MoU Terdaftar Resmi
                            </div>
                        </div>

                        <!-- Box 2: Kuota & Kapasitas -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                KUOTA &amp; KETERSEDIAAN SISWA
                            </div>
                            <div class="text-xs font-bold text-slate-900">
                                <span x-text="activeIndustri?.kuota_terisi || 0"></span> / <span x-text="activeIndustri?.kuota || 0"></span> Siswa Terplotting
                            </div>
                            <div class="text-[11px] text-emerald-600 font-semibold mt-1">
                                Sisa Kursi Tersedia: <span x-text="Math.max(0, (activeIndustri?.kuota || 0) - (activeIndustri?.kuota_terisi || 0))"></span> Siswa
                            </div>
                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Keterisian: <span class="font-bold" x-text="activeIndustri?.kuota > 0 ? Math.round(((activeIndustri.kuota_terisi || 0) / activeIndustri.kuota) * 100) + '%' : '0%'"></span>
                            </div>
                        </div>

                        <!-- Box 3: PIC & Kontak Mentor -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                PIC &amp; MENTOR INDUSTRI
                            </div>
                            <div class="text-xs font-bold text-slate-900" x-text="activeIndustri?.kontak_nama"></div>
                            <div class="text-[11px] text-slate-500 mt-0.5" x-text="activeIndustri?.kontak_jabatan || 'Pembimbing Teknis'"></div>
                            <div class="text-[11px] text-blue-600 font-medium mt-1" x-text="'WA/Tel: ' + activeIndustri?.kontak_no_hp"></div>
                            <div class="text-[11px] text-slate-500" x-text="'Email: ' + activeIndustri?.kontak_email"></div>
                        </div>

                        <!-- Box 4: Pembimbing Sekolah & Alamat -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                PEMBIMBING SEKOLAH &amp; LOKASI
                            </div>
                            <div class="text-xs font-bold text-slate-900" x-text="activeIndustri?.pembimbing_nama || 'Tim Hubin SMKN 1'"></div>
                            <div class="text-[11px] text-slate-500 mt-1" x-text="activeIndustri?.alamat"></div>
                        </div>

                        <!-- Box 5: Jurusan Afiliasi -->
                        <div class="sm:col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">
                                KONSENTRASI KEAHLIAN / JURUSAN TERKAIT
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="j in (activeIndustri?.jurusans || [])" :key="j.id">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 text-slate-800 text-xs font-medium rounded-lg shadow-2xs">
                                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                        <span class="font-bold" x-text="j.kode"></span>
                                        <span class="text-slate-500" x-text="'- ' + j.nama"></span>
                                    </span>
                                </template>
                                <span x-show="!activeIndustri?.jurusans?.length" class="text-xs text-slate-400 italic">Menerima seluruh program keahlian.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-slate-50 px-6 py-4 flex flex-wrap items-center justify-between gap-3 border-t border-slate-100">
                    <!-- Hapus Mitra Form -->
                    <form :action="'/admin/industri/' + activeIndustri?.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra industri ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center gap-1.5 px-3.5 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-xs font-bold rounded-xl transition shadow-2xs">
                            <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            <span>Hapus Mitra</span>
                        </button>
                    </form>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="openEditModal(activeIndustri)" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Edit Data
                        </button>
                        <button type="button" @click="detailModalOpen = false" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3: Edit Mitra Industri -->
    <div x-show="editModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="editModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form :action="'/admin/industri/' + editForm.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Edit Mitra Industri DU/DI</h3>
                                    <p class="text-xs text-slate-400">Perbarui informasi profil perusahaan, kuota, dan kontak PIC</p>
                                </div>
                            </div>
                            <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <!-- Form Fields Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <!-- Nama Industri -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Perusahaan / DU-DI *</label>
                                <input type="text" name="nama" x-model="editForm.nama" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Bidang Usaha -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Bidang Usaha *</label>
                                <input type="text" name="bidang_usaha" x-model="editForm.bidang_usaha" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Wilayah -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Wilayah / Kota *</label>
                                <select name="wilayah" x-model="editForm.wilayah" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    @foreach($wilayahList as $w)
                                    <option value="{{ $w }}">{{ $w }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap Kantor / Pabrik *</label>
                                <textarea name="alamat" rows="2" x-model="editForm.alamat" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"></textarea>
                            </div>

                            <!-- No MoU -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nomor MoU Kemitraan</label>
                                <input type="text" name="no_mou" x-model="editForm.no_mou" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Masa Berlaku MoU -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Masa Berlaku MoU Sampai</label>
                                <input type="date" name="mou_berlaku_sampai" x-model="editForm.mou_berlaku_sampai" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Jurusan Afiliasi Checkboxes -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-1">Program Keahlian Terkait (PKL)</label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                                    @foreach($jurusans as $j)
                                    <label class="flex items-center gap-2 text-xs text-slate-700 font-medium cursor-pointer">
                                        <input type="checkbox" 
                                               name="jurusan_ids[]" 
                                               value="{{ $j->id }}" 
                                               :checked="editForm.jurusan_ids.includes({{ $j->id }})"
                                               @change="toggleJurusanEdit({{ $j->id }})"
                                               class="rounded text-blue-600 focus:ring-blue-500 h-4 w-4">
                                        <span>{{ $j->kode }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Kontak PIC Nama -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Nama PIC / Mentor Lapangan *</label>
                                <input type="text" name="kontak_nama" x-model="editForm.kontak_nama" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Kontak Jabatan -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan PIC</label>
                                <input type="text" name="kontak_jabatan" x-model="editForm.kontak_jabatan" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- No HP / WA -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">No. HP / WhatsApp *</label>
                                <input type="text" name="kontak_no_hp" x-model="editForm.kontak_no_hp" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Email PIC -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi PIC *</label>
                                <input type="email" name="kontak_email" x-model="editForm.kontak_email" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Total Kuota -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Total Kuota Penerimaan Siswa *</label>
                                <input type="number" name="kuota" x-model="editForm.kuota" required min="1" max="50" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Kuota Terisi -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Kuota Terisi Saat Ini</label>
                                <input type="number" name="kuota_terisi" x-model="editForm.kuota_terisi" min="0" max="50" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Pembimbing Sekolah -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Pembimbing Sekolah</label>
                                <input type="text" name="pembimbing_nama" x-model="editForm.pembimbing_nama" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <!-- Status Kemitraan -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Status Kemitraan *</label>
                                <select name="status_kemitraan" x-model="editForm.status_kemitraan" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="aktif">Aktif Tersedia</option>
                                    <option value="penuh">Kuota Penuh</option>
                                    <option value="baru">Kemitraan Baru</option>
                                    <option value="perlu_evaluasi">Perlu Evaluasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
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

    <!-- Modal 4: Sesuaikan Kapasitas Kuota Cepat -->
    <div x-show="kuotaModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="kuotaModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form :action="'/admin/industri/' + activeKuotaIndustri?.id + '/update-kuota'" method="POST">
                    @csrf
                    <div class="p-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Sesuaikan Kuota Siswa</h3>
                                    <p class="text-xs text-slate-400" x-text="activeKuotaIndustri?.nama"></p>
                                </div>
                            </div>
                            <button type="button" @click="kuotaModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <div class="space-y-4 mt-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Total Daya Tampung Kuota (Siswa) *</label>
                                <input type="number" 
                                       name="kuota" 
                                       x-model="kuotaForm.kuota"
                                       required 
                                       min="1" 
                                       max="100" 
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Kuota Terisi Saat Ini *</label>
                                <input type="number" 
                                       name="kuota_terisi" 
                                       x-model="kuotaForm.kuota_terisi"
                                       required 
                                       min="0" 
                                       max="100" 
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>

                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-xs flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Sisa Kursi Tersedia:</span>
                                <span class="font-bold text-emerald-600" x-text="Math.max(0, (kuotaForm.kuota || 0) - (kuotaForm.kuota_terisi || 0)) + ' Siswa'"></span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="kuotaModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Simpan Kuota
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function industriApp() {
    return {
        viewMode: '{{ $viewMode ?? "grid" }}',
        createModalOpen: false,
        detailModalOpen: false,
        editModalOpen: false,
        kuotaModalOpen: false,

        activeIndustri: null,
        activeKuotaIndustri: null,

        kuotaForm: {
            kuota: 0,
            kuota_terisi: 0,
        },

        editForm: {
            id: null,
            nama: '',
            bidang_usaha: '',
            wilayah: 'Bogor',
            alamat: '',
            no_mou: '',
            mou_berlaku_sampai: '',
            kontak_nama: '',
            kontak_jabatan: '',
            kontak_no_hp: '',
            kontak_email: '',
            kuota: 6,
            kuota_terisi: 0,
            pembimbing_nama: '',
            status_kemitraan: 'aktif',
            jurusan_ids: [],
        },

        setViewMode(mode) {
            this.viewMode = mode;
        },

        openCreateModal() {
            this.createModalOpen = true;
        },

        openDetailModal(industri) {
            this.activeIndustri = industri;
            this.detailModalOpen = true;
        },

        openEditModal(industri) {
            this.detailModalOpen = false;
            let jIds = [];
            if (industri.jurusans && Array.isArray(industri.jurusans)) {
                jIds = industri.jurusans.map(j => j.id);
            }

            let dateFormatted = '';
            if (industri.mou_berlaku_sampai) {
                dateFormatted = industri.mou_berlaku_sampai.substring(0, 10);
            }

            this.editForm = {
                id: industri.id,
                nama: industri.nama || '',
                bidang_usaha: industri.bidang_usaha || '',
                wilayah: industri.wilayah || 'Bogor',
                alamat: industri.alamat || '',
                no_mou: industri.no_mou || '',
                mou_berlaku_sampai: dateFormatted,
                kontak_nama: industri.kontak_nama || '',
                kontak_jabatan: industri.kontak_jabatan || '',
                kontak_no_hp: industri.kontak_no_hp || '',
                kontak_email: industri.kontak_email || '',
                kuota: industri.kuota || 6,
                kuota_terisi: industri.kuota_terisi || 0,
                pembimbing_nama: industri.pembimbing_nama || '',
                status_kemitraan: industri.status_kemitraan || 'aktif',
                jurusan_ids: jIds,
            };
            this.editModalOpen = true;
        },

        toggleJurusanEdit(id) {
            const index = this.editForm.jurusan_ids.indexOf(id);
            if (index > -1) {
                this.editForm.jurusan_ids.splice(index, 1);
            } else {
                this.editForm.jurusan_ids.push(id);
            }
        },

        openKuotaModal(industri) {
            this.activeKuotaIndustri = industri;
            this.kuotaForm = {
                kuota: industri.kuota || 0,
                kuota_terisi: industri.kuota_terisi || 0,
            };
            this.kuotaModalOpen = true;
        }
    };
}
</script>
@endpush
