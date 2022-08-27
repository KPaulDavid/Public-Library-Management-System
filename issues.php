<?php
$user_name = $book_name = $user_id = $book_id = $author = $status = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $user_name=$_POST['user_name'];
  $book_name=$_POST['book_name'];
  $user_id=$_POST['user_id'];
  $book_id=$_POST['book_id'];
  $author=$_POST['author'];
  $status=$_POST['status'];
}
Issues($user_name,$book_name,$user_id,$book_id,$author,$status);

function Issues($user_name,$book_name,$user_id,$book_id,$author,$status)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Book Issue</title>
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
      <h3>BOOK ISSUES</h3>
      <form action="" method="POST">
        <label for="user_id">User Id</label><br>
        <input type="text" required  name="user_id" value="<?php echo $user_id; ?>"placeholder="User Id"/><br>
        <label for="book_id">Book Id</label><br>
        <input type="text" required  name="book_id" value="<?php echo $book_id; ?>" placeholder="Book Id"/><br>
        <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
        <input type="hidden" name="book_name" value="<?php echo $book_name; ?>">
        <input type="hidden" name="author" value="<?php echo $author; ?>">
        <input type="hidden" name="status" value="<?php echo $status; ?>">

        <input type="submit" name="Issue" value="Issue" class="submit_button submit_button1">
      </form>
    </div>
  
    <?php
    if( isset($_POST['Issue']))
    { 
      $user_name=$_POST['user_name'];
      $book_name=$_POST['book_name'];
      $user_id=$_POST['user_id'];
      $book_id=$_POST['book_id'];
      $author=$_POST['author'];
      require_once "db_connect.php";
      $sql1=mysqli_query($conn,"SELECT Name from users WHERE Enrol_id=".$user_id."");
      $row1 = mysqli_num_rows($sql1);
      while ($row1 = mysqli_fetch_array($sql1))
        $user_name = $row1['Name'];
      if($user_name == '')
      {
      	echo("<script>alert('User Details not existed with User Id ".$user_id."')</script>");
      	unset($_POST['Issue']);
      }
      require_once "db_connect.php";
      $sql2=mysqli_query($conn,"SELECT Book, Author, Status,Numofcopies from books WHERE Book_id=".$book_id."");
      $row2 = mysqli_num_rows($sql2);
      while ($row2 = mysqli_fetch_array($sql2))
      {
        $book_name = $row2['Book'];
        $author = $row2['Author'];
        $status = $row2['Status'];
        $copies = $row2['Numofcopies']; 
     }
      if($book_name == '')
      {
      	echo("<script>alert('Book Details not existed with Book Id ".$book_name."')</script>");
      	unset($_POST['Issue']);
      }
      if($user_name!='' && $book_name!='')
      {
      ?>
      <script>
        var r =confirm("Please check details once\n\nUser Name   : <?php echo $user_name; ?>\nBook name   : <?php echo $book_name; ?> \nAuthor Name: <?php echo $author; ?> \n Available copies: <?php echo $copies; ?> \nAvailability    : <?php echo $status; ?>")
        if (r == true) 
        {
          <?php 
          require_once 'db_connect.php';
          if($status =="Available" || $status=="")
            $sql=mysqli_query($conn,"Insert Into issues (Book_id,User_id) values (".$book_id.",".$user_id.")");
          else
            $sql=false;
          if($sql)
          {?>
            alert('Book has been issued successfully');
            window.location = 'issues.php';<?php
            $status="Not Available";
            $sql1=mysqli_query($conn,"UPDATE books SET Status='".$status."' WHERE Book_id=".$book_id."");
          } 
          else
          {?>
            alert('The Book Status is unavailable, so it cannot be issued');
            window.location = 'issues.php';<?php
          }?>
        }
        else 
        {
          <?php unset($_POST['Issue']); ?>
        }
      </script><?php
  	 }
    }?> 
</div>
</center>
</body>
<html>
<?php
}
?>