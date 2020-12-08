<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;



class MovieController extends Controller
{
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {   
        $this->movieService = $movieService;
    }

    
    public function getAllMovies() {
        return $this->movieService->getAllMovies();
    }

    public function getMovieDetails (int $movieId) {
        return $this->movieService->getMovieDetails($movieId);
    }

    public function getMoviesByName (string $movieName) {
        return $this->movieService->getMoviesByName($movieName);
    }

    public function getMoviesByGenre (int $genreId) {
        return $this->movieService->getMoviesByGenre($genreId);
    }
}
