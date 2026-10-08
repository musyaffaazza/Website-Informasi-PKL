<?php

use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\RombelController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\LogAktivitasController;
use App\Http\Controllers\Admin\IndustriController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', fn() => view()->exists('login') ? view('login') : view('auth.login'))->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'user_id' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    $userId = trim($request->input('user_id'));
    $password = $request->input('password');

    $account = \App\Models\User::where('username', $userId)->first();
    if (!$account) {
        $account = \App\Models\Guru::where('nip', $userId)->with('user')->first()?->user;
    }
    if (!$account) {
        $account = \App\Models\Siswa::where(function ($query) use ($userId) {
            $query->where('nisn', $userId)->orWhere('nis', $userId);
        })->with('user')->first()?->user;
    }

    if ($account && \Illuminate\Support\Facades\Auth::attempt(['username' => $account->username, 'password' => $password], $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->route('admin.jurusan.index');
    }

    return back()->withErrors(['user_id' => 'USER ID atau kata sandi salah.'])->onlyInput('user_id');
})->name('login.post');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Forgot password: show form & handle reset
Route::get('/forgot-password', function () {
    return view()->exists('forgot-password') ? view('forgot-password') : view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (\Illuminate\Http\Request $request) {
    $data = $request->validate([
        'user_id' => ['required', 'string', 'max:50'],
        'current_password' => ['required', 'string'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $userId = trim($data['user_id']);
    $user = \App\Models\User::where('username', $userId)->first();
    if (!$user) {
        $user = \App\Models\Guru::where('nip', $userId)->with('user')->first()?->user;
    }
    if (!$user) {
        $user = \App\Models\Siswa::where(function ($query) use ($userId) {
            $query->where('nisn', $userId)->orWhere('nis', $userId);
        })->with('user')->first()?->user;
    }

    if (!$user) {
        return back()->withErrors(['user_id' => 'USER ID tidak ditemukan.'])->withInput();
    }

    if (!\Illuminate\Support\Facades\Hash::check($data['current_password'], $user->password_hash)) {
        return back()->withErrors(['current_password' => 'Password lama salah.'])->withInput();
    }

    $user->password_hash = \Illuminate\Support\Facades\Hash::make($data['password']);
    $user->save();

    return redirect()->route('login')->with('success', 'Kata sandi berhasil diubah. Silakan login dengan kata sandi baru.');
})->name('password.reset');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.jurusan.index'));
    Route::get('/profile', function () {
        $user = \Illuminate\Support\Facades\Auth::user() ?: \App\Models\User::where('username', 'admin')->firstOrFail();
        return view('admin.profile', compact('user'));
    })->name('profile');
    Route::put('/profile', function (\Illuminate\Http\Request $request) {
        $user = \Illuminate\Support\Facades\Auth::user() ?: \App\Models\User::where('username', 'admin')->firstOrFail();
        $data = $request->validate([
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if (!empty($data['password'])) {
            $user->password_hash = \Illuminate\Support\Facades\Hash::make($data['password']);
        }
        if ($request->hasFile('avatar')) {
            if ($user->avatar_url) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar_url);
            }
            $user->avatar_url = $request->file('avatar')->store('profile', 'public');
        }
        $user->save();
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    })->name('profile.update');

    // Jurusan
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');
    Route::post('/jurusan/{id}/kurikulum', [JurusanController::class, 'updateKurikulum'])->name('jurusan.updateKurikulum');
    Route::post('/jurusan/{id}/industri', [JurusanController::class, 'syncIndustri'])->name('jurusan.syncIndustri');
    Route::get('/jurusan-export', [JurusanController::class, 'export'])->name('jurusan.export');
    Route::post('/jurusan/bulk-delete', [JurusanController::class, 'bulkDelete'])->name('jurusan.bulkDelete');

    // Rombel
    Route::get('/rombel', [RombelController::class, 'index'])->name('rombel.index');
    Route::post('/rombel', [RombelController::class, 'store'])->name('rombel.store');
    Route::put('/rombel/{id}', [RombelController::class, 'update'])->name('rombel.update');
    Route::delete('/rombel/{id}', [RombelController::class, 'destroy'])->name('rombel.destroy');
    Route::get('/rombel-export', [RombelController::class, 'export'])->name('rombel.export');
    Route::post('/rombel/bulk-delete', [RombelController::class, 'bulkDelete'])->name('rombel.bulkDelete');

    // Guru
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
    Route::put('/guru/{id}', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');
    Route::post('/guru/{id}/toggle-status', [GuruController::class, 'toggleStatus'])->name('guru.toggleStatus');
    Route::post('/guru/{id}/send-email', [GuruController::class, 'sendEmail'])->name('guru.sendEmail');
    Route::post('/guru/bulk-role', [GuruController::class, 'bulkRole'])->name('guru.bulkRole');
    Route::post('/guru/bulk-invite', [GuruController::class, 'bulkInvite'])->name('guru.bulkInvite');
    Route::get('/guru-export', [GuruController::class, 'export'])->name('guru.export');
    Route::post('/guru/bulk-delete', [GuruController::class, 'bulkDelete'])->name('guru.bulkDelete');

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/bulk-activate', [SiswaController::class, 'bulkActivate'])->name('siswa.bulkActivate');
    Route::post('/siswa/bulk-rombel', [SiswaController::class, 'bulkRombel'])->name('siswa.bulkRombel');
    Route::post('/siswa/invite-pending', [SiswaController::class, 'invitePending'])->name('siswa.invitePending');
    Route::get('/siswa-export', [SiswaController::class, 'export'])->name('siswa.export');
    Route::post('/siswa/bulk-delete', [SiswaController::class, 'bulkDelete'])->name('siswa.bulkDelete');

    // Industri
    Route::get('/industri', [IndustriController::class, 'index'])->name('industri.index');
    Route::post('/industri', [IndustriController::class, 'store'])->name('industri.store');
    Route::put('/industri/{id}', [IndustriController::class, 'update'])->name('industri.update');
    Route::delete('/industri/{id}', [IndustriController::class, 'destroy'])->name('industri.destroy');
    Route::post('/industri/{id}/update-kuota', [IndustriController::class, 'updateKuota'])->name('industri.updateKuota');
    Route::get('/industri-export', [IndustriController::class, 'export'])->name('industri.export');
    Route::post('/industri/bulk-delete', [IndustriController::class, 'bulkDelete'])->name('industri.bulkDelete');

    // Mapping Pembimbing
    Route::get('/mapping-pembimbing', [\App\Http\Controllers\Admin\MappingPembimbingController::class, 'index'])->name('mapping-pembimbing.index');
    Route::post('/mapping-pembimbing', [\App\Http\Controllers\Admin\MappingPembimbingController::class, 'store'])->name('mapping-pembimbing.store');
    Route::put('/mapping-pembimbing/{id}', [\App\Http\Controllers\Admin\MappingPembimbingController::class, 'update'])->name('mapping-pembimbing.update');
    Route::delete('/mapping-pembimbing/{id}', [\App\Http\Controllers\Admin\MappingPembimbingController::class, 'destroy'])->name('mapping-pembimbing.destroy');
    Route::get('/mapping-pembimbing-export', [\App\Http\Controllers\Admin\MappingPembimbingController::class, 'export'])->name('mapping-pembimbing.export');

    // Log Aktivitas
    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
    Route::get('/log-aktivitas-export', [LogAktivitasController::class, 'export'])->name('log-aktivitas.export');

    // Dapodik Sync
    Route::post('/dapodik/sync', fn() => redirect()->back()->with('success', 'Sinkronisasi data berhasil!'))->name('dapodik.sync');
});

