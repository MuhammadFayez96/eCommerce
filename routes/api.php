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


// addresses routes
Route::group(['prefix' => 'addresses/', 'namespace' => 'API'], function () {

    //countries routes
    Route::get('countries', 'AddressesController@getAllCountries')->name('countries.getAllCountries');
    Route::get('countries/{id}', 'AddressesController@getCountry')->name('countries.getCountry');
    Route::post('countries/create', 'AddressesController@createNewCountry')->name('countries.createNewCountry');
    Route::patch('countries/update/{id}', 'AddressesController@updateCountry')->name('countries.updateCountry');
    Route::delete('countries/delete/{id}', 'AddressesController@deleteCountry')->name('countries.deleteCountry');

    //cities routes
    Route::get('cities', 'AddressesController@getAllCities')->name('cities.getAllCities');
    Route::get('cities/{id}', 'AddressesController@getCity')->name('cities.getCity');
    Route::post('cities/create', 'AddressesController@createNewCity')->name('cities.createNewCity');
    Route::patch('cities/update/{id}', 'AddressesController@updateCity')->name('cities.updateCity');
    Route::delete('cities/delete/{id}', 'AddressesController@deleteCity')->name('cities.deleteCity');


});


// options routes
Route::group(['prefix' => 'options/', 'namespace' => 'API'], function () {

    Route::get('', 'OptionsController@getAllOptions')->name('options.getAllOptions');
    Route::get('{id}', 'OptionsController@getOption')->name('options.getOption');
    Route::post('create', 'OptionsController@createNewOption')->name('options.createNewOption');
    Route::patch('update/{id}', 'OptionsController@updateOption')->name('options.updateOption');
    Route::delete('delete/{id}', 'OptionsController@deleteOption')->name('options.deleteOption');

});

// Menus routes
Route::group(['prefix' => 'menus/', 'namespace' => 'API'], function () {

    Route::get('', 'MenusController@getAllMenus')->name('menus.getAllMenus');
    Route::get('{id}', 'MenusController@getMenu')->name('menus.getMenu');
    Route::post('create', 'MenusController@createNewMenu')->name('menus.createNewMenu');
    Route::patch('update/{id}', 'MenusController@updateMenu')->name('menus.updateMenu');
    Route::delete('delete/{id}', 'MenusController@deleteMenu')->name('menus.deleteMenu');

});


// Categories routes
Route::group(['prefix' => 'categories/', 'namespace' => 'API'], function () {

    Route::get('', 'CategoriesController@getAllCategories')->name('categories.getAllCategories');
    Route::get('{id}', 'CategoriesController@getCategory')->name('categories.getCategory');
    Route::post('create', 'CategoriesController@createNewCategory')->name('categories.createNewCategory');
    Route::patch('update/{id}', 'CategoriesController@updateCategory')->name('categories.updateCategory');
    Route::delete('delete/{id}', 'CategoriesController@deleteCategory')->name('categories.deleteCategory');

});

// roles routes
Route::group(['prefix' => 'roles/', 'namespace' => 'API'], function () {

    Route::get('', 'RolesController@getAllRoles')->name('roles.getAllRoles');
    Route::get('{id}', 'RolesController@getRole')->name('roles.getRole');
    Route::post('create', 'RolesController@createNewRole')->name('roles.createNewRole');
    Route::patch('update/{id}', 'RolesController@updateRole')->name('roles.updateRole');
    Route::delete('delete/{id}', 'RolesController@deleteRole')->name('roles.deleteRole');
});


// products routes
Route::group(['prefix' => 'products/', 'namespace' => 'API'], function () {

    Route::get('', 'ProductsController@getAllProducts')->name('products.getAllProducts');
    Route::get('{id}', 'ProductsController@getProduct')->name('products.getProduct');
    Route::post('create', 'ProductsController@createNewProduct')->name('products.createNewProduct');
    Route::patch('update/{id}', 'ProductsController@updateProduct')->name('products.updateProduct');
    Route::delete('delete/{id}', 'ProductsController@deleteProduct')->name('products.deleteProduct');
});

// bought routes
Route::group(['prefix' => 'boughts/', 'namespace' => 'API'], function () {

    Route::get('', 'BoughtsController@getAllBoughts')->name('boughts.getAllBoughts');
    Route::get('{id}', 'BoughtsController@getBought')->name('boughts.getBought');
    Route::post('create', 'BoughtsController@createNewBought')->name('boughts.createNewBought');
    Route::patch('update/{id}', 'BoughtsController@updateBought')->name('boughts.updateBought');
    Route::delete('delete/{id}', 'BoughtsController@deleteBought')->name('boughts.deleteBought');
});

