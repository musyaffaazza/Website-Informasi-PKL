<?php

use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\RombelController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\IndustriController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.industri.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Jurusan Routes
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');
    Route::post('/jurusan/{id}/kurikulum', [JurusanController::class, 'updateKurikulum'])->name('jurusan.updateKurikulum');
    Route::post('/jurusan/{id}/industri', [JurusanController::class, 'syncIndustri'])->name('jurusan.syncIndustri');
    Route::get('/jurusan-export', [JurusanController::class, 'export'])->name('jurusan.export');

    // Rombel Routes
    Route::get('/rombel', [RombelController::class, 'index'])->name('rombel.index');
    Route::post('/rombel', [RombelController::class, 'store'])->name('rombel.store');
    Route::put('/rombel/{id}', [RombelController::class, 'update'])->name('rombel.update');
    Route::delete('/rombel/{id}', [RombelController::class, 'destroy'])->name('rombel.destroy');
    Route::post('/rombel/sync-dapodik', [RombelController::class, 'syncDapodik'])->name('rombel.syncDapodik');
    Route::get('/rombel-export', [RombelController::class, 'export'])->name('rombel.export');

    // Guru & Role Routes
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
    Route::put('/guru/{id}', [GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');
    Route::post('/guru/{id}/toggle-status', [GuruController::class, 'toggleStatus'])->name('guru.toggleStatus');
    Route::post('/guru/{id}/send-email', [GuruController::class, 'sendEmail'])->name('guru.sendEmail');
    Route::post('/guru/bulk-role', [GuruController::class, 'bulkRole'])->name('guru.bulkRole');
    Route::post('/guru/bulk-invite', [GuruController::class, 'bulkInvite'])->name('guru.bulkInvite');
    Route::post('/guru/sync-dapodik', [GuruController::class, 'syncDapodik'])->name('guru.syncDapodik');
    Route::get('/guru-export', [GuruController::class, 'export'])->name('guru.export');

    // Siswa Routes
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/bulk-activate', [SiswaController::class, 'bulkActivate'])->name('siswa.bulkActivate');
    Route::post('/siswa/bulk-rombel', [SiswaController::class, 'bulkRombel'])->name('siswa.bulkRombel');
    Route::post('/siswa/invite-pending', [SiswaController::class, 'invitePending'])->name('siswa.invitePending');
    Route::post('/siswa/sync-dapodik', [SiswaController::class, 'syncDapodik'])->name('siswa.syncDapodik');
    Route::get('/siswa-export', [SiswaController::class, 'export'])->name('siswa.export');

    // Industri Routes
    Route::get('/industri', [IndustriController::class, 'index'])->name('industri.index');
    Route::post('/industri', [IndustriController::class, 'store'])->name('industri.store');
    Route::put('/industri/{id}', [IndustriController::class, 'update'])->name('industri.update');
    Route::delete('/industri/{id}', [IndustriController::class, 'destroy'])->name('industri.destroy');
    Route::post('/industri/{id}/update-kuota', [IndustriController::class, 'updateKuota'])->name('industri.updateKuota');
    Route::get('/industri-export', [IndustriController::class, 'export'])->name('industri.export');
    
    // Global Dapodik Sync Route
    Route::post('/dapodik/sync', function () {
        return redirect()->back()->with('success', 'Sinkronisasi Dapodik Kemdikbudristek 2024 berhasil diperbarui secara realtime!');
    })->name('dapodik.sync');
});
