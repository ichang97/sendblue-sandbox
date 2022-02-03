<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\Models\IMessageLog;

class SendblueController extends Controller
{
    public function apiResponse(Request $request){
        if($request){
            $log                        = new IMessageLog;
            $log->transaction_status    = $request->status == 'ERROR' ? 'error' : 'success';
            $log->from                  = $request->from_number;
            $log->to                    = $request->to_number;
            $log->message_status        = $request->status;
            $log->ref_no                = $request->message_handle;

            if($log->transaction_status == 'error'){
                $log->error_code        = $request->error_code;
                $log->error_message     = $request->error_message;
            }

            $log->remark                = json_encode($request);
            $log->save();

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

        $phone_number = ['0967314939'];

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
                        'media_url' => 'https://markapp-s3.s3.ap-southeast-1.amazonaws.com/test-img/4990.png',
                        'send_style' => 'gentle',
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
