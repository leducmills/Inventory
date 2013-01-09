<?php 
require_once('config.php'); 
include('includes/headingEB.html');

$CheckedOutID = $_POST['CheckedOutID'];
$FinePaid = $_POST['FinePaid'];

$sql = "UPDATE checkedout SET FinePaid = '$FinePaid' WHERE ID = $CheckedOutID;";
//echo $sql;
mysql_select_db($database_equip, $equip);
mysql_query($sql, $equip) or die(mysql_error());

?>

Fine Paid. Thank you. 

<? 
include 'includes/footerEB.html';
?>