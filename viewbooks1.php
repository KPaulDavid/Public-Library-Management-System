<?php
$choose = $book_name = $author = $status = $holder = $key_name = $book_id = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $choose=$_POST['choose'];
  $book_name=$_POST['book_name'];
  $author=$_POST['author'];
  $key_name=$_POST['key_name'];
  $status=$_POST['status'];
  $holder=$_POST['holder'];
  $book_id=$_POST['book_id'];
}
ViewBook($choose,$book_name,$author,$key_name,$status,$holder,$book_id);

function ViewBook($choose,$book_name,$author,$key_name,$status,$holder,$book_id)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
.submit_button {
  background-color: #01CEFE;
  border: none;
  color: white;
  padding: 12px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  
}
.submit_button1:hover {
  background-color: white ;
  color: white;
}
</style>
<script type="text/javascript">
function choose() 
{
    if (document.getElementById('book').checked) 
    {
      document.getElementById('bookyes').style.display = 'block';
      document.getElementById('numyes').style.display = 'none';
      document.getElementById('keyyes').style.display = 'none';
      document.getElementById('authyes').style.display = 'none';
    }
    else if (document.getElementById('num').checked) 
    {
      document.getElementById('bookyes').style.display = 'none';
      document.getElementById('numyes').style.display = 'block';
      document.getElementById('keyyes').style.display = 'none';
      document.getElementById('authyes').style.display = 'none';
    }
    else if (document.getElementById('key').checked) 
    {
      document.getElementById('bookyes').style.display = 'none';
      document.getElementById('numyes').style.display = 'none';
      document.getElementById('keyyes').style.display = 'block';
      document.getElementById('authyes').style.display = 'none';
    }
    else if (document.getElementById('auth').checked) 
    {
      document.getElementById('bookyes').style.display = 'none';
      document.getElementById('numyes').style.display = 'none';
      document.getElementById('keyyes').style.display = 'none';
      document.getElementById('authyes').style.display = 'block';
    }
    
}
</script>
<title>View Book</title>
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
      <h3>VIEW BOOK</h3>
      <p style="color:red;"> *Please choose one option to view books*</p>

      View by Book<input type="radio" onclick="choose();" name="choose" id="book" value="Book" required>&nbsp;&nbsp;
      View by Author<input type="radio" onclick="choose();" name="choose" id="auth" value="Auth" required>&nbsp;&nbsp;
      View by Num<input type="radio" onclick="choose();" name="choose" id="num" value="Num" required>&nbsp;&nbsp;
      View by Key word<input type="radio" onclick="choose();" name="choose" id="key" value="Key" required>&nbsp;&nbsp;
      
    <br><br>
<!-- -------------------------------------------Book Section------------------------------------------------ -->
<form name="book" action="" method="POST">
<div id="bookyes" style="display: none;" ><br>
  <label for="book_name">Please enter Book name here</label><br>
  <input type="text" required  name="book_name" value="<?php echo $book_name; ?>"placeholder="Book Name"/><br>
  <input type="hidden" name="choose" value="<?php echo $choose; ?>">
  <input type="hidden" name="author" value="<?php echo $author; ?>">
  <input type="hidden" name="key_name" value="<?php echo $key_name; ?>">
  <input type="hidden" name="status" value="<?php echo $status; ?>">
  <input type="hidden" name="holder" value="<?php echo $holder; ?>">
  <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
  <input type="submit" name="book_view" value="View" class="submit_button submit_button1">
</div>
</form>
<!-- -------------------------------------------Num Section------------------------------------------------ -->
<form name="num" action="" method="POST">
<div id="numyes" style="display: none;" >
  <label for="book_id">Please enter Book Number here</label><br>
  <input type="text" required  name="book_id" value="<?php echo $book_id; ?>"placeholder="Book Number"/><br>
  <input type="hidden" name="choose" value="<?php echo $choose; ?>">
  <input type="hidden" name="book_name" value="<?php echo $book_name; ?>">
  <input type="hidden" name="key_name" value="<?php echo $key_name; ?>">
  <input type="hidden" name="status" value="<?php echo $status; ?>">
  <input type="hidden" name="holder" value="<?php echo $holder; ?>">
  <input type="hidden" name="author" value="<?php echo $author; ?>">
  <input type="submit" name="num_view" value="View" class="submit_button submit_button1">
