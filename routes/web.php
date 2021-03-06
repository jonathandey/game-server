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

Route::get('/crimes', 'Game\CrimeController@index');
Route::post('/crimes', 'Game\CrimeController@commit');

Route::get('/autoburglary', 'Game\AutoBurglaryController@index');
Route::post('/autoburglary', 'Game\AutoBurglaryController@commit');

Route::get('/vehicles', 'Game\StolenVehiclesController@index');
Route::post('/vehicles', 'Game\StolenVehiclesController@manage');

Route::get('/gym', 'Game\GymController@index');
Route::post('/gym', 'Game\GymController@commit');
Route::post('/gym/fight', 'Game\BoxingController@create');
Route::post('/gym/fight/match', 'Game\BoxingController@fight');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
