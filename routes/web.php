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
Route::get('/api-status', 'StatusApi@index');
Route::get('/api-status/options', 'StatusApi@getOptions');
Route::get('/status/download', 'StatusController@download')->name('status.download');
Route::get('/status/print', 'StatusController@print')->name('status.print');
Route::resource('/status', 'StatusController');
Route::get('/api-assignment', 'AssignmentApi@index');
Route::get('/api-assignment/options', 'AssignmentApi@getOptions');
Route::get('/assignment/download', 'AssignmentController@download')->name('assignment.download');
Route::get('/assignment/print', 'AssignmentController@print')->name('assignment.print');
Route::resource('/assignment', 'AssignmentController');