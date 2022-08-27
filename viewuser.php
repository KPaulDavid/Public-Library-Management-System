<?php
$choose = $user_id = $user_name = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $choose=$_POST['choose'];
  $user_id=$_POST['user_id'];
  $user_name=$_POST['user_name'];
}
ViewUser($choose,$user_id,$user_name);

function ViewUser($choose,$user_id,$user_name)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<script type="text/javascript">
function choose() 
{
    if (document.getElementById('userid').checked) 
    {
      document.getElementById('useridyes').style.display = 'block';
      document.getElementById('nameyes').style.display = 'none';
    }
    else if (document.getElementById('name').checked) 
    {
      document.getElementById('useridyes').style.display = 'none';
      document.getElementById('nameyes').style.display = 'block';
    }
}
</script>
<title>View Users</title>
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
      <h3>VIEW USER</h3>
      <p style="color:red;"> *Please choose one option to view books*</p>

      View by Id<input type="radio" onclick="choose();" name="choose" id="userid" value="User_id" required>&nbsp;&nbsp;
      View by name<input type="radio" onclick="choose();" name="choose" id="name" value="Name" required>&nbsp;&nbsp;
      
    <br><br>
<!-- -------------------------------------------User Id Section------------------------------------------------ -->
<form name="userid" action="" method="POST">
<div id="useridyes" style="display: none;" ><br>
  <label for="book_name">Please enter User Id here</label><br>
  <input type="text" required  name="user_id" value="<?php echo $user_id; ?>"placeholder="User Id"/><br>
  <input type="hidden" name="choose" value="<?php echo $choose; ?>">
  <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">

  <input type="submit" name="user_id_view" value="View" class="submit_button submit_button1">
</div>
</form>
<!-- -------------------------------------------Name Section------------------------------------------------ -->
<form name="name" action="" method="POST">
<div id="nameyes" style="display: none;" >
  <label for="user_name">Please enter User Name here</label><br>
  <input type="text" required  name="user_name" value="<?php echo $user_name; ?>"placeholder="User Name"/><br>
  <input type="hidden" name="choose" value="<?php echo $choose; ?>">
  <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

  <input type="submit" name="name_view" value="View" class="submit_button submit_button1">
</div>
</form>

<?php
if(isset($_POST['user_id_view']))
{
  $choose=$_POST['choose'];
  $user_id=$_POST['user_id'];
  $user_name=$_POST['user_name'];
  //echo $book_name;

  require_once 'db_connect.php';
  if(is_numeric($user_id))
    $user_id=$user_id;
  else
    $user_id=0;
  $sql = mysqli_query($conn,"SELECT * FROM users WHERE Enrol_id=".$user_id."");
  //echo "SELECT * FROM users WHERE Enrol_id=".$user_id."";
  $row = mysqli_num_rows($sql);
  if($row>0)
  {
  ?>
    <table border=1 align="center" style="table-layout: fixed; width: 90%;"><?php 
    while($row = mysqli_fetch_array($sql))
    {?>
      <tr>
        <th>ID Number</th>
        <td><center><?php echo $row['Enrol_id']; ?></center></td>
      </tr>
      <tr>
        <th>Name</th>
        <td><center><?php echo $row['Name']; ?></center></td>
      </tr>
      <tr>
        <th>Date of Birth</th>
        <td><center><?php echo $row['Dob']; ?></center></td>
      </tr>
      <tr>
        <th>Mobile Number</th>
        <td><center><?php echo $row['Mobile']; ?></center></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><center><?php echo $row['Email']; ?></center></td>
      </tr>
      <tr>
        <th>Access Type</th>
        <td><center><?php echo $row['Access_type']; ?></center></td>
      </tr>
      <tr>
        <th>Address</th>
        <td><center><?php echo $row['Address']; ?></center></td>
      </tr>
      <tr>
        <th>Password</th>
        <td><center><?php echo $row['Password']; ?></center></td>
      </tr>
    </table>
   <?php
   }
  }
  else
  {
    echo "<script>alert('No Users found')</script>";
    echo "<script>window.location = 'viewuser.php'</script>";
  }
}
elseif(isset($_POST['name_view']))
{
  $choose=$_POST['choose'];
  $user_id=$_POST['user_id'];
  $user_name=$_POST['user_name'];
  //echo $book_name;

  require_once 'db_connect.php';
  $sql = mysqli_query($conn,"SELECT * FROM users WHERE Name LIKE '%".$user_name."%' LIMIT 3");
  //echo "SELECT * FROM books WHERE Book='%".$book_name."%'";
  $row = mysqli_num_rows($sql);
  if($row>0)
  {
  
    while($row = mysqli_fetch_array($sql))
    {?>
      <table border=1 align="center" style="table-layout: fixed; width: 90%;">
      <tr>
        <th>ID Number</th>
        <td><center><?php echo $row['Enrol_id']; ?></center></td>
      </tr>
      <tr>
        <th>Name</th>
        <td><center><?php echo $row['Name']; ?></center></td>
      </tr>
      <tr>
        <th>Date of Birth</th>
        <td><center><?php echo $row['Dob']; ?></center></td>
      </tr>
      <tr>
        <th>Mobile Number</th>
        <td><center><?php echo $row['Mobile']; ?></center></td>
      </tr>
      <tr>
        <th>Email</th>
        <td><center><?php echo $row['Email']; ?></center></td>
      </tr>
      <tr>
        <th>Access Type</th>
        <td><center><?php echo $row['Access_type']; ?></center></td>
      </tr>
      <tr>
        <th>Address</th>
        <td><center><?php echo $row['Address']; ?></center></td>
      </tr>
      <tr>
        <th>Password</th>
        <td><center><?php echo $row['Password']; ?></center></td>
      </tr>
    </table>
   <?php
   echo "<br>";
   }
  }
  else
  {
    echo "<script>alert('No Users found')</script>";
    echo "<script>window.location = 'viewbooks.php'</script>";
  }
}
?>
</div>    

</div>
</form>
</center>
<html>
<?php
}
?>