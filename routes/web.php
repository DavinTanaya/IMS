<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard',[DashboardController::Class, 'getDashboard'])->name('dashboard');
    Route::post('/category', [CategoryController::class, 'storeCategory'])->name('storeCategory');
    Route::post('/product', [ProductController::class, 'storeProduct'])->name('storeProduct');
    Route::patch('/product/{id}', [ProductController::class, 'editProduct'])->name('editProduct');
    Route::delete('/product/{id}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
});

require __DIR__.'/auth.php';
