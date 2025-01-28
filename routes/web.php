<?php

use App\Http\Controllers\DetailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsAdmin;

// Auth Routes
Auth::routes();

// Route untuk Guest (Pengunjung) - Belum Login
Route::middleware('guest')->group(function () {
    Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::get('/detail/{category_slug}/{product_slug}', [DetailController::class, 'show'])->name('detail');
});

// Route untuk User yang Sudah Login
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// Route untuk Admin dengan Middleware
Route::prefix('admin')->middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('backend.dashboard'); // Pastikan file ini ada di resources/views/backend/dashboard.blade.php
    })->name('admin.dashboard');

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
});