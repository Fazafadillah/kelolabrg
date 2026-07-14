<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;

// =====================================================
// ROUTE AUTENTIKASI (publik)
// =====================================================
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =====================================================
// ROUTE YANG BUTUH LOGIN
// =====================================================
Route::middleware('auth.admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Resource
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('suppliers',  SupplierController::class)->except(['show']);
    Route::resource('items',      ItemController::class)->except(['show']);

    // =====================================================
    // EXCEL — Export & Import
    // =====================================================
    Route::prefix('excel')->name('excel.')->group(function () {

        // Halaman import
        Route::get('/import', [ExcelController::class, 'showImport'])->name('import');

        // Export
        Route::get('/export/all',        [ExcelController::class, 'exportAll'])->name('export.all');
        Route::get('/export/items',      [ExcelController::class, 'exportItems'])->name('export.items');
        Route::get('/export/categories', [ExcelController::class, 'exportCategories'])->name('export.categories');
        Route::get('/export/suppliers',  [ExcelController::class, 'exportSuppliers'])->name('export.suppliers');

        // Import (POST)
        Route::post('/import/items',      [ExcelController::class, 'importItems'])->name('import.items');
        Route::post('/import/categories', [ExcelController::class, 'importCategories'])->name('import.categories');
        Route::post('/import/suppliers',  [ExcelController::class, 'importSuppliers'])->name('import.suppliers');

        // Download template kosong
        Route::get('/template/items',      [ExcelController::class, 'downloadTemplateItems'])->name('template.items');
        Route::get('/template/categories', [ExcelController::class, 'downloadTemplateCategories'])->name('template.categories');
        Route::get('/template/suppliers',  [ExcelController::class, 'downloadTemplateSuppliers'])->name('template.suppliers');
    });
});
