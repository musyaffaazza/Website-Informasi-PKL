@extends('layouts.kaprog')

@section('title', 'Penempatan Industri — Rekayasa Perangkat Lunak | SIPRAK')

@section('content')
<div x-data="{
    openModalTambah: false,
    perPage: '{{ $perPage ?? 16 }}'
}">
    <!-- Top Breadcrumb & Page Header -->
    <div class="mb-6">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-1.5 text-xs font-semibold text-slate-400 mb-2">
            <span class="text-sky-600 hover:underline cursor-pointer">Kaprog RPL</span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-500">Penempatan Siswa</span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-800 font-bold">Penempatan Industri (Jurusan RPL)</span>
        </nav>

        <!-- Main Title & Top Action Buttons -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                    Penempatan Industri — Jurusan RPL
                </h1>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed max-w-3xl">
                    Monitoring kuota dan distribusi penempatan {{ $totalSiswa }} siswa lintas {{ $totalMitra }} mitra industri DU/DI.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5 shrink-0">
                <a href="{{ route('kaprog.penempatan-industri.export') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition shadow-2xs">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Ekspor Rekap Penempatan</span>
                </a>

                <button type="button"
                        @click="openModalTambah = true"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-xs">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Tambah Kuota Industri</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 4 Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card 1: TOTAL MITRA DU/DI -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        TOTAL MITRA DU/DI
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalMitra }}</span>
                    <span class="text-xs font-bold text-slate-400">Perusahaan</span>
                </div>
                <div class="text-xs text-slate-500 font-medium flex items-center gap-1.5 mt-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                    <span>{{ $aktifMitra }} Aktif • {{ $mouBaruMitra }} MoU Baru</span>
                </div>
            </div>
        </div>

        <!-- Card 2: KAPASITAS KUOTA -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        KAPASITAS KUOTA
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalKapasitas }}</span>
                    <span class="text-xs font-bold text-slate-400">Kursi</span>
                </div>
                <div class="text-xs text-slate-400 font-medium mt-2 truncate">
                    Total daya tampung kejuruan RPL
                </div>
            </div>
        </div>

        <!-- Card 3: SISWA TERPLOT -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        SISWA TERPLOT
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline justify-between gap-2 mt-2">
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalTerisi }}</span>
                        <span class="text-xs font-bold text-slate-400">/ {{ $totalSiswa }} Siswa</span>
                    </div>
                    <span class="text-xs font-bold text-sky-600">{{ $terplotPercent }}%</span>
                </div>
                <!-- Progress Line -->
                <div class="w-full bg-slate-100 h-1.5 rounded-full mt-2 overflow-hidden">
                    <div class="bg-sky-500 h-full rounded-full" style="width: {{ $terplotPercent }}%;"></div>
                </div>
                <div class="text-xs text-slate-500 font-medium mt-2">
                    {{ $siswaSeleksi }} siswa dalam proses seleksi
                </div>
            </div>
        </div>

        <!-- Card 4: MITRA KUOTA PENUH -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        MITRA KUOTA PENUH
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-[#064e3b] text-[#34d399] flex items-center justify-center shrink-0 shadow-2xs">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $mitraPenuhCount }}</span>
                    <span class="text-xs font-bold text-slate-400">Perusahaan</span>
                </div>
                <div class="text-xs text-slate-400 font-medium mt-2">
                    Mencapai batas kuota bimbingan
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-3.5 sm:p-4 mb-4 shadow-2xs">
        <form action="{{ route('kaprog.penempatan-industri.index') }}" method="GET" class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3">
            <!-- Search input -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama mitra industri, kota/alamat, atau keahlian..."
                       class="w-full h-11 pl-10 pr-4 bg-slate-50/70 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
            </div>

            <!-- Dropdown: Urutan -->
            @php
                $sortOptions = [
                    'penuh' => 'Kuota Paling Penuh',
                    'tersedia' => 'Kuota Tersedia',
                    'kuota_terbanyak' => 'Kapasitas Terbanyak',
                    'nama' => 'Nama Perusahaan (A-Z)',
                ];
                $sortLabel = 'Urutkan: ' . ($sortOptions[request('sort', 'penuh')] ?? 'Kuota Paling Penuh');
            @endphp
            <div class="relative w-full lg:w-56" x-data="{ open: false }">
                <input type="hidden" name="sort" id="input_sort" value="{{ request('sort', 'penuh') }}">
                <button type="button" 
                        @click="open = !open" 
                        class="w-full h-11 pl-3.5 pr-8 bg-slate-50/70 border {{ request('sort') && request('sort') != 'penuh' ? 'border-sky-300 bg-sky-50/90 text-sky-900 font-bold ring-1 ring-sky-300/50' : 'border-slate-200 text-slate-700 font-semibold' }} rounded-xl text-xs flex items-center justify-between transition focus:outline-none hover:bg-slate-100/70 shadow-2xs">
                    <span class="truncate">{{ $sortLabel }}</span>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </button>
                <div x-show="open" 
                     @click.outside="open = false" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute left-0 mt-1.5 w-60 max-h-64 overflow-y-auto bg-white rounded-2xl border border-slate-200/90 shadow-xl z-50 p-1.5 space-y-0.5">
                    <div class="px-2.5 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Urutan Data</div>
                    @foreach($sortOptions as $sKey => $sTitle)
                        <button type="button" 
                                @click="document.getElementById('input_sort').value = '{{ $sKey }}'; $el.closest('form').submit();"
                                class="w-full text-left px-2.5 py-2 rounded-xl text-xs flex items-center justify-between transition {{ request('sort', 'penuh') == $sKey ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span class="truncate">{{ $sTitle }}</span>
                            @if(request('sort', 'penuh') == $sKey)
                                <svg class="w-4 h-4 text-blue-600 shrink-0 ml-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Dropdown: Sektor -->
            @php
                $sektorList = [
                    'Software House',
                    'Telekomunikasi',
                    'Cloud Platform',
                    'Automotive' => 'Automotive & IoT',
                    'Fintech' => 'Fintech & Banking',
                    'E-Commerce',
                    'Healthcare' => 'Healthcare IT',
                    'Game' => 'Game Development',
                ];
                $sektorVal = request('sektor');
                $sektorDisplay = 'Semua Sektor';
                if ($sektorVal) {
                    $sektorDisplay = $sektorList[$sektorVal] ?? $sektorVal;
                }
            @endphp
            <div class="relative w-full lg:w-48" x-data="{ open: false }">
                <input type="hidden" name="sektor" id="input_sektor" value="{{ request('sektor') }}">
                <button type="button" 
                        @click="open = !open" 
                        class="w-full h-11 pl-3.5 pr-8 bg-slate-50/70 border {{ request('sektor') ? 'border-sky-300 bg-sky-50/90 text-sky-900 font-bold ring-1 ring-sky-300/50' : 'border-slate-200 text-slate-700 font-semibold' }} rounded-xl text-xs flex items-center justify-between transition focus:outline-none hover:bg-slate-100/70 shadow-2xs">
                    <span class="truncate">{{ $sektorDisplay }}</span>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </button>
                <div x-show="open" 
                     @click.outside="open = false" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute left-0 mt-1.5 w-56 max-h-64 overflow-y-auto bg-white rounded-2xl border border-slate-200/90 shadow-xl z-50 p-1.5 space-y-0.5">
                    <div class="px-2.5 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sektor Industri</div>
                    <button type="button" 
                            @click="document.getElementById('input_sektor').value = ''; $el.closest('form').submit();"
                            class="w-full text-left px-2.5 py-2 rounded-xl text-xs font-semibold flex items-center justify-between transition {{ !request('sektor') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Semua Sektor</span>
                        @if(!request('sektor'))
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </button>
                    @foreach($sektorList as $k => $v)
                        @php
                            $valKey = is_numeric($k) ? $v : $k;
                            $valTitle = $v;
                        @endphp
                        <button type="button" 
                                @click="document.getElementById('input_sektor').value = '{{ $valKey }}'; $el.closest('form').submit();"
                                class="w-full text-left px-2.5 py-2 rounded-xl text-xs flex items-center justify-between transition {{ request('sektor') == $valKey ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span class="truncate">{{ $valTitle }}</span>
                            @if(request('sektor') == $valKey)
                                <svg class="w-4 h-4 text-blue-600 shrink-0 ml-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Dropdown: Wilayah -->
            @php
                $wilayahMap = [
                    'Jakarta' => 'DKI Jakarta',
                    'Bogor' => 'Bogor / Sentul / Cileungsi',
                    'Tangerang' => 'Tangerang & BSD',
                    'Bekasi' => 'Bekasi & Cikarang',
                    'Bandung' => 'Bandung',
                ];
                $wilayahVal = request('wilayah');
                $wilayahDisplay = $wilayahVal && isset($wilayahMap[$wilayahVal]) ? $wilayahMap[$wilayahVal] : 'Semua Wilayah';
            @endphp
            <div class="relative w-full lg:w-48" x-data="{ open: false }">
                <input type="hidden" name="wilayah" id="input_wilayah" value="{{ request('wilayah') }}">
                <button type="button" 
                        @click="open = !open" 
                        class="w-full h-11 pl-3.5 pr-8 bg-slate-50/70 border {{ request('wilayah') ? 'border-sky-300 bg-sky-50/90 text-sky-900 font-bold ring-1 ring-sky-300/50' : 'border-slate-200 text-slate-700 font-semibold' }} rounded-xl text-xs flex items-center justify-between transition focus:outline-none hover:bg-slate-100/70 shadow-2xs">
                    <span class="truncate">{{ $wilayahDisplay }}</span>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </button>
                <div x-show="open" 
                     @click.outside="open = false" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute left-0 mt-1.5 w-56 max-h-64 overflow-y-auto bg-white rounded-2xl border border-slate-200/90 shadow-xl z-50 p-1.5 space-y-0.5">
                    <div class="px-2.5 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Wilayah / Kota</div>
                    <button type="button" 
                            @click="document.getElementById('input_wilayah').value = ''; $el.closest('form').submit();"
                            class="w-full text-left px-2.5 py-2 rounded-xl text-xs font-semibold flex items-center justify-between transition {{ !request('wilayah') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Semua Wilayah</span>
                        @if(!request('wilayah'))
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </button>
                    @foreach($wilayahMap as $wKey => $wTitle)
                        <button type="button" 
                                @click="document.getElementById('input_wilayah').value = '{{ $wKey }}'; $el.closest('form').submit();"
                                class="w-full text-left px-2.5 py-2 rounded-xl text-xs flex items-center justify-between transition {{ request('wilayah') == $wKey ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span class="truncate">{{ $wTitle }}</span>
                            @if(request('wilayah') == $wKey)
                                <svg class="w-4 h-4 text-blue-600 shrink-0 ml-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Reset Filter Button -->
            <a href="{{ route('kaprog.penempatan-industri.index') }}"
               class="h-11 w-11 flex items-center justify-center bg-slate-50/70 border border-slate-200 hover:bg-slate-100 rounded-xl text-slate-400 hover:text-slate-600 transition shrink-0"
               title="Reset Filter">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
            </a>
        </form>
    </div>

    <!-- Sub-header: Count and Legend -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2.5 mb-4 px-1">
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            <span>Menampilkan {{ $industris->count() }} dari {{ $totalMitra }} mitra industri (Urutan: Terpenuhi dahulu)</span>
        </div>

        <div class="flex items-center gap-4 text-xs font-semibold">
            <div class="flex items-center gap-1.5 text-slate-600">
                <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                <span>Kuota Penuh</span>
            </div>
            <div class="flex items-center gap-1.5 text-slate-600">
                <span class="w-2 h-2 rounded-full bg-sky-600 inline-block"></span>
                <span>Tersisa Kuota</span>
            </div>
        </div>
    </div>

    <!-- Industry Cards Grid (3 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        @forelse($industris as $ind)
            @php
                $isFull = $ind->kuota > 0 && $ind->kuota_terisi >= $ind->kuota;
                $percent = $ind->kuota > 0 ? round(($ind->kuota_terisi / $ind->kuota) * 100, 1) : 0;
                $sisa = max(0, $ind->kuota - $ind->kuota_terisi);
            @endphp

            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <!-- Top row of Card: Initials, Sector tag, Status Pill -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <!-- Initials Square -->
                            <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 font-extrabold text-xs flex items-center justify-center shrink-0 border border-slate-200/60 shadow-2xs">
                                {{ $ind->initials }}
                            </div>
                            <!-- Sector Badge -->
                            <span class="px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-200/60 rounded-lg text-xs font-bold leading-none">
                                {{ $ind->bidang_usaha }}
                            </span>
                        </div>

                        <!-- Status Badge (Penuh vs Tersisa) -->
                        @if($isFull)
                            <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[11px] font-bold flex items-center gap-1.5 shrink-0 shadow-2xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Penuh
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 bg-sky-50 text-sky-700 border border-sky-200 rounded-full text-[11px] font-bold flex items-center gap-1.5 shrink-0 shadow-2xs">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span>
                                Tersisa {{ $sisa }}
                            </span>
                        @endif
                    </div>

                    <!-- Company Name -->
                    <h3 class="font-extrabold text-base text-slate-900 mt-3.5 leading-snug tracking-tight">
                        {{ $ind->nama }}
                    </h3>

                    <!-- Location / Address -->
                    <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium mt-1">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="truncate">{{ $ind->alamat ?: $ind->wilayah }}</span>
                    </div>

                    <!-- Quota Bar Container -->
                    <div class="mt-4 pt-3.5 border-t border-slate-100">
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span class="text-slate-500 font-medium">Keterisian Kuota</span>
                            <span class="text-slate-900 font-extrabold">{{ $ind->kuota_terisi }} / {{ $ind->kuota }} Kuota</span>
                        </div>

                        <!-- Progress Bar (Dark Slate Bar) -->
                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-slate-900 h-full rounded-full transition-all duration-300" style="width: {{ min(100, $percent) }}%;"></div>
                        </div>

                        <div class="flex items-center justify-between mt-2">
                            @if($isFull)
                                <span class="text-xs font-bold text-emerald-500">
                                    {{ $ind->kuota_terisi }} Siswa Ditempatkan
                                </span>
                            @else
                                <span class="text-xs font-bold text-sky-600">
                                    {{ $ind->kuota_terisi }} Siswa Ditempatkan
                                </span>
                            @endif
                            <span class="text-xs font-extrabold text-slate-900">
                                {{ $percent }}%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row / Footer of Card -->
                <div class="pt-3.5 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-1.5 text-slate-600 font-semibold truncate max-w-[200px]" title="Guru Pembimbing">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                        </svg>
                        <span class="truncate">{{ $ind->pembimbing_nama ?: 'Drs. Bambang Wijaya' }}</span>
                    </div>

                    <a href="{{ route('kaprog.murid-pkl.index', ['industri' => $ind->nama]) }}"
                       class="text-xs font-bold text-sky-600 hover:text-sky-800 flex items-center gap-1 shrink-0 group">
                        <span>Siswa</span>
                        <span class="group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400 text-xs bg-white rounded-2xl border border-slate-200">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <p class="font-bold text-slate-600 text-sm">Tidak ada mitra industri ditemukan</p>
                    <p class="text-[11px] text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau filter sektor dan wilayah Anda.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Rows Selector & Pagination Footer -->
    <div class="bg-white border border-slate-200 rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-2xs mb-6">
        <!-- Rows Selector -->
        <div class="flex items-center gap-2 text-xs font-semibold text-slate-600">
            <span>Menampilkan</span>
            <form action="{{ route('kaprog.penempatan-industri.index') }}" method="GET" class="inline-block">
                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                @if(request('sektor')) <input type="hidden" name="sektor" value="{{ request('sektor') }}"> @endif
                @if(request('wilayah')) <input type="hidden" name="wilayah" value="{{ request('wilayah') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                <select name="per_page"
                        onchange="this.form.submit()"
                        class="px-2.5 py-1 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-1 focus:ring-sky-500 cursor-pointer">
                    <option value="16" {{ ($perPage ?? 16) == 16 ? 'selected' : '' }}>16 Baris</option>
                    <option value="28" {{ ($perPage ?? 16) == 28 ? 'selected' : '' }}>28 Baris (Semua)</option>
                    <option value="8" {{ ($perPage ?? 16) == 8 ? 'selected' : '' }}>8 Baris</option>
                </select>
            </form>
            <span>dari {{ $totalMitra }} Mitra Industri</span>
        </div>

        <!-- Pagination Controls -->
        @if($industris->hasPages())
            <div class="flex items-center gap-1 self-center sm:self-auto">
                <!-- Previous Button -->
                @if ($industris->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center text-xs font-bold text-slate-300 cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $industris->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-lg transition">‹</a>
                @endif

                <!-- Page Number Links -->
                @foreach ($industris->getUrlRange(1, $industris->lastPage()) as $page => $url)
                    @if ($page == $industris->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center bg-slate-900 text-white rounded-lg text-xs font-bold shadow-xs">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-slate-600 hover:bg-slate-100 rounded-lg text-xs font-bold transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                <!-- Next Button -->
                @if ($industris->hasMorePages())
                    <a href="{{ $industris->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-lg transition">›</a>
                @else
                    <span class="w-8 h-8 flex items-center justify-center text-xs font-bold text-slate-300 cursor-not-allowed">›</span>
                @endif
            </div>
        @else
            <div class="flex items-center gap-1">
                <span class="w-8 h-8 flex items-center justify-center bg-slate-900 text-white rounded-lg text-xs font-bold shadow-xs">1</span>
            </div>
        @endif
    </div>

    <!-- MODAL: Tambah Kuota Industri -->
    <div x-show="openModalTambah"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openModalTambah"
                 @click="openModalTambah = false"
                 class="fixed inset-0 bg-slate-900/60 transition-opacity"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="openModalTambah"
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('kaprog.penempatan-industri.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900" id="modal-title">
                                    Tambah Kuota Mitra Industri Baru
                                </h3>
                                <p class="text-xs text-slate-400 mt-0.5">Penetapan kuota daya tampung PKL kejuruan RPL</p>
                            </div>
                            <button type="button" @click="openModalTambah = false" class="text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div class="space-y-4 mt-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Perusahaan / Mitra DU/DI</label>
                                <input type="text" name="nama" required placeholder="Contoh: PT Telkom Akses" class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sektor / Bidang</label>
                                    <select name="bidang_usaha" required class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                                        <option value="Software House">Software House</option>
                                        <option value="Telekomunikasi">Telekomunikasi</option>
                                        <option value="Cloud Platform">Cloud Platform</option>
                                        <option value="Automotive & IoT">Automotive & IoT</option>
                                        <option value="Fintech & Banking">Fintech & Banking</option>
                                        <option value="E-Commerce & Tech">E-Commerce & Tech</option>
                                        <option value="Healthcare IT">Healthcare IT</option>
                                        <option value="Game Development">Game Development</option>
                                        <option value="IT Security">IT Security</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Kapasitas Kuota (Kursi)</label>
                                    <input type="number" name="kuota" value="4" min="1" max="50" required class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Wilayah</label>
                                    <select name="wilayah" required class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                                        <option value="Jakarta">DKI Jakarta</option>
                                        <option value="Bogor">Bogor / Sentul / Cileungsi</option>
                                        <option value="Tangerang">Tangerang / BSD</option>
                                        <option value="Bekasi">Bekasi / Cikarang</option>
                                        <option value="Bandung">Bandung</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status MoU</label>
                                    <select name="status_kemitraan" class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                                        <option value="Aktif">Aktif</option>
                                        <option value="MoU Baru">MoU Baru</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Lengkap / Area Penugasan</label>
                                <input type="text" name="alamat" required placeholder="Contoh: Jakarta & Bogor Network Area" class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Guru Pembimbing DU/DI</label>
                                <select name="pembimbing_nama" class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                                    @foreach($gurus as $g)
                                        <option value="{{ $g->nama }}">{{ $g->nama }} ({{ $g->nip }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2.5">
                        <button type="button" @click="openModalTambah = false" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-xs">
                            Simpan Kuota Mitra
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