</div>
</form>
<!-- -------------------------------------------Key Section------------------------------------------------ -->
<form name="key" action="" method="POST">
<div id="keyyes" style="display: none;" >
  <label for="key_name">Please enter Key word here</label><br>
  <input type="text" required  name="key_name" value="<?php echo $key_name; ?>"placeholder="Key Word"/><br>
  <input type="hidden" name="choose" value="<?php echo $choose; ?>">
  <input type="hidden" name="book_name" value="<?php echo $book_name; ?>">
  <input type="hidden" name="author" value="<?php echo $author; ?>">
  <input type="hidden" name="status" value="<?php echo $status; ?>">
  <input type="hidden" name="holder" value="<?php echo $holder; ?>">
  <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
  <input type="submit" name="key_view" value="View" class="submit_button submit_button1">
</div>
</form>
<!-- -------------------------------------------Auth Section------------------------------------------------ -->
<form name="auth" action="" method="POST">
<div id="authyes" style="display: none;" >
  <label for="author">Please enter Author here</label><br>
  <input type="text" required  name="author" value="<?php echo $author; ?>"placeholder="Author Name"/><br>
  <input type="hidden" name="choose" value="<?php echo $choose; ?>">
  <input type="hidden" name="book_name" value="<?php echo $book_name; ?>">
  <input type="hidden" name="key_name" value="<?php echo $key_name; ?>">
  <input type="hidden" name="status" value="<?php echo $status; ?>">
  <input type="hidden" name="holder" value="<?php echo $holder; ?>">
  <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
  <input type="submit" name="auth_view" value="View" class="submit_button submit_button1">
</div>
</form>

