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

Route::group(['namespace' => 'Admin'], function () {

    // admin home / index page
    Route::get('/admin', 'HomeController@index')->name('admin.home');

    //users routes
    Route::group(['prefix' => 'users/'], function () {
        Route::get('', 'UserController@getIndex')->name('admin.users.getIndex');
        Route::get('get-create', 'UserController@getCreateNewUser')->name('admin.users.getCreateNewUser');
        Route::post('create', 'UserController@createNewUser')->name('admin.users.createNewUser');
        Route::get('get-update/{id}', 'UserController@getUpdateUser')->name('admin.users.getUpdateUser');
        Route::post('post-update/{id}', 'UserController@UpdateUser')->name('admin.users.updateUser');
        Route::delete('delete/{id}', 'UserController@deleteUser')->name('admin.users.deleteUser');
    });

    //addresses routes
    Route::group(['prefix' => 'addresses/'], function () {
        Route::get('', 'AddressesController@getIndex')->name('admin.addresses.getIndex');
        Route::get('get-create', 'AddressesController@getCreateNewAddress')->name('admin.addresses.getCreateNewAddress');
        Route::post('create', 'AddressesController@createNewAddress')->name('admin.addresses.createNewAddress');
        Route::get('get-update/{id}', 'AddressesController@getUpdateAddress')->name('admin.addresses.getUpdateAddress');
        Route::post('post-update', 'AddressesController@UpdateAddress')->name('admin.addresses.updateAddress');
        Route::delete('delete/{id}', 'AddressesController@deleteAddress')->name('admin.addresses.deleteAddress');
        Route::get('get-add-city-templates', 'AddressesController@getAddCitiesTemplate')->name('get-add-city-templates');
        Route::get('get-add-city-templates-for-edit', 'AddressesController@getAddCitiesTemplateInEdit')->name('get-add-city-templates-for-edit');
        Route::get('delete-city/{id}', 'AddressesController@deleteCity')->name('delete-city');
    });

    //roles routes
    Route::group(['prefix' => 'roles/'], function () {
        Route::get('', 'RolesController@getIndex')->name('admin.roles.getIndex');
        Route::get('get-create', 'RolesController@getCreateNewRole')->name('admin.roles.getCreateNewRole');
        Route::post('create', 'RolesController@createNewRole')->name('admin.roles.createNewRole');
        Route::get('get-update/{id}', 'RolesController@getUpdateRole')->name('admin.roles.getUpdateRole');
        Route::post('post-update', 'RolesController@UpdateRole')->name('admin.roles.updateRole');
        Route::delete('delete/{id}', 'RolesController@deleteRole')->name('admin.roles.deleteRole');
    });

    //menus routes
    Route::group(['prefix' => 'menus/'], function () {
        Route::get('', 'MenusController@getIndex')->name('admin.menus.getIndex');
        Route::get('get-create', 'MenusController@getCreateNewMenu')->name('admin.menus.getCreateNewMenu');
        Route::post('create', 'MenusController@createNewMenu')->name('admin.menus.createNewMenu');
        Route::get('get-update/{id}', 'MenusController@getUpdateMenu')->name('admin.menus.getUpdateMenu');
        Route::post('post-update', 'MenusController@UpdateMenu')->name('admin.menus.updateMenu');
        Route::delete('delete/{id}', 'MenusController@deleteMenu')->name('admin.menus.deleteMenu');
    });

    //categories routes
    Route::group(['prefix' => 'categories/'], function () {
        Route::get('', 'CategoriesController@getIndex')->name('admin.categories.getIndex');
        Route::get('get-create', 'CategoriesController@getCreateNewCategory')->name('admin.categories.getCreateNewCategory');
        Route::post('create', 'CategoriesController@createNewCategory')->name('admin.categories.createNewCategory');
        Route::get('get-update/{id}', 'CategoriesController@getUpdateCategory')->name('admin.categories.getUpdateCategory');
        Route::post('post-update/{id}', 'CategoriesController@updateCategory')->name('admin.categories.updateCategory');
        Route::delete('delete/{id}', 'CategoriesController@deleteCategory')->name('admin.categories.deleteCategory');
    });

    //option routs
    Route::group(['prefix' => 'options/'], function () {
        Route::get('', 'OptionsController@getIndex')->name('admin.options.getIndex');
        Route::get('get-create', 'OptionsController@getCreateNewOption')->name('admin.options.getCreateNewOption');
        Route::post('create', 'OptionsController@createNewOption')->name('admin.options.createNewOption');
        Route::get('get-update/{id}', 'OptionsController@getUpdateOption')->name('admin.options.getUpdateOption');
        Route::post('post-update/{id}', 'OptionsController@updateOption')->name('admin.options.updateOption');
        Route::delete('delete/{id}', 'OptionsController@deleteOption')->name('admin.options.deleteOption');
        Route::post('delete-value/{id}', 'OptionsController@deleteOptionValue')->name('admin.options.deleteOptionValue');
    });

    //products routes
    Route::group(['prefix' => 'products/'], function () {
        Route::get('', 'ProductsController@getIndex')->name('admin.products.getIndex');
        Route::get('get-create', 'ProductsController@getCreateNewProduct')->name('admin.products.getCreateNewProduct');
        Route::post('create', 'ProductsController@createNewProduct')->name('admin.products.createNewProduct');
        Route::get('get-update/{id}', 'ProductsController@getUpdateProduct')->name('admin.products.getUpdateProduct');
        Route::post('post-update/{id}', 'ProductsController@updateProduct')->name('admin.products.updateProduct');
        Route::delete('delete/{id}', 'ProductsController@deleteProduct')->name('admin.products.deleteProduct');
    });


    //boughts routes
    Route::group(['prefix' => 'boughts/'], function () {
        Route::get('', 'BoughtsController@getIndex')->name('admin.boughts.getIndex');
        Route::get('get-create', 'BoughtsController@getCreateNewBought')->name('admin.boughts.getCreateNewBought');
        Route::post('create', 'BoughtsController@createNewBought')->name('admin.boughts.createNewBought');
        Route::get('bought-section', 'BoughtsController@getBoughtSectionView')->name('admin.boughts.getBoughtSectionView');
        Route::get('option-section', 'BoughtsController@getOptionSectionView')->name('admin.boughts.getOptionSectionView');
        Route::get('option-section0', 'BoughtsController@getOptionSectionView0')->name('admin.boughts.getOptionSectionView0');
        Route::get('get-update/{id}', 'BoughtsController@getUpdateBought')->name('admin.boughts.getUpdateBought');
        Route::post('post-update/{id}', 'BoughtsController@updateBought')->name('admin.boughts.updateBought');
        Route::delete('delete/{id}', 'BoughtsController@deleteBought')->name('admin.boughts.deleteBought');

        Route::get('option-values/{id}', 'BoughtsController@getOptionValues')->name('admin.boughts.getOptionValues');
    });

});
