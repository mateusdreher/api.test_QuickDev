<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => '/api/movies'], function() use($router){
    $router->get('', 'MovieController@getAllMovies');
    $router->get('/{movieId}', 'MovieController@getMovieDetails');
    $router->get('/name/{movieName}', 'MovieController@getMoviesByName');
    $router->get('/genre/{genre}', 'MovieController@getMoviesByGenre');
});

$router->get('/', function () use ($router) {
    return 'teste';
});

