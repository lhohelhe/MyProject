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