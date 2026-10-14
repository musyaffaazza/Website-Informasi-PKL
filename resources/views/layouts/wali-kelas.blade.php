<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Daftar Murid PKL — Kelas XII RPL 2 | SIPRAK')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('image/logo_skiell.jpeg') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind & Vite Assets -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        [x-cloak] { display: none !important; }
        html { background-color: #f8fafc; }
        body { overflow-x: hidden; }
        @media (min-width: 1024px) {
            .wali-main { margin-left: 16rem; }
        }
        .wali-main main > div { max-width: 1600px; margin-inline: auto; }
        .wali-main main table th { white-space: nowrap; }
        .wali-main main table td { vertical-align: middle; }
        .shadow-2xs { box-shadow: 0 1px 2px rgba(15, 41, 66, .04), 0 8px 24px rgba(15, 41, 66, .03); }
        @media (max-width: 1023px) {
            .wali-main { margin-left: 0; }
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 antialiased min-h-screen" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Backdrop for Mobile -->
    <div x-show="sidebarOpen"
         x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-slate-900/40 backdrop-blur-xs transition-opacity lg:hidden">
    </div>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-white border-r border-slate-200 transition-transform duration-200 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="min-h-0 flex-1 flex flex-col justify-between overflow-y-auto">
            <div>
                <!-- Brand Header -->
                <div class="p-5 flex items-center gap-3 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-white border border-slate-200 shadow-xs overflow-hidden">
                        <img src="{{ asset('image/logo_skiell.jpeg') }}" alt="Logo SIPRAK" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';">
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-extrabold text-[15px] tracking-wide text-[#0f2942] leading-tight">SIPRAK</span>
                            <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-sky-100 text-sky-700 tracking-wide">WALI KELAS</span>
                        </div>
                        <div class="text-[9px] font-bold text-slate-400 tracking-wider uppercase mt-0.5">SMKN 1 Gunungputri</div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="px-3 pt-5">
                    <div class="px-3 pb-2.5 flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                            MENU PEMBINAAN
                        </span>
                        <span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-sky-50 text-sky-600 border border-sky-100">
                            {{ $jurusanSingkatan ?? 'RPL' }}
                        </span>
                    </div>

                    <nav class="space-y-1">
                        <!-- Daftar Murid -->
                        <a href="{{ route('wali-kelas.murid.index') }}"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('wali-kelas.murid.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 {{ request()->routeIs('wali-kelas.murid.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>Daftar Murid</span>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ request()->routeIs('wali-kelas.murid.*') ? 'bg-slate-800 text-white' : 'bg-slate-200 text-slate-700' }}">
                                {{ $totalSiswaNav ?? $totalSiswa ?? 36 }}
                            </span>
                        </a>

                        <!-- Persetujuan -->
                        <a href="{{ route('wali-kelas.persetujuan.index') }}"
                           class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('wali-kelas.persetujuan.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 {{ request()->routeIs('wali-kelas.persetujuan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                                <span>Persetujuan</span>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-600">
                                {{ $menungguNav ?? $menungguPersetujuan ?? 3 }}
                            </span>
                        </a>

                        <!-- Jurnal Murid -->
                        <a href="{{ route('wali-kelas.jurnal.index') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('wali-kelas.jurnal.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('wali-kelas.jurnal.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <span>Jurnal Murid</span>
                        </a>

                        <!-- Absensi Murid -->
                        <a href="{{ route('wali-kelas.absensi.index') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('wali-kelas.absensi.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('wali-kelas.absensi.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Absensi Murid</span>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Bottom Card: Dapodik SIPRAK Sync -->
            <div class="p-3">
                <div class="bg-[#f8fafc] border border-slate-200/80 rounded-2xl p-3.5 shadow-2xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[11px] font-extrabold text-slate-800">Dapodik SIPRAK Sync</span>
                    </div>
                    <p class="text-[10px] text-slate-500 leading-relaxed mt-1">
                        Terhubung ke data rombel {{ $rombelAktifNama ?? 'XII RPL 2' }} — SMKN 1 Gunungputri
                    </p>
                    <div class="flex items-center justify-between text-[10px] text-slate-400 mt-2.5 pt-2 border-t border-slate-200/60">
                        <span>Sinkron: 10 Menit lalu</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Container -->
    <div class="wali-main min-h-screen flex flex-col min-w-0 transition-all duration-200">
        <!-- Top Navbar -->
        <header class="h-16 min-w-0 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-20 shadow-[0_1px_3px_rgba(0,0,0,0.03)]">
            <!-- Left: Mobile Toggle, Brand Badge & Search -->
            <div class="flex items-center gap-3 sm:gap-4 flex-1 max-w-xl">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                @if(request()->routeIs('wali-kelas.persetujuan.*'))
                    <!-- Active Role Pill Badge matching screenshot 1 -->
                    <div class="hidden sm:inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-sky-50 text-sky-800 border border-sky-100 tracking-wide">
                        WALI KELAS – {{ $rombelAktifNama ?? 'XII RPL 2' }}
                    </div>
                @else
                    <!-- Search Input matching dashboard screenshot -->
                    <form action="{{ route('wali-kelas.murid.index') }}" method="GET" class="w-full">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari NISN, nama siswa, PT/DUDI, atau NIP guru..."
                                   class="w-full pl-10 pr-4 py-2 bg-slate-50 hover:bg-slate-100/80 focus:bg-white text-xs text-slate-800 placeholder-slate-400 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500 transition">
                        </div>
                    </form>
                @endif
            </div>

            <!-- Right: Notifications & User Profile -->
            <div class="flex items-center gap-3 sm:gap-5 shrink-0 ml-4">
                <!-- Notification Bell -->
                <div class="relative">
                    <button type="button" class="p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>
                </div>

                <!-- User Profile -->
                @php
                    $authUser = \Illuminate\Support\Facades\Auth::user();
                    $guru = $authUser?->guru;
                    $headerName = $guru?->nama ?: ($rombel->waliKelas?->nama ?? 'Dra. Hj. Nurhayati, M.Pd.');
                    $nipRaw = $guru?->nip ?: ($rombel->waliKelas?->nip ?? '197508142002122003');
                    if (str_contains(strtolower($headerName), 'nurhayati')) {
                        $headerRole = 'NIP 19750814 200212 2 003';
                    } elseif ($guru && in_array('Wali Kelas', (array)($guru->roles_list ?? []))) {
                        $headerRole = $guru->keterangan_diampu ?: ('Wali Kelas ' . ($guru->kelas_diampu ?: 'XII RPL 2'));
                    } else {
                        $headerRole = 'Staf Tata Usaha & Admin Dapodik';
                    }
                    $initialsList = explode(' ', preg_replace('/[^a-zA-Z\s]/', '', $headerName));
                    $headerInitials = '';
                    foreach ($initialsList as $w) {
                        $w = trim($w);
                        if (!empty($w) && !in_array(strtolower($w), ['ir', 'drs', 'dra', 'hj', 'h', 'st', 'mpd', 'spd'])) {
                            $headerInitials .= strtoupper($w[0]);
                            if (strlen($headerInitials) >= 2) break;
                        }
                    }
                    if (empty($headerInitials)) $headerInitials = 'NH';
                @endphp

                <div class="relative" x-data="{ profileOpen: false }">
                    <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 cursor-pointer text-left focus:outline-none">
                        <div class="hidden sm:block text-right">
                            <div class="text-xs font-bold text-slate-900 leading-tight">
                                {{ $headerName }}
                            </div>
                            <div class="text-[10px] font-semibold text-slate-500 leading-tight mt-0.5">
                                {{ $headerRole }}
                            </div>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-[#0f2942] text-white flex items-center justify-center font-bold text-xs shadow-xs border border-slate-200 shrink-0">
                            {{ $headerInitials }}
                        </div>
                    </button>

                    <!-- Profile Dropdown Menu -->
                    <div x-show="profileOpen"
                         x-cloak
                         @click.away="profileOpen = false"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-1.5 z-50 text-xs">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <div class="font-bold text-slate-900">{{ $headerName }}</div>
                            <div class="text-[10px] text-slate-500">{{ $authUser?->email ?? 'wali@smkn1gunungputri.sch.id' }}</div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 flex items-center gap-2 font-medium">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Keluar Sistem</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Slot -->
        <main class="flex-1 p-4 sm:p-6 lg:p-8">
            <div class="w-full">
                @if(session('success'))
                    <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-2xs">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-semibold flex items-center gap-2 shadow-2xs">
                        <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
