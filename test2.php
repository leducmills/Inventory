<?php 
if (strlen($_COOKIE["EquipmentCheckout"]) < 1) { 
header('location:indexEB.php');
}

require_once('config.php'); 

//$KitName = $_REQUEST['KitName'];
$ReturnDate = $_REQUEST['ReturnDate'];
$CheckoutDate = time();
$StudentID = $_REQUEST['StudentID'];
//$KitID = $_REQUEST['KitID'];
$Accessories = $_REQUEST['Accessories'];
$Notes = $_REQUEST['Notes'];

//$ModelNumber = $_REQUEST['ModelNumber'];
//$SerialNUmber = $_REQUEST['SerialNumber'];
$FirstName = $_REQUEST['FirstName'];
$LastName = $_REQUEST['LastName'];


$Month = $_REQUEST['Month'];
$Day = $_REQUEST['Day'];
$Year = $_REQUEST['Year'];

$DateOut = date("D, F j, g:i a");
$DueBack = "$Month $Day, $Year";

include('includes/headingEB.html');
?>

Name: <b><? echo $FirstName; ?> <? echo $LastName; ?></b>
<br>
UserID : <b><? echo $StudentID; ?></b>
<br>
Checked Out: <b><? echo $DateOut; ?></b>
<br>
Due Back: <b><? echo $DueBack; ?></b><br>
<br>
<HR>
<b>Item(s) Checked Out:</b>
<P>
<?
#code to find and display checked boxes
$listvals=$_POST['frmCheckOut'];
$n=count($listvals);
echo "User is checking out $n items from the list.<br>\n";
for($i=0;$i<$n;$i++) {
   //echo "Item $i=".$listvals[$i]."<br>\n";
   echo "<b>Item:</b>";
   mysql_select_db($database_equip, $equip);
   $query_Recordset1 = sprintf("SELECT * FROM kit WHERE ID = $listvals[$i]");
   $Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
   $row_Recordset1 = mysql_fetch_assoc($Recordset1);
   $totalRows_Recordset1 = mysql_num_rows($Recordset1);
   
   $ID = $row_Recordset1['ID'];
   
   $sql = "UPDATE kit SET CheckedOut = '1', Student_ID = '$StudentID', DateOut = '$DateOut', DueBack = '$DueBack', Notes = '$Notes' WHERE ID = '$ID'"; 

mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());
   
?>   
Kit : <b><? echo $row_Recordset1['Name']; ?></b>
<P>
Model Number: <b><? echo $row_Recordset1['ModelNumber']; ?></b>
<P>
Serial Number: <b><? echo $row_Recordset1['SerialNumber']; ?></b>
<P>   
<? } ?>

Notes: <? echo $Notes; ?>
<p>
Item Checked Out.  Return to <a href="studentinfoEB.php?StudentID=<? echo $StudentID ?>">Student Info Page</a>
<p>
CATION: Read this document carefully before signing.  <B>It commits you to pay for anything you break or damage while it is checked out to you.</B>
<P>
1. PURPOSE OF CONTRACT:  The Department of Communciation has a large amount of equipment used regularly by students and staff.  In order to ensure responsible use of this equipment, provide for a means of protecting the university and the department from liability for damage or loss thereto, and to establish a method for assuring that the person who breaks, damages or loses any of this equipment through misuse or neglect will pay for repair or replacement costs, this contract has been devised.
<P>
2. PARIES TO THE CONTRACT: Eyebeam Atelier and its Tech Staff shall be known as PARTY 1.
<P>
Name of User: <b><? echo $FirstName; ?> <? echo $LastName; ?></b> Shall be known as Party 2.
<P>
3. PARTY 1 agrees to allow the items(s) of equipment listed below for the period of time specified.  Each item is certified to be in good working order at the time the load is make, with the exception of any and all discrepancies NOTED and INTIALED by PARTY 2 below at the time of check-out.  In exchange for this valuable consideration, PARTY 2 agrees to be fully liable for any breakage, damage loss or theft of any and all such items specified on this contract below, to pay promptly on demand for such breakage, damage loss or theft and to accept full responsibility and liability for any costs of collection or any legal fees brought about as a result of this contract.
<p>
<P>
Signature:
<P>
<P>
<P>
<P><br /><br />
<? echo $FirstName; ?> <? echo $LastName; ?>
<br />
<? include('includes/footerEB.html'); 
?>
