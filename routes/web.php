<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\AnggotaController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\TupoksiController;
use App\Http\Controllers\Admin\Pengaduan\MasukController;
use App\Http\Controllers\Admin\Pengaduan\SelesaiController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeminjamanCbtController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\WebController::class, 'home']);

Route::get('about', [App\Http\Controllers\WebController::class, 'about']);

Route::get('tupoksi', [App\Http\Controllers\WebController::class, 'tupoksi']);
Route::get('bandwith', [App\Http\Controllers\WebController::class, 'bandwith']);
Route::get('sistem', [App\Http\Controllers\WebController::class, 'sistem']);
Route::get('sop', [App\Http\Controllers\WebController::class, 'sop']);

Route::get('kuesioner', [App\Http\Controllers\WebController::class, 'kuesioner']);

Route::get('kontak', [App\Http\Controllers\WebController::class, 'kontak']);
Route::get('hubungi/{telp}', [App\Http\Controllers\WebController::class, 'hubungi']);

Route::get('peminjaman-cbt/pembelajaran', [\App\Http\Controllers\PeminjamanCbtController::class, 'create_pembelajaran']);
Route::get('peminjaman-cbt/lainnya', [\App\Http\Controllers\PeminjamanCbtController::class, 'create_lainnya']);
Route::post('peminjaman-cbt/pembelajaran', [\App\Http\Controllers\PeminjamanCbtController::class, 'store_pembelajaran']);
Route::post('peminjaman-cbt/lainnya', [\App\Http\Controllers\PeminjamanCbtController::class, 'store_lainnya']);
Route::get('peminjaman-cbt/bukti/{kode}', [\App\Http\Controllers\PeminjamanCbtController::class, 'bukti']);
Route::resource('peminjaman-cbt', PeminjamanCbtController::class)->except('edit', 'delete');

Route::get('pengaduan', [App\Http\Controllers\WebController::class, 'pengaduan']);
Route::post('pengaduan/create', [App\Http\Controllers\WebController::class, 'pengaduan_create']);

Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'proses_register']);

Route::get('login', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'proses_login']);

Route::post('logout', [AuthController::class, 'logout']);

Route::get('check-user', [AuthController::class, 'check_user']);

Route::get('asset', [AssetController::class, 'index']);

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('hubungi/{telp}', [HomeController::class, 'hubungi']);

    Route::get('unit', [UnitController::class, 'index']);
    Route::post('unit/update', [UnitController::class, 'update']);

    Route::post('user/reset/{id}', [\App\Http\Controllers\Admin\UserController::class, 'reset']);
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class)->except('show');

    Route::resource('visi-misi', VisiMisiController::class);

    Route::resource('tupoksi', TupoksiController::class);

    Route::get('pengaduan-masuk/konfirmasi_proses/{id}', [MasukController::class, 'konfirmasi_proses']);
    Route::get('pengaduan-masuk/konfirmasi_selesai/{id}', [MasukController::class, 'konfirmasi_selesai']);
    Route::get('pengaduan-masuk/hubungi/{id}', [MasukController::class, 'hubungi']);
    Route::post('pengaduan-masuk/catatan/{id}', [MasukController::class, 'catatan']);
    Route::resource('pengaduan-masuk', MasukController::class);

    Route::resource('pengaduan-selesai', SelesaiController::class);

    Route::get('hosting/{id}/selesai', [\App\Http\Controllers\Admin\HostingController::class, 'selesai']);
    Route::resource('hosting', \App\Http\Controllers\Admin\HostingController::class)->only(['index', 'show']);

    Route::get('peminjaman-cbt/hubungi/{id}', [\App\Http\Controllers\Admin\PeminjamanCbtController::class, 'hubungi']);
    Route::post('peminjaman-cbt/ubah-waktu/{id}', [\App\Http\Controllers\Admin\PeminjamanCbtController::class, 'ubah_waktu']);
    Route::get('peminjaman-cbt/selesaikan/{id}', [\App\Http\Controllers\Admin\PeminjamanCbtController::class, 'selesaikan']);
    Route::get('peminjaman-cbt/riwayat', [\App\Http\Controllers\Admin\PeminjamanCbtController::class, 'riwayat']);
    Route::resource('peminjaman-cbt', \App\Http\Controllers\Admin\PeminjamanCbtController::class);

    Route::post('karyawan/import', [\App\Http\Controllers\Admin\KaryawanController::class, 'import']);
    Route::resource('karyawan', \App\Http\Controllers\Admin\KaryawanController::class);

    Route::resource('prodi', \App\Http\Controllers\Admin\ProdiController::class);

    Route::resource('spek-barang', \App\Http\Controllers\Admin\SpekBarangController::class)->except('create', 'show', 'edit');
    Route::resource('spek-storage', \App\Http\Controllers\Admin\SpekStorageController::class)->except('create', 'show', 'edit');
    Route::resource('spek-ram', \App\Http\Controllers\Admin\SpekRamController::class)->except('create', 'show', 'edit');

    Route::resource('perangkat', \App\Http\Controllers\Admin\PerangkatController::class);
});

Route::middleware('user')->prefix('user')->group(function () {
    Route::get('/', [\App\Http\Controllers\User\HomeController::class, 'index']);
    Route::resource('kegiatan', \App\Http\Controllers\User\KegiatanController::class);
});

Route::middleware('tamu')->prefix('tamu')->group(function () {
    Route::get('/', [\App\Http\Controllers\Tamu\HomeController::class, 'index']);

    Route::get('hosting/download/{id}', [\App\Http\Controllers\Tamu\HostingController::class, 'download']);
    Route::resource('hosting', \App\Http\Controllers\Tamu\HostingController::class);

    Route::post('unit/update', [UnitController::class, 'update']);

    // Route::resource('anggota', AnggotaController::class);

    Route::resource('visimisi', VisiMisiController::class);

    Route::resource('tupoksi', TupoksiController::class);

    Route::get('pengaduan-masuk/konfirmasi_proses/{id}', [MasukController::class, 'konfirmasi_proses']);
    Route::get('pengaduan-masuk/konfirmasi_selesai/{id}', [MasukController::class, 'konfirmasi_selesai']);
    Route::get('pengaduan-masuk/hubungi/{id}', [MasukController::class, 'hubungi']);
    Route::post('pengaduan-masuk/catatan/{id}', [MasukController::class, 'catatan']);
    Route::resource('pengaduan-masuk', MasukController::class);

    Route::resource('pengaduan-selesai', SelesaiController::class);
});
