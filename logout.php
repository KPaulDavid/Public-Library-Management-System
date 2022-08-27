
<?php


session_start();
session_destroy();
unset($_SESSION['access_type']);
unset($_SESSION['username']);
unset($_SESSION['password']);
header('location:http://localhost/library2/index.php');

?>