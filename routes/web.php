<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RestockController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AnalitikController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstitusiController;
use App\Http\Controllers\MenuGroupController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RepositoriController;
use App\Http\Controllers\SumberDanaController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\KriteriaMitraController;
use App\Http\Controllers\BentukKegiatanController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\StatusKerjasamaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// })->name('home.index');

Route::get('/', function () {
    return redirect()->to('/login');
});

Route::group(['middleware' => ['web', 'auth', 'verified']], function () {
    Route::resource('dashboard', DashboardController::class)->only('index');
    Route::get('dashboard/mode', [DashboardController::class, 'mode'])->name('dashboard.mode');

    // DATA MASTER
    Route::get('data-jenis-motor', [MasterDataController::class,'jenisMotor'])->name('jenis-motor.index');
    Route::get('data-mekanik', [MasterDataController::class,'mekanik'])->name('mekanik.index');
    Route::get('data-spareparts', [MasterDataController::class,'sparepart'])->name('sparepart.index');
    Route::get('data-suppliers', [MasterDataController::class,'suppliers'])->name('suppliers.index');
    Route::get('data-services', [MasterDataController::class,'services'])->name('services.index');
 
    // TRANSAKSI
    Route::get('transaksi-bengkel',[TransaksiController::class,'transaksi'])->name('transaksi.bengkel');
    Route::get('riwayat-transaksi-bengkel',[TransaksiController::class,'riwayat'])->name('transaksi.riwayat');
    Route::get('cetak-transaksi-bengkel/{id}', [TransaksiController::class, 'cetak'])->name('transaksi.cetak');

    // RESTOCK
    Route::get('restock-barang', [RestockController::class,'index'])->name('restock.index');
    Route::get('riwayat-restock-barang', [RestockController::class,'riwayat'])->name('restock.riwayat');

    // Pengaturan
    Route::get('setting', [SettingController::class,'index'])->name('setting.index');
    Route::post('setting/update', [SettingController::class, 'update'])->name('setting.update');

    // REF DATA AJAX
    Route::get('referensi-sparepart', [AjaxController::class,'sparepart'])->name('ajax.sparepart');
    Route::get('referensi-service', [AjaxController::class,'service'])->name('ajax.service');
    Route::get('referensi-mekanik', [AjaxController::class,'mekanik'])->name('ajax.mekanik');
    Route::get('referensi-supplier', [AjaxController::class,'supplier'])->name('ajax.supplier');

    // ROUTE DEVELOPER
    Route::resource('user', UserManagementController::class)->only('index', 'store', 'update', 'destroy');
    Route::prefix('user')->group(function () {
        Route::resource('profile', UserProfileController::class)->only('index');
    });
    

    Route::resource('route', RouteController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('role', RoleController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('permission', PermissionController::class)->only('index', 'store', 'update', 'destroy');

    Route::resource('menu', MenuGroupController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('menu.item', MenuItemController::class)->only('index', 'store', 'update', 'destroy');
});