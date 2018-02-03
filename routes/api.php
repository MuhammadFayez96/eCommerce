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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// countries routes
Route::group(['prefix' => 'counties/', 'namespace' => 'API'], function () {

    Route::get('','CountriesController@getAllCountry')->name('countries.getAllCountries');
    Route::get('{id}','CountriesController@getCountry')->name('countries.getCountry');
    Route::delete('delete/{id}','CountriesController@deleteCountry')->name('countries.deleteCountry');
    Route::patch('update/{id}','CountriesController@updateCountry')->name('countries.updateCountry');
});