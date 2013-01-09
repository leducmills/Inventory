<?php 
require_once('config.php'); 
include('includes/headingEB.html');

$CheckedOutID = $_REQUEST['CheckedOutID'];
$Notes = $_REQUEST['Notes'];
$ModelNumber = $_REQUEST['ModelNumber'];
$KitName = $_REQUEST['KitName'];
$KitID = $_REQUEST['KitID'];
$StudentID = $_REQUEST['StudentID'];
$CheckInUser = $HTTP_COOKIE_VARS["EquipmentCheckout"];

if($_REQUEST['Problem']=="on"){
$Problem = 1;

$message = "There has been a problem with the checkout of $KitName - $ModelNumber\r\n\r\n$Notes\r\n\r\n";

//NOTE: CHANGE THESE TO MATCH YOUR DOMAIN
mail("****YOUR E-MAIL******", "SYSTEM MESSAGE - Checkout Problem with $KitName", $message,
     "From: $CheckInUser@****YOUR DOMAIN (E.G. 'gmail.com'****\r\n" .
     "Reply-To: $CheckInUser@****YOUR DOMAIN (E.G. 'gmail.com'****\r\n" .
     "X-Mailer: PHP/" . phpversion());
     
echo "Email sent to checkout administrator<p>";
     
} else {
$Problem = 0;
}

//$sql = "UPDATE checkedout SET DateIn = NOW(), Problem = $Problem, Notes = '$Notes', CheckInUser = '$CheckInUser' WHERE ID = $CheckedOutID;";
//echo $sql;
$sql = "UPDATE kit SET CheckedOut = '0', Student_ID = '' WHERE ID = '$KitID'"; 
mysql_select_db($database_equip, $equip);
$Recordset1 = mysql_query($sql, $equip) or die(mysql_error());
?>

Item returned. Return to <a href="studentinfoEB.php?StudentID=<? echo $StudentID ?>">Student Info Page</a>

<? include('includes/footerEB.html');  ?>