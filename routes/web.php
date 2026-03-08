<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\BabController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});


// BAGIAN ADMIN
// Dashboard admin
Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

// Admin CRUD User
Route::resource('/users', UserController::class);
// Admin CRUD Buku
Route::resource('/books', BukuController::class);
// Admin CRUD Bab
Route::prefix('bab')->group(function () {
    // get semua bab untuk buku tertentu
    Route::get('/{id_buku}', [BabController::class, 'index'])->name('bab.index');
    // get form tambah bab untuk buku tertentu
    Route::post('/store', [BabController::class, 'store'])->name('bab.store');
    // get form edit bab untuk buku tertentu
    Route::get('/edit/{id}', [BabController::class, 'edit'])->name('bab.edit');
    // update bab untuk buku tertentu
    Route::put('/update/{id}', [BabController::class, 'update'])->name('bab.update');
    // delete bab untuk buku tertentu
    Route::delete('/delete/{id}', [BabController::class, 'destroy'])->name('bab.delete');
});



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