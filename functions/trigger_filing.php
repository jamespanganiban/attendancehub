<?php
session_start();
require_once "../includes/db_config.php";

//date_default_timezone_set("Asia/Manila");	

if(isset($_REQUEST['filebtn']))
{


	$userid = strip_tags($_REQUEST['userid']);
	$attid = strip_tags($_REQUEST['attid']);
	$type = strip_tags($_REQUEST['type']);
	$reason = strip_tags($_REQUEST['reason']);
	$start_time = strip_tags($_REQUEST['start_time'].":00");
	$end_time = strip_tags($_REQUEST['end_time'].":00");
	$fstatus = "for approval";

	try
	{



			$file_q = $conn->prepare("INSERT INTO filed (userid,attendanceid,type,reason,start_time,end_time,fstatus)
										VALUES (:uid,:attid,:t,:r,:st,:et,:fstat) ");

			if($file_q->execute(array(':uid' => $userid,
									   ':attid' => $attid,
										':t' => $type,
										':r' => $reason,
										':st' => $start_time,
										':et' => $end_time,
										':fstat' => $fstatus))) {




				$_SESSION['regMsg'] = "Request submitted";
			   }



	}
	catch(PDOException $e)
	{
	echo $e->getMessage();
	}
	if ($_SESSION['type'] == 'for_admin')
	{
		header("Location: ../admin/filing.php");
	}
	elseif($_SESSION['type'] == 'for_myportal')
	header("Location: ../myportal/filing.php");
}


if(isset($_REQUEST['appbtn']))
{
	$approved = "approved";
	$fileid = strip_tags($_REQUEST['fileid']);
	$updated_by = strip_tags($_REQUEST['updated_by']);



try
{



			$approved_q = $conn->prepare("UPDATE filed SET fstatus = :fstat, updated_by = :updby WHERE fileid = :fid" );

			if($approved_q->execute(array(':fstat' => $approved,
									      ':updby' => $updated_by,
									  	  ':fid' => $fileid))) {




				$_SESSION['regMsg'] = "OT Approved";
			   }



	}
	catch(PDOException $e)
	{
	echo $e->getMessage();
	}

	if ($_SESSION['type'] == 'for_admin')
	{
		header("Location: ../admin/requests.php");
	}
	elseif($_SESSION['type'] == 'for_myportal')
	header("Location: ../myportal/filing.php");


}

if(isset($_REQUEST['disappbton']))
{
	$disapproved = "disapproved";
	$fileid = strip_tags($_REQUEST['fileid']);
	$updated_by = strip_tags($_REQUEST['updated_by']);
	$remarks = strip_tags($_REQUEST['remarks']);


try
{



			$approved_q = $conn->prepare("UPDATE filed SET fstatus = :fstat, updated_by = :updby,remarks = :rm WHERE fileid = :fid" );

			if($approved_q->execute(array(':fstat' => $disapproved,
									      ':updby' => $updated_by,
									      ':rm' => $remarks,
									  	  ':fid' => $fileid))) {




				$_SESSION['regMsg'] = "OT Disapproved";
			   }



	}
	catch(PDOException $e)
	{
	echo $e->getMessage();
	}

	if ($_SESSION['type'] == 'for_admin')
	{
		header("Location: ../admin/requests.php");
	}
	elseif($_SESSION['type'] == 'for_myportal')
	header("Location: ../myportal/filing.php");


}
?>