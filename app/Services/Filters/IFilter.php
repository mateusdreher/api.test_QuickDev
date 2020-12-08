<?php

namespace App\Services\Filters;

interface IFilter {
    
    public function filter($data, $param);
}
