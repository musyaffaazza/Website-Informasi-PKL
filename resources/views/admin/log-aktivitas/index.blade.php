@extends('layouts.admin')

@section('title', 'SIPRAK SMKN 1 GUNUNGPUTRI - Log Aktivitas Sistem')
@section('header_search_placeholder', 'Cari NISN, nama siswa, PT/DUDI, atau NIP guru...')

@section('header_actions')
<div class="flex items-center gap-4">
    <button type="button" class="relative p-2 text-slate-500 hover:text-[#0f2942] transition" aria-label="Notifikasi">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 01-6 0v-1m6 0H9" />
        </svg>
        <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-rose-500 rounded-full ring-2 ring-white"></span>
    </button>
    <div class="h-7 w-px bg-slate-200"></div>
    <div class="flex items-center gap-3">
        <div class="hidden sm:block text-right">
            <div class="text-xs font-bold text-slate-800 leading-tight">Endang Supriyatna, S.AP.</div>
            <div class="text-[10px] text-slate-400">Staf Tata Usaha &amp; Admin Dapodik</div>
        </div>
        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-sky-100 to-blue-200 border border-white shadow-xs text-[#0f2942] font-bold text-xs flex items-center justify-center">ES</div>
    </div>
</div>
@endsection

@section('content')
<div class="space-y-5">
    <section class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-[10px] font-semibold text-slate-400 mb-1.5">
                <span>Pengaturan &amp; Master Data</span>
                <span class="text-slate-300">›</span>
                <span class="text-slate-600">Log Aktivitas Sistem</span>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <h1 class="text-[22px] font-extrabold text-[#0f2942] tracking-tight leading-tight">Log Aktivitas Sistem</h1>
                <span class="inline-flex items-center gap-1.5 rounded-full border border-sky-200 bg-sky-50 px-2.5 py-1 text-[9px] font-extrabold tracking-wide text-sky-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7" /></svg>
                    AUDIT TRAIL RESMI &amp; TERENKRIPSI
                </span>
            </div>
            <p class="mt-1.5 max-w-2xl text-[10px] leading-relaxed text-slate-500">Rekaman jejak digital seluruh aktivitas, otorisasi berkas, dan mutasi data sistem secara real-time untuk transparansi dan kepatuhan operasional.</p>
        </div>
        <div class="flex shrink-0 items-center gap-2">
            <a href="{{ route('admin.log-aktivitas.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-[10px] font-bold text-[#0f2942] shadow-2xs transition hover:bg-slate-50">
                <svg class="w-3.5 h-3.5 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v10m0 0l-4-4m4 4l4-4M5 20h14" /></svg>
                Ekspor Log Audit
            </a>
            <button type="button" onclick="window.location.reload()" class="inline-flex items-center gap-2 rounded-lg bg-[#0f2942] px-3.5 py-2.5 text-[10px] font-bold text-white shadow-xs transition hover:bg-[#173b61]">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                Penyegaran Otomatis (Live)
            </button>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-xl border border-slate-100 bg-white p-4 shadow-2xs">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[8px] font-extrabold tracking-wide text-slate-500 uppercase">Total Log Hari Ini</p>
                    <p class="mt-1 text-[25px] font-black leading-none text-[#071d36]">{{ $logHariIni }}</p>
                    <p class="mt-1 text-[19px] font-extrabold leading-none text-[#071d36]">Aktivitas</p>
                </div>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-sky-100 bg-sky-50 text-sky-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 3H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14 3v5h5" /></svg></span>
            </div>
            <p class="mt-4 text-[8px] font-bold text-emerald-600">• +{{ $logHariIni }}% dari kemarin</p>
        </article>

        <article class="rounded-xl border border-slate-100 bg-white p-4 shadow-2xs">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[8px] font-extrabold tracking-wide text-slate-500 uppercase">Otorisasi &amp; Persetujuan</p>
                    <p class="mt-1 text-[25px] font-black leading-none text-[#071d36]">{{ $otorisasiCount }}</p>
                    <p class="mt-1 text-[19px] font-extrabold leading-none text-[#071d36]">Tindakan</p>
                </div>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-sky-100 bg-sky-50 text-sky-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></span>
            </div>
            <p class="mt-4 text-[8px] font-semibold text-sky-700">• Kaprog, Wali Kelas, Hubin</p>
        </article>

        <article class="rounded-xl border border-slate-100 bg-white p-4 shadow-2xs">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[8px] font-extrabold tracking-wide text-slate-500 uppercase">Mutasi Data Master</p>
                    <p class="mt-1 text-[25px] font-black leading-none text-[#071d36]">{{ $mutasiCount }}</p>
                    <p class="mt-1 text-[19px] font-extrabold leading-none text-[#071d36]">Pembaruan</p>
                </div>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-sky-100 bg-sky-50 text-sky-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2zm3 4h4m-4 4h4m-4 4h4" /></svg></span>
            </div>
            <p class="mt-4 text-[8px] font-semibold text-sky-700">• Siswa, Guru, DUDI</p>
        </article>

        <article class="rounded-xl border border-slate-100 bg-white p-4 shadow-2xs">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[8px] font-extrabold tracking-wide text-slate-500 uppercase">Autentikasi &amp; Keamanan</p>
                    <p class="mt-1 text-[25px] font-black leading-none text-[#071d36]">{{ $securityCount }}</p>
                    <p class="mt-1 text-[19px] font-extrabold leading-none text-[#071d36]">Sukses</p>
                </div>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-sky-100 bg-sky-50 text-sky-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V7a5 5 0 00-10 0v2H6a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg></span>
            </div>
            <p class="mt-4 text-[8px] font-semibold text-sky-700">◻ {{ $penggunaAktif }} pengguna aktif</p>
        </article>
    </section>

    <section class="rounded-xl border border-slate-100 bg-white p-3 shadow-2xs">
        <form method="GET" action="{{ route('admin.log-aktivitas.index') }}" class="grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-[1.45fr_1.05fr_.9fr_1.1fr_auto]">
            <label class="relative block">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama pengguna, IP address..." class="w-full rounded-lg border border-slate-100 bg-[#f7faff] py-2.5 pl-9 pr-3 text-[9px] font-medium text-slate-700 placeholder:text-slate-400 focus:border-sky-200 focus:outline-none focus:ring-2 focus:ring-sky-100">
            </label>
            <div class="grid grid-cols-2 gap-1.5 rounded-lg border border-slate-100 bg-[#f7faff] px-2.5 py-1.5 text-[9px] text-slate-500">
                <input type="date" name="from" value="{{ request('from') }}" aria-label="Mulai tanggal" class="min-w-0 bg-transparent font-semibold outline-none">
                <input type="date" name="to" value="{{ request('to') }}" aria-label="Sampai tanggal" class="min-w-0 border-l border-slate-200 bg-transparent pl-1.5 font-semibold outline-none">
            </div>
            <select name="role" onchange="this.form.submit()" class="rounded-lg border border-slate-100 bg-[#f7faff] px-3 py-2.5 text-[9px] font-semibold text-slate-600 outline-none focus:ring-2 focus:ring-sky-100">
                <option value="all">Semua Role</option>
                <option value="guru" @selected(request('role') === 'guru')>Guru</option>
                <option value="siswa" @selected(request('role') === 'siswa')>Siswa</option>
            </select>
            <select name="aksi" onchange="this.form.submit()" class="rounded-lg border border-slate-100 bg-[#f7faff] px-3 py-2.5 text-[9px] font-semibold text-slate-600 outline-none focus:ring-2 focus:ring-sky-100">
                <option value="all">Semua Kategori Aksi</option>
                @foreach($aksiList as $aksi)
                    <option value="{{ $aksi }}" @selected(request('aksi') === $aksi)>{{ $aksi }}</option>
                @endforeach
            </select>
            <div class="flex items-center gap-2">
                <button type="submit" class="inline-flex h-full items-center justify-center rounded-lg bg-[#0f2942] px-3 text-[9px] font-bold text-white transition hover:bg-[#173b61]">Terapkan</button>
                <a href="{{ route('admin.log-aktivitas.index') }}" class="inline-flex h-full items-center justify-center gap-1.5 rounded-lg border border-slate-100 bg-[#f7faff] px-3 text-[9px] font-semibold text-slate-600 transition hover:bg-slate-100"><svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2" /></svg>Reset Filter</a>
            </div>
        </form>
    </section>

    <section class="overflow-hidden rounded-xl border border-slate-100 bg-white shadow-2xs">
        <div class="overflow-x-auto">
            <table class="min-w-[900px] w-full table-fixed text-left">
                <colgroup>
                    <col class="w-[23%]">
                    <col class="w-[23%]">
                    <col class="w-[28%]">
                    <col class="w-[26%]">
                </colgroup>
                <thead class="bg-[#edf4ff] text-[8px] font-extrabold uppercase tracking-wide text-[#25446b]">
                    <tr>
                        <th class="px-4 py-2.5">Waktu &amp; Sesi</th>
                        <th class="px-4 py-2.5">Pengguna / Aktor</th>
                        <th class="px-4 py-2.5">Aksi Yang Dilakukan</th>
                        <th class="px-4 py-2.5">Data Terdampak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        @php
                            $username = $log->user?->username ?? 'Sistem SIPRAK';
                            $initials = collect(explode(' ', str_replace(['.', '_'], ' ', $username)))->filter()->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->join('');
                            $isSiswa = $log->user?->tipe_akun === 'siswa';
                            $badgeClass = match($log->aksi) {
                                'Login' => 'bg-emerald-50 text-emerald-700',
                                'Hapus Data' => 'bg-rose-50 text-rose-700',
                                'Edit Data', 'Tambah Data', 'Impor Data' => 'bg-sky-100 text-sky-800',
                                default => 'bg-blue-50 text-blue-800',
                            };
                            $actorName = \Illuminate\Support\Str::headline(str_replace(['.', '_'], ' ', $username));
                            $browser = str_contains(strtolower($log->user_agent ?? ''), 'mobile') ? 'Mobile App' : 'Web Desktop';
                        @endphp
                        <tr class="bg-white transition hover:bg-sky-50/40">
                            <td class="px-4 py-3 align-top">
                                <div class="font-mono text-[9px] font-bold text-[#12355c]">{{ $log->dibuat_pada?->format('Y-m-d H:i:s') }} WIB</div>
                                <div class="mt-1 flex items-center gap-1 text-[8px] text-slate-400"><svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12.414A8 8 0 1117.657 16.657z" /></svg>IP: {{ $log->ip_address ?? '-' }} · {{ $browser }}</div>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <div class="flex items-start gap-2">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full {{ $isSiswa ? 'bg-sky-100 text-sky-800' : 'bg-[#12355c] text-white' }} text-[8px] font-extrabold">{{ $initials ?: 'SS' }}</span>
                                    <div class="min-w-0">
                                        <div class="truncate text-[9px] font-extrabold text-[#12355c]">{{ $actorName }}</div>
                                        <span class="mt-1 inline-flex rounded bg-sky-100 px-1.5 py-0.5 text-[7px] font-extrabold uppercase tracking-wide text-sky-800">{{ $isSiswa ? 'Siswa' : 'Guru RPL' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <span class="inline-flex max-w-full items-center gap-1.5 rounded-full px-2.5 py-1 text-[8px] font-bold {{ $badgeClass }}"><span>•</span><span class="truncate">{{ $log->aksi }}</span></span>
                            </td>
                            <td class="px-4 py-3 align-top">
                                <div class="text-[8.5px] font-bold leading-relaxed text-[#12355c]">{{ $log->modul ?? 'Sistem' }}: {{ $log->deskripsi }}</div>
                                <div class="mt-1 text-[8px] leading-relaxed text-slate-400">ID Log #{{ str_pad($log->id, 5, '0', STR_PAD_LEFT) }} · {{ $log->user?->email ?? 'Aktivitas sistem' }}</div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-14 text-center">
                                <svg class="mx-auto h-8 w-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 3H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v9a2 2 0 01-2 2z" /></svg>
                                <p class="mt-2 text-xs font-bold text-slate-500">Belum ada aktivitas yang tercatat.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="flex flex-col gap-3 rounded-xl border border-slate-100 bg-white px-4 py-3 shadow-2xs lg:flex-row lg:items-center lg:justify-between">
        <div class="flex max-w-sm items-start gap-2 text-[8px] leading-relaxed text-slate-400">
            <svg class="mt-0.5 h-3.5 w-3.5 shrink-0 text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.105-.895 2-2 2s-2-.895-2-2 .895-2 2-2 2 .895 2 2zm0 0c0 1.105.895 2 2 2s2-.895 2-2-.895-2-2-2-2 .895-2 2zm-8 9c0-2.21 1.79-4 4-4h8c2.21 0 4 1.79 4 4" /></svg>
            <span>Log audit tersimpan secara permanen (Read-Only) dan terenkripsi untuk kebutuhan audit kepatuhan ISO &amp; Kemenkebudristek.</span>
        </div>
        <div class="text-[8px] font-semibold text-slate-500">Menampilkan {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} dari {{ number_format($logs->total()) }} entri log aktivitas</div>
        <div class="flex items-center gap-1 text-[8px] font-bold">
            @if($logs->onFirstPage())
                <span class="rounded-md px-2.5 py-2 text-slate-300">‹ Sebelumnya</span>
            @else
                <a href="{{ $logs->previousPageUrl() }}" class="rounded-md px-2.5 py-2 text-slate-500 hover:bg-slate-50">‹ Sebelumnya</a>
            @endif
            @for($page = max(1, $logs->currentPage() - 1); $page <= min($logs->lastPage(), $logs->currentPage() + 2); $page++)
                <a href="{{ $logs->url($page) }}" class="flex h-7 w-7 items-center justify-center rounded-md {{ $page === $logs->currentPage() ? 'bg-[#0f2942] text-white' : 'bg-[#edf4ff] text-[#25446b] hover:bg-sky-100' }}">{{ $page }}</a>
            @endfor
            @if($logs->hasMorePages())
                <a href="{{ $logs->nextPageUrl() }}" class="rounded-md px-2.5 py-2 text-[#25446b] hover:bg-slate-50">Selanjutnya ›</a>
            @else
                <span class="rounded-md px-2.5 py-2 text-slate-300">Selanjutnya ›</span>
            @endif
        </div>
    </section>
</div>
@endsection