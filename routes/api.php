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

    Route::get('','CountriesController@getAllCountries')->name('countries.getAllCountries');
    Route::get('{id}','CountriesController@getCountry')->name('countries.getCountry');
    Route::post('create','CountriesController@createNewCountry')->name('countries.createNewCountry');
    Route::patch('update/{id}','CountriesController@updateCountry')->name('countries.updateCountry');
    Route::delete('delete/{id}','CountriesController@deleteCountry')->name('countries.deleteCountry');
});



// options routes
Route::group(['prefix' => 'options/', 'namespace' => 'API'], function () {

    Route::get('','OptionsController@getAllOptions')->name('options.getAllOptions');
    Route::get('{id}','OptionsController@getOption')->name('options.getOption');
    Route::post('create','OptionsController@createNewOption')->name('options.createNewOption');
    Route::patch('update/{id}','OptionsController@updateOption')->name('options.updateOption');
    Route::delete('delete/{id}','OptionsController@deleteOption')->name('options.deleteOption');

});

// Menus routes
Route::group(['prefix' => 'menus/', 'namespace' => 'API'], function () {

    Route::get('','MenusController@getAllMenus')->name('menus.getAllMenus');
    Route::get('{id}','MenusController@getMenu')->name('menus.getMenu');
    Route::post('create','MenusController@createNewMenu')->name('menus.createNewMenu');
    Route::patch('update/{id}','MenusController@updateMenu')->name('menus.updateMenu');
    Route::delete('delete/{id}','MenusController@deleteMenu')->name('menus.deleteMenu');

});


// Categories routes
Route::group(['prefix' => 'categories/', 'namespace' => 'API'], function () {

    Route::get('','CategoriesController@getAllCategories')->name('categories.getAllCategories');
    Route::get('{id}','CategoriesController@getCategory')->name('categories.getCategory');
    Route::post('create','CategoriesController@createNewCategory')->name('categories.createNewCategory');
    Route::patch('update/{id}','CategoriesController@updateCategory')->name('categories.updateCategory');
    Route::delete('delete/{id}','CategoriesController@deleteCategory')->name('categories.deleteCategory');

});