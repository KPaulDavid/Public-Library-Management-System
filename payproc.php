<?php
$fulname = $email_id = $dopay = $pgender = $carddet = $cardcv = $expdt = $pamt = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $fulname=$_POST['fullname'];
  $email_id=$_POST['uemail'];
  $dopay=$_POST['dofb'];
  $pgender=$_POST['pgender'];
  $carddet=$_POST['cdetails'];
  $cardcv=$_POST['cdcv'];
  $expdt=$_POST['cdexp'];
  $pamt=$_POST['amount'];
}
Adduser($fulname,$email_id,$dopay,$pgender,$carddet,$cardcv,$expdt,$pamt);

function Adduser($fulname,$email_id,$dopay,$pgender,$carddet,$cardcv,$expdt,$pamt)
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
</style>
</head>
<?php  
require_once 'db_connect.php';?>
<body bgcolor="lightblue">
<center>
<h3> PAYMENT MODE</h3>
    <div class="">
      <form action="" method="POST">
	<table>
	<tr ><td>
        <label for="fullname"> Full Name </label></td>
        <td><input type="text" required  name="fullname" value="<?php echo $fulname; ?>"placeholder="Enter Full Name" maximumsize="20"></td></tr>
        <tr><td><br/>
	
	<label for="email">Email-Id</label></td><br>
        <td><input type="text" required  name="uemail" value="<?php echo $email_id; ?>"placeholder="Enter your mail-id"/></td></tr><br>
        
	<tr><td><br/><label for="Date of Payment">Date of Payment</label></td><br>
        <td><input type="date" required  name="dofb" value="<?php echo $dopay; ?>"placeholder=""/></td></tr><br>
        
	<tr><td><br/><label for="Gender">Gender</label><br></td>
        <td><select  required  name="pgender" value="<?php echo $pgender; ?>"placeholder="Enter your Gender"/>
        <option name="pgender" value="Male"> Male </option>
         <option name="pgender" value="Female"> Female</option>
         </select>
        <br></td></tr>
        
	<tr><td><br/><label for="cardedetails">Card-Details</label><br></td><td>
        <input type="text" required  name="cdetails" value="<?php echo $carddet; ?>"placeholder="Enter your Card Number"/><br></td></tr>
       
	<tr><td><br/><label for="cardecvc">Card-CV</label><br></td><td>
        <input type="text" required  name="cdcv" value="<?php echo $cardcv; ?>"placeholder="CV"/><br></td></tr>
      
	<tr><td><br/><label for="Expire Date">Expire Details</label><br></td><td>
        <input type="date" required  name="cdexp" value="<?php echo $expdt; ?>"placeholder=""/><br></td></tr>
      

	<tr><td><br/><label for="Payment">Amount</label><br></td><td>
        <input type="text" required  name="amount" value="<?php echo $pamt; ?>"placeholder=" &#8377 "/><br></td></tr>
      
	<br><td><br/><th><br/>
	 <input type="submit" name="add" value="Add" class="butn"> </th></td>
       </table>
      </div>
        </form>
    
</div>
</center>
<html>
<?php
  if( isset($_POST['add']))
  { 
    $fulname=$_POST['fullname'];
  $email_id=$_POST['uemail'];
  $dopay=$_POST['dofb'];
  $gender=$_POST['pgender'];
  $carddet=$_POST['cdetails'];
  $cardcv=$_POST['cdcv'];
  $expdt=$_POST['cdexp'];
  $pamt=$_POST['amount'];

    require_once 'db_connect.php';
    $sql = mysqli_query($conn,"INSERT into payment(FullName,Email,Dateofpay,Gender,Carddetails,Cardcvc,ExpDate,Amount) VALUES ('".$fulname."','".$email_id."','".$dopay."','".$pgender."',".$carddet.",".$cardcv.",'".$expdt."',".$pamt.")");
    if($sql)
    {
      echo "<script>alert('Payment Successfull - Thanks For your Contribution')</script>";
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