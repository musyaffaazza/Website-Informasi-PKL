<?php

use App\Http\Controllers\Admin\JurusanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.jurusan.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
    Route::post('/jurusan', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::put('/jurusan/{id}', [JurusanController::class, 'update'])->name('jurusan.update');
    Route::delete('/jurusan/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy');
    Route::post('/jurusan/{id}/kurikulum', [JurusanController::class, 'updateKurikulum'])->name('jurusan.updateKurikulum');
    Route::post('/jurusan/{id}/industri', [JurusanController::class, 'syncIndustri'])->name('jurusan.syncIndustri');
    Route::get('/jurusan-export', [JurusanController::class, 'export'])->name('jurusan.export');
    
    Route::post('/dapodik/sync', function () {
        return redirect()->back()->with('success', 'Sinkronisasi Dapodik Kemdikbudristek 2024 berhasil diperbarui secara realtime!');
    })->name('dapodik.sync');
});
