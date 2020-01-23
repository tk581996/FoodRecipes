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

Route::get('/index', 'PageController@getIndex');

Route::get('/login', 'PageController@getLogin');
Route::post('/login', 'PageController@postLogin');

Route::get('logout', 'PageController@getLogout');

Route::get('/itemdetail/{id}', 'PageController@getItemDetail');

Route::post('/itemdetail/comment/{id}', 'PageController@postComment');

Route::get('/register', 'PageController@getRegister');

Route::get('/inputform', 'PageController@getInputForm');
