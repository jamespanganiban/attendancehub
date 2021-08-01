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


$requests=$conn->prepare("SELECT b.fileid,a.firstname,a.lastname,b.type,b.reason,c.date_in,c.date_out,b.start_time,b.end_time,b.date_created,b.fstatus FROM
users a INNER JOIN filed b ON a.userid = b.userid INNER JOIN attendance c ON b.attendanceid = c.attendanceid");
$requests->execute();






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
 

  
     <?php
       if(isset($_SESSION['regMsg']))
        {
        ?>
          <div ng-if="c.message" class="alert alert-success ng-binding ng-scope" role="alert" style="">
          <?php echo $_SESSION['regMsg']; ?>
            
          </div>
                    <?php
        }
        
          unset($_SESSION['regMsg']);

         ?>
          <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php if(!isset($_GET['id'])) {?> All Requests <?php } ?> </h1>
         
      

        </div>
      
    

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
      
          <div class="card-body">
  


      <?php include "viewrequest.php"; ?>

      <?php if(!isset($_GET['id'])) {?>



      <table id="mytable" class="table-bordered table-striped table-sm" style="color: black;">
  <thead>
    <tr style="font-size: 14px;">
      <th class="th-sm">#</th>
      <th class="th-sm">NAME</th>
      <th class="th-sm">TYPE</th>
      <th class="th-sm">REASON</th>
      <th class="th-sm">REQUESTED DATE</th>
      <th class="th-sm">REQUESTED TIME</th>
      <th class="th-sm">DATE CREATED</th>
      <th class="th-sm">STATUS</th>
      <th class="th-sm">ACTION</th>


      

    </tr>
  </thead>
  <tbody>
   
   <?php 

    $n = 1;
      
    while($row_requests=$requests->fetch(PDO::FETCH_ASSOC)) 
        { 


?>

    <tr style="font-size: 11px">
        

     
      <td><?php echo $n; ?></td>
      <td><?php echo $row_requests['firstname']." ".$row_requests['lastname']; ?></td>
      <td><?php echo $row_requests['type']; ?></td>
      <td><?php echo $row_requests['reason']; ?></td>
      <td><?php echo $row_requests['date_in']." - ".$row_requests['date_out']; ?></td>
      <td><?php echo $row_requests['start_time']." - ".$row_requests['end_time']; ?></td>
      <td><?php echo $row_requests['date_created']; ?></td>
      <td><?php echo $row_requests['fstatus']; ?></td>
     <!-- <td> <a class="approvalbutton" href="" >YES</a> | <a class="approvalbutton" href="">NO</td>-->
      <td><a class="approvalbutton" href="requests.php?id=<?php echo $row_requests['fileid'];?>" >VIEW</a> </td>


    </tr>
         
       <?php 

       $n ++;
       } 
       
        ?>
     
  </tbody>

</table>


      <?php } ?>


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
