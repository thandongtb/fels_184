<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->middleware('user');

Auth::routes();

Route::get('/home', 'HomeController@index')->middleware('user');

Route::get('social/redirect/{type}', 'Auth\LoginController@redirectToProvider');

Route::get('social/callback/{driver}', 'Auth\LoginController@handleProviderCallback');

Route::resource('lesson', 'LessonsController');

Route::resource('result', 'ResultsController');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::resource('/', 'AdminController');
    Route::group(['namespace' => 'Admin'], function () {
        Route::resource('users', 'UsersController');
        Route::resource('categories', 'CategoriesController');
        Route::resource('words', 'WordsController');
    });
});
