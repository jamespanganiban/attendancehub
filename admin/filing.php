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
  <link rel="stylesheet" type="text/css" href="../css/cws.css">


 



</head>

<?php
session_start();
$_SESSION['type'] = "for_admin";
require_once "../includes/db_config.php";
$userdata = $_SESSION['userlogin'];
//include "../includes/viewtaskmodal.php";
    
if(!isset($_SESSION['userlogin']))
{
  header("location: ../login.php");
}

$select_user_name=$conn->prepare("SELECT * FROM users WHERE level != :a AND level != :p");
$select_user_name->execute(array(':a' => "admin",
                                 ':p' => "payroll"));

$select_user_shift=$conn->prepare("SELECT * FROM shift");
$select_user_shift->execute(array());

$select_user=$conn->prepare("SELECT * FROM users WHERE userid = :uuserdata");
$select_user->execute(array(':uuserdata'=>$userdata));
$row=$select_user->fetch(PDO::FETCH_ASSOC);



$mn_timecard=$conn->prepare("SELECT b.attendanceid,a.firstname,a.lastname,b.date_in,b.time_in,b.date_out,b.time_out FROM users a INNER JOIN attendance b ON a.userid = b.userid WHERE a.userid = :uid AND b.date_out IS NOT NULL GROUP BY b.date_in,b.time_in ORDER BY b.date_in DESC,b.time_in DESC");
$mn_timecard->execute(array(':uid' => $userdata));

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

          <!-- DataTales Example -->
          <div class="container" id="inp2">
           
            <div  class="card-body" >
           <form action="../functions/trigger_filing.php" method="post" class="user">

            <input type="hidden" name="userid" value="<?php echo $userdata;  ?>">
          <div class="form-group">
                  
       

   
          
          <select id="inp1" class="form-control" name="type" required="required">
          <option value="" selected>--To file--</option>
        
          <option value="OT">Overtime</option>
    

          </select><br>



          <label>Reason:</label>
          <textarea class="form-control" rows="3" name="reason" id="txtarea" required></textarea>
          <br>
                           


          
          <select id="inp1" class="form-control" name="attid" required="required">
          <option value="" selected>--Date to File--</option>
          <?php
          while($row_name=$mn_timecard->fetch(PDO::FETCH_ASSOC))
          {
          ?>
          <option value="<?php echo $row_name['attendanceid']; ?>"  style="background-color: black;color:white;"><?php echo $row_name['date_in']." to ".$row_name['date_out']; ?></option>
          <?php } ?>
          </select><br>



                           
            <div class="form-group row" class="inline-block">
            <div class="col-sm-6 mb-3 mb-sm-0">
          <input type="text" id="inp1" name="start_time" required="required" class="form-control" placeholder="--OT IN--" onfocus="(this.type='time')" onblur="(this.type='text')">
     
            </div>
            <div class="col-sm-6">
          <input type="text" id="inp1" name="end_time" required="required" class="form-control" placeholder="--OT OUT--" onfocus="(this.type='time')" onblur="(this.type='text')">
          
            </div> 
            </div>

            </div>
            <input type="submit" id="btn1" name="filebtn" class="btn btn-primary btn-block" value="REQUEST">
              
                    
                </form>
              </div>
            </div>
          </div>

            
        </div>

    </body>

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

  $( function() {
    $( "#datepicker" ).datepicker();
  } );

</script>
    
  </script>



</body>

</html>
