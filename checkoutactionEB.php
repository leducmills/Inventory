<?php 

require_once('config.php'); 

$KitName = $_REQUEST['KitName'];
$ReturnDate = $_REQUEST['ReturnDate'];
$CheckoutDate = time();
$StudentID = $_REQUEST['StudentID'];
$KitID = $_REQUEST['KitID'];
$Accessories = $_REQUEST['Accessories'];
$Notes = $_REQUEST['Notes'];

$ModelNumber = $_REQUEST['ModelNumber'];
$SerialNUmber = $_REQUEST['SerialNumber'];
$FirstName = $_REQUEST['FirstName'];
$LastName = $_REQUEST['LastName'];


$Month = $_REQUEST['Month'];
$Day = $_REQUEST['Day'];
$Year = $_REQUEST['Year'];

$DateOut = date("D, F j, g:i a");
$DueBack = "$Month $Day, $Year";
//echo $DueBack;
//echo $Month;

if ($_REQUEST['ContractRequired']==1) {

	require_once('contract.txt'); 
?>
	
	<P>
	<b>
	Kit: <i><? echo $KitName; ?></i> 
	<P>
	<?
	$i = 0;
	$j = 0;
	
	do { 
	$AccessoryID = "Accessory$i";
	
	if ($_REQUEST[$AccessoryID] != "") {
	if ($j > 0) {
	$Accessories = $Accessories . ", " . $_REQUEST[$AccessoryID]; 
	} else {
	$Accessories = $_REQUEST[$AccessoryID]; 
	$j++;
	}
	}
	
	$i++;
	} while ($i < 50); 
	
	
	?>
	Accessories: <i><? echo $Accessories ?></i>
	
	<P>
	Notes: <i><? echo $_REQUEST['Notes']; ?></i>
	<P>
	Checked Out: <i><? echo $DateOut; ?></i>
	<P>
	Due Back: <i><? echo $DueBack; ?></i><br>
	<P>&nbsp;
	<P>
	Student's Signature: <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
	
	</div>
	</td>
	</tr>
	</table>
	</center>
	
	
	<form name="frmCheckOut" action="checkoutactionEB.php" method="post">
	
	<input type="hidden" name="FirstName" value="<? echo $FirstName; ?>">
	<input type="hidden" name="LastName" value="<? echo $LastName; ?>">
	<input type="hidden" name="KitName" value="<? echo $KitName; ?>">
	<input type="hidden" name="KitID" value="<? echo $KitID; ?>">
	<input type="hidden" name="StudentID" value="<? echo $StudentID; ?>">
	<input type="hidden" name="ReturnDate" value="<? echo $ReturnDate; ?>">
	<input type="hidden" name="Accessories" value="<? echo $Accessories; ?>">
	<input type="hidden" name="Notes" value="<? echo $Notes; ?>">
	<P>
	<center>
	<input type="submit" name="Submit" value="Contract Signed and Filed">
	</center>

<?
} else {
include('includes/headingEB.html');

function multi_post_item($repeatedString) {
$ArrayOfItems = array();
$raw_input_items = split("&", $_SERVER['QUERY_STRING']);
foreach($raw_input_items as $input_item) {
$itemPair = split("=", $input_item);
if($itemPair[0]==$repeatedString){
$ArrayOfItems[]=$itemPair[1];
}
}
return $ArrayOfItems;
}

//$AccArrray = multi_post_item($HTTP_GET_VARS['Accessory_TypeID']);
//echo $AccArrray[0];
//echo $Accessory_TypeID[0];
//echo $Accessory_TypeID[1];
//echo "<P>";
//echo var_dump($HTTP_GET_VARS['Accessory_TypeID']);




do { 
$AccessoryID = "Accessory$i";

if ($_REQUEST[$AccessoryID] != "") {
if ($j > 0) {
$Accessories = $Accessories . ", " . $_REQUEST[$AccessoryID]; 
} else {
$Accessories = $_REQUEST[$AccessoryID]; 
$j++;
}
}

$i++;
} while ($i < 50); 


$CheckoutUser = $HTTP_COOKIE_VARS["EquipmentCheckout"];
//$sql = "INSERT INTO checkedout (ID , KitID , StudentID , DateOut , ExpectedDateIn , DateIn , FinePaid , Reserved, Accessories, Notes, CheckoutUser) VALUES ('', '$KitID', '$StudentID', NOW(), '$ReturnDate', '', NULL , NULL, '$Accessories', '$Notes', '$CheckoutUser');";
//echo $sql;
$sql = "UPDATE kit SET CheckedOut = '1', Student_ID = '$StudentID', DateOut = '$DateOut', DueBack = '$DueBack', Notes = '$Notes' WHERE ID = '$KitID'"; 

mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());
//$Recordset1 = mysql_query($sql, $equip) or die(mysql_error());
//$row_Recordset1 = mysql_fetch_assoc($Recordset1);
//$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>
Name: <i><? echo $FirstName; ?> <? echo $LastName; ?></i>
<P>
UserID : <i><? echo $StudentID; ?></i>
<P>
Kit : <i><? echo $KitName; ?></i>
<P>
Model Number: <i><? echo $ModelNumber; ?></i>
<P>
Serial Number: <i><? echo $SerialNumber; ?></i>
<P>
Accessories: <i><? echo $Accessories ?></i>
<P>
Notes: <i><? echo $Notes; ?></i>
<P>
Checked Out: <i><? echo $DateOut; ?></i>
<P>
Due Back: <i><? echo $DueBack; ?></i><br>
<P>
Item Checked Out.  Return to <a href="studentinfoEB.php?StudentID=<? echo $StudentID ?>">Student Info Page</a>
<p>
CATION: Read this document carefully before signing.  <B>It commits you to pay for anything you break or damage while it is checked out to you.</B>
<P>
1. PURPOSE OF CONTRACT:  The Department of Communication has a large amount of equipment used regularly by students and staff.  In order to ensure responsible use of this equipment, provide for a means of protecting the university and the department from liability for damage or loss thereto, and to establish a method for assuring that the person who breaks, damages or loses any of this equipment through misuse or neglect will pay for repair or replacement costs, this contract has been devised.
<P>
2. PARTIES TO THE CONTRACT: Eyebeam Atelier and its Tech Staff shall be known as PARTY 1.
<P>
Name of User: <i><? echo $FirstName; ?> <? echo $LastName; ?></i> Shall be known as Party 2.
<P>
3. PARTY 1 agrees to allow the items(s) of equipment listed below for the period of time specified.  Each item is certified to be in good working order at the time the load is make, with the exception of any and all discrepancies NOTED and INITIALED by PARTY 2 below at the time of check-out.  In exchange for this valuable consideration, PARTY 2 agrees to be fully liable for any breakage, damage loss or theft of any and all such items specified on this contract below, to pay promptly on demand for such breakage, damage loss or theft and to accept full responsibility and liability for any costs of collection or any legal fees brought about as a result of this contract.
<p>
<P>
Signature:
<P>
<P>
<P>
<P><br /><br /><br />
<? include('includes/footerEB.html'); 
}
?>