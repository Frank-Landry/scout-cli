<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class BountyListService {

    public function fetchBountyList(string $target) : array
    {
        $response = Http::get($target);
        // transform result into an array
        return json_decode($response->__toString());
    }
}
