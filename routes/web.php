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

    Route::post('/newsAction/{id}', 'ActionsController@newsAction');
    Route::get('/updateNews/{id}', 'ActionsController@updateNews');
    Route::post('/updateNews/{id}', 'ActionsController@updateNews2');

    Route::post('/deleteComment/{id}', 'ActionsController@deleteComment');
});

Route::group(['middleware' => ['admin_professor']], function () {

    Route::get('/changePrivacy', 'ActionsController@changePrivacy');
    Route::post('/changePrivacy', 'ActionsController@changePrivacy2');

    Route::get('/videoPermissions', 'ActionsController@videoPermissions');
    Route::get('/videoPermissions2/{id}', 'ActionsController@videoPermissions2');
    Route::post('/videoPermissions3/{id}', 'ActionsController@videoPermissions3');

    Route::get('/myVideos', 'ActionsController@myVideos');

    Route::get('/createPlaylist', 'ActionsController@createPlaylist');
    Route::post('/createPlaylist', 'ActionsController@createPlaylist2');

    Route::get('/assignPlaylist', 'ActionsController@assignPlaylist');
    Route::post('/assignPlaylist', 'ActionsController@assignPlaylist2');

    Route::get('/deletePlaylist', 'ActionsController@deletePlaylist');
    Route::post('/deletePlaylist', 'ActionsController@deletePlaylist2');

    Route::get('/changeVideoOrder', 'ActionsController@changeVideoOrder');
    Route::get('/changeVideoOrder2/{id}', 'ActionsController@changeVideoOrder2');
    Route::post('/changeVideoOrder3', 'ActionsController@changeVideoOrder3');
});

Route::group(['middleware' => ['confirmed_user']], function () {

    Route::post('/addComment/{id}', 'ActionsController@addComment');

});

    Route::get('/', 'ActionsController@index');
    Route::get('/videoPlaylist/{id}', 'ActionsController@videoPlaylist');
    Route::get('/videoList', 'ActionsController@videoList');
    Route::get('/playlistList', 'ActionsController@playlistList');
    Route::get('/watch/{id}', 'ActionsController@watchVideo');
    Route::get('/professorsList', 'ActionsController@professorsList');
    Route::get('/professorsList2/{id}', 'ActionsController@professorsList2');

