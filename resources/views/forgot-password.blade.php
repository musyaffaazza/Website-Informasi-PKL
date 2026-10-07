<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - SIPRAK</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4">
    <main class="w-full max-w-[560px] rounded-2xl border border-slate-200 bg-white px-6 py-10 shadow-xl sm:px-9">
        <div class="text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo sekolah" class="mx-auto mb-5 h-20 w-20 object-contain" onerror="this.onerror=null; this.src='{{ asset('logo.png') }}';">
            <h1 class="text-3xl font-extrabold tracking-tight text-[#0f2942]">Reset Kata Sandi</h1>
            <p class="mx-auto mt-3 max-w-md text-base leading-relaxed text-slate-500">Masukkan USER ID dan password lama, lalu buat password baru.</p>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-xl border border-rose-200 bg-rose-50 p-3 text-sm text-rose-700">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset') }}" class="mt-7 space-y-4">
            @csrf
            <label class="block text-sm font-bold text-[#0f2942]">
                USER ID (NISN / NIP)
                <input name="user_id" value="{{ old('user_id') }}" required autofocus autocomplete="username" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 text-sm focus:border-[#0f2942] focus:ring-[#0f2942]">
            </label>

            <label class="block text-sm font-bold text-[#0f2942]">
                Password lama
                <input type="password" name="current_password" required autocomplete="current-password" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 text-sm focus:border-[#0f2942] focus:ring-[#0f2942]">
            </label>

            <label class="block text-sm font-bold text-[#0f2942]">
                Password baru
                <input type="password" name="password" required minlength="8" autocomplete="new-password" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 text-sm focus:border-[#0f2942] focus:ring-[#0f2942]">
            </label>

            <label class="block text-sm font-bold text-[#0f2942]">
                Konfirmasi password baru
                <input type="password" name="password_confirmation" required minlength="8" autocomplete="new-password" class="mt-2 block w-full rounded-xl border-slate-300 px-4 py-3 text-sm focus:border-[#0f2942] focus:ring-[#0f2942]">
            </label>

            <button type="submit" class="w-full rounded-xl bg-[#0f2942] py-3.5 text-sm font-bold text-white transition hover:bg-[#1a385c]">Simpan Password Baru</button>
        </form>

        <a href="{{ route('login') }}" class="mt-6 block text-center text-sm font-semibold text-[#103358] hover:underline">Kembali ke login</a>
    </main>
</body>
</html>