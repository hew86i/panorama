<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="../js/mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="../js/mlColorPicker.js"></script>

<script type="text/javascript">
	$(document).ready(
		function changecolor()
    	{
    		$("#Color1").mlColorPicker({ 'onChange': function (val) {
        	$("#Color1").css("background-color", "" + val);
        	$("#FillColor").val("#" + val);
        	$("#menuvanjeBoja").css("background-color", "" + val);
    		}
    	});
    });
</script>
<script>
	function OptionsChange() {
	
	var praznikot = document.getElementById('tipDen').value;

    if (praznikot == "8")
    {
        document.getElementById('tipNaPraznik').style.display = '';
    }
    if(praznikot != "8")
    {
        document.getElementById('tipNaPraznik').style.display = 'none';
	}
	}
</script>
	
	<?php 

	opendb();

	$tipNaKorisnik = query("select * from users where id = ".session("user_id"));
	$korisnikZona = pg_fetch_result($tipNaKorisnik, 0, "datetimeformat");
	
	$datum = str_replace("'", "''", NNull($_GET['Datum'], '')); 
	
	if(strpos($korisnikZona,'m-d-Y') !== false) 
	{
 		$datum2 = DateTimeFormat($datum, 'm-d-Y');
	}
	else 
	{
		$datum2 = DateTimeFormat($datum, 'd-m-Y');
	}
	
	$kojDen = str_replace("'", "''", NNull($_GET['dayOfWeek'], '')); 
	
	?>	
	<style>
	#tipPraznik
	{
	position:absolute;
	top:1px;
	}
	</style>	    	
	<div align = "center">

	<table align = "center" width = "100%" cellpadding="5">
	<!--tr>
	<td align="right" style="font-weight:bold" class ="text2"> <?php echo dic("Settings.DateChooseIs")?> </td><td align="left" style="font-weight:bold" class ="text2"><font color = "red"><span id = "menuvanjeBoja"><?php echo $datum2?></span></font></td>
	</tr-->
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr>
	<td align="right" style="font-weight:bold" class ="text2"><?= dic_("Settings.NameHoliday")?>:</td>
	<td align="left" style="font-weight:bold" class ="text2"><input id = "imePraznik" style="width:195px;height:25px;" class="textboxCalender corner5" type="text"></input></td>
	</tr>
	<!--tr id = "praznikot">
	<td align="right" style="font-weight:bold" class ="text2"><?php echo dic("Settings.EnterThisDateAs")?> : </td> 
	<td align="left" style="font-weight:bold" class ="text2">
	<select id = "tipDen" onchange="OptionsChange()" class="combobox text2">
		<option id = "9" value="9"><?php echo dic("Settings.NonWorkingForCompany")?></option>
		<option id = "8" value="8"><?php echo dic("Settings.Holiday")?></option>
	</select>
	</td>
	</tr-->
	<tr id= "tipNaPraznik" style="display:none;">
	<td align="right" style="font-weight:bold" class ="text2"><?php echo dic("Settings.HolidayIs")?>: </td> 
	<td align="left" style="font-weight:bold" class ="text2">
	<select id = "tipPraznik" style="position:relative; bottom:4px" class="combobox text2">
		<?php
	 	$find6 = query("select * from companydaysholiday where clientid=".session("client_id")."order by nameholiday");
	    while($row6 = pg_fetch_array($find6))
	    {
		$data6[] = ($row6);
		}
		foreach ($data6 as $row6)
		{
		?>
		<option id="<?php echo $row6["id"] ?>" value = "<?php echo $row6["holidayid"] ?>"><?php echo $row6["nameholiday"]?>
		<?php
		}
		?>
	</option>
	</select>&nbsp;
	<button id="dodadi" onclick="dodadiTipPraznik()" style="position:relative; top:5px" ></button>
	</td>
	</tr>
	<!--tr>
	<td align="right" style="font-weight:bold" class ="text2"><?php echo dic("Settings.TheDayIs")?> : </td> 
	<td align="left" style="font-weight:bold" class ="text2">
	<select id = "den" class="combobox text2">
		<option id = "1" value="1" <?php if($kojDen==0){?> selected = "selected" <?php }?>><?php echo dic("Settings.Monday")?></option>	
		<option id = "2"  value="2" <?php if($kojDen==1){?> selected = "selected" <?php }?>><?php echo dic("Settings.Tuesday")?></option>
		<option id = "3" value="3" <?php if($kojDen==2){?> selected = "selected" <?php }?>><?php echo dic("Settings.Wednesday")?></option>	
		<option id = "4"  value="4" <?php if($kojDen==3){?> selected = "selected" <?php }?>><?php echo dic("Settings.Thursday")?></option>
		<option id = "5" value="5" <?php if($kojDen==4){?> selected = "selected" <?php }?>><?php echo dic("Settings.Friday")?></option>	
		<option id = "6"  value="6" <?php if($kojDen==5){?> selected = "selected" <?php }?>><?php echo dic("Settings.Saturday")?></option>
		<option id = "7" value="7" <?php if($kojDen==6){?> selected = "selected" <?php }?>><?php echo dic("Settings.Sunday")?></option>	
	</select>
	</tr-->
	<tr>
	<td align="right" style="font-weight:bold" class ="text2"><?= dic_("Settings.Color")?>: </td>
	<td align="left" style="font-weight:bold" class ="text2">
	
	<div id="Color">
		<span id="Color1" style="cursor: pointer; float:left; border:1px solid black; width:15px; height:15px;margin-top:3px;margin-right:5px;" ></span>
		<input id="FillColor" type="text" class="textboxCalender corner5"  onclick="" value="#ffffff" style="width:171px; height:25px; border:0px"  />
	</div>
	</td> 
	</tr>
	</table>
	</div>	
	<div id="div-tip-praznik" style="display:none" title="<?php echo dic("Settings.AddingTypeHoliday")?>" ><br>
	<br><br><br>
	
	<table align = "center" width = "100%">
	<tr>
	<td style="font-weight:bold" class ="text2" width="50%" align = "right"><?php echo dic("Settings.EnterNameHolidayType")?>: </td>
	<td style="font-weight:bold" class ="text2" width="50%" align = "left">
		
		<input id= "dodTipPraznik" type="text" size="32"></input>
    
    </td>
    </tr>
    </table>
    </div>
    
	<div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	 </p>
	</div>
	
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

	$('#dodadi').button({ icons: { primary: "ui-icon-plus"} });
	document.getElementById('dodadi').style.height = "25px";
    document.getElementById('dodadi').style.width = "30px";
    document.getElementById('div-add-day').title = '<?= dic_("Settings.AddNonWorkingDay")?>: <?= $datum?>';
    
	function dodadiTipPraznik(){
	document.getElementById('div-tip-praznik').title = dic("Settings.AddingTypeHoliday")
    $('#div-tip-praznik').dialog({ modal: true, width: 400, height: 250, resizable: false,
                  buttons: 
                  [
                  {
                	text:dic("Tracking.Add"),
				    click: function() {
				    	
				    	tipPraznik = $('#dodTipPraznik').val()
				    	tipPraznikID = document.getElementById("dodTipPraznik");
				    	
				    	if(tipPraznik=="")
				    	{
				    		msgboxPetar(dic("Settings.EnterNameForHoliday", lang))
				    		tipPraznikID.focus();
				    	}
				    	else
                        {   
                            $.ajax({
		                        url: "InsertTypeHoliday.php?tipPraznik="+tipPraznik+"&l="+lang,
		                        context: document.body,
		                        success: function(data){
		                        msgboxPetar(dic("Settings.SuccAdd",lang));
		                      	location.reload();
		                      }
		                    });	
		         		  $( this ).dialog( "close" );
                        }
                      }
				    },
				    {
				    	text:dic("Fm.Cancel",lang),
                    	click: function() {
					    $( this ).dialog( "close" );
				    }
                }
            ]
   		})
   	}
</script>

<?php
	closedb();
?>

