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
    Route::get('/', 'ProductCategoriesController@index');
    Route::get('/{id}', 'ProductCategoriesController@show');
    Route::post('/', 'ProductCategoriesController@store');
    Route::put('/{id}', 'ProductCategoriesController@update');
    Route::delete('/{id}', 'ProductCategoriesController@destroy');
});
