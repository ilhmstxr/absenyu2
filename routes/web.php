<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\DataKelasController;
use App\Http\Controllers\AbsenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});
//guest
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
    // Route::get('/absen', function () {
    //     return view('absen');
    // });
});


//admin
Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('absen', SiswaController::class);
    Route::resource('datasiswa', DataController::class);
    Route::get('datasiswa/{id_siswa}/hapus', [DataController::class, 'hapus'])->name('datasiswa.hapus');
    Route::resource('datakelas', DataKelasController::class);
    Route::get('datakelas/{id}/hapus', [DataKelasController::class, 'hapus'])->name('datakelas.hapus');
    Route::resource('guru', GuruController::class);
    Route::get('guru/{id_guru}/hapus', [GuruController::class, 'hapus'])->name('guru.hapus');
    Route::resource('listkelas', KelasController::class);
    Route::resource('rekapdata', AbsenController::class);
    

    Route::post('logout', [LoginController::class, 'logout']);
});
