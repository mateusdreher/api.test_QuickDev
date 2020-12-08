<?php

namespace App\Services;
use Illuminate\Http\Response;
use Prophecy\Exception\Exception;

class RequestService {

    private const BASE_URI = 'https://api.themoviedb.org/3';

    public function make(string $endpoint) {

        try {
            $url = self::BASE_URI . '/' . $endpoint;
            $context = stream_context_create(array(
                'http' => array(
                    'method' => 'GET',
                    'header' => 'Content-Type: application/json'
                )
            ));

        
        return file_get_contents($url, null, $context);
        } catch (Exception $exception) {
            return response()->json(Response::HTTP_INTERNAL_SERVER_ERROR, 'Erro');
        }
        
        
    }

}
