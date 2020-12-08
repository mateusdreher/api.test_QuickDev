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
    $router->get('/details/{movieId}', 'MovieController@getMovieDetails');
    $router->get('/genres', 'MovieController@getGenres'); 
    $router->get('/filter/genre/{genreId}', 'MovieController@getMoviesByGenre');
    $router->get('/filter/name/{movieName}', 'MovieController@getMoviesByName');
});

$router->get('/', function () use ($router) {
    return 'teste';
});

