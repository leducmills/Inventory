<?php 

require_once('config.php');
 
session_start();


$equip = mysql_connect($hostname_equip, $username_equip, $password_equip);
if (!$equip)
    die("Error " . mysql_errno() . " : " . mysql_error());

# Select the DB
$db_selected = mysql_select_db($database_equip, $equip);
if (!$db_selected)
    die("Error " . mysql_errno() . " : " . mysql_error());

$usernameLabel = "Username:";
$usernameName = "username";
$usernameValue = $_POST[$usernameName];

$passwordLabel = "Password:";
$passwordName = "password";
$passwordValue = $_POST[$passwordName];

$submitName = "dataAction";
$submitValue = "Submit";

$statusMsg = "";    # Gives response back to user (i.e. "Thank you for your ...")
$hasErrors = 0;    # Keeps track of whether there are input errors

if ($_POST[$submitName]==$submitValue)
{    # Someone wants to login

    # Error Checking
    $noPassword = $noUsername = 0;
    $userid = 0;
    $usernameValue = trim($usernameValue);
    $passwordValue = trim($passwordValue);
    
    if (empty($usernameValue))
    {    $hasErrors = 1; $noUsername = 1; $statusMsg = "There were errors in your login info.";
    }

    if (empty($passwordValue))
    {    $hasErrors = 1; $noPassword = 1; $statusMsg = "There were errors in your login info.";
    }
    
    if (!$hasErrors)
    {    # This is a good submission
        $usernameValueDB = str_replace("'", "''", $usernameValue);
        $passwordValueDB = str_replace("'", "''", $passwordValue);
        
        # Look for this information in the DB
        $SqlStatement = "SELECT Username, Password FROM users
            WHERE username='$usernameValueDB' AND password='$passwordValueDB'";
        # print $SqlStatement . "\n";
            
        # Run the query on the database through the connection
        $result = mysql_query($SqlStatement,$equip);
        if (!$result)
            die("Error " . mysql_errno() . " : " . mysql_error());
			
			
		 if ($row = mysql_fetch_array($result,MYSQL_NUM))
        {    # Successful login
            $username = $row[0];
            $password = $row[1];
			setcookie("EquipmentCheckout", $username, time()+600);
            
            
            # Set our logged in session parameters
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            $_SESSION["lastname"] = $lastname;
            $_SESSION["logged-in"] = 1;
            unset($_SESSION["login-trials"]);
			
			mysql_close($equip);
            
            # Make sure the session data gets written
            session_write_close();
            
            # Now go to the member home page
           header("Location: studentidEB.php");
            exit;
        }
        else
        {    # Bad login
            if (empty($_SESSION["login-trials"]))
                $_SESSION["login-trials"] = 1;
            
            
            $statusMsg = "Your login information was incorrect.  Please try again. ".$_SESSION["login-trials"];
        }
    }
}
			
		

//SHOW LOGIN FORM
 include('includes/headingEB.html'); ?>
<HTML>

<link href="includes/equipEB.css" rel="stylesheet" type="text/css">

<BODY OnLoad=form.Username.focus();>


<form name="form" action="indexEB.php" method="post">
<b>Admin Sign-In</b>
<p>
<a href="/Checkout/publicListEB.php">Click Here</a> for the public equipment listing.
<p>
  Username:
    <input name="<?=$usernameName?>" value="<?=$usernameValue ?>" type="text" id="Username">
  </p>
  <?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noUsername)
{    print '<br><font color="#000000"><b>Please provide a username</b></font>';
}

?>
<p>
  Password :
    <input name="<?=$passwordName?>" value="<?=$passwordValue?>" type="password" id="Password"> 
</p>
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noPassword)
{    print '<br><font color="#000000"><b>Please provide a password</b></font>';
}

?>
<p>
  <input type="submit" name="<?=$submitName?>" value="<?=$submitValue?>">
</p>
</form>

</BODY>
</HTML>
<? // } ?>
<? include('includes/footerEB.html'); ?>
<? mysql_close($equip); ?>