<?php
$user_name = $dob = $email = $address = $pwd = $mobile = $access = $uniqueid =  "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $user_name=$_POST['user_name'];
  $dob=$_POST['dob'];
  $email=$_POST['email'];
  $address=$_POST['address'];
  $pwd=$_POST['pwd'];
  $mobile=$_POST['mobile'];
  $access=$_POST['access'];
 $uniqueid=$_POST['uniqueid'];
}
Adduser($user_name,$dob,$email,$address,$pwd,$mobile,$access,$uniqueid);

function Adduser($user_name,$dob,$email,$address,$pwd,$mobile,$access,$uniqueid)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Add User</title>
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
      <h3>ADD AN USER</h3>
      <form action="" method="POST">
        <label for="user_name">User Name</label><br>
        <input type="text" required  name="user_name" value="<?php echo $user_name; ?>"placeholder="User Name"/><br>
        <label for="dob" required>Date of Birth</label><br>
        <input type="text" name="dob" value="<?php echo $dob; ?>" required placeholder="DD/MM/YYYY" </br><br>
        <label for="email">Email</label><br>
        <input type="text" name="email" value="<?php echo $email; ?>" required placeholder="email" style="text-transform: lowercase;"/><br>
        <label for="mobile">Mobile Number</label><br>
        <input type="text" required size=10 name="mobile" value="<?php echo $mobile; ?>" placeholder="Mobile Number"/><br>
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
        <label for="uniqueid"> Unique ID</label><br>
        <input type="text" required name="uniqueid" value="<?php echo $uniqueid; ?>" placeholder="Enter your Unique ID"/><br>
       
        <input type="submit" name="add" value="Add" class="submit_button submit_button1">
       
      </div>
        </form>
        <?php
  if( isset($_POST['add']))
  { 
    $user_name=$_POST['user_name'];
    $dob=$_POST['dob'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $pwd=$_POST['pwd'];
    $mobile=$_POST['mobile'];
    $access=$_POST['access'];
    $contact=floor($mobile/1000000000);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
      echo "<script>alert('Please enter a valid Email address')</script>";
      unset($_POST['add']);
      //Adduser($user_name,$dob,$email,$address,$pwd,$mobile,$access);
    }
    elseif($contact!=6 && $contact!=7 && $contact!=8 && $contact!=9)
    {
      echo "<script>alert('Please enter a valid mobile number')</script>";
      unset($_POST['add']);
    }
    elseif(!preg_match("/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?=(.*[\W]){1,})(?!.*\s).{8,20}$/",str_replace("'","\'",$pwd)))
    {
      echo "<script>alert('Please enter a valid password')</script>";
      unset($_POST['add']);
    }
    else
    {
      require_once 'db_connect.php';
      $date1=explode("/",$dob);
      $dob=$date1[2]."-".$date1[1]."-".$date1[0];
      
      $sql = mysqli_query($conn,"INSERT into users(Name, Dob, Mobile, Email, Access_type, Address, Password, Uniqueid) VALUES ('".$user_name."','".$dob."','".$mobile."','".$email."','".$access."','".$address."','".$pwd."',".$uniqueid." )");
      if($sql)
      {
        $sql1 = mysqli_query($conn,"SELECT Enrol_id FROM users WHERE Name='".$user_name."' AND Dob='".$dob."' AND Mobile=".$mobile." AND Email='".$email."' AND Access_type='".$access."' AND Password='".$pwd."'ORDER BY Enrol_id DESC LIMIT 1");
        $row=mysqli_num_rows($sql1);
        while($row=mysqli_fetch_array($sql1))
          $user_id=$row['Enrol_id'];
        echo "<script>alert('A user has been added with Id : ".$user_id."')</script>";
        echo "<script>window.location = 'adduser.php'</script>";
      }
      else
      {
        echo "<script>alert('email or phone number already existed')</script>";
        unset($_POST['add']);
      }
      
    }
  }?>
      
</div>
</center>
</html><?php
}
?>