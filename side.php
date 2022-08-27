<?php
    session_start();
    if (!isset($_SESSION['access_type'])){    
        header('location:http://localhost:800/Library/index.php');
        // redirect the page to another location (a page saying no session found)
      }
    if ($_SESSION['access_type']!="User"){      
        header('location:http://localhost:800/Library/logout.php');
        // redirect the page to another location (a page saying no session found)
      }
require_once 'db_connect.php';
?>
<html>
<head>
	<title>User Page</title>
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
      <li><a href="viewbooks1.php">View Books</a></li>
      </li>
    </ul>
  </li>
<li><a href="request.php">Request</a></li>
  <li><a>Users ▼</a>
    <ul>
      <li><a href="userbooks1.php?myid=<?php echo $_SESSION['username']; ?>">Books Usage</a></li>
    </ul>
  </li>
  <li><a>Courses ▼</a>
    <ul>
      <li><a href="viewcourses1.php">View Courses</a></li>
    </ul>
  </li>
  <li><a>Complaints ▼</a>
    <ul>
      <li><a href="complaints1.php">Write Complaint</a></li>
    </ul>
  </li>
  <li><a>Suggestions ▼</a>
    <ul>
      <li><a href="suggestions1.php">Write Suggestion</a></li>
    </ul>
  </li>

  <li><a href="aboutus1.php">About Library</a></li>
  <li><a href="logout.php">Logout</a></li>

</ul>


<body>
</body>

</html>