<?php
$program_name = $start_date = $department =  $program_id = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $program_name=$_POST['program_name'];
  $start_date=$_POST['start_date'];
  $department=$_POST['department'];
  $program_id=$_POST['program_id'];
}
EditProgram($program_name,$start_date,$department,$program_id);

function EditProgram($program_name,$start_date,$department,$program_id)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Edit Program</title>
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
      <h3>EDIT PROGRAM</h3>
      <form action="" method="POST">
        <label for="user_name">Plese enter Program Id</label><br>
        <input type="text" required  name="program_id" value="<?php echo $program_id; ?>"placeholder="Program Id"/>
        <br><input type="hidden" name="program_name" value="<?php echo $program_name; ?>">
        <input type="hidden" name="start_date" value="<?php echo $start_date; ?>">
        <input type="hidden" name="department" value="<?php echo $department; ?>">

        <input type="submit" name="view" value="View" class="submit_button submit_button1">
       
        </form>
        <?php
  if( isset($_POST['view']))
  { 
    $program_name=$_POST['program_name'];
    $start_date=$_POST['start_date'];
    $department=$_POST['department'];
    $program_id=$_POST['program_id'];

      require_once 'db_connect.php';
      if(is_numeric($program_id))
        $program_id=$program_id;
      else
        $program_id=0;
      $sql = mysqli_query($conn,"SELECT * FROM programs WHERE Program_id=".$program_id);
      $row = mysqli_num_rows($sql);
      while($row = mysqli_fetch_array($sql))
      {
        $program_name=$row['Program_name'];
        $start_date=$row['Start_date'];
        $department=$row['Department'];
      }
      if($program_name == '')
      {
        echo "<script>alert('No Program existed with Program id ".$program_id."')</script>";
        echo "<script>window.location = 'editprogram.php'</script>";
      }
      else
      {?>
        
        <form action="" method="POST">
        <label for="user_name">Program Name</label><br>
        <input type="text" required  name="program_name" value="<?php echo $program_name; ?>"placeholder="Program Name"/>
        <br>
        <label for="dob" required>Start Date</label><br>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>" required/></br>
        <label for="department">Department</label><br>
        <input type="text" name="department" value="<?php echo $department; ?>" required placeholder="department"/><br>
        <input type="hidden" name="program_id" value="<?php echo $program_id; ?>">

        <input type="submit" name="edit" value="Edit" class="submit_button submit_button1">
        </form><?php
      }
      
  }
  if( isset($_POST['edit']))
  {
    $program_name=$_POST['program_name'];
    $start_date=$_POST['start_date'];
    $department=$_POST['department'];
    $program_id=$_POST['program_id'];
    require_once 'db_connect.php';
    $sql1=mysqli_query($conn,"UPDATE programs SET Program_name='".$program_name."',Start_date='".$start_date."',Department='".$department."' WHERE Program_id=".$program_id);
    if($sql1)
    {
      echo "<script>alert('Your Program has been updated.')</script>";
      echo "<script>window.location = 'editprogram.php'</script>";
    }
    else
    {
      echo "<script>alert('There is a problem in updating, please try again later.')</script>";
      echo "<script>window.location = 'editprogram.php'</script>";
    }
  }
  ?>
     </div>  
</div>
</center>
</html><?php
}
?>