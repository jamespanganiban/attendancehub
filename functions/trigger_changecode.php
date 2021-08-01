;<?php
session_start();
require_once "../includes/db_config.php";

//date_default_timezone_set("Asia/Manila");	

if(isset($_REQUEST['btnchangecode']))
{


	$emailadd = strip_tags($_REQUEST['emailadd']);
	$old_code = strip_tags($_REQUEST['old_code']);
	$new_code = strip_tags($_REQUEST['new_code']);
	

	try
	{
		$check_q = $conn->prepare("SELECT * FROM users WHERE email_add = :uemail"); 


		$check_q->execute(array(':uemail' => $emailadd));
		$row = $check_q->fetch(PDO::FETCH_ASSOC);

		if($row["email_add"] == $emailadd AND $row["access_code"] == $old_code)
		{

			//$hash_pass = password_hash($new_code, PASSWORD_DEFAULT);

			$change_q = $conn->prepare("UPDATE users SET access_code = :uaccess_code WHERE email_add = 									:uemailadd");

			if($change_q->execute(array(':uaccess_code' => $new_code,
										':uemailadd' => $emailadd))){

				$_SESSION['regMsg'] = "Access Code Changed";
				}
			}
		else
		{
			$_SESSION['errMsg'] = "Email and Code does not match!";
		}



	}
	catch(PDOException $e)
	{
	echo $e->getMessage();
	}

	header("Location: ../changecode.php");
}

?>