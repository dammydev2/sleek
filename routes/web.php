<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes(['verify' => true]);


Route::get('/item', 'HomeController@item');
Route::get('/sales', 'SalesController@sales');
Route::get('/payment', 'SalesController@payment');
Route::get('/live_search/action', 'SalesController@action')->name('live_search.action');
Route::get('/pagination/fetch_data', 'HomeController@fetch_data');
Route::get('/deleteItem/{id}', 'HomeController@deleteItem');
Route::get('/addStockItem/{id}', 'HomeController@addStockItem');


// Route::get('/item', 'HomeController@item')->name('item');
Route::post('/addItem', 'HomeController@addItem')->name('addItem');
Route::post('/itemExist', 'HomeController@itemExist');
Route::post('/saleEnter', 'SalesController@saleEnter')->name('saleEnter');
Route::post('/enterStock', 'HomeController@enterStock')->name('enterStock');