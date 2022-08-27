<?php
$user_id = $request = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $user_id=$_POST['user_id'];
  $requests=$_POST['request'];
 }
Issues($user_id,$request);

function Issues($user_id,$request)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Request</title>
<link rel="stylesheet" href="css/all.css">
</head>
<?php require_once 'main.php'; 
require_once 'db_connect.php';?>
<body>
<div class="row">
  <div class="column1" style="height:120%; text-align:justify">
    <center><font color=red>New Books</font></center>
      <?php 
      $query=mysqli_query($conn,"SELECT * FROM `books` WHERE books.Date>DATE_SUB(now(), INTERVAL 3 MONTH)");
      $row1 = mysqli_num_rows($query);
      if($row1>0){?>
        <ol style="padding-left:25px; padding-right:5px;"><?php
        while ($row1 = mysqli_fetch_array($query)) 
        {
          ?><li ><?php echo $row1['Book']." by ".$row1['Author']; ?></li><?php
          echo "<br>";
        }?></ol><?php
      }
      ?>  
  </div>
  <div class="column2" style="height:120%;">
    <?php
      $query2=mysqli_query($conn,"SELECT * FROM programs WHERE Start_date>=DATE_SUB(now(), INTERVAL 0 MONTH)");
      $rows1=mysqli_num_rows($query2);
      if($rows1>0){
        echo "<center><font color=red>Dept Festivals</font></center>";?>
        <ol style="padding-left:20px; padding-right:5px;"><?php
        while($rows1 = mysqli_fetch_array($query2))
        {
          $date1 =explode("-",$rows1['Start_date']);
          $date2=implode("-",array($date1[2],$date1[1],$date1[0]));
      
          $noti=$rows1['Program_name']." on ".$date2." by department of ".$rows1['Department'];
          ?><li style="padding:5px; text-align:justify;"><?php echo $noti; ?></li><br><?php
        }?></ol><?php
      }
      $query3=mysqli_query($conn,"SELECT * FROM courses WHERE Start_date>=DATE_SUB(now(), INTERVAL 0 MONTH)");
      $rows2=mysqli_num_rows($query3);
      if($rows2>0){
        echo "<center><font color=red>Certificate Courses</font></center>";?>
        <ol style="padding-left:20px; padding-right:5px;"><?php
        while($rows2 = mysqli_fetch_array($query3))
        {
          $date1 =explode("-",$rows2['Start_date']);
          $date2=implode("-",array($date1[2],$date1[1],$date1[0]));
          $noti=$rows2['Course_title']." starts from ".$date2;
          ?><li style="padding:5px;"><a href="viewcourses.php"><?php echo $noti; ?></a></li><br><?php
        }?></ol><?php
      }
    ?>
  </div>
  <?php

  ?><center>
    <div class="column6">
      <h3>BOOK REQUEST</h3>
      <form action="" method="POST">
        <label for="user_id">User Id</label><br>
        <input type="text" required  name="user_id" value="<?php echo $user_id; ?>"placeholder="User Id"/><br>
        <label for="book_id">Book Id</label><br>
        <input type="text" required  name="request" value="<?php echo $request; ?>" placeholder="Request"/><br>
        <input type="submit" name="Issue" value="Request" class="submit_button submit_button1">
      </form>
    </div>
  
    <?php
      $user_id=$_POST['user_id'];
      $requests=$_POST['request'];
      require_once "db_connect.php";
      $sql1=mysqli_query($conn,"INSERT into requests(User_id,requests) Values (".$user_id.",".$requests.")");
echo "<script>alert('Request sent Successfully')</script>";    
 
     
     ?> 
</center>
</body>
<html>
<?php
}
?>