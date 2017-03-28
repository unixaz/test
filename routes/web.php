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


Route::get('/create', 'ActionsController@create')->middleware('admin_professor');
Route::get('/addVideo', 'ActionsController@addVideo')->middleware('admin_professor');
Route::post('/addVideo', 'ActionsController@storeVideo')->middleware('admin_professor');
Route::get('/myVideos', 'ActionsController@myVideos')->middleware('admin_professor');
Route::get('/createPlaylist', 'ActionsController@createPlaylist')->middleware('admin_professor');

Route::post('/ideti', 'ActionsController@store')->middleware('admin');
Route::get('/confirm', 'ActionsController@confirm')->middleware('admin');
Route::get('/confirm2/{action}/{id}', 'ActionsController@confirm2')->middleware('admin');
Route::get('/upload', 'ActionsController@upload')->middleware('admin');
Route::post('/upload_data', 'ActionsController@upload_data')->middleware('admin');

Auth::routes();

Route::get('/', 'HomeController@index');

Route::post('/test', 'TestController@test');

Route::get('/test2', 'TestController@test2');


Route::get('/test4', 'TestController@test4');



