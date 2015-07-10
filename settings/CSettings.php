<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
	<?php
		$ua=getBrowser();
		$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
		$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
		
		$proverka1 = "";
		opendb();
		$Allow = getPriv("usersettings", session("user_id"));
		if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
		$display = 'display: none;';
		if ($_SESSION["role_id"] == "2"){ 
			$sqlV = query("select id from vehicles where clientid =" . $_SESSION['client_id']); 
			$row = pg_fetch_result($sqlV,0,"id"); 
			$proverka1= query("select id, fullname , roleid  from users  where clientid = " . Session("client_id"));
			$display = 'display: block;';
		}
		if ($_SESSION["role_id"] == "1"){ 
			$row = pg_fetch_result($sqlV, 0, "id"); 
		}
		if ($_SESSION["role_id"] == "3"){ 
			$sqlV2 = query("select vehicleid from UserVehicles where userid=" . $_SESSION['user_id'] . "") ;
			$row2 = pg_fetch_result($sqlV2, 0, "vehicleid"); 
			$proverka1= query("select id, fullname , roleid  from users  where id = " . Session("user_id"));
		}
		if ($_SESSION["role_id"] == "4"){ 
			$row = pg_fetch_result($sqlV, 0, "id"); 
		}
	?>
	
	<html>
	<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css"/>
    <script src="../js/jquery-ui.js"></script>

    <!-- STRENGTH -->
    <link rel="stylesheet" type="text/css" href="../css/strength.css">
    <script type="text/javascript" src="../js/strength.js"></script>

    <script type="text/javascript">


	$(document).ready(function () {

	jQuery('body').bind('touchmove', function(e){e.preventDefault()});
	});
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">
	<?php
	if($yourbrowser == "1")
	{
	?>
		html { 
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch; 
		}
		body {
		    height: 100%;
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch;

		}
	<?php
	}
	?>
	</style>
	<style type="text/css"> 
 		body{ overflow-y:auto }
	</style>

	<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
	
	</style>
	</head>

	<body>
	<table border="0" width="94%" align="center" style="margin-top:30px; margin-left:35px">
		    <tr>
		    	<td align = "left" width="85%" class="textTitle" style="font-weight:bold; font-size = 15px ;">
					<?php echo dic_("Settings.UserSett")?>
				</td>
				<?php
				if ($_SESSION["role_id"] != "3")
				{
				?>
				<td align = "right" width="15%" class="text5" style="font-weight:bold; font-size = 15px ;">
					<button id="btnAdd" onclick="AddButtonClick()"><?php echo dic("Settings.Add")?></button>
				</td>
				<?php
				}
			?>
		    </tr>
    </table>
  	<br/>
		<table id = "tabelata" width="94%" border="0" cellspacing="2" cellpadding="2" align="center" style="margin-top:30px; margin-left:35px">
		  <tr><td height="22px" class="text2" colspan=7 style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;"><?php echo dic_("Settings.UserSett")?></td></tr>
          <tr>
			 <td width="3%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><?php dic("Fm.Rbr")?></td>
             <td width="50%"  height="22px" align="left" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px;" class="text2"><?php echo dic("Settings.User")?></td>
             <td width="26%"  height="22px" align="left" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px;" class="text2"><?php echo dic("Settings.Role")?></td>
             <td width="7%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php echo dic("Settings.Edit")?></td>
             <?php
			   	 if ($_SESSION["role_id"] != "3")
			   	 {
			 ?>
             <td width="7%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php echo dic("Settings.Vehicles")?></td>
             <td width="7%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php echo dic("Settings.Delete")?></td>
             <td width="7%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php echo dic("Settings.Privileges")?></td>
			 <?php
		  	     }
			 ?>
		</tr>
		<?php 
		if(pg_num_rows($proverka1) == 0)
		{
			echo dic("Settings.ThereAreNoResults");
		}
		else
		{
			$cnt = 1;
			while ($row = pg_fetch_array($proverka1))
			{
		?>
		<tr>
			<td width="3%" id="td-1-<?php echo $cnt?>" width="5%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $cnt?></td>
			<td width="50%" class="text5" style="font-weight:bold; font-size = 15px ; background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px;">
				<div id="usr_<?php echo $row["id"]?>" value="<?php echo $row["id"] ?>" title="<?php echo $row["roleid"]?>"><?php echo $row["fullname"] ?></div>
			</td>
			<td width="26%" class="text5" style="font-weight:bold; font-size = 15px ; background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px;">
				<?php
				if ($row["roleid"] == "1"){
				?><?php echo dic("Settings.Administrator");?>
				<?php
				}
				if ($row["roleid"] == "2"){
				?><?php echo dic("Settings.Administrator"); ?>
				<?php
				}
				if ($row["roleid"] == "3"){
					?><font color="#ff6633"><?php echo dic("Settings.User");?></font>
				<?php
				}
				if ($row["roleid"] == "4"){
					?><font color = "#ff6633"><?php echo "OR_Admin";?></font>
				<?php
				}
				?>
			</td>
			<td width="7%" class="text2" style="text-align: center; font-weight:bold; text-align: center; background-color:#fff; border:1px dotted #B8B8B8;">
				<button id="btnEdit<?php echo $cnt?>" onclick="EditUserClick('<?php echo $row["id"]?>')" style="height:22px; width:30px"></button>
			</td>
			<?php
			if ($_SESSION["role_id"] != "3")
			{
			?>
			<td width="7%" class="text2" style="text-align: center; font-weight:bold; text-align: center; background-color:#fff; border:1px dotted #B8B8B8;">
				<button id="btnVehicles<?php echo $cnt?>" onclick="ShowVehicles('<?php echo $row["id"]?>')" style="height:22px; width:30px"></button>
			</td>
			<td width="7%" class="text2" style="text-align: center; font-weight:bold; text-align: center; background-color:#fff; border:1px dotted #B8B8B8;">
				<button <?php if($row["roleid"] == "1" || $row["roleid"] == "2"){?>disabled="disabled" title= "<?php echo dic("Settings.CannotDelUser")?>"<?php }?> id="btnDelete<?php echo $cnt?>" onclick="DelButtonClick('<?php echo $row["id"]?>')" style="height:22px; width:30px"></button>
			</td>
			<td width="7%" class="text2" style="text-align: center; font-weight:bold; text-align: center; background-color:#fff; border:1px dotted #B8B8B8;">
				<button id="btnprivileges<?php echo $cnt?>" onclick="Privileges('<?php echo $row["id"]?>')" style="height:22px; width:30px"></button>
			</td>
			<?php
			}
			?>
		</tr>
		<script>
			var z = '<?php echo $cnt?>';
			$('#btnEdit' + z).button({ icons: { primary: "ui-icon-pencil"} });
			$('#btnVehicles' + z).button({ icons: { primary: "ui-icon-transferthick-e-w"} });
			$('#btnDelete' + z).button({ icons: { primary: "ui-icon-trash"} });
			$('#btnprivileges' + z).button({ icons: { primary: "ui-icon-key"} });
		</script>
		<?php
			     $cnt = $cnt + 1;
		    }
		}
		?>
		</table>

    <div id="div-vehicles-user" style="display:none" title="<?php echo dic("Settings.Vehicles")?>">
    </div>
    <div id="div-edit-user" style="display:none" title="<?php echo dic("Settings.EditUser")?>">
    </div>
    <div id="div-del-user" style="display:none" title="<?php echo dic("Settings.DelUser")?>">
        <?php echo dic("Settings.DelUser")?>
    </div>
    <div id="div-del-admin" style="display:none" title="<?php echo dic("Settings.DelUser")?>">
        <?php echo dic("Settings.CannotDelUser")?>
    </div>
    <div id="div-add-user" style="display:none" title="<?php echo dic("Settings.AddUser")?>">
        <table align = "center">
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Fm.Name")?></td>
                <td>
                    <input id="ime" type="text" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr>
            <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.LastName")?></td>
            <td>
                <input id="prezime" type="text" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
            </td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.Email")?></td>
                <td>
                    <input id="email2" type="text" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.Phone")?></td>
                <td>
                    <input id="phone2" type="text" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>
                </td>
            </tr>
            <tr>
            	<td>
            	</td>
            	<td>
            	</td>
            </tr>
            <tr>
            	<td>
            	</td>
            	<td>
            	</td>
            </tr>
            <tr>
            <td colspan="2">
            	<div style="border-bottom:1px solid #bebebe"></div>
            </td>
            </tr>
            <tr>
            	<td>
            	</td>
            	<td>
            	</td>
            </tr>
            <tr>
            	<td>
            	</td>
            	<td>
            	</td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.UserName")?></td>
                <td>
                    <input id="korisnicko" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.Password")?></td>
                <td>
                    <input id="password3" type="password" title="<?php echo dic("Settings.PasswordMust")?>." class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.RepeatPasswordOnce")?> <?php echo dic("Settings.Password")?></td>
                <td>
                    <input id="password4" type="password" onChange="checkPasswordMatch1();" title="<?php echo dic("Settings.PasswordMust")?>." class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr id="checkLozinka1" style="display:none;">
            	<td>
            	</td>
            	<td align="left">
            	<div class="registsrationFormAlert" id="divCheckPasswordMatch1"></div>
            	</td>
            </tr>
            <tr>
            	<td>
            		&nbsp;
            	</td>
            	<td>
            		&nbsp;
            	</td>
            </tr>
            <tr>
            	<td>
            	</td>
            	<td align = "right">
            		<font size = "-3" color="red"><?php echo dic("Settings.RequiredInfo")?></font><font color = "red">*</font>
            	</td>
            </tr>
        </table>
      <div align = "right"></div>
    </div>
	<br/>
	<br/>
	<div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	</p>
	</div>
