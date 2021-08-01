<!DOCTYPE html>
<html lang="en">
<?php 
date_default_timezone_set("Asia/Manila"); 
session_start(); 
require_once "includes/db_config.php";
$userdata = $_SESSION['userlogin'];
$date = date("F d, Y");

include "functions/run_tk.php";


?>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=yes">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="img/logo/TH_LOGO.PNG">
  <title>AttendanceHUB</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/togglepass.css" rel="stylesheet">
    


</head>

<?php
  if(!isset($_SESSION["userlogin"])  OR $_SESSION['userlevel'] == "admin" OR $_SESSION['userlevel'] == "payroll"  )
  {

  header("location: admin/");
  }


    $select_user=$conn->prepare("SELECT * FROM users WHERE userid = :uuserdata");
    $select_user->execute(array(':uuserdata'=>$userdata));
    $row_udata=$select_user->fetch(PDO::FETCH_ASSOC);

    $select_user_shift=$conn->prepare("SELECT TIME_FORMAT(a.shift_in,'%h:%i %p') AS shift_in, TIME_FORMAT(a.shift_out,'%h:%i %p') AS shift_out FROM shift a  INNER JOIN users b ON a.shiftid=b.shiftid WHERE b.userid = :uuserdata");
    $select_user_shift->execute(array(':uuserdata'=>$userdata));
    $row_user_shift=$select_user_shift->fetch(PDO::FETCH_ASSOC);

    //announcement query
    $select_a=$conn->prepare("SELECT * FROM announcement");
    $select_a->execute();
    $row_a=$select_a->fetch(PDO::FETCH_ASSOC);
  

