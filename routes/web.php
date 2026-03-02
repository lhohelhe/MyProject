<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard admin
Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

// Admin CRUD
Route::resource('/users', UserController::class);

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