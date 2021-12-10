<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[AuthController::class,'index'])->name('login')->middleware('guest');
Route::post('/auth',[AuthController::class,'authenticate']);

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['admin','cekshift']], function () {
        Route::get('/report',[App\Http\Controllers\TrxController::class,'report']);
<<<<<<< HEAD
        Route::get('/activity-report',[App\Http\Controllers\TrxController::class,'activityReport']);
        Route::get('/pegawai-report',[App\Http\Controllers\TrxController::class,'pegawaiReport']);
=======
>>>>>>> 2f1bf87dd07d03a594828cf8fbee33d43df3dcb5
        Route::get('/payment-report',[App\Http\Controllers\TrxController::class,'paymentReport']);
        Route::resource('menu',MenuController::class);
        Route::resource('paket',PaketController::class);
        Route::get('/paket/{id}/getMenu',[PaketController::class,'getMenu']);
        Route::post('/paket/{id}/addMenu',[PaketController::class,'addMenu']);
        Route::delete('/paket/{id}/{id2}/deleteMenu', [PaketController::class,'deleteMenu']);
        Route::resource('meja', App\Http\Controllers\MejaController::class);
        Route::resource('posts', UserController::class);
        Route::get('/bestSelling',[App\Http\Controllers\TrxController::class,'bestSelling']);
    });

    //buat shift
    Route::get('/cashawal',[App\Http\Controllers\ShiftController::class,'cashawal'])->name('cashawal')->middleware('cekshift');
    Route::post('/storecash',[App\Http\Controllers\ShiftController::class,'inputCash']);

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class,'index'])->name('dashboard')->middleware('cekshift');

    Route::get('/trx',[App\Http\Controllers\TrxController::class,'index'])->middleware('cekshift');
    Route::post('/trx/chooseTable',[App\Http\Controllers\TrxController::class,'chooseTable'])->name('chooseTable')->middleware('cekshift');

    Route::get('/trx/create',[App\Http\Controllers\TrxController::class,'create'])->name('trxcreate')->middleware('cekshift');
    Route::get('/order',[App\Http\Controllers\TrxController::class,'orderPegawai'])->name('orderPegawai')->middleware('cekshift');

    Route::get('/getPaket',[App\Http\Controllers\TrxController::class,'getPaket'])->middleware('cekshift');
    Route::get('/hargaMenu', [App\Http\Controllers\TrxController::class,'hargaMenu'])->middleware('cekshift');

    Route::get('/hargaPaket',[App\Http\Controllers\TrxController::class,'hargaPaket'])->middleware('cekshift');
    Route::post('/trx/store',[App\Http\Controllers\TrxController::class,'store'])->middleware('cekshift');
<<<<<<< HEAD
=======

    Route::post('/trx/{id}/checkout',[App\Http\Controllers\TrxController::class,'checkout'])
    ->name('checkout')->middleware('cekshift');

    Route::get('/trx/{id}/splitBill',[App\Http\Controllers\TrxController::class,'splitBill'])
    ->name('splitBill')->middleware('cekshift');

    Route::get('/trx/{id}/pindahMeja',[App\Http\Controllers\TrxController::class,'pindahMeja'])
    ->name('pindahMeja')->middleware('cekshift');

    Route::delete('/trx/{id}/cancel',[App\Http\Controllers\TrxController::class,'cancel'])
    ->name('cancel')->middleware('cekshift');

    Route::put('/splitSelected',[App\Http\Controllers\TrxController::class,'splitSelected'])
    ->middleware('cekshift');

    Route::get('/trx/{id}/menu',[App\Http\Controllers\TrxController::class,'listMenu'])
    ->name('listMenu')->middleware('cekshift');

    Route::get('/trx/{id}/invoice',[App\Http\Controllers\TrxController::class,'invoice'])
    ->name('invoice')->middleware('cekshift');
>>>>>>> 2f1bf87dd07d03a594828cf8fbee33d43df3dcb5

    Route::post('/trx/{id}/checkout',[App\Http\Controllers\TrxController::class,'checkout'])
    ->name('checkout')->middleware('cekshift');

    Route::get('/trx/{id}/splitBill',[App\Http\Controllers\TrxController::class,'splitBill'])
    ->name('splitBill')->middleware('cekshift');

    Route::get('/trx/{id}/pindahMeja',[App\Http\Controllers\TrxController::class,'pindahMeja'])
    ->name('pindahMeja')->middleware('cekshift');

    Route::delete('/trx/{id}/cancel',[App\Http\Controllers\TrxController::class,'cancel'])
    ->name('cancel')->middleware('cekshift');

    Route::put('/splitSelected',[App\Http\Controllers\TrxController::class,'splitSelected'])
    ->middleware('cekshift');

    Route::get('/trx/{id}/menu',[App\Http\Controllers\TrxController::class,'listMenu'])
    ->name('listMenu')->middleware('cekshift');

    Route::get('/trx/{id}/invoice',[App\Http\Controllers\TrxController::class,'invoice'])
    ->name('invoice')->middleware('cekshift');

    Route::get('/logout',[AuthController::class,'logout'])->middleware('cekshift');

    Route::post('/storeakhir',[App\Http\Controllers\ShiftController::class,'update'])
    ->middleware('cekshift');

});
