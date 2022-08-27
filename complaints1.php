<?php
$complaint = $user_id = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $complaint = $_POST['complaint'];
  $user_id = $_POST['user_id'];
}
Complaint($complaint,$user_id);

function Complaint($complaint,$user_id)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Write Complaint</title>
<link rel="stylesheet" href="css/all.css">
</head>
<?php require_once 'side.php'; 
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
          ?><li style="padding:5px;"><a href="viewcourses1.php"><?php echo $noti; ?></a></li><br><?php
        }?></ol><?php
      }
    ?>
  </div>
  <?php

  ?><center>
    <div class="column6">
      <h3>WRITE COMPLAINT</h3>
      <form action="" method="POST">
        <label for="user_id">User Id</label><br><font size=2 color=red>User Id is not mandatory</font><br>
        <input type="text" required  name="user_id" value="<?php echo $user_id; ?>"placeholder="User Id"/><br>
        <label for="complaint" required>Write Complaint here</label><br>
        <textarea rows="8" cols="50" name="complaint" value="<?php echo $complaint; ?>" required></textarea><br>

        <input type="submit" name="Submit" value="Submit" class="submit_button submit_button1">
       
      </div>
        </form>
      
</div>
</center>
<html>
<?php
  if( isset($_POST['Submit']))
  { 
    $complaint = $_POST['complaint'];
    $user_id = $_POST['user_id'];

    $sql=mysqli_query($conn,"INSERT INTO complaints (Complaint, User_id) VALUES ('".$complaint."',".$user_id.")");
    echo "INSERT INTO complaints (Complaint, User_id) VALUES ('".$complaint."',".$user_id.")";
    if($sql)
    {
      echo "<script>alert('A Complaint has been registered')</script>";
      echo "<script>window.location = 'complaints.php'</script>";
    }
    else
    {
      echo "<script>alert('There is a problem in Database, please try again later.')</script>";
      echo "<script>window.location = 'complaints.php'</script>";
    }
  }
}
?>