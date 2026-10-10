<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman Utama / Home
Route::get('/', function () {
    return view('home');
});

// Route untuk Tamu (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route setelah Login (Auth & Fitur Tambahan)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route tambahan dari development (temanmu)
Route::get('/konsultasi', function () {
    return view('konsultasi');
});