<?php
$book_name = $author = $cost = $company = $copies =  "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $book_name=$_POST['book_name'];
  $author=$_POST['author'];
  $cost=$_POST['cost'];
  $company=$_POST['company'];
  $copies=$_POST['copies'];
}
Adduser($book_name,$author,$cost,$company,$copies);

function Adduser($book_name,$author,$cost,$company,$copies)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Add Book</title>
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
      <h3>ADD BOOK</h3>
      <form action="" method="POST">
        <label for="book_name">Book Name</label><br>
        <input type="text" required  name="book_name" value="<?php echo $book_name; ?>"placeholder="Book Name"/><br>
        <label for="author">Author</label><br>
        <input type="text" required  name="author" value="<?php echo $author; ?>"placeholder="Author name"/><br>
        <label for="cost">Book Cost</label><br>
        <input type="text" required  name="cost" value="<?php echo $cost; ?>"placeholder="Book Cost"/><br>
        <label for="company">Book Company</label><br>
        <input type="text" required  name="company" value="<?php echo $company; ?>"placeholder="Book Company"/><br>
        <label for="company">Number of Copies</label><br>
        <input type="text" required  name="copies" value="<?php echo $copies; ?>"placeholder="Number of copies Issuing"/><br>
        <input type="submit" name="add" value="Add" class="submit_button submit_button1">
       
      </div>
        </form>
    
</div>
</center>
<html>
<?php
  if( isset($_POST['add']))
  { 
    $book_name=$_POST['book_name'];
    $author=$_POST['author'];
    $cost=$_POST['cost'];
    $company=$_POST['company'];
   $copies=$_POST['copies'];

    require_once 'db_connect.php';
    $sql = mysqli_query($conn,"INSERT into books(Author,Book,Cost,Company,Numofcopies) VALUES ('".$author."','".$book_name."','".$cost."','".$company."',".$copies.")");
    if($sql)
    {
      echo "<script>alert('A Book has been added to Library')</script>";
      echo "<script>window.location = 'addbook.php'</script>";
    }
    else
    {
      echo "<script>alert('There is a problem in adding book, try later')</script>";
      unset($_POST['add']);
    }
      
    }
  }
?>