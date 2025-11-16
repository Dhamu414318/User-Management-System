<?php

use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\AdminUserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Public auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth.front')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Admin pages
    Route::middleware('admin.front')->prefix('admin')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::post('/users/{id}/delete', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/users/search', [AdminUserController::class, 'search'])->name('admin.users.search');
    });
});
