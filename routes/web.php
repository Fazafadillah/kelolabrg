<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

// =====================================================
// ROUTE AUTENTIKASI (publik, tanpa middleware)
// =====================================================
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// ROUTE YANG BUTUH LOGIN (dilindungi middleware auth.admin)
// =====================================================
Route::middleware('auth.admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kategori (Resource: index, create, store, edit, update, destroy)
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Supplier (Resource)
    Route::resource('suppliers', SupplierController::class)->except(['show']);

    // Barang (Resource)
    Route::resource('items', ItemController::class)->except(['show']);
});
