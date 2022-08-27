<?php
$choose = $book_name = $author = $from_date = $to_date = $holder = $book_id = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $choose=$_POST['choose'];
  $book_name=$_POST['book_name'];
  $author=$_POST['author'];
  $holder=$_POST['holder'];
  $book_id=$_POST['book_id'];
  $from_date=$_POST['from_date'];
  $to_date=$_POST['to_date'];
}
Bookhistory($choose,$book_name,$author,$from_date,$to_date,$holder,$book_id);

function Bookhistory($choose,$book_name,$author,$from_date,$to_date,$holder,$book_id)
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<script type="text/javascript">
function choose() 
{
    if (document.getElementById('book').checked) 
    {
      document.getElementById('bookyes').style.display = 'block';
      document.getElementById('numyes').style.display = 'none';
    }
    else if (document.getElementById('num').checked) 
    {
      document.getElementById('bookyes').style.display = 'none';
      document.getElementById('numyes').style.display = 'block';
    }  
}
</script>
<title>Book History</title>
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
    <div class="column6">
      <h3>BOOK HISTORY</h3>
      <p style="color:red;"> *Please choose one option to view book history*</p>

      View by Book<input type="radio" onclick="choose();" name="choose" id="book" value="Book" required>&nbsp;&nbsp;
      View by Number<input type="radio" onclick="choose();" name="choose" id="num" value="Num" required>&nbsp;&nbsp;
      
    <br><br>
<!-- -------------------------------------------Book Section------------------------------------------------ -->
<form name="book" action="" method="POST">
<div id="bookyes" style="display: none;" ><br>
  <label for="book_name">Please enter Book name here</label><br>
  <input type="text" required  name="book_name" value="<?php echo $book_name; ?>"placeholder="Book Name"/><br>
  <input type="hidden" name="choose" value="<?php echo $choose; ?>">
  <input type="hidden" name="author" value="<?php echo $author; ?>">
  <input type="hidden" name="to_date" value="<?php echo $to_date; ?>">
  <input type="hidden" name="from_date" value="<?php echo $from_date; ?>">
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
  <input type="hidden" name="to_date" value="<?php echo $to_date; ?>">
  <input type="hidden" name="from_date" value="<?php echo $from_date; ?>">
  <input type="hidden" name="holder" value="<?php echo $holder; ?>">
  <input type="hidden" name="author" value="<?php echo $author; ?>">
  <input type="submit" name="num_view" value="View" class="submit_button submit_button1">
</div>
</form>

<?php
if(isset($_POST['book_view']))
{
  $choose=$_POST['choose'];
  $book_name=$_POST['book_name'];
  $author=$_POST['author'];
  $holder=$_POST['holder'];
  $book_id=$_POST['book_id'];
  $from_date=$_POST['from_date'];
  $to_date=$_POST['to_date'];
  //echo $book_name;

  require_once 'db_connect.php';
  $sql = mysqli_query($conn,"SELECT Book,Author,User_id,Name,Issue_date,Return_date FROM books,issues,users WHERE Book like '%".$book_name."%' AND books.Book_id=issues.Book_id AND users.Enrol_id=issues.User_id ORDER By Return_date DESC");
  //echo "SELECT * FROM books WHERE Book='%".$book_name."%'";
  $row = mysqli_num_rows($sql);
  if($row>0)
  {
  ?>
    <table border=1 align="center" style="table-layout: fixed; width: 90%;">
      <?php
      $i=0;
      while ($row = mysqli_fetch_array($sql)) 
      {
        if($i==0)
        {?>
          <tr>
            <th colspan=3>Book Name</th>
            <th colspan=3>Author</th>
          </tr>
          <tr>
            <td colspan=3 align=center><?php echo $row['Book']; ?> </td>
            <td colspan=3 align=center><?php echo $row['Author']; ?> </td>
          </tr>
          <tr>
            <th colspan=2>Issue Date</th>           
            <th colspan=2>Return Date</th>
            <th colspan=2>Holder Name</th>
          </tr>
          <?php
        }?>
        <tr>
          <td colspan=2 align= center><?php echo $row['Issue_date']; ?> </td>
          <td colspan=2 align= center><?php echo $row['Return_date']; ?> </td>
          <td colspan=2 align= center><?php echo $row['Name']; ?> </td>
        </tr>
        <?php 
        $i++;
      }?>
    </table><?php
  }
  else
  {
    echo "<script>alert('No Book History found')</script>";
    echo "<script>window.location = 'Bookhistory.php'</script>";
  }
}
elseif(isset($_POST['num_view']))
{
  $choose=$_POST['choose'];
  $book_name=$_POST['book_name'];
  $author=$_POST['author'];
  $holder=$_POST['holder'];
  $book_id=$_POST['book_id'];
  $from_date=$_POST['from_date'];
  $to_date=$_POST['to_date'];
  //echo $book_name;

  require_once 'db_connect.php';
  if(is_numeric($book_id))
    $book_id=$book_id;
  else
    $book_id=0;
  $sql = mysqli_query($conn,"SELECT Book,Author,User_id,Name,Issue_date,Return_date FROM books,issues,users WHERE books.Book_id =".$book_id." AND books.Book_id=issues.Book_id AND users.Enrol_id=issues.User_id ORDER By Return_date DESC");
  //echo "SELECT * FROM books WHERE Book='%".$book_name."%'";
  $row = mysqli_num_rows($sql);
  if($row>0)
  {
  ?>
    <table border=1 align="center" style="table-layout: fixed; width: 90%;">
      <?php
      $i=0;
      while ($row = mysqli_fetch_array($sql)) 
      {
        if($i==0)
        {?>
          <tr>
            <th colspan=3>Book Name</th>
            <th colspan=3>Author</th>
          </tr>
          <tr>
            <td colspan=3 align=center><?php echo $row['Book']; ?> </td>
            <td colspan=3 align=center><?php echo $row['Author']; ?> </td>
          </tr>
          <tr>
            <th colspan=2>Issue Date</th>           
            <th colspan=2>Return Date</th>
            <th colspan=2>Holder Name</th>
          </tr>
          <?php
        }?>
        <tr>
          <td colspan=2 align= center><?php echo $row['Issue_date']; ?> </td>
          <td colspan=2 align= center><?php echo $row['Return_date']; ?> </td>
          <td colspan=2 align= center><?php echo $row['Name']; ?> </td>
        </tr>
        <?php 
        $i++;
      }?>
    </table><?php
  }
  else
  {
    echo "<script>alert('No Book History found')</script>";
    echo "<script>window.location = 'Bookhistory.php'</script>";
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