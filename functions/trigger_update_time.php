<?php
session_start();
require_once "../includes/db_config.php";

//date_default_timezone_set("Asia/Manila");	

if(isset($_REQUEST['updtimebtn']))
{


	$attid = strip_tags($_REQUEST['attid']);
	//$type = strip_tags($_REQUEST['type']);
	$tasks = strip_tags($_REQUEST['tasks']);
	$date_to_file = strip_tags($_REQUEST['date_to_file']);
	$time_to_file = strip_tags($_REQUEST['time_to_file']);

	$t_time = $time_to_file.":00";

	try
	{


			$change_t = $conn->prepare("UPDATE attendance SET date_out = :do,
                                                        time_out = :to,
                                                        tasks = :t
                                                        WHERE attendanceid = :aid");

			if($change_t->execute(array(':do' => $date_to_file,
										':to' => $t_time,
										':t' => $tasks,
										':aid' => $attid))) {

				$_SESSION['regMsg'] = "Time-out Manually encoded: Date :".$date_to_file." Time: ".$t_time;
			   }
			  else
			  {
			  	$_SESSION['regMsg'] = "Something went wrong, please try again later!";
			  }

			



	}
	catch(PDOException $e)
	{
	echo $e->getMessage();
	}

	header("Location: ../admin/fts.php");
}

?>