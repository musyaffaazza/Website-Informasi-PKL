@extends('layouts.admin')

@section('title', 'SIPRAK SMKN 1 GUNUNGPUTRI - Log Aktivitas Sistem')
@section('header_search_placeholder', 'Cari nama pengguna, aksi, atau IP address...')

@section('content')
<div class="space-y-6">

    <!-- Page Header & Title Section -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <div class="text-[11px] font-semibold text-slate-400 mb-1.5 flex items-center gap-1.5">
                <span>Pengaturan &amp; Master Data</span>
                <span class="text-slate-300">&gt;</span>
                <span class="text-slate-600">Log Aktivitas Sistem</span>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl font-extrabold text-[#0f2942] tracking-tight">
                    Log Aktivitas Sistem
                </h1>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide bg-sky-50 text-sky-700 border border-sky-200 shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    AUDIT TRAIL RESMI
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 max-w-3xl leading-relaxed">
                Rekaman jejak digital seluruh aktivitas, otorisasi berkas, dan mutasi data sistem secara real-time untuk transparansi dan kepatuhan operasional.
            </p>
        </div>

        <!-- Top Right Actions -->
        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            <a href="{{ route('admin.log-aktivitas.export', request()->query()) }}" 
               class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>Ekspor Log Audit</span>
            </a>

            <button type="button" 
                    onclick="window.location.reload()" 
                    class="flex items-center gap-2 px-4 py-2.5 bg-[#0f2942] hover:bg-[#1a385c] text-white rounded-xl text-xs font-bold shadow-xs transition active:scale-98">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span>Penyegaran (Live)</span>
            </button>
        </div>
    </div>

    <!-- 4 KPI Summary Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Total Log Hari Ini -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-xs font-medium text-slate-500">Total Log Hari Ini</div>
                <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $logHariIni }} Aktivitas</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Aktivitas sistem hari ini</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 border border-sky-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 3H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>

        <!-- Card 2: Otorisasi & Persetujuan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-xs font-medium text-slate-500">Otorisasi &amp; Persetujuan</div>
                <div class="text-2xl font-black text-emerald-600 mt-1 leading-tight">{{ $otorisasiCount }} Tindakan</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Persetujuan &amp; status</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 border border-emerald-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Card 3: Mutasi Data Master -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-xs font-medium text-slate-500">Mutasi Data Master</div>
                <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $mutasiCount }} Pembaruan</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">Tambah, edit, &amp; hapus</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 border border-amber-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
        </div>

        <!-- Card 4: Autentikasi & Keamanan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-2xs flex items-center justify-between">
            <div>
                <div class="text-xs font-medium text-slate-500">Autentikasi &amp; Keamanan</div>
                <div class="text-2xl font-black text-slate-900 mt-1 leading-tight">{{ $securityCount }} Sukses</div>
                <div class="text-[11px] font-medium text-slate-400 mt-1">{{ $penggunaAktif }} pengguna aktif</div>
            </div>
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 border border-indigo-100/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V7a5 5 0 00-10 0v2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter & Toolbar Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-2xs">
        <form method="GET" action="{{ route('admin.log-aktivitas.index') }}" id="logFilterForm" class="flex flex-col xl:flex-row xl:items-center justify-between gap-3">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 flex-1 flex-wrap">
                <!-- Search Input -->
                <div class="relative w-full sm:min-w-[240px] sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama pengguna, IP address..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </div>

                <!-- Date Range Inputs -->
                <div class="flex items-center gap-1.5 bg-slate-50/80 border border-slate-200 rounded-xl px-3 py-1.5 w-full sm:w-auto">
                    <input type="date" 
                           name="from" 
                           value="{{ request('from') }}" 
                           onchange="document.getElementById('logFilterForm').submit()"
                           class="bg-transparent text-xs font-semibold text-slate-700 focus:outline-none cursor-pointer">
                    <span class="text-slate-300 text-xs">—</span>
                    <input type="date" 
                           name="to" 
                           value="{{ request('to') }}" 
                           onchange="document.getElementById('logFilterForm').submit()"
                           class="bg-transparent text-xs font-semibold text-slate-700 focus:outline-none cursor-pointer">
                </div>

                <!-- Role Filter -->
                <div class="relative w-full sm:min-w-[140px] sm:flex-1">
                    <select name="role" 
                            onchange="document.getElementById('logFilterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="all">Semua Role</option>
                        <option value="guru" @selected(request('role') === 'guru')>Guru</option>
                        <option value="siswa" @selected(request('role') === 'siswa')>Siswa</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Aksi Filter -->
                <div class="relative w-full sm:min-w-[160px] sm:flex-1">
                    <select name="aksi" 
                            onchange="document.getElementById('logFilterForm').submit()"
                            class="w-full px-3.5 py-2.5 bg-slate-50/80 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="all">Semua Kategori Aksi</option>
                        @foreach($aksiList as $aksi)
                            <option value="{{ $aksi }}" @selected(request('aksi') === $aksi)>{{ $aksi }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Reset Button -->
                @if(request('search') || (request('role') && request('role') !== 'all') || (request('aksi') && request('aksi') !== 'all') || request('from') || request('to'))
                    <a href="{{ route('admin.log-aktivitas.index') }}" 
                       class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-2">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50/50 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 w-44">WAKTU &amp; SESI</th>
                        <th class="py-3.5 px-4 w-52">PENGGUNA / AKTOR</th>
                        <th class="py-3.5 px-4 w-48">AKSI YANG DILAKUKAN</th>
                        <th class="py-3.5 pr-6 pl-4">DATA TERDAMPAK &amp; DESKRIPSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    @forelse($logs as $log)
                        @php
                            $username = $log->user?->username ?? 'Sistem SIPRAK';
                            $initials = collect(explode(' ', str_replace(['.', '_'], ' ', $username)))->filter()->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->join('');
                            $isSiswa = $log->user?->tipe_akun === 'siswa';
                            $badgeClass = match($log->aksi) {
                                'Login' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Logout' => 'bg-slate-100 text-slate-600 border-slate-200',
                                'Hapus Data' => 'bg-rose-50 text-rose-700 border-rose-200',
                                'Tambah Data', 'Edit Data', 'Impor Data', 'Ekspor Data' => 'bg-sky-50 text-sky-800 border-sky-200',
                                default => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                            };
                            $actorName = \Illuminate\Support\Str::headline(str_replace(['.', '_'], ' ', $username));
                            $browser = str_contains(strtolower($log->user_agent ?? ''), 'mobile') ? 'Mobile App' : 'Web Desktop';
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Waktu & Sesi -->
                            <td class="py-4 px-4 align-top font-mono">
                                <div class="font-bold text-slate-900 text-xs">
                                    {{ $log->dibuat_pada?->format('d/m/Y H:i:s') ?? '-' }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5 font-sans">
                                    IP: {{ $log->ip_address ?? '127.0.0.1' }} • {{ $browser }}
                                </div>
                            </td>

                            <!-- Pengguna / Aktor -->
                            <td class="py-4 px-4 align-top">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-[11px] shrink-0 {{ $isSiswa ? 'bg-sky-100 text-sky-800' : 'bg-[#0f2942] text-white' }}">
                                        {{ $initials ?: 'SS' }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-slate-900 text-[13px] leading-snug truncate">
                                            {{ $actorName }}
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wide mt-0.5 {{ $isSiswa ? 'bg-sky-50 text-sky-700 border border-sky-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                            {{ $log->user?->tipe_akun ? ucfirst($log->user->tipe_akun) : 'Sistem' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Aksi Yang Dilakukan -->
                            <td class="py-4 px-4 align-top">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border {{ $badgeClass }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                    <span>{{ $log->aksi }}</span>
                                </span>
                            </td>

                            <!-- Data Terdampak & Deskripsi -->
                            <td class="py-4 pr-6 pl-4 align-top">
                                <div class="font-semibold text-slate-900 text-xs leading-relaxed">
                                    <span class="font-bold text-sky-800">[{{ $log->modul ?? 'Sistem' }}]</span> {{ $log->deskripsi }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    Ref: #{{ str_pad($log->id, 5, '0', STR_PAD_LEFT) }} • {{ $log->user?->email ?? 'Aktivitas Internal Sistem' }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 3H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="font-bold text-slate-700 text-sm">Belum ada aktivitas yang tercatat</div>
                                <div class="text-xs text-slate-400 mt-1">Aktivitas login, pembaruan data, dan otorisasi akan otomatis tercatat di sini.</div>
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
                    <strong class="text-slate-800">{{ $logs->firstItem() ?? 0 }}</strong> - 
                    <strong class="text-slate-800">{{ $logs->lastItem() ?? 0 }}</strong> dari 
                    <strong class="text-slate-800">{{ $logs->total() }}</strong> entri log aktivitas
                </span>
                <span class="text-slate-300">|</span>
                <div class="flex items-center gap-1.5">
                    <span>Tampilkan:</span>
                    <select onchange="let u=new URL(location.href);u.searchParams.set('per_page',this.value);u.searchParams.delete('page');location.href=u.toString();" 
                            class="bg-slate-50 border border-slate-200 rounded-lg px-2 py-1 text-xs font-semibold text-slate-700 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8 baris</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 baris</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 baris</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 baris</option>
                    </select>
                </div>
            </div>

            <!-- Pagination Numbers -->
            <div class="flex items-center gap-1">
                @if ($logs->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg text-slate-300 font-medium cursor-not-allowed">Sebelumnya</span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold transition">Sebelumnya</a>
                @endif

                @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                    @if ($page == $logs->currentPage())
                        <span class="w-8 h-8 rounded-lg bg-[#0f2942] text-white font-bold flex items-center justify-center shadow-xs">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold flex items-center justify-center transition">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-slate-600 hover:bg-slate-100 font-semibold transition">Selanjutnya</a>
                @else
                    <span class="px-3 py-1.5 rounded-lg text-slate-300 font-medium cursor-not-allowed">Selanjutnya</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Bottom Signature Footer -->
    <div class="flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2 pt-1">
        <div>Log audit tersimpan secara permanen (Read-Only) untuk kepatuhan operasional dan keamanan data.</div>
        <div>Terakhir diperbarui: {{ now()->format('d M Y, H:i') }} WIB</div>
    </div>

</div>
@endsection
