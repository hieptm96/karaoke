<?php

Route::get('/', function () {
    return view('layouts.app');
})->middleware('auth');

Auth::routes();
Route::get('/sample-users', 'SampleUsersController@index');

Route::group(['middleware' => ['auth', 'acl']], function () {
    Route::get('/home', 'HomeController@index')->name('home.index');

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
    Route::get('/ktvreports/fee', 'KtvReportsController@fee')->name('ktvreports.fee');
    Route::resource('ktvreports', 'KtvReportsController');

    //Roles
    Route::get('roles/{id}/permissions', 'RolePermissionsController@index')->name('rolePermissions.index');
    Route::put('roles/{id}/permissions', 'RolePermissionsController@update')->name('rolePermissions.update');
    Route::resource('roles', 'RolesController');

//Permissions
    Route::get('permissions/sync', 'PermissionsController@sync')->name('permissions.sync');
    Route::resource('permissions', 'PermissionsController');

// Statistics
    Route::get('/import-data-usages', 'ImportController@index')->name('importDataUsages.index');
    Route::post('/import-data-usages', 'ImportController@importDataUsages')->name('importDataUsages.import');

// Songs
    Route::get('/contentowner/{id}/datatables', 'ContentOwnerSongController@datatables')->name('contentowner.datatables');
    Route::get('/contentowner/{id}', 'ContentOwnerSongController@index');

    Route::get('/contentowner-reports/datatables', 'ContentOwnerReportController@datatables')->name('contentOwnerReport.datatables');
    Route::get('/contentowner-reports/{id}/datatables', 'ContentOwnerReportController@detailDatatables')->name('contentOwnerDetailReport.datatables');
    Route::post('/contentowner-reports/export', 'ContentOwnerReportController@exportExcel')->name('contentOwnerReport.exportExcel');
    Route::resource('/contentowner-reports', 'ContentOwnerReportController');

    // Content Owners report
    Route::get('/contentowner-reports/datatables', 'ContentOwnerReportController@datatables')->name('contentOwnerReport.datatables');
    Route::get('/contentowner-reports/{id}/datatables', 'ContentOwnerReportController@detailDatatables')->name('contentOwnerDetailReport.datatables');
    Route::post('/contentowner-reports/export', 'ContentOwnerReportController@exportExcel')->name('contentOwnerReport.exportExcel');
    Route::resource('/contentowner-reports', 'ContentOwnerReportController');

    // Songs report
    Route::get('/song-reports/datatables', 'SongReportController@datatables')->name('songReport.datatables');
    Route::get('/song-reports/{id}/datatables', 'SongReportController@detailDatatables')->name('songDetailReport.datatables');
    Route::resource('/song-reports', 'SongReportController');

});


Route::group(['prefix' => 'admin', 'middleware' => ['role:admin', 'acl']], function() {
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

    // User
    Route::get('/users/datatables', 'UsersController@datatables')->name('users.datatables');
    Route::resource('users', 'UsersController');

});
