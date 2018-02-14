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
Route::get('/', 'HomeController@index');
Route::get('/login', ['as'=>'login', 'uses'=>'UserController@getLogin']);
Route::get('/logout','UserController@getLogout');
Route::post('/login', ['as'=>'login', 'uses'=>'UserController@postSignin']);
Route::get('/set_theme/{any}', 'HomeController@set_theme');
Route::get('home/load','HomeController@getLoad');


include('module.php');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', function () {
        return view('layouts.app');
    });
});


Route::group(['namespace' => 'katana','middleware' => 'auth'], function () {
    include('katana.php');
});

Route::group(['namespace' => 'Core','middleware' => 'auth'], function () {
    include('core.php');
});

