<?php

namespace App\Services\Filters;
use App\Services\Filters\IFilter;


class NameFilter implements IFilter {

    public function filter($data, $param) {
        $moviesList = [];

        $param = str_replace('%20', ' ', $param);        

        foreach($data as $movie) {
            $comp = strcasecmp($movie->title, $param);
            if ($comp === 0) {
                array_push($moviesList, $movie);
            }
        }

        return $moviesList;
    }
}