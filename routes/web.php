<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DataDiriController;
use App\Http\Controllers\RiwayatJabatanController;
use App\Http\Controllers\RiwayatPendidikanController;
use App\Http\Controllers\PresensiController;

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
// Route Login
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);

// Route Logout
Route::post('/logout', [LoginController::class, 'logout']);

// Route Register
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::group(['middleware' => ['auth', 'checkRole:admin']], function (){
    // Route Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    // Route Data Pegawai
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::get('/pegawai/create-pegawai-tetap', [PegawaiController::class, 'createPegawaiTetap'])->name('createPegawaiTetap');
    Route::get('/pegawai/create-pegawai-kontrak', [PegawaiController::class, 'createPegawaiKontrak'])->name('createPegawaiKontrak');
    Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('storePegawai');
    Route::get('/pegawai/show/{id}', [PegawaiController::class, 'show'])->name('showPegawai');
    Route::post('/pegawai/store-riwayat-pendidikan', [PegawaiController::class, 'storeRiwayatPendidikan'])->name('storeRiwayatPendidikan');
    Route::post('/pegawai/store-riwayat-jabatan', [PegawaiController::class, 'storeRiwayatJabatan'])->name('storeRiwayatJabatan');
    Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('editPegawai');
    Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('updatePegawai');
    Route::put('/pegawai/update-riwayat-pendidikan/{id}', [PegawaiController::class, 'updateRiwayatPendidikan'])->name('updateRiwayatPendidikan');
    Route::put('/pegawai/update-riwayat-jabatan/{id}', [PegawaiController::class, 'updateRiwayatJabatan'])->name('updateRiwayatJabatan');
    Route::post('/pegawai/store-berkas', [PegawaiController::class, 'storeBerkas'])->name('storeBerkas');
    Route::get('/export/pegawai/', [PegawaiController::class, 'export'])->name('exportPegawai');
    Route::post('/import/pegawai/', [PegawaiController::class, 'import'])->name('importPegawai');
    Route::get('/report/pegawai/', [PegawaiController::class, 'report']);

    // Route Master Data
        // Data Golongan
        Route::resource('/golongan', GolonganController::class);
        Route::get('/export/golongan/', [GolonganController::class, 'export']);
        Route::post('/import/golongan/', [GolonganController::class, 'import'])->name('import-golongan');
        // Data Bidang
        Route::resource('/bidang', BidangController::class);
        Route::get('/export/bidang/', [BidangController::class, 'export']);
        Route::post('/import/bidang/', [BidangController::class, 'import'])->name('import-bidang');
        // Data Jabatan
        Route::resource('/jabatan', JabatanController::class);
        Route::get('/export/jabatan/', [JabatanController::class, 'export']);
        Route::post('/import/jabatan/', [JabatanController::class, 'import'])->name('import-jabatan');
    
    // Route Presensi
    Route::get('/rekap-presensi', [PresensiController::class, 'rekapPresensi']);

    // Route Data Pengguna
    Route::resource('/user', UserController::class);
});

// Routing Java Script
Route::post('/cari-pegawai', [PegawaiController::class, 'cariPegawai'])->name('cariPegawai');
Route::post('/cari-jabatan', [PegawaiController::class, 'cariJabatan'])->name('cariJabatan');
Route::post('/cari-golongan', [PegawaiController::class, 'cariGolongan'])->name('cariGolongan');
Route::post('/cari-kota', [PegawaiController::class, 'cariKota'])->name('cariKota');
Route::post('/cari-kecamatan', [PegawaiController::class, 'cariKecamatan'])->name('cariKecamatan');
Route::post('/cari-desa', [PegawaiController::class, 'cariDesa'])->name('cariDesa');
Route::post('/cari-kode-pos', [PegawaiController::class, 'cariKodePos'])->name('cariKodePos');

Route::group(['middleware' => ['auth', 'checkRole:admin,user']], function (){
    // Route Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::group(['middleware' => ['auth', 'checkRole:user']], function (){
        Route::get('/profil', [PegawaiController::class, 'show_']);
        Route::get('/pemberkasan-pegawai', [BerkasController::class, 'index_']);
        Route::group(['middleware' => ['auth', 'checkIP']], function (){
            Route::get('/presensi-pegawai', [PresensiController::class, 'index_']);
            Route::post('/presensi-pegawai', [PresensiController::class, 'absen_masuk']);
            Route::put('/presensi-pegawai', [PresensiController::class, 'absen_pulang']);
        });
        // Route Berkas
        Route::get('/pemberkasan-pegawai', [BerkasController::class, 'index_']);
        Route::post('/pemberkasan-pegawai', [BerkasController::class, 'store_']);
        Route::delete('/pemberkasan-pegawai/{id}', [BerkasController::class, 'destroy_']);
    });
});
