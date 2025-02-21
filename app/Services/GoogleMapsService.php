<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleMapsService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('constants.google_map_token');
    }

    public function getAddressFromCoordinates($latitude, $longitude)
    {

        $response = Http::get(config('constants.google_map_url'), [
            'latlng' => "$latitude,$longitude",
            'key' => $this->apiKey,
        ]);

        $locationData = $response->json();

        if ($response->successful() && isset($locationData['results'][0]['formatted_address'])) {
            return $locationData['results'][0]['formatted_address'];
        }

        return '';
    }
}