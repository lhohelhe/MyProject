<?php

// Kateori Mapel
use App\Models\KategoriMapel;
Route::get('/kategori', function () {return KategoriMapel::all();});

// Buku
use App\Http\Controllers\Api\BukuController;
Route::get('buku', [BukuController::class, 'index']);
Route::post('buku', [BukuController::class, 'store']);
Route::get('buku/{id}', [BukuController::class, 'show']);
Route::put('buku/{id}', [BukuController::class, 'update']);
Route::delete('buku/{id}', [BukuController::class, 'destroy']);

// Bab
use App\Http\Controllers\Api\BabController;
Route::get('bab', [BabController::class, 'index']);
Route::post('bab', [BabController::class, 'store']);
Route::get('bab/{id}', [BabController::class, 'show']);
Route::put('bab/{id}', [BabController::class, 'update']);
Route::delete('bab/{id}', [BabController::class, 'destroy']);

// Subab
use App\Http\Controllers\Api\SubabController;
Route::get('subab', [SubabController::class, 'index']);
Route::post('subab', [SubabController::class, 'store']);
Route::get('subab/{id}', [SubabController::class, 'show']);
Route::put('subab/{id}', [SubabController::class, 'update']);
Route::delete('subab/{id}', [SubabController::class, 'destroy']);

// Materi
use App\Http\Controllers\Api\MateriController;
Route::get('materi', [MateriController::class, 'index']);
Route::post('materi', [MateriController::class, 'store']);
Route::get('materi/{id}', [MateriController::class, 'show']);
Route::put('materi/{id}', [MateriController::class, 'update']);
Route::delete('materi/{id}', [MateriController::class, 'destroy']);