<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<html>
<head>
	<script>
		lang = '<?php echo $cLang?>'
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php dic("Reports.PanoramaGPS")?></title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">	
	<LINK REL="SHORTCUT ICON" HREF="../images/icon.ico">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="reports.js"></script>
    <link rel="stylesheet" type="text/css" href="../js/spineditcontrol.css">
    <link rel="stylesheet" type="text/css" href="../js/content.css">	
    <script src="js/spineditcontrol.js" type="text/javascript"></script>
    <script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
  
</head>

<?php
	opendb();
	
	If (is_numeric(nnull($_SESSION['user_id'])) == False) echo header('Location: ../sessionexpired/?l=' . $cLang);
    	
    $ind2 = 0;

    $idto = getQUERY("id");
    
    $lang = getQUERY("lang");
    $cLang = $lang;

	$tipIzvestaj = query("select * from scheduler where id=" . $idto);
    $tipI = pg_fetch_result($tipIzvestaj, 0, "report");
    $repid = pg_fetch_result($tipIzvestaj, 0, "repid");

	$selVehID = pg_fetch_result($tipIzvestaj, 0, "vehid");
	$periodPris = query("select * from scheduler where id=" . $idto);
	if ($selVehID <> 0) {
		$selVehVal = dlookup("select registration || ' ' || alias || ' (' || code || ')' from vehicles where id=" . $selVehID);				
	} else {
		$selVehVal = "0";
	}

    $sql_ = "";
    If ($_SESSION['role_id'] == "2") {
        $sql_ = "select * from vehicles where clientID=" . $_SESSION['client_id'] . " and active='1' order by code";
    } Else {
        $sql_ = "select * from vehicles where active='1' and id in (select vehicleID from UserVehicles where userID=" . $_SESSION['user_id'] . ") order by code";
    }
		
    $dsVehicles = query($sql_);
    
    $registrations = "";
	
	while ($dr = pg_fetch_array($dsVehicles)) {  
        $registrations .= $dr["registration"] . " " . $dr["alias"] . " (" . $dr["code"] . ");";
    }

    $clientType = DlookUP("select clienttypeid from clients where id=" . $_SESSION['client_id']);
	
    If ($clientType <> 2) {
        If (intval($index) > 4) {
            $index = $index - 1;
        }
    }
   
?>
<body>
	
