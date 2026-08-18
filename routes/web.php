<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
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

// Area Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::get('/riwayat', function () {
        return view('admin.riwayat'); // buat view kosong dulu kalau perlu
    })->name('riwayat');

    Route::get('/pengaturan', function () {
        return view('admin.pengaturan');
    })->name('pengaturan');
});

// Area User
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
});
