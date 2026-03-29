<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\BabController;
use App\Http\Controllers\Admin\SubabController;
use App\Http\Controllers\Admin\MateriController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});


// BAGIAN ADMIN
// Dashboard admin
Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

// Admin CRUD User
Route::resource('/dashboard-user', UserController::class);
// Admin CRUD Buku
Route::resource('/dashboard-buku', BukuController::class);
// Admin CRUD Bab
Route::resource('bab', BabController::class)->except(['show']);
// Admin CRUD Subbab
Route::resource('subab', SubabController::class)->except(['show','index']);
// Admin CRUD Materi
Route::get('/materi/subab/{id}', [MateriController::class,'getMateri']);
Route::resource('materi', MateriController::class)->except(['show','index']);


// Auth routes (Breeze)
require __DIR__.'/auth.php';

// User routes (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/user/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Alias agar navigation.blade.php tidak error
    Route::get('/profile/edit', function () {
        return redirect()->route('user.profile');
    })->name('profile.edit');

     Route::post('/user/profile/update', function(\Illuminate\Http\Request $request) {
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . auth()->id(),
        'kelas' => 'required|in:10,11,12',
        'foto'  => 'nullable|image|max:2048',
    ]);

    $data = $request->only('name', 'email', 'kelas');

    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('foto-profil', 'public');
        $data['foto'] = $path;
    }

        auth()->user()->update($data);
        return response()->json(['success' => true, 'foto' => auth()->user()->foto]);
    })->name('profile.update.ajax');
});