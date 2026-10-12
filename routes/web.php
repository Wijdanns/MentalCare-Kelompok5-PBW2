<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureRole;
use App\Http\Controllers\TesController;

Route::view('/', 'home')->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/tes-psikologi', [TesController::class, 'index'])->name('tes.index');

// Area pasien (wajib login)
Route::middleware(['auth', EnsureRole::class . ':pasien'])->group(function () {
    Route::view('/dashboard', 'pasien.dashboard')->name('pasien.dashboard');

    Route::prefix('tes-psikologi')->name('tes.')->group(function () {
        // riwayat & hasil harus di atas /{tes}, kalau tidak "riwayat" dianggap ID tes
        Route::get('/riwayat', [TesController::class, 'riwayat'])->name('riwayat');
        Route::get('/hasil/{hasil}', [TesController::class, 'hasil'])->name('hasil');
        Route::get('/{tes}', [TesController::class, 'show'])->name('show');
        Route::post('/{tes}', [TesController::class, 'submit'])->name('submit');
    });
});

// Route tambahan dari development (temanmu)
Route::get('/konsultasi', function () {
    return view('konsultasi');
});