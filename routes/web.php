<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::resource('/category', CategoryController::class);
// });
