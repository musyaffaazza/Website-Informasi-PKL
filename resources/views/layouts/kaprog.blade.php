<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Murid PKL — Rekayasa Perangkat Lunak | SIPRAK')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('image/logo_skiell.jpeg') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
            .kaprog-main { margin-left: 16rem; }
        }
        .kaprog-main main > div { max-width: 1600px; margin-inline: auto; }
        .kaprog-main main table th { white-space: nowrap; }
        .kaprog-main main table td { vertical-align: middle; }
        .shadow-2xs { box-shadow: 0 1px 2px rgba(15, 41, 66, .04), 0 8px 24px rgba(15, 41, 66, .03); }
        @media (max-width: 1023px) {
            .kaprog-main { margin-left: 0; }
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 antialiased min-h-screen" x-data="{ sidebarOpen: false }">

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-white border-r border-slate-200 transition-transform duration-200 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="min-h-0 flex-1 overflow-y-auto flex flex-col justify-between">
            <div>
                <!-- School Brand Header -->
                <div class="p-5 flex items-center gap-3 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-white border border-slate-200 shadow-xs overflow-hidden">
                        <img src="{{ asset('image/logo_skiell.jpeg') }}" alt="Logo SIPRAK" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';">
                    </div>
                    <div>
                        <div class="font-extrabold text-[15px] tracking-wide text-[#0f2942] leading-tight">SIPRAK</div>
                        <div class="text-[9px] font-bold text-slate-400 tracking-wider uppercase">SMKN 1 GUNUNGPUTRI</div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="px-3 pt-5">
                    <div class="px-3 pb-2 text-[10px] font-bold text-slate-400 tracking-wider uppercase">
                        MENU UTAMA
                    </div>

                    <nav class="space-y-1">
                        <!-- Murid PKL -->
                        <a href="{{ route('kaprog.murid-pkl.index') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('kaprog.murid-pkl.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('kaprog.murid-pkl.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span>Murid PKL</span>
                        </a>

                        <!-- Persetujuan PKL -->
                        <a href="{{ route('kaprog.persetujuan.index') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('kaprog.persetujuan.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('kaprog.persetujuan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span>Persetujuan PKL</span>
                        </a>

                        <!-- Penempatan Industri -->
                        <a href="{{ route('kaprog.penempatan-industri.index') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('kaprog.penempatan-industri.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('kaprog.penempatan-industri.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Penempatan Industri</span>
                        </a>

                        <!-- Laporan PKL -->
                        <a href="{{ route('kaprog.laporan.index') }}"
                           class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('kaprog.laporan.*') ? 'bg-[#0f2942] text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/80' }}">
                            <svg class="w-4 h-4 {{ request()->routeIs('kaprog.laporan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>Laporan PKL</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Container -->
    <div class="kaprog-main min-h-screen flex flex-col min-w-0 transition-all duration-200">
        <!-- Top Navbar -->
        <header class="h-16 min-w-0 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between sticky top-0 z-20 shadow-[0_1px_3px_rgba(0,0,0,0.04)]">
            <!-- Mobile Toggle -->
            <div class="flex items-center gap-2.5 sm:gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Right Actions: User Profile -->
            <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                @php
                    $authUser = \Illuminate\Support\Facades\Auth::user();
                    $guru = $authUser?->guru;
                    $headerName = $guru?->nama ?: ($authUser?->username ?: 'Kepala Program');
                    $jurusanSingkatan = $guru?->jurusanKaprog?->singkatan ?: ($guru?->jurusan?->singkatan ?: ($guru?->jurusanKaprog?->kode ?: ''));
                    $headerRole = $jurusanSingkatan ? ('Kaprog ' . $jurusanSingkatan) : (in_array('Kaprog', (array)($guru?->roles_list ?? [])) ? 'Kepala Program' : ($authUser?->tipe_akun ? ucfirst($authUser->tipe_akun) : 'Kaprog'));
                    $headerInitials = $guru?->initials ?: strtoupper(substr($headerName, 0, 2));
                    $avatarUrl = $guru?->avatar_url ? asset('storage/' . $guru->avatar_url) : ($authUser?->avatar_url ? asset('storage/' . $authUser->avatar_url) : null);
                @endphp

                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ profileOpen: false }">
                    <button @click="profileOpen = !profileOpen" class="flex items-center gap-2.5 sm:gap-3 cursor-pointer text-left">
                        <div class="hidden sm:block text-right">
                            <div class="text-xs font-bold text-slate-900 leading-tight flex items-center justify-end gap-1">
                                <span>{{ $headerName }}</span>
                                <svg class="w-3.5 h-3.5 text-sky-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-[10px] font-semibold text-slate-500 leading-tight mt-0.5">{{ $headerRole }}</div>
                        </div>
                        <div class="relative">
                            @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $headerName }}" class="w-9 h-9 rounded-full object-cover shadow-xs shrink-0 border border-slate-200">
                            @else
                                <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold text-xs flex items-center justify-center shadow-xs shrink-0 tracking-wider">
                                    {{ $headerInitials }}
                                </div>
                            @endif
                            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full ring-2 ring-white"></span>
                        </div>
                    </button>
                    <div x-show="profileOpen" @click.outside="profileOpen = false" x-transition class="absolute right-0 mt-2 w-52 bg-white rounded-2xl border border-slate-200 shadow-xl z-50 py-1.5">
                        <div class="px-4 py-2 border-b border-slate-100">
                            <div class="text-xs font-bold text-slate-900 truncate">{{ $headerName }}</div>
                            <div class="text-[10px] text-slate-500">{{ $headerRole }}</div>
                        </div>
                        <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Edit Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Page Content -->
        <main class="flex-1 p-5 sm:p-6 md:p-8">
            <!-- Flash Notifications -->
            @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium flex items-center justify-between shadow-xs">
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
            <div class="mb-6 p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-800 text-xs font-medium flex items-center justify-between shadow-xs">
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
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium shadow-xs">
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
