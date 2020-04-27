<?php

use Illuminate\Http\Request;

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

Route::post('bank/login', ['middleware' => 'cors', 'uses' => 'UserController@loginBank']);
Route::post('customer/login', ['middleware' => 'cors', 'uses' => 'UserController@loginCustomer']);
Route::post('customer/options', ['middleware' => 'cors', 'uses' => 'OptionController@options']);