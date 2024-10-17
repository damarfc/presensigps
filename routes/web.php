<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\PerangkatDesaController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

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


Route::middleware(['guest:perangkat_desa'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    
    Route::post('/proseslogin', [AuthController::class, 'proseslogin']);
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
    
});


Route::middleware(['auth:perangkat_desa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

    //presensi
    Route::get('/presensi/create', [PresensiController::class, 'create']);
    Route::post('/presensi/store', [PresensiController::class, 'store']);

    //Edit profile
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('presensi/{PD_ID}/updateprofile', [PresensiController::class, 'updateprofile']);

    //history
    Route::get('/presensi/histori', [PresensiController::class, 'histori']);
    Route::post('/gethistori', [PresensiController::class, 'gethistori']);

    //izin
    Route::get('/presensi/izin', [PresensiController::class, 'izin']);
    Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
    Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
    Route::post('/presensi/cekpengajuanizin', [PresensiController::class, 'cekpengajuanizin']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

    //perangkatdesa
    Route::get('/perangkatdesa', [PerangkatDesaController::class,'index']);
    Route::post('/perangkatdesa/store', [PerangkatDesaController::class,'store']);
    Route::post('/perangkatdesa/edit', [PerangkatDesaController::class,'edit']);
    Route::post('/perangkatdesa/{PD_ID}/update', [PerangkatDesaController::class,'update']);
    Route::post('/perangkatdesa/{PD_ID}/delete', [PerangkatDesaController::class,'delete']);
    //desa
    Route::get('/desa', [DesaController::class,'index']);
    Route::post('/desa/store', [DesaController::class, 'store']);
    Route::post('/desa/edit', [DesaController::class, 'edit']);
    Route::post('/desa/{kode_desa}/update', [DesaController::class, 'update']);
    Route::post('/desa/{kode_desa}/delete', [DesaController::class, 'delete']);
    //presensi
    Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/tampilkanpeta', [PresensiController::class, 'tampilkanpeta']);
    Route::get('/presensi/izinsakit', [PresensiController::class, 'izinsakit']);
    Route::post('/presensi/approvedizinsakit', [PresensiController::class, 'approvedizinsakit']);
    Route::get('/presensi/{id}/batalkanizinsakit', [PresensiController::class, 'batalkanizinsakit']);
    //laporan
    Route::get('/presensi/laporan', [PresensiController::class, 'laporan']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap']);
    Route::post('/presensi/cetakrekap', [PresensiController::class, 'cetakrekap']);
    //konfigurasi
    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor']);


});

