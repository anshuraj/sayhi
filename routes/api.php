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

Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'Api\UserController@details');
    Route::get('users', 'Api\UserController@users');
    Route::post('sayhi', 'Api\UserController@sayhi');
    Route::get('messages', 'Api\UserController@getMessages');
    Route::post('logout','Api\UserController@logout');
});
