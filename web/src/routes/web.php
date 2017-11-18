<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api', 'middleware' => 'auth:api'], function() {
    Route::get('/test', function (Request $request) {
        return response()->json(['name' => 'test']);
    });

    Route::post('apnics/search','ApnicsController@search');
});

Route::group(['middleware' => ['web']], function() {
    Route::get('apnics/init','ApnicsController@init');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
