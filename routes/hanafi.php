<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasarDesaController;
use App\Http\Controllers\IndividuController;
use App\Http\Controllers\UsahaController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KategoriKomoditasController;
use App\Http\Controllers\KomoditasController;
use App\Http\Controllers\SubKomoditasController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\InstansiPembinaController;
use App\Http\Controllers\PerizinanController;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\PendidikanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GisController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProfileController;

Route::group(['middleware' => ['auth']], function () 
{    
    // Route::get('/', DashboardController::class);

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('pasar-desa/export', [PasarDesaController::class, 'export'])->name('pasar-desa.export');

    Route::get('pasar-desa/getDataTables', [PasarDesaController::class, 'getDataTables'])->name('pasar-desa.getDataTables');

    Route::resource('pasar-desa', PasarDesaController::class);

    Route::get('gis', GisController::class)->name('gis.index');

    // Route::get('gis/loadmap', [GisController::class, 'loadmap'])->name('gis.loadmap');

    Route::resource('setting', SettingController::class);

    Route::post('profile/updateProfileInformation', [ProfileController::class, 'updateProfileInformation'])->name('profile.updateProfileInformation');

    Route::post('profile/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::resource('profile', ProfileController::class);
});

Route::group([
    'prefix'     => 'uem',
    'as'         => 'uem.',
    'middleware' => ['auth']], function () {

    Route::get('individu/ajax-search', [IndividuController::class, 'ajaxSearch'])->name('individu.ajax-search');

    Route::get('individu/getDataTables', [IndividuController::class, 'getDataTables'])->name('individu.getDataTables');

    Route::get('individu/export', [IndividuController::class, 'export'])->name('individu.export');
    
    Route::resource('individu', IndividuController::class);

    Route::get('usaha/getDataTables', [UsahaController::class, 'getDataTables'])->name('usaha.getDataTables');

    Route::get('usaha/export', [UsahaController::class, 'export'])->name('usaha.export');

    Route::resource('usaha', UsahaController::class);
});

Route::group([
    'prefix'     => 'master',
    'as'         => 'master.',
    'middleware' => ['auth']], function () {

    Route::get('kecamatan/getDataTables', [KecamatanController::class, 'getDataTables'])->name('kecamatan.getDataTables');

    Route::resource('kecamatan', KecamatanController::class);

    Route::get('desa/get-desa/{id}', [DesaController::class, 'getDesa'])->name('desa.get-desa');

    Route::get('desa/get-desa2/{id}', [DesaController::class, 'getDesa2'])->name('desa.get-desa2');

    Route::get('desa/get-desa3/{id}', [DesaController::class, 'getDesa3'])->name('desa.get-desa3');

    Route::get('desa/getDataTables', [DesaController::class, 'getDataTables'])->name('desa.getDataTables');

    Route::resource('desa', DesaController::class);

    Route::get('kategori-komoditas/getDataTables', [KategoriKomoditasController::class, 'getDataTables'])->name('kategori-komoditas.getDataTables');

    Route::resource('kategori-komoditas', KategoriKomoditasController::class);

    Route::get('komoditas/get-komoditas/{id}', [KomoditasController::class, 'getKomoditas'])->name('komoditas.get-komoditas');

    Route::get('komoditas/getDataTables', [KomoditasController::class, 'getDataTables'])->name('komoditas.getDataTables');

    Route::resource('komoditas', KomoditasController::class);

    Route::get('sub-komoditas/get-sub-komoditas/{id}', [SubKomoditasController::class, 'getSubKomoditas'])->name('sub-komoditas.get-sub-komoditas');

    Route::get('sub-komoditas/getDataTables', [SubKomoditasController::class, 'getDataTables'])->name('sub-komoditas.getDataTables');

    Route::resource('sub-komoditas', SubKomoditasController::class);

    Route::get('produk/ajax-search', [ProdukController::class, 'ajaxSearch'])->name('produk.ajax-search');

    Route::get('produk/getDataTables', [ProdukController::class, 'getDataTables'])->name('produk.getDataTables');

    Route::resource('produk', ProdukController::class);

    Route::get('instansi-pembina/getDataTables', [InstansiPembinaController::class, 'getDataTables'])->name('instansi-pembina.getDataTables');

    Route::resource('instansi-pembina', InstansiPembinaController::class);

    Route::get('perizinan/getDataTables', [PerizinanController::class, 'getDataTables'])->name('perizinan.getDataTables');

    Route::resource('perizinan', PerizinanController::class);

    Route::get('badan-usaha/getDataTables', [BadanUsahaController::class, 'getDataTables'])->name('badan-usaha.getDataTables');

    Route::resource('badan-usaha', BadanUsahaController::class);

    Route::get('pendidikan/getDataTables', [PendidikanController::class, 'getDataTables'])->name('pendidikan.getDataTables');

    Route::resource('pendidikan', PendidikanController::class);

    Route::get('pengguna/getDataTables', [UserController::class, 'getDataTables'])->name('pengguna.getDataTables');

    Route::resource('pengguna', UserController::class);

    
});