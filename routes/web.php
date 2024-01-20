<?php

use App\Http\Controllers\AnakperusahaanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IjincutiController;
use App\Http\Controllers\IjinsakitController;
use App\Http\Controllers\IjintidakmasukController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

//ijintidakmasuk
    Route::get('/ijintidakmasuk', [IjintidakmasukController::class, 'ijintidakmasuk']);
    Route::post('/ijintidakmasuk/store', [IjintidakmasukController::class, 'store']);
    Route::get('/ijintidakmasuk/{kode_ijin}/edit', [IjintidakmasukController::class, 'edit']);
    Route::post('/ijintidakmasuk/{kode_ijin}/update', [IjintidakmasukController::class, 'update']);

//ijinsakit
    Route::get('/ijinsakit', [IjinsakitController::class, 'ijinsakit']);
    Route::post('/ijinsakit/store', [IjinsakitController::class, 'store']);
    Route::get('/ijinsakit/{kode_ijin}/edit', [IjinsakitController::class, 'edit']);
    Route::post('/ijinsakit/{kode_ijin}/update', [IjinsakitController::class, 'update']);

//ijincuti
    Route::get('/ijincuti', [IjincutiController::class, 'ijincuti']);
    Route::post('/ijincuti/store', [IjincutiController::class, 'store']);
    Route::get('/ijincuti/{kode_ijin}/edit', [IjincutiController::class, 'edit']);
    Route::post('/ijincuti/{kode_ijin}/update', [IjincutiController::class, 'update']);

//editijinuser
    Route::get('/ijin/{kode_ijin}/showact', [PresensiController::class, 'showact']);
    Route::get('/ijin/{kode_ijin}/delete', [PresensiController::class, 'deleteijin']);
});

