<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/', [BarcodeController::class, 'index'])->name('barcode.index');
    Route::get('/stats', [BarcodeController::class, 'getStats'])->name('barcode.stats');
    Route::get('/search', [BarcodeController::class, 'search'])->name('barcode.search');
    Route::post('/generate', [BarcodeController::class, 'generate'])->name('barcode.generate');
    Route::get('/barcode/{code}', [BarcodeController::class, 'generateBarcode'])->name('barcode.image');
    Route::get('/reports', [BarcodeController::class, 'reports'])->name('barcode.reports');
    Route::get('/reports/export', [BarcodeController::class, 'exportReports'])->name('barcode.reports.export');
});
