 <?php
session_start();
require_once "../includes/db_config.php";

//date_default_timezone_set("Asia/Manila");	

if(isset($_REQUEST['updshiftbtn']))
{


	$emp_name = strip_tags($_REQUEST['emp_name']);
	$shift = strip_tags($_REQUEST['shift']);
	$dtr_date_from = strip_tags($_REQUEST['dtr_date_from']);
	$dtr_date_to = strip_tags($_REQUEST['dtr_date_to']);

	try
	{



			$change_q = $conn->prepare("INSERT INTO schedule (userid,shiftid,scheduled_date_start,scheduled_date_end)
										VALUES (:u,:s,:sds,:sde)");

			if($change_q->execute(array(':u' => $emp_name,
										':s' => $shift,
										':sds' => $dtr_date_from,
										':sde' => $dtr_date_to))) {

				$change_s = $conn->prepare("UPDATE users SET shiftid = :sid
											WHERE userid = :uid");
				$change_s->execute(array(':sid' => $shift,
										 ':uid' => $emp_name));


				$_SESSION['regMsg'] = "Shift Updated";
			   }



	}
	catch(PDOException $e)
	{
	echo $e->getMessage();
	}

	header("Location: ../admin/cws.php");
}

?>