<?php 

/* Things yet to do: check for greatest check out time and default to that
	multiple kit listing with multiple classes
	renewal system - reservation system
*/

require_once('config.php'); 
include('includes/headingEB.html');

session_start();

if ($_SESSION["logged-in"]!=1)
{ header("Location: indexEB.php?err=notloggedin");
  exit;
} 

$KitID = $_REQUEST['KitID'];
$StudentID = $_REQUEST['StudentID'];
$CheckingOut = $_REQUEST['Check[]'];
echo $CheckingOut;
//echo $StudentID;
//echo $KitID;
$today = date("F j, Y, g:i a");


mysql_select_db($database_equip, $equip);
$query_Recordset1 = sprintf("SELECT * FROM kit WHERE ID = $KitID");
$Recordset1 = mysql_query($query_Recordset1, $equip) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_equip, $equip);
$query_Recordset2 = sprintf("SELECT * FROM kit_accessorytype INNER JOIN accessorytype ON accessorytype.ID = kit_accessorytype.AccessorytypeID WHERE KitID = $KitID;");
$Recordset2 = mysql_query($query_Recordset2, $equip) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_equip, $equip);
$query_Recordset3 = sprintf("SELECT * FROM students WHERE StudentID = '$StudentID'");
$Recordset3 = mysql_query($query_Recordset3, $equip) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_equip, $equip);
$query_Recordset4 = sprintf("SELECT * FROM kit_class INNER JOIN student_class ON student_class.ClassID = kit_class.ClassID WHERE student_class.StudentID = '$StudentID' AND kit_class.kitID = $KitID");
$Recordset4 = mysql_query($query_Recordset4, $equip) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4); 

if ($row_Recordset1['ContractRequired'] == 1) { 
echo("<b>Student must sign an individual contract for this kit.</b>");
}
?>
<P>
<form name="frmCheckOut" action="checkoutactionEB.php" method="post">

<input type="hidden" name="FirstName" value="<?php echo $row_Recordset3['FirstName']; ?>">
<input type="hidden" name="LastName" value="<?php echo $row_Recordset3['LastName']; ?>">
<input type="hidden" name="KitName" value="<?php echo $row_Recordset1['Name']; ?>">
<input type="hidden" name="ModelNumber" value="<?php echo $row_Recordset1['ModelNumber']; ?>">
<input type="hidden" name="SerialNumber" value="<?php echo $row_Recordset1['SerialNumber']; ?>">
<input type="hidden" name="ContractRequired" value="<?php echo $_REQUEST['ContractRequired']; ?>">


<P>
<strong><?php echo $row_Recordset3['FirstName']; ?> <?php echo $row_Recordset3['LastName']; ?></strong> is
 checking out a <strong><?php echo $row_Recordset1['Name']; ?></strong><br>
 Checked Out: <strong><?php echo $today; ?></strong><br />
 Due Back: 
 <select name="Month">
 <option value="Jan">Jan</option>
 <option value="Feb">Feb</option>
 <option value="March">March</option>
 <option value="April">April</option>
 <option value="May">May</option>
 <option value="June">June</option>
 <option value="July">July</option>
 <option value="Aug">Aug</option>
 <option value="Sept">Sept</option>
 <option value="Oct">Oct</option>
 <option value="Nov">Nov</option>
 <option value="Dec">Dec</option> 
 </select>
 <select name="Day">
 <option value="1">1</option>
 <option value="2">2</option>
 <option value="3">3</option>
 <option value="4">4</option>
 <option value="5">5</option>
 <option value="6">6</option>
 <option value="7">7</option>
 <option value="8">8</option>
 <option value="9">9</option>
 <option value="10">10</option>
 <option value="11">11</option>
 <option value="12">12</option>
 <option value="13">13</option>
 <option value="14">14</option>
 <option value="15">15</option>
 <option value="16">16</option>
 <option value="17">17</option>
 <option value="18">18</option>
 <option value="19">19</option>
 <option value="20">20</option>
 <option value="21">21</option>
 <option value="22">22</option>
 <option value="23">23</option>
 <option value="24">24</option>
 <option value="25">25</option>
 <option value="26">26</option>
 <option value="27">27</option>
 <option value="28">28</option>
 <option value="29">29</option>
 <option value="30">30</option>
 <option value="31">31</option> 
 </select>
 <select name="Year">
 <option value="2008">2008</option>
 <option value="2009">2009</option>
 <option value="2010">2010</option>
 <option value="2011">2011</option>
 <option value="2012">2012</option>
 <option value="2012">2013</option>
 </select>
<p>
 

 <br>
 <table width="40%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> Item: <strong><?php echo $row_Recordset1['Name']; ?></strong></td>
  </tr>
  <tr>
    <td><div align="center">
    <? 
    $Image = $row_Recordset1['Image'];
    if($Image!=""){ 
    echo("<IMG SRC=\"images/$Image\">");
    }?>
    <br>
    </div></td>
  </tr>
  <tr>
    <td>Serial Number: <?php echo $row_Recordset1['SerialNumber']; ?><br></td>
  </tr>
   <tr>
    <td>Model Number: <?php echo $row_Recordset1['ModelNumber']; ?><br></td>
  </tr>
</table>


 <br>
 <HR>
<u><strong>Be sure these accessories are included:</strong></u> <br>
<i>LAB AIDS: Check off all accessories in bags. If accessory is not in the bag
do not check off.</i>

<input type="hidden" name="KitID" value="<? echo $KitID ?>">
<input type="hidden" name="StudentID" value="<? echo $StudentID ?>">
<input type="hidden" name="FirstName" value="<?php echo $row_Recordset3['FirstName']; ?>">
<input type="hidden" name="LastName" value="<?php echo $row_Recordset3['LastName']; ?>">
<input type="hidden" name="ModelNumber" value="<?php echo $row_Recordset1['ModelNumber']; ?>">
<input type="hidden" name="SerialNumber" value="<?php echo $row_Recordset1['SerialNumber']; ?>">
<input type="hidden" name="ReturnDate" value="<? echo $returndateSQL ?>">
<P>
<?
$i = 0;
do { 
$AccessoryName = $row_Recordset2['Name'];
echo"<input name=\"Accessory$i\" type=\"checkbox\" value=\"$AccessoryName\">";
echo $AccessoryName ."<br>";
$i++;
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); 
?>
<P>
Notes:<br>
<textarea cols=80 rows=5 name="Notes"></textarea><br>
<input type="submit" name="Submit" value="Check Out">

</form>

<? 
include('includes/footerEB.html'); 
mysql_free_result($Recordset1);
mysql_free_result($Recordset2);
mysql_free_result($Recordset3);
mysql_free_result($Recordset4);
?>
