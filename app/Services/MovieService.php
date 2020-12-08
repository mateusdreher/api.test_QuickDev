<?php

namespace App\Services;

use Prophecy\Exception\Exception;
use Illuminate\Http\Response;
use App\Services\RequestService;
use App\Services\Filters\NameFilter;

class MovieService {

    private RequestService $request;
    private NameFilter $nameFilter;

    public function __construct(RequestService $request, NameFilter $nameFilter) {
        $this->request = $request;
        $this->nameFilter = $nameFilter;
    }

    public function getAllMovies() {
        $endpoint = 'discover/movie?api_key=4ec327e462149c3710d63be84b81cf4f&sort_by=popularity.desc&include_adult=false';

        $ret = $this->request->make($endpoint);

        $movies = $this->getMovieGenres(json_decode($ret)->results);         
        
        return $movies;
        
    }

    public function getMovieDetails(int $movieId) {
        $endpoint = 'movie/'. $movieId .'?api_key=4ec327e462149c3710d63be84b81cf4f';
        
        return $this->request->make($endpoint);

    }

    public function getMoviesByName(string $movieName) {
        $endpoint = 'discover/movie?api_key=4ec327e462149c3710d63be84b81cf4f&sort_by=popularity.desc&include_adult=false';

        $data = $this->request->make($endpoint);

        $movies = $this->nameFilter->filter(json_decode($data)->results, $movieName);

        return $this->getMovieGenres($movies);
    }

    public function getMoviesByGenre(int $genreId) {
        $endpoint = 'discover/movie?api_key=4ec327e462149c3710d63be84b81cf4f&sort_by=popularity.desc&include_adult=false&with_genres=' . $genreId;

        $data = $this->request->make($endpoint);

        return $this->getMovieGenres(json_decode($data)->results);

    }

    public function getGenres() {
        $endpoint = 'genre/movie/list?api_key=4ec327e462149c3710d63be84b81cf4f';

        return $this->request->make($endpoint);

    }

    private function getMovieGenres(array $movies) {
        $genreNames = [];
        $newMovies = [];

        try {
            $genresList = $this->getGenres();
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