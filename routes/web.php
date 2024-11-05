<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\TupoksiController;
use App\Http\Controllers\Admin\Pengaduan\MasukController;
use App\Http\Controllers\Admin\Pengaduan\SelesaiController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeminjamanCbtController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Artisan
Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    return redirect('/');
});

Route::get('/migrate-fresh', function () {
    Artisan::call('migrate:fresh --seed');
    return redirect('/');
});

Route::any('adminer', '\Aranyasen\LaravelAdminer\AdminerController@index');

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

    Route::get('identitas', [\App\Http\Controllers\Admin\IdentitasController::class, 'index']);
    Route::post('identitas/update', [\App\Http\Controllers\Admin\IdentitasController::class, 'update']);

    Route::post('anggota/reset/{id}', [\App\Http\Controllers\Admin\AnggotaController::class, 'reset']);
    Route::resource('anggota', \App\Http\Controllers\Admin\AnggotaController::class)->except('show');

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

    Route::resource('prodi', \App\Http\Controllers\Admin\ProdiController::class);

    Route::resource('unit', \App\Http\Controllers\Admin\UnitController::class)->except('create', 'show', 'edit');

    Route::resource('bagian', \App\Http\Controllers\Admin\BagianController::class)->except('create', 'show', 'edit');

    // Route::post('karyawan/import', [\App\Http\Controllers\Admin\KaryawanController::class, 'import']);
    Route::resource('karyawan', \App\Http\Controllers\Admin\KaryawanController::class)->except('create', 'edit', 'show');

    Route::resource('spesifikasi', \App\Http\Controllers\Admin\SpesifikasiController::class)->except('create', 'show', 'edit');

    Route::get('sparepart/motherboard', [\App\Http\Controllers\Admin\SparepartController::class, 'create_motherboard']);
    Route::post('sparepart/motherboard', [\App\Http\Controllers\Admin\SparepartController::class, 'store_motherboard']);
    Route::get('sparepart/motherboard/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'edit_motherboard']);
    Route::post('sparepart/motherboard/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'update_motherboard']);

    Route::get('sparepart/prosesor', [\App\Http\Controllers\Admin\SparepartController::class, 'create_prosesor']);
    Route::post('sparepart/prosesor', [\App\Http\Controllers\Admin\SparepartController::class, 'store_prosesor']);
    Route::get('sparepart/prosesor/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'edit_prosesor']);
    Route::post('sparepart/prosesor/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'update_prosesor']);

    Route::get('sparepart/ram', [\App\Http\Controllers\Admin\SparepartController::class, 'create_ram']);
    Route::post('sparepart/ram', [\App\Http\Controllers\Admin\SparepartController::class, 'store_ram']);
    Route::get('sparepart/ram/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'edit_ram']);
    Route::post('sparepart/ram/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'update_ram']);

    Route::get('sparepart/storage', [\App\Http\Controllers\Admin\SparepartController::class, 'create_storage']);
    Route::post('sparepart/storage', [\App\Http\Controllers\Admin\SparepartController::class, 'store_storage']);
    Route::get('sparepart/storage/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'edit_storage']);
    Route::post('sparepart/storage/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'update_storage']);

    Route::get('sparepart/psu', [\App\Http\Controllers\Admin\SparepartController::class, 'create_psu']);
    Route::post('sparepart/psu', [\App\Http\Controllers\Admin\SparepartController::class, 'store_psu']);
    Route::get('sparepart/psu/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'edit_psu']);
    Route::post('sparepart/psu/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'update_psu']);

    Route::get('sparepart/heatsink', [\App\Http\Controllers\Admin\SparepartController::class, 'create_heatsink']);
    Route::post('sparepart/heatsink', [\App\Http\Controllers\Admin\SparepartController::class, 'store_heatsink']);
    Route::get('sparepart/heatsink/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'edit_heatsink']);
    Route::post('sparepart/heatsink/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'update_heatsink']);

    Route::get('sparepart/monitor', [\App\Http\Controllers\Admin\SparepartController::class, 'create_monitor']);
    Route::post('sparepart/monitor', [\App\Http\Controllers\Admin\SparepartController::class, 'store_monitor']);
    Route::get('sparepart/monitor/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'edit_monitor']);
    Route::post('sparepart/monitor/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'update_monitor']);

    Route::get('sparepart/keyboard', [\App\Http\Controllers\Admin\SparepartController::class, 'create_keyboard']);
    Route::post('sparepart/keyboard', [\App\Http\Controllers\Admin\SparepartController::class, 'store_keyboard']);
    Route::get('sparepart/keyboard/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'edit_keyboard']);
    Route::post('sparepart/keyboard/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'update_keyboard']);

    Route::get('sparepart/mouse', [\App\Http\Controllers\Admin\SparepartController::class, 'create_mouse']);
    Route::post('sparepart/mouse', [\App\Http\Controllers\Admin\SparepartController::class, 'store_mouse']);
    Route::get('sparepart/mouse/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'edit_mouse']);
    Route::post('sparepart/mouse/{id}', [\App\Http\Controllers\Admin\SparepartController::class, 'update_mouse']);

    Route::resource('sparepart', \App\Http\Controllers\Admin\SparepartController::class);

    Route::get('perangkat/karyawan-search', [\App\Http\Controllers\Admin\PerangkatController::class, 'karyawan_search']);
    Route::get('perangkat/karyawan-set/{id}', [\App\Http\Controllers\Admin\PerangkatController::class, 'karyawan_set']);
    Route::get('perangkat/scan', [\App\Http\Controllers\Admin\PerangkatController::class, 'scan']);
    Route::post('perangkat/scan', [\App\Http\Controllers\Admin\PerangkatController::class, 'scan_proses']);
    Route::post('perangkat/print/{id}', [\App\Http\Controllers\Admin\PerangkatController::class, 'print']);
    Route::resource('perangkat', \App\Http\Controllers\Admin\PerangkatController::class);

    Route::get('perbaikan/perangkat-search', [\App\Http\Controllers\Admin\PerbaikanController::class, 'perangkat_search']);
    Route::get('perbaikan/perangkat-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'perangkat_set']);
    Route::get('perbaikan/buat/{kode}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'buat']);
    Route::get('perbaikan/motherboard-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'motherboard_set']);
    Route::get('perbaikan/prosesor-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'prosesor_set']);
    Route::get('perbaikan/ram-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'ram_set']);
    Route::get('perbaikan/storage-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'storage_set']);
    Route::get('perbaikan/psu-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'psu_set']);
    Route::get('perbaikan/heatsink-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'heatsink_set']);
    Route::get('perbaikan/monitor-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'monitor_set']);
    Route::get('perbaikan/keyboard-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'keyboard_set']);
    Route::get('perbaikan/mouse-set/{id}', [\App\Http\Controllers\Admin\PerbaikanController::class, 'mouse_set']);
    Route::resource('perbaikan', \App\Http\Controllers\Admin\PerbaikanController::class);
});

Route::middleware('user')->prefix('user')->group(function () {
    Route::get('/', [\App\Http\Controllers\User\HomeController::class, 'index']);
    Route::resource('kegiatan', \App\Http\Controllers\User\KegiatanController::class);

    Route::middleware('support')->group(function () {
        Route::resource('spesifikasi', \App\Http\Controllers\User\SpesifikasiController::class)->except('create', 'show', 'edit');

        Route::get('sparepart/motherboard', [\App\Http\Controllers\User\SparepartController::class, 'create_motherboard']);
        Route::post('sparepart/motherboard', [\App\Http\Controllers\User\SparepartController::class, 'store_motherboard']);
        Route::get('sparepart/motherboard/{id}', [\App\Http\Controllers\User\SparepartController::class, 'edit_motherboard']);
        Route::post('sparepart/motherboard/{id}', [\App\Http\Controllers\User\SparepartController::class, 'update_motherboard']);
        // 
        Route::get('sparepart/prosesor', [\App\Http\Controllers\User\SparepartController::class, 'create_prosesor']);
        Route::post('sparepart/prosesor', [\App\Http\Controllers\User\SparepartController::class, 'store_prosesor']);
        Route::get('sparepart/prosesor/{id}', [\App\Http\Controllers\User\SparepartController::class, 'edit_prosesor']);
        Route::post('sparepart/prosesor/{id}', [\App\Http\Controllers\User\SparepartController::class, 'update_prosesor']);
        // 
        Route::get('sparepart/ram', [\App\Http\Controllers\User\SparepartController::class, 'create_ram']);
        Route::post('sparepart/ram', [\App\Http\Controllers\User\SparepartController::class, 'store_ram']);
        Route::get('sparepart/ram/{id}', [\App\Http\Controllers\User\SparepartController::class, 'edit_ram']);
        Route::post('sparepart/ram/{id}', [\App\Http\Controllers\User\SparepartController::class, 'update_ram']);
        // 
        Route::get('sparepart/storage', [\App\Http\Controllers\User\SparepartController::class, 'create_storage']);
        Route::post('sparepart/storage', [\App\Http\Controllers\User\SparepartController::class, 'store_storage']);
        Route::get('sparepart/storage/{id}', [\App\Http\Controllers\User\SparepartController::class, 'edit_storage']);
        Route::post('sparepart/storage/{id}', [\App\Http\Controllers\User\SparepartController::class, 'update_storage']);
        // 
        Route::get('sparepart/psu', [\App\Http\Controllers\User\SparepartController::class, 'create_psu']);
        Route::post('sparepart/psu', [\App\Http\Controllers\User\SparepartController::class, 'store_psu']);
        Route::get('sparepart/psu/{id}', [\App\Http\Controllers\User\SparepartController::class, 'edit_psu']);
        Route::post('sparepart/psu/{id}', [\App\Http\Controllers\User\SparepartController::class, 'update_psu']);
        // 
        Route::get('sparepart/heatsink', [\App\Http\Controllers\User\SparepartController::class, 'create_heatsink']);
        Route::post('sparepart/heatsink', [\App\Http\Controllers\User\SparepartController::class, 'store_heatsink']);
        Route::get('sparepart/heatsink/{id}', [\App\Http\Controllers\User\SparepartController::class, 'edit_heatsink']);
        Route::post('sparepart/heatsink/{id}', [\App\Http\Controllers\User\SparepartController::class, 'update_heatsink']);
        // 
        Route::get('sparepart/monitor', [\App\Http\Controllers\User\SparepartController::class, 'create_monitor']);
        Route::post('sparepart/monitor', [\App\Http\Controllers\User\SparepartController::class, 'store_monitor']);
        Route::get('sparepart/monitor/{id}', [\App\Http\Controllers\User\SparepartController::class, 'edit_monitor']);
        Route::post('sparepart/monitor/{id}', [\App\Http\Controllers\User\SparepartController::class, 'update_monitor']);
        // 
        Route::get('sparepart/keyboard', [\App\Http\Controllers\User\SparepartController::class, 'create_keyboard']);
        Route::post('sparepart/keyboard', [\App\Http\Controllers\User\SparepartController::class, 'store_keyboard']);
        Route::get('sparepart/keyboard/{id}', [\App\Http\Controllers\User\SparepartController::class, 'edit_keyboard']);
        Route::post('sparepart/keyboard/{id}', [\App\Http\Controllers\User\SparepartController::class, 'update_keyboard']);
        // 
        Route::get('sparepart/mouse', [\App\Http\Controllers\User\SparepartController::class, 'create_mouse']);
        Route::post('sparepart/mouse', [\App\Http\Controllers\User\SparepartController::class, 'store_mouse']);
        Route::get('sparepart/mouse/{id}', [\App\Http\Controllers\User\SparepartController::class, 'edit_mouse']);
        Route::post('sparepart/mouse/{id}', [\App\Http\Controllers\User\SparepartController::class, 'update_mouse']);
        // 
        Route::resource('sparepart', \App\Http\Controllers\User\SparepartController::class);

        Route::get('perangkat/karyawan-search', [\App\Http\Controllers\User\PerangkatController::class, 'karyawan_search']);
        Route::get('perangkat/karyawan-set/{id}', [\App\Http\Controllers\User\PerangkatController::class, 'karyawan_set']);
        Route::get('perangkat/scan', [\App\Http\Controllers\User\PerangkatController::class, 'scan']);
        Route::post('perangkat/scan', [\App\Http\Controllers\User\PerangkatController::class, 'scan_proses']);
        Route::post('perangkat/print/{id}', [\App\Http\Controllers\User\PerangkatController::class, 'print']);
        Route::resource('perangkat', \App\Http\Controllers\User\PerangkatController::class);

        Route::get('perbaikan/perangkat-search', [\App\Http\Controllers\User\PerbaikanController::class, 'perangkat_search']);
        Route::get('perbaikan/perangkat-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'perangkat_set']);
        Route::get('perbaikan/buat/{kode}', [\App\Http\Controllers\User\PerbaikanController::class, 'buat']);
        Route::get('perbaikan/motherboard-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'motherboard_set']);
        Route::get('perbaikan/prosesor-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'prosesor_set']);
        Route::get('perbaikan/ram-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'ram_set']);
        Route::get('perbaikan/storage-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'storage_set']);
        Route::get('perbaikan/psu-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'psu_set']);
        Route::get('perbaikan/heatsink-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'heatsink_set']);
        Route::get('perbaikan/monitor-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'monitor_set']);
        Route::get('perbaikan/keyboard-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'keyboard_set']);
        Route::get('perbaikan/mouse-set/{id}', [\App\Http\Controllers\User\PerbaikanController::class, 'mouse_set']);
        Route::resource('perbaikan', \App\Http\Controllers\User\PerbaikanController::class);
    });

    Route::middleware('cbt')->group(function () {
        Route::get('peminjaman-cbt/hubungi/{id}', [\App\Http\Controllers\User\PeminjamanCbtController::class, 'hubungi']);
        Route::post('peminjaman-cbt/ubah-waktu/{id}', [\App\Http\Controllers\User\PeminjamanCbtController::class, 'ubah_waktu']);
        Route::post('peminjaman-cbt/batalkan/{id}', [\App\Http\Controllers\User\PeminjamanCbtController::class, 'batalkan']);
        Route::get('peminjaman-cbt/selesaikan/{id}', [\App\Http\Controllers\User\PeminjamanCbtController::class, 'selesaikan']);
        Route::get('peminjaman-cbt/riwayat', [\App\Http\Controllers\User\PeminjamanCbtController::class, 'riwayat']);
        Route::resource('peminjaman-cbt', \App\Http\Controllers\User\PeminjamanCbtController::class);
    });
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
