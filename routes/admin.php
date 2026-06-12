<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\SecurityController as AdminSecurityController;

Route::middleware('auth', 'role:admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/unit-kerjas', UnitKerjaController::class);
        Route::get('/golongans/export', [GolonganController::class, 'export'])->name('golongans.export');
        Route::resource('/golongans', GolonganController::class);
        Route::resource('/gajis', GajiController::class);
        Route::resource('/users', AdminUserController::class);
        Route::get('/panduan', [\App\Http\Controllers\Admin\GuideController::class, 'index'])->name('panduan');
        Route::resource('/contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);

        Route::prefix('security')
            ->name('security.')
            ->group(function () {
                Route::get('/{mode?}', [AdminSecurityController::class, 'index'])->name('index');
                Route::put('/update-password', [AdminSecurityController::class, 'updatePassword'])->name('updatePassword');
                Route::put('/update-email', [AdminSecurityController::class, 'updateEmail'])->name('updateEmail');
            });
    });
