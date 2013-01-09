<?php 
require_once('config.php'); 
include('includes/headingEB.html');

$StudentID = $_POST['StudentID'];

$sql = "UPDATE students SET ContractSigned = '1' WHERE StudentID = '$StudentID'";
//echo $sql;
mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());

?>

Contract Signed. Thank you.

Page will refresh automatically.

<meta http-equiv="refresh" content="3,studentinfoEB.php?StudentID=<? echo $StudentID ?>" />
<? 
include 'includes/footerEB.html';
?>