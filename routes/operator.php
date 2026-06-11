<?php

use App\Http\Controllers\Operator\PegawaiController as OperatorPegawaiController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\PermohonanController as OperatorPermohonanController;
use App\Http\Controllers\Operator\SkPengangkatanController as OperatorSkPengangkatanController;
use App\Http\Controllers\Operator\RiwayatGajiBerkalaController as OperatorRiwayatGajiBerkalaController;
use App\Http\Controllers\Operator\TemplateSkController as OperatorTemplateSkController;
use App\Http\Controllers\Operator\KenaikanPangkatController as OperatorKenaikanPangkatController;
use App\Http\Controllers\Operator\RiwayatKenaikanPangkatController as OperatorRiwayatKenaikanPangkatController;
use App\Http\Controllers\Operator\InstanGbkController as OperatorInstanGbkController;
use App\Http\Controllers\Operator\GuideController as OperatorGuideController;
use App\Http\Controllers\SecurityController as OperatorSecurityController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth', 'role:operator')
    ->prefix('operator')
    ->name('operator.')
    ->group(function () {
        Route::resource('/pegawais', OperatorPegawaiController::class, ['parameters' => ['pegawais' => 'user']]);
        Route::get('pegawais/create/lama', [OperatorPegawaiController::class, 'create'])->name('pegawais.createLama');

        Route::resource('riwayat_gbks', OperatorRiwayatGajiBerkalaController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

        Route::get('/dashboard', [OperatorDashboardController::class, 'index'])->name('dashboard');

        Route::prefix('permohonan-sk')
            ->name('permohonan-sk.')
            ->group(function () {
                Route::get('/', [OperatorPermohonanController::class, 'index'])->name('index');
                Route::get('/{id}', [OperatorPermohonanController::class, 'show'])->name('show');
                Route::get('/{permohonanSk}/attachments/{attachment}/preview', [OperatorPermohonanController::class, 'previewAttachment'])->name('attachments.preview');
                Route::get('/{permohonanSk}/attachments/{attachment}/download', [OperatorPermohonanController::class, 'downloadAttachment'])->name('attachments.download');
                Route::post('/{id}/process', [OperatorPermohonanController::class, 'process'])->name('process');
                Route::post('/print', [OperatorPermohonanController::class, 'printSk'])->name('print-sk');
                Route::match(['get', 'post'], '/{id}/process-sk', [OperatorPermohonanController::class, 'processSk'])->name('process-sk');
                Route::get('/{riwayatGbk}/download', [OperatorPermohonanController::class, 'download'])->name('download');
                Route::delete('/{id}', [OperatorPermohonanController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('sk-pengangkatan')
            ->name('sk-pengangkatan.')
            ->group(function () {
                Route::get('/', [OperatorSkPengangkatanController::class, 'index'])->name('index');
                Route::get('/{skPengangkatan}/show', [OperatorSkPengangkatanController::class, 'show'])->name('show');
                Route::get('/{skPengangkatan}/edit', [OperatorSkPengangkatanController::class, 'edit'])->name('edit');
                Route::put('/{skPengangkatan}/update', [OperatorSkPengangkatanController::class, 'update'])->name('update');
                Route::get('/{skPengangkatan}/download', [OperatorSkPengangkatanController::class, 'download'])->name('download');
            });

        Route::prefix('template-sk')
            ->name('template-sk.')
            ->group(function () {
                Route::get('/', [OperatorTemplateSkController::class, 'index'])->name('index');
                Route::get('/create', [OperatorTemplateSkController::class, 'create'])->name('create');
                Route::post('/store', [OperatorTemplateSkController::class, 'store'])->name('store');
                Route::get('/edit', [OperatorTemplateSkController::class, 'edit'])->name('edit');
                Route::put('/update', [OperatorTemplateSkController::class, 'update'])->name('update');
                Route::delete('/destroy', [OperatorTemplateSkController::class, 'destroy'])->name('destroy');
                Route::get('/{templateSk}/download', [OperatorTemplateSkController::class, 'download'])->name('download');
            });

        // Kenaikan Pangkat (Operator proses)
        Route::prefix('kenaikan-pangkat')
            ->name('kenaikan-pangkat.')
            ->group(function () {
                Route::get('/', [OperatorKenaikanPangkatController::class, 'index'])->name('index');
                Route::get('/{id}', [OperatorKenaikanPangkatController::class, 'show'])->name('show');
                Route::post('/{id}/process', [OperatorKenaikanPangkatController::class, 'process'])->name('process');
                Route::post('/{id}/approve', [OperatorKenaikanPangkatController::class, 'approve'])->name('approve');
                Route::post('/{id}/reject', [OperatorKenaikanPangkatController::class, 'reject'])->name('reject');
                Route::get('/{id}/download', [OperatorKenaikanPangkatController::class, 'download'])->name('download');
            });

        // Riwayat Kenaikan Pangkat (Operator view)
        Route::prefix('riwayat-kenaikan-pangkat')
            ->name('riwayat-kenaikan-pangkat.')
            ->group(function () {
                Route::get('/', [OperatorRiwayatKenaikanPangkatController::class, 'index'])->name('index');
                Route::get('/{id}', [OperatorRiwayatKenaikanPangkatController::class, 'show'])->name('show');
                Route::get('/{id}/download', [OperatorRiwayatKenaikanPangkatController::class, 'download'])->name('download');
            });

        Route::prefix('instan-gbk')
            ->name('instan-gbk.')
            ->group(function () {
                Route::get('/', [OperatorInstanGbkController::class, 'index'])->name('index');
                Route::post('/process', [OperatorInstanGbkController::class, 'process'])->name('process');
                Route::post('/print-sk', [OperatorInstanGbkController::class, 'postPrintSk'])->name('print-sk');
            });

         Route::prefix('security')
            ->name('security.')
            ->group(function () {
                Route::get('/{mode?}', [OperatorSecurityController::class, 'index'])->name('index');
                Route::put('/update-password', [OperatorSecurityController::class, 'updatePassword'])->name('updatePassword');
                Route::put('/update-email', [OperatorSecurityController::class, 'updateEmail'])->name('updateEmail');
            });

        // Panduan Penggunaan (Operator)
        Route::get('/panduan', [OperatorGuideController::class, 'index'])->name('panduan');
    });
