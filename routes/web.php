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
        Route::resource('menu',MenuController::class);
        Route::resource('paket',PaketController::class);
        Route::get('/paket/{id}/getMenu',[PaketController::class,'getMenu']);
        Route::post('/paket/{id}/addMenu',[PaketController::class,'addMenu']);
        Route::delete('/paket/{id}/{id2}/deleteMenu', [PaketController::class,'deleteMenu']);
        Route::resource('meja', App\Http\Controllers\MejaController::class);
        Route::resource('posts', UserController::class);

    });

    //buat shift
    Route::get('/cashawal',[App\Http\Controllers\ShiftController::class,'cashawal'])->name('cashawal');
    Route::post('/storecash',[App\Http\Controllers\ShiftController::class,'inputCash']);
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class,'index'])->name('dashboard')->middleware('cekshift');

    Route::get('/trx',[App\Http\Controllers\TrxController::class,'index'])->middleware('cekshift');
    Route::get('/getPaket',[App\Http\Controllers\TrxController::class,'getPaket'])->middleware('cekshift');
    Route::get('/hargaMenu', [App\Http\Controllers\TrxController::class,'hargaMenu'])->middleware('cekshift');
    Route::get('/hargaPaket',[App\Http\Controllers\TrxController::class,'hargaPaket'])->middleware('cekshift');
    Route::post('/trx/store',[App\Http\Controllers\TrxController::class,'store'])->middleware('cekshift');
    Route::post('/trx/{id}/checkout',[App\Http\Controllers\TrxController::class,'checkout'])->name('checkout')->middleware('cekshift');



    Route::post('/storeakhir',[App\Http\Controllers\ShiftController::class,'update'])->middleware('cekshift');
    Route::get('/logout',[AuthController::class,'logout'])->middleware('cekshift');

});
