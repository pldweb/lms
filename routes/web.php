<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\admin\FileManagerController;

Route::middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        // Route::get('/login', 'getIndex')->name('login');
        Route::get('/user/login', 'getIndex');
        Route::post('/login', 'postLoginAction');
    });
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'getIndex');
        Route::get('/daftar', 'getIndex');
        Route::get('/user/daftar', 'getIndex');
    });
});

// File Manager Routes (with auth middleware)
Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
    Route::controller(FileManagerController::class)->prefix('file-manager')->group(function () {
        Route::get('/', 'index');
        Route::post('/upload', 'upload');
        Route::post('/create-folder', 'createFolder');
        Route::delete('/delete', 'delete');
    });
});