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

// Ktv reports
Route::get('ktvreports/datatables', 'KtvReportsController@datatables')->name('ktvreports.datatables');
Route::post('ktvreports/export', 'KtvReportsController@exportExcel')->name('ktvreports.exportExcel');
Route::resource('ktvreports', 'KtvReportsController');

// Ktv
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	Route::get('/ktvs/datatables', 'KtvsController@datatables')->name('ktvs.datatables');
	Route::get('/ktvs/get-districts', 'KtvsController@getDistricts')->name('ktvs.getdistricts');
	Route::resource('ktvs', 'KtvsController');
});

// Statistics
Route::get('/statistics/import-data-usage', 'ImportController@index')->name('statistics.import');
Route::post('/statistics/import-data-usage', 'ImportController@importDataUsages');
