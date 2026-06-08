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

// Subbab
use App\Http\Controllers\Api\SubabController;
Route::get('subbab', [SubabController::class, 'index']);
Route::post('subbab', [SubabController::class, 'store']);
Route::get('subbab/{id}', [SubabController::class, 'show']);
Route::put('subbab/{id}', [SubabController::class, 'update']);
Route::delete('subbab/{id}', [SubabController::class, 'destroy']);

// Materi
use App\Http\Controllers\Api\MateriController;
Route::get('materi', [MateriController::class, 'index']);
Route::post('materi', [MateriController::class, 'store']);
Route::get('materi/{id}', [MateriController::class, 'show']);
Route::put('materi/{id}', [MateriController::class, 'update']);
Route::delete('materi/{id}', [MateriController::class, 'destroy']);

// Quiz & Soal
use App\Http\Controllers\Api\QuizController;
Route::get('quiz', [QuizController::class, 'index']);
Route::post('quiz', [QuizController::class, 'store']);
Route::get('quiz/{id}', [QuizController::class, 'show']);
Route::delete('quiz/{id}', [QuizController::class, 'destroy']);
Route::get('quiz/{id}/soal', [QuizController::class, 'soal']);
Route::post('quiz/{id}/soal', [QuizController::class, 'storeSoal']);

// Simulasi & Soal
use App\Http\Controllers\Api\SimulasiController;
Route::get('simulasi', [SimulasiController::class, 'index']);
Route::post('simulasi', [SimulasiController::class, 'store']);
Route::get('simulasi/{id}', [SimulasiController::class, 'show']);
Route::delete('simulasi/{id}', [SimulasiController::class, 'destroy']);
Route::get('simulasi/{id}/soal', [SimulasiController::class, 'soal']);
Route::post('simulasi/{id}/soal', [SimulasiController::class, 'storeSoal']);

// Flashcard
use App\Http\Controllers\Api\FlashcardController;
Route::get('flashcard', [FlashcardController::class, 'index']);
Route::post('flashcard', [FlashcardController::class, 'store']);
Route::get('flashcard/{id}', [FlashcardController::class, 'show']);
Route::put('flashcard/{id}', [FlashcardController::class, 'update']);
Route::delete('flashcard/{id}', [FlashcardController::class, 'destroy']);
