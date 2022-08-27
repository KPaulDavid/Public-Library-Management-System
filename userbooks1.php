<?php
$user_id = $_GET["myid"];
Userbooks($user_id);

function Userbooks($user_id)
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
      <h3>Books Usage</h3>
    
       <?php

        $sql1=mysqli_query($conn,"SELECT books.Book,books.Author,issues.User_id,issues.Issue_date,issues.Return_date from books,users,issues WHERE issues.User_id=users.Enrol_id AND issues.Book_id=books.Book_id and users.Email='".$user_id."' ORDER BY Return_date LIMIT 12");
        $row1=mysqli_num_rows($sql1);
        $i=0;
        if($row1>0)
        {
          while ($row1 = mysqli_fetch_array($sql1))
          {
            if($i == 0)
            {
              ?><table border=1 align="center" style="table-layout: fixed; width: 90%;">
              <tr>
                <th>Book Name</th>
                <th>Author</th>
                <th>Issue Date</th>
                <th>Return Date</th>
              </tr>
             <?php
            }
            ?>  
            <tr>
              <td><?php echo $row1['Book']; ?></td>
              <td><?php echo $row1['Author']; ?></td>
              <td><?php echo $row1['Issue_date']; ?></td>
              <td><?php echo $row1['Return_date']; ?></td>
            </tr>
            <?php
            $i++;
          }
        }
        else
        {
          echo "No transactions found.";
        }
        ?></table><?php
        
          echo "<br><br>";

      ?>
    </div>
          
</div>
</center>
</html>
<?php
}
?>