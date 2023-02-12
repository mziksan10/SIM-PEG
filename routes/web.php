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

Route::group(['middleware' => ['auth', 'checkrole:admin']], function (){
    // Route Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    // Route Pegawai
    Route::resource('/pegawai', PegawaiController::class);
    Route::get('/create-pegawai-tetap/pegawai', [PegawaiController::class, 'createPegawaiTetap']);
    Route::get('/create-pegawai-kontrak/pegawai', [PegawaiController::class, 'createPegawaiKontrak']);
    Route::get('/export/pegawai/', [PegawaiController::class, 'export']);
    Route::post('/import/pegawai/', [PegawaiController::class, 'import'])->name('import-pegawai');
    Route::get('/report/pegawai/', [PegawaiController::class, 'report']);
    // Route Golongan
    Route::resource('/golongan', GolonganController::class);
    Route::get('/export/golongan/', [GolonganController::class, 'export']);
    Route::post('/import/golongan/', [GolonganController::class, 'import'])->name('import-golongan');
    Route::get('/report/golongan/', [GolonganController::class, 'report']);
    // Route Bidang
    Route::resource('/bidang', BidangController::class);
    Route::get('/export/bidang/', [BidangController::class, 'export']);
    Route::post('/import/bidang/', [BidangController::class, 'import'])->name('import-bidang');
    // Route Jabatan
    Route::resource('/jabatan', JabatanController::class);
    Route::get('/export/jabatan/', [JabatanController::class, 'export']);
    Route::post('/import/jabatan/', [JabatanController::class, 'import'])->name('import-jabatan');
    // Route Riwayat Jabatan
    Route::resource('/riwayat-jabatan', RiwayatJabatanController::class);
    Route::post('/import/riwayat-jabatan/', [RiwayatJabatanController::class, 'import'])->name('import-riwayat-jabatan');
    // Route Riwayat Pendidikan
    Route::resource('/riwayat-pendidikan', RiwayatPendidikanController::class);
    // Route Pemberkasan
    Route::resource('/riwayat-pemberkasan', BerkasController::class);
    // Route Presensi
    Route::resource('/presensi', PresensiController::class);
    Route::put('/ubah_presensi/{id}', [PresensiController::class, 'ubah_presensi']);
    Route::get('/export/presensi/', [PresensiController::class, 'export']);
    // Route Pengguna
    Route::resource('/user', UserController::class);
    // Routing JS
    Route::post('/cari-pegawai', [PegawaiController::class, 'cariPegawai'])->name('cariPegawai');
    Route::post('/cari-jabatan', [PegawaiController::class, 'cariJabatan'])->name('cariJabatan');
    Route::post('/cari-golongan', [PegawaiController::class, 'cariGolongan'])->name('cariGolongan');
    Route::post('/cari-kota', [PegawaiController::class, 'cariKota'])->name('cariKota');
    Route::post('/cari-kecamatan', [PegawaiController::class, 'cariKecamatan'])->name('cariKecamatan');
    Route::post('/cari-desa', [PegawaiController::class, 'cariDesa'])->name('cariDesa');
    Route::post('/cari-kode-pos', [PegawaiController::class, 'cariKodePos'])->name('cariKodePos');
});

Route::group(['middleware' => ['auth', 'checkrole:user']], function (){
    // Route Dashboard
    Route::get('/profil', [PegawaiController::class, 'index_']);
    Route::get('/pemberkasan-pegawai', [BerkasController::class, 'index_']);
    Route::group(['middleware' => ['auth', 'checkip']], function (){
        Route::get('/presensi-pegawai', [PresensiController::class, 'index_']);
        Route::post('/presensi-pegawai', [PresensiController::class, 'absen_masuk']);
        Route::put('/presensi-pegawai', [PresensiController::class, 'absen_pulang']);
    });
    // Route Berkas
    Route::get('/pemberkasan-pegawai', [BerkasController::class, 'index_']);
    Route::post('/pemberkasan-pegawai', [BerkasController::class, 'store_']);
    Route::delete('/pemberkasan-pegawai/{id}', [BerkasController::class, 'destroy_']);
});