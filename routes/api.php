<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/token', 'AuthController@token');

Route::post('/signup', 'SignUpController@create');

Route::resource('/authors', 'AuthorsController', [
    'except' => ['create', 'edit'],
]);
