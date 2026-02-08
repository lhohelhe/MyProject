<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Landing page
Route::get('/', function () { return view('welcome');});
// Dashboard_User (index)
Route::get('/dashboard', function () { return view('user.dashboard');
    })->middleware('auth')->name('dashboard');
// CRUD Routes
Route::resource('/users', UserController::class);
require __DIR__.'/auth.php';