<?php
/**
 * Created by Seeb.co
 * Date: 3/7/14
 * Time: 4:16 PM
 */


namespace App\Seeb;

class shSMS {

    public static $API_KEY = "6F5839453538304570685773484B6B6F3858306C58413D3D";
    public static function sendSMS($to,$msg)
    {
        $url = "http://api.kavenegar.com/v1/".shSMS::$API_KEY."/sms/send.json";
        $number = "10001000605040";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $url, [
            'form_params' => [
                'receptor' => $to,
                'sender' => $number,
                'message' => $msg
            ]
        ]);
        return $response;
    }
    public static function sendVerification($to,$token)
    {
        $url = "https://api.kavenegar.com/v1/".shSMS::$API_KEY."/verify/lookup.json?receptor=$to&token=$token&template=blito";
        $number = "10001000605040";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        return $response;
    }
    public static function sendPurchase($to,$token)
    {
        $token2 = urlencode("https://blito.ir");
        $url = "https://api.kavenegar.com/v1/".shSMS::$API_KEY."/verify/lookup.json?receptor=$to&token=$token&token2=$token2&template=blitopurchase";
        $number = "10001000605040";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        return $response;
    }
    public static function sendResetPass($to,$token)
    {
        $url = "https://api.kavenegar.com/v1/".shSMS::$API_KEY."/verify/lookup.json?receptor=$to&token=$token&template=blitoresetpass";
        $number = "10001000605040";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        return $response;
    }

}