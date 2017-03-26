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


Route::get('/create', 'ActionsController@create')->middleware('admin');
Route::post('/ideti', 'ActionsController@store')->middleware('admin');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::post('/test', 'TestController@test');

Route::get('/test2', 'TestController@test2');

Route::get('/test3', 'TestController@test3');

Route::get('/test4', 'TestController@test4');
Route::post('/upload_data', 'TestController@upload_data');



