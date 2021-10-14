<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class GetterService {
    public function getHeaders(string $target_url) : array
    {
        $response = Http::withOptions(array('verify' => false))->get($target_url);
        return $response->headers();
    }

    public function verifyHeaderExists(string $header, array $headers) : bool
    {
        return array_key_exists($header, $headers);
    }
}
