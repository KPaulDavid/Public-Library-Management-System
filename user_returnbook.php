<?php
$user_name = $book_name = $user_id = $book_id = $author = $issuedate = $status = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $user_name=$_POST['user_name'];
  $book_name=$_POST['book_name'];
  $user_id=$_POST['user_id'];
  $book_id=$_POST['book_id'];
  $author=$_POST['author'];
  $status=$_POST['status'];
  $issuedate=$_POST['issuedate'];
}
Returns($user_name,$book_name,$user_id,$book_id,$author,$status,$issuedate);

function Returns($user_name,$book_name,$user_id,$book_id,$author,$status,$issuedate)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>Book Returns</title>
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
      <h3>BOOK RETURNS</h3>
      <form action="" method="POST">
        <label for="book_id">Book Id</label><br>
        <input type="text" required  name="book_id" value="<?php echo $book_id; ?>" placeholder="Book Id"/><br>
        <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
        <input type="hidden" name="book_name" value="<?php echo $book_name; ?>">
        <input type="hidden" name="author" value="<?php echo $author; ?>">
        <input type="hidden" name="status" value="<?php echo $status; ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="issuedate" value="<?php echo $issuedate; ?>">
        
        <input type="submit" name="Return" value="Return" class="submit_button submit_button1">
      </form>
       <?php
      if( isset($_POST['Return']))
      { 
        $user_name=$_POST['user_name'];
        $book_name=$_POST['book_name'];
        $user_id=$_POST['user_id'];
        $book_id=$_POST['book_id'];
        $author=$_POST['author'];
        $status=$_POST['status'];
        $issuedate=$_POST['issuedate'];
        if(is_numeric($book_id))
          $book_id=$book_id;
        else
          $book_id=0;
        $sql1=mysqli_query($conn,"SELECT books.Book,books.Status,books.Author,users.Name,issues.User_id,issues.Issue_date from books,users,issues WHERE issues.User_id=users.Enrol_id AND issues.Book_id=books.Book_id and issues.Book_id=".$book_id."");
        $row1=mysqli_num_rows($sql1);
        if($row1>0){
        while ($row1 = mysqli_fetch_array($sql1))
        {
          $book_name = $row1['Book'];
          $author = $row1['Author'];
          $status = $row1['Status'];
          $user_name = $row1['Name'];
          $user_id = $row1['User_id'];
          $issuedate = $row1['Issue_date'];
        }
        
        ?>
        <script>
        var r =confirm("Please check details once\n\nUser Name   : <?php echo $user_name; ?>\nBook name   : <?php echo $book_name; ?> \nAuthor Name: <?php echo $author; ?> \nAvailability    : <?php echo $status; ?>")
        if (r == true) 
        { <?php
          $sql=false;
          if($status == "Not Available")
          {
            require_once 'db_connect.php';
            $date = date('Y-m-d H:i:s');
            $sql=mysqli_query($conn,"UPDATE issues SET Return_date='".$date."' WHERE Book_id=".$book_id);


          }
          if($sql)
          {?>
            alert('Book has been Returned successfully');
            window.location = 'returns.php';<?php
            $status="Available";
            $sql1=mysqli_query($conn,"UPDATE books SET Status='".$status."' WHERE Book_id=".$book_id."");
            
          } 
          else
          {?>
            alert('The book status is available, please check it once');
             window.location = 'returns.php';<?php
          }?>
        }
        else 
        {
          <?php unset($_POST['Return']); ?>
        }
      </script><?php
      }
      

      }?>
    </div>
          
</div>
</center>
<html>
<?php
}
?>