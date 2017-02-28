<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->post('/api/auth/token', 'AuthController@token');

$app->post('/api/signup', 'SignUpController@create');

$app->group([
    'prefix' => '/api/authors',
], function () use ($app) {
    $app->get('/', 'AuthorsController@index');
    $app->post('/', 'AuthorsController@store');
    $app->get('/{id}', 'AuthorsController@show');
    $app->put('/{id}', 'AuthorsController@update');
    $app->delete('/{id}', 'AuthorsController@destroy');
});

$app->group([
    'prefix' => '/api/books',
], function () use ($app) {
    $app->get('/', 'BooksController@index');
    $app->post('/', 'BooksController@store');
    $app->get('/{id}', 'BooksController@show');
    $app->put('/{id}', 'BooksController@update');
    $app->delete('/{id}', 'BooksController@destroy');
});
