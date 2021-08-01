<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="img/logo/TH_LOGO.PNG">
    <title>AttendanceHub - Change Access Code</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <!-- register alert -->
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!-- insert image -->
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
              <div class="text-center">
              <img src="img/logo/LOGO.PNG" style='height: 50%; width: 69%; object-fit: contain'>
              <h1 class="h4 text-gray-900 mb-4"</h1>
              </div>
                                <h1 class="h4 text-gray-900 mb-4"><br>Change Access Code</h1>
                            </div>
                <?php
                session_start();  
                //include "functions/register_account.php";

                if(isset($_SESSION['errMsg']))
                {
                  ?>

                  <div ng-if="c.message" class="alert alert-danger ng-binding ng-scope" role="alert" style="">
                  <?php echo $_SESSION['errMsg']; ?>
                    
                  </div>
                            <?php
                  }

                if(isset($_SESSION['regMsg']))
                {
                ?>
                  <div ng-if="c.message" class="alert alert-success ng-binding ng-scope" role="alert" style="">
                  <?php echo $_SESSION['regMsg']; ?>
                    
                  </div>
                            <?php
                }
                  unset($_SESSION['errMsg']);
                  unset($_SESSION['regMsg']);
                ?>
                            <form action="functions/trigger_changecode.php" method="post" class="user">
                
                                <div class="form-group">
                                    <input type="email" name="emailadd" class="form-control form-control-user" placeholder="Email Address" required="required">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="old_code" class="form-control form-control-user" placeholder="Old Access Code" required="required">
                                    </div>
                                     <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" name="new_code" placeholder="New Access Code" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 6 or more characters" required="required">
                                  </div> 
                                </div>
                                <input type="submit" name="btnchangecode" class="btn btn-primary btn-user btn-block" value="Change Code">
                            </form>
                            <hr>
                            <div class="text-center">
                                <!--<a class="small" href="forgot-password.html">Forgot Password?</a>-->
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.php">Back to Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include "includes/footer.php"; ?>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>





</html>