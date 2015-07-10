<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    If (is_numeric(nnull(Session("user_id"))) == False) echo header('Location: ../sessionexpired/?l=' . $cLang);
    
    $sql_ = "";
    If (Session("Role_id") == "2") {
        $sql_ = "select * from vehicles where clientID=" . Session("client_id") . " order by code";
    } Else {
        $sql_ = "select * from vehicles where id in (select vehicleID from UserVehicles where userID=" . Session("user_id") . ") order by code";
    }
	
	opendb();
	
    $dsVehicles = query($sql_);
   
	$langArr = explode("?", getQUERY("l"));
	$cLang = $langArr[0];
    
?>

    <div align=left style='padding-top:25px; margin-left:45px'>
<table>
   
    <tr>
        <td style='font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#2f5185; text-decoration: none;'><?php dic("Reports.EnterEmail")?></td>
<tr>
<tr>
        <td>
            <input id="toEmail" type="text" class="text1-" style="height:24px; width:270px; text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:green; text-decoration: none;" onclick="select_()" onkeydown="keyDown()"/>
        </td>
    </tr>

</table>
</div>

<div id="notification" style="color:green; text-align:left; padding-top:15px; font-style:italic; visibility:hidden; padding-left:45px"><img src="../images/success.gif" width="12px" height="12px">&nbsp;<?php dic("Reports.SucSent")?></div>

<?php
	closedb();
?>

<script>
    function select_() {
        document.getElementById('toEmail').select();
    }

    function keyDown() {
        document.getElementById('toEmail').style.color = "#2f5185";
        document.getElementById('toEmail').style.fontStyle = "";
    }
</script>
