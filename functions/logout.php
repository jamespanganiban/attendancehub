<?php
session_start();
unset($_SESSION["userlogin"]);
session_destroy();
header("refresh:0.3; ../login.php");
?>