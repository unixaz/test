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

Auth::routes();

Route::group(['middleware' => ['admin']], function () {
    Route::get('/confirmUser', 'ActionsController@confirmUser');
    Route::get('/confirmUser2/{action}/{id}', 'ActionsController@confirmUser2');

    Route::get('/changeOwner', 'ActionsController@changeOwner');
    Route::post('/changeOwner', 'ActionsController@changeOwner2');

    Route::get('/deleteVideo', 'ActionsController@deleteVideo');
    Route::post('/deleteVideo', 'ActionsController@deleteVideo2');

    Route::get('/upload', 'ActionsController@upload');
    Route::post('/upload_data', 'ActionsController@upload_data');

    Route::get('/writeNews', 'ActionsController@writeNews');
    Route::post('/writeNews', 'ActionsController@writeNews2');

    Route::get('/addVideo', 'ActionsController@addVideo');
    Route::post('/addVideo', 'ActionsController@addVideo2');
});

Route::group(['middleware' => ['admin_professor']], function () {
    Route::get('/changePrivacy', 'ActionsController@changePrivacy');
    Route::post('/changePrivacy', 'ActionsController@changePrivacy2');

    Route::get('/videoPermissions', 'ActionsController@videoPermissions');
    Route::get('/videoPermissions2/{id}', 'ActionsController@videoPermissions2');
    Route::post('/videoPermissions3/{id}', 'ActionsController@videoPermissions3');

});

Route::get('/myVideos', 'ActionsController@myVideos')->middleware('admin_professor');

Route::get('/createPlaylist', 'ActionsController@createPlaylist')->middleware('admin_professor');
Route::post('/createPlaylist', 'ActionsController@storePlaylist')->middleware('admin_professor');

Route::get('/assignPlaylist', 'ActionsController@assignPlaylist')->middleware('admin_professor');
Route::post('/assignPlaylist', 'ActionsController@storeAssignPlaylist')->middleware('admin_professor');

Route::get('/deletePlaylist', 'ActionsController@deletePlaylist')->middleware('admin_professor');
Route::post('/deletePlaylist', 'ActionsController@storeDeletePlaylist')->middleware('admin_professor');

Route::get('/videoPlaylist/{id}', 'ActionsController@videoPlaylist');


Route::get('/videoList', 'ActionsController@videoList');
Route::get('/playlistList', 'ActionsController@playlistList');
Route::get('/watch/{id}', 'ActionsController@watchVideo');
Route::post('/addComment/{id}', 'ActionsController@addComment');

Route::get('/sortPlaylist', 'ActionsController@sortPlaylist');
Route::post('/sortPlaylist2', 'ActionsController@sortPlaylist2');


Route::get('/', 'HomeController@index');

Route::post('/test', 'TestController@test');

Route::get('/test2', 'TestController@test2');


Route::get('/test4', 'TestController@test4');




