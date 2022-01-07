<?php

use Illuminate\Support\Facades\Route;
use App\HTTP\Controllers\GetdataController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/db', [GetdataController::class, 'getDataFromApi'])->name('getDataFromApi');

Route::get('/test', [GetdataController::class, 'getData'])->name('getData');