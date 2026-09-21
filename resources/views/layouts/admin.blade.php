<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPRAK SMKN 1 GUNUNGPUTRI')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            .admin-main { margin-left: 16rem; }
        }
        .admin-main main > div { max-width: 1600px; margin-inline: auto; }
        .admin-main main table th { white-space: nowrap; }
        .admin-main main table td { vertical-align: middle; }
        .admin-main main .shadow-2xs { box-shadow: 0 1px 2px rgba(15, 41, 66, .04), 0 8px 24px rgba(15, 41, 66, .03); }
        @media (max-width: 1023px) {
            .admin-main { margin-left: 0; }
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 antialiased min-h-screen" x-data="{ sidebarOpen: false }">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-white border-r border-slate-200 transition-transform duration-200 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="min-h-0 flex-1 overflow-y-auto">
            <!-- School Brand Header -->
            <div class="p-5 flex items-center gap-3 border-b border-slate-100">
                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-white border border-slate-200 shadow-xs">
                    <!-- School Emblem / Logo -->
                    <svg class="w-7 h-7" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="24" cy="24" r="22" fill="#0284c7" />
                        <circle cx="24" cy="24" r="18" fill="#facc15" />
                        <path d="M24 10L14 16V26C14 32.5 18.2 38.5 24 40C29.8 38.5 34 32.5 34 26V16L24 10Z" fill="#0369a1" />
                        <path d="M24 15L18 19V25C18 29.5 20.6 33.6 24 35C27.4 33.6 30 29.5 30 25V19L24 15Z" fill="#ffffff" />
                        <circle cx="24" cy="24" r="3.5" fill="#e11d48" />
                        <path d="M20 30H28V32H20V30Z" fill="#0284c7" />
                    </svg>
                </div>
                <div>
                    <div class="font-extrabold text-[15px] tracking-wide text-[#0f2942] leading-tight">SIPRAK</div>
                    <div class="text-[9px] font-bold text-slate-400 tracking-wider uppercase">SMKN 1 GUNUNGPUTRI</div>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="px-3 pt-5">
                <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                    MASTER DATA POKOK
                </div>

                <nav class="space-y-1">
                    <!-- Master Data Jurusan -->
                    <a href="{{ route('admin.jurusan.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.jurusan.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.jurusan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"/>
                        </svg>
                        <span>Master Data Jurusan</span>
                    </a>

                    <!-- Master Data Rombel -->
                    <a href="{{ route('admin.rombel.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.rombel.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.rombel.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span>Master Data Rombel</span>
                    </a>

                    <!-- Master Data Siswa -->
                    <a href="{{ route('admin.siswa.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.siswa.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.siswa.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Master Data Siswa</span>
                    </a>

                    <!-- Master Data Guru -->
                    <a href="{{ route('admin.guru.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.guru.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.guru.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Master Data Guru</span>
                    </a>

                    <!-- Master Data Industri -->
                    <a href="{{ route('admin.industri.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.industri.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.industri.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Master Data Industri</span>
                    </a>

                    <!-- Mapping Pembimbing -->
                    <a href="{{ route('admin.mapping-pembimbing.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.mapping-pembimbing.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.mapping-pembimbing.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <span>Mapping Pembimbing</span>
                    </a>

                    <!-- Log Aktivitas -->
                    <a href="{{ route('admin.log-aktivitas.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('admin.log-aktivitas.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('admin.log-aktivitas.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Log Aktivitas</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Bottom Sync Widget -->
        <div class="p-3">
            <div class="rounded-xl border border-emerald-200/80 bg-[#f0fdf4] p-3.5 shadow-2xs">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-xs font-bold text-slate-900">Dapodik SIPRAK Sync</span>
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                </div>
                <div class="text-[11px] font-medium text-emerald-600 mb-1.5 flex items-center gap-1.5">
                    <span>⇄</span>
                    <span>Online • Terhubung Realtime</span>
                </div>
                <div class="flex items-center justify-between text-[10px] text-slate-400 pt-1 border-t border-emerald-100">
                    <span>Server Pusdatin: OK</span>
                    <span class="font-mono">v2024.b</span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Container -->
    <div class="admin-main min-h-screen flex flex-col min-w-0 transition-all duration-200">
        <!-- Top Navbar -->
        <header class="h-16 min-w-0 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-20 shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <!-- Mobile Toggle + Global Search -->
            <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Search Input Form -->
                @php
                    $searchAction = route('admin.jurusan.index');
                    if (request()->routeIs('admin.industri.*')) {
                        $searchAction = route('admin.industri.index');
                    } elseif (request()->routeIs('admin.mapping-pembimbing.*')) {
                        $searchAction = route('admin.mapping-pembimbing.index');
                    } elseif (request()->routeIs('admin.siswa.*')) {
                        $searchAction = route('admin.siswa.index');
                    } elseif (request()->routeIs('admin.guru.*')) {
                        $searchAction = route('admin.guru.index');
                    } elseif (request()->routeIs('admin.rombel.*')) {
                        $searchAction = route('admin.rombel.index');
                    }
                @endphp
                <form action="{{ $searchAction }}" method="GET" class="relative w-full max-w-md min-w-0">
                    @if(request('tingkat') && request()->routeIs('admin.rombel.*'))
                        <input type="hidden" name="tingkat" value="{{ request('tingkat') }}">
                    @endif
                    @if(request('jurusan_id') && request()->routeIs('admin.rombel.*'))
                        <input type="hidden" name="jurusan_id" value="{{ request('jurusan_id') }}">
                    @endif
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="@yield('header_search_placeholder', 'Cari siswa, NIS, atau pembimbing...')" 
                           class="w-full pl-10 pr-4 py-2 bg-slate-50/80 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </form>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                <!-- Tarik Data Rombel Dapodik Button -->
                <form action="{{ route('admin.rombel.syncDapodik') }}" method="POST" class="hidden xl:inline">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-2 px-3.5 py-2 bg-[#f0f9ff] hover:bg-[#e0f2fe] text-[#0284c7] border border-sky-200/80 rounded-xl text-xs font-semibold shadow-2xs transition active:scale-98">
                        <svg class="w-3.5 h-3.5 text-[#0284c7]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <span>Tarik Data Rombel Dapodik</span>
                    </button>
                </form>

                <div class="hidden xl:block h-6 w-px bg-slate-200"></div>

                <!-- User Profile Info -->
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="w-9 h-9 rounded-full bg-slate-100 text-slate-700 border border-slate-200 font-bold text-xs flex items-center justify-center shadow-xs shrink-0">
                        ES
                    </div>
                    <div class="hidden sm:block text-left">
                        <div class="text-xs font-bold text-slate-900 leading-tight">Endang Supriyatna, S.AP.</div>
                        <div class="text-[10px] text-slate-400">Staf Tata Usaha &amp; Admin Dapodik</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Page Content -->
        <main class="flex-1 p-6 md:p-8">
            <!-- Flash Notifications -->
            @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
            @endif

            @if(session('info'))
            <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-xs font-medium flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('info') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700">&times;</button>
            </div>
            @endif

            @if(isset($errors) && $errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium shadow-xs">
                <div class="font-bold mb-1">Periksa kembali data Anda:</div>
                <ul class="list-disc pl-5 space-y-0.5">
                    @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Backdrop for mobile sidebar -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-cloak
         class="fixed inset-0 bg-slate-900/60 z-20 lg:hidden"></div>

    @stack('scripts')
</body>
</html>
