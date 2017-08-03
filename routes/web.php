<?php

Route::get('/', function () {
    return view('layouts.app');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/sample-users', 'SampleUsersController@index');

// Profile
Route::resource('profiles', 'ProfilesController', ['only' => ['index', 'update']]);

// Songs
Route::get('songs/datatables', 'SongsController@datatables')->name('songs.datatables');
Route::resource('songs', 'SongsController');

// Singers
Route::get('singers/datatables', 'SingersController@datatables')->name('singers.datatables');
Route::resource('singers', 'SingersController');

// Ktv reports
Route::get('ktvreports/datatables', 'KtvReportsController@datatables')->name('ktvreports.datatables');
Route::get('ktvreports/detail-datatables', 'KtvReportsController@detailDatatables')->name('ktvreports.detailDatatables');
Route::post('ktvreports/export', 'KtvReportsController@exportExcel')->name('ktvreports.exportExcel');
Route::get('/ktvreports/get-districts', 'KtvReportsController@getDistricts')->name('ktvreports.getdistricts');
Route::resource('ktvreports', 'KtvReportsController');

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
    // Ktv
	Route::get('/ktvs/datatables', 'KtvsController@datatables')->name('ktvs.datatables');
	Route::get('/ktvs/get-districts', 'KtvsController@getDistricts')->name('ktvs.getdistricts');
	Route::resource('ktvs', 'KtvsController');

	// Content Owner
    Route::get('/contentowners/datatables', 'ContentOwnersController@datatables')->name('contentowners.datatables');
    Route::get('/contentowners/get-districts', 'ContentOwnersController@getDistricts')->name('contentowners.getdistricts');
    Route::resource('contentowners', 'ContentOwnersController');

    // Config
    Route::resource('configs', 'ConfigsController', ['only' => ['index', 'update']]);
});

// Statistics
Route::get('/statistics/import-data-usage', 'ImportController@index')->name('statistics.import');
Route::post('/statistics/import-data-usage', 'ImportController@importDataUsages');
