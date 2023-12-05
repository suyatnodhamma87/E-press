<?php

use App\Http\Controllers\AnakperusahaanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SettingController;
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




Route::middleware(['guest:karyawan'])->group(function () {
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

Route::middleware(['auth:karyawan'])->group(function () {
    Route::get('/home', [HomeController::class,'index']);
    Route::get('/proseslogout', [AuthController::class, 'proseslogout']);

//route presensi
    Route::get('/presensi/create', [PresensiController::class,'create']);
    Route::post('/presensi/store', [presensiController::class, 'store' ]);

//editprofile
    Route::get('/editprofile', [PresensiController::class, 'editprofile']);
    Route::post('/presensi/{nip}/updateprofile', [PresensiController::class, 'updateprofile']);

//history
    Route::get('/presensi/history', [PresensiController::class, 'history']);
    Route::post('/gethistory', [PresensiController::class,'gethistory']);

//ijin
    Route::get('/presensi/ijin', [PresensiController::class,'ijin']);
    Route::get('/presensi/buatijin', [PresensiController::class,'buatijin']);
    Route::post('/presensi/storeijin', [PresensiController::class,'storeijin']);
    Route::POST('/presensi/cekpengajuanijin', [PresensiController::class, 'cekpengajuanijin']);
});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/homeadmin', [HomeController::class, 'homeadmin']);


    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nip}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nip}/delete', [KaryawanController::class, 'delete']);

    //Divisi
    Route::get('/divisi', [DivisiController::class, 'indexdivisi']);
    Route::post('/divisi/store', [DivisiController::class, 'store']);
    Route::post('/divisi/edit', [DivisiController::class, 'edit']);
    Route::post('/divisi/{kode_div}/update', [DivisiController::class, 'update']);
    Route::post('/divisi/{kode_div}/delete', [DivisiController::class, 'delete']);

    //presensi
    Route::get('/presensi/livereport', [PresensiController::class, 'livereport']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/showmap', [PresensiController::class, 'tampilkanmap']);
    Route::get('/presensi/laporanpresensi', [PresensiController::class, 'laporanpresensi']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/laporanpresensiall', [PresensiController::class, 'laporanpresensiall']);
    Route::post('/presensi/cetaklaporanpresensiall', [PresensiController::class, 'cetaklaporanpresensiall']);
    Route::get('/presensi/perijinankaryawan', [PresensiController::class, 'perijinankaryawan']);
    Route::post('/presensi/approvalijinkaryawan', [PresensiController::class, 'approvalijinkaryawan']);
    Route::get('/presensi/{id}/batalkanapproval', [PresensiController::class, 'batalkanapproval']);

    //Cabang
    Route::get('/anakperusahaan', [AnakperusahaanController::class, 'index']);
    Route::post('/anakperusahaan/store', [AnakperusahaanController::class, 'store']);
    Route::post('/anakperusahaan/edit', [AnakperusahaanController::class, 'edit']);
    Route::post('/anakperusahaan/update', [AnakperusahaanController::class, 'update']);
    Route::post('/anakperusahaan/{kode_anper}/delete', [AnakperusahaanController::class, 'delete']);


    //Setting
    Route::get('/setting/lokasikantor', [SettingController::class, 'lokasikantor']);
    Route::post('/setting/updatelokasikantor', [SettingController::class, 'update']);
});
