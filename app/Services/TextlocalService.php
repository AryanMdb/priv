<?php

namespace App\Services;

use GuzzleHttp\Client;

class TextlocalService
{
    protected $apiKey;
    protected $client;

    public function __construct()
    {
        $this->apiKey = config('constants.text_local_token');
        $this->client = new Client(['base_uri' => config('constants.text_local_base_uri')]);
    }

    public function sendOtp($phoneNumber, $otp)
    {

        $message = "Welcome to Privykart. Your OTP for secure login is {$otp}. Please DO NOT share it.%n %n-PRIVYKART ECOMMERCE SERVICES LIMITED LIABILITY PARTNERSHIP";

        $response = $this->client->post('send', [
            'form_params' => [
                'apiKey' => $this->apiKey,
                'numbers' => '+91'.$phoneNumber,
                'message' => $message,
                'sender' => 'PRVKRT',
                'template' => config('constants.text_local_template_id'),
                'placeholders' => json_encode(['#var#' => $otp]),
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}