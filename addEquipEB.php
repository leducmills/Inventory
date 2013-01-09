<?php 
if (strlen($_COOKIE["EquipmentCheckout"]) < 1) { 
header('location:indexEB.php');
}
require_once('config.php');
  
# connect
$equip = mysql_connect($hostname_equip, $username_equip, $password_equip);
if (!$equip)
    die("Error " . mysql_errno() . " : " . mysql_error());

# Select the DB
$db_selected = mysql_select_db($database_equip, $equip);
if (!$db_selected)
    die("Error " . mysql_errno() . " : " . mysql_error());


#note -- need code for image upload and category assignment
$nameLabel = "Name:";
$nameName = "name";
$nameValue = $_POST[$nameName];

$modelLabel = "Model:";
$modelName = "model";
$modelValue = $_POST[$modelName];

$serialNumberLabel = "SerialNumber:";
$serialNumberName = "serialNumber";
$serialNumberValue = $_POST[$serialNumberName];
 
$valueLabel = "Value:";
$valueName = "value";
$valueValue = $_POST[$valueName];

# Image names
$filename = "";
$outfile = "";

$uploadFileLabel = "Select Image:";
$uploadFileName = "file";

$delURLName = "cmd";
$delURLValue = "del";

# CHANGE THESE TO YOUR LOCAL DIRECTORIES
$upload_dir = "**********";
$image_dir = "**********";
$thumb_dir = "**********";
$web_dir = "**********";

$goodFile = 0;
//$imageLabel = "Image:";
//$imageName = "image";
//$imageValue = $_POST[$imageName];

$locationLabel = "Location:";
$locationName = "location";
$locationValue = $_POST[$locationName];


$notesLabel = "Notes:";
$notesName = "notes";
$notesValue = $_POST[$notesName];
 
