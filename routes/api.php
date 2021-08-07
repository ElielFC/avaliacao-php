<?php

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

Route::group(['middleware' => ['auth:web'], 'prefix' => '/product-categories', 'namespace' => 'Api'], function () {
    Route::get('/', 'ProductCategoryController@index');
    Route::get('/{id}', 'ProductCategoryController@show');
    Route::post('/', 'ProductCategoryController@store');
    Route::put('/{id}', 'ProductCategoryController@update');
    Route::delete('/{id}', 'ProductCategoryController@destroy');
});
