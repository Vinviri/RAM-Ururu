<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Toko RAM Ururu
|--------------------------------------------------------------------------
*/

// Auth Routes (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});

// Protected Routes (Auth required)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data - Kategori Barang
    Route::resource('kategori', KategoriController::class)->parameters([
        'kategori' => 'kategori',
    ]);

    // Master Data - Daftar Barang
    Route::resource('barang', BarangController::class)->parameters([
        'barang' => 'barang',
    ]);

    // Master Data - Manajemen Pengguna
    Route::resource('pengguna', PenggunaController::class)->parameters([
        'pengguna' => 'pengguna',
    ]);

    // Persediaan Barang
    Route::prefix('persediaan')->name('persediaan.')->group(function () {
        Route::get('/stok', [App\Http\Controllers\PersediaanController::class, 'indexStok'])->name('stok');
        Route::get('/masuk', [App\Http\Controllers\PersediaanController::class, 'createMasuk'])->name('masuk.create');
        Route::post('/masuk', [App\Http\Controllers\PersediaanController::class, 'storeMasuk'])->name('masuk.store');
        Route::get('/keluar', [App\Http\Controllers\PersediaanController::class, 'createKeluar'])->name('keluar.create');
        Route::post('/keluar', [App\Http\Controllers\PersediaanController::class, 'storeKeluar'])->name('keluar.store');
    });

    // Laporan
    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [App\Http\Controllers\LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');

    // API Internal
    Route::get('/api/barang-detail/{barang}', [App\Http\Controllers\PersediaanController::class, 'getDetailBarang']);
});