//$categoriesLabel = "Categories:";
//$categoriesName = "catgories";
//$categoriesValue = $_POST[$categoriesName];
$listvals=$_POST['categories'];	 
 
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
    //$noName = $noModelNumber = $noSerialNumber = $noValue = $noImage = $noNotes = $noCategories = 0;
	$noName = $noModelNumber = $noSerialNumber = $noValue = $noImage = $noLocation = $noNotes = 0;
    #$userid = 0;
	$nameValue = trim($nameValue);
	$modelValue = trim($modelValue);
	$serialNumberValue = trim($serialNumberValue);
    $valueValue = trim($valueValue);
	$locationValue = trim($locationValue);
    //$imageValue = trim($imageValue);
	$notesValue = trim($notesValue);
	//$categoriesValue = trim($categoriesValue);
    
	
	$filename = basename($_FILES[$uploadFileName]['name']);
    
    # Remove spaces and go to lowercase
    $filename = str_replace(" ","",$filename);
    $filename = strtolower($filename);
    $fullFilename = $upload_dir.$filename;
	
    if (empty($nameValue))
    {    $hasErrors = 1; $noName = 1; $statusMsg = "There were errors in your registration info.";
    }
	
    if (empty($modelValue))
    {    $hasErrors = 1; $noModelNumber = 1; $statusMsg = "There were errors in your registration info.";
    }
	
    if (empty($serialNumberValue))
    {    $hasErrors = 1; $noSerialNumber = 1; $statusMsg = "There were errors in your registration info.";
    }
	
    if (empty($valueValue))
    {    $hasErrors = 1; $noValue = 1; $statusMsg = "There were errors in your registration info.";
    }
	
	if (empty($locationValue))
    {    $hasErrors = 1; $noLocation = 1; $statusMsg = "There were errors in your registration info.";
    }
	
	if (empty($notesValue))
    {    $hasErrors = 1; $noNotes = 1; $statusMsg = "There were errors in your registration info.";
    }
	
	if (empty($listvals))
	{     $hasErrors =1; $statusMsg = "Your list has no vals.";
	}
	
	/*if (empty($categoriesValue))
    {    $hasErrors = 1; $noCategories = 1; $statusMsg = "There were errors in your registration info.";
    }*/
	
	 # Make sure this has an image file extentions
    $pattern = ".(gif|jpg|jpeg|png)$"; # A reg exp that looks for familiar file endings
    $goodFile = eregi($pattern,$filename);
	
	$filetype = "";
	if (eregi("[.](jpeg|jpg)$", $filename)) $filetype = "jpg";
	if (eregi("[.](gif)$", $filename)) $filetype = "gif";
	if (eregi ("[.](png)$", $filename )) $filetype = "png";
	
	if (!$goodFile)
    { $statusMsg = "Please upload an image file (GIF, JPG or PNG).";
    }
	elseif (move_uploaded_file($_FILES[$uploadFileName]['tmp_name'], $fullFilename))
	
	{    if (file_exists($fullFilename))
	
	if (!$hasErrors)
    {    
		# This is a good submission
		$nameValueDB = str_replace("'", "''", $nameValue);
		$modelValueDB = str_replace("'", "''", $modelValue);
		$serialNumberValueDB = str_replace("'", "''", $serialNumberValue);
        $valueValueDB = str_replace("'", "''", $valueValue);
        //$imageValueDB = str_replace("'", "''", $imageValue);
		$locationValueDB = str_replace("'", "''", $locationValue);
		$notesValueDB = str_replace("'", "''", $notesValue);
		$filenameDB = str_replace("'", "''", $filename);
		$thumbDB =  $filenameDB;
		//$listvalsDB = str_replace("'", "''", $listvals);
		//$categoriesValueDB = str_replace("'", "''", $categoriesValue);
		
		# Insert this information in the DB (REGISTERATION PAGE)
        $SqlStatement = "INSERT INTO kit (Name, Image, ImageThumb, ModelNumber, SerialNumber, Value, Location, Notes)
           VALUES ('$nameValueDB', '$filenameDB', '$filenameDB', '$modelValueDB', '$serialNumberValueDB', '$valueValueDB', '$locationValueDB', '$notesValueDB')";
         #print $SqlStatement . "\n";
			
        # Run the query on the database through the connection
        $result = mysql_query($SqlStatement,$equip);
        if (!$result)
            die("Error " . mysql_errno() . " : " . mysql_error());
		
		
		$SqlStatement = "SELECT max(id) FROM kit";
            $result = mysql_query($SqlStatement,$equip);
            if (!$result)
                die("Error " . mysql_errno() . " : " . mysql_error());
            if ($row = mysql_fetch_array($result,MYSQL_NUM))
            {    $max_id = $row[0];
	
				$n=count($listvals);
				for($i=0;$i<$n;$i++) {
		
   				mysql_select_db($database_equip, $equip);
   				$query_Recordset1 = sprintf("INSERT INTO cat_X_kit (KITID, CATID)
  				VALUES ('$max_id','$listvals[$i]')");
   				$result = mysql_query($query_Recordset1,$equip);
      			if (!$result)
    			die("Error " . mysql_errno() . " : " . mysql_error());
				}
		
			}
		
		
		
		$SqlStatement = "SELECT max(id) FROM kit";
            $result = mysql_query($SqlStatement,$equip);
            if (!$result)
                die("Error " . mysql_errno() . " : " . mysql_error());
            if ($row = mysql_fetch_array($result,MYSQL_NUM))
            {    $max_id = $row[0];
            
			
                $fileParts = split('\.',$fullFilename);
                $newFilename = $max_id.".".end($fileParts);
				$newThumbFilename = $max_id."thumb".".".end($fileParts);
               
			    $newThumbAppend = "thumb";
                $oldFullFilename = $upload_dir.$filename;
				$newFullFilename = $image_dir.$newFilename;
				$thumbFilename = $image_dir.$newFilename;
                
                rename($oldFullFilename,$newFullFilename);
                
                # Let's rename it in the DB
                $newFilenameDB = str_replace("'", "''", $newFilename);
				$thumbFilenameDB = str_replace("'", "''", $thumbFilename);
                $SqlStatement = "UPDATE kit
                    SET Image='$newFilenameDB'
                    WHERE id=$max_id";
                $result = mysql_query($SqlStatement,$equip);
                if (!$result)
                    die("Error " . mysql_errno() . " : " . mysql_error());
            }
			
			// Get new sizes
			list($width, $height) = getimagesize($newFullFilename);
			
			// or set explicitly
			$newwidth = 160;
			$newheight = 120;

			// create the thumb image
			$thumb = imagecreatetruecolor($newwidth, $newheight);

			// get the source data
			if ($filetype=="gif")
   		 		$source = imagecreatefromgif($newFullFilename);
			elseif ($filetype=="jpg")
    			$source = imagecreatefromjpeg($newFullFilename);
			elseif ($filetype=="png")
				$source = imagecreatefrompng($newFullFilename);

			// resize
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			// create the thumb
			if ($filetype=="gif")
    			imagegif($thumb,$thumbFilename);
			elseif ($filetype=="jpg")
    			imagejpeg($thumb,$thumbFilename);
			elseif ($filetype=="png")
    			imagepng($thumb,$thumbFilename);
				
			$thumbFilenameDB = str_replace("'", "''", $newFilename);
            $SqlStatement = "UPDATE kit
                    SET ImageThumb ='$thumbFilenameDB'
                    WHERE id=$max_id";
            $result = mysql_query($SqlStatement,$equip);
                if (!$result)
                    die("Error " . mysql_errno() . " : " . mysql_error());
				
			}	
			else
        {    $statusMsg = "An error occurred while uploading $filename";
        }
    }
    else
    {    $statusMsg = "An error occurred while uploading $filename";
    }
			
			
			mysql_close($equip); 
            
            # Make sure the session data gets written
            session_write_close();
            
            # Now go to the member home page
           header('location:allEquipListEB.php');
            exit;
        }
			
