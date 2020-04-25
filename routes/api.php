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

Route::get('bank/login', ['middleware' => 'cors', 'uses' => 'UserController@loginBank']);
Route::get('customer/login', ['middleware' => 'cors', 'uses' => 'UserController@loginCustomer']);