<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once 'config/database.php';
    include_once 'class/attendance.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Attendance($db);

    $item->attendanceid = isset($_GET['attendanceid']) ? $_GET['attendanceid'] : die();
  
    $item->getSpecificAttendance();

    if($item->attendanceid != null){
        // create array
        $att_arr = array(
            "attendanceid" =>  $item->attendanceid,
            "date_in" => $item->date_in,
            "time_in" => $item->time_in,
            "date_out" => $item->date_out,
            "time_out" => $item->time_out,
            "tasks" => $item->tasks
        );
      
        http_response_code(200);
        echo json_encode($att_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Attendance not found.");
    }
?>
PHP
