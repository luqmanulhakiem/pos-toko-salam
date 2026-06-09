<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// Pengecekan apakah sudah login atau belum
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});


// Kumpulan Route yang bisa diakses ketika user belum login
Route::middleware(['guest'])->group(function () {
    // View Halaman Login
    Route::get('/login', [AuthController::class, 'loginView'])->name("login");
    // Request Login
    Route::post('/login-request', [AuthController::class, 'login'])->name("login.request");
});

// Kumpulan Route yang hanya bisa diakses ketika user sudah login
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");

    // User Management / Manajemen Akun Karyawan
    Route::controller(UserManagementController::class)->group(function () {
        Route::group(['prefix' => 'user-management'], function () {
            Route::get('/', 'index')->name('userManagement');
        });
    });

    // logout request
    Route::post('logout-request', [AuthController::class, 'logout'])->name('logout.request');
});
