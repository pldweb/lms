<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\Admin\ERaportController;

Route::middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'getIndex')->name('login');
        Route::get('/user/login', 'getIndex');
        Route::post('/login', 'postLoginAction');
    });
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'getIndex');
        Route::get('/daftar', 'getIndex');
        Route::get('/user/daftar', 'getIndex');
    });
});

// E-Raport Routes
Route::prefix('admin/e-raport')->controller(ERaportController::class)->group(function () {
    Route::get('/', 'getIndex');
    Route::get('/preview/{siswa_id}', 'getPreview');
    Route::get('/download/{siswa_id}', 'downloadPDF');
    Route::get('/download-class', 'downloadClassPDF');
    Route::get('/kelas-stats', 'getKelasStats');
});