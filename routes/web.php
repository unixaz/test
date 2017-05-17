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

    Route::get('/deletePrivateVideo', 'ActionsController@deletePrivateVideo');
    Route::post('/deletePrivateVideo', 'ActionsController@deletePrivateVideo2');

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

    Route::get('/updateVideoInfo/{id}', 'ActionsController@updateVideoInfo');
    Route::post('/updateVideoInfo2/{id}', 'ActionsController@updateVideoInfo2');

    Route::get('/toggleStreaming', 'ActionsController@toggleStreaming');

    Route::get('/uploadPrivate', 'ActionsController@uploadPrivate');
    Route::post('/uploadPrivate2', 'ActionsController@uploadPrivate2');
    Route::post('/uploadPrivate3', 'ActionsController@uploadPrivate3');

    Route::get('/ajax/professorsList', 'ActionsController@getProfessorsList');
    Route::get('/ajax/videosList', 'ActionsController@getVideosList');
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

    Route::get('/assignToPlaylist', 'ActionsController@assignToPlaylist');
    Route::post('/assignToPlaylist', 'ActionsController@assignToPlaylist2');

    Route::get('/deleteFromPlaylist', 'ActionsController@deleteFromPlaylist');
    Route::get('/deleteFromPlaylist2/{id}', 'ActionsController@deleteFromPlaylist2');
    Route::post('/deleteFromPlaylist3/{id}', 'ActionsController@deleteFromPlaylist3');

    Route::get('/deletePlaylist', 'ActionsController@deletePlaylist');
    Route::post('/deletePlaylist', 'ActionsController@deletePlaylist2');

    Route::get('/changeVideoOrder', 'ActionsController@changeVideoOrder');
    Route::get('/changeVideoOrder2/{id}', 'ActionsController@changeVideoOrder2');
    Route::post('/changeVideoOrder3', 'ActionsController@changeVideoOrder3');
});

Route::group(['middleware' => ['confirmed_user']], function () {

    Route::post('/addComment/{id}', 'ActionsController@addComment');
    Route::post('/starVideo', 'ActionsController@starVideo');

});

    Route::get('/', 'ActionsController@index');
    Route::get('/videoPlaylist/{id}', 'ActionsController@videoPlaylist');
    Route::get('/videoList', 'ActionsController@videoList');
    Route::get('/playlistList', 'ActionsController@playlistList');
    Route::get('/watch/{id}', 'ActionsController@watchVideo');
    Route::get('/professorsList', 'ActionsController@professorsList');
    Route::get('/professorsList2/{id}', 'ActionsController@professorsList2');
    Route::post('/searchByDifficulty', 'ActionsController@searchByDifficulty');
    Route::post('/searchByTag', 'ActionsController@searchByTag');
    Route::get('/sortByLikes', 'ActionsController@sortByLikes');
    Route::get('/privateVideo/{filename}', 'ActionsController@watchPrivate')->name('watchPrivate');

