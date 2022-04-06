<?php
function get_merit_list($attributes){

    $exam_id = $attributes['exam_id'];
    $branch_id  = $attributes['branch_id'];
    $class_id = $attributes['class_id'];
    $shit_id = $attributes['shit_id'];
    $section_id = $attributes['section_id'];

    $time_now = time();
    $token_set_at = get_option('token_set_at');
    $diff_in_min = intval(($time_now - $token_set_at) / 60);


    if($diff_in_min >= 300){
        updateAccessToken();
    }

    $access_token = get_option('oxford_access_token');
        $curl = curl_init();
    
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://api.fems.education/api/v1/wp/merit-list/$exam_id/$branch_id/$class_id/$shit_id/$section_id",
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
    $merit_list = json_decode($response);
    $class_name = $merit_list->data->class_info->name;
    $students = json_decode(json_encode($merit_list->data->students), true);

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
                                <th>Student ID</th>
                                <th>Class</th>
                                <th>Total Marks</th>
                                <th>CGP/GPA</th>
                                <th>Position</th>
                            </thead>
                            <tbody>'; 
    
                            if (!empty($merit_list)) { 
                                $x=0; foreach ($students as $id => $student) {  
                                    $x++;
                                    $td .="<tr>
                                        <td> $x</td>
                                        <td> $student[f_name]  $student[l_name]</td>
                                        <td> $student[std_id] </td>
                                        <td> $class_name </td>
                                        <td> $student[total] </td>
                                        <td> $student[cgpa] /$student[grade] </td>
                                        <td> $x </td>
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

?>