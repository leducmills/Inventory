<?php 
require_once('config.php');
include('includes/headingEB.html'); 

mysql_select_db($database_equip, $equip);
//$query_Recordset1 = "SELECT * FROM checkedout  LEFT JOIN students ON students.StudentID = checkedout.StudentID LEFT JOIN kit ON kit.ID = checkedout.KitID WHERE DateIn = '' ORDER BY kit.ID";
$query_Recordset1 = "SELECT * FROM kit WHERE CheckedOut = '1'";
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_equip, $equip);
$sql2 = "SELECT FirstName, LastName FROM students WHERE StudentID = '$StudentID'";
$result2 = mysql_query($sql2, $equip) or die(mysql_error());
$row2 = mysql_fetch_assoc($result2);
?>



  <?
if($row_Recordset1['ID']>0) {  

echo "<center><strong>KITS CURRENTLY CHECKED OUT</strong></center><p>"; ?>

<html>
<head>
<script src="sortTable.js"></script>
</head>
<body>
<table class="sortable" width="100%" border="1">
<thead>
<tr align="center">
<th><strong>Equipment Checked Out:</strong></th>
<th><strong>User: </strong></th>
<th> <strong>Model Number: </strong></th>
<th><strong>Serial Number: </strong></th>
<th><strong>Image: </strong></th>
<th><strong>Date Out: </strong></th>
<th><strong>Expected Return: </strong></th>
</tr>
</thead>
<tbody>
<? do { ?>
<tr align="center">
    <td><?php echo $row_Recordset1['Name']; ?></td>
    <td><?php echo $row2['FirstName']; ?> <? echo $row2['LastName']; ?></td>
    <td><?php echo $row_Recordset1['ModelNumber']; ?></td>
    <td><?php echo $row_Recordset1['SerialNumber']; ?></td>
    <td><img src="images/<? echo $row_Recordset1['ImageThumb']; ?>"/></td>
    <td><?php echo $row_Recordset1['DateOut']; ?></td>
    <td><?php echo $row_Recordset1['DueBack']; ?></td>

 <?


if (intval(strtotime($row_Recordset1['DueBack'])) < intval(strtotime("now"))) {
echo "<td><strong><font color=\"#FF0000\"> -- THIS ITEM IS LATE</font></strong></td>";
}
echo '<P>';
?></tr><?
 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

</tbody>
</table>
 
 <? 
 } else {
 
echo "<center><strong>ALL KITS CURRENTLY CHECKED IN</strong></center><p>";
 }

mysql_free_result($Recordset1);
include('includes/footerEB.html'); 
?>

