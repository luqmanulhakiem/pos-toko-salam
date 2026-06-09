<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginView'])->name("login");
Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");

Route::controller(UserManagementController::class)->group(function () {
    Route::group(['prefix' => 'user-management'], function () {
        Route::get('/', 'index')->name('userManagement');
    });
});
