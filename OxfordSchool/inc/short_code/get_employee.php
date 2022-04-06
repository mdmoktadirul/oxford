<?php

function get_employee($attributes){

    $time_now = time();
    $token_set_at = get_option('token_set_at');
    $diff_in_min = intval(($time_now - $token_set_at) / 60);

    if($diff_in_min >= 300){
        updateAccessToken();
    }

    $access_token = get_option('oxford_access_token');
        $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.fems.education/api/v1/wp/employee-list',
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
    $emploies = json_decode($response);
    
        $table =''; 
        $td = '';
        $table .= '<div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="admission-results">
                        <table id="employeeTable" class="table table-hover thead-light">
                            <thead>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Mobile No (Office)</th>
                                <th>Email (Office)</th>
                                <th>Department</th>
                                <th>Campus</th>
                            </thead>
                            <tbody>'; 
    
                            if (!empty($emploies)) { 
                                $x=0; foreach ($emploies->data as $employee) {  
                                    $x++;
                                    $td .="<tr>
                                        <td> $x</td>
                                        <td> $employee->first_name $employee->last_name</td>
                                        <td> $employee->designation</td>
                                        <td> $employee->official_mobile</td>
                                        <td> $employee->official_email</td>
                                        <td> $employee->department_name</td>
                                        <td> $employee->campus_name</td>
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