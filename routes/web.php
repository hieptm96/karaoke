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
    return view('layouts.app');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/sample-users', 'SampleUsersController@index');

// Songs
Route::get('songs/datatables', 'SongsController@datatables')->name('songs.datatables');
Route::resource('songs', 'SongsController');

// Singers
Route::get('singers/datatables', 'SingersController@datatables')->name('singers.datatables');
Route::resource('singers', 'SingersController');