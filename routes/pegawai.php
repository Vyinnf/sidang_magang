<?php

use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboardController;
use App\Http\Controllers\Pegawai\PermohonanController as PegawaiPermohonanController;
use App\Http\Controllers\Pegawai\ProfileController as PegawaiProfileController;
use App\Http\Controllers\Pegawai\RiwayatGbkController as PegawaiRiwayatGbkController;
use App\Http\Controllers\SecurityController as PegawaiSecurityController;

use Illuminate\Support\Facades\Route;


Route::middleware('auth', 'role:pegawai')
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {
        Route::get('/dashboard', [PegawaiDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('profile')
            ->name('profile.')
            ->group(function () {
                Route::get('/', [PegawaiProfileController::class, 'index'])->name('index');
                Route::get('/edit', [PegawaiProfileController::class, 'edit'])->name('edit');
                Route::get('/profile-photo/{user}', [PegawaiProfileController::class, 'view'])->name('view-photo');
                Route::put('/update', [PegawaiProfileController::class, 'update'])->name('update');
            });

        Route::prefix('riwayat-gbk')
            ->name('riwayat-gbk.')
            ->group(function () {
                Route::get('/export/{format}', [PegawaiRiwayatGbkController::class, 'export'])->name('export');
                Route::get('/', [PegawaiRiwayatGbkController::class, 'index'])->name('index');
                Route::get('/{id}/show', [PegawaiRiwayatGbkController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [PegawaiRiwayatGbkController::class, 'edit'])->name('edit');
                Route::put('/{id}/update', [PegawaiRiwayatGbkController::class, 'update'])->name('update');
                Route::get('/{id}/download', [PegawaiRiwayatGbkController::class, 'download'])->name('download');
            });

        Route::prefix('permohonan-sk')
            ->name('permohonan-sk.')
            ->group(function () {
                Route::get('/', [PegawaiPermohonanController::class, 'index'])->name('index');
                Route::get('/create', [PegawaiPermohonanController::class, 'create'])->name('create');
                Route::post('/', [PegawaiPermohonanController::class, 'store'])->name('store');
                Route::get('/{permohonanSk}/attachments/{attachment}/preview', [PegawaiPermohonanController::class, 'previewAttachment'])->name('attachments.preview');
                Route::get('/{permohonanSk}/attachments/{attachment}/download', [PegawaiPermohonanController::class, 'downloadAttachment'])->name('attachments.download');
                Route::get('/{permohonanSk}', [PegawaiPermohonanController::class, 'show'])->name('show');
                Route::get('/{riwayatGbk}/download', [PegawaiPermohonanController::class, 'download'])->name('download');
            });

        // Pengajuan Kenaikan Pangkat
        Route::prefix('permohonan-kenaikan-pangkat')
            ->name('permohonan-kenaikan-pangkat.')
            ->group(function () {
                Route::get('/', [\App\Http\Controllers\Pegawai\KenaikanPangkatController::class, 'index'])->name('index');
                Route::get('/create', [\App\Http\Controllers\Pegawai\KenaikanPangkatController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\Pegawai\KenaikanPangkatController::class, 'store'])->name('store');
                Route::get('/{id}', [\App\Http\Controllers\Pegawai\KenaikanPangkatController::class, 'show'])->name('show');
                Route::get('/{id}/download', [\App\Http\Controllers\Pegawai\KenaikanPangkatController::class, 'download'])->name('download');
            });

        // Riwayat Kenaikan Pangkat (versi pegawai untuk melihat)
        Route::prefix('riwayat-kenaikan-pangkat')
            ->name('riwayat-kenaikan-pangkat.')
            ->group(function () {
                Route::get('/', [\App\Http\Controllers\Pegawai\RiwayatKenaikanPangkatController::class, 'index'])->name('index');
                Route::get('/{id}', [\App\Http\Controllers\Pegawai\RiwayatKenaikanPangkatController::class, 'show'])->name('show');
                Route::get('/{id}/download', [\App\Http\Controllers\Pegawai\RiwayatKenaikanPangkatController::class, 'download'])->name('download');
            });

        Route::prefix('security')
            ->name('security.')
            ->group(function () {
                Route::get('/{mode?}', [PegawaiSecurityController::class, 'index'])->name('index');
                Route::put('/update-password', [PegawaiSecurityController::class, 'updatePassword'])->name('updatePassword');
                Route::put('/update-email', [PegawaiSecurityController::class, 'updateEmail'])->name('updateEmail');
            });

        Route::get('/edit', [PegawaiDashboardController::class, 'edit'])->name('edit');
        Route::get('/detail', [PegawaiDashboardController::class, 'detailGaji'])->name('detail');
        Route::get('/gaji/riwayat', [PegawaiDashboardController::class, 'riwayatGaji'])->name('gaji.riwayat');

        // Panduan Penggunaan Pegawai
        Route::get('/panduan', [\App\Http\Controllers\Pegawai\GuideController::class, 'index'])->name('panduan');
    });
