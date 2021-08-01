<?php
//session_start();

require_once "includes/db_config.php";


date_default_timezone_set("Asia/Manila"); 
$date_t = date("Y-m-d");
$time_t = date("H:i:s");



    //$user_time_in = $row_u['time_in'];

if(isset($_REQUEST['in_outbtn']))
{
    $userid = strip_tags($_REQUEST['userid']);
    $time_in_out = strip_tags($_REQUEST['time_in_out']);
    $tasks = strip_tags($_REQUEST['tasks']);

    $select_dat_in=$conn->prepare("SELECT MAX(date_in) AS date_in FROM attendance WHERE userid = :uuserid");
    $select_dat_in -> execute(array(':uuserid'=>$userid));
    $row_date_in=$select_dat_in -> fetch(PDO::FETCH_ASSOC);
    $user_date_in = $row_date_in['date_in'];

    $select_u=$conn->prepare("SELECT time_in,time_out FROM attendance WHERE date_in = :udate_in");
    $select_u -> execute(array(':udate_in'=> $user_date_in));
    $row=$select_u -> fetch(PDO::FETCH_ASSOC);

    $user_time_in = $row['time_in'];
    $user_time_out = $row['time_out'];
  try
  {


  if($time_in_out == "time_in" AND $user_date_in == $date_t)
    {
      $_SESSION['err_msg'] = "You already Have Time in!";

    }


    elseif($time_in_out == "time_in" AND $user_date_in != $date_t)

        {

        $time_q = $conn->prepare("INSERT INTO attendance (userid,date_in,time_in)
        VALUES (:tq_userid,:tqdate_in,:tqtime_in)");

        if($time_q->execute(array(':tq_userid' => $userid,
                                  ':tqdate_in' => $date_t,
                                  ':tqtime_in' => $time_t))){

            $_SESSION['t_msg'] = "Time in: ".$date_t." at ".$time_t;
            
        }

        }


    if(empty($user_date_in) AND $time_in_out == "time_out")
    {
      $_SESSION['err_msg'] = "Warning: Time in not detected!";

    }


    elseif(!empty($user_date_in) AND $time_in_out == "time_out")
      {


      $time1 = $user_date_in." ".$user_time_in;  
      $time2 = $date_t." ".$time_t; 
    

      $diff = abs(strtotime($time1) - strtotime($time2));

      $tmins = $diff/60;

      $hours = floor($tmins/60);

      $mins = $tmins%60;


        
      $time_rendered = $hours." "."hours ".", ".$mins." "."minutes";




      $check_aid = $conn->prepare("SELECT MAX(attendanceid) AS attendanceid FROM attendance WHERE userid = :uid");
      $check_aid->execute(array(':uid' => $userid ));
      $row_check_aid=$check_aid -> fetch(PDO::FETCH_ASSOC);
      $aid = $row_check_aid['attendanceid'];


      $time_q = $conn->prepare("UPDATE attendance SET date_out = :tqdate_out,
                                                        time_out = :tqtime_out,
                                                        tasks = :tqtasks,
                                                        time_rendered = :tqtime_rendered
                                                        WHERE attendanceid = :tqaid");

 
      $time_q->execute(array( ':tqdate_out' => $date_t,
                              ':tqtime_out' => $time_t,
                              ':tqtasks' => $tasks,
                              ':tqtime_rendered' => $time_rendered,
                              ':tqaid' => $aid));

        

      $_SESSION['t_msg'] = "Time out: ".$date_t." at ".$time_t;
        
        }


    
}

  
  catch(PDOException $e)
  {
  echo $e->getMessage();
  }   

    //header("Location: ../index.php");

}



?>


