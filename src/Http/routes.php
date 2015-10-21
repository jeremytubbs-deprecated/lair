<?php

if (config('lair.routes.login')) {
    // Authentication routes...
    Route::get('auth/login', 'App\Http\Controllers\Auth\AuthController@getLogin');
    Route::post('auth/login', 'App\Http\Controllers\Auth\AuthController@postLogin');
    Route::get('auth/logout', 'App\Http\Controllers\Auth\AuthController@getLogout');
}

if (config('lair.routes.register')) {
    // Registration routes...
    Route::get('auth/register', 'App\Http\Controllers\Auth\AuthController@getRegister');
    Route::post('auth/register', 'App\Http\Controllers\Auth\AuthController@postRegister');
}