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

Route::resource('word', 'WordsController');

Route::resource('user', 'UsersController');

Route::resource('home/follow', 'RelationshipsController');

Route::resource('activity', 'ActivitiesController');

Route::get('user/change-password/{id}', 'UsersController@getResetPasswordForm');

Route::get('user/following/{id}', 'UsersController@showFollowingUser');

Route::get('user/follower/{id}', 'UsersController@showUserFollowers');

Route::get('user/following-activities/{id}', 'ActivitiesController@showFollowingUserActivities');

Route::get('user/follower-activities/{id}', 'ActivitiesController@showUserFollowersActivities');

Route::post('user/change-password', 'ActivitiesController@resetPasssword');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::resource('/', 'AdminController');
    Route::group(['namespace' => 'Admin'], function () {
        Route::resource('users', 'UsersController');
        Route::resource('categories', 'CategoriesController');
        Route::resource('words', 'WordsController');
        Route::resource('lessons', 'LessonsController');
    });
});
