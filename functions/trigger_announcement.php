<?php
session_start();
require_once "../includes/db_config.php";

//date_default_timezone_set("Asia/Manila");	





if(isset($_REQUEST['anbtn']))
{


	$announcement = strip_tags($_REQUEST['announcement']);



	try
	{




			$an_q = $conn->prepare("UPDATE announcement SET announcement = :an, is_true = :yn");

			if($an_q->execute(array(':an' => $announcement,':yn' => 'yes'))) {

				$_SESSION['regMsg'] = "Announcement Posted!";
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

	header("Location: ../admin/announcement.php");
}

?>