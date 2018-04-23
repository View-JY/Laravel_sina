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

// ------ StaticPages
Route::get('/', 'StaticPagesController@home') ->name('home');
Route::get('help', 'StaticPagesController@help') ->name('help');
Route::get('about', 'StaticPagesController@about') ->name('about');

// ------ User
Route::get('signup', 'UsersController@create') ->name('signup');

Route::group(['prefix' => 'users'], function(){
    Route::get('/', 'UsersController@index') ->name('users.index');
    Route::get('/{user}', 'UsersController@show') ->name('users.show');
    Route::get('/create', 'UsersController@create') ->name('users.create');
    Route::post('/', 'UsersController@store') ->name('users.store');
    Route::get('/{user}/edit', 'UsersController@edit') ->name('users.edit');
    Route::patch('/{user}', 'UsersController@update') ->name('users.update');
    Route::delete('/{user}', 'UsersController@destroy') ->name('users.destroy');
});

// ------ Login
Route::get('login', 'SessionsController@create') ->name('login');
Route::post('login', 'SessionsController@store') ->name('login');
Route::delete('logout', 'SessionsController@destroy') ->name('logout');

Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

// ------ Password
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');