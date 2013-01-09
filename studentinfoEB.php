<?php 
if (strlen($_COOKIE["EquipmentCheckout"]) < 1) { 
header('location:indexEB.php');
}

require_once('config.php'); 


$StudentID = $_REQUEST['StudentID'];


mysql_select_db($database_equip, $equip);
$query_Recordset1 = "SELECT * FROM students WHERE StudentID = \"$StudentID\"";
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


mysql_select_db($database_equip, $equip);
$query_Fines = "SELECT * FROM checkedout WHERE (unix_timestamp(DateIn) - $fineFreq) > unix_timestamp(ExpectedDateIn) AND FinePaid IS NULL AND StudentID =  \"$StudentID\"";
$Fines = mysql_query($query_Fines, $equip) or die(mysql_error());
$row_Fines = mysql_fetch_assoc($Fines);
$totalRows_Fines = mysql_num_rows($Fines);

include('includes/headingEB.html');  
if($fines!=0){
if(isset($row_Fines['ID'])) {

echo "<h1><strong><font color='#FF0000'>STUDENT OWES FINES!!!</font></strong></h1>";
}
}
?>
<html>
<head>
<script src="sortTable.js"></script>
</head>
<body>
<p><u><strong>USER INFORMATION</strong></u><br> 

<?
if($row_Recordset1['FirstName']!=""){
?>
  Name: <?php echo $row_Recordset1['FirstName']; ?>
  <?php echo $row_Recordset1['LastName']; ?>
  <br>
E-mail: <?php echo $row_Recordset1['Email']; ?>
<br>
Phone: <?php echo $row_Recordset1['Phone']; ?>




<?php 

} else {
echo "<FONT COLOR='red'>There is no user with ID: $StudentID in the system.</FONT><br>";
}



mysql_select_db($database_equip, $equip);

$sqlStatement = "SELECT ID, Name, ModelNumber, SerialNumber, CheckedOut FROM kit WHERE CheckedOut = '1' AND Student_ID = '$StudentID'";

$result = mysql_query($sqlStatement,$equip);
        if (!$result)
            die("Error " . mysql_errno() . " : " . mysql_error());
			
$row = mysql_fetch_assoc($result);
$totalRows = mysql_num_rows($result);
	




?>

<p>
<HR>
<u><strong>Equipment checked out by this user:</strong></u> (To check in equipment, click the link below)
<p>
<p>
<? if ($row['ID']>1) { ?>
<table class="sortable" border="1">
<thead>
  <tr align="center">
    <th><strong>ID</strong></th>
    <th><strong>Name</strong></th>
    <th><strong>Model Number</strong></th>
    <th><strong>Serial Number</strong></th>
  </tr>
</thead>
<tbody>
<? do { ?>
<tr align="center">
	<td><? echo $row['ID']; ?></td>   
  	<td><? echo $row['Name']; ?></td> 
  	<td><? echo $row['ModelNumber']; ?></td>
    <td><? echo $row['SerialNumber']; ?></td>
    <!-- NOTE:  Figure out check in url parameters to bring up the correct check in page -->
    <td><a href="checkinEB.php?KitID=<? echo $row['ID'] ?>&StudentID=<? echo $StudentID ?>">Check Back In</a></td>
</tr>
<? } while ($row = mysql_fetch_assoc($result)); ?>
</tbody>
</table>  
  


<?php
}
?> 

<HR>
<p>
<strong><u>Kits available for checkout:</u></strong>
 (To check out equipment, check the boxes below and hit submit.)<br>
 <p>
 <p>
<?




mysql_select_db($database_equip, $equip);

$sqlStatement = "SELECT ID, Name, ModelNumber, SerialNumber, Notes FROM kit WHERE CheckedOut = '0' ORDER BY ID asc";

$result = mysql_query($sqlStatement,$equip);
        if (!$result)
            die("Error " . mysql_errno() . " : " . mysql_error());
			
$row = mysql_fetch_assoc($result);
$totalRows = mysql_num_rows($result);



?>

<? if ($row['ID']>1) { ?>
<!--<form action="checkoutEB.php" name="Check[]" method="post">-->
<form action="test.php" name="Check[]" method="post">
<input type="hidden" name="StudentID" value="<? echo $StudentID ?>">

<table class="sortable" width="100%" border="1">
<thead>
  <tr align="center">
    <th><strong>ID</strong></th>
    <th><strong>Name</strong></th>
    <th><strong>Model Number</strong></th>
    <th><strong>Serial Number</strong></th>
    <th><strong>Notes</strong></th>
    <th><strong>Check Out</strong></th>
  </tr>
  </thead>
  <tbody>
<? do { ?>
<tr align="center">
	<td><? echo $row['ID']; ?></td>   
  	<td><? echo $row['Name']; ?></td> 
  	<td><? echo $row['ModelNumber']; ?></td>
    <td><? echo $row['SerialNumber']; ?></td>
    <td><? echo $row['Notes']; ?></td>
    <!-- NOTE:  Figure out check in url parameters to bring up the correct check in page -->
    <!--<td><a href="checkoutEB.php?KitID=<? //echo $row['ID'] ?>&ContractRequired=0&StudentID=<? //echo $StudentID ?>">Check Out</a></td>-->
    <td><input type="checkbox" 	name="Check[]" value="<? echo $row['ID'] ?>"><? echo $row['ID'] ?></td>
</tr>
<? } while ($row = mysql_fetch_assoc($result)); ?>
</tbody>
<tfoot>
<tr><td><input type="submit" name="Submit" value="Proceed to Checkout"></td></tr>
</tfoot>
</table>  
  
<?php
}




include('includes/footerEB.html'); ?>