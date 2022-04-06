<?php

function updateAccessToken(){

    $oxford_username = $access_token = get_option('oxford_username');
    $oxford_password = $access_token = get_option('oxford_password');

    $data = ["user_username" => $oxford_username, "password" => $oxford_password ];
        
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://api.fems.education/api/v1/auth/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => array(
        'Origin: http://ems.ois.edu.bd',
        'Content-Type: application/json'
    ),
    ));

    $response = json_decode(curl_exec($curl));

    if($response && $response->access_token){
        update_option('token_set_at', time());
        update_option( 'oxford_access_token', $response->access_token);
    }
    return 1;
}
