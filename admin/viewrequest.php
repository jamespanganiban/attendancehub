<?php
If(isset($_GET['id']))
{


$id = $_GET['id'];



$viewreq=$conn->prepare("SELECT b.fileid,a.firstname,a.lastname,b.type,b.reason,c.date_in,c.time_in,c.time_out,c.date_out,b.start_time,b.end_time,b.date_created,b.fstatus,b.remarks FROM
users a INNER JOIN filed b ON a.userid = b.userid INNER JOIN attendance c ON b.attendanceid = c.attendanceid
WHERE b.fileid = :fid ");
$viewreq->execute(array(':fid' => $id));

$row_viewreq = $viewreq->fetch(PDO::FETCH_ASSOC);





echo '
  <form action="../functions/trigger_filing.php" method="post" class="user">
  <input type="hidden" name="fileid" value="'.$id.'">
  <input type="hidden" name="updated_by" value="'.$row['firstname'].' '.$row['lastname'].'">
  
<input type="text" id="inp1" class="form-control" name="fullname" value="Name: '.$row_viewreq['firstname'].' '.$row_viewreq['lastname'].'" readonly> 

<input type="text" id="inp1" class="form-control" name="type" value="Type: '.$row_viewreq['type'].'" readonly> 

<input type="text" id="inp1" class="form-control" name="fullname" value="Reason: '.$row_viewreq['reason'].'" readonly> 

<input type="text" id="inp1" class="form-control" name="fullname" value="Filed for DTR: '.$row_viewreq['date_in'].' '.$row_viewreq['time_in'].' - '.$row_viewreq['date_out'].' '.$row_viewreq['time_out'].'  " readonly> 

<input type="text" id="inp1" class="form-control" name="fullname" value="OT In: '.$row_viewreq['start_time'].' " readonly> 

<input type="text" id="inp1" class="form-control" name="fullname" value="OT Out: '.$row_viewreq['end_time'].' " readonly>

<input type="text" id="inp1" class="form-control" name="fullname" value="Date filed: '.$row_viewreq['date_created'].' " readonly> 
<input type="text" id="inp1" class="form-control" name="fullname" value="Status: '.$row_viewreq['fstatus'].' " readonly> 



&nbsp&nbsp<textarea class="form-control" rows="3" name="remarks" id="txtarea" placeholder="Remarks...">'.$row_viewreq['remarks'].'</textarea><br>

      

<input type="submit" id="btn1" name="appbtn" class="btn btn-primary btn-block" value="APPROVE"><br><br>

<input type="submit" id="btn1" name="disappbton" class="btn btn-primary btn-block" value="DISAPPROVE">
</form>

';



}


?>