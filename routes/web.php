<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\RiwayatController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PengaturanController;
use Illuminate\Support\Facades\Route;

// Halaman awal pilih role
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Auth
Route::get('/login/{role}', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Area Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::get('/jadwal/hari-ini', [JadwalController::class, 'hariIni'])->name('jadwal.hari-ini');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');

    // Route spesifik booking (create, availability) HARUS di atas route dengan parameter {id}
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/availability', [BookingController::class, 'availability'])->name('booking.availability');
    Route::get('/booking/{id}', [JadwalController::class, 'show'])->name('booking.show');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::put('/pengaturan/profil', [PengaturanController::class, 'updateProfil'])->name('pengaturan.profil');
    Route::put('/pengaturan/keamanan', [PengaturanController::class, 'updateKeamanan'])->name('pengaturan.keamanan');
});

// User (Satpam) - tanpa auth
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\User\JadwalController::class, 'index'])->name('dashboard');
    Route::get('/booking/{id}', [\App\Http\Controllers\User\JadwalController::class, 'show'])->name('booking.show');
});