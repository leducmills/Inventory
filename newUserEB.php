<?php 

require_once('config.php');

session_start();

#connect
$equip = mysql_connect($hostname_equip, $username_equip, $password_equip);
if (!$equip)
    die("Error " . mysql_errno() . " : " . mysql_error());

# Select the DB
$db_selected = mysql_select_db($database_equip, $equip);
if (!$db_selected)
    die("Error " . mysql_errno() . " : " . mysql_error());

$firstnameLabel = "Firstname:";
$firstnameName = "firstname";
$firstnameValue = $_POST[$firstnameName];

$lastnameLabel = "Lastname:";
$lastnameName = "lastname";
$lastnameValue = $_POST[$lastnameName];

$emailLabel = "Email:";
$emailName = "email";
$emailValue = $_POST[$emailName];

$phoneLabel = "Phone:";
$phoneName = "phone";
$phoneValue = $_POST[$phoneName];

$userIDLabel = "UserID:";
$userIDName = "userID";
$userIDValue = $_POST[$userIDName];

$submitName = "dataAction";
$submitValue = "Submit";

### Status variables ###
$statusMsg = "";    # Gives response back to user (i.e. "Thank you for your ...")
$hasErrors = 0;    # Keeps track of whether there are input errors


# Check our inputs and perform any DB actions
#########################################################
if ($_POST[$submitName]==$submitValue)
{    # Someone wants to login

    # Error Checking
    $noFirstname = $noLastname = $noEmail = $noPhone = $noUserID = 0;
    #$userid = 0;
	$firstnameValue = trim($firstnameValue);
	$lastnameValue = trim($lastnameValue);
	$emailValue = trim($emailValue);
    $phoneValue = trim($phoneValue);
    $userIDValue = trim($userIDValue);
    
	
    if (empty($firstnameValue))
    {    $hasErrors = 1; $noFirstname = 1; $statusMsg = "There were errors in your registration info.";
    }
	
    if (empty($lastnameValue))
    {    $hasErrors = 1; $noLastname = 1; $statusMsg = "There were errors in your registration info.";
    }
	
    if (empty($emailValue))
    {    $hasErrors = 1; $noEmail = 1; $statusMsg = "There were errors in your registration info.";
    }
	
    if (empty($phoneValue))
    {    $hasErrors = 1; $noPhone = 1; $statusMsg = "There were errors in your registration info.";
    }

    if (empty($userIDValue))
    {    $hasErrors = 1; $noUserID = 1; $statusMsg = "There were errors in your registration info.";
    }

 if (!$hasErrors)
    {    # This is a good submission
		$firstnameValueDB = str_replace("'", "''", $firstnameValue);
		$lastnameValueDB = str_replace("'", "''", $lastnameValue);
		$emailValueDB = str_replace("'", "''", $emailValue);
        $phoneValueDB = str_replace("'", "''", $phoneValue);
        $userIDValueDB = str_replace("'", "''", $userIDValue);
        
        # Look for this information in the DB
        #$SqlStatement = "SELECT id, firstname, lastname, email, last_login FROM class06_member
         #   WHERE username='$usernameValueDB' AND password='$passwordValueDB' ";
        # print $SqlStatement . "\n";
            
			
		# Insert this information in the DB (REGISTERATION PAGE)
        $SqlStatement = "INSERT INTO students (StudentID, FirstName, LastName, Email, Phone, ContractSigned)
           VALUES ('$userIDValueDB', '$firstnameValueDB', '$lastnameValueDB', '$emailValueDB', '$phoneValueDB', '0')";
         #print $SqlStatement . "\n";
			
        # Run the query on the database through the connection
        $result = mysql_query($SqlStatement,$equip);
        if (!$result)
            die("Error " . mysql_errno() . " : " . mysql_error());
			
			 //mysql_close($equip);
			 
		$Sql = "INSERT INTO student_class (StudentID, ClassID)
		VALUES ('$userIDValueDB', '1')";
		
		$result = mysql_query($Sql, $equip);
		if (!$result)
			die("Error " . mysql_errno() .  " : " . mysql_error());
			
			mysql_close($equip); 
            
            # Make sure the session data gets written
            session_write_close();
            
            # Now go to the member home page
           header("Location: studentidEB.php");
            exit;
        }
}		
include('includes/headingEB.html'); ?>

<html>
<body>
<form name="form" action="newUserEB.php" method="post">
<strong>New User Account Form</strong>
<p>

User ID: <input name="<?=$userIDName?>" value="<?=$userIDValue?>" type="text" id="userID">
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noUserID)
{    print '<br><font color="#ff0000"><b>Please provide a User ID</b></font>';
}

?>
<p>
First Name: <input name="<?=$firstnameName?>" value="<?=$firstnameValue?>" type="text" id="firstName">
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noFirstname)
{    print '<br><font color="#ff0000"><b>Please provide a Firstname</b></font>';
}

?>
<p>
Last Name: <input name="<?=$lastnameName?>" value="<?=$lastanameValue?>" type="text" id="lastName">
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noLastname)
{    print '<br><font color="#ff0000"><b>Please provide a Lastname</b></font>';
}
?>
<p>
E-mail: <input name="<?=$emailName?>" value="<?=$emailValue?>" type="text" id="eMail">
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noEmail)
{    print '<br><font color="#ff0000"><b>Please provide an E-Mail Address</b></font>';
}
?>
<p>
Phone: <input name="<?=$phoneName?>" value="<?=$phoneValue?>" type="text" id="phone">
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noPhone)
{    print '<br><font color="#ff0000"><b>Please provide a Phone Number</b></font>';
}
?>
<p>
<input type="submit" name="<?=$submitName?>" value="<?=$submitValue?>">
</form>



<? include('includes/footerEB.html'); ?>
<? mysql_close($equip); ?>
</body>
</html>