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
    Route::get('/export/pegawai/', [PegawaiController::class, 'export']);
    Route::post('/import/pegawai/', [PegawaiController::class, 'import'])->name('import-pegawai');
    Route::get('/report/pegawai/', [PegawaiController::class, 'report']);
    Route::post('/pegawai/cari-jabatan', [PegawaiController::class, 'cariJabatan'])->name('cariJabatan');
    Route::get('/ajax_autocomplete', [PegawaiController::class, 'ajax_autocomplete']);
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
    // Route Berkas
    Route::resource('/berkas', BerkasController::class);
    // Route Pengguna
    Route::resource('/riwayat-jabatan', RiwayatJabatanController::class);
    // Route Cuti
    Route::resource('/cuti', CutiController::class);
    // Route Pengguna
    Route::resource('/user', UserController::class);
    Route::get('/pegawai-list', [CutiController::class, 'pegawaiList']);
});

Route::group(['middleware' => ['auth', 'checkrole:user']], function (){
    // Route Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/data-diri', [DataDiriController::class, 'index']);
    Route::group(['middleware' => ['auth', 'checkip']], function (){
        Route::get('/presensi-pegawai', [PresensiController::class, 'index_']);
        Route::post('/presensi-pegawai', [PresensiController::class, 'absen_masuk']);
        Route::put('/presensi-pegawai', [PresensiController::class, 'absen_pulang']);
    });
});