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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('logout', 'UserController@logout');
Route::post('login', 'UserController@login');
Route::resource('place','PlaceController', ['except' => ['create', 'edit']]);
Route::resource('device','DeviceController', ['except' => ['create', 'edit']]);
Route::get('service/{id}/{data}/{mutantKey}', 'DeviceController@service');
Route::get('cryptExample/{method?}', 'DeviceController@cryptExample');
