<?php 	

$localhost = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// db connection
$conn = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($conn->connect_error) {
  die("Connection Failed : " . $conn->connect_error);
} else {
  // echo "Successfully connected";
}

?>