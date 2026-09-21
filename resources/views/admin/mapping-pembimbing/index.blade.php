@extends('layouts.admin')

@section('title', 'SIPRAK SMKN 1 GUNUNGPUTRI - Mapping Pembimbing')
@section('header_search_placeholder', 'Cari siswa, NIS, atau pembimbing...')

@section('content')
<div x-data="mappingApp()" class="space-y-6">

    <!-- Breadcrumb & Page Header -->
    <div>
        <div class="text-[11px] font-semibold text-slate-400 mb-1.5 flex items-center gap-1.5">
            <span>Data PKL</span>
            <span class="text-slate-300">/</span>
            <span class="text-slate-600">Mapping Pembimbing</span>
        </div>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-[#0f2942] tracking-tight">
                    Mapping Pembimbing
                </h1>
                <p class="text-xs text-slate-500 mt-1 max-w-3xl leading-relaxed">
                    Kelola penugasan guru pembimbing untuk siswa yang melaksanakan PKL.
                </p>
            </div>

            <!-- Top Right Action Button -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <a href="{{ route('admin.mapping-pembimbing.export', request()->query()) }}" 
                   class="flex items-center gap-2 px-3.5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Ekspor Data</span>
                </a>

                <button type="button" 
                        @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition active:scale-98">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Mapping</span>
                </button>
            </div>
        </div>
    </div>

    <!-- 3 Summary Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Card 1: TOTAL SISWA PKL -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">TOTAL SISWA PKL</div>
                <div class="text-3xl font-black text-slate-900 mt-1 leading-tight">{{ $totalSiswaPkl }}</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Siswa aktif terdaftar periode {{ $tahunAjaranAktif }}</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 2: SUDAH MEMILIKI PEMBIMBING -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">SUDAH MEMILIKI PEMBIMBING</div>
                <div class="text-3xl font-black text-emerald-600 mt-1 leading-tight">{{ $sudahMemilikiPembimbing }}</div>
                <div class="text-[11px] font-medium text-emerald-600 mt-1 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>{{ $persenTerpetakan }}% siswa telah terpetakan</span>
                </div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
        </div>

        <!-- Card 3: BELUM MEMILIKI PEMBIMBING -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">BELUM MEMILIKI PEMBIMBING</div>
                <div class="text-3xl font-black text-[#d97706] mt-1 leading-tight">{{ $belumMemilikiPembimbing }}</div>
                <div class="text-[11px] font-medium text-amber-600 mt-1 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    <span>Memerlukan alokasi pembimbing</span>
                </div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs">
        <form action="{{ route('admin.mapping-pembimbing.index') }}" method="GET" id="filterForm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 items-end">
                
                <!-- Filter 1: Cari Siswa / NIS -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Cari Siswa / NIS</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Ketik nama siswa atau NIS..." 
                               class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Filter 2: Jurusan -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Jurusan</label>
                    <select name="jurusan_id" 
                            class="w-full bg-white border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-medium">
                        <option value="all">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}" {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->kode }} ({{ Str::limit($j->nama, 18) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter 3: Rombel -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Rombel</label>
                    <select name="rombel_id" 
                            class="w-full bg-white border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-medium">
                        <option value="all">Semua Rombel</option>
                        @foreach($rombels as $r)
                            <option value="{{ $r->id }}" {{ request('rombel_id') == $r->id ? 'selected' : '' }}>
                                {{ $r->nama_rombel ?: $r->nama_kode }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter 4: Guru Pembimbing -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Guru Pembimbing</label>
                    <select name="guru_id" 
                            class="w-full bg-white border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-medium">
                        <option value="all">Semua Pembimbing</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter 5: Status Mapping & Action Buttons -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1.5">Status Mapping</label>
                    <div class="flex items-center gap-2">
                        <select name="status_mapping" 
                                class="flex-1 bg-white border border-slate-200 text-slate-700 text-xs rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition font-medium">
                            <option value="all" {{ request('status_mapping') == 'all' ? 'selected' : '' }}>Semua Status</option>
                            <option value="sudah" {{ request('status_mapping') == 'sudah' ? 'selected' : '' }}>Sudah Dipetakan</option>
                            <option value="belum" {{ request('status_mapping') == 'belum' ? 'selected' : '' }}>Belum Dipetakan</option>
                        </select>
                    </div>
                </div>

            </div>

            <!-- Filter Buttons Row -->
            <div class="mt-3.5 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-end gap-2">
                <a href="{{ route('admin.mapping-pembimbing.index') }}" 
                   class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-semibold rounded-xl transition shadow-2xs">
                    Reset
                </a>
                <button type="submit" 
                        class="flex items-center gap-1.5 px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs transition active:scale-98">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>Terapkan Filter</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <!-- Table Header Bar -->
        <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div class="flex items-center gap-2.5">
                <h3 class="font-extrabold text-slate-900 text-sm">Daftar Penugasan Siswa PKL</h3>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-slate-100 text-slate-600 border border-slate-200">
                    {{ $pengajuans->total() }} Siswa Tampil
                </span>
            </div>
            <div class="text-[11px] text-slate-400">
                Menampilkan data penempatan yang telah disetujui Pokja Hubin
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table class="min-w-[1050px] w-full text-left text-xs">
                <thead class="bg-slate-50/70 border-b border-slate-200 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 text-slate-400 w-12">NO</th>
                        <th class="py-3.5 px-4">SISWA</th>
                        <th class="py-3.5 px-4">NIS</th>
                        <th class="py-3.5 px-4">ROMBEL</th>
                        <th class="py-3.5 px-4">JURUSAN</th>
                        <th class="py-3.5 px-4">INDUSTRI</th>
                        <th class="py-3.5 px-4">PEMBIMBING</th>
                        <th class="py-3.5 px-4">TANGGAL MULAI</th>
                        <th class="py-3.5 px-4 text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $index => $p)
                    @php
                        $siswa = $p->siswa;
                        $penugasan = $p->penugasan;
                        $guru = $penugasan ? $penugasan->pembimbing : null;
                        $isMapped = $guru !== null;

                        // Avatar bg colors for initials
                        $avatarBgs = [
                            'bg-sky-100 text-sky-700',
                            'bg-emerald-100 text-emerald-700',
                            'bg-amber-100 text-amber-700',
                            'bg-purple-100 text-purple-700',
                            'bg-rose-100 text-rose-700',
                            'bg-indigo-100 text-indigo-700'
                        ];
                        $avatarClass = $avatarBgs[$index % count($avatarBgs)];

                        $kodePengajuan = $p->kode_pengajuan ?: ('#PKL-' . date('Y') . '-' . str_pad($p->id, 4, '0', STR_PAD_LEFT));
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition">
                        <!-- NO -->
                        <td class="py-3.5 px-4 font-semibold text-slate-400">
                            {{ ($pengajuans->currentPage() - 1) * $pengajuans->perPage() + $index + 1 }}
                        </td>

                        <!-- SISWA -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full {{ $avatarClass }} font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ $siswa ? $siswa->initials : 'SW' }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 leading-tight">
                                        {{ $siswa ? $siswa->nama : 'Nama Siswa' }}
                                    </div>
                                    @if($isMapped)
                                    <div class="text-[10px] text-slate-400 mt-0.5 font-mono">
                                        Pengajuan: {{ $kodePengajuan }}
                                    </div>
                                    @else
                                    <div class="text-[10px] text-amber-600 font-semibold mt-0.5">
                                        Menunggu Penetapan Guru
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- NIS -->
                        <td class="py-3.5 px-4 font-semibold text-slate-700">
                            {{ $siswa ? $siswa->nis : '-' }}
                        </td>

                        <!-- ROMBEL -->
                        <td class="py-3.5 px-4">
                            @if($siswa && $siswa->rombel)
                            <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $siswa->rombel->nama_rombel ?: $siswa->rombel->nama_kode }}
                            </span>
                            @else
                            <span class="text-slate-400">-</span>
                            @endif
                        </td>

                        <!-- JURUSAN -->
                        <td class="py-3.5 px-4 font-semibold text-slate-700">
                            {{ $siswa && $siswa->jurusan ? $siswa->jurusan->kode : 'PPLG' }}
                        </td>

                        <!-- INDUSTRI -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="font-semibold text-slate-800">{{ $p->industri ? $p->industri->nama : '-' }}</span>
                            </div>
                        </td>

                        <!-- PEMBIMBING -->
                        <td class="py-3.5 px-4">
                            @if($isMapped)
                            <div>
                                <div class="flex items-center gap-1.5 font-bold text-slate-900 leading-tight">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span>{{ $guru->nama }}</span>
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">
                                    NIP. {{ $guru->nip ?: '-' }}
                                </div>
                            </div>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                <svg class="w-3 h-3 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <span>Belum Dipetakan</span>
                            </span>
                            @endif
                        </td>

                        <!-- TANGGAL MULAI -->
                        <td class="py-3.5 px-4 {{ !$isMapped ? 'text-slate-400 italic' : 'text-slate-700 font-medium' }}">
                            @if($penugasan && $penugasan->tanggal_mulai)
                                {{ $penugasan->tanggal_mulai->format('d F Y') }}
                            @elseif($p->tanggal_mulai)
                                {{ $p->tanggal_mulai->format('d F Y') }}
                            @else
                                {{ $p->penugasan && $p->penugasan->tanggal_mulai ? $p->penugasan->tanggal_mulai->format('d F Y') : ($p->tanggal_mulai ? \Carbon\Carbon::parse($p->tanggal_mulai)->format('d F Y') : '-') }}
                            @endif
                        </td>

                        <!-- AKSI -->
                        <td class="py-3.5 px-4 text-center">
                            @if($isMapped)
                            <div class="flex items-center justify-center gap-1.5">
                                <!-- View Detail -->
                                <button type="button" 
                                        @click="openDetailModal({{ json_encode($p->load(['siswa.rombel', 'siswa.jurusan', 'industri', 'penugasan.pembimbing'])) }})"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" 
                                        title="Detail Penugasan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>

                                <!-- Edit -->
                                <button type="button" 
                                        @click="openEditModal({{ json_encode($p->load(['siswa.rombel', 'siswa.jurusan', 'industri', 'penugasan.pembimbing'])) }})"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition" 
                                        title="Edit Pembimbing">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <!-- Delete / Unassign -->
                                <form action="{{ route('admin.mapping-pembimbing.destroy', $penugasan->id) }}" method="POST" onsubmit="return confirm('Hapus penugasan pembimbing untuk siswa {{ $siswa ? $siswa->nama : '' }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" 
                                            title="Hapus Penugasan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            @else
                            <!-- Tugaskan Button -->
                            <button type="button" 
                                    @click="openQuickAssignModal({{ json_encode($p->load(['siswa.rombel', 'siswa.jurusan', 'industri'])) }})"
                                    class="px-3 py-1.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-lg text-xs font-bold shadow-2xs transition active:scale-98">
                                Tugaskan
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-8 text-center text-slate-400 text-xs">
                            Tidak ada data penugasan siswa PKL yang sesuai dengan filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Pagination Footer -->
        <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-slate-500 font-medium">
                Menampilkan <span class="font-bold text-slate-800">{{ $pengajuans->firstItem() ?? 0 }}–{{ $pengajuans->lastItem() ?? 0 }}</span> dari <span class="font-bold text-slate-800">{{ $pengajuans->total() }}</span> data
            </div>
            <div>
                {{ $pengajuans->links() }}
            </div>
        </div>
    </div>

    <!-- Bottom Preview Card (Empty State Simulation Preview) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-8 text-center shadow-2xs">
        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </div>
        <h4 class="font-bold text-slate-800 text-sm">Pratinjau Kondisi: Belum Ada Mapping Pembimbing</h4>
        <p class="text-xs text-slate-400 mt-1 max-w-md mx-auto">
            Belum ada siswa yang mendapatkan guru pembimbing. Tambahkan mapping untuk mulai mengatur pembimbing PKL.
        </p>
        <div class="mt-4">
            <button type="button" 
                    @click="openCreateModal()"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition active:scale-98">
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Mapping</span>
            </button>
        </div>
    </div>

    <!-- ==================== MODALS ==================== -->

    <!-- Modal 1: Tambah Mapping Pembimbing -->
    <div x-show="createModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="createModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-lg transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form action="{{ route('admin.mapping-pembimbing.store') }}" method="POST">
                    @csrf
                    <div class="p-6">
                        <!-- Header -->
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Tambah Mapping Pembimbing</h3>
                                    <p class="text-xs text-slate-400">Petakan siswa PKL dengan guru pembimbing sekolah</p>
                                </div>
                            </div>
                            <button type="button" @click="createModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <!-- Fields -->
                        <div class="space-y-4 mt-4">
                            <!-- Select Siswa -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Siswa PKL *</label>
                                <select name="siswa_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="">-- Pilih Siswa yang Melaksanakan PKL --</option>
                                    @foreach($semuaSiswaPkl as $sw)
                                    <option value="{{ $sw->id }}">
                                        {{ $sw->nama }} (NIS: {{ $sw->nis }}) - {{ $sw->rombel ? $sw->rombel->nama_kode : '' }} [{{ $sw->pengajuanPkl && $sw->pengajuanPkl->industri ? $sw->pengajuanPkl->industri->nama : 'Mitra DUDI' }}]
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Select Guru Pembimbing -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Guru Pembimbing Sekolah *</label>
                                <select name="pembimbing_guru_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="">-- Pilih Guru Pembimbing --</option>
                                    @foreach($gurus as $g)
                                    <option value="{{ $g->id }}">
                                        {{ $g->nama }} (NIP: {{ $g->nip ?: '-' }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tanggal Mulai -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Mulai Penugasan *</label>
                                <input type="date" name="tanggal_mulai" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="createModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Simpan Penugasan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 2: Quick Tugaskan Pembimbing (For unmapped rows) -->
    <div x-show="quickAssignModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="quickAssignModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form action="{{ route('admin.mapping-pembimbing.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="siswa_id" :value="activePengajuan?.siswa_id">
                    <div class="p-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Tugaskan Pembimbing PKL</h3>
                                    <p class="text-xs text-slate-400" x-text="activePengajuan?.siswa?.nama"></p>
                                </div>
                            </div>
                            <button type="button" @click="quickAssignModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <div class="space-y-4 mt-4">
                            <!-- Info Box -->
                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-xs space-y-1">
                                <div class="flex justify-between">
                                    <span class="text-slate-400">NIS / Rombel:</span>
                                    <span class="font-bold text-slate-800" x-text="(activePengajuan?.siswa?.nis || '-') + ' • ' + (activePengajuan?.siswa?.rombel?.nama_rombel || activePengajuan?.siswa?.rombel?.nama_kode || '-')"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Industri Penempatan:</span>
                                    <span class="font-bold text-slate-800" x-text="activePengajuan?.industri?.nama || '-'"></span>
                                </div>
                            </div>

                            <!-- Guru Pembimbing -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Guru Pembimbing *</label>
                                <select name="pembimbing_guru_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    <option value="">-- Pilih Guru Pembimbing --</option>
                                    @foreach($gurus as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }} (NIP: {{ $g->nip ?: '-' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tanggal Mulai -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Mulai Penugasan *</label>
                                <input type="date" name="tanggal_mulai" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-2 border-t border-slate-100">
                        <button type="button" @click="quickAssignModalOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-semibold rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                            Tetapkan Pembimbing
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal 3: Edit Mapping Pembimbing -->
    <div x-show="editModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="editModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <form :action="'/admin/mapping-pembimbing/' + editForm.penugasan_id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-base">Edit Penugasan Pembimbing</h3>
                                    <p class="text-xs text-slate-400" x-text="editForm.siswa_nama"></p>
                                </div>
                            </div>
                            <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                        </div>

                        <div class="space-y-4 mt-4">
                            <!-- Info Box -->
                            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-xs space-y-1">
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Industri:</span>
                                    <span class="font-bold text-slate-800" x-text="editForm.industri_nama"></span>
                                </div>
                            </div>

                            <!-- Guru Pembimbing -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Guru Pembimbing Baru *</label>
                                <select name="pembimbing_guru_id" x-model="editForm.pembimbing_guru_id" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                                    @foreach($gurus as $g)
                                    <option value="{{ $g->id }}">{{ $g->nama }} (NIP: {{ $g->nip ?: '-' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tanggal Mulai -->
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Mulai Penugasan *</label>
                                <input type="date" name="tanggal_mulai" x-model="editForm.tanggal_mulai" required class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
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

    <!-- Modal 4: Detail Mapping -->
    <div x-show="detailModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="detailModalOpen = false"></div>

        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-6">
            <div class="relative z-10 w-full max-w-xl transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                <div class="p-6">
                    <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 font-extrabold text-sm flex items-center justify-center shrink-0"
                                 x-text="activePengajuan?.siswa?.nama ? activePengajuan.siswa.nama.substring(0, 2).toUpperCase() : 'SW'">
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-lg" x-text="activePengajuan?.siswa?.nama"></h3>
                                <div class="text-xs text-slate-500 mt-0.5" x-text="'NIS: ' + (activePengajuan?.siswa?.nis || '-') + ' • NISN: ' + (activePengajuan?.siswa?.nisn || '-')"></div>
                            </div>
                        </div>
                        <button type="button" @click="detailModalOpen = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                        <!-- Box 1: Akademik Siswa -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                KELAS &amp; PROGRAM KEAHLIAN
                            </div>
                            <div class="text-xs font-bold text-slate-900" x-text="activePengajuan?.siswa?.rombel?.nama_rombel || activePengajuan?.siswa?.rombel?.nama_kode || '-'"></div>
                            <div class="text-[11px] text-slate-500 mt-1" x-text="activePengajuan?.siswa?.jurusan?.nama || 'Pengembangan Perangkat Lunak & Gim'"></div>
                        </div>

                        <!-- Box 2: Industri Penempatan -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                INDUSTRI MITRA DU/DI
                            </div>
                            <div class="text-xs font-bold text-slate-900" x-text="activePengajuan?.industri?.nama || '-'"></div>
                            <div class="text-[11px] text-slate-500 mt-1" x-text="activePengajuan?.industri?.alamat || 'Kawasan Industri'"></div>
                        </div>

                        <!-- Box 3: Guru Pembimbing -->
                        <div class="sm:col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">
                                GURU PEMBIMBING SEKOLAH
                            </div>
                            <div class="text-xs font-bold text-slate-900" x-text="activePengajuan?.penugasan?.pembimbing?.nama || 'Belum Dipetakan'"></div>
                            <div class="text-[11px] text-slate-500 mt-0.5" x-text="activePengajuan?.penugasan?.pembimbing?.nip ? 'NIP. ' + activePengajuan.penugasan.pembimbing.nip : 'Belum ada NIP'"></div>
                            <div class="text-[11px] text-emerald-600 font-semibold mt-1" x-show="activePengajuan?.penugasan?.tanggal_mulai" x-text="'Mulai Penugasan: ' + new Date(activePengajuan.penugasan.tanggal_mulai).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'})"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 flex items-center justify-end border-t border-slate-100">
                    <button type="button" @click="detailModalOpen = false" class="px-4 py-2 bg-[#0f2942] hover:bg-[#1a385c] text-white text-xs font-bold rounded-xl shadow-xs">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
function mappingApp() {
    return {
        createModalOpen: false,
        quickAssignModalOpen: false,
        editModalOpen: false,
        detailModalOpen: false,

        activePengajuan: null,

        editForm: {
            penugasan_id: null,
            siswa_nama: '',
            industri_nama: '',
            pembimbing_guru_id: '',
            tanggal_mulai: '',
        },

        openCreateModal() {
            this.createModalOpen = true;
        },

        openQuickAssignModal(pengajuan) {
            this.activePengajuan = pengajuan;
            this.quickAssignModalOpen = true;
        },

        openEditModal(pengajuan) {
            this.activePengajuan = pengajuan;
            let dateFormatted = new Date().toISOString().slice(0, 10);
            if (pengajuan.penugasan && pengajuan.penugasan.tanggal_mulai) {
                dateFormatted = pengajuan.penugasan.tanggal_mulai.substring(0, 10);
            }

            this.editForm = {
                penugasan_id: pengajuan.penugasan?.id || null,
                siswa_nama: pengajuan.siswa?.nama || 'Siswa',
                industri_nama: pengajuan.industri?.nama || 'Industri',
                pembimbing_guru_id: pengajuan.penugasan?.pembimbing_guru_id || '',
                tanggal_mulai: dateFormatted,
            };
            this.editModalOpen = true;
        },

        openDetailModal(pengajuan) {
            this.activePengajuan = pengajuan;
            this.detailModalOpen = true;
        }
    };
}
</script>
@endpush