?>
<body class="bg-gradient-primary" onload="digi()">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-9 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">

          <div class="card-body p-0">

            <!-- Nested Row within Card Body -->
            <div class="row">

       <!-- insert image -->

              <div class="col-lg-12">


              <div class="p-5">

              
             
                  <div class="text-center">
                     <!-- <img src="img/logo/TH_LOGO.png" style='height: 50%; width: 50%; object-fit: contain'>-->
                    
          <?php 

              if(isset($_SESSION['t_msg']))
                    {
                      ?>
                      <div ng-if="c.message" class="alert alert-success ng-binding ng-scope" role="alert" style="">
                      <?php echo $_SESSION['t_msg']; ?>
                        
                      </div>
                      `
                      <?php
                        
                      }
              if(isset($_SESSION['err_msg']))
                    {
                      ?>
                      <div ng-if="c.message" class="alert alert-danger ng-binding ng-scope" role="alert" style="">
                      <?php echo $_SESSION['err_msg']; ?>
                        
                      </div>
                      
                      <?php
                      
                      }
                      unset($_SESSION['t_msg']);
                      unset($_SESSION['err_msg']);
    
          ?>

              <div class="text-center">
              <strong><marquee><?php echo $row_a['announcement']; ?></marquee></strong>
              <img src="img/logo/LOGO.PNG" style='height: 50%; width: 100%; object-fit: contain'>
              <h1 class="h4 text-gray-900 mb-4"</h1>
              </div>


              <div style='height: 50%; width: 100%; object-fit: contain'>
              <a href="functions/logout.php" class="btn"> <i class="fa fa-arrow-circle-left"></i> Logout</a>
              <a href="functions/download_timecard.php?id=<?php echo $userdata ; ?>" class="btn"><i class="far fa-calendar"></i> My Timecard</a>
              <?php
              if($row_udata['level'] == "L2")
              {
              ?>
              <a href="admin/" class="btn"><i class="fa fa-user"></i> Admin</a><br><br>
            
             <?php
              }
             ?>
             <?php
              if($row_udata['level'] != "L2")
              {
              ?>
              <a href="myportal/" class="btn"><i class="fa fa-user"></i> My Portal</a><br><br>
            
             <?php
              }
             ?>
              </div>

                    <!--<h3 class="h4 text-gray-900 mb-4"><br>Welcome back!</h3>-->
                  </div>

                  <form action="" method="post" class="user">

               <strong>Date: </strong> <span class="inline"> <?php echo $date; ?> </span><br>
               <strong>Time: </strong> <span class="inline" id="clock"> </span><br>
               <strong>Shift: </strong> <span class="inline"><?php echo $row_user_shift['shift_in'].' - '.$row_user_shift['shift_out'];?></span><br><br>
         
                <div class="form-group">
                <input type="hidden" name="userid" value="<?php echo $row_udata['userid']; ?>">
                <input type="text" class="form-control" name="emp_name" required="required" id="password-field"readonly="readonly" value="<?php echo $row_udata['lastname'].", ".$row_udata['firstname']; ?>">
                
                    </div>

                    <div class="form-group">
                        
                      <input type="text" class="form-control" name="emailadd" required="required"  readonly="readonly" value="<?php echo $row_udata['email_add']; ?>">
                      
                    </div>

                <div class="form-group">
                    <SELECT class="form-control" name="time_in_out" id="in_out" onchange="yesnoCheck()">
                      
                      <option value="time_in">Time-in</option>
                      <option id="show_task" value="time_out">Time-out</option>

                    </SELECT>
                  </div>
                <div class="form-group" id="tasks" style="display: none;">
                <label>Task Accomplished for the Day:</label>
                  <textarea class="form-control" rows="3" name="tasks" id="txtarea"></textarea>

                </div>


                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                      <!--  <label class="custom-control-label" for="customCheck">Remember Me</label> -->
                      </div>
                    </div>
                    <input type="submit" id="btn" name="in_outbtn" class="btn btn-primary btn-user btn-block" value="LET ME IN">    
                    <p id="cd"></p>
                    
                </form>
                    <hr>
                  <div class="text-center">
                    <!--<a class="small" href="forgot-password.html">Forgot Password?</a>-->
                  </div>
                  <div class="text-center">
                   <!-- <a class="small" href="register.php">Create an Account!</a>-->
                      


                  </div>
                    
                </div>
              </div>
            </div>
          </div>
            
            <?php include "includes/footer.php"; ?>
                    </div>
      </div>

    </div>

     
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripdts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
    

  <script type="text/javascript">
    var r;

    

      function yesnoCheck() {
          if (document.getElementById("show_task").selected) {
              document.getElementById("tasks").style.display = "block";
              document.getElementById("txtarea").required = true;
          } else {
              document.getElementById("tasks").style.display = "none";
              document.getElementById("txtarea").required = false;
          }

        var in_out_val = document.getElementById('in_out').value;
      
          
        if (in_out_val  == "time_in")
            {
                document.getElementById("btn").value = "LET ME IN";
               // r = confirm("Are you sure you want to Time In?");
                
            }
        else if(in_out_val == "time_out")
            {
                document.getElementById("btn").value ="LET ME OUT";
                //r = confirm("Are you sure you want to Time Out?");
            
            }

    }

        function confirmation() {
       // document.getElementById("cd").innerHTML = r;

         var in_out_val = document.getElementById('in_out').value;
      
          
        if (in_out_val  == "time_in")
            {
                document.getElementById("btn").value = "LET ME IN";
            confirm("Are you sure you want to Time In?");
                
            }
        else if(in_out_val == "time_out")
            {
                document.getElementById("btn").value ="LET ME OUT";
              confirm("Are you sure you want to Time Out?");
            
            }
            
            
            }
        


          function digi() {
          var date = new Date(),
          hour = date.getHours(),
          minute = checkTime(date.getMinutes()),
          ss = checkTime(date.getSeconds());

          function checkTime(i) {
          if( i < 10 ) {
          i = "0" + i;
          }
          return i;
          }

          if ( hour > 12 ) {
          hour = hour - 12;
          if ( hour == 12 ) {
          hour = checkTime(hour);
          document.getElementById("clock").innerHTML = hour+":"+minute+":"+ss+" AM";
          }
          else {
          hour = checkTime(hour);
          document.getElementById("clock").innerHTML = hour+":"+minute+":"+ss+" PM";
          }
          }
          else {
          document.getElementById("clock").innerHTML = hour+":"+minute+":"+ss+" AM";;
          }
          var time = setTimeout(digi,1000);
          }
  </script>


</body>

</html>
