<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\AuthController;
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

    Route::group(['middleware' => ['admin']], function () {

        Route::resource('menu',MenuController::class);
        Route::resource('paket',PaketController::class);
        Route::resource('meja', App\Http\Controllers\MejaController::class);
        Route::resource('menupaket',App\Http\Controllers\MenuPaketController::class);


        // Route::get('/transaksi', function () {
        //     return 'trx';
        // });
    });

    //buat shift
    Route::get('/cashawal',[App\Http\Controllers\ShiftController::class,'cashawal']);
    Route::post('/storecash',[App\Http\Controllers\ShiftController::class,'inputCash']);
    //

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');

    // Route::get('/tes',[AuthController::class,'tes']);
    Route::post('/storeakhir',[App\Http\Controllers\ShiftController::class,'update']);
    Route::get('/logout',[AuthController::class,'logout']);

});
