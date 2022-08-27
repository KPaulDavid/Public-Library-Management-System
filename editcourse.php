<?php
$course_id = $title = $duration = $start_date = $dept = $timings = $fee = $further_details = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $course_id = $_POST['course_id'];
  $title = $_POST['title'];
  $duration = $_POST['duration'];
  $start_date = $_POST['start_date'];
  $dept = $_POST['dept'];
  $timings = $_POST['timings'];
  $fee = $_POST['fee'];
  $further_details = $_POST['further_details'];
}
EditCourse($course_id,$title,$duration,$start_date,$dept,$timings,$fee,$further_details);

function EditCourse($course_id,$title,$duration,$start_date,$dept,$timings,$fee,$further_details)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Edit Course</title>
<link rel="stylesheet" href="css/all.css">
</head>
<?php require_once 'main.php'; 
require_once 'db_connect.php';?>
<body>
<div class="row">
  <div class="column1" style="height:150%; text-align:justify">
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
  <div class="column2" style="height:150%;">
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
    <div class="column6" style="height:150%;">
      <h3>EDIT COURSE</h3>
      <form action="" method="POST">
        <input type="hidden" name="title" value="<?php echo $title; ?>">
        <input type="hidden" name="duration" value="<?php echo $duration; ?>"/>
        <input type="hidden" name="start_date" value="<?php echo $start_date; ?>"/>
        <input type="hidden"  name="dept" value="<?php echo $dept; ?>"/>
        <input type="hidden" name="timings" value="<?php echo $timings; ?>"/>
        <input type="hidden" name="fee" value="<?php echo $fee; ?>"/>
        <input type="hidden" name="further_details" value="<?php echo $further_details; ?>">
        
        <label for="course_id">Please enter Course Id</label><br>
        <input type="text" name="course_id" value="<?php echo $course_id; ?>" placeholder="Course Id"><br>
        <input type="submit" name="View" value="View" class="submit_button submit_button1">
       
      
        </form>
      <?php
  if( isset($_POST['View']))
  { 
    
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $start_date = $_POST['start_date'];
    $dept = $_POST['dept'];
    $timings = $_POST['timings'];
    $fee = $_POST['fee'];
    $further_details = $_POST['further_details'];

    $sql=mysqli_query($conn,"SELECT * FROM courses WHERE Course_id=".$course_id);
    $row = mysqli_num_rows($sql);
    if($row>0)
    {
      while($row = mysqli_fetch_array($sql))
      {
        $course_id = $row['Course_id'];
        $title = $row['Course_title'];
        $duration = $row['Duration'];
        $start_date = $row['Start_date'];
        $dept = $row['Department'];
        $timings = $row['Timings'];
        $fee = $row['Fee'];
        $further_details = $row['Further_details'];
      }?>
      <form action="" method="POST">
      <label for="title">Course Name</label><br>
        <input type="text" required  name="title" value="<?php echo $title; ?>"placeholder="Course Name"/><br>
        <label for="duration" required>Duration of Course</label><br>
        <input type="text" name="duration" value="<?php echo $duration; ?>" required placeholder="Course Duration"/></br>
        <label for="start_date">Starting Date</label><br>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>" required placeholder="Starting Date"/><br>
        <label for="dept">Organizing Department</label><br>
        <input type="text" required size=10 name="dept" value="<?php echo $dept; ?>" placeholder="Department Name"/><br>
        <label for="timings">Timings</label><br>
        <input type="text" required name="timings" value="<?php echo $timings; ?>" placeholder="Timings"/><br>
        <label for="fee">Course Fee</label><br>
        <input type="text" required name="fee" value="<?php echo $fee; ?>" placeholder="Course Fee"/><br>
        <label for="further_details">Further Details</label><br>
        <input type="text" name="further_details" value="<?php echo $further_details; ?>" placeholder="Further Details">
        <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
        <br>
        
        <input type="submit" name="Edit" value="Edit" class="submit_button submit_button1">
      </form><?php
    }  
    else
    {
      echo "<script>alert('We Could not find any course with course id  ".$course_id."')</script>";
      unset($_POST['View']);
    }
  }
  elseif(isset($_POST['Edit']))
  {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $start_date = $_POST['start_date'];
    $dept = $_POST['dept'];
    $timings = $_POST['timings'];
    $fee = $_POST['fee'];
    $further_details = $_POST['further_details'];

    $sql2=mysqli_query($conn,"UPDATE courses SET Course_title='".$title."', Duration='".$duration."', Start_date='".$start_date."', Department='".$dept."', Timings='".$timings."', Fee='".$fee."', Further_details='".$further_details."' WHERE Course_id=".$course_id);
    //echo "UPDATE users SET Course_title='".$title."', Duration='".$duration."', Start_date='".$start_date."', Department='".$dept."', Timings='".$timings."', Fee='".$fee."', Further_details='".$further_details."' WHERE Course_id=".$course_id;

    if($sql2)
    {
      echo "<script>alert('A Course has been Updated successfully')</script>";
      echo "<script>window.location = 'editcourse.php'</script>";
    }
    else
    {
      echo "<script>alert('There is a problem in Database, please try again.')</script>";
      echo "<script>window.location = 'editcourse.php'</script>";
    }
  }
    ?>
     </div> 
</div>
</center>
</body>
</html><?php
}
?>