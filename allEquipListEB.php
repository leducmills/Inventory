<?php 
if (strlen($_COOKIE["EquipmentCheckout"]) < 1) { 
header('location:indexEB.php');
}

require_once('config.php');
include('includes/headingEB.html'); 

mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("SELECT * FROM kit ORDER BY ID ASC");
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
<div align="center"><strong>LIST OF EQUIPMENT</strong><br>
  <br>
 <a href="/Checkout/addEquipEB.php">Click Here</a> to add new equipment to the database.
 <br> 
</div>
<?

if($row_Recordset1['ID']!=""){

?>


<table width="50%" border="1">
  <tr align="center">
    <td><strong>ID</strong></td>
    <td><strong>Name</strong></td>
    <td><strong>Model Number</strong></td>
    <td><strong>Serial Number</strong></td>
    <td><strong>Image</strong></td>
    <td><strong>Value</strong></td>
    <td><strong>Notes</strong></td>
  </tr>
<? do { ?>
<tr align="center">
	<td><? echo $row_Recordset1['ID']; ?></td>   
  	<td><? echo $row_Recordset1['Name']; ?></td> 
  	<td><? echo $row_Recordset1['ModelNumber']; ?></td>
    <td><? echo $row_Recordset1['SerialNumber']; ?></td>
    <td><? $Image = $row_Recordset1['ImageThumb'];
    	if($Image!=""){ 
    		echo("<IMG SRC=\"images/$Image\">");
   		 }?></td>
    <td><? echo $row_Recordset1['Value']; ?></td>
    <td><? echo $row_Recordset1['Notes']; ?></td>
</tr>
<? } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
</table>
<? 
}
 ?>
    