<table align = "center" style="padding-top: 15px">
    <tr>
        <td align="right" class="text5" style="font-size:12;"><?php dic("Reports.Report")?>: </td>
        <td align="left" class="text5" style="font-size:12;font-family:Arial, Helvetica, sans-serif;" colspan="3">
        <?php
       
            If ($_SESSION['role_id'] == "2") {
                $ind2 = $index;
				
                	
        ?>
            <select id="cbReports"  style="width:235px; font-size:12;font-family:Arial, Helvetica, sans-serif;" class="combobox text2" onchange="reportChange()">		
                     <?php
					
                    
                   
				?>
					<option value="overview" ><?php dic("Reports.Dashboard")?></option>
                    <option value="OverviewV" ><?php dic("Reports.Overview")?></option>
                    <option value="ShortReport" ><?php dic("Reports.ShortReport")?></option>
                    <option value="IdlingReport" ><?php dic("Reports.IdlingReport")?></option>
                  
                    <?php
                        If ($clientType == 2) {
                    ?>
                    <option value="TaxiReport"><?php dic("Reports.TaxiReport")?></option>
                    <?php
						}
                    ?>
                    <option value="VehiclePOI" ><?php dic("Reports.VisitedPOI")?></option>
					<option value="AnalDistance" ><?php dic("Reports.DistanceTravelled")?></option>
                    <option value="AnalActivity" ><?php dic("Reports.Aktivnost")?></option>
                    <option value="AnalSpeed" ><?php dic("Reports.MaxSpeed")?></option>
                    <option value="AnalSpeedEx" ><?php dic("Reports.SpeedLimitExcess")?></option>
                    <?php
                    $dsRep = query("select * from reportgenerator where userid=" . $_SESSION['user_id'] . " order by id asc");
                    while ($drRep = pg_fetch_array($dsRep)) {
                    ?>
                    	 <option value="CustomizedReport_<?php echo $drRep["id"]?>"><?php echo $drRep["name"]?></option>
                    <?	
                    }
                    ?>
				</select>
        <?php
        } Else {
           
            $Dashboard = "";
            $Overview = "";
            $ShortReport = "";
			$IdlingReport = "";
            $TaxiReport = "";
            $VisitedPointsOfInterest = "";
            $DistanceTravelled = "";
            $Activity = "";
            $MaxSpeed = "";
            $SpeedLimitExcess = "";
            $CustomizedReports = "";
                
            $ind1 = 0;
            $ind2 = $index;
                            
            $Dashboard = "<option value='Dashboard'>" . dic_("Reports.Dashboard") . "</option>";
            $Overview = "<option value='Overview'>" . dic_("Reports.Overview") . "</option>";
            $ShortReport = "<option value='ShortReport'>" . dic_("Reports.ShortReport") . "</option>";
            $IdlingReport = "<option value='IdlingReport'>" . dic_("Reports.IdlingReport") . "</option>";  
			   
            If ($clientType == 2) {
                $TaxiReport = "<option value='TaxiReport'>" . dic_("Reports.TaxiReport") . "</option>";
            }
                        
            $VisitedPointsOfInterest = "<option value='VisitedPointsOfInterest'>" . dic_("Reports.VisitedPOI") . "</option>";
            $DistanceTravelled = "<option value='DistanceTravelled'>" . dic_("Reports.DistanceTravelled") . "</option>";
            $Activity = "<option value='Activity'>" . dic_("Reports.Aktivnost") . "</option>";
            $MaxSpeed = "<option value='MaxSpeed'>" . dic_("Reports.MaxSpeed") . "</option>";
            $SpeedLimitExcess = "<option value='SpeedLimitExcess'>" . dic_("Reports.SpeedLimitExcess") . "</option>";
          
            $dsRep = query("select * from reportgenerator where userid=" . $_SESSION['user_id'] . " order by id asc");
            while ($drRep = pg_fetch_array($dsRep)) {
            	$CustomizedReports .=  "<option value='CustomizedReport_" . $drRep["id"] . "'>" . $drRep["name"] . "</option>";
            }
        ?>
                 <select id="cbReports"  style="width:235px; font-size:12;font-family:Arial, Helvetica, sans-serif;" class="combobox text2" onchange="reportChange()">		
                    <?php echo $Dashboard ?>
                    <?php echo $Overview ?>
                    <?php echo $ShortReport ?>
					<?php echo $IdlingReport ?>
					
                    <?php
                        If ($clientType == 2) {
                    ?>
                    <?php echo $TaxiReport ?>
                    <?php
                    	}
                    ?>

                    <?php echo $VisitedPointsOfInterest ?>
					<?php echo $DistanceTravelled ?>
                    <?php echo $Activity ?>
                    <?php echo $MaxSpeed ?>
                    <?php echo $SpeedLimitExcess ?>
                    <?php echo $CustomizedReports?>
				</select>
        <?php
           } //end if   
        ?>
        </td>
    </tr>


    <tr>
        <td align="right" class="text5" style="font-size:12;"><?php dic("Reports.Vehicle")?>: </td>
        <td align="left" class="text5" style="font-size:12;font-family:Arial, Helvetica, sans-serif;" colspan="3">
            <select id="cbVehicles" style="width:235px; font-size:12;font-family:Arial, Helvetica, sans-serif;" class="combobox text2">		
                    <?php
                   
                        //ako e taxi kompanija
                        If ($clientType == 2) {
                            If ($index == 0 Or $index == 1 Or $index == 7 Or $index == 8 Or $index == 9 Or $index == 10 Or $index > 10) {
                     ?>
                            <option value="0"><?php dic("Reports.AllVehicles")?></option>
                            <?php
							} Else {FleetReport
								?>
								<option value="0"><?php dic("Reports.AllVehicles")?></option>
								<?php
                                //$registrations = "";
								$dsVehicles = query($sql_);
								while ($dr = pg_fetch_array($dsVehicles)) {  
                                  
							?>
                            <option value="<?php echo $dr["registration"]?>"><?php echo $dr["registration"]?> <?php echo $dr["alias"]?> (<?php echo $dr["code"]?>)</option>
					<?php
                                } //end while
				
               		 } //end if
					//ako ne e taxi kompanija
                        } Else {
               				 If ($index == 0 Or $index == 1 Or $index == 6 Or $index == 7 Or $index == 8 Or $index == 9 Or $index > 9) {
                            ?>
                            <option value="0"><?php dic("Reports.AllVehicles")?></option>
                            <?php
							 } Else {
							 	?>
							 	<option value="0"><?php dic("Reports.AllVehicles")?></option>
							 	<?php
                                   //$registrations = "";
								   $dsVehicles = query($sql_);
								   while ($dr = pg_fetch_array($dsVehicles)) {                                    
							?>
                            <option value="<?php echo $dr["registration"]?>"><?php echo $dr["registration"]?> <?php echo $dr["alias"]?> (<?php echo $dr["code"]?>)</option>
					<?php
                                   } //end while
				
                               } //end ifFleetReport
                       } //end if
                       
                        ?>
				</select>
        </td>
    </tr>

     <tr>
        <td align="right" class="text5" style="font-size:12;"><?php dic("Reports.DateTimeRange")?>: </td>
        <td align="left" class="text5" style="font-size:12; font-family:Arial, Helvetica, sans-serif;" colspan="3">
        
        <select id="cbRange" style="width:235px; font-size:12;font-family:Arial, Helvetica, sans-serif;" class="combobox text2">
        	 <?php
					$vremeRazmerot = query("select * from scheduler where id=" . $idto);
					$pristignuvanjeto = explode(" ", pg_fetch_result($vremeRazmerot, 0, "range"));
					
					$z1 = "";
                    $z2 = "";
                    $z3 = "";
					$z4 = "";
					$z5 = "";
					
					If($pristignuvanjeto[0] == "Last1"){
                        $z1 = "selected='selected'";
					}
					If($pristignuvanjeto[0] == "Last3"){
                        $z3 = "selected='selected'";
					}
					If($pristignuvanjeto[0] == "Last4"){
                        $z4 = "selected='selected'";
					}
					If($pristignuvanjeto[0] == "Last5"){
                        $z5 = "selected='selected'";
					}
					
			    	?>
					<option value="Last1" <?php echo $z1?>><?php echo dic("Reports1.Day")?></option>
		            <option value="Last2" <?php echo $z2?>><?php echo dic("Reports2.Days")?></option>
		            <option value="Last3" <?php echo $z3?>><?php echo dic("Reports3.Days")?></option>
                    <option value="Last4" <?php echo $z4?>><?php echo dic("Reports4.Days")?></option>
                    <option value="Last5" <?php echo $z5?>><?php echo dic("Reports5.Days")?></option>
	    </td>
	    </tr>
		<tr>
			
        <td align="right" class="text5" style="font-size:12;"><?php dic("Reports.PeriodRec")?>: </td>
        <td align="left" class="text5" style="font-size:12;" colspan="3">
        <select id="cbPeriod" style="width:235px; font-size:12; font-family:Arial, Helvetica, sans-serif;" onchange="PeriodChange()" class="combobox text2">		
					
			<?php
			    	$pristignuvanje = explode(" ", pg_fetch_result($periodPris, 0, "period"));
                    $t1 = "";
                    $t2 = "";
                   
					If($pristignuvanje[0] == "Daily"){
                       $t1 = "selected='selected'";
					}
					If($pristignuvanje[0] == "Weekly"){
                        $t2 = "selected='selected'";
					}
				?>
					<option value="Daily" <?php echo $t1?>><?php echo dic("Reports.Daily")?></option>
		            <option value="Weekly" <?php echo $t2?>><?php echo dic("Reports.Weekly")?></option>
			</select>
        </td>
    </tr>
    <tr id="div-Day" style="display:none;">
        <td align="right" class="text5" style="font-size:12;"><?php dic("Reports.Day")?>: </td>
        <td align="left" class="text5" style="font-size:12;" colspan="3">
        	
            <select id="cbDay" style="width:235px; font-size:12; font-family:Arial, Helvetica, sans-serif;" class="combobox text2">	
            	<?php
            	$pristignuvanjeDen = explode(" ", pg_fetch_result($periodPris, 0, "day"));
                    $tt1 = "";
                    $tt2 = "";
					$tt3 = "";
                    $tt4 = "";
					$tt5 = "";
                    $tt6 = "";
                    $tt7 = "";
              
                    If($pristignuvanjeDen[0] == "Monday"){
                       $tt1 = "selected='selected'";
					}
					If($pristignuvanjeDen[0] == "Tuesday"){
                        $tt2 = "selected='selected'";
					}
					If($pristignuvanjeDen[0] == "Wednesday"){
                       $tt3 = "selected='selected'";
					}
					If($pristignuvanjeDen[0] == "Thursday"){
                        $tt4 = "selected='selected'";
					}
					If($pristignuvanjeDen[0] == "Friday"){
                       $tt5 = "selected='selected'";
					}
					If($pristignuvanjeDen[0] == "Saturday"){
                        $tt6 = "selected='selected'";
					}
					If($pristignuvanjeDen[0] == "Sunday"){
                       $tt7 = "selected='selected'";
					}
				?>	
				<option value="Monday" <?php echo $tt1?>><?php dic("Reports.Monday")?></option>
				<option value="Tuesday" <?php echo $tt2?>><?php dic("Reports.Tuesday")?></option>
                <option value="Wednesday" <?php echo $tt3?>><?php dic("Reports.Wednesday")?></option>
                <option value="Thursday" <?php echo $tt4?>><?php dic("Reports.Thursday")?></option>
                <option value="Friday" <?php echo $tt5?>><?php dic("Reports.Friday")?></option>
                <option value="Saturday" <?php echo $tt6?>><?php dic("Reports.Saturday")?></option>
                <option value="Sunday" <?php echo $tt7?>><?php dic("Reports.Sunday")?></option>
		    </select>
        </td>
     </tr>
     <tr id="div-Date" style="display:none;">
        <td align="right" class="text5" style="font-size:12;"><?php dic("Reports.Day")?>: </td>
        <td align="left" class="text5" style="width:200px; font-size:12;" colspan="3">
            <select id="cbDate1" style="width:235px; font-size:12;font-family:Arial, Helvetica, sans-serif;" class="combobox text2">
            <?php
                $br = 1;
                while($br <= 31) {
            ?>		
			<option value="<?php echo $br?>"><?php echo $br?></option>
            <?php
            	$br = $br + 1;
                }                
            ?>
		    </select>
        </td>
    </tr>
    <tr>
    <td align="right" class="text5" style="font-size:12;"><?php dic("Reports.RecTime")?>: </td>
    <td align="left" style="font-size:12; width:99px;" >
            <select id="cbTimeHours" style="width:99px; font-size:12;font-family:Arial, Helvetica, sans-serif;" class="combobox text2">		
					<?php
					$pristignuvanjeSaat = explode(" ", pg_fetch_result($periodPris, 0, "time"));
                    $ttx1 = "";
                    $ttx2 = "";
					$ttx3 = "";
                    $ttx4 = "";
					$ttx5 = "";
                    $ttx6 = "";
                    $ttx7 = "";
					$ttx8 = "";
                    $ttx9 = "";
					$ttx10 = "";
                    $ttx11 = "";
					$ttx12 = "";
                    $ttx13 = "";
                    $ttx14 = "";
					$ttx15 = "";
                    $ttx16 = "";
					$ttx17 = "";
                    $ttx18 = "";
					$ttx19 = "";
                    $ttx20 = "";
                    $ttx21 = "";
					$ttx22 = "";
                    $ttx23 = "";
                    $ttx24 = "";
              
                    If($pristignuvanjeSaat[0] == "01:00"){
                       $ttx1 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "02:00"){
                        $ttx2 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "03:00"){
                       $ttx3 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "04:00"){
                        $ttx4 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "05:00"){
                       $ttx5 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "06:00"){
                        $ttx6 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "07:00"){
                       $ttx7 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "08:00"){
                       $ttx8 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "09:00"){
                        $ttx9 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "10:00"){
                       $ttx10 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "11:00"){
                       $ttx11 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "12:00"){
                       $ttx12 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "13:00"){
                        $ttx13 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "14:00"){
                       $ttx14 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "15:00"){
                       $ttx15 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "16:00"){
                       $ttx16 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "17:00"){
                       $ttx17 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "18:00"){
                       $ttx18 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "19:00"){
                       $ttx19 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "20:00"){
                       $ttx20 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "21:00"){
                       $ttx21 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "22:00"){
                       $ttx22 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "23:00"){
                       $ttx23 = "selected='selected'";
					}
					If($pristignuvanjeSaat[0] == "24:00"){
                       $ttx24 = "selected='selected'";
					}
				?>	
				<option value="01:00" <?php echo $ttx1?>>01:00</option>
				<option value="02:00" <?php echo $ttx2?>>02:00</option>
                <option value="03:00" <?php echo $ttx3?>>03:00</option>
                <option value="04:00" <?php echo $ttx4?>>04:00</option>
                <option value="05:00" <?php echo $ttx5?>>05:00</option>
                <option value="06:00" <?php echo $ttx6?>>06:00</option>
                <option value="07:00" <?php echo $ttx7?>>07:00</option>
                <option value="08:00" <?php echo $ttx8?>>08:00</option>
				<option value="09:00" <?php echo $ttx9?>>09:00</option>
                <option value="10:00" <?php echo $ttx10?>>10:00</option>
                <option value="11:00" <?php echo $ttx11?>>11:00</option>
                <option value="12:00" <?php echo $ttx12?>>12:00</option>
                <option value="13:00" <?php echo $ttx13?>>13:00</option>
                <option value="14:00" <?php echo $ttx14?>>14:00</option>
                <option value="15:00" <?php echo $ttx15?>>15:00</option>
				<option value="16:00" <?php echo $ttx16?>>16:00</option>
                <option value="17:00" <?php echo $ttx17?>>17:00</option>
                <option value="18:00" <?php echo $ttx18?>>18:00</option>
                <option value="19:00" <?php echo $ttx19?>>19:00</option>
                <option value="20:00" <?php echo $ttx20?>>20:00</option>
                <option value="21:00" <?php echo $ttx21?>>21:00</option>
                <option value="22:00" <?php echo $ttx22?>>22:00</option>
                <option value="23:00" <?php echo $ttx23?>>23:00</option>
                <option value="24:00" <?php echo $ttx24?>>24:00</option>
			</select>
        </td>
    </tr>
    <tr>
        <td align="right" class="text5" style="font-size:12; vertical-align:top" ><div style="position:relative; top:5px"><?php dic("Reports.Email")?>:</div> </td>
        <td align="left" class="text5" style="width:200px; font-size:12;" colspan="3">
            <div id="div-email">
            <?php
            	$role = $_SESSION['role_id'];
            	$email = DlookUP("select email from scheduler where id=" . $idto);
            ?>
            <input type="checkbox" checked="checked" id="cb_<?php echo $_SESSION['user_id']?>" alt="<?php echo $_SESSION['user_id']?>" style="display:none" />
            <input type="text" style="width:235;" id="email" class="textboxcalender corner5 text3" value="<?php echo nnull($email, "/") ?>" /></p>
            <script>$('#email_<?php echo $_SESSION['user_id'] ?>').text();</script>

      		<div id="sNote" style="position:relative; top:-10px; color:red; width:235px; font-size:10px">
         		  <?php dic("Reports.SchNote")?>
            </div>       
            </div>
        </td>
    </tr>
	<tr>
		<td align="right" class="text5" style="font-size:12; vertical-align:top" ><div style="position:relative; top:5px"><?php echo dic("Settings.DocumentType")?>:</div> </td>
		<td class="text5">
			 <?php
			 		$tipDokument = query("select * from scheduler where id=" . $idto);
                    $dokument = pg_fetch_result($tipDokument, 0, "doctype"); 
                    $pdf = "";
					$excel = "";
                    If($dokument == "pdf"){
                        $pdf = "checked";
                    }
					if($dokument == "xls")
                    {
                        $excel = "checked";
					}
			?>
		    <input type="radio" name="doc" value="pdf" id = "pdf" <?php echo $pdf?> />PDF
			<input type="radio" name="doc" value="xls" id = "excel" <?php echo $excel?> style="margin-left:20px"/>Excel
        </td>
	</tr>
