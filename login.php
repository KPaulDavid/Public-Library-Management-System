<?php
require_once 'db_connect.php';
?>
<html>
<head>
	<title>LOGIN PAGE</title>
	<link rel="stylesheet" href="css/all.css">
</head>
<script type="text/javascript">
   function checkForm(form)
  {
  	if(form.username.value == "" && form.password.value == "") 
  	{
      alert("Error: Plese Fill All Fields....");
      form.username.focus();
      return false;
    }


    if(form.username.value == "" ) 
    {
      alert("Error: Username cannot be blank!");
      form.username.focus();
      return false;
    }

    if(form.password.value == "" )
    {
      alert("Error: Password cannot be blank!");
      form.password.focus();
      return false;
    }
  }
  setTimeout(function() { window.location.href = "logout.php"; }, 5 * 60 * 1000);
</script>
<style>
	body
	{
		background-image: url(Images/loginimg.jpg);
		 background-repeat: no-repeat;
		  background-size: 100% 100%;	  
	}
	.form-area{
	position: absolute;
	top:10%;
	left: 75%;
	right: 20%
	transform: translate(-50%,-50%);
	width: 250px;
	height: 320px;
	box-sizing: border-box;
	background:rgba(0,0,0,0.5);
	padding: 20px;
	}
.error {color: #FF1494;}

</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/all.css">
<center>
<body>
              
		<div class="form-area">
              			<span class="error"><h2><font color="cyan">USER LOGIN</font> </h2></span>
			<form onsubmit="return checkForm(this);" action="" method="POST">
			<label for="username"><span class="error">User Name:</span></label></br>
			<input type="text" style="width:100%"required name="username" placeholder="User Name"/></br>
			<label for="password"><span class="error">Password:</span></label></br>
			<input type="password" required name="password" placeholder="Password"/></br>
			<input type="submit" name="login" value="LOGIN" class="submit_button submit_button1"><br/>
	
		</form>
		</div>
		
</body>
</html>
<?php

if (isset($_POST['login'])) 
{	
	if($_POST['username']!="" && $_POST['password']!="" && $_POST['password']!="")
	{	
		$access_type="";
		$enrol_id=0;
		require_once 'db_connect.php';
		$result = mysqli_query($conn,"SELECT Access_type,Enrol_id FROM Users WHERE Email='".$_POST['username']."' AND Password ='".$_POST['password']."' ");
		//echo "SELECT Access_type,Enrol_id FROM Users WHERE Email='".$_POST['username']."' AND Password ='".$_POST['password']."' ";
		//echo $_POST['username'];
		//echo $_POST['password'];
		$row1 = mysqli_num_rows($result);
 			while ($row1 = mysqli_fetch_array($result))
    		{
        		$access_type=$row1['Access_type'];
        		$emp_id=$row1['Enrol_Id'];
        		//echo $access_type;
   			} 
		if($access_type=="")
		{
			echo "<script>alert('Invalid login details')</script>";
			echo "<script>window.location = 'login.php'</script>"; 
		}
		else
		{
			if($access_type =="Admin")
			{	
              	session_start();
				$_SESSION['username'] = $_POST["username"];
                $_SESSION['password'] = $_POST["password"];
				$_SESSION['access_type'] = "Admin";
				
				header('location:http://localhost/library2/admin.php');
				exit;
			}
			else if($access_type =="User")
			{	
				session_start();        
				$_SESSION['username'] = $_POST["username"];
                $_SESSION['password'] = $_POST["password"];
                $_SESSION['empid']= $emp_id;
				$_SESSION['access_type'] = "User";

				header('location:http://localhost/library2/user.php');
				exit;
			}
		}
	}
}

?>