<?php

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

Route::group(['namespace' => '\App\Http\Controllers'], function () {

    Route::get('crisp', 'CrispController@index');

    Route::group(['prefix' => 'crisp/webhook'], function () {
        // Route::get('', 'CrispController@index');
    });
});