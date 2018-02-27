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
    return view('welcome');
});

Route::resource('games', 'GameController');
Route::post('games/{game}/deal', 'GameController@deal')->name('games.deal');
Route::post('games/{game}/hit', 'GameController@hit')->name('games.hit');
Route::post('games/{game}/stand', 'GameController@stand')->name('games.stand');
Route::get('middleware-request', 'MiddlewareTestController@modifyRequest')->middleware('modify-request');
