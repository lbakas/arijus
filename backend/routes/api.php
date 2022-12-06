<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/orders', 'App\Http\Controllers\OrdersController@list');
Route::post('/orders', 'App\Http\Controllers\OrdersController@store');
Route::get('/order/{id}', 'App\Http\Controllers\OrdersController@show');
Route::post('/order/{id}', 'App\Http\Controllers\OrdersController@update');
Route::delete('/order/{id}', 'App\Http\Controllers\OrdersController@delete');

Route::get('/clients', 'App\Http\Controllers\ClientsController@list');