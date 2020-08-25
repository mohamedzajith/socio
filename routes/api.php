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

Route::prefix('auth')
    ->group(function () {
        Route::post('/login', 'Api\AuthenticateController@login');
        Route::post('/signup', 'Api\AuthenticateController@register');
        Route::post('/admin/signup', 'Api\AuthenticateController@adminRegister');
        Route::post('/admin', 'Api\AuthenticateController@adminLogin');
    });

Route::prefix('product')
    ->middleware('jwt.auth.refresh')
    ->group(function () {
        Route::get('/', 'Api\AuthenticateController@index');
        Route::post('/', 'Api\AuthenticateController@store');
        Route::post('/disable', 'Api\AuthenticateController@disable');
        Route::put('/{id}', 'Api\AuthenticateController@update');
        Route::delete('/{id}', 'Api\AuthenticateController@delete');
    });
