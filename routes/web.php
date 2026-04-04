<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\BabController;
use App\Http\Controllers\Admin\SubabController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\ProfileController;

// halaman landing page — tidak perlu login
Route::get('/', function () {
    return view('welcome');
});

// ─────────────────────────────────────────
// ROUTE ADMIN — harus sudah login
// ─────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // dashboard ringkasan admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // kelola user
    Route::resource('/dashboard-user', UserController::class);

    // kelola buku
    Route::resource('/dashboard-buku', BukuController::class);

    // kelola bab
    Route::resource('/bab', BabController::class)->except(['show']);

    // kelola subbab
    Route::resource('/subab', SubabController::class)->except(['show', 'index']);

    // kelola materi
    Route::get('/materi/subab/{id}', [MateriController::class, 'getMateri']);
    Route::resource('/materi', MateriController::class)->except(['show', 'index']);
});

// ─────────────────────────────────────────
// ROUTE USER BIASA — harus sudah login
// ─────────────────────────────────────────
Route::middleware(['auth'])->prefix('user')->group(function () {

    // dashboard user biasa
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // halaman profil user
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    // update profil
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// auth routes (login, register, logout) — dari breeze
require __DIR__.'/auth.php';

