<?php require_once('config.php'); ?>
<html>
<body>
<?php
$colname_Recordset1 = "1";
if (isset($HTTP_GET_VARS['EquipID'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $HTTP_GET_VARS['EquipID'] : addslashes($HTTP_GET_VARS['EquipID']);
}
mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("SELECT * FROM equip WHERE ID = %s", $colname_Recordset1);
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$ServerEquipID = $HTTP_GET_VARS['EquipID'];
$colname_Recordset2 = "1";
if (isset($HTTP_GET_VARS['EquipID'])) {
  $colname_Recordset2 = (get_magic_quotes_gpc()) ? $HTTP_GET_VARS['EquipID'] : addslashes($HTTP_GET_VARS['EquipID']);
}
mysql_select_db($database_equip, $equip);
$query_Recordset2 = sprintf("SELECT * FROM equipment_accessory INNER JOIN accessory_type ON accessory_type.ID = equipment_accessory.Accessory_TypeID WHERE EquipmentID = $ServerEquipID;");
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$colname_Recordset3 = "1";
if (isset($HTTP_GET_VARS['StudentID'])) {
  $colname_Recordset3 = (get_magic_quotes_gpc()) ? $HTTP_GET_VARS['StudentID'] : addslashes($HTTP_GET_VARS['StudentID']);
}
mysql_select_db($database_equip, $equip);
$query_Recordset3 = sprintf("SELECT * FROM students WHERE ID = %s", $colname_Recordset3);
$Recordset3 = mysql_query($query_Recordset3, $equip) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);


?>
<strong><?php echo $row_Recordset3['FirstName']; ?> <?php echo $row_Recordset3['LastName']; ?> (Code # <?php echo $row_Recordset3['ID']; ?></strong>) is
 checking out a <strong><?php echo $row_Recordset1['Name']; ?></strong><br>
 Checked Out:<strong> <?php $ServerCheckHours = $row_Recordset1['CheckHours']; ?>
 <? 
// NEED TO ADD MORE DATE LOGIC TO SKIP WEEKENDS
echo date("D, F j, g:i a") 
?>
 </strong><br>
Due Back:
<strong>
<?php 
if (($ServerCheckHours+date('g'))<24) {
$returndate = mktime(date('g')+$ServerCheckHours,date('i'),0,date('n'),date('j'),date('Y'));
} else {
if ( date("D", mktime(date('g'),date('i'),0,date('n'),date('j')+1,date('Y'))) == "Sat") {
$returndate = mktime(date('g'),date('i'),0,date('n'),date('j')+3,date('Y'));
} else {
$returndate = mktime(date('g'),date('i'),0,date('n'),date('j')+1,date('Y'));
}

$Year = date('Y');
$Day = (date('j')+1);
if ( date("D", mktime(date('g'),date('i'),0,date('n'),date('j')+1,date('Y'))) == "Sat") {
$Day = (date('j')+3);
}
$Month = date('n');
$Hours = date('g');
if ($Hours< 10) {
$Hours = "0".$Hours;
}
$Minutes = date('i');
if ($Month<10) {
$Month = "0".$Month;
}

$returndateSQL = "$Year-$Month-$Day $Hours:$Minutes:00";

}
//echo "<P>";
//echo "SQL Formatted Date = $returndateSQL";
//echo "<P>";


echo date("D, F j, g:i", $returndate); ?>


</strong><br>
Fine Per Day: $1.00<br>
 <?php //echo $row_Recordset1['ID']; ?>
 <br>
 <table width="40%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> Item: <?php echo $row_Recordset1['ID']; ?>- <?php echo $row_Recordset1['Name']; ?></td>
  </tr>
  <tr>
    <td><div align="center"><IMG SRC="<?php echo $row_Recordset1['Image']; ?>"><br>
    </div></td>
  </tr>
  <tr>
    <td>Serial Number: <?php echo $row_Recordset1['SerialNumber']; ?><br></td>
  </tr>
   <tr>
    <td>Model Number: <?php echo $row_Recordset1['ModelNumber']; ?><br></td>
  </tr>
</table>






 <br>
 <HR>
<u><strong>Be sure these accessories are included:</strong></u> <br>
(LAB AIDS: Check off all accessories in bags. If accessories is not in the bag
do
not
check
off.)
<form action="checkoutactionEB.php" method="get">
<input type="hidden" name="EquipID" value="<? echo $HTTP_GET_VARS['EquipID'] ?>">
<input type="hidden" name="StudentID" value="<? echo $HTTP_GET_VARS['StudentID'] ?>">
<input type="hidden" name="ReturnDate" value="<? echo $returndateSQL ?>">

<?php do { ?>
<p>

<input name="Accessory_TypeID[]" type="checkbox" value="<?php echo $row_Recordset2['Accessory_TypeID']; ?>">
<?php echo $row_Recordset2['Name']; ?><br>
</p>

<?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>


</form>

</html>
</body>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
