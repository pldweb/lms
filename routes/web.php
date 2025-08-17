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
use App\Http\Controllers\admin\SlideshowController;
use App\Http\Controllers\admin\KontakController;

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

// Admin Tugas Routes
Route::prefix('admin/tugas')->controller(AdminTugasController::class)->group(function () {
    Route::get('/', 'getIndex');
    Route::get('/create', 'getCreate');
    Route::post('/store', 'postStore');
    Route::get('/show/{id}', 'getShow');
    Route::get('/edit/{id}', 'getEdit');
    Route::post('/update/{id}', 'postUpdate');
    Route::get('/delete/{id}', 'getDelete');
    Route::get('/nilai/{id}', 'getNilai');
    Route::post('/nilai/{id}', 'postNilai');
    Route::get('/export/csv', 'exportCSV');
    Route::get('/export/json', 'exportJSON');
});

// Guru Tugas Routes
Route::prefix('guru/tugas')->controller(GuruTugasController::class)->group(function () {
    Route::get('/', 'getIndex');
    Route::get('/create', 'getCreate');
    Route::post('/store', 'postStore');
    Route::get('/show/{id}', 'getShow');
    Route::get('/edit/{id}', 'getEdit');
    Route::post('/update/{id}', 'postUpdate');
    Route::get('/delete/{id}', 'getDelete');
    Route::get('/nilai/{id}', 'getNilai');
    Route::post('/nilai/{id}', 'postNilai');
    Route::get('/export/csv', 'exportCSV');
    Route::get('/export/json', 'exportJSON');
});

// Siswa Tugas Routes
Route::prefix('siswa/tugas')->controller(SiswaTugasController::class)->group(function () {
    Route::get('/', 'getIndex');
    Route::get('/show/{id}', 'getShow');
    Route::get('/submit/{id}', 'getSubmit');
    Route::post('/submit/{id}', 'postSubmit');
    Route::get('/export/csv', 'exportCSV');
    Route::get('/export/json', 'exportJSON');
});

// Guru Nilai Routes
Route::prefix('guru/nilai')->controller(GuruNilaiController::class)->group(function () {
    Route::get('/', 'getIndex');
    Route::get('/show/{id}', 'getShow');
    Route::get('/edit/{id}', 'getEdit');
    Route::post('/update/{id}', 'postUpdate');
    Route::get('/export/csv', 'exportCSV');
    Route::get('/export/json', 'exportJSON');
});

// Siswa Nilai Routes
Route::prefix('siswa/nilai')->controller(SiswaNilaiController::class)->group(function () {
    Route::get('/', 'getIndex');
    Route::get('/show/{id}', 'getShow');
    Route::get('/export/csv', 'exportCSV');
    Route::get('/export/json', 'exportJSON');
});

// Admin Slideshow Routes
Route::prefix('admin/slideshow')->controller(SlideshowController::class)->group(function () {
    Route::get('/', 'getIndex');
    Route::get('/create', 'getCreate');
    Route::post('/store', 'postStore');
    Route::get('/edit/{id}', 'getEdit');
    Route::post('/update/{id}', 'postUpdate');
    Route::get('/delete/{id}', 'getDelete');
    Route::post('/ajax-delete', 'postAjaxDelete');
});

// Admin Kontak Routes
Route::prefix('admin/kontak')->controller(KontakController::class)->group(function () {
    Route::get('/', 'getIndex');
    Route::get('/create', 'getCreate');
    Route::post('/store', 'postStore');
    Route::get('/edit/{id}', 'getEdit');
    Route::get('/delete/{id}', 'postDeleteAction');
});