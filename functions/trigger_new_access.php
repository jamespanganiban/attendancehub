;<?php
session_start();
require_once "../includes/db_config.php";

//date_default_timezone_set("Asia/Manila");	

if(isset($_REQUEST['createbtn']))
{

	$firstname = strip_tags($_REQUEST['firstname']);
	$lastname = strip_tags($_REQUEST['lastname']);
	$email_add = strip_tags($_REQUEST['email_add']);
	$access_code = strip_tags($_REQUEST['access_code']);
	$level = strip_tags($_REQUEST['level']);
	

	try
	{
		$check_q = $conn->prepare("SELECT * FROM users WHERE email_add = :uemail"); 


		$check_q->execute(array(':uemail' => $email_add));
		$row = $check_q->fetch(PDO::FETCH_ASSOC);

		if($row["email_add"] == $email_add OR $row["access_code"] == $access_code)
		{


			$_SESSION['regMsg'] = "Existing Access";
			//$hash_pass = password_hash($new_code, PASSWORD_DEFAULT);


			}
		else
		{
			$change_q = $conn->prepare("INSERT INTO users (firstname,lastname,email_add,access_code,level) 
				VALUES (:fn,:ln,:ea,:ac,:lvl) ");

			if($change_q->execute(array(':fn' => $firstname,
										':ln' => $lastname,
									    ':ea' => $email_add,
									    ':ac' => $access_code,
									    ':lvl' => $level))){

			$_SESSION['regMsg'] = "Access Created";
			}
		}



	}
	catch(PDOException $e)
	{
	echo $e->getMessage();
	}

		header("Location: ../admin/new_access.php");
}

?>