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

Route::get('/', [GetdataController::class, 'getData']);
Route::get('/test', 'App\Http\Controllers\TestController@test');

//Route::get('/getdatafromapi', 'App\HTTP\Controllers\GetDataFromApi');