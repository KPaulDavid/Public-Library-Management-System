<?php
ViewCourses();

function ViewCourses()
{?>
<html>
<head>
<style>
.error {color: #FFF000;}
</style>
<title>View Courses</title>
<link rel="stylesheet" href="css/all.css">
</head>
<?php require_once 'main.php'; 
require_once 'db_connect.php';?>
<body style="background-color:#FFFAF0;">
  <center>
      <h3>VIEW COURSES</h3>
       <?php 
       $sql=mysqli_query($conn,"SELECT * FROM courses WHERE Start_date>=DATE_SUB(now(), INTERVAL 0 MONTH)");
       $row1=mysqli_num_rows($sql);
       $i=0;
       while($row1=mysqli_fetch_array($sql))
       {?> 
        <table border=1 align="center" style="table-layout: fixed; width: 90%;">
          <?php if($i == 0) 
          {?>
          <tr>
            <th>Course Name</th>
            <th>Duration</th>
            <th>Start Date</th>
            <th>Department</th>
            <th>Timings</th>
            <th>Fee</th>
            <th>Further Details</th>
          <tr><?php 
          }?>
          <tr>
            <td><center><?php echo $row1['Course_title']; ?></center></td>
            <td><center><?php echo $row1['Duration']; ?></center></td>
            <td><center><?php echo $row1['Start_date']; ?></center></td>
            <td><center><?php echo $row1['Department']; ?></center></td>
            <td><center><?php echo $row1['Timings']; ?></center></td>
            <td><center></center><?php echo $row1['Fee']; ?></center></td>
            <td><center><?php echo $row1['Further_details']; ?></center></td>
          </tr>
          <?php
          $i++;
       }?>
     </table>
</center>
</body>
</html><?php
}
?>