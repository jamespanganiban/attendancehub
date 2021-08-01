<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="img/logo/TH_LOGO.PNG">
  <title>AttendanceHub - Monitor</title>

  <!-- Custom fonts for this template -->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Custom styles for this template -->
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="../css/datatable.css">




</head>

<?php
session_start();
$_SESSION['type'] = "for_admin";
require_once "../includes/db_config.php";
$userdata = $_SESSION['userlogin'];
//include "../includes/viewtaskmodal.php";
date_default_timezone_set("Asia/Manila"); 
$date_t = date("Y-m-d");
    
if(!isset($_SESSION['userlogin']))
{
  header("location: ../login.php");
}



$select_user=$conn->prepare("SELECT * FROM users WHERE userid = :uuserdata");
$select_user->execute(array(':uuserdata'=>$userdata));
$row=$select_user->fetch(PDO::FETCH_ASSOC);

    
$select_ass_user=$conn->prepare("SELECT CONCAT(firstname,' ',lastname) as name FROM users WHERE userid = :uuserdata");
$select_ass_user->bindParam('uuserdata',$userdata);
$select_ass_user->execute();
$row_ass_user=$select_ass_user->fetch(PDO::FETCH_ASSOC);

$assigned = $row_ass_user['name'];

$dateorder=$conn->prepare("SELECT b.date_in FROM users a INNER JOIN attendance b ON a.userid = b.userid ");
$dateorder->execute(array());


