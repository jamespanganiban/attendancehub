<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once 'config/database.php';
    include_once 'class/attendance.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Attendance($db);

    $stmt = $items->getAttendance();
    $itemCount = $stmt->rowCount();


    echo json_encode($itemCount);

    if($itemCount > 0){
        
        $attendanceArr = array();
        $attendanceArr["body"] = array();
        $attendanceArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "attendanceid" => $attendanceid,
                "date_in" => $date_in,
                "time_in" => $time_in,
                "date_out" => $date_out,
                "time_out" => $time_out,
                "tasks" => $tasks
            );

            array_push($attendanceArr["body"], $e);
        }
        echo json_encode($attendanceArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>