<?php
@session_start();
require_once "includes/db_config.php";



if(isset($_REQUEST['logbtn']))
{




	$access_code = strip_tags($_REQUEST['access_code']);


			try
			{
				$check_q=$conn->prepare("SELECT * FROM users WHERE access_code = :uaccesscode");
				$check_q->execute(array(':uaccesscode'=>$access_code));
				$row=$check_q->fetch(PDO::FETCH_ASSOC);

				if($check_q->rowCount() > 0 AND $row['level'] != "admin" AND $row['level'] != "payroll")
				{
							$_SESSION['userlevel'] = $row['level'];
							$_SESSION['userlogin'] = $row['userid'];
							header("refresh:0.3; index.php/../");
							
				}
				else if($check_q->rowCount() > 0 AND $row['level'] == "admin" OR 
					$row['level'] == "payroll" )
				{
							$_SESSION['userlevel'] = $row['level'];
							$_SESSION['userlogin'] = $row['userid'];
							header("refresh:0.3; admin/");
							
				}
						
						else
						{
							$_SESSION['errMsg'] = "Access Code not registered";
						}
				 }
				

				


		
			catch(PDOexception $e)
			{
				$e->getMessage();
			}

	}




?>