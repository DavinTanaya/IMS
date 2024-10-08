<?php

use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard',[DashboardController::Class, 'getDashboard'])->name('dashboard');
    Route::post('/cart/{id}', [CartController::class, 'storeCart'])->name('storeCart');
    Route::post('/order', [OrderController::class, 'storeOrder'])->name('storeOrder');
    Route::patch('/cart/{id}', [CartController::class, 'updateCart'])->name('updateCart');
    Route::delete('/cart/{id}', [CartController::class, 'deleteCart'])->name('deleteCart');
    Route::get('/invoice/{token}', [OrderController::class, 'getInvoice'])->name('invoice');
    Route::get('/download/{token}', [PdfController::class, 'generatePdf'])->name('download.invoice');
    Route::get('/', [DashboardController::class, 'fallback']);
});

Route::prefix('admin')->middleware(['auth', isAdmin::class])->group(function () {
    Route::get('/dashboard',[DashboardController::Class, 'getAdminDashboard'])->name('admin.dashboard');
    Route::post('/product', [ProductController::class, 'storeProduct'])->name('storeProduct');
    Route::patch('/product/{id}', [ProductController::class, 'editProduct'])->name('editProduct');
    Route::delete('/product/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
    Route::get('/unhide/{id}', [ProductController::class, 'unhideProduct'])->name('unhideProduct');
    Route::delete('/category', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
    Route::post('/category', [CategoryController::class, 'storeCategory'])->name('storeCategory');
    Route::get('{any}', [DashboardController::class, 'fallback'])->name('fallback');
});

require __DIR__.'/auth.php';
