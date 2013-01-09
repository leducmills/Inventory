<?php 
require_once('config.php'); 
include('includes/headingEB.html');

$KitID = $_REQUEST['KitID'];
$StudentID = $_REQUEST['StudentID'];


mysql_select_db($database_equip, $equip);
$sql = "SELECT * FROM kit WHERE ID = '$KitID' AND CheckedOut = '1' AND Student_ID = '$StudentID'";
$result = mysql_query($sql, $equip) or die(mysql_error());
$row = mysql_fetch_assoc($result);
$totalRows = mysql_num_rows($result);

mysql_select_db($database_equip, $equip);
$sql2 = "SELECT FirstName, LastName FROM students WHERE StudentID = '$StudentID'";
$result2 = mysql_query($sql2, $equip) or die(mysql_error());
$row2 = mysql_fetch_assoc($result2);

?>
<br>
<br>
<strong><? echo $row2['FirstName']; ?> <? echo $row2['LastName']; ?></strong> is returning a <strong><? echo $row['Name']; ?></strong>.
<? 
$image = $row['Image'];
if ($image != "") {
 echo("<IMG SRC=\"images/$image\">");
 }?>
<BR />
Serial Number: <strong><?php echo $row['SerialNumber']; ?></strong><br>
Model Number: <strong><?php echo $row['ModelNumber']; ?></strong><br>

<HR>
<!--
<FONT COLOR="red">Check to make sure all the items listed below are in the kit.  If something
is missing, do not check the kit in!  Ask the student to find the missing
item.  If they cannot find it, note what is missing in the box below and
check the "Report a Problem" option when checking in the kit.</FONT>
<p>
Accessories: <?php //echo $row_Recordset1['Accessories']; ?>
<p> -->
<form action="checkinactionEB.php" method="post">
Checked Out Notes:
<textarea cols=80 rows=5 name="Notes">
<? echo $row['Notes']; ?>
</textarea>
<br />
<input type="checkbox" name="Problem"> Report a Problem (this sends an email to the check-in administrator).<br>
<br />
<input type="hidden" name="CheckedOutID" value="<? echo $CheckedOutID ?>">
<input type="hidden" name="KitID" value="<? echo $KitID ?>">
<input type="hidden" name="StudentID" value="<? echo $StudentID ?>">
<input type="hidden" name="ReturnDate" value="<? echo $returndateSQL ?>">
<input type="hidden" name="ModelNumber" value="<? echo $row['ModelNumber'] ?>">
<input type="hidden" name="KitName" value="<? echo $row['Name'] ?>">



  <input type="submit" name="Submit" value="Check In">
  <br>
</form>

<? 
include 'includes/footerEB.html';
//mysql_free_result($Recordset1);

?>
