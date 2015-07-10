<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<link rel="stylesheet" href="../js/mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="../js/mlColorPicker.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../style.css">

	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery-ui.js"></script>
	<style>
	.ui-datepicker-trigger { position:relative; top:5px ; padding-left:3px; height:19px ; width:20px}
	</style>
	<style type="text/css"> 
    	body{ overflow-y:auto;}
 	    body{ overflow-x:auto;}
    </style>
	<script type="text/javascript">
	$(document).ready(
		function changecolor()
    	{
    		$("#Color1").mlColorPicker({ 'onChange': function (val) {
        	$("#Color1").css("background-color", "" + val);
        	$("#FillColor").val("#" + val);
        	$("#datumot").css("background-color", "" + val);
    		}
    	});
    });
	</script>
	<script>
	
	
		function OptionsChange() {
		
		/*var praznikot = document.getElementById('tipDen').value;
	
	    if (praznikot == "8")
	    {
	        //document.getElementById('tipNaPraznik').style.display = '';
	    }
	    if(praznikot != "8")
	    {
	        //document.getElementById('tipNaPraznik').style.display = 'none';
		}*/
		}
		
		$(document).ready(function () {
			OptionsChange();
		});
		
		
	</script>

	<script>
		
		$('#datumot').datepicker({
		firstDay: 1,
    	dateFormat: 'yy-mm-dd',
        hourGrid: 4,
        minuteGrid: 10,
        numberOfMonths: 1,
        showButtonPanel: true,
        showOn: "button",
		buttonImage: "../images/cal.png",
		buttonImageOnly: true,
    });
    
	</script>
	
	<?php 

	opendb();

		$tipNaKorisnik = query("select * from users where id = ".session("user_id"));
		$korisnikZona = pg_fetch_result($tipNaKorisnik, 0, "datetimeformat");
	
		$denID = str_replace("'", "''", NNull($_GET['id'], '')); 
		$informaciiDen = query("select * from companydays where id = ".$denID." and clientid = " . Session("client_id"));
		$imePraznik = pg_fetch_result($informaciiDen, "dayname");
		$tipDen = pg_fetch_result($informaciiDen, "companyholiday");
		$tipPraznik = pg_fetch_result($informaciiDen, "typeofholiday");
		$imePraznik = pg_fetch_result($informaciiDen, "dayname"); 
		$denOdNedela = pg_fetch_result($informaciiDen, "typeofday"); 
		$bojaKvadrat= pg_fetch_result($informaciiDen, "cellcolor"); 
		$bojata = substr($bojaKvadrat, 1);
		$datum= pg_fetch_result($informaciiDen, "datum");
		
		if(strpos($korisnikZona,'m-d-Y') !== false) 
		{
			$datum2 = DateTimeFormat($datum, 'm-d-Y');
		}
		else 
		{
			$datum2 = DateTimeFormat($datum, 'd-m-Y');
		}
		
		
	?>
	<body <?php if($tipDen==8) {?> onload="OdStart()" <?php }?>>
	<div align = "center">
		
	<table align = "center" width = "100%" cellpadding="5">
		<tr height="30px"><td></td><td></td></tr>
	<!--tr>
	<td align="right" style="font-weight:bold" class ="text2"><?php echo dic("Settings.DateChooseIs")?> : </td><td align="left" style="font-weight:bold" class ="text2"><input type="text" id="datumot" style="width: 195px;" class="textboxCalender corner5"  value="<?php echo $datum2?>" /></input></td>
	</tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr-->
	<tr>
	<td align="right" style="font-weight:bold" class ="text2"><?= dic_("Settings.NameHoliday")?>:</td>
	<td align="left" style="font-weight:bold" class ="text2"> <input id = "imePraznik" class="textboxCalender corner5" style="width: 195px;" type="text" value="<?php echo $imePraznik;?>"></input></td>
	</tr>
	<!--tr id = "praznikot">
	<td align="right" style="font-weight:bold" class ="text2"><?php echo dic("Settings.EnterThisDateAs")?>: </td> 
	<td align="left" style="font-weight:bold" class ="text2">
	<select id = "tipDen" onchange="OptionsChange()" class="combobox text2">
		<option id = "9"  value="9" <?php if($tipDen==9) {?>selected = "selected" <?php }?> ><?php echo dic("Settings.NonWorkingForCompany")?></option>
		<option id = "8"  value="8" <?php if($tipDen==8) {?> selected = "selected" <?php }?> ><?php echo dic("Settings.Holiday")?></option>
	</select>
	</td>
	</tr-->
	<tr id= "tipNaPraznik" style="display:none;">
	<td align="right" style="font-weight:bold" class ="text2"><?php echo dic("Settings.HolidayIs")?> : </td> 
	<td align="left" style="font-weight:bold" class ="text2">
	<select id = "tipPraznik" class="combobox text2">
		<?php
	 	$find6 = query("select * from companydaysholiday where clientid=".session("client_id")."order by nameholiday");
	    while($row6 = pg_fetch_array($find6)){
		$data6[] = ($row6);
		}
		foreach ($data6 as $row6){
		?>
		<option id="<?php echo $row6["id"] ?>" <?php if ($row6["holidayid"] == $tipPraznik) {?>  selected = "selected" <?php } ?> value = "<?php echo $row6["holidayid"] ?>"><?php echo $row6["nameholiday"]?>
		<?php
		}
		?>
		</option>
	</select>
	</td>
	</tr>
	<!--tr>
	<td align="right" style="font-weight:bold" class ="text2"><?php echo dic("Settings.TheDayIs")?> : </td> 
	<td align="left" style="font-weight:bold" class ="text2">
	<select id = "den" class="combobox text2">
		<option id = "1" value="1" <?php if($denOdNedela==1){?> selected = "selected" <?php }?>><?php echo dic("Settings.Monday")?></option>	
		<option id = "2"  value="2" <?php if($denOdNedela==2){?> selected = "selected" <?php }?>><?php echo dic("Settings.Tuesday")?></option>
		<option id = "3" value="3" <?php if($denOdNedela==3){?> selected = "selected" <?php }?>><?php echo dic("Settings.Wednesday")?></option>	
		<option id = "4"  value="4" <?php if($denOdNedela==4){?> selected = "selected" <?php }?>><?php echo dic("Settings.Thursday")?></option>
		<option id = "5" value="5" <?php if($denOdNedela==5){?> selected = "selected" <?php }?>><?php echo dic("Settings.Friday")?></option>	
		<option id = "6"  value="6" <?php if($denOdNedela==6){?> selected = "selected" <?php }?>><?php echo dic("Settings.Saturday")?></option>
		<option id = "7" value="7" <?php if($denOdNedela==7){?> selected = "selected" <?php }?>><?php echo dic("Settings.Sunday")?></option>	
	</select>
	</tr-->
	<tr>
	<td align="right" style="font-weight:bold" class ="text2"><?= dic_("Settings.Color")?>: </td>
	<td align="left" style="font-weight:bold" class ="text2">
	
	<div id="Color">
		<span id="Color1" style="cursor: pointer; float:left; border:1px solid black; width:15px; height:15px;margin-top:3px;margin-right:5px; background-color:<?=$bojata?>" ></span>
		<input id="FillColor" type="text" class="textboxCalender corner5"  onclick="" value="#<?php echo $bojata;?>" style="width:171px;height:25px;border:0px" />
	</div>
	</td> 
	</tr>
	</table>
	</div>
	
	<script>
		document.getElementById('div-edit-day').title = '<?= dic_("Settings.ChangeNonWorkingDay")?>: <?= $datum2?>';
	</script>
	<?php
	closedb();
?>	