<?php include('includes/headingEB.html'); 

require_once('config.php');

$KitID = $_REQUEST['KitID'];

mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("SELECT kit.ID AS KitID, kit.Name AS KitName, kit.ImageThumb AS KitImageThumb, accessorytype.ID AS AccessoryTypeID, accessorytype.Name AS AccessoryTypeName, kit_accessorytype.ID AS KitAccID FROM kit LEFT JOIN kit_accessorytype ON kit_accessorytype.KitID = kit.ID LEFT JOIN accessorytype ON kit_accessorytype.AccessorytypeID = accessorytype.ID WHERE kit.ID = $KitID");
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_equip, $equip);
$query_Recordset2 = sprintf("SELECT checkedout.ID AS checkID, Notes, LastName, FirstName, DateOut, DateIn, CheckoutUser, CheckinUser FROM checkedout LEFT JOIN students ON students.StudentID = checkedout.StudentID WHERE KitID = $KitID ORDER BY checkedout.ID DESC");
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$CheckedOutCount = 0;
?>
<style type="text/css">
<!--
.accessoryText {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	line-height: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	color: #666666;
}
-->
</style>

<div align="center"><strong>KIT'S CHECKOUT HISTORY</strong><br>
  <br>
</div>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="3">


<?php 
$AccessoryCount = 0;

do { 
if ($CurrentKitID != $row_Recordset1['KitID']) {
if ($FirstTime == 1) {
echo "</td></tr>";
}
$AccessoryCount = 0;
$AccessoryFirstTime = 0;

?>
<tr>
    <td colspan="2"><strong>Kit Name:</strong> <? echo $row_Recordset1['KitName']; ?></td>

        </tr>
        <tr>
        <td valign='top' CLASS='accessoryText'>
      <?
if (isset($row_Recordset1['KitImageThumb'])){
echo "<p><IMG SRC='images/".$row_Recordset1['KitImageThumb']."' align='center'>";
echo "</td><td valign='top' CLASS='accessoryText'>";
}
if (isset($row_Recordset1['AccessoryTypeName'])){
echo '<em><strong>Accessories</strong></em>';
}
$CurrentKitID = $row_Recordset1['KitID'];
echo "<BR>";
}
if (isset($row_Recordset1['AccessoryTypeName'])){


//echo $row_Recordset1['KitAccID'];
//echo " - ";
if($AccessoryCount > 8){
if($AccessoryFirstTime < 1){
echo "</td><td valign='top' CLASS='accessoryText'>";
$AccessoryFirstTime++;
}
}
echo $row_Recordset1['AccessoryTypeName'];
echo "<BR>";
$AccessoryCount++;
}

$FirstTime++;
 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); 
 ?>
        </div>
      </blockquote>
</table>

CHECKOUT HISTORY:
<p>
<table border="1" cellpadding="5">
	<tr>
		<td>Student Name</td>
		<td>Date Out</td>
		<td>By</td>
		<td>Date In</td>
		<td>By</td>
	</tr>
	
		
        <?
       
       if(isset($row_Recordset2['checkID'])){
    
        do { 
        if($row_Recordset2['checkID']!=$tempID){
        ?>
        <tr>
        	<td><? echo $row_Recordset2['LastName'] ?>, <? echo $row_Recordset2['FirstName'] ?></td>
        	<td><? echo $row_Recordset2['DateOut'] ?></td>
        	<td><? echo $row_Recordset2['CheckoutUser'] ?></td>
        	<td><? echo $row_Recordset2['DateIn'] ?></td>
        	<td><? echo $row_Recordset2['CheckinUser'] ?></td>
        </tr>
        <tr>
        	<td colspan="5"><? echo $row_Recordset2['Notes'] ?></td>
        </tr>
        
     
        
   <?	
  }
  $tempID=$row_Recordset2['checkID'];
         } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
 
       }
        ?>
</table>

<? include('includes/footerEB.html');  ?>