<?php

function get_newsletter(){

    $time_now = time();
    $token_set_at = get_option('token_set_at');
    $diff_in_min = intval(($time_now - $token_set_at) / 60);

    if($diff_in_min >= 300){
        updateAccessToken();
    }

    $access_token = get_option('oxford_access_token');
        $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.fems.education/api/v1/wp/newsletter',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Origin: http://ems.ois.edu.bd',
            'Access-Control-Request-Headers: *',
            'Authorization: Bearer '.$access_token
        ),
    ));
    
    $response = curl_exec($curl);
  
    curl_close($curl);
    $newsletter = json_decode($response);
    
        $htmlDiv =''; 
        $single="";
        $htmlDiv .= '<div class="container">
            <div class="row">
                <div class="col-md-12">'; 
    
    
                            if (!empty($newsletter)) { 
                                $x=0; 
                                foreach ($newsletter->data as $data) { 
                                   
                                    $single .= "<br>"; 
                                    $single .= "<h1>$data->title</h1>";
                                    $single  .= date_format(date_create($data->publish_date),"d M, Y h:ia");
                                    $single .= "<p>$data->message</p>";
                                    $single .= "<hr>";
                                    $x++;
                                    $emails = '<ul>';
                                    $optional_email = json_decode($data->optional_email);
                                   if($optional_email){
                                        foreach($optional_email as $email){
                                            $emails .="<li> $email</li>";
                                        }
                                   }
                                   $emails .= '</ul>';
                                   $single .=$emails;
                                }
                                $htmlDiv .= $single;
                            }
         
                $htmlDiv .= '</div>
            </div>
        </div>';
    
        return $htmlDiv;
    }
