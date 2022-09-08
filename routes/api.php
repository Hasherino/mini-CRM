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

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
});

Route::group(['prefix' => 'companies'], function ($router) {
    Route::get('', 'App\Http\Controllers\CompanyController@index');
    Route::get('{id}', 'App\Http\Controllers\CompanyController@show');
    Route::post('', 'App\Http\Controllers\CompanyController@create');
    Route::put('{id}', 'App\Http\Controllers\CompanyController@update');
    Route::delete('{id}', 'App\Http\Controllers\CompanyController@destroy');
});

Route::group(['prefix' => 'employees'], function ($router) {
    Route::get('', 'App\Http\Controllers\EmployeeController@index');
    Route::get('{id}', 'App\Http\Controllers\EmployeeController@show');
    Route::post('', 'App\Http\Controllers\EmployeeController@create');
    Route::put('{id}', 'App\Http\Controllers\EmployeeController@update');
    Route::delete('{id}', 'App\Http\Controllers\EmployeeController@destroy');
});