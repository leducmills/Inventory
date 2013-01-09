<?php 
require_once('config.php'); 
include('includes/headingEB.html'); 

if (empty($_REQUEST['StudentID'])) {
$SQL = " AND FinePaid is NULL";
echo "<strong>UNPAID FINES LIST</strong>";
} else {
$SQL = " AND checkedout.StudentID = " . $_REQUEST['StudentID'];
echo "HISTORY OF FINES FOR STUDENT CODE # " . $_REQUEST['StudentID'];
}
//PROBLEM WITH SQL SYNTAX -> not recognizing kit as a proper table, so not retriving fines correctly
mysql_select_db($database_equip, $equip);
$query_Recordset1 = "SELECT FirstName, LastName, checkedout.ID, checkedout.StudentID, checkedout.DateOut, checkedout.ExpectedDateIn, checkedout.DateIn, checkedout.kitID, checkedout.FinePaid, Kit.Name FROM checkedout LEFT JOIN students ON students.StudentID = checkedout.StudentID LEFT JOIN kit ON checkedout.KitID = kit.ID WHERE (unix_timestamp(DateIn) - $fineFreq) > unix_timestamp(ExpectedDateIn) $SQL";


$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<form action="finesEB.php" method="post">
<strong>Find Student Fines by ID:</strong><br>  
<input name="StudentID" type="text" value="<? echo $_REQUEST['StudentID'] ?>">
<input name="" type="submit" Value="Search">
</form>

<?php
if (isset($row_Recordset1['StudentID'])) {
do { 

?>
<p><font size="2" face="Arial, Helvetica, sans-serif"><strong>Student Name: </strong><?php echo $row_Recordset1['FirstName']; ?> <?php echo $row_Recordset1['LastName']; ?><strong><br>
  Student Code #: </strong><?php echo $row_Recordset1['StudentID']; ?>
  <br>
    <strong>Returned 
  Late:</strong> <?php echo $row_Recordset1['EquipmentID']; ?> - <?php echo $row_Recordset1['Name']; ?><strong><br>
  Date CheckOut:</strong> <?php 
  //echo $row_Recordset1['DateOut']; 
  echo date("D F j, Y, g:i a", strtotime($row_Recordset1['DateOut']));  
  ?>
  <br>
  <strong>Expected Return Date:</strong> <?php echo date("D, F j, g:i a", strtotime($row_Recordset1['ExpectedDateIn'])); ?><br>
  <strong>Actual Return Date:</strong> <?php echo date("D, F j, g:i a", strtotime($row_Recordset1['DateIn'])); 
  ?> <br>
  <strong>Fine Rate Per <?php echo $fineFreq/60?> Minutes:</strong> <?php echo '$'.number_format($fineAmount,2); ?> <br>
  <strong>Amount Due: $</strong>
  		<?php $timeDue = date(strtotime($row_Recordset1['ExpectedDateIn']));
				$timeIn = date(strtotime($row_Recordset1['DateIn']));
				$diff = abs($timeIn - $timeDue);
				if ($diff > $fineFreq) {
				$inc = round($diff/$fineFreq);
				$fineDue = $inc * $fineAmount;
				$fineDue = round($fineDue,2);
				if ($fineDue > $maxFine) {
					$fineDue = $maxFine;
					}
				} else { // the item was less than $fineFreq late, therefore no fine is issued
					$fineDue = 0.00;
					if (empty($row_Recordset1['FinePaid'])) { // this item hasn't been cleared, clear it and force a refresh to update screen
					$CheckedOutID = $row_Recordset1['ID'];
					$noFine = "UPDATE checkedout SET FinePaid = '0.00' WHERE ID = $CheckedOutID";
					//echo $sql;
					mysql_select_db($database_equip, $equip);
					mysql_query($noFine, $equip) or die(mysql_error());
					echo "<meta http-equiv='refresh' content='0'>";
					}
					// make this clear the fine from the list (set FinePaid)
				}
				echo number_format($fineDue,2);
				?>
	<?php if (empty($row_Recordset1['FinePaid'])) { ?>
  <form name="form1" method="post" action="finesaction.php">
 <strong>Pay Fine:</strong>  
<input name="FinePaid" type="text" id="FinePaid" value="<?php echo number_format($fineDue,2); ?>">
<input name="CheckedOutID" type="hidden" value="<?php echo $row_Recordset1['ID']; ?>">
  <input type="submit" name="Submit" value="Pay">
</form>
<?php } ?>
<P>
<p> 
  

<HR>


<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
} else {
echo "<P>No Fines Found</P>";
}
?>
<form action="fines.php" method="post">
<strong>Find Student Fines by ID:</strong><br>  
<input name="StudentID" type="text" value="<? echo $_REQUEST['StudentID'] ?>">
<input name="" type="submit" Value="Search">
</form>
<?
mysql_free_result($Recordset1);
include('includes/footerEB.html');
?>
