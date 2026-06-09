<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'loginView'])->name("login");
Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
