<style>
ul{
  margin:0px;
  padding:0px;
  list-style:none;
  width:800px;
  height:40px;
}
ul li{
  width:100px;
  height:40px;
  line-height:30px;
  float:left;
  padding-left: 10px;
}
ul li a{
  text-decoration:none;
  color:WHITE;
}
ul li a:hover{
	color:RED; 
}
</style>

<html>
<body>
<div style="width:1250px;background-color:#000000;height:30px;color:#ffffff;"> 
<ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="?op=list">Employeelist</a></li>
  <li><a href="?op=dep">Department</a></li>
  <li><a href="?op=sal">Salary</a></li>
</ul>
</div>
<?php
  echo "Welcome to the MVC ARCHITECTURE..!!";
?>
<br/>
<br/>
</body>
</html>

<?php

//echo '1';
include_once 'controller/employeeController.php';

//echo '2';
$controller = new employeeController();

//echo '3';
$controller->handleRequest();

?>




