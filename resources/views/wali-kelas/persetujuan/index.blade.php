@extends('layouts.wali-kelas')

@section('title', 'Persetujuan PKL — Kelas ' . ($rombelAktifNama ?? 'XII RPL 2') . ' | SIPRAK')

@section('content')
<div x-data="{
    batchModal: false,
    rejectDrawer: {
        @foreach($pengajuans as $p)
            '{{ $p->id }}': false,
        @endforeach
    },
    toggleReject(id) {
        this.rejectDrawer[id] = !this.rejectDrawer[id];
    }
}">
    <!-- Top Breadcrumb & Page Header -->
    <div class="mb-5">
        <!-- Breadcrumb Links -->
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
            <span class="flex items-center gap-1.5 text-slate-500">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
                <span>Wali Kelas</span>
            </span>
            <span class="text-slate-300">›</span>
            <span class="text-slate-500">Rombel {{ $rombelAktifNama ?? 'XII RPL 2' }}</span>
            <span class="text-slate-300">›</span>
            <span class="text-slate-800 font-bold">Persetujuan PKL</span>
        </nav>

        <!-- Red Alert Notification Banner -->
        <div class="mb-4 p-2.5 sm:p-3 bg-red-50/90 border border-red-200/90 rounded-2xl flex items-center gap-2 text-xs font-semibold text-red-700 shadow-2xs">
            <span class="w-2.5 h-2.5 rounded-full bg-red-500 shrink-0 animate-pulse"></span>
            <span><strong>{{ $menungguTabCount }} Berkas Menunggu Persetujuan Anda</strong> — Batas Waktu Sinkronisasi: 14 Hari Kerja</span>
        </div>

        <!-- Main Title, Subtitle & Action Button -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
                    Persetujuan PKL — Verifikasi & Tanda Tangan Wali Kelas
                </h1>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed max-w-3xl">
                    Tinjau berkas pengajuan praktik kerja lapangan siswa kelas {{ $rombelAktifNama ?? 'XII RPL 2' }} tahap 1 (Wali Kelas) sebelum diteruskan ke Ketua Program Keahlian (Kaprog).
                </p>
            </div>

            <!-- Batch E-Sign Button -->
            <button type="button"
                    @click="batchModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-slate-800 text-white text-xs font-bold rounded-xl transition shadow-xs shrink-0 cursor-pointer">
                <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                <span>Tanda Tangani Semua Cepat (Batch)</span>
            </button>
        </div>
    </div>

    <!-- Alur Pengesahan Mandat Card -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 mb-6 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-xl bg-[#0f2942] text-sky-400 flex items-center justify-center shrink-0 shadow-xs">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <div class="font-extrabold text-xs sm:text-sm text-slate-900 tracking-wide uppercase">
                    ALUR PENGESAHAN MANDAT
                </div>
                <div class="text-[11px] text-slate-500 font-medium">
                    Sistem verifikasi berjenjang Standar PKL SMKN 1 Gunungputri
                </div>
            </div>
        </div>

        <!-- 3 Step Flow -->
        <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
            <!-- Step 1: Wali Kelas (Active) -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-[#0f2942] text-white text-xs font-bold shadow-xs">
                <span class="w-4 h-4 rounded-full bg-emerald-400 text-slate-900 text-[10px] font-extrabold flex items-center justify-center">1</span>
                <span>Wali Kelas (Anda)</span>
                <span class="px-1.5 py-0.2 text-[9px] font-extrabold rounded bg-slate-800 text-sky-400 border border-slate-700 uppercase">AKTIF</span>
            </div>

            <span class="text-slate-300 font-bold">→</span>

            <!-- Step 2: Kaprog RPL -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100/80 text-slate-600 text-xs font-semibold">
                <span class="w-4 h-4 rounded-full bg-slate-200 text-slate-600 text-[10px] font-bold flex items-center justify-center">2</span>
                <span>Kaprog {{ $jurusanSingkatan ?? 'RPL' }}</span>
            </div>

            <span class="text-slate-300 font-bold">→</span>

            <!-- Step 3: Pokja Hubin -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100/80 text-slate-600 text-xs font-semibold">
                <span class="w-4 h-4 rounded-full bg-slate-200 text-slate-600 text-[10px] font-bold flex items-center justify-center">3</span>
                <span>Pokja Hubin & SK Tugas</span>
            </div>
        </div>
    </div>

    <!-- Tab Bar & Token Indicator -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
        <!-- Status Tabs -->
        <div class="inline-flex items-center gap-1.5 p-1 bg-slate-100/90 rounded-xl text-xs font-bold">
            <a href="{{ route('wali-kelas.persetujuan.index', ['tab' => 'menunggu']) }}"
               class="px-4 py-2 rounded-lg transition flex items-center gap-2 {{ $activeTab === 'menunggu' ? 'bg-white text-slate-900 shadow-xs border border-slate-200/80' : 'text-slate-600 hover:text-slate-900' }}">
                <span>Menunggu Respon</span>
                <span class="px-1.5 py-0.5 text-[10px] font-extrabold rounded-full bg-red-600 text-white">
                    {{ $menungguTabCount }}
                </span>
            </a>

            <a href="{{ route('wali-kelas.persetujuan.index', ['tab' => 'disetujui']) }}"
               class="px-4 py-2 rounded-lg transition flex items-center gap-2 {{ $activeTab === 'disetujui' ? 'bg-white text-slate-900 shadow-xs border border-slate-200/80' : 'text-slate-600 hover:text-slate-900' }}">
                <span>Disetujui</span>
                <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-full bg-slate-200 text-slate-700">
                    {{ $disetujuiTabCount }}
                </span>
            </a>

            <a href="{{ route('wali-kelas.persetujuan.index', ['tab' => 'ditolak']) }}"
               class="px-4 py-2 rounded-lg transition flex items-center gap-2 {{ $activeTab === 'ditolak' ? 'bg-white text-slate-900 shadow-xs border border-slate-200/80' : 'text-slate-600 hover:text-slate-900' }}">
                <span>Ditolak</span>
                <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-full bg-slate-200 text-slate-700">
                    {{ $ditolakTabCount }}
                </span>
            </a>
        </div>

        <!-- Token e-Sign Badge -->
        <div class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-700">
            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span>Token e-Sign: <strong class="font-bold">SK1G-NIP-19750814</strong></span>
        </div>
    </div>

    <!-- Cards List for Submissions -->
    <div class="space-y-5 mb-8">
        @forelse($pengajuans as $p)
            @php
                $siswa = $p->siswa;
                $ind = $p->industri;
                $nisn = $siswa?->nisn ?? '';
                $details = $pendingDetails[$nisn] ?? null;

                $namaSiswa = $details['nama'] ?? ($siswa?->nama ?? 'Siswa PKL');
                $gender = $details['gender'] ?? ($siswa?->jenis_kelamin === 'P' ? 'Perempuan' : 'Laki-laki');
                $avatarBg = $details['avatar_bg'] ?? 'bg-amber-100 text-amber-700';
                $avatarInitials = $details['avatar_initials'] ?? strtoupper(substr($namaSiswa, 0, 2));
                $submittedTime = $details['submitted_time'] ?? ($p->dibuat_pada ? $p->dibuat_pada->format('d M Y · H:i WIB') : '04 Sep 2026 · 09:15 WIB');
                $companyName = $details['company_name'] ?? ($ind?->nama ?? 'Mitra DU/DI');
                $bidang = $details['bidang'] ?? ($ind?->bidang_usaha ?? 'Teknologi Informasi');
                $alamat = $details['alamat'] ?? ($ind?->alamat ?? 'Bogor');
                $relevansi = $details['relevansi'] ?? '98% Relevan RPL';
                $attachments = $details['attachments'] ?? [
                    ['label' => 'Form 1A (Permohonan Siswa) PDF', 'icon' => 'file'],
                    ['label' => 'Surat Kesediaan DU/DI', 'icon' => 'check'],
                ];
                $catatanSiswa = $details['catatan_siswa'] ?? 'Berkas permohonan magang PKL resmi diserahkan siswa.';
            @endphp

            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-2xs hover:border-slate-300 transition">
                <!-- Card Header: Student Profile & Status -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-slate-100 gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full flex items-center justify-center font-black text-sm shrink-0 {{ $avatarBg }}">
                            {{ $avatarInitials }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-extrabold text-sm sm:text-base text-slate-900 leading-tight">
                                    {{ $namaSiswa }}
                                </h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-600">
                                    {{ $gender }}
                                </span>
                            </div>
                            <div class="text-xs text-slate-400 mt-0.5">
                                NISN: {{ $nisn }} · Kelas {{ $rombelAktifNama }}
                            </div>
                        </div>
                    </div>

                    <!-- Right Status & Submission Time -->
                    <div class="sm:text-right">
                        @if($p->status === 'ditolak')
                            <div class="text-xs font-bold text-rose-600 flex items-center sm:justify-end gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                <span>Pengajuan Ditolak</span>
                            </div>
                        @elseif($p->status === 'disetujui' || $p->status === 'menunggu_kaprog')
                            <div class="text-xs font-bold text-emerald-600 flex items-center sm:justify-end gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Disetujui Tahap 1 (Wali Kelas)</span>
                            </div>
                        @else
                            <div class="text-xs font-bold text-amber-600 flex items-center sm:justify-end gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                <span>Menunggu Verifikasi Tahap 1</span>
                            </div>
                        @endif
                        <div class="text-[11px] text-slate-400 mt-0.5 flex items-center sm:justify-end gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $submittedTime }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Body: Target Company & Competency Match -->
                <div class="py-4 flex flex-col md:flex-row md:items-start justify-between gap-6">
                    <!-- Left: Company & Attachments -->
                    <div class="flex-1 space-y-3">
                        <div>
                            <div class="flex items-center gap-1.5 text-[10px] font-bold text-sky-700 uppercase tracking-wider mb-1">
                                <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span>PERUSAHAAN MITRA DU/DI DITUJU</span>
                            </div>
                            <h4 class="font-black text-base sm:text-lg text-slate-900 leading-tight">
                                {{ $companyName }}
                            </h4>
                            <div class="flex items-center gap-2.5 text-xs text-slate-600 mt-1 flex-wrap font-medium">
                                <span class="flex items-center gap-1 text-slate-700">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                    </svg>
                                    <span>Bidang: {{ $bidang }}</span>
                                </span>
                                <span class="text-slate-300">•</span>
                                <span class="flex items-center gap-1 text-slate-500">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $alamat }}</span>
                                </span>
                            </div>
                        </div>

                        <!-- Attachments Row -->
                        <div class="pt-1 flex items-center gap-2 flex-wrap">
                            <span class="text-xs font-semibold text-slate-500 mr-1">Berkas Lampiran:</span>
                            @foreach($attachments as $att)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-100 hover:bg-sky-100/80 transition cursor-pointer">
                                    @if(($att['icon'] ?? '') === 'check')
                                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                    @elseif(($att['icon'] ?? '') === 'mail')
                                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    @elseif(($att['icon'] ?? '') === 'badge')
                                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    @endif
                                    <span>{{ $att['label'] ?? '' }}</span>
                                </span>
                            @endforeach
                        </div>

                        <!-- Catatan dari Siswa -->
                        <div class="p-3 bg-slate-50/80 rounded-xl border border-slate-100 flex items-start gap-2.5 text-xs text-slate-600">
                            <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            <div class="leading-relaxed">
                                <span class="font-bold text-slate-700">Catatan dari Siswa:</span>
                                <span class="italic text-slate-600">"{{ $catatanSiswa }}"</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Kesesuaian Kompetensi Card -->
                    <div class="w-full md:w-56 shrink-0 bg-sky-50/70 border border-sky-100 rounded-2xl p-4 text-center">
                        <div class="text-[11px] font-semibold text-slate-500 mb-1">
                            Kesesuaian Kompetensi
                        </div>
                        <div class="text-sm font-extrabold text-emerald-600 flex items-center justify-center gap-1.5">
                            <span class="text-amber-500">★</span>
                            <span>{{ $relevansi }}</span>
                        </div>
                    </div>
                </div>

                <!-- Card Actions: Tolak & Setujui -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-3">
                    <!-- Tombol Tolak (Toggle Drawer) -->
                    <button type="button"
                            @click="toggleReject('{{ $p->id }}')"
                            class="px-4 py-2 border border-rose-200 hover:bg-rose-50 text-rose-600 font-bold text-xs rounded-xl transition flex items-center gap-1.5 cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Tolak</span>
                    </button>

                    <!-- Tombol Setujui & E-Sign -->
                    <form action="{{ route('wali-kelas.persetujuan.approve', $p->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-5 py-2 bg-[#0f2942] hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition shadow-xs flex items-center gap-2 cursor-pointer">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            <span>Setujui & Bubuhkan E-Sign</span>
                        </button>
                    </form>
                </div>

                <!-- Drawer Alasan Penolakan untuk Siswa -->
                <div x-show="rejectDrawer['{{ $p->id }}']"
                     x-cloak
                     class="mt-4 p-4 bg-rose-50/60 border border-rose-200 rounded-2xl transition">
                    <form action="{{ route('wali-kelas.persetujuan.reject', $p->id) }}" method="POST">
                        @csrf
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-xs font-bold text-rose-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                <span>Alasan Penolakan untuk Siswa:</span>
                            </div>
                            <span class="text-[10px] text-slate-500 font-medium">
                                Notifikasi otomatis dikirim via WhatsApp & SIPRAK Student
                            </span>
                        </div>

                        <textarea name="catatan"
                                  rows="2"
                                  placeholder="Tuliskan catatan perbaikan berkas (contoh: cap basah perusahaan belum terlihat jelas, dsb)..."
                                  class="w-full p-3 bg-white border border-rose-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500"></textarea>

                        <div class="mt-3 flex items-center justify-end gap-2.5">
                            <button type="button"
                                    @click="toggleReject('{{ $p->id }}')"
                                    class="px-3.5 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 text-xs font-bold rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-4 py-1.5 bg-[#ea580c] hover:bg-orange-700 text-white text-xs font-bold rounded-xl transition flex items-center gap-1.5 shadow-xs">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                <span>Kirim Penolakan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 rounded-2xl p-12 text-center text-slate-400 shadow-2xs">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <div class="font-bold text-slate-700 text-sm">Tidak ada berkas pengajuan</div>
                <div class="text-xs text-slate-400 mt-0.5">Semua pengajuan pada tab ini telah selesai diproses.</div>
            </div>
        @endforelse
    </div>

    <!-- Bottom Verification Disclaimer Card -->
    <div class="bg-white border border-slate-200/90 rounded-2xl p-4 sm:p-5 shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed">
                Tervalidasi dengan e-Sign digital resmi <strong class="text-slate-800">SMK Negeri 1 Gunungputri</strong> sesuai pedoman vokasi Kemendikbudristek RI. Kunci kriptografi tersimpan aman pada server sekolah.
            </p>
        </div>

        <a href="{{ route('wali-kelas.murid.export') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 font-bold text-xs rounded-xl transition shadow-2xs shrink-0">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            <span>Unduh Rekap Form 1A</span>
        </a>
    </div>

    <!-- Modal: Batch E-Sign Approval -->
    <div x-show="batchModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
        <div @click.away="batchModal = false"
             class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-xl border border-slate-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </div>
                    <h3 class="font-extrabold text-slate-900 text-base">Konfirmasi Batch E-Sign</h3>
                </div>
                <button @click="batchModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>

            <div class="mt-4 space-y-3.5 text-xs">
                <p class="text-slate-600 leading-relaxed">
                    Anda akan membubuhkan tanda tangan elektronik (e-Sign) secara kolektif untuk seluruh berkas pengajuan PKL siswa yang berstatus <strong class="text-slate-900">Menunggu Respon</strong> pada kelas <strong class="text-slate-900">{{ $rombelAktifNama }}</strong>.
                </p>

                <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/80 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Jumlah Berkas:</span>
                        <span class="font-bold text-slate-800">{{ $menungguTabCount }} Berkas Pengajuan</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Otoritas Penandatangan:</span>
                        <span class="font-bold text-slate-800">Dra. Hj. Nurhayati, M.Pd. (Wali Kelas)</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Kunci Sertifikat:</span>
                        <span class="font-mono font-bold text-sky-700">SK1G-NIP-19750814</span>
                    </div>
                </div>

                <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-amber-800 text-[11px] leading-relaxed">
                    Setiap berkas yang disetujui akan otomatis dialihkan ke tahap verifikasi berikutnya yaitu <strong class="text-amber-900">Ketua Program Keahlian (Kaprog)</strong>.
                </div>
            </div>

            <form action="{{ route('wali-kelas.persetujuan.batch-approve') }}" method="POST" class="mt-6 flex justify-end gap-2.5">
                @csrf
                <button type="button" @click="batchModal = false" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl font-bold text-xs hover:bg-slate-50">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-[#0f2942] hover:bg-slate-800 text-white rounded-xl font-bold text-xs flex items-center gap-2 shadow-xs cursor-pointer">
                    <span>✔ Tanda Tangani & Setujui Semua</span>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
