<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::resource('/category', CategoryController::class);
Route::resource('/product', ProductController::class);
Route::resource('/discount', DiscountController::class);

// });