$mn_timecard=$conn->prepare("SELECT a.userid,b.attendanceid,a.firstname,a.lastname,DATE_FORMAT(b.date_in,'%b %d, %Y') as date_in,TIME_FORMAT(b.time_in,'%h:%i %p') as time_in ,DATE_FORMAT(b.date_out,'%b %d, %Y') as date_out,TIME_FORMAT(b.time_out,'%h:%i %p') AS time_out,b.tasks,CONCAT(HOUR(TIMEDIFF(CONCAT(date_in,' ',time_in),CONCAT(date_out,' ',time_out))),' hours, ',MINUTE(TIMEDIFF(CONCAT(date_in,' ',time_in),CONCAT(date_out,' ',time_out))),' minutes') AS timerendered,a.level,TIME_FORMAT(d.shift_in,'%h:%i %p') AS shift_in,TIME_FORMAT(d.shift_out,'%h:%i %p') AS shift_out,b.NSD FROM users a INNER JOIN attendance b ON a.userid = b.userid INNER JOIN schedule c ON a.userid = c.userid
INNER JOIN shift d ON c.shiftid = d.shiftid WHERE b.date_in BETWEEN c.scheduled_date_start AND c.scheduled_date_end 
GROUP BY b.date_in,b.time_in ORDER BY b.date_in DESC,b.time_in DESC");
$mn_timecard->execute();



?>


<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php include "../includes/sidebar.html"; ?>
    <!-- End of Sidebar --> 

    <!-- Content Wrapper -->
   
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
 
          <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">DTR Monitoring </h1>
         
        <form action="export.php">
        <input type="text" name="dtr_date_from" required="required" class="form-control" placeholder="DTR From:" onfocus="(this.type='date')" onblur="(this.type='text')"><br>
        <input type="text" name="dtr_date_to" required="required" class="form-control"  placeholder="To:" onfocus="(this.type='date')" onblur="(this.type='text')">
        <br>
        <button type="submit" name="src_date" class="form-control btn-primary"  value="DTR Report" > <i class="fas fa-download fa-sm"> </i> DTR Report </button> 



        </form>
        </div>
      
    

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
      
          <div class="card-body">
            
      <table id="mytable" class="table-bordered table-striped table-sm" style="color: black;">
  <thead>
    <tr style="font-size: 14px;">
      <th class="th-sm">#</th>
      <th class="th-sm">NAME</th>
      <th class="th-sm">DATE</th>
      <th class="th-sm">&nbspIN&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
      <th class="th-sm">DATE</th>
      <th class="th-sm">OUT&nbsp</th>

      <?php if($row['level'] != "payroll") {?>
      <th class="th-sm">TASK ACCOMPLISHED</th>
      <?php } ?>
      <th class="th-sm">RENDERED</th>

      <th class="th-sm">SHIFT</th>


      

    </tr>
  </thead>
  <tbody>
   
   <?php 
    include "nsd.php";
    $n = 1;
      
    while($row_timecard=$mn_timecard->fetch(PDO::FETCH_ASSOC)) 
        { 
     

      if($row_timecard['shift_in'] == "10:00 PM" OR $row_timecard['shift_in'] == "02:00 PM"){
      $diff =  (night_difference(strtotime($row_timecard['date_in'].' '.$row_timecard['time_in']),strtotime($row_timecard['date_out'].' '.$row_timecard['time_out']))); 

      $tmins = $diff/60;

      $hours = floor($tmins/60);

      $mins = $tmins%60;

      $time_rendered = $hours." "."hours ".", ".$mins." "."minutes";

      $run_nsd_update = $conn->prepare("UPDATE attendance SET NSD = :nsd
                                                    WHERE attendanceid = :aid");

      $run_nsd_update->execute(array(':nsd' => $time_rendered,
                                     ':aid' => $row_timecard['attendanceid']));
 		

        }
       
      else {
      $run_nsd_update1 = $conn->prepare("UPDATE attendance SET NSD = :nsd
                                            WHERE attendanceid = :aid");

      $run_nsd_update1->execute(array(':nsd' => "N/A",
                                     ':aid' => $row_timecard['attendanceid']));

      } 

?>

    <tr style="font-size: 11px">
        

     
      <td title="Attid: <?php echo $row_timecard['attendanceid']?> Userid: <?php echo $row_timecard['userid']?>"><?php echo $n; ?></td>
      <td><?php echo $row_timecard['firstname']." ".$row_timecard['lastname']; ?></td>
      <td><?php echo $row_timecard['date_in']; ?></td>
      <?php if($row_timecard['time_in'] > $row_timecard['shift_in'].':59')
      {?>
      <td style="color: #d82020;font-size: 11px;"><?php echo $row_timecard['time_in']; ?></td>
      <?php 
      }
      else
      {?>
      <td><?php echo $row_timecard['time_in']; ?></td>
      <?php }?>
      <td><?php echo $row_timecard['date_out']; ?></td>

      <?php if($row_timecard['date_in'] == $date_t AND $row_timecard['time_out'] < $row_timecard['shift_out'].':00' AND !empty($row_timecard['time_out']))
      {?>

      <!-- NSD -->
      <td style="color: #d82020" title="<?php echo $row_timecard['NSD']; ?>">

      <?php echo $row_timecard['time_out']; ?></td>
      <?php 
      }
      else
      {?>
        <!-- NSD END-->
        <!-- NSD -->
      <td title = "<?php echo 'NSD: '.$row_timecard['NSD']; ?>">
            <!-- NSD END -->
     <?php echo $row_timecard['time_out']; ?></td>
      <?php }?>
      <!--<button type="button" class="material-icons" data-toggle="modal" title=""-->

        <?php if($row['level'] != "payroll") {?>
      <?php if(!empty($row_timecard['tasks'])) 
       {?>
      <td style=" white-space: normal; width: 400px;">

      <input type="button" onclick="change<?php echo $n; ?>()" class="collapsible" id="accbtn<?php echo $n; ?>" value=" View Task Accomplished"> 
      <div class="content"><br><?php echo $row_timecard['tasks'];?>
      </td>
        <?php 
       }

      else
      {?>
      <td><?php echo $row_timecard['tasks']; ?></td>
      <?php }}?>

      <td><?php if(!empty($row_timecard['time_out'])){echo $row_timecard['timerendered'];} else{echo "PENDING";} ?></td>



      <td><?php echo $row_timecard['shift_in']."-".$row_timecard['shift_out'] ?></td>

    </tr>
         <script>
     
        function change<?php echo $n;?>() // no ';' here
        {
            var elem = document.getElementById("accbtn<?php echo $n; ?>");
            if (elem.value=="Close") elem.value = "View Task Accomplished";
            else elem.value = "Close";
        }
        
      </script>
       <?php 

       $n ++;
       } 
       
        ?>
     
  </tbody>
  <tfoot>
    <!--
    <tr>
      <th class="th-sm">#</th>
      <th class="th-sm">Name</th>
      <th class="th-sm">Date In</th>
      <th class="th-sm">Time In</th>
      <th class="th-sm">Date Out</th>
      <th class="th-sm">Time Out</th>
      <th class="th-sm">Task Accomplished</th>
      <th class="th-sm">Time Rendered</th>
      <th class="th-sm">Level</th>

    </tr>
  -->
  </tfoot>
</table>
              </div>
            </div>
          </div>

            
        </div>
        <!-- /.container-fluid -->
 
 <!-- Modal -->
 





    
      <!-- End of Main Content -->

      <!-- Footer -->

      <!-- End of Footer -->

    
    
    <!-- End of Content Wrapper -->

  
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

 
 
     
  <!-- Logout Modal-->
    <?php include "../includes/logoutModal.html" ?>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


  
  <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <!-- Page level plugins -->


  <!-- Page level custom scripts -->
  <script>


    $(document).ready(function () {
    $('#mytable').DataTable({
    "scrollX": false,
    //"scrollY": 300,
    "paging": true,
    });
    $('.dataTables_length').addClass('bs-select');
    });
          function Export()
        {
            var conf = confirm("Export DTR to CSV?");
            if(conf == true)
            {
                window.open("export.php", '_blank');
            }
        }


        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
        content.style.display = "none";
        } else {
        content.style.display = "block";
        }
        });
        }



</script>
    



</body>

</html>
