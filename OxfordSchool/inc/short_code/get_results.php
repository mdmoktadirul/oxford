<?php

function get_results($attributes){

    $time_now = time();
    $token_set_at = get_option('token_set_at');
    $diff_in_min = intval(($time_now - $token_set_at) / 60);

    if($diff_in_min >= 300){
        updateAccessToken();
    }

    $access_token = get_option('oxford_access_token');
        $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.fems.education/api/v1/wp/admission-result',
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
    $admission_results = json_decode($response);
    
        $table =''; 
        $td = '';
        $table .= '<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="admission-results">
                        <table id="userTable" class="table table-hover thead-light">
                            <thead>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Academic year</th>
                                <th>Exam Branch</th>
                                <th>Guardian first name</th>
                                <th>Guardian last name</th>
                                <th>Guardian contact</th>
                            </thead>
                            <tbody>'; 
    
                            if (!empty($admission_results)) { 
                                $x=0; foreach ($admission_results->data as $user) {  
                                    $x++;
                                    $td .="<tr>
                                        <td> $x</td>
                                        <td> $user->first_name $user->last_name</td>
                                        <td> $user->academic_year_id</td>
                                        <td> $user->exam_branch</td>
                                        <td> $user->guardian_first_name</td>
                                        <td> $user->guardian_last_name</td>
                                        <td> $user->guardian_contact</td>
                                    </tr>";
                                }
                            }
    
                        $table .= $td;       
                $table .= '</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>';
    
        return $table;
    }