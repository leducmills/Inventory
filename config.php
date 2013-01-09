<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

# YOU MUST CHANGE THESE TO YOUR LOCAL SERVER SETTINGS
$hostname_equip = "**********";
$database_equip = "**********";
$username_equip = "**********";
$password_equip = "**********";
$equip = mysql_pconnect($hostname_equip, $username_equip, $password_equip) or die(mysql_error());

# CHANGE YOUR TIME ZONE HERE
putenv("TZ=US/Eastern");

$weekends = true; // if open weekends, flag this


// set your open and close times here. System will only work with Hour arguments, input hour in 24 our time in format HH
$monOpen = 10;
$monClose = 22;
$tueOpen = 10;
$tueClose = 22;
$wedOpen = 10;
$wedClose = 22;
$thuOpen = 10;
$thuClose = 22;
$friOpen = 10;
$friClose = 17;
$satOpen = 12;
$satClose = 15;
$sunOpen = 12;
$sunClose = 15;


// fine controls
$fineAmount = 5.00; // amount of fine
$fineFreq = 900; // amount of time per fine increment, in seconds
$maxFine = 100.00; // max amount of fine per kit
?>