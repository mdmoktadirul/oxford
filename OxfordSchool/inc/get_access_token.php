<?php

$oxford_username = $_POST['oxford_username'];
$oxford_password = $_POST['oxford_password'];

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

$response = curl_exec($curl);

curl_close($curl);
echo json_encode($response);

die();
