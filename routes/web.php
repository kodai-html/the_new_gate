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

Route::get('/product/create','productController@showCreate')->name('create');

Route::post('/product/store','productController@exeStore')->name('store');

Route::get('/product/{id}','productController@showDetail')->name('detail');

Route::post('/product/search','productController@filterProductByKeywords')->name('search');

Auth::routes();

Route::get('/','productController@showList')->name('list');

Route::get('/product/edit/{id}','productController@showEdit')->name('edit');

Route::post('/product/update','productController@exeUpdate')->name('update');

Route::post('/product/delete','productController@exeDelete')->name('delete');

Route::post('/product/order/id','productController@sortID')->name('orderID');
