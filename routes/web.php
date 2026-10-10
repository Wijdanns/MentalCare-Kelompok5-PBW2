<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureRole;

Route::view('/', 'home')->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Area pasien
Route::middleware(['auth', EnsureRole::class . ':pasien'])->group(function () {
    Route::view('/dashboard', 'pasien.dashboard')->name('pasien.dashboard');
});

// Route tambahan dari development (temanmu)
Route::get('/konsultasi', function () {
    return view('konsultasi');
});