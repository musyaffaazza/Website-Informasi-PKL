@extends('layouts.wali-kelas')

@section('title', 'Jurnal Kegiatan Murid — ' . ($selectedSiswa->nama ?? 'Raka Pratama') . ' | SIPRAK')

@section('content')
<div class="space-y-6" x-data="{
    activeTab: '{{ $selectedDate }}',
    catatanInput: '{{ addslashes($activeJurnal->catatan_wali_kelas ?? '') }}',
    addQuickNote(text) {
        if (!this.catatanInput.trim()) {
            this.catatanInput = text;
        } else {
            this.catatanInput += ' ' + text;
        }
    }
}">

    <!-- Alert Success / Info -->
    @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-emerald-800 text-xs font-semibold shadow-2xs">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" @click="$el.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">✕</button>
    </div>
    @endif

    <!-- Top Navigation & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500">
            <a href="{{ route('wali-kelas.murid.index') }}" class="hover:text-slate-800 flex items-center gap-1.5 transition">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Wali Kelas</span>
            </a>
            <span class="text-slate-300">›</span>
            <span class="text-slate-500">Jurnal Murid</span>
            <span class="text-slate-300">›</span>
            <span class="text-slate-900 font-extrabold">{{ $selectedSiswa->nama ?? 'Raka Pratama' }}</span>
        </nav>

        <div class="flex items-center gap-3">
            <!-- Student Selector Dropdown -->
            <div class="relative" x-data="{ openMurid: false }">
                <button @click="openMurid = !openMurid"
                        class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 shadow-2xs transition">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Ganti Siswa</span>
                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="openMurid"
                     x-cloak
                     @click.away="openMurid = false"
                     class="absolute right-0 mt-2 w-64 bg-white border border-slate-200 rounded-xl shadow-xl z-30 max-h-72 overflow-y-auto divide-y divide-slate-100">
                    <div class="p-2 text-[10px] font-bold uppercase text-slate-400 tracking-wider">Pilih Siswa Rombel</div>
                    @foreach($rombelStudents as $s)
                    <a href="{{ route('wali-kelas.jurnal.index', ['siswa_id' => $s->id]) }}"
                       class="flex items-center justify-between px-3 py-2 text-xs hover:bg-slate-50 {{ $s->id == $selectedSiswa->id ? 'bg-sky-50/70 font-bold text-sky-800' : 'text-slate-700' }}">
                        <span>{{ $s->nama }}</span>
                        <span class="text-[10px] text-slate-400 font-mono">{{ $s->nisn }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Back to Student List Button -->
            <a href="{{ route('wali-kelas.murid.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:text-slate-900 hover:bg-slate-50 shadow-2xs transition">
                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Daftar Murid</span>
            </a>
        </div>
    </div>

    <!-- Student Profile Header Banner -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-2xs flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
        <div class="flex items-start sm:items-center gap-4">
            <!-- Avatar Initials -->
            <div class="w-14 h-14 rounded-full bg-sky-100 border border-sky-200 flex items-center justify-center shrink-0 text-sky-700 font-extrabold text-xl shadow-xs">
                @php
                    $nameWords = explode(' ', preg_replace('/[^a-zA-Z\s]/', '', $selectedSiswa->nama));
                    $initials = '';
                    foreach ($nameWords as $w) {
                        if ($w) { $initials .= strtoupper($w[0]); if(strlen($initials)>=2) break; }
                    }
                    if (!$initials) $initials = 'RP';
                @endphp
                {{ $initials }}
            </div>

            <div class="space-y-1">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h1 class="text-lg sm:text-xl font-extrabold text-slate-900 tracking-tight">
                        {{ $selectedSiswa->nama }}
                    </h1>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Aktif Magang
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200/60">
                        {{ $rombelAktifNama ?? 'XII RPL 2' }}
                    </span>
                </div>
                <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs text-slate-500 leading-relaxed">
                    <span>NISN: <span class="font-mono font-medium text-slate-700">{{ $selectedSiswa->nisn }}</span></span>
                    <span class="text-slate-300">•</span>
                    <span>Industri: <strong class="text-slate-800 font-semibold">{{ $industriNama }}</strong> (Network & App Support)</span>
                    <span class="text-slate-300">•</span>
                    <span>Guru Pembimbing: <strong class="text-slate-800 font-semibold">{{ $pembimbingNama }}</strong></span>
                </div>
            </div>
        </div>

        <!-- Right Quick Stats Pills -->
        <div class="flex items-center gap-3 shrink-0 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
            <div class="px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200/80 text-left">
                <div class="text-[9px] font-extrabold uppercase tracking-wider text-slate-400">TOTAL LOGBOOK</div>
                <div class="text-sm font-extrabold text-slate-900 mt-0.5">48 / 50 Hari</div>
            </div>
            <div class="px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200/80 text-left">
                <div class="text-[9px] font-extrabold uppercase tracking-wider text-slate-400">PRESENSI</div>
                <div class="text-sm font-extrabold text-emerald-600 mt-0.5">96%</div>
            </div>
        </div>
    </div>

    <!-- Date Selection & Jump Bar -->
    <div class="bg-white border border-slate-200/80 rounded-2xl p-4 shadow-2xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <!-- Jump to Date Dropdown -->
        <div class="flex items-center gap-3">
            <label for="date-jump" class="text-xs font-bold text-slate-600 whitespace-nowrap">
                Lompat ke tanggal:
            </label>
            <div class="relative">
                <select id="date-jump"
                        onchange="location.href = this.value"
                        class="appearance-none pl-3.5 pr-8 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#0f2942]/20 cursor-pointer">
                    @foreach($datesList as $d)
                    <option value="{{ route('wali-kelas.jurnal.index', ['siswa_id' => $selectedSiswa->id, 'tanggal' => $d['tanggal']]) }}"
                            {{ $selectedDate === $d['tanggal'] ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($d['tanggal'])->translatedFormat('l, d M Y') }} ({{ $d['sub'] }}) {{ $d['is_today'] ? '— Terbaru' : '' }}
                    </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Horizontal Date Pills Matching Screenshot -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0 scrollbar-none">
            @foreach($datesList as $d)
                @php
                    $isActive = ($selectedDate === $d['tanggal']);
                @endphp
                <a href="{{ route('wali-kelas.jurnal.index', ['siswa_id' => $selectedSiswa->id, 'tanggal' => $d['tanggal']]) }}"
                   class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition shrink-0 {{ $isActive ? 'bg-[#0f2942] text-white shadow-xs font-bold' : 'bg-slate-50 border border-slate-200/80 text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    @if($isActive)
                        <svg class="w-3.5 h-3.5 text-sky-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $d['label'] }} {{ $d['is_today'] ? '(Hari Ini)' : '' }}</span>
                        <span class="px-1.5 py-0.5 rounded-md bg-white/20 text-[10px] text-white font-mono">{{ $d['sub'] }}</span>
                    @else
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                        <span>{{ $d['label'] }}</span>
                        <span class="text-[10px] text-slate-400 font-mono">{{ $d['sub'] }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>

    <!-- Main Journal Report Card (LAPORAN JURNAL HARIAN) -->
    <div class="bg-white border border-slate-200/80 rounded-2xl shadow-2xs overflow-hidden">
        <!-- Card Header Banner -->
        <div class="p-5 sm:p-6 border-b border-slate-100 bg-linear-to-r from-slate-50/50 to-white flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200/60">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }} • 08:15 – 16:30 WIB</span>
                </span>
            </div>

            <!-- Badges: Wali Kelas Status & Mentor Status -->
            <div class="flex flex-wrap items-center gap-2">
                @if(($activeJurnal->status ?? 'menunggu') === 'disetujui')
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        ✓ Terverifikasi Wali Kelas
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Menunggu Tinjauan Wali Kelas
                    </span>
                @endif

                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Disetujui Mentor DU/DI
                </span>
            </div>
        </div>

        <!-- Journal Content Body -->
        <div class="p-6 sm:p-8 space-y-6">
            <!-- Journal Title -->
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-400">JUDUL KEGIATAN LOGBOOK</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1 leading-snug">
                    {{ $activeJurnal->kegiatan ?? 'Pemeliharaan Server Rack, Patching Kabel Patch Cord Cat6, dan Pengujian Konektivitas Switch Core' }}
                </h2>
            </div>

            <!-- 3-Column Info Meta Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Mitra Industri / Unit</div>
                    <div class="text-xs font-extrabold text-slate-900 mt-1">{{ $industriNama }}</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Departemen Network Operation</div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Instruktur Lapangan (DU/DI)</div>
                    <div class="text-xs font-extrabold text-slate-900 mt-1">Bpk. Hendra Kurniawan, S.T.</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">Senior Network Engineer</div>
                </div>

                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Capaian Kompetensi Kejuruan</div>
                    <div class="text-xs font-extrabold text-slate-900 mt-1">Infrastruktur Jaringan & Server (RPL)</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">SKKNI Level II - No. 04.2/JNG/2026</div>
                </div>
            </div>

            <!-- Activity Description & Details -->
            <div class="space-y-4">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500">
                    Rincian Aktivitas & Pekerjaan yang Dilakukan:
                </h3>
                <p class="text-xs sm:text-sm text-slate-700 leading-relaxed">
                    {{ $activeJurnal->deskripsi ?? 'Melakukan inventarisasi dan perapihan patch cord Cat6 pada rack server lantai 2 Kantor Area Bogor. Melakukan pengecekan fisik konektor RJ-45 yang mengalami kelonggaran atau penurunan transfer rate data, serta mengganti 3 kabel patch cord yang rusak dengan kabel baru bersertifikasi AMP/CommScope.' }}
                </p>

                <!-- Bulleted Task Steps -->
                <div class="space-y-2.5 pt-2">
                    <div class="flex items-start gap-3 text-xs sm:text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-2 shrink-0"></span>
                        <div>
                            <strong class="font-bold text-slate-900">Identifikasi & Labeling Port:</strong>
                            <span>Melakukan pencatatan ulang label port patch panel ke switch core Cisco Catalyst 2960.</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 text-xs sm:text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-2 shrink-0"></span>
                        <div>
                            <strong class="font-bold text-slate-900">Re-patching Kabel Patch Cord:</strong>
                            <span>Menyusun ulang jalur kabel menggunakan velcro strap (cable organizer management) agar sirkulasi udara server optimal.</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 text-xs sm:text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-2 shrink-0"></span>
                        <div>
                            <strong class="font-bold text-slate-900">Testing & Verifikasi Koneksi:</strong>
                            <span>Menguji konektivitas antar VLAN dengan throughput test dan memastikan packet loss 0%.</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 text-xs sm:text-sm text-slate-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-2 shrink-0"></span>
                        <div>
                            <strong class="font-bold text-slate-900">Pencatatan Logbook Fisik Ruang Server:</strong>
                            <span>Menandatangani form checklist perawatan berkala bersama instruktur lapangan.</span>
                        </div>
                    </div>
                </div>

                <!-- Callout Box: Kendala & Solusi Teknis -->
                <div class="mt-4 p-4 rounded-xl bg-sky-50/70 border border-sky-100 flex items-start gap-3">
                    <div class="w-7 h-7 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-xs leading-relaxed">
                        <div class="font-bold text-sky-900">Kendala yang Dihadapi & Solusi Teknis:</div>
                        <div class="text-sky-800 mt-0.5">
                            Terdapat 1 konektor RJ-45 yang crimping-nya longgar pada port 18 switch B, telah diterminasi ulang menggunakan crimping tool dan kabel tester LAN dengan hasil 8 pin menyala normal.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo Documentation Section -->
            <div class="pt-6 border-t border-slate-100 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>FOTO DOKUMENTASI LAPANGAN SISWA</span>
                    </h3>
                    <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200/60">
                        ● Terverifikasi GPS & Timestamp
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80">
                    <!-- Photo Display / Preview -->
                    <div class="md:col-span-5 relative group overflow-hidden rounded-xl border border-slate-200 bg-slate-900 shadow-xs aspect-4/3 flex items-center justify-center">
                        <!-- Server Rack Graphic / Photo -->
                        <div class="absolute inset-0 bg-linear-to-b from-slate-800 to-slate-950 flex flex-col items-center justify-center p-4 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-[#0f2942] border border-sky-500/30 flex items-center justify-center text-sky-400 mb-3 shadow-lg">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                </svg>
                            </div>
                            <div class="text-xs font-bold text-white tracking-wide">Server Rack Unit 2B (Telkom Area)</div>
                            <div class="text-[11px] text-sky-300 font-mono mt-1">Patch Cord Cat6 & Switch Cisco 2960</div>
                        </div>

                        <!-- Badge Overlay Top Left -->
                        <div class="absolute top-3 left-3 px-2 py-0.5 rounded-md bg-red-600/90 text-white text-[9px] font-black uppercase tracking-wider flex items-center gap-1.5 shadow-xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                            LIVE CAPTURE
                        </div>

                        <!-- Open Original Link -->
                        <a href="#" onclick="alert('Membuka foto resolusi tinggi asli (1920x1080)...'); return false;"
                           class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2 text-white text-xs font-bold backdrop-blur-2xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                            <span>Lihat Foto Penuh</span>
                        </a>
                    </div>

                    <!-- Photo Metadata Info -->
                    <div class="md:col-span-7 flex flex-col justify-between space-y-3">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-xs text-slate-900">Dokumentasi_Server_Rack_07092026.jpg</span>
                                <span class="px-2 py-0.5 rounded-full bg-slate-200 text-slate-700 text-[10px] font-bold">Foto Asli Kamera</span>
                            </div>
                            <div class="text-xs text-slate-500">
                                Diambil: <strong class="text-slate-700 font-semibold">Senin, 07 Sep 2026 · 14:22:15 WIB</strong>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Foto menunjukkan siswa saat melakukan perapihan cable organizer velcro strap pada rack server lantai 2 dan pengujian switch port status.
                            </p>
                        </div>

                        <!-- Metadata Badges -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 pt-2 border-t border-slate-200/80 text-[11px]">
                            <div class="p-2 rounded-lg bg-white border border-slate-200/70">
                                <div class="text-slate-400 text-[10px] uppercase font-bold">Ukuran File</div>
                                <div class="font-extrabold text-slate-800 mt-0.5">1.8 MB</div>
                            </div>
                            <div class="p-2 rounded-lg bg-white border border-slate-200/70">
                                <div class="text-slate-400 text-[10px] uppercase font-bold">Resolusi</div>
                                <div class="font-extrabold text-slate-800 mt-0.5">1920 × 1080</div>
                            </div>
                            <div class="p-2 rounded-lg bg-white border border-slate-200/70 col-span-2 sm:col-span-1">
                                <div class="text-slate-400 text-[10px] uppercase font-bold">Geolokasi</div>
                                <div class="font-extrabold text-emerald-700 mt-0.5 flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Radius 18m
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mentor Feedback Box (DU/DI) -->
            <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200/80 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-emerald-600 text-white font-black text-xs flex items-center justify-center shrink-0 shadow-xs">
                            HK
                        </div>
                        <div>
                            <div class="text-xs font-extrabold text-slate-900">
                                Bpk. Hendra Kurniawan, S.T. <span class="font-normal text-slate-500">(Instruktur Mentor DU/DI)</span>
                            </div>
                            <div class="text-[10px] text-slate-400 mt-0.5">
                                Diverifikasi pada: 07 Sep 2026 • 17:05 WIB
                            </div>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 self-start sm:self-auto">
                        ✓ Telah Diverifikasi & Diberi Nilai A
                    </span>
                </div>

                <div class="p-3.5 rounded-xl bg-white border border-emerald-200/60 text-xs sm:text-sm text-slate-700 italic leading-relaxed">
                    “Raka bekerja sangat rapi dan teliti saat penataan kabel patch cord. Pemahaman mengenai warna kabel T568B sangat baik. Pertahankan kedisiplinan APD keselamatan kerja di ruang server.”
                </div>
            </div>

            <!-- Catatan Wali Kelas Section -->
            <div class="pt-6 border-t border-slate-100">
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-2xs space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-[#0f2942]/10 text-[#0f2942] flex items-center justify-center font-bold">
                                💬
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-900">
                                Catatan Pembinaan untuk Siswa
                            </h3>
                        </div>
                        <div class="text-[11px] text-slate-400">
                            Ditinjau oleh: <strong class="text-slate-700 font-semibold">Dra. Hj. Nurhayati, M.Pd.</strong> (Wali Kelas)
                        </div>
                    </div>

                    <!-- Quick Suggestions Pills -->
                    <div class="space-y-1.5">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                            TEMPLATE CATATAN CEPAT:
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <button type="button"
                                    @click="addQuickNote('Sangat baik, lanjutkan ketelitian kerja!')"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition cursor-pointer">
                                + Sangat baik, lanjutkan ketelitian kerja!
                            </button>
                            <button type="button"
                                    @click="addQuickNote('Pastikan dokumentasi kabel tester dicantumkan.')"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition cursor-pointer">
                                + Pastikan dokumentasi kabel tester dicantumkan
                            </button>
                            <button type="button"
                                    @click="addQuickNote('Jaga stamina dan kepatuhan K3 di lokasi magang.')"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition cursor-pointer">
                                + Jaga stamina dan kepatuhan K3
                            </button>
                        </div>
                    </div>

                    <!-- Form submission -->
                    <form action="{{ route('wali-kelas.jurnal.catatan', $activeJurnal->id ?? 1) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <textarea name="catatan"
                                      rows="3"
                                      x-model="catatanInput"
                                      placeholder="Tuliskan catatan apresiasi, masukan teknis, atau instruksi pembinaan untuk jurnal ini..."
                                      class="w-full px-4 py-3 text-xs sm:text-sm text-slate-800 bg-slate-50/50 border border-slate-200 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#0f2942]/20 focus:border-[#0f2942] transition leading-relaxed"></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2 border-t border-slate-100">
                            <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Catatan akan langsung muncul pada aplikasi siswa dan tersimpan dalam rekap bimbingan.</span>
                            </div>

                            <div class="flex items-center gap-2.5 self-end sm:self-auto">
                                <button type="button"
                                        @click="alert('Draf catatan berhasil disimpan sementara di browser.')"
                                        class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                                    Simpan Draf
                                </button>
                                <button type="submit"
                                        class="px-5 py-2 rounded-xl bg-[#0f2942] hover:bg-[#143657] text-white text-xs font-bold shadow-xs transition flex items-center gap-2 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    <span>Kirim Catatan</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
