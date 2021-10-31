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

        Route::get('/transaksi', function () {
            return 'trx';
        });
    });

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class,'index'])
        ->name('dashboard');

    Route::get('/tes',[AuthController::class,'tes']);
    Route::get('/logout',[AuthController::class,'logout']);

});
