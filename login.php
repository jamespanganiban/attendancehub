<!DOCTYPE html>
<html lang="en">
<?php
 define('APP', true);
 include "includes/db_config.php"; 

 ?>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="img/logo/TH_LOGO.PNG">
  <title>AttendanceHUB - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/togglepass.css" rel="stylesheet">
    


</head>


<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
       <!-- insert image -->
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                     <!-- <img src="img/logo/TH_LOGO.png" style='height: 50%; width: 50%; object-fit: contain'>-->
                  <div class="text-center">
                  <img src="img/logo/LOGO.PNG" style='height: 50%; width: 80%; object-fit: contain'>
                  <h1 class="h4 text-gray-900 mb-4"</h1>
                  </div>
                    <!--<h3 class="h4 text-gray-900 mb-4"><br>Welcome back!</h3>-->
                  </div>

                <?php

               
                include "functions/login_account.php";

                          
                if(isset($_SESSION['errMsg']))
                {
                  ?>
                  <div ng-if="c.message" class="alert alert-danger ng-binding ng-scope" role="alert" style="">
                  <?php echo $_SESSION['errMsg']; ?>
                    
                  </div>
                  
                  <?php
                  }
                  unset($_SESSION['errMsg']);
              
                ?>


                  <form action="" method="post" class="user">
            
                    <div class="form-group">
                        
                      <input type="password" class="form-control form-control-user" name="access_code" placeholder="Access Code"required="required" id="password-field">
                       <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password" title="Show Code"></span>
                 
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                      <!--  <label class="custom-control-label" for="customCheck">Remember Me</label> -->
                      </div>
                    </div>
                    <input type="submit" name="logbtn" class="btn btn-primary btn-user btn-block" value="Login">
                      
                    
                </form>
                    <hr>
                  <div class="text-center">
                    <!--<a class="small" href="forgot-password.html">Forgot Password?</a>-->
                  </div>
                  <div class="text-center">
                    <a class="small" href="changecode.php">Change My Access Codesss</a>
                      


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

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
    
    <script>
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

</body>

</html>
