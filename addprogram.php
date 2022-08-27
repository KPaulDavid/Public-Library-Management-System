<?php
$program_name = $start_date = $department =  "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $program_name=$_POST['program_name'];
  $start_date=$_POST['start_date'];
  $department=$_POST['department'];
}
AddProgram($program_name,$start_date,$department);

function AddProgram($program_name,$start_date,$department)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Add Program</title>
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
      <h3>ADD PROGRAM</h3>
      <form action="" method="POST">
        <label for="user_name">Program Name</label><br>
        <input type="text" required  name="program_name" value="<?php echo $program_name; ?>"placeholder="Program Name"/>
        <br>
        <label for="dob" required>Start Date</label><br>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>" required/></br>
        <label for="department">Department</label><br>
        <input type="text" name="department" value="<?php echo $department; ?>" required placeholder="department"/><br>

        <input type="submit" name="add" value="Add" class="submit_button submit_button1">
       
      </div>
        </form>
        <?php
  if( isset($_POST['add']))
  { 
    $program_name=$_POST['program_name'];
    $start_date=$_POST['start_date'];
    $department=$_POST['department'];

      require_once 'db_connect.php';
      $sql = mysqli_query($conn,"INSERT into programs(Program_name,Start_date,Department) VALUES ('".$program_name."','".$start_date."','".$department."')");
      if($sql)
      {
        $sql1=mysqli_query($conn,"SELECT Program_id FROM programs WHERE Program_name='".$program_name."' AND Start_date='".$start_date."' AND Department='".$department."' ORDER BY Program_id DESC LIMIT 1");
        $row=mysqli_num_rows($sql1);
        while($row=mysqli_fetch_array($sql1))
          $program_id=$row['Program_id'];
        echo "<script>alert('A Program has been added with Program_id : ".$program_id."')</script>";
        echo "<script>window.location = 'addprogram.php'</script>";
      }
      else
      {
        echo "<script>alert('There is a problem in inserting, try again later')</script>";
        unset($_POST['add']);
      }
      
  }?>
      
</div>
</center>
</html><?php
}
?>