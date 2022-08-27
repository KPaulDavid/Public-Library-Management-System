<html>
<body bgcolor="lightyellow">
<?php 
$username = "root"; 
$password = ""; 
$database = "library"; 
$mysqli = new mysqli("localhost", $username, $password, $database); 
$query = "SELECT Book_id,User_id,Issue_date,Return_date FROM issues";


echo '<table border="2" cellspacing="2" cellpadding="2" width="800" height="300" bgcolor="lightblue" align="center"> 
      <tr><center> <font face="TimesNewRoman" size="18" color="blue"><b><u> REPORTS </b></u></font></center>       
<tr> 
          <th> <font face="Arial" color="red"><b> Book-id </b></font> </td> 
          <th> <font face="Arial" color="red"><b> User-id</b> </font> </td> 
          <th> <font face="Arial" color="red">Issue-Date</font></b> </td> 
          <th> <font face="Arial" color="red"> <b> Return-Date </b></font> </td> 
          
      </tr>';

if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        $field1name = $row["Book_id"];
        $field2name = $row["User_id"];
        $field3name = $row["Issue_date"];
        $field4name = $row["Return_date"];
       

        echo '<tr> 
                  <td>'.$field1name.'</td> 
                  <td>'.$field2name.'</td> 
                  <td>'.$field3name.'</td> 
                  <td>'.$field4name.'</td> 
                  
              </tr>';
    }
    $result->free();
} 
?>
</body>
</html>