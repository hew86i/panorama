<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
lang = '<?php echo $cLang?>';
</script>
</head>

<?php

    $id = str_replace("'", "''", NNull($_GET['id'], ''));
    opendb();
	$dsedit = query("select * from users where id=" . $id . " and clientid = " . Session("client_id"));

?>
<body>
		<table align="center">
			<tr>
            <td>
            	<button id = "promeniLozOTVORI" onclick="lozinkaPokazi()" style="width: 150px;height: 25px"><font style="font-size: 10px"><?php echo dic("Settings.ChangePassword")?></font></button>
            	<button id = "promeniLozZATVORI" style="display:none;" onclick="lozinkaZatvori()" style="width: 150px;height: 25px"><font style="font-size: 10px"><?php echo dic("Settings.DontChangePassword")?></font></button>
            </td>
            <td align = "right">
            	<font size = "-3" color="red"><?php echo dic("Settings.RequiredInfo")?></font><font color = "red">*</font>
            </td>
            </tr>
            <tr>
            	<td>&nbsp;</td><td>&nbsp;</td>
            </tr>
            <?php
			$pronajdi = query("select * from users where id = " . $id);
			$pronajdi1 = pg_result($pronajdi,"fullname");
			$name = strstr($pronajdi1, ' ', true);
			$lastname1 = strstr($pronajdi1, ' ');
			$lastname = trim($lastname1);
            ?>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Fm.Name")?></td>
                <td>
                     <input id="CEName" type="text" value="<?php echo $name?>" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.LastName")?></td>
                <td>
                    <input id="CELastName" type="text"  value="<?php echo trim($lastname)?>" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.Email")?></td>
                <td>
                    <input id="CEEmail"  value="<?php echo pg_fetch_result($dsedit,0,"email")?>" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.Phone")?></td>
                <td>
                    <input id="CEPhone"  value="<?php echo pg_fetch_result($dsedit,0,"phone")?>" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>
                </td>
            </tr>
            <tr>
            	<td></td><td></td>
            </tr><tr>
            	<td></td><td></td>
            </tr>
            <tr>
            <td colspan="2">
            	<div style="border-bottom:1px solid #bebebe"></div>
            </td>
            </tr>
             <tr>
            	<td></td><td></td>
            </tr><tr>
            	<td></td><td></td>
            </tr>	
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.UserName")?></td>
                <td>
                    <input id="CEUserName" value="<?php echo pg_fetch_result($dsedit,0,"username")?>"  class="textboxcalender corner5 text5"  data-indicator="pwindicator" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.Password")?></td>
                <td>
                     <input id="PasswordStar" readonly="readonly" title="<?php echo dic("Settings.PasswordMust")?>." type="password" value="<?php echo pg_fetch_result($dsedit,0,"password")?>" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font>
                </td>
            </tr>
            <tr>
            	<td></td><td></td>
            </tr>
            <tr>
            	<td></td><td></td>
            </tr>
            <tr>
            <td colspan="2">
            	<div style="border-bottom:1px solid #bebebe"></div>
            </td>
            </tr>
            <tr>
            	<td>    
            	<input id="pomosno" value = "1" style="display:none;"/>
                </td><td></td>
            </tr>
            <tr>
            	<td></td><td></td>
            </tr>
            <tr id="lozinka1" style="display:none;">
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.PasswordNewPasswordNew")?> <?php echo dic("Settings.Password")?></td>
                <td>
                <div class="td"><input type="password" id="txtNewPassword" title="<?php echo dic("Settings.PasswordMust")?>"class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font></div>
                </td>
            </tr>
            <tr id="lozinka2" style="display:none;">
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php echo dic("Settings.RepeatPasswordOnce")?> <?php echo dic("Settings.Password")?></td>
                <td>
                <div class="td"><input type="password" id="txtConfirmPassword" onChange="checkPasswordMatch();" title="<?php echo dic("Settings.PasswordMust")?>." class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>&nbsp;<font color = "red">*</font></div>
                </td>

            <!-- AREA FOR STRENGTH PLUGIN -->
            <!-- ================================================= -->
            <tr class="strClass">
                <td class="text5"></td>
                <td class="td" id="insertionAfter"></td>
            </tr>


            <tr id="checkLozinka" style="display:none;">
                <td>
                </td>
                <td align="left">
                <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
                </td>
            </tr>
            <tr>
            	<td></td><td></td>
            </tr>
            <tr>
            <td id = "granicnik" colspan="2" style="display:none;">
            	<div style="border-bottom:1px solid #bebebe"></div>
            </td>
            </tr>
        </table>
</body>
        <script type="text/javascript">
            $(document).ready(function ($) {

                $("#txtNewPassword").strength({
                    strengthClass: 'strength',
                    strengthMeterClass: 'strength_meter',
                    strengthButtonClass: '',
                    strengthButtonText: '',
                    strengthButtonTextToggle: '',
                    strengthClassDisplay: 'strClass'
        });

            });
        </script>


        <script>
        $('#promeniLozOTVORI').button({ icons: { primary: "ui-icon-unlocked"} });
        $('#promeniLozZATVORI').button({ icons: { primary: "ui-icon-locked"} });
        </script>
        
        <script>
        $('#promeniLozOTVORI, #promeniLozZATVORI').click(function () {
		    if (this.id == 'promeniLozOTVORI') {
		        document.getElementById('pomosno').value = 2;
		    }
		    else if (this.id == 'promeniLozZATVORI') {
		        document.getElementById('pomosno').value = 1;
		    }
		});
        </script>
		
		<script>
		function lozinkaPokazi()
		{
		document.getElementById('promeniLozOTVORI').style.display = 'none';
	    document.getElementById('lozinka1').style.display = '';
	    document.getElementById('lozinka2').style.display = '';
	    document.getElementById('promeniLozZATVORI').style.display = '';
	    document.getElementById('divCheckPasswordMatch').style.display = '';
	    document.getElementById('checkLozinka').style.display = '';
	    document.getElementById('granicnik').style.display = '';
	    }
		</script>
		<script>
		function lozinkaZatvori()
		{
		document.getElementById('promeniLozOTVORI').style.display = ''; 
	    document.getElementById('lozinka1').style.display = 'none';
	    document.getElementById('lozinka2').style.display = 'none'; 
	    document.getElementById('promeniLozZATVORI').style.display = 'none';
	    document.getElementById('divCheckPasswordMatch').style.display = 'none';
	    document.getElementById('checkLozinka').style.display = 'none';
	    document.getElementById('granicnik').style.display = 'none';
	    }
		</script>
		<script>
        function checkPasswordMatch() {
	    var password = $("#txtNewPassword").val();
	    var confirmPassword = $("#txtConfirmPassword").val();
	
	    if (password != confirmPassword)
	        $("#divCheckPasswordMatch").html("<img src = '../images/stikla3.png' width='10px' height='10px'></img>"+"<font color='#FF0000' size = '2'>&nbsp;"+'<?php echo dic("Settings.NewPasswordDontMatchTwo")?>'+"!</font>");
	    else
	        $("#divCheckPasswordMatch").html("<img src = '../images/stikla2.png' width='10px' height='10px'></img>"+"<font color='#04B404' size = '2'>&nbsp;"+'<?php echo dic("Settings.PasswordMatchTwo")?>'+".</font>");
		}
		$(document).ready(function () {
		   $("#txtConfirmPassword").keyup(checkPasswordMatch);
            

		});
        </script>
     
        



	
<?php
	closedb();
?>
