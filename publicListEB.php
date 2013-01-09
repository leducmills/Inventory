<?php require_once('config.php');
include('includes/headingEB.html');
 
?>
<html>
<head>
<script src="sortTable.js"></script>
</head>
<body>
<div align="center">
Select the catagory of equipment you would like to see:
<br>
<form name="form" action="publicListEB.php" method="post">
<select name="catagories" >
<option value="1">Projectors</option>
<option value="2">Cameras</option>
<option value="3">Video Utilities & Accessories</option>
<option value="4">Media Storage & Players</option>
<option value="5">Computers</option>
<option value="6">Audio Gear</option>
<option value="7">Rapid Prototyping</option>
<option value="8">Wood Shop/Welding</option>
<option value="9">Electronics Dev</option>
<option value="10">Computer Peripherals & Accessories</option>
<option value="11">Cables & Adapters</option>
</select>
<input type="submit" name="submit" value="submit">
</form>

<table class="sortable" border="1">
<thead>
<tr><th>Name</th><th>Model Number</th><th>Image</th><th>Value</th><th>Notes</th><th>Checked Out</th><th>Due Back</th></tr>
</thead>
<tbody>
<?
$listval = $_POST['catagories'];

mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("SELECT * FROM cat_X_kit WHERE '$listval' = CATID");
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if ($row_Recordset1['ID']!=""){

	do {

	$kitID = $row_Recordset1['KITID'];
	
	mysql_select_db($database_equip, $equip);
	$query_Recordset2 = sprintf("SELECT * FROM kit WHERE '$kitID' = ID");
	$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
	$row_Recordset2 = mysql_fetch_assoc($Recordset2);
	$totalRows_Recordset2 = mysql_num_rows($Recordset2);
	
	if($row_Recordset2['ID']!=""){
	
?>	
	
  
<? do { ?>

<tr>
<td><? echo $row_Recordset2['Name']; ?></td> 
  	<td><? echo $row_Recordset2['ModelNumber']; ?></td>
    <td><? $Image = $row_Recordset2['ImageThumb'];
    	if($Image!=""){ 
    		echo("<IMG SRC=\"images/$Image\">");
   		 }?></th>
    <td><? echo $row_Recordset2['Value']; ?></td>
    <td><? echo $row_Recordset2['Notes']; ?></td>
    <td><?php echo $row_Recordset2['DateOut']; ?></td>
    <td><?php echo $row_Recordset2['DueBack']; ?></td>
</tr>
<? } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>

<?
}
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
?>
</tbody>
</table></div><?
}
?>
    
