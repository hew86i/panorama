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
		.ui-button { margin-left: -1px; }
		.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
		.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
	</style>
	<style>
		.Highlighted a{
		   background-color : #339933 !important;
		   background-image :none !important;
		   color: white !important;
		   font-weight:bold !important;
		   font-size: 10pt;
		}
		.ui-datepicker-week-end a {
		   background-color :#FFFFFF  !important;
		   background-image :none !important;
		   color: red !important;
		   font-weight:bold !important;
		   font-size: 10pt;
	  
	}
	</style>
	
	<script>
	$(document).ready(function() {
    
    var SelectedDates = {};
    //ПРАЗНИЦИ ЗА СИТЕ ГРАЃАНИ БЕЗ РАЗЛИКА НА ВЕРСКА И НАЦИОНАЛНА ПРИПАДНОСТ
    SelectedDates[new Date('01/01/2013')] = new Date('01/01/2013');
    SelectedDates[new Date('01/07/2013')] = new Date('01/07/2013');
    SelectedDates[new Date('05/01/2013')] = new Date('05/01/2013');
    SelectedDates[new Date('05/06/2013')] = new Date('05/06/2013');
    SelectedDates[new Date('05/24/2013')] = new Date('05/24/2013');
    SelectedDates[new Date('08/02/2013')] = new Date('08/02/2013');
    
    //ПРАВОСЛАВНИ ПРАЗНИЦИ
    SelectedDates[new Date('01/06/2013')] = new Date('01/06/2013');
    SelectedDates[new Date('01/19/2013')] = new Date('01/19/2013');
    SelectedDates[new Date('05/03/2013')] = new Date('05/03/2013');
    SelectedDates[new Date('06/21/2013')] = new Date('06/21/2013');
    SelectedDates[new Date('08/28/2013')] = new Date('08/28/2013');
    
    
    //КАТОЛИЧКИ ПРАЗНИЦИ
    SelectedDates[new Date('04/01/2013')] = new Date('04/01/2013');
    SelectedDates[new Date('11/01/2013')] = new Date('11/01/2013');
    SelectedDates[new Date('12/25/2013')] = new Date('12/25/2013');
    
    //МУСЛИМАНСКИ ПРАЗНИЦИ
    SelectedDates[new Date('10/15/2013')] = new Date('10/15/2013');
    
    //ПРАЗНИЦИ ЗА АЛБАНСКА ЗАЕДНИЦА
    SelectedDates[new Date('11/22/2013')] = new Date('11/22/2013');
    
    //ПРАЗНИЦИ ЗА СРПСКА ЗАЕДНИЦА
    SelectedDates[new Date('01/27/2013')] = new Date('01/27/2013');
	
	//ПРАЗНИЦИ ЗА РОМСКАТА ЗАЕДНИЦА
    SelectedDates[new Date('04/08/2013')] = new Date('04/08/2013');
    
    //ПРАЗНИЦИ ЗА ВЛАШКАТА ЗАЕДНИЦА
    SelectedDates[new Date('05/23/2013')] = new Date('05/23/2013');
    
    //ПРАЗНИЦИ ЗА ЕВРЕЈСКАТА ЗАЕДНИЦА
    SelectedDates[new Date('09/26/2013')] = new Date('09/26/2013');
    
    //ПРАЗНИЦИ ЗА БОШЊАЧКАТА ЗАЕДНИЦА
    SelectedDates[new Date('09/28/2013')] = new Date('09/28/2013');
    
    //ПРАЗНИЦИ ЗА ТУРСКАТА ЗАЕДНИЦА
    SelectedDates[new Date('12/21/2013')] = new Date('12/21/2013');

	$('#txtDate2').datepicker({
    	dateFormat: 'dd-mm-yy',
        hourGrid: 4,
        minuteGrid: 10,
        numberOfMonths: 3,
        showButtonPanel: true,
       /* onSelect: 
        
       
        function dodadiDen(){
   		document.getElementById('div-add-day').title = dic("Додавање на ден")
        $('#div-add-day').dialog({ modal: true, width: 600, height: 500, resizable: false,
                 buttons: 
                 [
                 {
                	text:dic("Settings.Yes",lang),
				    click: function() {
                            $.ajax({
		                        url: "WorkTime.php",
		                        context: document.body,
		                        success: function(data){
		                        alert(dic("Settings.SuccEditedWorkTime",lang));
		                        window.location.reload();
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
   		   })
   		},*/
   		
   		
   		beforeShowDay: function(date) {
            var Highlight = SelectedDates[date];
            if (Highlight) {
                return [true, "Highlighted", Highlight];
            }
            else {
                return [true, '', ''];
            }
        }
        
    });
	});
	
	</script>
	<script>
	
	</script>
	<style type="text/css"> 
 		body{ overflow-y:auto }
	</style>
	</head>
	<body>
	<table width="100%">
	<tr>
	<td align = "left" width="100%">
	<div class="textTitle" style="padding-left:<?php if($yourbrowser == "1") { echo '35px'; } else { echo '35px'; } ?>; padding-top:30px;"><?php echo dic("Settings.WorkTime")?><br />
	</div>
	</td>
	</tr>
	</table>
	<?php 
	$prikazi = query("SELECT * FROM worktime where clientid =" . Session("client_id"));
	?>
	<div align = "left">
		
		<table width="94%" border="0" cellspacing = "2" cellpadding = "2" style="margin-top:30px; margin-left:35px">
		<tr>
		<td align = "center" valign="middle">
		<div align = "middle" id="txtDate2" />
		</div>
		<div >
	    <!--<img src = "../images/redsquare.png" width="20px" height="20px" style="padding-top: 5px"></img>-->
		<img src="../images/infocircle.png" onmousemove="ShowPopup(event, 'Сите празници за 2013 година без разлика на национална и верска припадност се означени со <br> зелени квадратчиња и  бела боја бројки,викендите се означени со бела боја квадратчиња и црвени бројки.')" onmouseout="HidePopup()" style="padding-top: 5px"></img>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button id="nerab" onclick="NerabotniDenovi()" style="margin-left:1px">Листа на неработни денови</button>
		</div>
		</td>
		</tr>
		<tr>
		<td align = "center" valign="middle">
		<div id="noData" align = "center" style="font-size:10px; font-style:italic;font-style:bold;" class="text4">
 		</div>
		</td>
		</tr>
		<tr>
		<td align = "left" valign="top">
			<button id="addBtn2" onclick="AddButton()" style="margin-left:1px"><?php dic("Tracking.Add")?></button>
		</td>
		</tr>
		</table>
		</div>
		<?php
		$cnt = 1;
		$i = 1;
		$poi = query("select * from worktime where clientid = " . Session("client_id")." order by daytype");
		if(pg_num_rows($poi)==0){
		?>
		<br><br>
		<div id="noData" style="padding-left:40px; font-size:30px; font-style:italic; padding-bottom:40px" class="text4">
 		<?php dic("Reports.NoData1")?>
		</div>
		<?php
		}
		else
		{
		?>
		<div align = "left">
	    <table width="94%" border="0" cellspacing = "2" cellpadding = "2" style="margin-top:30px; margin-left:35px">
		<tr>
			<td align = "left" valign = "middle" colspan="9" height="22px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" > <?php echo dic("Settings.WorkTime")?></td>
		</tr>
		<tr>
		<td align = "center" width="17%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Reports.From")?></td>
		<td align = "center" width="17%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Reports.To")?> </td>
		<td align = "center" width="25%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Reports.Day")?> </td>
		<td align = "center" width="17%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Shift")?> </td>
		<td align = "center" width="12%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Change")?> </td> 
		<td align = "center" width="12%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Tracking.Delete")?> </td>
		</tr>
		<?php
		while ($row1 = pg_fetch_array($poi))
 		{
 			$data[] = ($row1);
		}
		foreach ($data as $row1)
		{
		?>
		
		<tr>
		<td align = "center" width="17%" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
			<?php echo $row1['timefrom'] ?>
		</td>
		<td align = "center" width="17%" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
			<?php echo $row1['timeto'] ?>
		</td>
		<td width="25%" align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
			 <?php 
				if ($row1["daytype"] == "1"){
					dic("Settings.Monday");
				}
				if ($row1["daytype"] == "2"){
					dic("Settings.Tuesday");
				}
				if ($row1["daytype"] == "3"){
					dic("Settings.Wednesday");
				}
				if ($row1["daytype"] == "4"){
					dic("Settings.Thursday");
				}
				if ($row1["daytype"] == "5"){
					dic("Settings.Friday");
				}
				if ($row1["daytype"] == "6"){
					dic("Settings.Saturday");
				}
				if ($row1["daytype"] == "7"){
					dic("Reports.Sunday");
				}
				if ($row1["daytype"] == "8"){
					dic("Settings.Holiday");
				}
			?>
			</td>
			<td align = "center" width="17%" cheight="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
				<?php echo $row1['shift'] ?>
			</td>
			<td align = "center" width="12%"  height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
				<button id="btnEdit<?php echo $cnt?>"  onclick="EditTimeClick(<?php echo $row1["id"]?>)" style="height:22px; width:30px"></button>
			</td>
			<td align = "center" width="12%"  height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
				<button id="DelBtn<?php echo $cnt?>"  onclick="DeleteButtonClick(<?php echo $row1["id"]?>)" style="height:22px; width:30px"></button>
			</td>
		</tr>
		<script>
		var i = <?php echo $cnt?>;
		$('#btnEdit' + i).button({ icons: { primary: "ui-icon-pencil"} });
		$('#DelBtn' + i).button({ icons: { primary: "ui-icon-trash"} });
		</script>
		<?php
		$cnt++;
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
    
    <div id="div-del-admin" style="display:none" title="Листа на неработни денови за 2013 година"><br>
    <div align="center">
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
    
    <div id="div-add-day" style="display:none" title="Додавање на ден"><br>
    </div>
    
    
    
	</body>
	</html>
	
	<script>
	top.HideWait();
	
	$('#nerab').button({ icons: { primary: "ui-icon-note"} });
    $('#addBtn2').button({ icons: { primary: "ui-icon-plus"} });
    document.getElementById('addBtn2').style.height = "27px";
    document.getElementById('addBtn2').style.width = "90px";
   	
   	
   	function NerabotniDenovi(){
   	document.getElementById('div-del-admin').title = dic("Листа на неработни денови за 2013 година")
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
		                       			alert(dic("Settings.WorkTimeCheck"),lang)
		                              }
		                              else
		                              {
		                              	alert(dic("Settings.SucAddWorkTime"),lang)
					    			 	window.location.reload();
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
   function DeleteButtonClick(id) {
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
		                        alert(dic("Settings.SuccDeleted",lang));
		                        window.location.reload();
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
		                       			alert(dic("Settings.EditTimeAlreadyCombination"),lang)
		                              }
		                              else
		                              {
		                              	alert(dic("Settings.SuccEditedWorkTime"),lang)
					    			 	window.location.reload();
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
   </script>
   <?php closedb();?>
   