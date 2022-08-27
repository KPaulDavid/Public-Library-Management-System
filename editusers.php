<?php
$choose = $user_id = $user_name = $dob = $email = $address = $pwd = $mobile = $access = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $choose=$_POST['choose'];
  $user_id=$_POST['user_id'];
  $user_name=$_POST['user_name'];
  $dob=$_POST['dob'];
  $email=$_POST['email'];
  $address=$_POST['address'];
  $pwd=$_POST['pwd'];
  $mobile=$_POST['mobile'];
  $access=$_POST['access'];
}
EditUser($choose,$user_id,$user_name,$dob,$email,$address,$pwd,$mobile,$access);

function EditUser($choose,$user_id,$user_name,$dob,$email,$address,$pwd,$mobile,$access)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Edit Users</title>
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
      <h3>EDIT USERS</h3>
      <form action="" method="POST">
      Please Enter User Id
      <br><input type="text" required  name="user_id" value="<?php echo $user_id; ?>"placeholder="User Id"/><br>
      <input type="hidden" name="choose" value="<?php echo $choose; ?>">
      <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
      <input type="hidden" name="dob" value="<?php echo $dob; ?>">
      <input type="hidden" name="email" value="<?php echo $email; ?>">
      <input type="hidden" name="address" value="<?php echo $address ;?>">
      <input type="hidden" name="pwd" value="<?php echo $pwd; ?>">
      <input type="hidden" name="mobile" value="<?php echo $mobile; ?>">
      <input type="hidden" name="access" value="<?php echo $access; ?>">
      <input type="submit" name="View" value="View" class="submit_button submit_button1">   

      </form>  
    <br><br>
<?php
if(isset($_POST['View']))
{
  $choose=$_POST['choose'];
  $user_id=$_POST['user_id'];
  $user_name=$_POST['user_name'];
  $dob=$_POST['dob'];
  $email=$_POST['email'];
  $address=$_POST['address'];
  $pwd=$_POST['pwd'];
  $mobile=$_POST['mobile'];
  $access=$_POST['access'];
  //echo $book_name;

  require_once 'db_connect.php';
  $sql = mysqli_query($conn,"SELECT * FROM users WHERE Enrol_id=".$user_id);
  //echo "SELECT * FROM users WHERE Enrol_id=".$user_id;
  $row = mysqli_num_rows($sql);
  if($row>0)
  {
  while($row = mysqli_fetch_array($sql))
  {
    $user_name=$row['Name'];
    $dob=$row['Dob'];
    $email=$row['Email'];
    $address=$row['Address'];
    $pwd=$row['Password'];
    $mobile=$row['Mobile'];
    $access=$row['Access_type'];
  }
  ?>
  <form action="" method="POST">
        <label for="user_name">User Name</label><br>
        <input type="text" required  name="user_name" value="<?php echo $user_name; ?>"placeholder="User Name"/><br>
        <label for="dob" required>Date of Birth</label><br>
        <input type="date" name="dob" value="<?php echo $dob; ?>" required/></br>
        <label for="email">Email</label><br>
        <input type="text" name="email" value="<?php echo $email; ?>" readonly placeholder="email" style="text-transform: lowercase;"/><br>
        <label for="mobile">Mobile Number</label><br>
        <input type="text" size=10 name="mobile" readonly value="<?php echo $mobile; ?>" placeholder="Mobile Number"/><br>
        <label for="address">Address</label><br>
        <input type="text" required name="address" value="<?php echo $address; ?>" placeholder="Address"/><br>
        <?php
          $table_name = "users";
          $column_name="Access_type";
          $result =mysqli_query($conn,"SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$table_name."' AND COLUMN_NAME ='".$column_name."'");
          $row = mysqli_fetch_array($result);
          $enumList= explode(",",str_replace("'", "", substr($row['COLUMN_TYPE'],5, (strlen($row['COLUMN_TYPE'])-6))));
          if($access == '')
          {
            $access="--Access Type--";
          }
          $av=$access;
        ?>
        <label for="access">Access Type</label><br>
          <select required name="access" id="select">
            <?php 
            echo "<option value='$av'>$access</option>";
            foreach ($enumList as $value)
            {
              if($value == $access)
                 continue;
              else
                echo  "<option value='$value'>$value</option>";
            }
          ?>
          </select>
        <br>
        <label for="pwd">Password</label><br>
        <font size=2 color=red>Should contain 8 letters with combination of Capital, small, special character & number</font><br>
        <input type="text" name="pwd" value="<?php echo $pwd; ?>" placeholder="Password"/><br>
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="choose" value="<?php echo $choose; ?>">

        <input type="submit" name="Edit" value="Edit" class="submit_button submit_button1"><br>
       
        </form><?php
  }
  else
  {
    echo "<script>alert('No Users found')</script>";
    echo "<script>window.location = 'editusers.php'</script>";
  }
}
elseif(isset($_POST['Edit']))
{
  $choose=$_POST['choose'];
  $user_id=$_POST['user_id'];
  $user_name=$_POST['user_name'];
  $dob=$_POST['dob'];
  $email=$_POST['email'];
  $address=$_POST['address'];
  $pwd=$_POST['pwd'];
  $mobile=$_POST['mobile'];
  $access=$_POST['access'];

  $sql1=mysqli_query($conn,"UPDATE users SET Name='".$user_name."',Dob='".$dob."',Email='".$email."',Address='".$address."',Password='".$pwd."',Mobile='".$mobile."',Access_type='".$access."' WHERE Enrol_id=".$user_id."");
  if($sql1)
  {
    echo "<script>alert('User Details has been updated')</script>";
    echo "<script>window.location = 'editusers.php'</script>";
  }
  else
  {
    echo "<script>alert('There is a problem in Database, please try later.')</script>";
    echo "<script>window.location = 'editusers.php'</script>";
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