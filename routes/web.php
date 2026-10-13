<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PsikologController;
use App\Http\Controllers\TesController;
use App\Http\Middleware\EnsureRole;
use App\Http\Controllers\ArtikelController;
use Illuminate\Support\Facades\Route;

// ---------- Publik ----------
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/psikolog', [PsikologController::class, 'index'])->name('psikolog.index');
Route::get('/psikolog/{psikolog}', [PsikologController::class, 'show'])->name('psikolog.show');

Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{artikel}', [ArtikelController::class, 'show'])->name('artikel.show');

// Foto psikolog dilayani dari storage/app/public/psikolog (tanpa storage:link)
Route::get('/foto-psikolog/psikolog/{file}', function (string $file) {
    $path = storage_path('app/public/psikolog/' . basename($file));

    abort_unless(is_file($path), 404);

    return response()->file($path);
})->name('foto-psikolog');

Route::get('/tes-psikologi', [TesController::class, 'index'])->name('tes.index');

// Route tambahan dari development (temanmu), sementara sampai controller konsultasi dibuat
Route::get('/konsultasi', function () {
    return view('konsultasi');
})->name('konsultasi.index');

// ---------- Area pasien (wajib login) ----------
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