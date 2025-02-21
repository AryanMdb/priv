<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MapsController extends BaseController
{
    public function getAddress(Request $request)
    {
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $apiKey = 'YOUR_GOOGLE_MAPS_API_KEY';

        $client = new Client();

        $response = $client->get("https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}");

        $data = json_decode($response->getBody(), true);

        if ($data['status'] == 'OK') {
            $address = $data['results'][0]['formatted_address'];
            return response()->json(['address' => $address]);
        } else {
            return response()->json(['error' => 'Unable to fetch address']);
        }
    }
}