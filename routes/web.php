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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware(['auth'])->group(function () {

    Route::get('/orders/required_materials', 'OrderController@listRequired')->name('orders.required_materials');

    Route::resource('orders', 'OrderController');

    Route::resource('carts', 'CartController');

    Route::resource('materials', 'MaterialController');

    Route::resource('products', 'ProductController');

    Route::get('/product/{id}/materials/search', 'ProductController@searchMaterials')->name('products.search_material');

    Route::get('/product/{id}/materials', 'ProductController@addMaterialsPage')->name('products.add_material');

    Route::post('/product/{id}/materials', 'ProductController@addMaterials')->name('products.add_material');

    Route::post('/product/{id}/remove_material', 'ProductController@removeMaterial')->name('products.remove_material');

});