<?php
	 closedb();
?>
</table>
</body>
</html>
<script type="text/javascript">
//    $('#cbReports').combobox();
//    $('#cbVehicles').combobox();
//    $('#cbPeriod').combobox();
//    $('#cbDay').combobox();
//    $('#cbDate').combobox();
//    $('#cbTimeHours').combobox();
//    $('#cbTimeHours').css('width','50px');
//    $('#cbTimeMinutes').combobox();
//    $('#cbTimeMinutes').css('width','50px');

    if (document.getElementById('cbReports')) { 
        document.getElementById('cbReports').selectedIndex = '<?php echo $ind2 ?>';
    }

	if ('<?php echo $tipI?>' == "CustomizedReport") {
		$('#cbReports').val('<?php echo $tipI?>_' + '<?php echo $repid?>');
	} else {
		$('#cbReports').val('<?php echo $tipI?>');
	}

 reportChange();
 $('#cbVehicles').val('<?php echo $selVehVal?>');
 PeriodChange();

function PeriodChange() {
    var per = $('#cbPeriod').val()
    if (per == "Weekly") {
        document.getElementById('div-Day').style.display = '';
        document.getElementById('div-Date').style.display = 'none';
    } 
    if (per == "Monthly") {
        document.getElementById('div-Date').style.display = '';
        document.getElementById('div-Day').style.display = 'none';
    }
    if (per == "Daily") {
        document.getElementById('div-Day').style.display = 'none';
        document.getElementById('div-Date').style.display = 'none';
    }
}

