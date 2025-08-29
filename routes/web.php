<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\Admin\ERaportController;
use App\Http\Controllers\Admin\TugasController as AdminTugasController;
use App\Http\Controllers\Guru\TugasController as GuruTugasController;
use App\Http\Controllers\Siswa\TugasController as SiswaTugasController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Siswa\NilaiController as SiswaNilaiController;
use Telegram\Bot\Api;

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