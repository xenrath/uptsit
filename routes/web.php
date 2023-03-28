<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\PengaduanController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\TupoksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'home']);
Route::get('about', [WebController::class, 'about']);
Route::get('tupoksi', [WebController::class, 'tupoksi']);
Route::get('kontak', [WebController::class, 'kontak']);
Route::get('hubungi/{id}', [WebController::class, 'hubungi']);
Route::get('pengaduan', [WebController::class, 'pengaduan']);
Route::post('pengaduan/create', [WebController::class, 'pengaduan_create']);

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login']);
    Route::post('login_proses', [AuthController::class, 'login_proses']);
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    
    Route::get('unit', [UnitController::class, 'index']);
    Route::post('unit/update', [UnitController::class, 'update']);

    Route::resource('anggota', AnggotaController::class);
    Route::resource('visimisi', VisiMisiController::class);
    Route::resource('tupoksi', TupoksiController::class);
    Route::resource('pengaduan', PengaduanController::class);
});
