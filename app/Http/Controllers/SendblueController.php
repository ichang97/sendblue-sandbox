<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SendblueController extends Controller
{
    public function apiResponse(Request $request){
        if($request){
            // dd($request);
            return response()->json($request, 200);
        }
    }

    public function sendMessage(){
        $client = new Client([
            'base_uri' => config('app.sendblue_api_endpoint'),
            'headers' => [
                'Content-Type' => 'application/json',
                'sb-api-key-id' => config('app.sendblue_api_key'),
                'sb-api-secret-key' => config('app.sendblue_api_secret'),
                'sb-signing-secret' => config('app.sendblue_api_webhook_secret')
            ]
        ]);

        $phone_number = ['0967314939', '0931369378'];

        $phone_number_converted = [];

        for($i = 0; $i < count($phone_number); $i++){
            $temp_phone_number = str_replace('0', '+66', $phone_number[$i]);
            array_push($phone_number_converted, $temp_phone_number);
        }

        try{

            for($j = 0; $j < count($phone_number_converted); $j++){
                $api_res = $client->post('send-message', [
                    'json' => [
                        '_token' => '18LbaWmJbE5nml1vu7kTW4UC358iwsMMbx0f88OQ',
                        'number' => $phone_number_converted[$j],
                        'content' => $phone_number_converted[$j] . ' : test mark api from laravel',
                        'send_style' => 'balloons',
                        'statusCallback' => config('app.sendblue_api_webhook')
                    ]
                ]);
            }
            
            dd(json_decode($api_res->getBody()->getContents(), true), "messege is sent.");
        }catch(Exception $e){
            return response()->json($e, 500);
        }
    }
}
