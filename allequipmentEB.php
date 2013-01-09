<?php require_once('config.php');
include('includes/headingEB.html'); 

mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("SELECT kit.ID AS KitID, kit.Name AS KitName, kit.ImageThumb AS KitImageThumb, accessorytype.ID AS AccessoryTypeID, accessorytype.Name AS AccessoryTypeName, kit_accessorytype.ID AS KitAccID FROM kit LEFT JOIN kit_accessorytype ON kit_accessorytype.KitID = kit.ID LEFT JOIN accessorytype ON kit_accessorytype.AccessorytypeID = accessorytype.ID ORDER BY kit.ID");
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_equip, $equip);
$query_Recordset2 = sprintf("SELECT * FROM checkedout WHERE DateIn = 0");
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

<div align="center"><strong>LIST OF EQUIPMENT</strong><br>
  <br>
</div>
<table width="550" border="0" align="center" cellpadding="5" cellspacing="5">


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
    <td>
        <strong>Kit Name:</strong> <? echo $row_Recordset1['KitName']; ?></div>
        </td><td>
        <?
       
       if(isset($row_Recordset2['ID'])){
        do { 
        if ($row_Recordset1['KitID']==$row_Recordset2['KitID']){
        
        echo("<B><font color=\"red\">Checked Out</font></B>");
        
        }
  
         } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
         mysql_data_seek($Recordset2, 0);
       }
        ?>
        </td>
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
<? include('includes/footerEB.html');  ?>