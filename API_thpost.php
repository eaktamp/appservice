<?php

$api_token_url = 'https://trackapi.thailandpost.co.th/post/api/v1/authenticate/token';
$api_track_url = 'https://trackapi.thailandpost.co.th/post/api/v1/track';
$token_key = 'PIApH=KgY@BBFSK-ZZKuLvWJCiLhFLS*C7J0OfYPO7RQIwI/GjLnIbGEV0L0V0WdFSA_M!FCGXW:JDCIS6FrARHFGyXLBIWRSJMB';

function api_request($url, $token, $content = null){
     
    $headers = [
        'Authorization: Token '. $token,
        'Content-Type: application/json'
    ];
     
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($content) );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
 
    $result = curl_exec( $ch );
    curl_close($ch);
       
    return json_decode($result, true);  
}
$items = [
    'status' => 'all',
    'language' => 'TH',
    'barcode' => [
        ' EF11111111111TH,EF582568151TH,EF582568151TH'
    ]
];

$res_token = api_request($api_token_url, $token_key);
$res_items = api_request($api_track_url, $res_token['token'], $items);
print_r($res_items);  //ผลลัพธ์

?>