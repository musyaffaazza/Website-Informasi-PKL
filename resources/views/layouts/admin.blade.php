<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPRAK SMKN 1 GUNUNGPUTRI')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('image/logo_skiell.jpeg') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind & Vite Assets -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

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
                    } elseif (request()->routeIs('admin.log-aktivitas.*')) {
                        $searchAction = route('admin.log-aktivitas.index');
                    }
                @endphp
                <form action="{{ $searchAction }}" method="GET" class="relative w-full max-w-xl min-w-0">
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
                           placeholder="Search"
                           class="w-full h-12 pl-10 pr-4 bg-slate-50/80 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition">
                </form>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-3 sm:gap-4 shrink-0">


                @php
                    $headerUser = \Illuminate\Support\Facades\Auth::user() ?: \App\Models\User::where('username', 'admin')->first();
                    $headerInitials = strtoupper(substr($headerUser?->username ?? 'AD', 0, 2));
                @endphp
                <!-- User Profile Info with Dropdown -->
                <div class="relative" x-data="{ profileOpen: false }">
                    <button @click="profileOpen = !profileOpen" class="flex items-center gap-2.5 sm:gap-3 cursor-pointer">
                        <div class="w-9 h-9 overflow-hidden rounded-full bg-slate-100 text-slate-700 border border-slate-200 font-bold text-xs flex items-center justify-center shadow-xs shrink-0">
                            @if($headerUser?->avatar_url)
                                <img src="{{ asset('storage/' . $headerUser->avatar_url) }}" alt="Foto profil" class="h-full w-full object-cover">
                            @else
                                {{ $headerInitials }}
                            @endif
                        </div>
                        <div class="hidden sm:block text-left">
                            <div class="text-xs font-bold text-slate-900 leading-tight">Admin Sistem</div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="profileOpen" @click.outside="profileOpen = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl border border-slate-200 shadow-lg z-50 py-1">
                        <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Edit Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
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

    <div id="deleteConfirmModal" class="fixed inset-0 z-[100] hidden" role="alertdialog" aria-modal="true" aria-labelledby="deleteConfirmTitle" aria-describedby="deleteConfirmMessage">
        <div data-delete-cancel class="absolute inset-0 bg-slate-900/60"></div>
        <div class="relative flex min-h-screen items-center justify-center p-4">
            <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-6 text-center shadow-2xl sm:p-8">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-rose-600">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" /></svg>
                </div>
                <h2 id="deleteConfirmTitle" class="mt-4 text-lg font-extrabold text-slate-900">Hapus Data?</h2>
                <p id="deleteConfirmMessage" class="mt-2 text-sm leading-relaxed text-slate-500">Data yang dihapus tidak dapat dipulihkan.</p>
                <div class="mt-7 flex gap-3">
                    <button type="button" data-delete-cancel class="flex-1 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-100">Batal</button>
                    <button id="deleteConfirmSubmit" type="button" class="flex-1 rounded-xl bg-rose-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-rose-700">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const modal = document.getElementById('deleteConfirmModal');
            const message = document.getElementById('deleteConfirmMessage');
            const submit = document.getElementById('deleteConfirmSubmit');
            let pendingForm = null;

            const close = () => {
                modal.classList.add('hidden');
                if (pendingForm?.dataset.deleteTemporary === 'true') pendingForm.remove();
                pendingForm = null;
            };

            window.confirmDeleteAction = (form, text = 'Data yang dihapus tidak dapat dipulihkan.') => {
                pendingForm = form;
                message.textContent = text;
                modal.classList.remove('hidden');
                submit.focus();
                return false;
            };

            modal.querySelectorAll('[data-delete-cancel]').forEach((button) => button.addEventListener('click', close));
            submit.addEventListener('click', () => {
                const form = pendingForm;
                pendingForm = null;
                modal.classList.add('hidden');
                form?.submit();
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) close();
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>
