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
Route::get('/product/get', 'HomeController@getProducts')->name('getProducts');
Route::get('/product/add', 'HomeController@addProduct')->name('getAddProduct');
Route::get('/product/edit', 'HomeController@editProduct')->name('getEditProduct');
Route::get('/product/delete', 'HomeController@deleteProduct')->name('getDeleteProduct');