<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Dashboard (index)
Route::get('/dashboard', [UserController::class, 'index']);

// CRUD Routes
Route::resource('/users', UserController::class);