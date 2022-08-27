<?php
$title = $duration = $start_date = $dept = $timings = $fee = $further_details = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $title = $_POST['title'];
  $duration = $_POST['duration'];
  $start_date = $_POST['start_date'];
  $dept = $_POST['dept'];
  $timings = $_POST['timings'];
  $fee = $_POST['fee'];
  $further_details = $_POST['further_details'];
}
AddCourse($title,$duration,$start_date,$dept,$timings,$fee,$further_details);

function AddCourse($title,$duration,$start_date,$dept,$timings,$fee,$further_details)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Add Course</title>
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
    <div class="column6" style="height:120%;">
      <h3>ADD COURSE</h3>
      <form action="" method="POST">
        <label for="title">Course Name</label><br>
        <input type="text" required  name="title" value="<?php echo $title; ?>"placeholder="Course Name"/><br>
        <label for="duration" required>Duration of Course</label><br>
        <input type="text" name="duration" value="<?php echo $duration; ?>" required placeholder="Course Duration"/></br>
        <label for="start_date">Starting Date</label><br>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>" required placeholder="Starting Date"/><br>
        <label for="dept">Organizing Department</label><br>
        <input type="text" required name="dept" value="<?php echo $dept; ?>" placeholder="Department Name"/><br>
        <label for="timings">Timings</label><br>
        <input type="text" required name="timings" value="<?php echo $timings; ?>" placeholder="Timings"/><br>
        <label for="fee">Course Fee</label><br>
        <input type="text" required name="fee" value="<?php echo $fee; ?>" placeholder="Course Fee"/><br>
        <label for="further_details">Further Details</label><br>
        <input type="text" name="further_details" value="<?php echo $further_details; ?>" placeholder="Further Details">
        <br>
        
        <input type="submit" name="add" value="Add" class="submit_button submit_button1">
       
      </div>
        </form>
      
</div>
</center>
<html>
<?php
  if( isset($_POST['add']))
  { 
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $start_date = $_POST['start_date'];
    $date1=explode("/",$start_date);
    $start_date=$date1[2]."-".$date1[1]."-".$date1[0];
    $dept = $_POST['dept'];
    $timings = $_POST['timings'];
    $fee = $_POST['fee'];

    $sql=mysqli_query($conn,"INSERT INTO courses (Course_title, Duration, Start_date, Department, Timings, Fee, Further_details) VALUES ('".$title."','".$duration."','".$start_date."','".$dept."','".$timings."','".$fee."','".$further_details."') ");
    if($sql)
    {
      $sql1=mysqli_query($conn,"SELECT Course_id FROM courses WHERE Course_title='".$title."' AND Duration='".$duration."' AND Start_date='".$start_date."' AND Department='".$dept."' AND Timings='".$timings."' AND Fee='".$fee."' AND Further_details='".$further_details."' ORDER BY Course_id DESC LIMIT 1");
      $row=mysqli_num_rows($sql1);
      while($row=mysqli_fetch_array($sql1))
        $course_id=$row['Course_id'];
      echo "<script>alert('A Course has been added with Course Id : ".$course_id."')</script>";
      echo "<script>window.location = 'addcourse.php'</script>";
    }
    else
    {
      echo "<script>alert('There is a problem in Database, please try later.')</script>";
      unset($_POST['add']);
    }
  }
}
?>