</body>
</html>

	<script>
	function msgboxPetar(msg) {
    $("#DivInfoForAll").css({ display: 'none' });
    $('#div-msgbox').html(msg)
    $("#dialog-message").dialog({
        modal: true,
        zIndex: 9999, resizable: false,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
        	}
        }
    });
	}
	</script>
	
	
	<script>
	function validatePassword() {
		var password1 = $("#password3").val();
   		if (password1.length < 6){
   			 $("#divCheckPasswordMatch1").html("<img src = '../images/stikla3.png' width='10px' height='10px'></img>"+"<font color='#FF0000' size = '2'>&nbsp;"+'<?php echo dic("Settings.NewPasswordDontMatchTwo")?>'+"</font>");

   		}


	}

   function checkPasswordMatch1() {
   var password1 = $("#password3").val();
   var confirmPassword1 = $("#password4").val();
   document.getElementById('divCheckPasswordMatch1').style.display = '';
   document.getElementById('checkLozinka1').style.display = '';
	
   if (password1 != confirmPassword1)
        $("#divCheckPasswordMatch1").html("<img src = '../images/stikla3.png' width='10px' height='10px'></img>"+"<font color='#FF0000' size = '2'>&nbsp;"+'<?php echo dic("Settings.NewPasswordDontMatchTwo")?>'+"</font>");
   else
        $("#divCheckPasswordMatch1").html("<img src = '../images/stikla2.png' width='10px' height='10px'></img>"+"<font color='#04B404' size = '2'>&nbsp;"+'<?php echo dic("Settings.PasswordMatchTwo")?>'+".</font>");
   }
	    $(document).ready(function() {
        $("#password4").keyup(checkPasswordMatch1);
   });
	</script>
	<script>
   top.HideWait();
   $('#btnAdd').button({ icons: { primary: "ui-icon-plus"} });
                    
   $('#vId_<?php echo $row["id"]?>').button({ icons: { primary: "ui-icon-pencil"} });
   $('#vId_<?php echo $row["id"]?>').css({ height: "27px" });
   $('#vId_<?php echo $row["id"]?>').css({ width: "150px" });
   
   $('#usr_<?php echo $row["id"]?>').select;
   document.getElementById('usr_<?php echo $row["id"] ?>');
   document.getElementById('usr_<?php echo $row["id"] ?>');
   
   function Privileges(id) 
   {
       top.ShowWait();
       top.document.getElementById('ifrm-cont').src = "Privileges.php?uid=" + id + "&l=" + lang;
   }
   $(function () 
   {
       $('#btnSave').button({ icons: { primary: "ui-icon-check"} });
   });
</script>
<?php

	closedb();
?>
