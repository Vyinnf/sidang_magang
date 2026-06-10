<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SkController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;

use Illuminate\Support\Facades\Route;
use App\Models\ContactMessage;

require __DIR__ . '/operator.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/pegawai.php';


Route::get('/', function () {
    $messages = ContactMessage::latest()->get();

    return view('landing', compact('messages'));
})->name('landing');

// Public contact form endpoint
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('loginForm');
Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/download/sk/{path}', [SkController::class, 'download'])->name('sk.download');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
});
