<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\BabController;
use App\Http\Controllers\Admin\SubabController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Admin\SimulasiController;
use App\Http\Controllers\Admin\SoalSimulasiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\User\KatalogController;
use App\Http\Controllers\User\SimulasiController as UserSimulasiController;
use App\Http\Controllers\User\QuizController as UserQuizController;
use App\Http\Controllers\User\FlashcardController as UserFlashcardController;
use App\Http\Controllers\ProfileController;

// Halaman landing page — tidak perlu login
Route::get('/', function () {
    return view('welcome');
});

// ROUTE ADMIN — harus sudah login
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Dashboard ringkasan admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Kelola user
    Route::resource('/dashboard-user', UserController::class);

    // Kelola buku
    Route::resource('/dashboard-buku', BukuController::class);

    // Kelola bab
    Route::resource('/bab', BabController::class)->except(['show']);

    // Kelola subbab
    Route::resource('/subab', SubabController::class)->except(['show', 'index']);

    // Kelola materi
    Route::get('/materi/subab/{id}', [MateriController::class, 'getMateri']);
    Route::resource('/materi', MateriController::class)->except(['show', 'index']);

    // Kelola simulasi
    Route::resource('/simulasi', SimulasiController::class);
    Route::get('/simulasi/{id}/soal', [SoalSimulasiController::class, 'index'])->name('soal-simulasi.index');
    Route::post('/simulasi/{id}/soal', [SoalSimulasiController::class, 'store'])->name('soal-simulasi.store');
    Route::put('/simulasi/soal/{id}', [SoalSimulasiController::class, 'update'])->name('soal-simulasi.update');
    Route::delete('/simulasi/soal/{id}', [SoalSimulasiController::class, 'destroy'])->name('soal-simulasi.destroy');
});

// ROUTE USER BIASA — harus sudah login
Route::middleware(['auth'])->prefix('user')->group(function () {

    // Halaman profil user
    Route::get('/profile', function () {
        return view('user.profile');
    })->name('user.profile');

    // Dashboard user biasa (redirect ke profile)
    Route::get('/dashboard', function () {
        return redirect()->route('user.profile');
    });

    // Update profil
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Katalog buku
    Route::get('/katalog', [KatalogController::class, 'index'])->name('user.katalog');

    // Detail buku
    Route::get('/buku/{id}', [App\Http\Controllers\User\BukuController::class, 'show'])->name('user.buku.show');

    // SIMULASI UJIAN (Perbaikan urutan: Submit & Result dulu sebelum {id})
    Route::get('/simulasi', [UserSimulasiController::class, 'index'])->name('user.simulasi.index');
    Route::post('/simulasi/submit', [UserSimulasiController::class, 'submit'])->name('user.simulasi.submit');
    Route::get('/simulasi/result/{id}', [UserSimulasiController::class, 'result'])->name('user.simulasi.result');
    Route::get('/simulasi/{id}', [UserSimulasiController::class, 'show'])->name('user.simulasi.show');
    Route::post('/simulasi/{id}/start', [UserSimulasiController::class, 'start'])->name('user.simulasi.start');

    // QUIZ HARIAN ADAPTIF (Perbaikan urutan: Submit & Result dulu sebelum {id})
    Route::get('/quiz/bab/{id_bab}', [UserQuizController::class, 'index'])->name('user.quiz.index');
    Route::post('/quiz/submit', [UserQuizController::class, 'submit'])->name('user.quiz.submit');
    Route::get('/quiz/result/{id}', [UserQuizController::class, 'result'])->name('user.quiz.result');
    Route::get('/quiz/{id}/start', [UserQuizController::class, 'start'])->name('user.quiz.start');

    // FLASHCARD
    Route::get('/flashcard/{id_subbab}', [UserFlashcardController::class, 'index'])->name('user.flashcard');
    Route::post('/flashcard/{id}/done', [UserFlashcardController::class, 'markDone'])->name('user.flashcard.done');
    Route::post('/flashcard/{id_subbab}/reset', [UserFlashcardController::class, 'reset'])->name('user.flashcard.reset');
});

// Auth routes (login, register, logout) — dari Laravel Breeze
require __DIR__.'/auth.php';
