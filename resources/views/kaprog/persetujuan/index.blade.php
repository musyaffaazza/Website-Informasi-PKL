@extends('layouts.kaprog')

@section('title', 'Persetujuan PKL Siswa — Rekayasa Perangkat Lunak | SIPRAK')

@section('content')
<div x-data="{
    selectAll: false,
    selected: [],
    allIds: {{ json_encode($antrean->pluck('id')->values()->toArray()) }},
    toggleSelectAll() {
        if (this.selectAll) {
            this.selected = [...this.allIds];
        } else {
            this.selected = [];
        }
    },
    // Modal Revisi / Catatan
    openModalRevisi: false,
    selectedRevisiItem: {
        id: 102,
        nama: 'Farhan Maulana',
        kelas: 'XII RPL 1',
        industri: 'CV Mitra Logika Grafika',
        posisi: 'Digital Printing & Kasir',
        alasan: 'Perusahaan yang dituju bergerak di bidang Digital Printing & Kasir. Bidang ini termasuk kompetensi DKV / Retail, sehingga tidak memenuhi capaian kurikulum Rekayasa Perangkat Lunak (RPL).',
        rekomendasi: 'Arahkan siswa Farhan Maulana untuk mendaftar ke slot kemitraan resmi RPL: PT Indocyber Global Technology atau Divisi IT RS Thamrin Cileungsi (masih tersedia 2 kuota).'
    },
    bukaModalRevisi(item) {
        this.selectedRevisiItem = item;
        this.openModalRevisi = true;
    },
    // Modal Berkas Lampiran
    openModalBerkas: false,
    selectedBerkasItem: null,
    bukaModalBerkas(item) {
        this.selectedBerkasItem = item;
        this.openModalBerkas = true;
    },
    // Modal Konfirmasi Dispensasi
    openModalDispensasi: false,
    selectedDispensasiItem: null,
    bukaModalDispensasi(item) {
        this.selectedDispensasiItem = item;
        this.openModalDispensasi = true;
    }
}" class="space-y-6 pb-10">

    <!-- Top Breadcrumb & Page Header -->
    <div>
        <nav class="flex items-center gap-1.5 text-xs font-semibold text-slate-400 mb-2">
            <a href="{{ route('kaprog.murid-pkl.index') }}" class="text-slate-500 hover:text-sky-600 transition">Kaprog RPL</a>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-slate-800 font-bold">Persetujuan Tempat PKL</span>
        </nav>

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                        Persetujuan Tempat PKL Siswa
                    </h1>
                    <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 rounded-full text-xs font-bold">
                        {{ $menungguCount }} Pengajuan Perlu Diperiksa
                    </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed max-w-3xl">
                    Periksa kesesuaian bidang magang dan berikan persetujuan untuk siswa kelas XII Rekayasa Perangkat Lunak.
                </p>
            </div>

            <!-- Tombol Aksi Cepat -->
            <div class="flex items-center gap-2.5 shrink-0">
                <a href="{{ route('kaprog.persetujuan.export') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition shadow-2xs">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Unduh Rekap (.CSV)</span>
                </a>

                <form action="{{ route('kaprog.persetujuan.batch-approve') }}" method="POST">
                    @csrf
                    <template x-for="id in selected" :key="id">
                        <input type="hidden" name="selected_ids[]" :value="id">
                    </template>
                    <button type="submit"
                            :disabled="selected.length === 0"
                            :class="selected.length === 0 ? 'opacity-50 cursor-not-allowed bg-slate-400' : 'bg-emerald-600 hover:bg-emerald-700'"
                            class="inline-flex items-center gap-2 px-4 py-2.5 text-white text-xs font-bold rounded-xl transition shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Setujui Semua yang Dipilih (<span x-text="selected.length"></span>)</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Alur Otorisasi 3 Langkah (Sangat Jelas & Mudah Dipahami) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-2xs">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                Alur Tahapan Persetujuan PKL
            </span>
            <span class="text-xs font-semibold text-slate-400">
                SMK Negeri 1 Gunungputri
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
            <!-- Tahap 1: Wali Kelas -->
            <div class="p-3.5 rounded-xl border border-emerald-200 bg-emerald-50/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-extrabold text-xs flex items-center justify-center shrink-0">
                    ✓
                </div>
                <div>
                    <div class="text-xs font-bold text-emerald-900 leading-tight">1. Wali Kelas</div>
                    <div class="text-[11px] text-emerald-700 font-medium mt-0.5">Sikap, BK, & Izin Ortu</div>
                    <div class="text-[11px] font-bold text-emerald-600 mt-0.5">{{ $totalSiswa > 0 ? 'Sudah Disetujui (' . $totalSiswa . ' Siswa)' : 'Belum Ada Siswa' }}</div>
                </div>
            </div>

            <!-- Tahap 2: Kaprog RPL (Sedang Berjalan) -->
            <div class="p-3.5 rounded-xl border-2 border-sky-400 bg-sky-50/70 flex items-center gap-3 shadow-xs">
                <div class="w-8 h-8 rounded-full bg-sky-600 text-white font-extrabold text-xs flex items-center justify-center shrink-0 animate-pulse">
                    2
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-extrabold text-slate-900 leading-tight">2. Kaprog RPL</span>
                        <span class="px-1.5 py-0.5 bg-sky-600 text-white text-[10px] font-extrabold rounded">
                            GILIRAN ANDA
                        </span>
                    </div>
                    <div class="text-[11px] text-slate-600 font-medium mt-0.5">Kesesuaian Kompetensi Kerja</div>
                    <div class="text-[11px] font-bold text-sky-700 mt-0.5">{{ $menungguCount }} Berkas Perlu Keputusan</div>
                </div>
            </div>

            <!-- Tahap 3: Hubinmas & Kepala Sekolah -->
            <div class="p-3.5 rounded-xl border border-slate-200 bg-slate-50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-500 font-extrabold text-xs flex items-center justify-center shrink-0">
                    3
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-700 leading-tight">3. Waka Hubin & Kepsek</div>
                    <div class="text-[11px] text-slate-400 font-medium mt-0.5">Penerbitan Surat Tugas Resmi</div>
                    <div class="text-[11px] font-semibold text-slate-400 mt-0.5">Menunggu Otorisasi Kaprog</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Navigasi Tab Status -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <!-- Tab Pilihan -->
        <div class="flex items-center gap-2">
            <a href="{{ route('kaprog.persetujuan.index', ['tab' => 'menunggu']) }}"
               class="px-4 py-2 {{ $activeTab === 'menunggu' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-2xs' }} rounded-xl text-xs font-bold flex items-center gap-2 transition">
                <span>Perlu Diperiksa</span>
                <span class="px-2 py-0.5 {{ $activeTab === 'menunggu' ? 'bg-amber-400 text-slate-900' : 'bg-amber-100 text-amber-800' }} text-[11px] font-extrabold rounded-full">
                    {{ $menungguCount }}
                </span>
            </a>

            <a href="{{ route('kaprog.persetujuan.index', ['tab' => 'disetujui']) }}"
               class="px-4 py-2 {{ $activeTab === 'disetujui' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-2xs' }} rounded-xl text-xs font-bold flex items-center gap-2 transition">
                <span>Sudah Disetujui</span>
                <span class="px-2 py-0.5 {{ $activeTab === 'disetujui' ? 'bg-emerald-400 text-slate-900' : 'bg-slate-100 text-slate-600' }} text-[11px] font-bold rounded-full">
                    {{ $disetujuiCount }}
                </span>
            </a>

            <a href="{{ route('kaprog.persetujuan.index', ['tab' => 'ditolak']) }}"
               class="px-4 py-2 {{ $activeTab === 'ditolak' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-2xs' }} rounded-xl text-xs font-bold flex items-center gap-2 transition">
                <span>Perlu Revisi</span>
                <span class="px-2 py-0.5 {{ $activeTab === 'ditolak' ? 'bg-rose-400 text-slate-900' : 'bg-rose-50 text-rose-600 border border-rose-200' }} text-[11px] font-bold rounded-full">
                    {{ $ditolakCount }}
                </span>
            </a>
        </div>

        <!-- Pencarian Cepat -->
        <form action="{{ route('kaprog.persetujuan.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
            <input type="hidden" name="tab" value="{{ $activeTab }}">
            <div class="relative flex-1 sm:w-72">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari siswa atau nama PT..."
                       class="w-full h-10 pl-9 pr-3 bg-white border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
            </div>
            @if(request('search'))
                <a href="{{ route('kaprog.persetujuan.index', ['tab' => $activeTab]) }}" 
                   class="h-10 px-3 flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 text-xs font-semibold transition"
                   title="Reset Pencarian">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Reset</span>
                </a>
            @endif
        </form>
    </div>

    <!-- TABEL UTAMA PENGAJUAN (Sangat Rapi, Jelas, dan Tidak Ada Accordion Pemecah Baris) -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/90 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-12 text-center">
                            <input type="checkbox"
                                   x-model="selectAll"
                                   @change="toggleSelectAll()"
                                   class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer"
                                   title="Pilih Semua">
                        </th>
                        <th class="py-3.5 px-4">Nama Siswa &amp; Kelas</th>
                        <th class="py-3.5 px-4">Perusahaan yang Dituju</th>
                        <th class="py-3.5 px-4">Kesesuaian Jurusan RPL</th>
                        <th class="py-3.5 px-4">Wali Kelas</th>
                        <th class="py-3.5 px-4 text-center">Berkas</th>
                        <th class="py-3.5 px-6 text-center">Keputusan Kaprog</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($antrean as $item)
                        @php
                            $isProblematic = $item['has_perhatian'] ?? false;
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition {{ $isProblematic ? 'bg-amber-50/30' : '' }}">
                            <!-- Checkbox -->
                            <td class="py-4 px-4 text-center">
                                <input type="checkbox"
                                       :value="{{ $item['id'] }}"
                                       x-model="selected"
                                       class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer">
                            </td>

                            <!-- Siswa & Kelas -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full {{ $isProblematic ? 'bg-amber-100 text-amber-800 border-amber-300' : 'bg-sky-100 text-sky-800 border-sky-200' }} border font-extrabold text-xs flex items-center justify-center shrink-0">
                                        {{ $item['initials'] }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-sm text-slate-900 leading-tight">
                                            {{ $item['nama'] }}
                                        </div>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 font-bold text-[11px] rounded">
                                                {{ $item['kelas'] }}
                                            </span>
                                            <span class="text-slate-400 text-[11px]">
                                                NISN: {{ $item['nisn'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Target Mitra DU/DI -->
                            <td class="py-4 px-4">
                                <div>
                                    <div class="font-bold text-slate-900 text-xs sm:text-[13px]">
                                        {{ $item['industri'] }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ $item['lokasi'] }}
                                    </div>
                                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 mt-1 rounded text-[11px] font-semibold {{ $isProblematic ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-sky-50 text-sky-700' }}">
                                        <span>Posisi: <strong>{{ $item['posisi'] }}</strong></span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kesesuaian RPL (Bahasa Manusiawi & Jelas) -->
                            <td class="py-4 px-4">
                                <div>
                                    @if($item['kesesuaian_status'] === 'high')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 rounded-lg text-xs font-bold">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span>Sesuai Kurikulum</span>
                                        </span>
                                        <div class="text-[11px] text-slate-500 font-medium mt-1">
                                            {{ $item['kesesuaian_label'] }} ({{ $item['kesesuaian_score'] }}%)
                                        </div>
                                    @elseif($item['kesesuaian_status'] === 'medium')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-sky-50 text-sky-800 border border-sky-200 rounded-lg text-xs font-bold">
                                            <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span>Sesuai (Jaringan/IT)</span>
                                        </span>
                                        <div class="text-[11px] text-slate-500 font-medium mt-1">
                                            {{ $item['kesesuaian_label'] }} ({{ $item['kesesuaian_score'] }}%)
                                        </div>
                                    @else
                                        <!-- Farhan Maulana (Bermasalah) -->
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-rose-50 text-rose-800 border border-rose-200 rounded-lg text-xs font-bold">
                                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                            <span>Tidak Sesuai Jurusan</span>
                                        </span>
                                        <div class="text-[11px] text-rose-600 font-bold mt-1">
                                            Bidang Retail / Kasir ({{ $item['kesesuaian_score'] }}%)
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Validasi Wali Kelas -->
                            <td class="py-4 px-4">
                                <div>
                                    <span class="inline-flex items-center gap-1 text-emerald-700 font-bold text-xs">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Disetujui Wali Kelas
                                    </span>
                                    <div class="text-[11px] text-slate-800 font-semibold mt-0.5">
                                        {{ $item['wali_nama'] }}
                                    </div>
                                    <div class="text-[10px] text-slate-400">
                                        {{ $item['wali_catatan'] }}
                                    </div>
                                </div>
                            </td>

                            <!-- Berkas Dokumen Lampiran -->
                            <td class="py-4 px-4 text-center">
                                <button type="button"
                                        @click="bukaModalBerkas({{ json_encode($item) }})"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition"
                                        title="Klik untuk melihat berkas lampiran">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>{{ $item['lampiran_count'] }} Dokumen</span>
                                </button>
                            </td>

                            <!-- Keputusan Kaprog (Aksi Terang & Jelas) -->
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($isProblematic)
                                        <!-- Siswa yang Tidak Sesuai Jurusan: Tombol Beri Catatan & Tombol Dispensasi -->
                                        <button type="button"
                                                @click="bukaModalRevisi({
                                                    id: {{ $item['id'] }},
                                                    nama: '{{ $item['nama'] }}',
                                                    kelas: '{{ $item['kelas'] }}',
                                                    industri: '{{ $item['industri'] }}',
                                                    posisi: '{{ $item['posisi'] }}',
                                                    alasan: '{{ $item['revisi_note'] ?? 'Perusahaan tidak sesuai dengan capaian pembelajaran kompetensi keahlian RPL.' }}',
                                                    rekomendasi: '{{ $item['revisi_rekomendasi'] ?? 'Arahkan siswa untuk memilih mitra industri DUDI resmi jurusan RPL.' }}'
                                                })"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-lg transition shadow-xs">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span>Beri Catatan Revisi</span>
                                        </button>

                                        <button type="button"
                                                @click="bukaModalDispensasi({{ json_encode($item) }})"
                                                class="px-2.5 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition"
                                                title="Izinkan dispensasi khusus">
                                            Dispensasi
                                        </button>
                                    @else
                                        <!-- Siswa yang Sesuai: Tombol Setujui -->
                                        <form action="{{ route('kaprog.persetujuan.approve', $item['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition shadow-xs">
                                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span>Setujui</span>
                                            </button>
                                        </form>

                                        <button type="button"
                                                @click="bukaModalRevisi({
                                                    id: {{ $item['id'] }},
                                                    nama: '{{ $item['nama'] }}',
                                                    kelas: '{{ $item['kelas'] }}',
                                                    industri: '{{ $item['industri'] }}',
                                                    posisi: '{{ $item['posisi'] }}',
                                                    alasan: 'Harap periksa kembali berkas dan persyaratan magang.',
                                                    rekomendasi: 'Mohon lengkapi dokumen pendukung sebelum disetujui.'
                                                })"
                                                class="px-2 py-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg text-xs font-semibold transition"
                                                title="Tolak atau Minta Revisi">
                                            Tolak
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 text-xs font-medium">
                                Tidak ada pengajuan yang perlu diperiksa pada tab ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Ringkasan Antrean -->
        <div class="px-6 py-3.5 bg-slate-50/80 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-slate-500">
            <div>
                Menampilkan <strong>{{ $antrean->count() }} pengajuan PKL</strong> yang siap diproses oleh Ketua Program Keahlian.
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <span>Tervalidasi Digital SIPRAK SMKN 1 Gunungputri</span>
            </div>
        </div>
    </div>

    <!-- MODAL 1: CATATAN REVISI (Pop-up Bersih di Tengah Layar) -->
    <div x-show="openModalRevisi"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div @click.outside="openModalRevisi = false"
             x-transition
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            
            <!-- Header Modal -->
            <div class="flex items-start justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center gap-2.5 text-rose-700">
                    <div class="w-8 h-8 rounded-lg bg-rose-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Catatan Revisi Tempat PKL</h3>
                        <div class="text-xs text-slate-500" x-text="selectedRevisiItem.nama + ' (' + selectedRevisiItem.kelas + ')'"></div>
                    </div>
                </div>
                <button @click="openModalRevisi = false" class="text-slate-400 hover:text-slate-600 text-lg font-bold leading-none">
                    &times;
                </button>
            </div>

            <!-- Penjelasan Masalah -->
            <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-900 leading-relaxed">
                <div class="font-bold mb-1 flex items-center gap-1.5">
                    <span>⚠️ Masalah yang Ditemukan:</span>
                </div>
                <p x-text="selectedRevisiItem.alasan"></p>
            </div>

            <!-- Form Catatan Kaprog -->
            <form :action="'/kaprog/persetujuan/' + selectedRevisiItem.id + '/reject'" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Arahan / Saran Solusi dari Kaprog RPL:
                    </label>
                    <textarea name="catatan"
                              rows="3"
                              class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 leading-relaxed"
                              x-model="selectedRevisiItem.rekomendasi"
                              placeholder="Ketikkan arahan tempat alternatif atau hal yang harus diperbaiki siswa..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2 border-t border-slate-100">
                    <button type="button"
                            @click="openModalRevisi = false"
                            class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition shadow-xs">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        <span>Kirim Catatan ke Siswa &amp; Wali Kelas</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: PRATINJAU BERKAS DOKUMEN -->
    <div x-show="openModalBerkas"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div @click.outside="openModalBerkas = false"
             x-transition
             class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div>
                    <h3 class="font-bold text-sm text-slate-900">Kelengkapan Berkas PKL</h3>
                    <div class="text-xs text-slate-500" x-text="selectedBerkasItem?.nama + ' (' + selectedBerkasItem?.kelas + ')'"></div>
                </div>
                <button @click="openModalBerkas = false" class="text-slate-400 hover:text-slate-600 text-lg font-bold leading-none">
                    &times;
                </button>
            </div>

            <div class="space-y-2.5">
                <div class="p-3 rounded-xl border border-slate-200 flex items-center justify-between bg-slate-50/60">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded bg-rose-100 text-rose-700 flex items-center justify-center text-xs font-bold">PDF</span>
                        <div>
                            <div class="text-xs font-bold text-slate-800">Formulir Pengajuan PKL</div>
                            <div class="text-[10px] text-slate-400">Ditandatangani siswa</div>
                        </div>
                    </div>
                    <span class="text-emerald-600 text-xs font-bold">Lengkap ✓</span>
                </div>

                <div class="p-3 rounded-xl border border-slate-200 flex items-center justify-between bg-slate-50/60">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded bg-sky-100 text-sky-700 flex items-center justify-center text-xs font-bold">PDF</span>
                        <div>
                            <div class="text-xs font-bold text-slate-800">Surat Izin Orang Tua / Wali</div>
                            <div class="text-[10px] text-slate-400">Bermaterai 10.000</div>
                        </div>
                    </div>
                    <span class="text-emerald-600 text-xs font-bold">Lengkap ✓</span>
                </div>

                <div class="p-3 rounded-xl border border-slate-200 flex items-center justify-between bg-slate-50/60">
                    <div class="flex items-center gap-2.5">
                        <span class="w-7 h-7 rounded bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold">CV</span>
                        <div>
                            <div class="text-xs font-bold text-slate-800">Portofolio &amp; CV Siswa</div>
                            <div class="text-[10px] text-slate-400">Katalog karya & sertifikat</div>
                        </div>
                    </div>
                    <span class="text-emerald-600 text-xs font-bold">Lengkap ✓</span>
                </div>
            </div>

            <div class="pt-2">
                <button type="button"
                        @click="openModalBerkas = false"
                        class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 3: KONFIRMASI DISPENSASI KHUSUS -->
    <div x-show="openModalDispensasi"
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
        <div @click.outside="openModalDispensasi = false"
             x-transition
             class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="font-bold text-sm text-slate-900">Konfirmasi Dispensasi Khusus</h3>
                <button @click="openModalDispensasi = false" class="text-slate-400 hover:text-slate-600 text-lg font-bold leading-none">
                    &times;
                </button>
            </div>

            <p class="text-xs text-slate-600 leading-relaxed">
                Apakah Anda yakin ingin memberikan dispensasi penempatan di <strong x-text="selectedDispensasiItem?.industri"></strong> untuk siswa <strong x-text="selectedDispensasiItem?.nama"></strong>?
            </p>

            <form :action="'/kaprog/persetujuan/' + (selectedDispensasiItem?.id ?? 102) + '/dispensasi'" method="POST" class="pt-2">
                @csrf
                <div class="flex items-center justify-end gap-2.5">
                    <button type="button"
                            @click="openModalDispensasi = false"
                            class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl transition shadow-xs">
                        Ya, Berikan Dispensasi
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
