<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPRAK - SMKN 1 Gunungputri | Portal Masuk</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v3 CDN with forms plugin -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Tailwind Custom Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f5fa',
                            100: '#dce8f4',
                            200: '#bdd5ec',
                            500: '#1e629e',
                            700: '#103358',
                            800: '#0f2942',
                            900: '#081726',
                        },
                        accent: {
                            cyan: '#0284c7',
                            gold: '#eab308',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Custom Typography & Micro-interactions Styles -->
    <style data-purpose="base-styling">
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .input-focus-ring:focus-within {
            box-shadow: 0 0 0 3px rgba(15, 41, 66, 0.15);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">
    <!-- BEGIN: MainLayout -->
    <main class="min-h-screen w-full flex flex-col items-center justify-center p-4 sm:p-6 lg:p-8 bg-slate-50 relative overflow-hidden" data-purpose="login-split-container">

        <!-- BEGIN: LeftLoginPanel -->
        <section class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 p-6 sm:p-8 relative z-10 my-auto" data-purpose="login-form-section">

            <!-- Institutional Branding Header -->
            <header class="flex flex-col items-center text-center mb-6" data-purpose="school-brand-header">
                <img alt="Logo SMK Negeri 1 Gunungputri"
                     class="w-16 h-16 object-contain mb-3"
                     src="{{ asset('images/logo.png') }}"
                     onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';"
                >
                <div class="flex items-center justify-center gap-2 mb-1">
                    <span class="text-xs font-bold tracking-wider text-brand-700 uppercase">SMK Negeri 1 Gunungputri</span>
                </div>
                <span class="text-[11px] font-medium text-slate-500 uppercase tracking-widest">Kabupaten Bogor &bull; Jawa Barat</span>
            </header>

            <!-- Main Form Container -->
            <div class="w-full">
                <!-- Heading & Introduction -->
                <div class="mb-6 text-center">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-800 tracking-tight leading-tight">SIPRAK</h1>
                    <p class="text-xs font-bold text-brand-700 uppercase tracking-wider mt-1">Sistem Manajemen PKL</p>
                    <p class="text-sm text-slate-600 mt-2 leading-relaxed">Selamat datang di Portal SIPRAK. Masuk untuk mengelola logbook, presensi terverifikasi, dan penempatan industri.</p>
                </div>

                {{-- Error Alerts --}}
                @if($errors->any())
                    <div class="mb-4 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                        @foreach($errors->all() as $error)
                            <p class="font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <!-- Authentication Form -->
                <form class="space-y-4" method="POST" action="{{ route('login') }}" data-purpose="login-form">
                    @csrf

                    <!-- Username / Identifier Field -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" for="user_id">
                            USER ID (NISN / NIP)
                        </label>
                        <div class="relative rounded-xl border border-slate-300 transition-all duration-200 input-focus-ring bg-white">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
                                </svg>
                            </div>
                            <input class="block w-full pl-11 pr-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 border-0 rounded-xl focus:ring-1 focus:ring-brand-700 bg-transparent"
                                   id="user_id"
                                   name="user_id"
                                   value="{{ old('user_id') }}"
                                   placeholder="Masukkan NISN atau NIP"
                                   required
                                   type="text"
                                   autofocus>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5" for="password">
                            Kata Sandi (Password)
                        </label>
                        <div class="relative rounded-xl border border-slate-300 transition-all duration-200 input-focus-ring bg-white">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
                                </svg>
                            </div>
                            <input class="block w-full pl-11 pr-11 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 border-0 rounded-xl focus:ring-1 focus:ring-brand-700 bg-transparent"
                                id="password"
                                name="password"
                                placeholder="••••••••••••"
                                required
                                type="password">
                            <button aria-label="Tampilkan atau sembunyikan kata sandi"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none"
                                    id="togglePassword"
                                    type="button">
                                <!-- Eye Icon default -->
                                <svg class="w-5 h-5" fill="none" id="eyeIcon" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Options Row: Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center cursor-pointer">
                            <input class="w-4 h-4 rounded text-brand-700 border-slate-300 focus:ring-brand-700/30"
                                   id="remember"
                                   name="remember"
                                   type="checkbox">
                            <span class="ml-2 text-xs font-medium text-slate-600 select-none">Ingat saya di perangkat ini</span>
                        </label>
                        <a class="text-xs font-semibold text-brand-700 hover:text-brand-900 transition-colors duration-150" href="{{ route('password.request') }}">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <!-- Primary Submit Button -->
                    <div class="pt-2">
                        <button class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-brand-800 hover:bg-brand-700 text-white font-bold text-sm shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-brand-800 focus:ring-offset-2"
                                type="submit">
                            <span>Masuk ke Sistem</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Institutional Constraint Notice (Admin Provisioned Only) -->
                <div class="mt-6 pt-5 border-t border-slate-100 text-center" data-purpose="admin-provisioned-notice">
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Belum memiliki akun atau terkendala login?
                        <span class="block mt-0.5 text-slate-700 font-semibold">
                            Hubungi Tim Hubin SMKN 1 Gunungputri.
                        </span>
                    </p>
                </div>
            </div>

            <!-- Institutional Footer Copyright -->
            <footer class="mt-5 pt-3 text-center border-t border-slate-100" data-purpose="portal-footer">
                <p class="text-[11px] text-slate-400 font-medium">
                    &copy; 2025 SMKN 1 Gunungputri &bull; Terintegrasi Kurikulum Merdeka &amp; DUDI
                </p>
            </footer>
        </section>
        <!-- END: LeftLoginPanel -->

    </main>
    <!-- END: MainLayout -->

    <!-- BEGIN: InteractiveScripts -->
    <script data-purpose="password-toggle">
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', () => {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                    // Toggle eye icon styling or icon state
                    toggleBtn.classList.toggle('text-brand-700', isPassword);
                    toggleBtn.classList.toggle('text-slate-400', !isPassword);
                });
            }
        });
    </script>
    <!-- END: InteractiveScripts -->
</body>
</html>
