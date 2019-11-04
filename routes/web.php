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


Route::redirect('/', '/login');

Auth::routes();

Route::get('/user/addserver', 'ServerController@create')->name('createserver');
//Route::get('/home', 'HomeController@index')->name('home');
Route::redirect('/home', '/dashboard')->middleware('auth');
Route::get('/dashboard', 'UserController@show')->middleware('auth');
Route::get('/servers/overview', 'ServerController@index')->middleware('auth')->name('server_overview');
Route::get('/preferences', 'PreferenceController@show')->middleware('auth')->name('preferences');
Route::post('/preferences', 'PreferenceController@update')->middleware('auth')->name('preferences');
Route::get('/servers/create', 'ServerController@create')->middleware('auth')->name('get_create_server');
Route::post('/servers/create', 'ServerController@store')->middleware('auth')->name('post_create_server');
Route::get('/servers/edit/{id}', 'ServerController@edit')->middleware('auth')->name('get_edit_server');
Route::post('/servers/edit/{id}', 'ServerController@update')->middleware('auth')->name('post_edit_server');
Route::post('/servers/delete', 'ServerController@destroy')->middleware('auth')->name('delete_server');
Route::get('/servers/{id}', 'ServerController@show')->middleware('auth')->name('detail_server');

Route::get('/scans/overview', 'ScanController@index')->middleware('auth')->name('scan_overview');
Route::get('/scans/create', 'ScanController@create')->middleware('auth')->name('get_create_scan');
Route::post('/scans/create', 'ScanController@store')->middleware('auth')->name('post_create_scan');
Route::get('/scans/edit/{id}', 'ScanController@edit')->middleware('auth')->name('get_edit_scan');
Route::post('/scans/edit/{id}', 'ScanController@update')->middleware('auth')->name('post_edit_scan');
Route::post('/scans/delete', 'ScanController@destroy')->middleware('auth')->name('delete_scan');
Route::get('/scans/{id}', 'ScanController@show')->middleware('auth')->name('detail_scan');
Route::post('/scans/start/{id}', 'ScanController@start')->middleware('auth')->name('post_start_scan');
