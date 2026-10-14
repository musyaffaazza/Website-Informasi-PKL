@extends('layouts.wali-kelas')

@section('title', 'Daftar Murid PKL — Kelas ' . ($rombelAktifNama ?? 'XII RPL 2') . ' | SIPRAK')

@section('content')
<div x-data="{
    detailModal: false,
    selectedStudent: null,
    tinjauModal: false,
    selectedPengajuan: null,
    nilaiModal: false,
    selectedNilai: null,
    showStudentDetail(s) {
        this.selectedStudent = s;
        this.detailModal = true;
    },
    openTinjau(s) {
        this.selectedStudent = s;
        this.tinjauModal = true;
    },
    openNilai(s) {
        this.selectedStudent = s;
        this.nilaiModal = true;
    }
}">
    <!-- Top Breadcrumb & Page Header -->
    <div class="mb-6">
        <!-- Breadcrumb Links -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
            <span class="text-slate-500">Wali Kelas</span>
            <span class="text-slate-300">›</span>
            <span class="text-slate-500">Rombel {{ $rombelAktifNama ?? 'XII RPL 2' }}</span>
            <span class="text-slate-300">›</span>
            <span class="text-slate-800 font-bold">Daftar Murid</span>
        </nav>

        <!-- Main Title, Subtitle & Action Buttons -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                    Daftar Murid PKL — Kelas {{ $rombelAktifNama ?? 'XII RPL 2' }}
                </h1>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed max-w-3xl">
                    Pantau perkembangan penempatan industri, verifikasi persetujuan, kehadiran, dan logbook siswa binaan wali kelas.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5 shrink-0">
                <a href="{{ route('wali-kelas.murid.cetak') }}"
                   target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold rounded-xl transition shadow-2xs">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Cetak Rekap</span>
                </a>

                <a href="{{ route('wali-kelas.murid.export') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition shadow-xs">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span>Export Rekap Kelas</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Stats Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card 1: TOTAL SISWA -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                    TOTAL SISWA
                </span>
                <div class="flex items-baseline gap-2 mt-1.5">
                    <span class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $totalSiswa }}</span>
                    <span class="text-xs font-semibold text-slate-500">Siswa Aktif</span>
                </div>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-slate-100/90 text-slate-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card 2: SEDANG BERJALAN -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                    SEDANG BERJALAN
                </span>
                <div class="flex items-baseline gap-2 mt-1.5">
                    <span class="text-2xl sm:text-3xl font-extrabold text-emerald-600 tracking-tight">{{ $sedangBerjalan }}</span>
                    <span class="text-xs font-semibold text-slate-500">{{ $persenBerjalan }}%</span>
                </div>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <!-- Card 3: MENUNGGU PERSETUJUAN -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                    MENUNGGU PERSETUJUAN
                </span>
                <div class="flex items-baseline gap-2 mt-1.5">
                    <span class="text-2xl sm:text-3xl font-extrabold text-amber-600 tracking-tight">{{ $menungguPersetujuan }}</span>
                    <span class="text-xs font-semibold text-amber-600">Perlu Respon</span>
                </div>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
        </div>

        <!-- Card 4: SELESAI PKL -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block">
                    SELESAI PKL
                </span>
                <div class="flex items-baseline gap-2 mt-1.5">
                    <span class="text-2xl sm:text-3xl font-extrabold text-sky-600 tracking-tight">{{ $selesaiPkl }}</span>
                    <span class="text-xs font-semibold text-slate-500">Tuntas Uji</span>
                </div>
            </div>
            <div class="w-11 h-11 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter Bar Container -->
    <div class="bg-white border border-slate-200 rounded-2xl p-3 sm:p-3.5 mb-6 shadow-2xs">
        <form method="GET" action="{{ route('wali-kelas.murid.index') }}" class="flex flex-col md:flex-row items-center gap-3">
            <!-- Search Input -->
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama murid, NISN, atau mitra industri..."
                       class="w-full pl-10 pr-4 py-2 text-xs text-slate-800 placeholder-slate-400 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-52">
                <select name="status"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-xs text-slate-700 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition cursor-pointer">
                    <option value="Semua Status" {{ request('status') == 'Semua Status' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                    <option value="Berjalan" {{ request('status') == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                    <option value="Menunggu Persetujuan" {{ request('status') == 'Menunggu Persetujuan' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <!-- Pembimbing Filter -->
            <div class="w-full md:w-56">
                <select name="pembimbing"
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2 text-xs text-slate-700 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition cursor-pointer">
                    <option value="Semua Pembimbing" {{ request('pembimbing') == 'Semua Pembimbing' || !request('pembimbing') ? 'selected' : '' }}>Semua Pembimbing</option>
                    @foreach($pembimbingList as $p)
                        <option value="{{ $p->nama }}" {{ request('pembimbing') == $p->nama ? 'selected' : '' }}>
                            {{ $p->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Reset Button -->
            <a href="{{ route('wali-kelas.murid.index') }}"
               class="px-4 py-2 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl transition flex items-center gap-1.5 shrink-0">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Reset</span>
            </a>
        </form>
    </div>

    <!-- Student Table Card -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-slate-400 font-bold uppercase text-[10px] tracking-wider">
                        <th class="py-3.5 px-5">NAMA SISWA / NISN</th>
                        <th class="py-3.5 px-5">MITRA INDUSTRI & PEMBIMBING</th>
                        <th class="py-3.5 px-5">KEHADIRAN & DURASI</th>
                        <th class="py-3.5 px-5">STATUS</th>
                        <th class="py-3.5 px-5 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($paginatedStudents as $s)
                    <tr class="hover:bg-slate-50/60 transition group">
                        <!-- Column 1: Siswa / NISN -->
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs shrink-0 {{ $s->avatar_bg }}">
                                    {{ $s->initials }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm leading-snug">
                                        {{ $s->nama }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 leading-tight">
                                        NISN: {{ $s->nisn }}
                                    </div>
                                    @if($s->catatan)
                                        <div class="text-[10px] font-semibold mt-0.5 {{ str_contains($s->catatan, 'Sidang') ? 'text-sky-600' : 'text-amber-600' }}">
                                            {{ $s->catatan }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Column 2: Mitra Industri & Pembimbing -->
                        <td class="py-4 px-5">
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold text-slate-900 text-sm">
                                        {{ $s->industri_nama }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-sky-50 text-sky-700 border border-sky-100">
                                        {{ $s->posisi }}
                                    </span>
                                </div>
                                <div class="mt-0.5">
                                    @if($s->pembimbing_nama)
                                        <span class="text-xs text-slate-500">Guru: {{ $s->pembimbing_nama }}</span>
                                    @else
                                        <span class="text-xs font-medium text-rose-500 flex items-center gap-1">
                                            <span>⚠️</span> Pembimbing Belum Ditugaskan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Column 3: Kehadiran & Durasi -->
                        <td class="py-4 px-5 w-56">
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="font-bold {{ $s->kehadiran_persen >= 90 ? 'text-emerald-600' : ($s->kehadiran_persen > 0 ? 'text-amber-600' : 'text-slate-400') }}">
                                    {{ $s->kehadiran_persen }}%
                                </span>
                                <span class="text-slate-500 text-[11px] font-medium">
                                    {{ $s->kehadiran_hari }}
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-300 {{ $s->kehadiran_persen == 100 ? 'bg-sky-500' : ($s->kehadiran_persen >= 90 ? 'bg-emerald-500' : ($s->kehadiran_persen > 0 ? 'bg-amber-500' : 'bg-slate-200')) }}"
                                     style="width: {{ $s->kehadiran_persen }}%;"></div>
                            </div>
                        </td>

                        <!-- Column 4: Status -->
                        <td class="py-4 px-5">
                            @if($s->status === 'Berjalan')
                                <div class="inline-flex items-center gap-2 text-xs font-semibold text-slate-800">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span>Berjalan</span>
                                </div>
                            @elseif($s->status === 'Menunggu Persetujuan')
                                <div class="inline-flex items-center gap-2 text-xs font-semibold text-amber-700">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <span>Menunggu Persetujuan</span>
                                </div>
                            @elseif($s->status === 'Selesai')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 border border-sky-200">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Selesai</span>
                                </span>
                            @endif
                        </td>

                        <!-- Column 5: Aksi -->
                        <td class="py-4 px-5 text-right whitespace-nowrap">
                            @if($s->status === 'Berjalan')
                                <button type="button"
                                        @click="showStudentDetail({{ json_encode($s) }})"
                                        class="text-xs font-bold text-slate-800 hover:text-sky-600 transition inline-flex items-center gap-1 cursor-pointer">
                                    <span>Detail Murid</span>
                                    <span class="text-sm">→</span>
                                </button>
                            @elseif($s->status === 'Menunggu Persetujuan')
                                <button type="button"
                                        @click="openTinjau({{ json_encode($s) }})"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#d97706] hover:bg-amber-700 text-white font-bold text-xs rounded-xl transition shadow-xs cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    <span>Tinjau Berkas</span>
                                </button>
                            @elseif($s->status === 'Selesai')
                                <button type="button"
                                        @click="openNilai({{ json_encode($s) }})"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-xs rounded-xl transition shadow-2xs cursor-pointer">
                                    <svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span>Lihat Nilai</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="text-xs font-semibold">Tidak ada data murid yang sesuai kriteria pencarian</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer: Pagination & Information -->
        <div class="px-5 py-4 bg-white border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs font-medium text-slate-500">
                Menampilkan <span class="font-bold text-slate-800">{{ $paginatedStudents->firstItem() ?? 1 }}–{{ $paginatedStudents->lastItem() ?? $paginatedStudents->count() }}</span> dari <span class="font-bold text-slate-800">{{ $paginatedStudents->total() }}</span> siswa kelas {{ $rombelAktifNama }}
            </div>

            <!-- Custom Pagination to match screenshot: Sebelumnya, 1, 2, 3, 4, 5, Selanjutnya -->
            <div class="flex items-center gap-1.5">
                @if($paginatedStudents->onFirstPage())
                    <span class="px-3 py-1.5 text-xs font-semibold text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $paginatedStudents->previousPageUrl() }}"
                       class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">
                        Sebelumnya
                    </a>
                @endif

                @foreach(range(1, $paginatedStudents->lastPage()) as $page)
                    @if($page == $paginatedStudents->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center text-xs font-bold text-white bg-[#0f2942] rounded-lg shadow-xs">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $paginatedStudents->url($page) }}"
                           class="w-8 h-8 flex items-center justify-center text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if($paginatedStudents->hasMorePages())
                    <a href="{{ $paginatedStudents->nextPageUrl() }}"
                       class="px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 rounded-lg transition">
                        Selanjutnya
                    </a>
                @else
                    <span class="px-3 py-1.5 text-xs font-semibold text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">
                        Selanjutnya
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal 1: Detail Murid -->
    <div x-show="detailModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div @click.away="detailModal = false"
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-extrabold text-slate-900 text-base">Detail Siswa PKL</h3>
                <button @click="detailModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <template x-if="selectedStudent">
                <div class="mt-4 space-y-3.5 text-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-sm"
                             :class="selectedStudent.avatar_bg"
                             x-text="selectedStudent.initials">
                        </div>
                        <div>
                            <div class="font-extrabold text-sm text-slate-900" x-text="selectedStudent.nama"></div>
                            <div class="text-slate-500" x-text="'NISN: ' + selectedStudent.nisn + ' • NIS: ' + selectedStudent.nis"></div>
                        </div>
                    </div>
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Mitra Industri:</span>
                            <span class="font-bold text-slate-800" x-text="selectedStudent.industri_nama"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Posisi:</span>
                            <span class="font-semibold text-sky-700" x-text="selectedStudent.posisi"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Guru Pembimbing:</span>
                            <span class="font-semibold text-slate-800" x-text="selectedStudent.pembimbing_nama || 'Belum Ditugaskan'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Kehadiran:</span>
                            <span class="font-bold text-emerald-600" x-text="selectedStudent.kehadiran_persen + '% (' + selectedStudent.kehadiran_hari + ')'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Periode Magang:</span>
                            <span class="font-medium text-slate-700" x-text="selectedStudent.tanggal_mulai + ' - ' + selectedStudent.tanggal_selesai"></span>
                        </div>
                    </div>
                </div>
            </template>
            <div class="mt-6 flex justify-end">
                <button @click="detailModal = false" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-bold text-xs">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal 2: Tinjau Berkas Pengajuan PKL -->
    <div x-show="tinjauModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div @click.away="tinjauModal = false"
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    <h3 class="font-extrabold text-slate-900 text-base">Tinjau Berkas Pengajuan PKL</h3>
                </div>
                <button @click="tinjauModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <template x-if="selectedStudent">
                <div class="mt-4 space-y-4 text-xs">
                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-amber-800">
                        <div class="font-bold text-xs" x-text="selectedStudent.catatan || 'Verifikasi Pengajuan PKL'"></div>
                        <div class="text-[11px] mt-0.5">Siswa mengajukan penempatan magang ke industri terkait dan memerlukan verifikasi wali kelas sebelum diajukan ke Kaprog.</div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500">Nama Siswa:</span>
                            <span class="font-bold text-slate-800" x-text="selectedStudent.nama"></span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500">NISN / NIS:</span>
                            <span class="font-medium text-slate-700" x-text="selectedStudent.nisn + ' / ' + selectedStudent.nis"></span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500">Tujuan DU/DI:</span>
                            <span class="font-bold text-slate-900" x-text="selectedStudent.industri_nama"></span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-slate-100">
                            <span class="text-slate-500">Peminatan Posisi:</span>
                            <span class="font-semibold text-sky-700" x-text="selectedStudent.posisi"></span>
                        </div>
                    </div>

                    <form :action="'{{ url('wali-kelas/persetujuan') }}/' + (selectedStudent.pengajuan_id || 1) + '/approve'" method="POST" class="pt-2">
                        @csrf
                        <label class="block text-slate-600 font-bold mb-1">Catatan Verifikasi Wali Kelas (Opsional):</label>
                        <textarea name="catatan" rows="2" placeholder="Catatan persetujuan berkas..." class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-sky-500/20 text-xs"></textarea>

                        <div class="mt-4 flex items-center justify-end gap-2.5">
                            <button type="button" @click="tinjauModal = false" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl font-bold text-xs hover:bg-slate-50">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs flex items-center gap-1.5 shadow-xs">
                                <span>✔ Setujui & Teruskan ke Kaprog</span>
                            </button>
                        </div>
                    </form>
                </div>
            </template>
        </div>
    </div>

    <!-- Modal 3: Lihat Nilai -->
    <div x-show="nilaiModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div @click.away="nilaiModal = false"
             class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-extrabold text-slate-900 text-base">Rekapitulasi Nilai PKL</h3>
                <button @click="nilaiModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <template x-if="selectedStudent">
                <div class="mt-4 space-y-3.5 text-xs">
                    <div class="text-center pb-2">
                        <div class="font-extrabold text-base text-slate-900" x-text="selectedStudent.nama"></div>
                        <div class="text-slate-500 text-[11px]" x-text="selectedStudent.industri_nama + ' • ' + selectedStudent.posisi"></div>
                        <span class="inline-block mt-2 px-3 py-1 bg-sky-100 text-sky-800 rounded-full font-extrabold text-xs">
                            Status: Tuntas PKL & Sidang
                        </span>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/80 space-y-2.5">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600">Nilai Pembimbing Sekolah:</span>
                            <span class="font-extrabold text-slate-900 text-sm">92.00</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-600">Nilai Mentor Industri DU/DI:</span>
                            <span class="font-extrabold text-slate-900 text-sm">95.00</span>
                        </div>
                        <div class="border-t border-slate-200 pt-2 flex justify-between items-center">
                            <span class="font-bold text-slate-800">Nilai Akhir Rata-rata:</span>
                            <span class="font-extrabold text-emerald-600 text-base">93.50 (A)</span>
                        </div>
                    </div>
                </div>
            </template>
            <div class="mt-6 flex justify-end">
                <button @click="nilaiModal = false" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-bold text-xs">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
