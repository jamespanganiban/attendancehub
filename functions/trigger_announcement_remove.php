<?php
session_start();
require_once "../includes/db_config.php";


if(isset($_REQUEST['rmanbtn']))
{


	try
	{




			$rm_q = $conn->prepare("UPDATE announcement SET is_true = :yn");

			if($rm_q->execute(array(':an' => $announcement,':yn' => 'no'))) {

				$_SESSION['regMsg'] = "Posts Removed!";
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