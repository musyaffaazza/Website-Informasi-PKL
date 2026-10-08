@extends('layouts.admin')
@section('title', 'Edit Profil - SIPRAK')
@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-[#0f2942]">Edit Profil</h1>
        <p class="mt-1 text-sm text-slate-500">Perbarui foto profil atau kata sandi akun admin.</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        @if($errors->any())
            <div class="m-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="border-b border-slate-100 bg-slate-50/70 p-6 sm:p-8">
                <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                    <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-full border-4 border-white bg-[#0f2942] text-2xl font-extrabold text-white shadow-md">
                        @if($user->avatar_url)
                            <img src="{{ asset('storage/' . $user->avatar_url) }}" alt="Foto profil" class="h-full w-full object-cover">
                        @else
                            AD
                        @endif
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900">Foto Profil</h2>
                        <p class="mt-1 text-sm text-slate-500">Gunakan foto JPG, JPEG, atau PNG maksimal 2 MB.</p>
                        <label class="mt-4 inline-flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-100">
                            <svg class="h-4 w-4 text-[#0f2942]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L21 16m-9-9h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Pilih Foto
                            <input type="file" name="avatar" accept="image/png,image/jpeg" class="hidden">
                        </label>
                    </div>
                </div>
            </div>

            <div class="space-y-6 p-6 sm:p-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700">USER ID</label>
                    <div class="mt-2 flex items-center justify-between rounded-xl border border-slate-200 bg-slate-100 px-4 py-3.5">
                        <span class="font-bold text-slate-800">{{ $user->username }}</span>
                        <span class="text-xs font-semibold text-slate-400">Tidak dapat diubah</span>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <h2 class="text-base font-extrabold text-slate-900">Ubah Kata Sandi</h2>
                    <p class="mt-1 text-sm text-slate-500">Kosongkan jika tidak ingin mengubah kata sandi.</p>
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <label class="block text-sm font-bold text-slate-700">
                            Kata sandi baru
                            <input type="password" name="password" autocomplete="new-password" class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-[#0f2942] focus:ring-[#0f2942]">
                        </label>
                        <label class="block text-sm font-bold text-slate-700">
                            Ulangi kata sandi baru
                            <input type="password" name="password_confirmation" autocomplete="new-password" class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-[#0f2942] focus:ring-[#0f2942]">
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end border-t border-slate-100 bg-slate-50/70 p-6 sm:p-8">
                <button type="submit" class="rounded-xl bg-[#0f2942] px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#1a385c]">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection