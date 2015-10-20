<?php

// Authentication routes...
Route::get('auth/login', 'App\Http\Controllers\Auth\AuthController@getLogin');
Route::post('auth/login', 'App\Http\Controllers\Auth\AuthController@postLogin');
Route::get('auth/logout', 'App\Http\Controllers\Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'App\Http\Controllers\Auth\AuthController@getRegister');
Route::post('auth/register', 'App\Http\Controllers\Auth\AuthController@postRegister');