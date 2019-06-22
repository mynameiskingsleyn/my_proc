<?php

namespace App\Helpers;

class Helper
{
    public function __construct()
    {
    }
    public function sendRequest($method, $url, $data=[])
    {
        $curl = curl_init();
        if ($method =='pos' || $method=='pu') {
            if ($method=='post') {
                $m = "POST";
            } else {
                $m="PUT";
            }
            curl_setopt_array($curl, array(
              CURLOPT_URL=>$url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30000,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => $m,
              CURLOPT_POSTFIELDS => json_encode($data),
              CURLOPT_HTTPHEADER => array(
                    // Set here requred headers
                    "accept: */*",
                    "accept-language: en-US,en;q=0.8",
                    "content-type: application/json",
                ),
            ));
        } else {
            $url = sprintf("%s?%s", $url, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            //dd($url);
        }
        $response = curl_exec($curl);
        //dd('helper');
        //dd($url);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:".$err;
            $returned = json_encode([]);
        } else {
            $returned = json_decode($response);
        }
        //dd($response);
        return $returned;
    }
}