include('includes/headingEB.html'); ?>

<html>
<body>
<form name="form" action="addEquipEB.php" method="post" enctype="multipart/form-data">


Equipment Name: <input name="<?=$nameName?>" value="<?=$nameValue?>" type="text">
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noName)
{    print '<br><font color="#ff0000"><b>Please provide an Equipment Name</b></font>';
}

?>
<p>
Model: <input name="<?=$modelName?>" value="<?=$modelValue?>" type="text">
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noModelNumber)
{    print '<br><font color="#ff0000"><b>Please provide a Model Number</b></font>';
}

?>
<p>
Serial Number: <input name="<?=$serialNumberName?>" value="<?=$serialNumberValue?>" type="text">
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noSerialNumber)
{    print '<br><font color="#ff0000"><b>Please provide a Serial Number</b></font>';
}
?>
<p>
Select Image:<input type="file" name="file">
<?php
if ($hasErrors && $noFilename)
{    print '<br><font color="#ff0000"><b>Please provide an image file to upload</b></font>';
}
?>
<p>
Catagories (hold apple key to select multiple):
<br>
<select name="catagories[]" multiple>
<option value="1">Projectors</option>
<option value="2">Cameras</option>
<option value="3">Video Utilities & Accessories</option>
<option value="4">Media Storage & Players</option>
<option value="5">Computers</option>
<option value="6">Audio Gear</option>
<option value="7">Rapid Prototyping</option>
<option value="8">Wood Shop/Welding</option>
<option value="9">Electronics Dev</option>
<option value="10">Computer Peripherals & Accessories</option>
<option value="11">Cables & Adapters</option>
</select>
<p>
Value ($): <input name="<?=$valueName?>" value="<?=$valueValue?>" type="text">
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noValue)
{    print '<br><font color="#ff0000"><b>Please provide a Value</b></font>';
}
?>
<p>
Location: <input name="<?=$locationName?>" value="<?=$locationValue?>" type="text">
<?php
#if problem, show error
if ($hasErrors && $noLocation)
{	print '<br><font color="#ff0000"><b>Please provide a Location</b></font>';
}
?>
<p>
Notes: <textarea cols=80 rows=5 name="<?=$notesName?>" value="<?=$notesValue?>"></textarea>
<?php

# If we had a problem with the name, show error message here
if ($hasErrors && $noNotes)
{    print '<br><font color="#ff0000"><b>Please provide some Notes</b></font>';
}
?>
<br>
<input type="submit" name="<?=$submitName?>" value="<?=$submitValue?>">
</form>

<? include('includes/footerEB.html'); ?>
<? mysql_close($equip); ?>
</body>
</html>