function reportChange() {

    var ind = document.getElementById('cbReports').selectedIndex;

    //ako e taxi kompanija
    
    if(<?php echo $clientType ?> == 2) {
    if (ind == 0|| ind == 6 || ind == 7 || ind == 8 || ind == 9) {
        document.getElementById('cbVehicles').innerHTML = "<option value='0'><?php dic("Reports.AllVehicles")?></option>";
       
    }
    else {
       var htmlText = "<option value='0'><?php dic("Reports.AllVehicles")?></option>" 	
       var registrations = '<?php echo $registrations ?>'.split(";");
       for (var i = 0; i < registrations.length - 1; i++) {
        var reg = registrations[i];
        htmlText += "<option value='" + reg + "'>" + reg + "</option>";
       }
        document.getElementById('cbVehicles').innerHTML = htmlText;
	 if (ind > 9) document.getElementById('cbVehicles').selectedIndex = 0;
		    else document.getElementById('cbVehicles').selectedIndex = 1;
    }


    }
    //ako ne e taxi kompanija
    else {
        if (ind == 0  || ind == 5 || ind == 6 || ind == 7 || ind == 8) {
        document.getElementById('cbVehicles').innerHTML = "<option value='0'><?php dic("Reports.AllVehicles")?></option>";
       
    }
    else {
       var htmlText = "<option value='0'><?php dic("Reports.AllVehicles")?></option>"	
       var registrations = '<?php echo $registrations ?>'.split(";");
       for (var i = 0; i < registrations.length - 1; i++) {
        var reg = registrations[i];
        htmlText += "<option value='" + reg + "'>" + reg + "</option>";
       }
        document.getElementById('cbVehicles').innerHTML = htmlText;

        if (ind > 8) document.getElementById('cbVehicles').selectedIndex = 0;
	        else document.getElementById('cbVehicles').selectedIndex = 1;
    }

  

    }
    

}
</script>
