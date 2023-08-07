<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\TupoksiController;
use App\Http\Controllers\Admin\Pengaduan\MasukController;
use App\Http\Controllers\Admin\Pengaduan\SelesaiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'home']);

Route::get('about', [WebController::class, 'about']);

Route::get('tupoksi', [WebController::class, 'tupoksi']);

Route::get('bandwith', [WebController::class, 'bandwith']);
Route::get('sistem', [WebController::class, 'sistem']);
Route::get('sop', [WebController::class, 'sop']);

Route::get('kontak', [WebController::class, 'kontak']);

Route::get('hubungi/{id}', [WebController::class, 'hubungi']);

Route::get('pengaduan', [WebController::class, 'pengaduan']);
Route::post('pengaduan/create', [WebController::class, 'pengaduan_create']);


Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'proses_register']);

Route::get('login', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'proses_login']);

Route::post('logout', [AuthController::class, 'logout']);

Route::get('check-user', [AuthController::class, 'check_user']);

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [HomeController::class, 'index']);

    Route::get('unit', [UnitController::class, 'index']);
    Route::post('unit/update', [UnitController::class, 'update']);

    Route::resource('anggota', AnggotaController::class);

    Route::resource('visimisi', VisiMisiController::class);

    Route::resource('tupoksi', TupoksiController::class);

    Route::get('pengaduan-masuk/konfirmasi_proses/{id}', [MasukController::class, 'konfirmasi_proses']);
    Route::get('pengaduan-masuk/konfirmasi_selesai/{id}', [MasukController::class, 'konfirmasi_selesai']);
    Route::get('pengaduan-masuk/hubungi/{id}', [MasukController::class, 'hubungi']);
    Route::post('pengaduan-masuk/catatan/{id}', [MasukController::class, 'catatan']);
    Route::resource('pengaduan-masuk', MasukController::class);

    Route::resource('pengaduan-selesai', SelesaiController::class);

    Route::get('hosting/{id}/setujui', [\App\Http\Controllers\Admin\HostingController::class, 'setujui']);
    Route::resource('hosting', \App\Http\Controllers\Admin\HostingController::class)->only(['index', 'show']);
});

Route::middleware('tamu')->prefix('tamu')->group(function () {
    Route::get('/', [\App\Http\Controllers\Tamu\HomeController::class, 'index']);

    Route::get('hosting/download/{id}', [\App\Http\Controllers\Tamu\HostingController::class, 'download']);
    Route::resource('hosting', \App\Http\Controllers\Tamu\HostingController::class);

    Route::post('unit/update', [UnitController::class, 'update']);

    Route::resource('anggota', AnggotaController::class);

    Route::resource('visimisi', VisiMisiController::class);

    Route::resource('tupoksi', TupoksiController::class);

    Route::get('pengaduan-masuk/konfirmasi_proses/{id}', [MasukController::class, 'konfirmasi_proses']);
    Route::get('pengaduan-masuk/konfirmasi_selesai/{id}', [MasukController::class, 'konfirmasi_selesai']);
    Route::get('pengaduan-masuk/hubungi/{id}', [MasukController::class, 'hubungi']);
    Route::post('pengaduan-masuk/catatan/{id}', [MasukController::class, 'catatan']);
    Route::resource('pengaduan-masuk', MasukController::class);

    Route::resource('pengaduan-selesai', SelesaiController::class);
});
