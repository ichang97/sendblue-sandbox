<?php

namespace App\Http\Modules;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use stdClass;

class Sendblue {
    public function __construct(){
        $this->api_key = config('app.sendblue_api_key');
        $this->api_secret = config('app.sendblue_api_secret');
        $this->api_webhook = config('app.sendblue_api_webhook');
        $this->api_webhook_secret = config('app.sendblue_api_webhook_secret');

        $this->api_request = new Client([
            'base_uri' => config('app.sendblue_api_endpoint'),
            'headers' => [
                'Content-Type' => 'application/json',
                'sb-api-key-id' => $this->api_key,
                'sb-api-secret-key' => $this->api_secret,
                'sb-signing-secret' => $this->api_webhook_secret
            ]
        ]);
    }

    // $body is include phone with message
    public function sendMessage($phone, $message){
        if($phone && $message){
            $phone_number_converted = str_replace('0', '+66', $phone);


        }else{
           
        }
    }
}