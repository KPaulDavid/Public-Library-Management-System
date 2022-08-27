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
.butn
 { 
     background-color: #1CB6ED;
  color: white;
  
  font-size: 16px;
  border: none;
display:flex;
justify-content:center;
align-items:center;
flex-align:center;
width: 90px;
height: 30px;
}
div{
display:flex;
justify-content:center;
align-items:center;
}
label{
padding: 20px;
}
.bclass
{
   border-radius:4px;
   background-color:ghostwhite;
}
.txtbx
{
  height:35px;
  width:200px;
  }
</style>
</head>
<?php  
require_once 'db_connect.php';?>
<body bgcolor="linen">
<center>

    <div class="">
      <form action="" method="POST">
<font color="brown"><h3>DONATE BOOK</h3>
	<table width="470" height="200" cellpadding="2" cellspacing="4">

         <tr> <td><font size="4" color="blue"> BOOK NAME <b>:-</font> <td><input type="text" required class="bclass txtbx" name="book_name" value="<?php echo $book_name; ?>"placeholder=" &nbsp &nbsp &nbsp &nbsp &nbsp Book Name" maximumsize="20"></td></tr>
        <tr><td><br/>
         <tr> <td><font size="4" color="blue"> AUTHOR <b>:-</font><td><input type="text" height="12px" class="bclass txtbx" required  name="author" value="<?php echo $author; ?>"placeholder=" &nbsp &nbsp &nbsp &nbsp &nbsp Author name"/ maxlength="40"></td></tr><br>
        <tr><td><br/><label for="cost"> <font color="blue"><b>Book Cost</label></td><br>
        <td><input type="text" required  class="bclass txtbx" name="cost" value="<?php echo $cost; ?>"placeholder=" &nbsp &nbsp &nbsp &nbsp &nbsp Book Cost"/></td></tr><br>
        <tr><td><br/><label for="company"> <font color="blue"><b>Publisher</label><br></td>
        <td><input type="text" required class="bclass txtbx" name="company" value="<?php echo $company; ?>"placeholder=" &nbsp &nbsp &nbsp &nbsp &nbsp Book Company"/><br></td></tr>
        <tr><td><br/><label for="company"><font color="blue"><b>Total Copies</label><br></td><td>
        <input type="text" required class="bclass txtbx"  name="copies" value="<?php echo $copies; ?>"placeholder=" &nbsp &nbsp &nbsp Number of copies Issuing"/><br></td></tr>
       <br><td><br/><th><br/>
      <tr> <td><input type="submit" name="add" value="Add" class="butn"> <td><td> <input type="Reset" name="clear" value="CLEAR" class="butn"><center> 
       <tr> <td> <td><a href="index.php"><input type="button" class="butn" Value="BACK"></a>    
<table>
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
      echo "<script>window.location = 'index.php'</script>";
    }
    else
    {
      echo "<script>alert('There is a problem in adding book, try later')</script>";
      unset($_POST['add']);
    }
      
    }
  }
?>