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


    $select_u=$conn->prepare("SELECT MAX(date_in) AS date_in, MAX(time_in) AS time_in FROM attendance WHERE userid = :uuserid");
    $select_u -> execute(array(':uuserid'=>$userid));
    $row=$select_u -> fetch(PDO::FETCH_ASSOC);

    $user_date_in = $row['date_in'];
    $user_time_in = $row['time_in'];

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


    if(empty($user_date_in) AND $time_in_out == "time_out" AND $date_t != $user_date_in 
     OR !empty($user_date_in) AND $time_in_out == "time_out" AND $date_t != $user_date_in)
    {
      $_SESSION['err_msg'] = "Warning: Time in not detected!";

    }


    elseif(!empty($user_date_in) AND $time_in_out == "time_out" AND $date_t == $user_date_in)
      {


      $date1 = strtotime($user_date_in." ".$user_time_in);  
      $date2 = strtotime($date_t." ".$time_t); 
      $diff = abs($date2 - $date1);  
      $years = floor($diff / (365*60*60*24));  
      $months = floor(($diff - $years * 365*60*60*24) 
                                     / (30*60*60*24));  
      $days = floor(($diff - $years * 365*60*60*24 -  
                   $months*30*60*60*24)/ (60*60*24)); 
      $hours = floor(($diff - $years * 365*60*60*24  
             - $months*30*60*60*24 - $days*60*60*24) 
                                         / (60*60));  
      $minutes = floor(($diff - $years * 365*60*60*24  
               - $months*30*60*60*24 - $days*60*60*24  
                                - $hours*60*60)/ 60);  
      $seconds = floor(($diff - $years * 365*60*60*24  
               - $months*30*60*60*24 - $days*60*60*24 
                      - $hours*60*60 - $minutes*60));  
        
      $time_rendered = sprintf("%d hours, ". "%d minutes", $hours, $minutes);




        $time_q = $conn->prepare("UPDATE attendance SET date_out = :tqdate_out,
                                                        time_out = :tqtime_out,
                                                        tasks = :tqtasks,
                                                        time_rendered = :tqtime_rendered
                                                        WHERE userid = :tquserid
                                                        AND date_in = :tqdate_t");


      $time_q->execute(array( ':tqdate_out' => $date_t,
                              ':tqtime_out' => $time_t,
                              ':tqtasks' => $tasks,
                              ':tqtime_rendered' => $time_rendered,
                              ':tquserid' => $userid,
                              ':tqdate_t' => $date_t));

        

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


