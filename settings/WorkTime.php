<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php opendb();?>

	<?php 
	header("Content-type: text/html; charset=utf-8");
	opendb();
	$Allow = getPriv("employees", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
	addlog(45);
	?>
	<html>
	<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css"> 
		.menuTable { display:none; width:200px; } 
	</style>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	
	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery-ui.js"></script>
	<style type="text/css">
	
	<?php
	if($yourbrowser == "1")
	{?>
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
	<style>
	    .ui-button { margin-left: -1px;}
		.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
		.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
	</style>
	
	<style>
	.ui-datepicker-next,.ui-datepicker-prev,.ui-datepicker-today {display:block;}
	.ui-datepicker-week-end a {
		   color: red !important;
		   font-weight:bold !important;
		   font-size: 8pt;
	}
	</style>
	
	<script>
	function msgboxPetar(msg) {
	    $("#DivInfoForAll").css({ display: 'none' });
	    $('#div-msgbox').html(msg)
	    $("#dialog-message").dialog({
	        modal: true, width: 370, height: 220, 
	        zIndex: 9999, resizable: false,
	        buttons: {
	            Ok: function () {
	                $(this).dialog("close");
	        	}
	        }
	    });
	}
	</script>	
	
	<?php 
	
	$daysArr = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
	
	$tipNaKorisnik = query("select * from users where id = ".session("user_id"));
	$tipKorisnik = pg_fetch_result($tipNaKorisnik, 0, "roleid");
	$korisnikZona = pg_fetch_result($tipNaKorisnik, 0, "datetimeformat");
	
	?>
	<script>
	$(document).ready(function() {
		
    var SelectedDates = {};
    var SeletedText = {};
    var SelectedBoicka = [];
    
    <?php 
    $Denovite = query("select * from companydays where clientid = " .Session("client_id"). " order by datum");
	$count=1;
	while($izbrojGi = pg_fetch_array($Denovite))
	{
		 $datum = DateTimeFormat($izbrojGi['datum'], 'm/d/Y');
		 $ImeNaDen = $izbrojGi["dayname"];
		 $bojaKvadrat = $izbrojGi["cellcolor"];
	?>
		 var datumce = '<?php echo $datum?>';
		 SelectedDates[new Date(datumce)] = new Date(datumce);
		 var ImeNaDen = '<?php echo $ImeNaDen ?>';
		 SeletedText[new Date(datumce)] = ImeNaDen;
		 var boja = '<?php echo $bojaKvadrat ?>';
		 SelectedBoicka['<?php echo $count?>'] = boja + '@' + datumce;
	
	<?php
	$count++;
	}
    ?>
 
	var tipKorisnik = '<?php echo $tipKorisnik?>';
    
    // AKO E ADMINISTRATOR
    
    if(tipKorisnik=="2")
	{
	
	var today = new Date();
	
	$('#txtDate2').datepicker({
    	dateFormat: 'dd-mm-yy',
    	firstDay: 1,
        numberOfMonths:  [3, 4],
        showCurrentAtPos: today.getMonth(),
        monthNames: ['<?= dic_("Reports.January")?>', '<?= dic_("Reports.February")?>', '<?= dic_("Reports.March")?>', '<?= dic_("Reports.April")?>', '<?= dic_("Reports.May")?>', '<?= dic_("Reports.June")?>', '<?= dic_("Reports.July")?>', '<?= dic_("Reports.August")?>', '<?= dic_("Reports.September")?>', '<?= dic_("Reports.October")?>', '<?= dic_("Reports.November")?>', '<?= dic_("Reports.December")?>'],
   		monthNamesShort: ['<?= dic_("Reports.January1")?>', '<?= dic_("Reports.February1")?>', '<?= dic_("Reports.March1")?>', '<?= dic_("Reports.April1")?>', '<?= dic_("Reports.May1")?>', '<?= dic_("Reports.June1")?>', '<?= dic_("Reports.July1")?>', '<?= dic_("Reports.August1")?>', '<?= dic_("Reports.September1")?>', '<?= dic_("Reports.October1")?>', '<?= dic_("Reports.November1")?>', '<?= dic_("Reports.December1")?>'],
    	dayNames: ['<?= dic_("Reports.Sunday")?>', '<?= dic_("Reports.Monday")?>', '<?= dic_("Reports.Tuesday")?>', '<?= dic_("Reports.Wednesday")?>', '<?= dic_("Reports.Thursday")?>', '<?= dic_("Reports.Friday")?>', '<?= dic_("Reports.Saturday")?>'],
    	dayNamesShort: ['<?= mb_substr(dic_("Reports.Sunday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Monday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Tuesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Wednesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Thursday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Friday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Saturday"), 0, 2, 'UTF-8')?>'],
  		dayNamesMin: ['<?= mb_substr(dic_("Reports.Sunday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Monday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Tuesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Wednesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Thursday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Friday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Saturday"), 0, 2, 'UTF-8')?>'],
        
        //hideIfNoPrevNext: true,
        //showButtonPanel: true,
        onSelect: 
        function dodadiDen(event, ui){
		var Datum = $('#txtDate2').val();
		var date = $(this).datepicker('getDate');
    	var dayOfWeek = date.getUTCDay();
    	
    	ShowWait()
    	
    	
    	$.ajax({
		url: "CheckInsertDay.php?Datum="+Datum+"&l="+lang,
		context: document.body,
		success: function(data){
		
		if(data == 1)
        {	
        	 msgboxPetar(dic("Settings.CantAddThisDay",lang));
       		 HideWait()
       		 top.document.getElementById('ifrm-cont').src = "listaNerabotni.php?l=" + '<?php echo $cLang ?>';
       	}
        else
    	{
    	
    	$.ajax({
	    url: "SpecialWorkDays.php?Datum="+Datum+"&l="+lang+"&dayOfWeek="+dayOfWeek,
	    context: document.body,
	    success: function(data){
                HideWait()
			    $('#div-add-day').html(data)
                $('#div-add-day').dialog({ modal: true, width: 470, height: 270, resizable: false,
                     buttons: 
                     [
                     {
                     text:dic("Settings.Add",lang),
				     click: function(){
                             		var imePraznik = $('#imePraznik').val();
                             		var boja = $('#FillColor').val();
                             		boja = boja.replace("#", "");
                             		var tipDen = 9;//document.getElementById("tipDen").value
                             		var den = 0;//document.getElementById("den").value  
                             		var tipPraznik = 0;//document.getElementById("tipPraznik").value
                             		var imePraznikID = 0;//document.getElementById("imePraznik");
                             		var bojaFokus = document.getElementById("FillColor");
                             		
                             		if(imePraznik == '')
                             		{
                             		    msgboxPetar(dic("Settings.DayNameEnter", lang))
                             			imePraznikID.focus();
                             		}
                             		else
                             		{
                             		    if(boja=='')
				                        {
				                            msgboxPetar(dic("Settings.ChooseColor", lang))
				                            bojaFokus.focus();
				                        }
				                    else
				                    {
                             		$.ajax({
		                            url: "InsertSpecialWorkDays.php?Datum="+Datum+"&imePraznik="+imePraznik+"&tipDen="+tipDen+"&den="+den+"&boja="+boja+"&tipPraznik="+tipPraznik,
		                            context: document.body,
		                            success: function(data){
		                            	msgboxPetar(dic('Settings.AddRecache'), lang);
		                            	setTimeout(function(){
		                            		window.location.reload();
		                            		$.ajax({
					                            url: "cachereports_sett.php?date="+Datum+"&cid="+'<?= session("client_id")?>',
					                            context: document.body,
					                            success: function(data){}
			                          	 	});
		                            	}, 3000);
		                            }
		                          	  });	
                                    }
                                  }
                               }
                            },
                        {
                        	text:dic("cancel",lang),
                        click: function() {
					        window.location.reload();
					        $( this ).dialog( "close" );
					    },
                      }       
                    ]
                 });
			    }
		      });
		     }
		   }
		 });
	    }
	    ,
   		
   		beforeShowDay: function(date) {
           var Highlight = SelectedDates[date];
           var HighlighText = SeletedText[date];
           //var HighlighBoja = SelectedBoicka[date];
		   if (Highlight)
		   {
	      		return [true, '', HighlighText];
		   }
	       else 
	       {
	       		return [true, '', ''];
	       }
         }
      });
   }
   // AKO E USER
   else
   {
      	var today = new Date();
      	
      	$('#txtDate2').datepicker({
      		
      	dateFormat: 'dd-mm-yy',
        numberOfMonths:  [3, 4],
        firstDay: 1,
        showCurrentAtPos: today.getMonth(),
        monthNames: ['<?= dic_("Reports.January")?>', '<?= dic_("Reports.February")?>', '<?= dic_("Reports.March")?>', '<?= dic_("Reports.April")?>', '<?= dic_("Reports.May")?>', '<?= dic_("Reports.June")?>', '<?= dic_("Reports.July")?>', '<?= dic_("Reports.August")?>', '<?= dic_("Reports.September")?>', '<?= dic_("Reports.October")?>', '<?= dic_("Reports.November")?>', '<?= dic_("Reports.December")?>'],
   		monthNamesShort: ['<?= dic_("Reports.January1")?>', '<?= dic_("Reports.February1")?>', '<?= dic_("Reports.March1")?>', '<?= dic_("Reports.April1")?>', '<?= dic_("Reports.May1")?>', '<?= dic_("Reports.June1")?>', '<?= dic_("Reports.July1")?>', '<?= dic_("Reports.August1")?>', '<?= dic_("Reports.September1")?>', '<?= dic_("Reports.October1")?>', '<?= dic_("Reports.November1")?>', '<?= dic_("Reports.December1")?>'],
    	dayNames: ['<?= dic_("Reports.Sunday")?>', '<?= dic_("Reports.Monday")?>', '<?= dic_("Reports.Tuesday")?>', '<?= dic_("Reports.Wednesday")?>', '<?= dic_("Reports.Thursday")?>', '<?= dic_("Reports.Friday")?>', '<?= dic_("Reports.Saturday")?>'],
    	dayNamesShort: ['<?= mb_substr(dic_("Reports.Sunday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Monday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Tuesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Wednesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Thursday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Friday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Saturday"), 0, 2, 'UTF-8')?>'],
  		dayNamesMin: ['<?= mb_substr(dic_("Reports.Sunday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Monday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Tuesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Wednesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Thursday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Friday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Saturday"), 0, 2, 'UTF-8')?>'],
        //hideIfNoPrevNext: true,
        //showButtonPanel: true,
        hourGrid: 4,
        minuteGrid: 10,
  
    	beforeShowDay: function(date) {
           var Highlight = SelectedDates[date];
           var HighlighText = SeletedText[date];
           //var HighlighBoja = SelectedBoicka[date];
		   if (Highlight)
		   {
	      		return [true, '', HighlighText];
		   }
	       else
	       {
	       		return [true, '', ''];
	       }
		 }
       });
     }
     
 	//debugger;
 	
    //ColorDay(6,30,2013,"yellow");
	for(var j = 1; j < SelectedBoicka.length; j++)
	{
		//SelectedBoicka[j].split("@")[1].split("/")
		ColorDay(parseInt(SelectedBoicka[j].split("@")[1].split("/")[0], 10)-1,parseInt(SelectedBoicka[j].split("@")[1].split("/")[1], 10),parseInt(SelectedBoicka[j].split("@")[1].split("/")[2], 10), SelectedBoicka[j].split("@")[0]);
	}
	});
	function listaNerabotni()
	{
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "listaNerabotni.php?l=" + lang;
    }
	function ColorDay(month, day, year, backgroundColor)
	{
	    day--;
	    $("[onclick*='"+month+","+year+"'] [class*=ui-state-default]").eq(day).css("background",backgroundColor); 
	}

	</script>
	<?php 
	$i = 1;
	$Denovite2 = query("select * from companydays where clientid =" .Session("client_id"). " order by datum");
	while($izbrojGi2 = pg_fetch_array($Denovite2))
	{
		 $bojaKvadrat2 = $izbrojGi2["cellcolor"];
		 $datum2 = DateTimeFormat($izbrojGi2['datum'], 'm/d/Y');
		 $idRed = $izbrojGi2["id"];
	?>
	<style type="text/css"> 
    .HighlighBoja a
    {
		   background-color : <?php echo $izbrojGi2["cellcolor"];?> !important;
		   background-image :none !important;
		   color: white !important;
		   font-weight:bold !important;
		   font-size: 8pt;
	}
	</style>
	<?php
	$i++;
	}
	?>
	<style type="text/css"> 
		body{ overflow-y:auto;}
 	    body{ overflow-x:auto;}
    </style>
    
	</head>
	<body>
	<table width="100%">
	<tr>
	<td align = "left" width="100%">
	<div class="textTitle" style="padding-left:<?php if($yourbrowser == "1") { echo '35px'; } else { echo '35px'; } ?>; padding-top:30px;"><?php echo dic("Settings.NonWorkingDays")?><br />
	</div>
	</td>
	</tr>
	</table>
	<?php 
	$prikazi = query("SELECT * FROM worktime where clientid =" . Session("client_id"));
	?>
	<div align = "left">
 		
 		<table border="0" cellspacing = "2" cellpadding = "2" style="margin-top:30px; margin-left:35px">
		<tr>
		<td align = "center" valign="middle">
		<div align = "middle" id="txtDate2">
		</div>
		<div>
	    <!--<img src = "../images/redsquare.png" width="20px" height="20px" style="padding-top: 5px"></img>-->
		
		<?php 
		if($tipKorisnik==2 || $tipKorisnik==1)
		{
		?>
		<br>
		<img style="float:left" src="../images/infocircle.png" onmousemove="ShowPopup(event, '<?php echo dic("Settings.WorkDaysInfoAdmin")?>')" onmouseout="HidePopup()" style=""></img>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		<?php
		$countryName = dlookup("select name from countries where id = (select countryid from cities where id = (select cityid from clients where id = " . session("client_id") . "))");
		$firstDayCurrentYear = DateTimeFormat(now(), 'Y') . '-01-01';
		
			if($countryName == 'Македонија') {
				$cntCompanyDays = dlookup("select count(*) from companydays where clientid=".session("client_id")." and companyholiday=8 and typeofholiday=1 and datum >= '".$firstDayCurrentYear."'");
				$cntNonWorkingDays = dlookup("select count(*) from nonworkingdays where active='1'");
				if ($cntCompanyDays < $cntNonWorkingDays) {
			?>
			<button id="downloadHolidays" onclick="downloadHolidays(1)" style="float:right"><?= dic_("Settings.DownloadHolidays")?></button>&nbsp;
			<!--button id="listaNerab" onclick="listaNerabotni()" style="margin-left:1px"><?php echo dic("Settigns.DaysAddedAdmin")?></button>&nbsp;-->
			<!--<button id="nerab" onclick="NerabotniDenovi()" style="margin-left:1px"><?php echo dic("Settings.ListOfNonWorkingDays")?></button>--> 
			<?php 
				} else {
					?>
					<button id="removeHolidays" onclick="downloadHolidays(0)" style="float:right; cursor:pointer;"><?= dic_("Settings.RemoveHolidays")?></button>&nbsp;
					<?php
				}
			}
		}
		else
		{
		?>
		<br>
		<img style="float:left" src="../images/infocircle.png" onmousemove="ShowPopup(event, '<?php echo dic("Settings.WorkDaysInfoUser")?>')" onmouseout="HidePopup()" style=""></img>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<!--<button id="nerab" onclick="NerabotniDenovi()" style="margin-left:1px"><?php echo dic("Settings.ListOfNonWorkingDays")?></button>-->
		<?php
		}
		?>
		</div>
		</td>
		</tr>
		<tr>
		<td align = "left" valign="middle">
		<br>
		<table width="100%">
		<tr>
			<td ><div style="border-bottom:1px solid #bebebe"></div><br></td>	
		</tr>
		<tr>
		<td align = "left" width="100%">
		<div class="textTitle" style="text-align:left; width: 69%"><?php echo dic("Settings.WorkTime")?>
		<button id="addBtn2" onclick="AddButton()" style="margin-left:1px; float:right"><?php dic("Tracking.Add")?></button>
		</div>
		</td>
		</tr>
		</table>
				
		<div id="noData" align = "center" style="font-size:10px; font-style:italic;font-style:bold;" class="text4">
 		</div>
		</td>
		</tr>
	
		</table>
		</div>
		<?php
		$cnt = 1;
		$i = 1;
		$poi = query("select * from worktime where clientid = " . Session("client_id"). " order by daytype asc, shift asc");
		if(pg_num_rows($poi)==0){
			?>
			<br><br>
			<div id="noData" style="padding-left:40px; font-size:30px; font-style:italic; padding-bottom:40px" class="text4">
	 		<?php dic("Reports.NoData1")?>
			</div>
			<?php
		} else {
		?>
		
		<div align = "left">
	    <table width="40%" border="0" cellspacing = "2" cellpadding = "2" style="margin-top:30px; margin-left:35px">
		<tr>
			<td align = "left" valign = "middle" colspan="9" height="22px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" > <?php echo dic("Settings.WorkTime")?></td>
		</tr>
		<tr>
		<td align = "left" width="46%" height="25px" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Shift")?></td>
		<td align = "center" width="26%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Reports.From")?> - <?php dic("Reports.To")?></td>
		<td align = "center" width="14%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Change")?></td> 
		<td align = "center" width="14%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Tracking.Delete")?></td>
		</tr>
		
		<?php	
		while ($row1 = pg_fetch_array($poi))
 		{
 			$data[] = ($row1);
		}
		
		$lastDay = "";
		foreach ($data as $row1)
		{
		?>
		
		<tr>
			<td align = "left" height="30px" class="text2" style="padding-left:10px;background-color:#fff; border:1px dotted #B8B8B8;">
			<table width="100%" class="text2">
				<tr>
					<td width="50%" style="font-weight: bold">
						 <?php 
			 if ($lastDay == "" or $row1["daytype"] <> $lastDay) {
			 	if ($row1["daytype"] == "8"){
					echo dic_("Settings.Holiday") . ":";
				} else {
					echo dic_("Settings." . $daysArr[$row1["daytype"]-1]) . ":";
				}
			 } else {
			 	echo "&nbsp;";
			 }
		?>
					</td>
					<td width="50%">
						<?php echo $row1['shift'] . " (".dic_("Settings." . $row1['shift']).")" ?>
					</td>
				</tr>
			</table>
			
		</td>
			
		<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
			<?php 
			if(strpos($korisnikZona,'h:i:s A') !== false) 
			{
				echo DATE("g:i A", STRTOTIME($row1['timefrom'])) . " - " . DATE("g:i A", STRTOTIME($row1['timeto']));
			}
			else 
			{
				echo $row1['timefrom'] . " - " . $row1['timeto'];
			}
			?>

		</td>
						
		<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
			<button id="btnEdit<?php echo $cnt?>"  onclick="EditTimeClick(<?php echo $row1["id"]?>)" style="height:22px; width:30px"></button>
		</td>
		<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
			<button id="DelBtn<?php echo $cnt?>"  onclick="DeleteButtonClick(<?php echo $row1["id"]?>, '<?php echo $row1['timefrom']?>', '<?php echo $row1['timeto']?>', '<?php echo $row1["daytype"]?>')" style="height:22px; width:30px"></button>
		</td>
		</tr>
		<script>
		var i = <?php echo $cnt?>;
		$('#btnEdit' + i).button({ icons: { primary: "ui-icon-pencil"} });
		$('#DelBtn' + i).button({ icons: { primary: "ui-icon-trash"} });
		</script>
		<?php
			$cnt++;
			$lastDay = $row1["daytype"];
		}
		}
		?>
		</table>
		</div>
	    <br>
	    
		<div id="div-add-time" style="display:none" title="<?php echo dic("Settings.AddWorkTime")?>">
        <table align = "center" cellpadding="3" cellspacing="3" style="padding-top: 10px">
            <tr>
                <td class="text5" style="font-weight:bold"><?php echo dic_("From")?>:
                <td class="text5" style="font-weight:bold">
				<select id="TimeFrom" class="combobox text2">
					
                <?php
                	$TF = explode(" ", pg_fetch_result($prikazi, 0, "timefrom"));
                    $t1 = "";
                    $t2 = "";
                    $t3 = "";
					$t4 = "";
					$t5 = "";
					$t6 = "";
					$t7 = "";
					$t8 = "";
					$t9 = "";
					$t10 = "";
					$t11 = "";
                    $t12 = "";
                    $t13 = "";
					$t14 = "";
					$t15 = "";
					$t16 = "";
					$t17 = "";
					$t18 = "";
					$t19 = "";
					$t20 = "";
					$t21 = "";
                    $t22 = "";
                    $t23 = "";
					$t00 = "";
					
					If($TF[0] == "01"){
                       $t1 = "selected='selected'";
					}
					If($TF[0] == "02"){
                        $t2 = "selected='selected'";
					}
					If($TF[0] == "03"){
                        $t3 = "selected='selected'";
					}
					If($TF[0] == "04"){
                        $t4 = "selected='selected'";
					}
					If($TF[0] == "05"){
                        $t5 = "selected='selected'";
					}
					If($TF[0] == "06"){
                        $t6 = "selected='selected'";
					}
					If($TF[0] == "07"){
                        $t7 = "selected='selected'";
					}
					If($TF[0] == "08"){
                        $t8 = "selected='selected'";
					}
					If($TF[0] == "09"){
                        $t9 = "selected='selected'";
					}
					If($TF[0] == "10"){
                        $t10 = "selected='selected'";
					}
					If($TF[0] == "11"){
                       $t11 = "selected='selected'";
					}
					If($TF[0] == "12"){
                        $t12 = "selected='selected'";
					}
					If($TF[0] == "13"){
                        $t13 = "selected='selected'";
					}
					If($TF[0] == "14"){
                        $t14 = "selected='selected'";
					}
					If($TF[0] == "15"){
                        $t15 = "selected='selected'";
					}
					If($TF[0] == "16"){
                        $t16 = "selected='selected'";
					}
					If($TF[0] == "17"){
                        $t17 = "selected='selected'";
					}
					If($TF[0] == "18"){
                        $t18 = "selected='selected'";
					}
					If($TF[0] == "19"){
                        $t19 = "selected='selected'";
					}
					If($TF[0] == "20"){
                        $t20 = "selected='selected'";
					}
					If($TF[0] == "21"){
                       $t21 = "selected='selected'";
					}
					If($TF[0] == "22"){
                        $t22 = "selected='selected'";
					}
					If($TF[0] == "23"){
                        $t23 = "selected='selected'";
					}
					If($TF[0] == "00"){
                        $t00 = "selected='selected'";
					}
   
                ?>
   					<option value="01" <?php echo $t1?>>01:</option>
		            <option value="02" <?php echo $t2?>>02:</option>
		            <option value="03" <?php echo $t3?>>03:</option>
                    <option value="04" <?php echo $t4?>>04:</option>
                    <option value="05" <?php echo $t5?>>05:</option>
                    <option value="06" <?php echo $t6?>>06:</option>
                    <option value="07" <?php echo $t7?>>07:</option>
                    <option value="08" <?php echo $t8?>>08:</option>
                    <option value="09" <?php echo $t9?>>09:</option>
                    <option value="10" <?php echo $t10?>>10:</option>
                    <option value="11" <?php echo $t11?>>11:</option>
		            <option value="12" <?php echo $t12?>>12:</option>
		            <option value="13" <?php echo $t13?>>13:</option>
                    <option value="14" <?php echo $t14?>>14:</option>
                    <option value="15" <?php echo $t15?>>15:</option>
                    <option value="16" <?php echo $t16?>>16:</option>
                    <option value="17" <?php echo $t17?>>17:</option>
                    <option value="18" <?php echo $t18?>>18:</option>
                    <option value="19" <?php echo $t19?>>19:</option>
                    <option value="20" <?php echo $t20?>>20:</option>
                    <option value="21" <?php echo $t21?>>21:</option>
		            <option value="22" <?php echo $t22?>>22:</option>
		            <option value="23" <?php echo $t23?>>23:</option>
                    <option value="00" <?php echo $t00?>>00:</option>
               </select>
               
               <select id="TimeFrom1" class="combobox text2">
               	<?php
               		$TFZ = explode(" ", pg_fetch_result($prikazi, 0, "timefrom"));
                    $tz1 = "";
                    $tz2 = "";	
                    $tz3 = "";
					$tz4 = "";
					
					If($TFZ[0] == ":00"){
                       $tz1 = "selected='selected'";
					}
					If($TFZ[0] == ":15"){
                        $tz2 = "selected='selected'";
					}
					If($TFZ[0] == ":30"){
                        $tz3 = "selected='selected'";
					}
					If($TFZ[0] == ":45"){
                        $tz4 = "selected='selected'";
					}
               	?>
               	<option value=":00" <?php echo $tz1?>>:00</option>
               	<option value=":15" <?php echo $tz2?>>:15</option>
               	<option value=":30" <?php echo $tz3?>>:30</option>
               	<option value=":45" <?php echo $tz4?>>:45</option>
               	</select>
                </td>
                </td>
            </tr>
            <tr>
			
                <td class="text5" style="font-weight:bold"><?php echo dic_("To")?>:&nbsp;
                <td class="text5" style="font-weight:bold">
                <select id="TimeTo" class="combobox text2">
                <?php
                	$TT = explode(" ", pg_fetch_result($prikazi, 0, "timeto"));
                    $tt1 = "";
                    $tt2 = "";
                    $tt3 = "";
					$tt4 = "";
					$tt5 = "";
					$tt6 = "";
					$tt7 = "";
					$tt8 = "";
					$tt9 = "";
					$tt10 = "";
					$tt11 = "";
                    $tt12 = "";
                    $tt13 = "";
					$tt14 = "";
					$tt15 = "";
					$tt16 = "";
					$tt17 = "";
					$tt18 = "";
					$tt19 = "";
					$tt20 = "";
					$tt21 = "";
                    $tt22 = "";
                    $tt23 = "";
					$tt00 = "";
					
					If($TT[0] == "01"){
                       $tt1 = "selected='selected'";
					}
					If($TT[0] == "02"){
                        $tt2 = "selected='selected'";
					}
					If($TT[0] == "03"){
                        $tt3 = "selected='selected'";
					}
					If($TT[0] == "04"){
                        $tt4 = "selected='selected'";
					}
					If($TT[0] == "05"){
                        $tt5 = "selected='selected'";
					}
					If($TT[0] == "06"){
                        $tt6 = "selected='selected'";
					}
					If($TT[0] == "07"){
                        $tt7 = "selected='selected'";
					}
					If($TT[0] == "08"){
                        $tt8 = "selected='selected'";
					}
					If($TT[0] == "09"){
                        $tt9 = "selected='selected'";
					}
					If($TT[0] == "10"){
                        $tt10 = "selected='selected'";
					}
					If($TT[0] == "11"){
                       $tt11 = "selected='selected'";
					}
					If($TT[0] == "12"){
                        $tt12 = "selected='selected'";
					}
					If($TT[0] == "13"){
                        $tt13 = "selected='selected'";
					}
					If($TT[0] == "14"){
                        $tt14 = "selected='selected'";
					}
					If($TT[0] == "15"){
                        $tt15 = "selected='selected'";
					}
					If($TT[0] == "16"){
                        $tt16 = "selected='selected'";
					}
					If($TT[0] == "17"){
                        $tt17 = "selected='selected'";
					}
					If($TT[0] == "18"){
                        $tt18 = "selected='selected'";
					}
					If($TT[0] == "19"){
                        $tt19 = "selected='selected'";
					}
					If($TT[0] == "20"){
                        $tt20 = "selected='selected'";
					}
					If($TT[0] == "21"){
                       $tt21 = "selected='selected'";
					}
					If($TT[0] == "22"){
                        $tt22 = "selected='selected'";
					}	
					If($TT[0] == "23"){
                        $tt23 = "selected='selected'";
					}
					If($TT[0] == "00"){
                        $tt00 = "selected='selected'";
					}
   					?>
   					<option value="01" <?php echo $tt1?>>01:</option>
		            <option value="02" <?php echo $tt2?>>02:</option>
		            <option value="03" <?php echo $tt3?>>03:</option>
                    <option value="04" <?php echo $tt4?>>04:</option>
                    <option value="05" <?php echo $tt5?>>05:</option>
                    <option value="06" <?php echo $tt6?>>06:</option>
                    <option value="07" <?php echo $tt7?>>07:</option>
                    <option value="08" <?php echo $tt8?>>08:</option>
                    <option value="09" <?php echo $tt9?>>09:</option>
                    <option value="10" <?php echo $tt10?>>10:</option>
                    <option value="11" <?php echo $tt11?>>11:</option>
		            <option value="12" <?php echo $tt12?>>12:</option>
		            <option value="13" <?php echo $tt13?>>13:</option>
                    <option value="14" <?php echo $tt14?>>14:</option>
                    <option value="15" <?php echo $tt15?>>15:</option>
                    <option value="16" <?php echo $tt16?>>16:</option>
                    <option value="17" <?php echo $tt17?>>17:</option>
                    <option value="18" <?php echo $tt18?>>18:</option>
                    <option value="19" <?php echo $tt19?>>19:</option>
                    <option value="20" <?php echo $tt20?>>20:</option>
                    <option value="21" <?php echo $tt21?>>21:</option>
		            <option value="22" <?php echo $tt22?>>22:</option>
		            <option value="23" <?php echo $tt23?>>23:</option>
                    <option value="00" <?php echo $tt00?>>00:</option>
               </select>
               
               <select id="TimeTo1" class="combobox text2">
               <?php
               		$TFJ = explode(" ", pg_fetch_result($prikazi, 0, "timeto"));
                    $tj1 = "";
                    $tj2 = "";
                    $tj3 = "";
					$tj4 = "";
					
					If($TFJ[0] == ":00"){
                       $tj1 = "selected='selected'";
					}
					If($TFJ[0] == ":15"){
                        $tj2 = "selected='selected'";
					}
					If($TFJ[0] == ":30"){
                        $tj3 = "selected='selected'";
					}
					If($TFJ[0] == ":45"){
                        $tj4 = "selected='selected'";
					}
               ?>
               <option value=":00" <?php echo $tj1?>>:00</option>
               <option value=":15" <?php echo $tj2?>>:15</option>
               <option value=":30" <?php echo $tj3?>>:30</option>
               <option value=":45" <?php echo $tj4?>>:45</option>
               </select>
               </td>
               </td>
               
               </tr>
               <tr>
               <td class="text5" style="font-weight:bold"><?php dic("Settings.Day")?>:
               <td class="text5" style="font-weight:bold">
               <select id="TimeType" class="combobox text2">
                <?php
                	$ttd1 = "";
                    $ttd2 = "";
                    $ttd3 = "";
					$ttd4 = "";
					$ttd5 = "";
                    $ttd6 = "";
					$ttd7 = "";
					$ttd8 = "";
					$ttd9 = "";
					$ttd10 = "";
				?>
					<option value="1" <?php echo $ttd1?>><?php dic("Settings.Monday")?></option>
		            <option value="2" <?php echo $ttd2?>><?php dic("Settings.Tuesday")?></option>
		            <option value="3" <?php echo $ttd3?>><?php dic("Settings.Wednesday")?></option>
                    <option value="4" <?php echo $ttd4?>><?php dic("Settings.Thursday")?></option>
                    <option value="5" <?php echo $ttd5?>><?php dic("Settings.Friday")?></option>
                    <option value="6" <?php echo $ttd6?>><?php dic("Settings.Saturday")?></option>
                    <option value="7" <?php echo $ttd7?>><?php dic("Reports.Sunday")?></option>
                    <option value="8" <?php echo $ttd8?>><?php dic("Settings.Holiday")?></option>
                    <option value="9" <?php echo $ttd9?>><?php dic("Reports.Weekend")?></option>
		            <option value="10" <?php echo $ttd10?>><?php dic("Reports.Weekday")?></option>
		      </select>
              </td>
			  </td>
              </tr>
              <tr>
                <td class="text5" style="font-weight:bold"><?php dic("Settings.Shift")?>:</td>
                <td class="text5" style="font-weight:bold">
                    <select id="TimeShift" class="combobox text2">
                	<?php
                	$TS = explode(" ", pg_fetch_result($prikazi, 0, "shift"));
                    $tts1 = "";
                    $tts2 = "";
                    $tts3 = "";
					$tts4 = "";

					If($TS[0] == "1"){
                       $tts1 = "selected='selected'";
					}
					If($TS[0] == "2"){
                        $tts2 = "selected='selected'";
					}
					If($TS[0] == "3"){
                        $tts3 = "selected='selected'";
					}
					If($TS[0] == "4"){
                        $tts4 = "selected='selected'";
					}
					?>
					<option value="1" <?php echo $tts1?>>1</option>
		            <option value="2" <?php echo $tts2?>>2</option>
		            <option value="3" <?php echo $tts3?>>3</option>
                    <option value="4" <?php echo $tts4?>>4</option>
                </select>
              </td>
           </tr>
       </table>
    </div>
    
    <div id="div-del-time" style="display:none" title="<?php dic("Settings.DeleteWorkTime")?>">
    	<?php dic("Settings.DeleteWorkTimeQuestion")?>
    </div>
    <div id="div-edit-time" style="display:none" title="<?php dic("Settings.ChangeWorkTime")?>"></div>
    
    <div id="div-del-admin" style="display:none" title="Листа на неработни денови за 2014 година"><br>
    <div align="left">
	<b style="font-weight:bold; font-size: 12px;"><font color="black">ПРАЗНИЦИ ЗА СИТЕ ГРАЃАНИ БЕЗ РАЗЛИКА НА ВЕРСКА И НАЦИОНАЛНА ПРИПАДНОСТ</font></b><br><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;">
    <font color = "black">• </font> 01 Јануари, Нова Година <font color = "black">(вторник)</font> <br>
    <font color = "black">• </font> 07 Јануари, Божик <font color = "black">(понеделник)</font> <br>
    <font color = "black">• </font> 01 Мај, Ден на Трудот <font color = "black">(среда)</font><br>
    <font color = "black">• </font> 6 Мај, Велигден, вториот ден на Велигден <font color = "black">(понеделник)</font> <br>
    <font color = "black">• </font> 24 Мај, „Св. Кирил и Методиј“ Ден на сесловенските просветители <font color = "black">(петок)</font><br>
    <font color = "black">• </font> 02 Август, Ден на Републиката <font color = "black">(петок)</font><br> 
    <font color = "black">• </font> 7 Август, Рамазан Бајрам, првиот ден на Рамазан Бајрам <font color = "black">(среда)</font> <br>
    <font color = "black">• </font> 08 Септември, Ден на независноста <font color = "black">(недела, неработен ден е понеделник)</font> <br>
    <font color = "black">• </font> 11 Октомври <font color = "black">(петок)</font>, Ден на народното востание<br>
    <font color = "black">• </font> 23 Октомври <font color = "black">(среда)</font>, Ден на Македонската револуционерна борба<br>
    </font>
    <br><br>
    <b style="font-weight:bold; font-size: 12px;"><font color="black">ПРАВОСЛАВНИ ПРАЗНИЦИ</font></b><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;">
	<font color = "black">• </font> 06 Јануари, Бадник, ден пред Божик <font color = "black">(недела)</font><br>
	<font color = "black">• </font> 19 Јануари, Богојавление – Водици <font color = "black">(сабота)</font> <br>
	<font color = "black">• </font> 3 Мај, Велики Петок, петок пред Велигден <font color = "black">(петок)</font> <br>
	<font color = "black">• </font> 21 Јуни, Духовден, петок пред Духовден <font color = "black">(петок)</font><br>
	<font color = "black">• </font> 28 Август, Успение на Пресвета Богородица - Голема Богородица <font color = "black">(среда) </font><br>
   	</font>
    <br><br>
    <b style="font-weight:bold; font-size: 12px;"><font color="black">КАТОЛИЧКИ ПРАЗНИЦИ</font></b><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;">
    <font color = "black">• </font> 1 Април, Велигден, вториот ден на Велигден <font color = "black">(понеделник)</font> <br>
	<font color = "black">• </font> 01 Ноември <font color = "black">(петок)</font>, Празникот на сите светци<br>
	<font color = "black">• </font> 25 Декември <font color = "black">(среда)</font>, првиот ден на Божик<br>
    </font>
    <br><br> 
   
    <b style="font-weight:bold; font-size: 12px;"><font color="black">МУСЛИМАНСКИ ПРАЗНИЦИ</font></b><br><br>
   
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;"><font color = "black">•</font> 15 Октомври <font color = "black">(вторник)</font>, Курбан Ба`јрам, првиот ден на Курбан Бајрам</font><br><br>
    <br> 
    <b style="font-weight:bold; font-size: 12px;"><font color="black">ПРАЗНИЦИ ЗА АЛБАНСКА ЗАЕДНИЦА</font></b><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;"> <font color = "black">• </font>  22 Ноември <font color = "black">(петок)</font>, Ден на Албанската азбука </font><br><br>
    <br> 
    <b style="font-weight:bold; font-size: 12px;"><font color="black">ПРАЗНИЦИ ЗА СРПСКА ЗАЕДНИЦА</font></b><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;"> <font color = "black">• </font>  27 Јануари <font color = "black">(сабoта)</font>, Свети Сава</font><br><br>
	<br> 
	<b style="font-weight:bold; font-size: 12px;"><font color="black">ПРАЗНИЦИ ЗА РОМСКАТА ЗАЕДНИЦА</font></b><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;"> <font color = "black">• </font> 8 Април <font color = "black">(понеделник)</font>, Меѓународен ден на Ромите </font><br><br>
    <br> 
    <b style="font-weight:bold; font-size: 12px;"><font color="black">ПРАЗНИЦИ ЗА ВЛАШКАТА ЗАЕДНИЦА</font></b><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;"> <font color = "black">• </font>  23 Мај <font color = "black">(четврток)</font>, Национален ден на Власите </font><br><br>
    <br> 
    <b style="font-weight:bold; font-size: 12px;"><font color="black">ПРАЗНИЦИ ЗА ЕВРЕЈСКАТА ЗАЕДНИЦА</font></b><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;"> <font color = "black">• </font> 26 септември <font color = "black">(четврток)</font>, Јом Кипур, првиот ден на Јом Кипур</font><br><br>
    <br> 
    <b style="font-weight:bold; font-size: 12px;"><font color="black">ПРАЗНИЦИ ЗА БОШЊАЧКАТА ЗАЕДНИЦА</font></b><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;"> <font color = "black">• </font> 28 Септември <font color = "black">(сабота)</font>, Меѓународен ден на Бошњаците </font><br><br>
    <br> 
    <b style="font-weight:bold; font-size: 12px;"><font color="black">ПРАЗНИЦИ ЗА ТУРСКАТА ЗАЕДНИЦА</font></b><br><br>
    <font color="#002BFF" style="font-weight:bold; font-size: 11px;"> <font color = "black">• </font> 21 Декември <font color = "black">(сабота)</font>, Ден на настава на турски јазик</font><br>
    </div>
    </div>
    <div id="div-add-day" style="display:none" title="<?php dic("Settings.AddNonWorkingDay")?>"><br>
    </div>
    <div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	 </p>
	</div>
  	</body>
	</html>
	
	<script>
	top.HideWait();
	
	//$('#listaNerab').button({ icons: { primary: "ui-icon-bookmark"} });
	if ($('#downloadHolidays'))
		$('#downloadHolidays').button({ icons: { primary: "ui-icon-arrowthickstop-1-s"} });
	if ($('#removeHolidays'))
		$('#removeHolidays').button({ icons: { primary: "ui-icon-circle-close"} });
		
	$('#nerab').button({ icons: { primary: "ui-icon-note"} });
    $('#addBtn2').button({ icons: { primary: "ui-icon-plus"} });
    document.getElementById('addBtn2').style.height = "27px";
    document.getElementById('addBtn2').style.width = "90px";
   	
   	
   	function NerabotniDenovi(){
   	document.getElementById('div-del-admin').title = dic("Settings.ListOfNonWorkingDays")
        $('#div-del-admin').dialog({ modal: true, width: 650, height: 650, resizable: false,
                buttons: 
                [
                {
                	text:dic('Tracking.Cancel',lang),
                    click: function() {
					    $( this ).dialog( "close" );
			 	    }
                }
            ]
   	   })
   	}
   	function AddButton() {
	$('#div-add-time').dialog({ modal: true, width: 350, height: 300, resizable: false,
	        buttons: 
	        [
            {
            	text:dic("Settings.Add",lang),
				click: function() {
                    var WorkTimeFrom=0
   					WorkTimeFrom = $('#TimeFrom').val()
   					var WorkTimeFrom1=0
   					WorkTimeFrom1 = $('#TimeFrom1').val()
   					var WorkTimeTo=0
    				WorkTimeTo = $('#TimeTo').val()
    				var WorkTimeTo1=0
    				WorkTimeTo1 = $('#TimeTo1').val()
    				var WorkTimeShift=0
    				WorkTimeShift = $('#TimeShift').val()
    				var WorkTimeType=0
    				WorkTimeType = $('#TimeType').val()
                    if (WorkTimeFrom=='') {
                        mymsg(dic("enterUser", lang))     
                    } else {
                        if (WorkTimeTo==''){
                            mymsg(dic("enterFull", lang))   
                        }else{
                            if (WorkTimeShift==''){
                                mymsg(dic("enterPass", lang)) 
                            } else{
                                if(WorkTimeType==''){
                                    mymsg(dic("enterEmail", lang))  
                                }else{
                                	$.ajax({
		                              url: "SaveWorkTime.php?WorkTimeFrom="+WorkTimeFrom+"&WorkTimeFrom1="+WorkTimeFrom1+"&WorkTimeTo="+WorkTimeTo+"&WorkTimeTo1="+WorkTimeTo1+"&WorkTimeShift="+WorkTimeShift+"&WorkTimeType="+WorkTimeType,
		                              context: document.body,
		                              success: function(data){
		                              if(data == 1)
		                              {
		                       			msgboxPetar(dic("Settings.WorkTimeCheck"),lang)
		                              }
		                              else
		                              {
		                              	msgboxPetar(dic("Settings.AddShift"),lang)
		                              	setTimeout(function(){
		                            		window.location.reload();
		                            		var from = WorkTimeFrom + WorkTimeFrom1 + ":00";
		                            		var to = WorkTimeTo + WorkTimeTo1 + ":59";
		        
		                            		$.ajax({
					                            url: "cachereports_sett.php?cid="+'<?= session("client_id")?>' + "&dayType="+WorkTimeType+"&from="+from+"&to="+to,
					                            context: document.body,
					                            success: function(data){
					                            	//alert(data)
					                            }
			                          	 	});
		                            	}, 3000);
			                          }
		                              }
		                           });	
                                }
                             }
                          }
                       }
                    }
				},
				{
					text:dic("cancel",lang),
                click: function() {
					$( this ).dialog( "close" );
				},
			   }
			 ]
		  });
   		}
   		function DeleteButtonClick(id, _from, _to, WorkTimeType) {
   		
		$('#div-del-time').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                {
                	text:dic("Settings.Yes"),
				    click: function() {
                            $.ajax({
		                        url: "DelWorkTime.php?id="+id+"&l="+lang,
		                        context: document.body,
		                        success: function(data){
		                        msgboxPetar(dic("Settings.DeleteShift"),lang)
		                        setTimeout(function(){
                            		window.location.reload();
                            		var from = _from + ":00";
                            		var to = _to + ":59";
       
                            		$.ajax({
			                            url: "cachereports_sett.php?cid="+'<?= session("client_id")?>' + "&dayType="+WorkTimeType+"&from="+from+"&to="+to,
			                            context: document.body,
			                            success: function(data){
			                            	//alert(data)
			                            }
	                          	 	});
                            	}, 3000);
								}
		                    });	
                            $( this ).dialog( "close" );
                           }
				    },
				    {
				    	text:dic("Settings.No",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				    }
                 }
              ]
           });
        }
		function EditTimeClick(id){
        ShowWait()
        $.ajax({
		    url: "EditTime.php?id="+id+"&l="+lang,
		    context: document.body,
		    success: function(data){
                HideWait()
			    $('#div-edit-time').html(data)
                $('#div-edit-time').dialog({ modal: true, width: 350, height: 300, resizable: false,
                     buttons: 
                     [
                     {
                     	text:dic("Settings.Change",lang),
				        click: function() {
                             
                             var WorkTimeFrom=0
                             WorkTimeFrom = $('#TimeFrom3').val()
                             var WorkTimeFrom4=0
                             WorkTimeFrom4 = $('#TimeFrom4').val()
   							 var WorkTimeTo=0
    						 WorkTimeTo = $('#TimeTo2').val()
    						 var WorkTimeTo4=0
    						 WorkTimeTo4 = $('#TimeTo4').val()
    						 var WorkTimeShift=0
    						 WorkTimeShift = $('#TimeShift2').val()
    						 var WorkTimeType=0
    						 WorkTimeType = $('#TimeType2').val()
                                      $.ajax({
		                              url: "UpTime.php?WorkTimeFrom="+WorkTimeFrom+"&WorkTimeFrom4="+WorkTimeFrom4+"&WorkTimeTo="+WorkTimeTo+"&WorkTimeTo4="+WorkTimeTo4+"&WorkTimeShift="+WorkTimeShift+"&WorkTimeType="+WorkTimeType+"&id="+id,
		                              context: document.body,
		                              success: function(data){
		                              if(data == 1)
		                              {
		                       			msgboxPetar(dic("Settings.EditTimeAlreadyCombination"),lang)
		                              }
		                              else
		                              {
		                              	msgboxPetar(dic("Settings.ModifyShift"),lang)
		                                setTimeout(function(){
		                            		window.location.reload();
		                            		var from = WorkTimeFrom + WorkTimeFrom4 + ":00";
		                            		var to = WorkTimeTo + WorkTimeTo4 + ":59";
		       
		                            		$.ajax({
					                            url: "cachereports_sett.php?cid="+'<?= session("client_id")?>' + "&dayType="+WorkTimeType+"&from="+from+"&to="+to,
					                            context: document.body,
					                            success: function(data){
					                            	//alert(data)
					                            }
			                          	 	});
		                            	}, 3000);
			                          }
		                              }
		                            });	
                                }
                        	},
                        {
                        	text:dic("cancel",lang),
                        click: function() {
					        $( this ).dialog( "close" );
				        },
                     }       
                     ]
                });
		    }
		});
   }
   
   function downloadHolidays(t) {
   	 	$.ajax({
		    url: "downloadHolidays.php?t="+t,
		    context: document.body,
		    success: function(data){
		    	if (t == 1)
		    		msgboxPetar('<?= dic_("Settings.SuccDownloadHolidays1")?>')
		    	if (t == 0)	
		    		msgboxPetar('<?= dic_("Settings.SuccRemoveHolidays1")?>')
		    		
                setTimeout(function(){
            		window.location.reload();  
                    $.ajax({
		                url: "cachereports_sett.php?cid="+'<?= session("client_id")?>' + "&holidays=1",
                        context: document.body,
                        success: function(data){
                        	//alert(data)
                        }
              	 	});
            	}, 3000);
		    }
	    });
   }
   </script>
   
   
   
