<?php
Userbooks();
function Userbooks()
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Books Usage</title>
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
        echo "<center><font color=red>Library Fests</font></center>";?>
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
        echo "<center><font color=red>Certified Courses from Library</font></center>";?>
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
      
      <p align=justify style="padding-left:10%; width:80%; "><font size=4.5px><i>&nbsp &nbsp &nbsp &nbsp Library management system is a website which aims in developing a computerized system to maintain all the daily work of library .This project has many advanced features which are generally not available in normal library management systems like facility of user login .It also has a facility of admin login through which the admin can monitor  the whole system .It also has facility of an online notice board where teachers can put up information about workshops, certificate courses and seminars being held in our colleges or nearby college and  after proper verification by librarian from the concerned institution organizing the seminar can add it to the notice board. It has also a facility where Users after logging in their accounts can see list of books issued and its issue date and return date and also the Users can request the librarian to add new books by filling the book request form. The librarian after logging into his account i.e. admin account can see various requests and complaints such as viewing complaints.<br>
Overall this project of ours is being developed to help the Users as well as staff of library to maintain the library in the best way possible and also reduce the human efforts and to make it user friendly.</i></font></p><br>
     </div> 
          
</div>
</center>
</html>
<?php
}
?>