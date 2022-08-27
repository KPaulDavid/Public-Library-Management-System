<?php
    session_start();
    if (!isset($_SESSION['access_type'])){    
        header('location:http://localhost:800/Library/index.php');
        // redirect the page to another location (a page saying no session found)
      }
    if ($_SESSION['access_type']!="Admin"){      
        header('location:http://localhost:800/Library/logout.php');
        // redirect the page to another location (a page saying no session found)
      }
require_once 'db_connect.php';
?>
<html>
<head>
	<title>Admin Page</title>
	<link rel="stylesheet" href="css/all.css">
</head>
<!-- <script type="text/javascript">
   setTimeout(function() 
    { 
      alert('Timed Out! Please Login again to Continue.');
      window.location.href = "logout.php";
      
    }, 5*60*1000);

</script>-->

<meta name="viewport" content="width=device-width, initial-scale=1">
<ul >
  <li><a>Books ▼</a>
    <ul>
      <li><a href="issues.php">Book Issuing</a></li>
      <li><a href="returns.php">Book Return</a></li>
      <li><a href="addbook.php">Add Book</a></li>
      <li><a href="viewbooks.php">View Books</a></li>
      <li><a href="bookhistory.php">Book History</a>
      </li>
    </ul>
  </li>

  <li><a>Users ▼</a>
    <ul>
      <li><a href="adduser.php">Add User</a></li>
      <li><a href="userbooks.php">Books Usage</a></li>
      <li><a href="viewuser.php">View Users</a></li>
      <li><a href="editusers.php">Edit Users</a></li>
    </ul>
  </li>
  <li><a>Courses ▼</a>
    <ul>
      <li><a href="addcourse.php">Add Course</a></li>
      <li><a href="editcourse.php">Edit Course</a></li>
      <li><a href="viewcourses.php">View Courses</a></li>
    </ul>
  </li>
  <li><a>Complaints ▼</a>
    <ul>
      
      <li><a href="viewcomplaints.php">View Complaints</a></li>
    </ul>
  </li>
  <li><a>Suggestions ▼</a>
    <ul>
      
      <li><a href="viewsuggestions.php">View Suggestions</a></li>
    </ul>
  </li>
  <li><a>Programmes ▼</a>
    <ul>
      <li><a href="addprogram.php">Add Program</a></li>
      <li><a href="editprogram.php">Edit Program</a></li>
    </ul>
  </li>
  <li><a href="aboutus.php">About Library</a></li>
<li><a href="report.php">Reports</a></li>  
<li><a href="logout.php">Logout</a></li>
</ul> 


<body>
</body>
 
</div>
</html>