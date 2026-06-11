<?php

use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\ProdukController as APIProdukController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StokFlowController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AuthUserController;
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
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    // Request Login
    Route::post('/login-request', [AuthController::class, 'login'])->name('login.request');
});

// Kumpulan Route yang hanya bisa diakses ketika user sudah login
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // logout request
    Route::post('logout-request', [AuthController::class, 'logout'])->name('logout.request');
    // Stok Flow
    Route::post('/stock-flow/store', [StokFlowController::class, 'store'])->name('stok-flow.store');

    // Profile
    Route::controller(AuthUserController::class)->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::put('/profile/update-profile', 'updateProfile')->name('profile.update_profile');
        Route::put('/profile/update-password', 'updatePassword')->name('profile.update_password');
    });

    Route::controller(KasirController::class)->group(function () {
        Route::get('/kasir', 'index')->name('kasir');
        Route::post('/kasir', 'store')->name('kasir.store');
    });

    // Cart API
    Route::controller(CartController::class)->group(function () {
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', 'index')->name('cart');
            Route::post('/store', 'store')->name('cart.store');
            Route::delete('/clear', 'clearCart')->name('cart.clear');
        });
    });
    Route::controller(CartController::class)->group(function () {
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', 'index')->name('cart');
            Route::post('/store', 'store')->name('cart.store');
            Route::delete('/clear', 'clearCart')->name('cart.clear');
        });
    });

    // Produk API
    Route::controller(APIProdukController::class)->group(function () {
        Route::group(['prefix' => 'api/produk'], function () {
            Route::get('/', 'index')->name('api.produk');
        });
    });

    // Produk
    Route::controller(ProdukController::class)->group(function () {
        Route::group(['prefix' => 'produk'], function () {
            Route::get('/', 'index')->name('produk');
            Route::middleware('role:admin')->group(function () {
                Route::get('/create', 'create')->name('produk.create');
                Route::post('/store', 'store')->name('produk.store');
                Route::get('/edit/{id}', 'edit')->name('produk.edit');
                Route::put('/update/{id}', 'update')->name('produk.update');
                Route::delete('/delete/{id}', 'destroy')->name('produk.delete');
            });

            // Stok Flow
            Route::controller(StokFlowController::class)->group(function () {
                Route::group(['prefix' => 'stock-flow'], function () {
                    Route::middleware('role:admin')->get('/add-stock/{idProduk}', 'addStock')->name('stok-flow.add');
                    Route::middleware('role:admin')->get('/decrease-stock/{idProduk}', 'decreaseStock')->name('stok-flow.decrease');
                });
            });
        });
    });

    Route::middleware('role:admin')->group(function () {
        // User Management / Manajemen Akun Karyawan
        Route::controller(UserManagementController::class)->group(function () {
            Route::group(['prefix' => 'user-management'], function () {
                Route::get('/', 'index')->name('userManagement');
                Route::get('/create', 'create')->name('userManagement.create');
                Route::post('/store', 'store')->name('userManagement.store');
                Route::get('/edit/{id}', 'edit')->name('userManagement.edit');
                Route::put('/update/{id}', 'update')->name('userManagement.update');
                Route::delete('/delete/{id}', 'destroy')->name('userManagement.delete');
            });
        });

        // Kategori
        Route::controller(KategoriController::class)->group(function () {
            Route::group(['prefix' => 'kategori'], function () {
                // Kategori
                Route::get('/', 'index')->name('kategori');
                Route::get('/create', 'create')->name('kategori.create');
                Route::post('/store', 'store')->name('kategori.store');
                Route::get('/edit/{id}', 'edit')->name('kategori.edit');
                Route::put('/update/{id}', 'update')->name('kategori.update');
                Route::delete('/delete/{id}', 'destroy')->name('kategori.delete');
            });
        });

        // Laporan
        Route::group(['prefix' => 'laporan'], function () {
            // Laporan Flow Stok
            Route::controller(StokFlowController::class)->group(function () {
                Route::get('stock-flow', 'index')->name('stok-flow.report');
                Route::get('stock-flow/export-pdf', 'exportPdf')->name('stok-flow.exportPdf');
            });
            // Laporan Penjualan
            Route::controller(PenjualanController::class)->group(function () {
                Route::get('penjualan', 'index')->name('penjualan.report');
                Route::get('penjualan/show/{penjualan}', 'show')->name('penjualan.show');
                Route::get('penjualan/export-pdf', 'exportPdf')->name('penjualan.exportPdf');
            });
        });

        // Konfigurasi
        Route::controller(TokoController::class)->group(function () {
            Route::get('konfigurasi', 'index')->name('konfigurasi.index');
            Route::put('konfigurasi', 'update')->name('konfigurasi.update');
        });
    });
});