<?php
if(isset($_POST['book_view']))
{
  $choose=$_POST['choose'];
  $book_name=$_POST['book_name'];
  $author=$_POST['author'];
  $key_name=$_POST['key_name'];
  $status=$_POST['status'];
  $holder=$_POST['holder'];
  $book_id=$_POST['book_id'];
  //echo $book_name;

  require_once 'db_connect.php';
  $sql = mysqli_query($conn,"SELECT * FROM books WHERE Book like '%".$book_name."%'");
  //echo "SELECT * FROM books WHERE Book='%".$book_name."%'";
  $row = mysqli_num_rows($sql);
  if($row>0)
  {
  ?>
    <table border=1 align="center" style="table-layout: fixed; width: 90%;">
      <tr>
        <th>Book Name</th>
        <th>Author</th>
        <th>Status</th>           
        <th>Holder</th>
      </tr><?php
      while ($row = mysqli_fetch_array($sql)) 
      {?>
      <tr>
        <td align= center><?php  echo $row['Book']; ?> </td>
        <td align= center><?php echo $row['Author']; ?> </td>
        <td align= center><?php echo $row['Status']; ?> </td>
         
        <?php 
        if($row['Status']=="Not Available")
        {
          $sql1 = mysqli_query($conn,"SELECT Name from users,issues WHERE users.Enrol_id=issues.User_id and Book_id='".$row['Book_id']."' AND issues.Return_date IS NULL");
          $row1 = mysqli_num_rows($sql1);
          while( $row1 = mysqli_fetch_array ($sql1))
            $holder= $row1['Name'];
        }?>
        <td align= center><?php echo $holder ?></td>
      </tr>
      <?php 
      }?>
  
    </table>
<td><td><td><center><input type="button" onclick="window.location.href = 'request.php'" Value="Take Book"  class="submit_button submit_button1"></center>
<?php
  }
  else
  {
    echo "<script>alert('No Books found')</script>";
    echo "<script>window.location = 'viewbooks1.php'</script>";
  }
}
elseif(isset($_POST['num_view']))
{
  $choose=$_POST['choose'];
  $book_name=$_POST['book_name'];
  $author=$_POST['author'];
  $key_name=$_POST['key_name'];
  $status=$_POST['status'];
  $holder=$_POST['holder'];
  $book_id=$_POST['book_id'];
  //echo $book_name;

  require_once 'db_connect.php';
  if(is_numeric($book_id))
    $book_id=$book_id;
  else
    $book_id=0;
  $sql = mysqli_query($conn,"SELECT * FROM books WHERE Book_id =".$book_id."");
  //echo "SELECT * FROM books WHERE Book='%".$book_name."%'";
  $row = mysqli_num_rows($sql);
  if($row>0)
  {
  ?>
    <table border=1 align="center" style="table-layout: fixed; width: 90%;">
      <tr>
        <th>Book Name</th>
        <th>Author</th>
        <th>Status</th>           
        <th>Holder</th>
      </tr><?php
      while ($row = mysqli_fetch_array($sql)) 
      {?>
      <tr>
        <td align= center><?php  echo $row['Book']; ?> </td>
        <td align= center><?php echo $row['Author']; ?> </td>
        <td align= center><?php echo $row['Status']; ?> </td>
        <?php 
        if($row['Status']=="Not Available")
        {
          $sql1 = mysqli_query($conn,"SELECT Name from users,issues WHERE users.Enrol_id=issues.User_id and Book_id='".$row['Book_id']."' AND issues.Return_date IS NULL");
          $row1 = mysqli_num_rows($sql1);
          while( $row1 = mysqli_fetch_array ($sql1))
            $holder= $row1['Name'];
        }?>
        <td align= center><?php echo $holder ?></td>
      </tr>
      <?php 
      }?>
    </table>
<center><input type="button" onclick="window.location.href = 'request.php'" Value="Take Book" class="submit_button submit_button1"></center>  
<?php
  }
  else
  {
    echo "<script>alert('No Books found')</script>";
    echo "<script>window.location = 'viewbooks1.php'</script>";
  }
}
elseif(isset($_POST['key_view']))
{
  $choose=$_POST['choose'];
  $book_name=$_POST['book_name'];
  $author=$_POST['author'];
  $key_name=$_POST['key_name'];
  $status=$_POST['status'];
  $holder=$_POST['holder'];
  $book_id=$_POST['book_id'];
  //echo $book_name;

  require_once 'db_connect.php';
  $sql = mysqli_query($conn,"SELECT * FROM books WHERE Author like '%".$key_name."%' OR Book like '%".$key_name."%'");
  //echo "SELECT * FROM books WHERE Book='%".$book_name."%'";
  $row = mysqli_num_rows($sql);
  if($row>0)
  {
  ?>
    <table border=1 align="center" style="table-layout: fixed; width: 90%;">
      <tr>
        <th>Book Name</th>
        <th>Author</th>
        <th>Status</th>           
        <th>Holder</th>
      </tr><?php
      while ($row = mysqli_fetch_array($sql)) 
      {?>
      <tr>
        <td align= center><?php  echo $row['Book']; ?> </td>
        <td align= center><?php echo $row['Author']; ?> </td>
        <td align= center><?php echo $row['Status']; ?> </td>
        <?php 
        if($row['Status']=="Not Available")
        {
          $sql1 = mysqli_query($conn,"SELECT Name from users,issues WHERE users.Enrol_id=issues.User_id and Book_id='".$row['Book_id']."' AND issues.Return_date IS NULL");
          $row1 = mysqli_num_rows($sql1);
          while( $row1 = mysqli_fetch_array ($sql1))
            $holder= $row1['Name'];
        }?>
        <td align= center><?php echo $holder ?></td>
      </tr>
      <?php 
      }?>
    </table>
<center><input type="button" onclick="window.location.href = 'request.php'" Value="Take Book" class="submit_button submit_button1"></center>
<?php
  }
  else
  {
    echo "<script>alert('No Books found')</script>";
    echo "<script>window.location = 'viewbooks1.php'</script>";
  }
}
elseif(isset($_POST['auth_view']))
{
  $choose=$_POST['choose'];
  $book_name=$_POST['book_name'];
  $author=$_POST['author'];
  $key_name=$_POST['key_name'];
  $status=$_POST['status'];
  $holder=$_POST['holder'];
  $book_id=$_POST['book_id'];
  //echo $book_name;

  require_once 'db_connect.php';
  $sql = mysqli_query($conn,"SELECT * FROM books WHERE Author like '%".$author."%'");
  //echo "SELECT * FROM books WHERE Book='%".$book_name."%'";
  $row = mysqli_num_rows($sql);
  if($row>0)
  {
  ?>
    <table border=1 align="center" style="table-layout: fixed; width: 90%;">
      <tr>
        <th>Book Name</th>
        <th>Author</th>
        <th>Status</th>           
        <th>Holder</th>
      </tr><?php
      while ($row = mysqli_fetch_array($sql)) 
      {?>
      <tr>
        <td align= center><?php  echo $row['Book']; ?> </td>
        <td align= center><?php echo $row['Author']; ?> </td>
        <td align= center><?php echo $row['Status']; ?> </td>
        <?php 
        if($row['Status']=="Not Available")
        {
          $sql1 = mysqli_query($conn,"SELECT Name from users,issues WHERE users.Enrol_id=issues.User_id and Book_id='".$row['Book_id']."' AND issues.Return_date IS NULL");
          $row1 = mysqli_num_rows($sql1);
          while( $row1 = mysqli_fetch_array ($sql1))
            $holder= $row1['Name'];
        }?>
        <td align= center><?php echo $holder ?></td>
      </tr>
      <?php 
      }?>
    </table>
<center><input type="button" onclick="window.location.href = 'request.php'" Value="Take-Book" class="submit_button submit_button1" ></center>

 <?php
  }
  else
  {
    echo "<script>alert('No Books found')</script>";
    echo "<script>window.location = 'viewbooks1.php'</script>";
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