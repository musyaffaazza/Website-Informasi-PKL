@extends('layouts.kaprog')

@section('title', 'Murid PKL — Rekayasa Perangkat Lunak | SIPRAK')

@section('content')
<div x-data="{
    openModalTambah: false
}">
    <!-- Top Breadcrumb & Page Header -->
    <div class="mb-6">
        <!-- Breadcrumb Links -->
        <nav class="flex items-center gap-1.5 text-xs font-semibold text-slate-400 mb-2">
            <span class="text-sky-600 hover:underline cursor-pointer">Kaprog Rekayasa Perangkat Lunak</span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-500">Monitoring PKL</span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-800 font-bold">Murid PKL</span>
        </nav>

        <!-- Main Title, Badge & Action Buttons -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                        Murid PKL — Rekayasa Perangkat Lunak
                    </h1>
                    <span class="px-3 py-1 bg-sky-100 text-sky-800 border border-sky-200 rounded-full text-xs font-bold shadow-2xs">
                        {{ $rombels->count() }} Rombel • {{ $totalSiswa }} Siswa
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed max-w-3xl">
                    Monitoring komprehensif dan rekapitulasi penempatan, presensi, serta progres magang {{ $totalSiswa }} siswa{{ $rombels->isNotEmpty() ? ' lintas rombel (' . $rombels->pluck('nama_kode')->filter()->implode(', ') . ')' : '' }}.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5 shrink-0">
                <a href="{{ route('kaprog.murid-pkl.export') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition shadow-2xs">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Export Excel / Rekap Lengkap</span>
                </a>

                <button type="button"
                        @click="openModalTambah = true"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-xs">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Penempatan Baru</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 4 Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card 1: TOTAL SISWA JURUSAN -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        TOTAL SISWA JURUSAN
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalSiswa }}</span>
                    <span class="text-xs font-bold text-slate-400">Siswa</span>
                </div>
                <div class="text-xs font-bold {{ $totalSiswa > 0 ? 'text-emerald-600' : 'text-slate-400' }} flex items-center gap-1.5 mt-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ $totalSiswa > 0 ? '100% Terdaftar PKL Resmi' : 'Belum Ada Siswa Terdaftar' }}</span>
                </div>
            </div>
            <!-- Accent Line -->
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-emerald-400 h-full rounded-full" style="width: {{ $totalSiswa > 0 ? '100%' : '0%' }};"></div>
            </div>
        </div>

        <!-- Card 2: SUDAH DITEMPATKAN -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        SUDAH DITEMPATKAN
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $sudahDitempatkan }}</span>
                    <span class="text-xs font-bold text-slate-400">Siswa</span>
                </div>
                <div class="text-xs text-slate-500 font-medium flex items-center gap-1.5 mt-2 flex-wrap">
                    <span>{{ $persenDitempatkan }}% di {{ $mitraCount }} Mitra DU/DI</span>
                    @if($persenDitempatkan >= 90 && $totalSiswa > 0)
                    <span class="text-[10px] font-bold bg-emerald-50 text-emerald-700 px-1.5 py-0.5 rounded border border-emerald-200">
                        Optimal
                    </span>
                    @elseif($persenDitempatkan > 0)
                    <span class="text-[10px] font-bold bg-amber-50 text-amber-700 px-1.5 py-0.5 rounded border border-amber-200">
                        Proses
                    </span>
                    @endif
                </div>
            </div>
            <!-- Progress Line -->
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $persenDitempatkan }}%;"></div>
            </div>
        </div>

        <!-- Card 3: MENUNGGU KONFIRMASI -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        MENUNGGU KONFIRMASI
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $menungguKonfirmasi }}</span>
                    <span class="text-xs font-bold text-slate-400">Siswa</span>
                </div>
                <div class="text-xs text-slate-600 font-medium flex items-center gap-1.5 mt-2">
                    <span class="w-1.5 h-1.5 rounded-full {{ $menungguKonfirmasi > 0 ? 'bg-sky-500' : 'bg-slate-300' }} inline-block"></span>
                    <span>{{ $menungguKonfirmasi > 0 ? $menungguKonfirmasi . ' Siswa Dalam Proses' : 'Tidak Ada Antrean' }}</span>
                </div>
            </div>
            <!-- Progress Line -->
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-sky-400 h-full rounded-full" style="width: {{ $persenMenunggu }}%;"></div>
            </div>
        </div>

        <!-- Card 4: RATA-RATA KEHADIRAN -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        RATA-RATA KEHADIRAN
                    </span>
                    <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2 mt-2">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $rataRataKehadiran }}%</span>
                    @if($totalSiswa > 0)
                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">
                        ↑ +1.2%
                    </span>
                    @endif
                </div>
                <div class="text-xs font-bold {{ $totalSiswa > 0 ? 'text-emerald-600' : 'text-slate-400' }} flex items-center gap-1.5 mt-2">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                    </svg>
                    <span>{{ $totalSiswa > 0 ? 'Standar Disiplin Terpenuhi' : 'Belum Ada Data Presensi' }}</span>
                </div>
            </div>
            <!-- Accent Line -->
            <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                <div class="bg-emerald-400 h-full rounded-full" style="width: {{ $rataRataKehadiran }}%;"></div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white border border-slate-200 rounded-2xl p-3.5 sm:p-4 mb-6 shadow-2xs">
        <form action="{{ route('kaprog.murid-pkl.index') }}" method="GET" class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3">
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
                       placeholder="Cari nama siswa, NISN, atau mentor industri..."
                       class="w-full h-11 pl-10 pr-4 bg-slate-50/70 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
            </div>

            <!-- Dropdown Filter: Kelas -->
            @php
                $kelasLabel = request('kelas') ?: 'Semua Kelas';
            @endphp
            <div class="relative w-full lg:w-44" x-data="{ open: false }">
                <input type="hidden" name="kelas" id="input_kelas" value="{{ request('kelas') }}">
                <button type="button" 
                        @click="open = !open" 
                        class="w-full h-11 pl-3.5 pr-8 bg-slate-50/70 border {{ request('kelas') ? 'border-sky-300 bg-sky-50/90 text-sky-900 font-bold ring-1 ring-sky-300/50' : 'border-slate-200 text-slate-700 font-semibold' }} rounded-xl text-xs flex items-center justify-between transition focus:outline-none hover:bg-slate-100/70 shadow-2xs">
                    <span class="truncate">{{ $kelasLabel }}</span>
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
                     class="absolute left-0 mt-1.5 w-48 max-h-64 overflow-y-auto bg-white rounded-2xl border border-slate-200/90 shadow-xl z-50 p-1.5 space-y-0.5">
                    <div class="px-2.5 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Kelas / Rombel</div>
                    <button type="button" 
                            @click="document.getElementById('input_kelas').value = ''; $el.closest('form').submit();"
                            class="w-full text-left px-2.5 py-2 rounded-xl text-xs font-semibold flex items-center justify-between transition {{ !request('kelas') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Semua Kelas</span>
                        @if(!request('kelas'))
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </button>
                    @foreach($rombels as $r)
                        <button type="button" 
                                @click="document.getElementById('input_kelas').value = '{{ $r->nama_kode }}'; $el.closest('form').submit();"
                                class="w-full text-left px-2.5 py-2 rounded-xl text-xs flex items-center justify-between transition {{ request('kelas') == $r->nama_kode ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span class="truncate">{{ $r->nama_kode }}</span>
                            @if(request('kelas') == $r->nama_kode)
                                <svg class="w-4 h-4 text-blue-600 shrink-0 ml-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Dropdown Filter: Industri -->
            @php
                $industriLabel = request('industri') ? Str::limit(request('industri'), 18) : 'Semua Industri';
            @endphp
            <div class="relative w-full lg:w-56" x-data="{ open: false }">
                <input type="hidden" name="industri" id="input_industri" value="{{ request('industri') }}">
                <button type="button" 
                        @click="open = !open" 
                        class="w-full h-11 pl-3.5 pr-8 bg-slate-50/70 border {{ request('industri') ? 'border-sky-300 bg-sky-50/90 text-sky-900 font-bold ring-1 ring-sky-300/50' : 'border-slate-200 text-slate-700 font-semibold' }} rounded-xl text-xs flex items-center justify-between transition focus:outline-none hover:bg-slate-100/70 shadow-2xs">
                    <span class="truncate">{{ $industriLabel }}</span>
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
                     class="absolute left-0 mt-1.5 w-64 max-h-64 overflow-y-auto bg-white rounded-2xl border border-slate-200/90 shadow-xl z-50 p-1.5 space-y-0.5">
                    <div class="px-2.5 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Mitra Industri</div>
                    <button type="button" 
                            @click="document.getElementById('input_industri').value = ''; $el.closest('form').submit();"
                            class="w-full text-left px-2.5 py-2 rounded-xl text-xs font-semibold flex items-center justify-between transition {{ !request('industri') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Semua Industri</span>
                        @if(!request('industri'))
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </button>
                    @foreach($industris as $ind)
                        <button type="button" 
                                @click="document.getElementById('input_industri').value = '{{ $ind->nama }}'; $el.closest('form').submit();"
                                class="w-full text-left px-2.5 py-2 rounded-xl text-xs flex items-center justify-between transition {{ request('industri') == $ind->nama ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span class="truncate">{{ $ind->nama }}</span>
                            @if(request('industri') == $ind->nama)
                                <svg class="w-4 h-4 text-blue-600 shrink-0 ml-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Dropdown Filter: Status -->
            @php
                $statusMap = [
                    'Aktif Magang' => 'bg-emerald-500',
                    'Menunggu Konfirmasi' => 'bg-amber-500',
                    'Selesai PKL' => 'bg-blue-500',
                ];
                $statusLabel = request('status') ?: 'Semua Status';
            @endphp
            <div class="relative w-full lg:w-44" x-data="{ open: false }">
                <input type="hidden" name="status" id="input_status" value="{{ request('status') }}">
                <button type="button" 
                        @click="open = !open" 
                        class="w-full h-11 pl-3.5 pr-8 bg-slate-50/70 border {{ request('status') ? 'border-sky-300 bg-sky-50/90 text-sky-900 font-bold ring-1 ring-sky-300/50' : 'border-slate-200 text-slate-700 font-semibold' }} rounded-xl text-xs flex items-center justify-between transition focus:outline-none hover:bg-slate-100/70 shadow-2xs">
                    <span class="truncate">{{ $statusLabel }}</span>
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
                     class="absolute left-0 mt-1.5 w-52 max-h-64 overflow-y-auto bg-white rounded-2xl border border-slate-200/90 shadow-xl z-50 p-1.5 space-y-0.5">
                    <div class="px-2.5 py-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Siswa</div>
                    <button type="button" 
                            @click="document.getElementById('input_status').value = ''; $el.closest('form').submit();"
                            class="w-full text-left px-2.5 py-2 rounded-xl text-xs font-semibold flex items-center justify-between transition {{ !request('status') ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Semua Status</span>
                        @if(!request('status'))
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </button>
                    @foreach($statusMap as $sVal => $dotColor)
                        <button type="button" 
                                @click="document.getElementById('input_status').value = '{{ $sVal }}'; $el.closest('form').submit();"
                                class="w-full text-left px-2.5 py-2 rounded-xl text-xs flex items-center justify-between transition {{ request('status') == $sVal ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span class="inline-flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $dotColor }}"></span>
                                {{ $sVal }}
                            </span>
                            @if(request('status') == $sVal)
                                <svg class="w-4 h-4 text-blue-600 shrink-0 ml-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Reset Filter Button -->
            <a href="{{ route('kaprog.murid-pkl.index') }}"
               class="h-11 w-11 flex items-center justify-center bg-slate-50/70 border border-slate-200 hover:bg-slate-100 rounded-xl text-slate-400 hover:text-slate-600 transition shrink-0"
               title="Reset Filter">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
            </a>
        </form>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-4 px-4 sm:px-6 w-16 text-center">No</th>
                        <th class="py-4 px-4 sm:px-6">Nama Siswa</th>
                        <th class="py-4 px-4 sm:px-6">Kelas</th>
                        <th class="py-4 px-4 sm:px-6">Industri & Posisi</th>
                        <th class="py-4 px-4 sm:px-6">Kehadiran</th>
                        <th class="py-4 px-4 sm:px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($paginatedSiswa as $siswa)
                        <tr class="hover:bg-slate-50/60 transition group">
                            <!-- No -->
                            <td class="py-4 px-4 sm:px-6 text-center font-bold text-slate-400 text-xs">
                                {{ $siswa->no }}
                            </td>

                            <!-- Nama Siswa with Avatar and NISN -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    @if($siswa->avatar_color === 'amber')
                                        <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-800 font-bold text-xs flex items-center justify-center shrink-0 border border-amber-200 shadow-2xs">
                                            {{ $siswa->initials }}
                                        </div>
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-sky-100 text-sky-700 font-bold text-xs flex items-center justify-center shrink-0 border border-sky-200 shadow-2xs">
                                            {{ $siswa->initials }}
                                        </div>
                                    @endif

                                    <div>
                                        <div class="font-bold text-slate-900 leading-tight">
                                            {{ $siswa->nama }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 font-medium mt-0.5">
                                            NISN: {{ $siswa->nisn }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Kelas Badge -->
                            <td class="py-4 px-4 sm:px-6">
                                <span class="px-2.5 py-1 bg-sky-50 text-sky-800 border border-sky-200/80 rounded-md font-bold text-[11px] shadow-2xs">
                                    {{ $siswa->kelas }}
                                </span>
                            </td>

                            <!-- Industri & Posisi -->
                            <td class="py-4 px-4 sm:px-6">
                                <div>
                                    <div class="font-bold text-slate-900 leading-tight">
                                        {{ $siswa->industri }}
                                    </div>
                                    @if($siswa->is_warning_posisi)
                                        <div class="text-[11px] text-amber-600 font-bold mt-0.5">
                                            {{ $siswa->posisi }}
                                        </div>
                                    @else
                                        <div class="text-[11px] text-slate-500 font-medium mt-0.5">
                                            {{ $siswa->posisi }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Kehadiran -->
                            <td class="py-4 px-4 sm:px-6">
                                @if($siswa->kehadiran !== null)
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-20 bg-slate-100 h-1.5 rounded-full overflow-hidden shrink-0">
                                            @if($siswa->kehadiran >= 90)
                                                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $siswa->kehadiran }}%;"></div>
                                            @elseif($siswa->kehadiran >= 80)
                                                <div class="bg-sky-400 h-full rounded-full" style="width: {{ $siswa->kehadiran }}%;"></div>
                                            @else
                                                <div class="bg-amber-400 h-full rounded-full" style="width: {{ $siswa->kehadiran }}%;"></div>
                                            @endif
                                        </div>
                                        <span class="font-bold text-slate-800 text-xs">{{ $siswa->kehadiran }}%</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 font-bold text-xs pl-2">-</span>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-4 sm:px-6 text-center">
                                @if($siswa->status === 'Aktif Magang')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#064e3b] text-[#34d399] rounded-full text-[11px] font-bold shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#34d399]"></span>
                                        Aktif Magang
                                    </span>
                                @elseif($siswa->status === 'Menunggu Konfirmasi')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-full text-[11px] font-bold shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu Konfirmasi
                                    </span>
                                @elseif($siswa->status === 'Selesai PKL')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-100 text-sky-800 border border-sky-200 rounded-full text-[11px] font-bold shadow-2xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span>
                                        Selesai PKL
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-[11px] font-bold">
                                        {{ $siswa->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 text-xs">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-bold text-slate-600 text-sm">Tidak ada data murid PKL ditemukan</p>
                                    <p class="text-[11px] text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau filter Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Pagination / Footer -->
        <div class="px-4 sm:px-6 py-4 bg-white border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="text-xs font-semibold text-slate-500">
                Menampilkan {{ $paginatedSiswa->firstItem() ?? 0 }}-{{ $paginatedSiswa->lastItem() ?? 0 }} dari {{ $paginatedSiswa->total() }} total siswa (3 Kelas RPL)
            </div>

            <!-- Pagination Navigation -->
            @if($paginatedSiswa->hasPages())
                <div class="flex items-center gap-1 self-center sm:self-auto">
                    {{-- Previous Page Link --}}
                    @if ($paginatedSiswa->onFirstPage())
                        <span class="px-3 py-1.5 text-xs font-semibold text-slate-300 cursor-not-allowed">Previous</span>
                    @else
                        <a href="{{ $paginatedSiswa->previousPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition">Previous</a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($paginatedSiswa->getUrlRange(1, min(9, $paginatedSiswa->lastPage())) as $page => $url)
                        @if ($page == $paginatedSiswa->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center bg-slate-900 text-white rounded-lg text-xs font-bold shadow-xs">
                                {{ $page }}
                            </span>
                        @elseif($page == 5 && $paginatedSiswa->lastPage() > 6)
                            <span class="w-8 h-8 flex items-center justify-center text-slate-400 text-xs font-bold">...</span>
                        @elseif($page < 5 || $page == $paginatedSiswa->lastPage())
                            <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center text-slate-600 hover:bg-slate-100 rounded-lg text-xs font-bold transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginatedSiswa->hasMorePages())
                        <a href="{{ $paginatedSiswa->nextPageUrl() }}" class="px-3 py-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition">Next</a>
                    @else
                        <span class="px-3 py-1.5 text-xs font-semibold text-slate-300 cursor-not-allowed">Next</span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- MODAL 1: Tambah Penempatan Baru -->
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
                <form action="{{ route('kaprog.murid-pkl.store-penempatan') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                            <h3 class="text-base font-extrabold text-slate-900" id="modal-title">
                                Tambah Penempatan Baru Siswa PKL
                            </h3>
                            <button type="button" @click="openModalTambah = false" class="text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>

                        <div class="space-y-4 mt-4">
                            <!-- Search Siswa (Searchable) -->
                            <div x-data="{
                                searchSiswa: '',
                                selectedSiswaId: '',
                                openDropdown: false,
                                siswas: {{ Js::from($allSiswaJurusan->map(function($s) { return ['id' => $s->id, 'nama' => $s->nama, 'nisn' => $s->nisn ?? '', 'nis' => $s->nis ?? '', 'rombel' => $s->rombel ? $s->rombel->nama_kode : '']; })->values()) }},
                                get filtered() {
                                    if (!this.searchSiswa.trim()) return [];
                                    const q = this.searchSiswa.toLowerCase();
                                    return this.siswas.filter(s =>
                                        s.nama.toLowerCase().includes(q) ||
                                        s.nisn.toLowerCase().includes(q) ||
                                        s.nis.toLowerCase().includes(q) ||
                                        s.rombel.toLowerCase().includes(q)
                                    ).slice(0, 10);
                                },
                                selectSiswa(s) {
                                    this.selectedSiswaId = s.id;
                                    this.searchSiswa = s.nama + ' (' + s.nisn + ' - ' + s.rombel + ')';
                                    this.openDropdown = false;
                                },
                                clearSiswa() {
                                    this.selectedSiswaId = '';
                                    this.searchSiswa = '';
                                    this.openDropdown = false;
                                }
                            }" class="relative">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pilih Siswa (RPL)</label>
                                <input type="hidden" name="siswa_id" :value="selectedSiswaId" required>
                                <div class="relative">
                                    <input
                                        type="text"
                                        x-model="searchSiswa"
                                        @input="openDropdown = true; if(!searchSiswa) clearSiswa();"
                                        @focus="openDropdown = true"
                                        @click.outside="openDropdown = false"
                                        @keydown.escape="openDropdown = false"
                                        placeholder="Ketik nama / NISN / NIS siswa..."
                                        autocomplete="off"
                                        class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 pr-8"
                                        :class="selectedSiswaId ? 'text-slate-800' : 'text-slate-400 font-normal'"
                                    >
                                    <button type="button" x-show="selectedSiswaId" @click="clearSiswa()" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 text-base leading-none">&times;</button>
                                </div>
                                <!-- Dropdown Hasil -->
                                <div x-show="openDropdown && filtered.length > 0" x-cloak
                                    class="absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                                    <template x-for="s in filtered" :key="s.id">
                                        <div @click="selectSiswa(s)" class="px-3.5 py-2.5 cursor-pointer hover:bg-sky-50 border-b border-slate-50 last:border-0">
                                            <div class="text-xs font-bold text-slate-800" x-text="s.nama"></div>
                                            <div class="text-[10px] text-slate-500 mt-0.5" x-text="'NISN: ' + s.nisn + (s.rombel ? ' • ' + s.rombel : '')"></div>
                                        </div>
                                    </template>
                                </div>
                                <!-- Tidak Ditemukan -->
                                <div x-show="openDropdown && searchSiswa.trim().length > 0 && filtered.length === 0" x-cloak
                                    class="absolute z-50 mt-1 w-full bg-white border border-slate-100 rounded-xl shadow-lg px-3.5 py-2.5 text-xs text-slate-400">
                                    Siswa tidak ditemukan. Coba kata kunci lain.
                                </div>
                            </div>

                            <!-- Search Industri (Searchable) -->
                            <div x-data="{
                                searchIndustri: '',
                                selectedIndustriId: '',
                                openIndustriDropdown: false,
                                industris: {{ Js::from($industris->map(function($ind) { return ['id' => $ind->id, 'nama' => $ind->nama, 'wilayah' => $ind->wilayah ?? '']; })->values()) }},
                                get filteredIndustri() {
                                    if (!this.searchIndustri.trim()) return [];
                                    const q = this.searchIndustri.toLowerCase();
                                    return this.industris.filter(i =>
                                        i.nama.toLowerCase().includes(q) ||
                                        i.wilayah.toLowerCase().includes(q)
                                    ).slice(0, 10);
                                },
                                selectIndustri(i) {
                                    this.selectedIndustriId = i.id;
                                    this.searchIndustri = i.nama + ' (' + i.wilayah + ')';
                                    this.openIndustriDropdown = false;
                                },
                                clearIndustri() {
                                    this.selectedIndustriId = '';
                                    this.searchIndustri = '';
                                    this.openIndustriDropdown = false;
                                }
                            }" class="relative">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Mitra Industri (DU/DI)</label>
                                <input type="hidden" name="industri_id" :value="selectedIndustriId" required>
                                <div class="relative">
                                    <input
                                        type="text"
                                        x-model="searchIndustri"
                                        @input="openIndustriDropdown = true; if(!searchIndustri) clearIndustri();"
                                        @focus="openIndustriDropdown = true"
                                        @click.outside="openIndustriDropdown = false"
                                        @keydown.escape="openIndustriDropdown = false"
                                        placeholder="Ketik nama perusahaan / wilayah..."
                                        autocomplete="off"
                                        class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 pr-8"
                                        :class="selectedIndustriId ? 'text-slate-800' : 'text-slate-400 font-normal'"
                                    >
                                    <button type="button" x-show="selectedIndustriId" @click="clearIndustri()" class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 text-base leading-none">&times;</button>
                                </div>
                                <!-- Dropdown Hasil -->
                                <div x-show="openIndustriDropdown && filteredIndustri.length > 0" x-cloak
                                    class="absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-lg max-h-52 overflow-y-auto">
                                    <template x-for="i in filteredIndustri" :key="i.id">
                                        <div @click="selectIndustri(i)" class="px-3.5 py-2.5 cursor-pointer hover:bg-sky-50 border-b border-slate-50 last:border-0">
                                            <div class="text-xs font-bold text-slate-800" x-text="i.nama"></div>
                                            <div class="text-[10px] text-slate-500 mt-0.5" x-text="i.wilayah"></div>
                                        </div>
                                    </template>
                                </div>
                                <!-- Tidak Ditemukan -->
                                <div x-show="openIndustriDropdown && searchIndustri.trim().length > 0 && filteredIndustri.length === 0" x-cloak
                                    class="absolute z-50 mt-1 w-full bg-white border border-slate-100 rounded-xl shadow-lg px-3.5 py-2.5 text-xs text-slate-400">
                                    Industri tidak ditemukan. Coba kata kunci lain.
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Posisi / Role PKL</label>
                                <input type="text" name="posisi" placeholder="Contoh: Frontend React Developer" class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" value="2025-01-06" class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" value="2025-06-30" class="w-full h-11 px-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2.5">
                        <button type="button" @click="openModalTambah = false" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl shadow-xs">
                            Simpan Penempatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
