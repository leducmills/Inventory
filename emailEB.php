<?php require_once('Connections/equip.php'); ?>
<HTML>

<head>
<style>
div.content {
	border: 1px dotted #000000;
	padding: 0.7em;
	margin: 0.5em 0em 0.5em 0em;
}
.bodyText {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.bodyBorder {
	border: 1px dotted #000000;
}
</style>
</head>

<BODY>


<?php

//EMAIL FOR TESTING
$ToEmail = "**********";
$Start = $_REQUEST[Start];
$State = $_REQUEST[State];




     
     
     
mysql_select_db($database_equip, $equip);
$query_email = "SELECT * FROM students ORDER BY email";
$email = mysql_query($query_email, $equip) or die(mysql_error());
$row_email = mysql_fetch_assoc($email);
$totalRows_email = mysql_num_rows($email);

do { 
$ToEmail = $row_email['Email'] . "@**********.com";
$conName = $row_email['Name'];

if($ToEmail != $previousEmail){
if(strlen($ToEmail)>6){


echo $conName  . " - " . $ToEmail . "<br>";

// MOVE MESSAGE AND MAIL FUNCTION HERE

//MESSAGE


$message = "\r\n" .

"In the rush to get a second equipment checkout created in the Service Bureau at he beginning of the semester, we weren't able to get policies in place to charge fines for equipment that is returned late.  We now have that in place as well correcting the default 24 hour checkout period.  Student can now see the equipment they are allowed to checkout based on their classes as well as when that equipment is expected to be returned.\r\n" .

"http://gcc.bradley.edu/labs/students.php\r\n" .

"Before being able to checkout equipment after Spring Break, students must sign a contract that includes these policies and provide local contact information.\r\n" .

"The new policies are...\r\n" .

"1) Fees will be assessed for equipment that is not returned before it is due at a rate of $5 every 15 minutes up to $100 a day.  If equipment is more than 24 hours late, the student will be contacted by phone and email.  If it is not returned within 48 hours, it will be reported stolen with Campus Police.\r\n" .

"2) Students will not be able to check additional equipment out if they owe fines.  Fines can only be paid using QuickCash.  Once the fine is paid, the Service Bureau employee will contact me and I will remove the block on the student's account within 24 hours.\r\n" .

"Service Bureau student employees CANNOT remove a hold on a students checkout privileges.  Fines are automatically assessed by the software.  If you return something late, there is nothing the Service Bureau students can do to restore your checkout privileges.\r\n" .

"If you have questions about the new policies, let me know.\r\n" .

"---\r\n".

"Kevin Reynen\r".
"Director of Instructional Technology\r" .
"Slane College of Communications and Fine Arts\r" .
"Bradley University - Peoria, IL 61625\r";
	


//START EMAIL ACTION
mail("$ToEmail", "Changes to Equipment Checkout", $message,
     "From: ********** <**********>\r\n" .
     "Reply-To: **********\r\n" .
     "Return-Path: **********\r\n".
     "Return-Receipt-To: www@gcc.bradley.edu\r\n".
     "X-Mailer: PHP/" . phpversion());
//END EMAIL ACTION

$previousEmail = $ToEmail;
$i++;     
}
}

} while ($row_email = mysql_fetch_assoc($email));

echo "Count =" . $i;

mysql_free_result($email);

?>

</BODY>
</HTML>