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
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->attendanceid = $data->attendanceid;
    
    // employee values
    $item->date_in = $data->date_in;
    $item->time_in = $data->time_in;
    $item->date_out = $data->date_out;
    $item->time_out = $data->time_out;
    //$item->tasks = $data->tasks;
    
    if($item->updateAttendance()){
        echo json_encode("Attendance data updated.");
    } else{
        echo json_encode("Data could not be updated");
    }
?>