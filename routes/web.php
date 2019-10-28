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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::redirect('/', '/login');
Route::get('/kak', function () {
    return view('layouts.master3');
});

Auth::routes();

Route::get('/user/addserver', 'ServerController@create')->name('createserver');
//Route::get('/home', 'HomeController@index')->name('home');
Route::redirect('/home', '/dashboard')->middleware('auth');
Route::get('/dashboard', 'UserController@show')->middleware('auth');
Route::get('/servers/overview', 'ServerController@index')->middleware('auth')->name('server_overview');
Route::get('/servers/create', 'ServerController@create')->middleware('auth')->name('get_create_server');
Route::post('/servers/create', 'ServerController@store')->middleware('auth')->name('post_create_server');
Route::get('/servers/edit/{id}', 'ServerController@edit')->middleware('auth')->name('get_edit_server');
Route::post('/servers/edit/{id}', 'ServerController@update')->middleware('auth')->name('post_edit_server');
Route::post('/servers/delete', 'ServerController@store')->middleware('auth')->name('delete_server');
