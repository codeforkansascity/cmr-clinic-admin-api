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



Auth::routes(['verify' => true, 'register' => false]);


Route::group(['middleware' => 'auth'], function () {


    Route::get('/api-client', 'ClientApi@index');
    Route::get('/api-client/options', 'ClientApi@getOptions');
    Route::get('/client/download', 'ClientController@download');
    Route::resource('/client', 'ClientController');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/changePassword','HomeController@showChangePasswordForm');
    Route::post('/changePassword','HomeController@changePassword')->name('changePassword');



});



Route::get('/api-client', 'ClientApi@index');
Route::get('/api-client/options', 'ClientApi@getOptions');
Route::get('/client/download', 'ClientController@download')->name('client.download');
Route::get('/client/print', 'ClientController@print')->name('client.print');
Route::resource('/client', 'ClientController');