//Route khusus administrator & Admin divisi
Route::group(['middleware' => ['role:administrator|admin divisi,user']], function (){
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/homeadmin', [HomeController::class, 'homeadmin']);

    //karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::get('/karyawan/{nip}/resetpassword', [KaryawanController::class, 'resetpassword']);

    //set jam kerja karyawan
    Route::get('/setting/{nip}/setjamkerja', [SettingController::class, 'setjamkerja']);
    Route::post('/setting/storesetjamkerja', [SettingController::class, 'storesetjamkerja']);
    Route::post('/setting/updatesetjamkerja', [SettingController::class, 'updatesetjamkerja']);

    //presensi
    Route::get('/presensi/livereport', [PresensiController::class, 'livereport']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/showmap', [PresensiController::class, 'tampilkanmap']);
    Route::get('/presensi/laporanpresensi', [PresensiController::class, 'laporanpresensi']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/laporanpresensiall', [PresensiController::class, 'laporanpresensiall']);
    Route::post('/presensi/cetaklaporanpresensiall', [PresensiController::class, 'cetaklaporanpresensiall']);
    Route::get('/presensi/perijinankaryawan', [PresensiController::class, 'perijinankaryawan']);
});


Route::group(['middleware' => ['role:administrator,user']], function (){
    //karyawan
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nip}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nip}/delete', [KaryawanController::class, 'delete']);
    Route::post("/karyawan/importexcel",[KaryawanController::class,"importexcel"])->name("importexcel");


    //Divisi
    Route::get('/divisi', [DivisiController::class, 'indexdivisi'])->middleware('permission:view-divisi,user');
    Route::post('/divisi/store', [DivisiController::class, 'store']);
    Route::post('/divisi/edit', [DivisiController::class, 'edit']);
    Route::post('/divisi/{kode_div}/update', [DivisiController::class, 'update']);
    Route::post('/divisi/{kode_div}/delete', [DivisiController::class, 'delete']);

    //presensi
    Route::post('/presensi/approvalijinkaryawan', [PresensiController::class, 'approvalijinkaryawan']);
    Route::get('/presensi/{kode_ijin}/batalkanapproval', [PresensiController::class, 'batalkanapproval']);

    //Cabang
    Route::get('/anakperusahaan', [AnakperusahaanController::class, 'index']);
    Route::post('/anakperusahaan/store', [AnakperusahaanController::class, 'store']);
    Route::post('/anakperusahaan/edit', [AnakperusahaanController::class, 'edit']);
    Route::post('/anakperusahaan/update', [AnakperusahaanController::class, 'update']);
    Route::post('/anakperusahaan/{kode_anper}/delete', [AnakperusahaanController::class, 'delete']);


    //Setting
    Route::get('/setting/lokasikantor', [SettingController::class, 'lokasikantor']);
    Route::post('/setting/updatelokasikantor', [SettingController::class, 'update']);

    Route::get('/setting/jamkerja', [SettingController::class, 'jamkerja']);
    Route::post('/setting/storejamkerja', [SettingController::class, 'storejamkerja']);
    Route::post('/setting/editjamkerja', [SettingController::class, 'editjamkerja']);
    Route::post('/setting/updatejamkerja', [SettingController::class, 'updatejamkerja']);
    Route::post('/setting/jam_kerja/{kode_jamkerja}/deletejamkerja', [SettingController::class, 'deletejamkerja']);


    Route::get('/setting/jamkerjadiv', [SettingController::class, 'jamkerjadiv']);
    Route::get('/setting/jamkerjadiv/create', [SettingController::class, 'createjamkerjadiv']);
    Route::post('/setting/jamkerjadiv/store', [SettingController::class, 'storejamkerjadiv']);
    Route::get('/setting/jamkerjadiv/{kode_jk_div}/edit', [SettingController::class, 'editjamkerjadiv']);
    Route::post('/setting/jamkerjadiv/{kode_jk_div}/update', [SettingController::class, 'updatejamkerjadiv']);
    Route::get('/setting/jamkerjadiv/{kode_jk_div}/show', [SettingController::class, 'showjamkerjadiv']);
    Route::get('/setting/jamkerjadiv/{kode_jk_div}/delete', [SettingController::class, 'deletejamkerjadiv']);

    //Users
    Route::get('/setting/users', [UserController::class, 'index']);
    Route::post('/setting/users/store', [UserController::class, 'store']);
    Route::post('/setting/users/edit', [UserController::class, 'edit']);
    Route::post('/setting/users/{id_user}/update', [UserController::class, 'update']);
    Route::post('/setting/users/{id_user}/deleteuser', [UserController::class, 'deleteuser']);

    //cuti
    Route::get('/cuti', [CutiController::class, 'indexcuti']);
    Route::post('/cuti/storecuti', [CutiController::class, 'storecuti']);
    Route::post('/cuti/edit', [CutiController::class, 'edit']);
    Route::post('/cuti/{kode_cuti}/update', [CutiController::class, 'update']);
    Route::post('/cuti/{kode_cuti}/delete', [CutiController::class, 'delete']);
});

Route::get('/createrolerpermission', function() {

    try {
        Role::create(['name' => 'admin divisi']);
        // Permission::create(['name' => 'view-karyawan']);
        // Permission::create(['name' => 'view-divisi']);
        echo "success";
    } catch (\Exception $e) {
        echo "Error";
    }
});

Route::get('/give-user-role', function(){
    try {
        $user = User::findorfail(1);
        $user ->assignRole('administrator');
        echo "success";
    } catch (\Exception $e) {
        echo "Error";
    }
});

Route::get('/give-role-permission', function(){
    try {
        $role = Role::findorfail(1);
        $role->givePermissionTo('view-divisi');
        echo "success";
    } catch (\Exception $e) {
        echo "error";
    }
});

Route::get('/get-image',function(){
    $path = 'D:\Onedrive\OneDrive - Bina Nusantara\KULIAH\KULIAH\e-presensi\Aplikasi Nalanda E-Press\Nalanda E-press\public\assets\img\logopt.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
return $base64;
});
