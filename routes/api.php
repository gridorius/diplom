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

Route::model('device', App\Device::class);

Route::post('login', 'UserController@login')->name('login');

Route::get('rooms', 'RoomController@getRooms')->name('getRooms');

Route::get('device/{device}/{value}', 'DeviceController@setValue')->name('setValue');