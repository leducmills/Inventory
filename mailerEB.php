#!/usr/local/bin/php -q
<?php
require_once('config.php');

mysql_select_db($database_equip, $equip);
$query_Recordset1 = "SELECT * FROM kit WHERE CheckedOut = '1'";
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);



if($row_Recordset1['ID']>0) {  

do {

$studentID = $row_Recordset1['Student_ID'];

mysql_select_db($database_equip, $equip);
$query_Recordset2 = "SELECT * FROM students WHERE StudentID = '$studentID'";
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

if($row_Recordset2['ID']>0) 

do {

if (intval(strtotime($row_Recordset1['DueBack'])) < intval(strtotime("now"))) {

$FirstName = $row_Recordset2['FirstName'];
$LastName = $row_Recordset2['LastName']; 

$message = "The following item, checked out by: $FirstName $LastName is now overdue.\r\n\r\n";

$ID = $row_Recordset1['ID'];
$Name = $row_Recordset1['Name'];
$ModelNumber = $row_Recordset1['ModelNumber'];
$SerialNumber = $row_Recordset1['SerialNumber'];
$DueBack = $row_Recordset1['DueBack'];

$message = $message . "ID: $ID\rName: $Name\rModel Number: $ModelNumber\rSerial Number: $SerialNumber\rWas Due Back: $DueBack"; 

mail("ben.itplist@gmail.com", "System Message - Overdue Equipment", $message);
}

} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));

} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));

}
?>