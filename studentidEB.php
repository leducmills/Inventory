<?php 
if (strlen($_COOKIE["EquipmentCheckout"]) < 1) { 
header('location:indexEB.php');
}

require_once('config.php'); 

mysql_select_db($database_equip, $equip);
$query = sprintf("SELECT * FROM students");
$result = mysql_query($query, $equip) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$totalRows = mysql_num_rows($result);
//echo $result;
//echo $row;
//echo $totalRows;


/*if (empty($_REQUEST['Username']) || empty($_REQUEST['Password'])) {
?>

<html>
<head>
<meta http-equiv="refresh" content="0;URL=indexEB.php">
<link href="includes/equipEB.css" rel="stylesheet" type="text/css">
</head>
<body>
Incorrect Username/Password Combo.
</body>
</html>

<? } else { */
include('includes/headingEB.html'); ?>
<html>
<head>
<script src="sortTable.js"></script>
</head>
<body>
<div align="center">
<form name="form" action="studentinfoEB.php" method="post">
<strong>Enter the User's ID or click on a 'student info' link below: </strong> <br>
<input name="StudentID" type="password" id="StudentID">

<input type="submit" name="Submit" value="Submit">
<br>
</form>

<a href="newUserEB.php">Click here</a> to insert a new user into the database.
</div>

<P>
List of current users (click to sort):
<? if ($row['ID']>0) { ?>
<table class="sortable" border="1">
<thead>
  <tr><th><strong>ID</strong></th><th><strong>User Name</strong></th><th><strong>First Name</strong></th><th><strong>Last Name</strong></th></tr>
</thead> 
<tbody>
<? do { ?>
<tr>
	<td><? echo $row['ID']; ?></td>   
  	<td><? echo $row['StudentID']; ?></td> 
  	<td><? echo $row['FirstName']; ?></td>
    <td><? echo $row['LastName']; ?></td>
    <!-- NOTE:  Figure out check in url parameters to bring up the correct check in page -->
    <td><a href="studentinfoEB.php?StudentID=<? echo $row['StudentID']; ?>">Student Info Page</a></td>
</tr>

<? } while ($row = mysql_fetch_assoc($result)); ?>
</tbody>
</table>  
<P>
<P>

<? include('includes/footerEB.html'); ?>

<? } ?>