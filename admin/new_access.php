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
  <link href="../css/togglepass.css" rel="stylesheet">

 



</head>

<?php
session_start();
require_once "../includes/db_config.php";
$userdata = $_SESSION['userlogin'];
//include "../includes/viewtaskmodal.php";
    
if(!isset($_SESSION['userlogin']))
{
  header("location: ../login.php");
}

$select_user=$conn->prepare("SELECT * FROM users WHERE userid = :uuserdata");
$select_user->execute(array(':uuserdata'=>$userdata));
$row=$select_user->fetch(PDO::FETCH_ASSOC);

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
           <form action="../functions/trigger_new_access.php" method="post" class="user">
              <div class="form-group">

                  <input type="text" name="firstname" class="form-control " placeholder="Firstname" required="required">
                  <br>
                  <input type="text" name="lastname" class="form-control" placeholder="Lastname" required="required">
                  <br>
                  <input type="email" name="email_add" class="form-control" placeholder="Email address" required="required">
                  <br>    

                  <input type="password" name="access_code" class="form-control " id="password-field" placeholder="Access code" required="required">
                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" title="Show Code"></span>
                  <br>
                  <select name="level" class="form-control" placeholder="Level" required="required">
                  <option value="" selected>--Level--</option>
                  <option value="L1">L1</option>
                  <option value="L2">L2</option>
                  <option value="L3">L3</option>
                  <option value="admin">Admin</option>
                  <option value="payroll">Payroll</option>
                  </select>
          
                  <br>
                     
              <input type="submit" id="btn1" name="createbtn" class="btn btn-primary btn-block" value="Create Access">

                 </div>
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

       function yesnoCheck() {
          if (document.getElementById("show_task").selected) {
              document.getElementById("tasks").style.display = "block";
              document.getElementById("txtarea").required = true;
          } else {
              document.getElementById("tasks").style.display = "none";
              document.getElementById("txtarea").required = false;
          }

        var in_out_val = document.getElementById('in_out').value;
      
          


   

    }
        $(".toggle-password").click(function() {

          $(this).toggleClass("fa-eye fa-eye-slash");
          var input = $($(this).attr("toggle"));
          if (input.attr("type") == "password") {
            input.attr("type", "text");
          } else {
            input.attr("type", "password");
          }
        });
      
</script>
    
  </script>



</body>

</html>
