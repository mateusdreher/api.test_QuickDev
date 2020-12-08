<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Response;
use App\Services\RequestService;
use App\Services\Filters\NameFilter;
use App\Services\Filters\GenreFilter;

class MovieService {

    private RequestService $request;
    private NameFilter $nameFilter;
    private GenreFilter $genreFilter;

    public function __construct(RequestService $request, NameFilter $nameFilter, GenreFilter $genreFilter) {
        $this->request = $request;
        $this->nameFilter = $nameFilter;
        $this->genreFilter = $genreFilter;
    }

    public function getAllMovies() {
        $endpoint = 'discover/movie?api_key=4ec327e462149c3710d63be84b81cf4f&sort_by=popularity.desc&include_adult=false';

        try {
            $ret = $this->request->make($endpoint);

            $movies = $this->getMovieGenres(json_decode($ret)->results);         
            
            return $movies;
        } catch (Exception $exception) {
            return response()->json(Response::HTTP_INTERNAL_SERVER_ERROR, 'Erro');
        }
        
    }

    public function getMovieDetails(int $movieId) {

        try {

            return $this->request->make($movieId);
        
        } catch (Exception $exception) {
            return response()->json(Response::HTTP_INTERNAL_SERVER_ERROR, 'Erro');
        }

    }

    public function getMoviesByName(string $movieName) {
        $endpoint = 'discover/movie?api_key=4ec327e462149c3710d63be84b81cf4f&sort_by=popularity.desc&include_adult=false';

        try {
            $data = $this->request->make($endpoint);

            $movies = $this->nameFilter->filter(json_decode($data)->results, $movieName);

            return $this->getMovieGenres($movies);
        
        } catch (Exception $exception) {
            return response()->json(Response::HTTP_INTERNAL_SERVER_ERROR, 'Erro');
        }
    }

    public function getMoviesByGenre(int $genreId) {

    }

    private function getMovieGenres(array $movies) {
        $endpoint = 'genre/movie/list?api_key=4ec327e462149c3710d63be84b81cf4f&language=en-US';
        $genreNames = [];
        $newMovies = [];

        try {

            $genresList = $this->request->make($endpoint);

            foreach ($movies as $movie => $movieInfos) {
                $genreNames = [];
                foreach($movieInfos->genre_ids as $movieInfoGenreId) {
                    foreach(json_decode($genresList) as $genre => $genresListInfos) {
                        foreach($genresListInfos as $genre => $genreListInfosInfo) {
                            if($movieInfoGenreId === $genreListInfosInfo->id) {
                                array_push($genreNames, $genreListInfosInfo->name);
                            }
                        }
                        $movieInfos->genre_names = $genreNames;
                    }
                    
                }
                array_push($newMovies, $movieInfos);
            }
            
            return $newMovies;
        
        } catch (Exception $exception) {
            return response()->json(Response::HTTP_INTERNAL_SERVER_ERROR, 'Erro');
        }
    }
}