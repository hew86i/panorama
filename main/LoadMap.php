<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 

	$tpoint = getQUERY("tpoint");

	header("Content-type: text/html; charset=utf-8");
	if (session('user_id') == "261") echo header( 'Location: ' . $tpoint . '/sessionexpired/?l='.$cLang);
?>
 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
	<script type="text/javascript">
		lang = '<?php echo $cLang?>';
	</script>

	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">	

	
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="livelite.js"></script>
    
	
	<script type="text/javascript" src="../js/OpenLayers.js"></script>
    <!--Marjan-->

	<style>
		#div-menu {
		position:relative;
		z-index:1;
		height:200px;        /* Desired element height */
		}
	</style>

<?php
    
    //$cLang = Request.QueryString("l").Split("?")(0)
	$dat = getQUERY("datetime");
	$reg = getQUERY("reg");
	$type = getQUERY("type");
	$num = getQUERY("num");
    opendb();
    $DefMap = nnull(dlookup("select defaultmap from users where id=".session("user_id")),1);
    if($DefMap == "GOOGLEM")
	{
		?>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<?php
	}
    $ClientTypeID = dlookup("select clienttypeid from clients where id=".session("client_id"));
	
	$sqlStyles = "";
	$sqlStyles .= "SELECT c1.name engineon, c2.name engineoff, c3.name engineoffpassengeron, c4.name satelliteoff, c5.name taximeteron, c6.name taximeteroffpassengeron, c7.name passiveon, c8.name activeoff ";
	$sqlStyles .= "from users us ";
	$sqlStyles .= "left outer join statuscolors c1 on c1.id=us.engineon ";
	$sqlStyles .= "left outer join statuscolors c2 on c2.id=us.engineoff ";
	$sqlStyles .= "left outer join statuscolors c3 on c3.id=us.engineoffpassengeron ";
	$sqlStyles .= "left outer join statuscolors c4 on c4.id=us.satelliteoff ";
	$sqlStyles .= "left outer join statuscolors c5 on c5.id=us.taximeteron ";
	$sqlStyles .= "left outer join statuscolors c6 on c6.id=us.taximeteroffpassengeron ";
	$sqlStyles .= "left outer join statuscolors c7 on c7.id=us.passiveon ";
	$sqlStyles .= "left outer join statuscolors c8 on c8.id=us.activeoff ";
	$sqlStyles .= "where us.id=" . session("user_id");
	$dsStyles = query($sqlStyles);
	
	$vehID = dlookup("select id from vehicles where registration='" . $reg . "'");
	
	$driver = dlookup("select getdrivernew1('" . $dat . "','" . $dat . "'," . $vehID . ")");
	//echo $driver;
	//exit;
	
	$cntIgn = dlookup("select count(portname) from vehicleport where vehicleid=" . $vehID . " and porttypeid=1");
	if($cntIgn == 0)
		$ign = "di1";
	else	
		$ign = dlookup("select portname from vehicleport where vehicleid=" . $vehID . " and porttypeid=1");
	
	$sql_ = "";
	$sql_ .= "select cast(v.code as integer), v.registration, '1' sedista, hl.* ";
	$sql_ .= "from historylog hl ";
	$sql_ .= "left outer join vehicles v on v.id=hl.vehicleid ";
	$sql_ .= "where hl.datetime='" . $dat . "' and hl.vehicleid=" . $vehID;
	$sql_ .= "union ";
	$sql_ .= "select cast(v.code as integer), v.registration, '1' sedista, hl.* ";
	$sql_ .= "from historylogmotoroff hl ";
	$sql_ .= "left outer join vehicles v on v.id=hl.vehicleid ";
	$sql_ .= "where hl.datetime='" . $dat . "' and hl.vehicleid=" . $vehID;
	//$strLM = "select status, latitude, longitude, speed, " . $ign . " ignition, location, poinames, poiids from historylog where datetime='" . $dat . "' and vehicleid=" . $vehID;
	$dsH = query($sql_);
	//echo "select status, latitude, longitude, speed, " . $ign . " ignition, location, poinames, poiids from historylog where datetime='" . $dat . "' and vehicleid=" . $vehID;
	//exit;
	
	$status = pg_fetch_result($dsH, 0, "status");
	$speed = pg_fetch_result($dsH, 0, "speed");
	$sedista = pg_fetch_result($dsH, 0, "sedista");
	$location = pg_fetch_result($dsH, 0, "location");
	$poiname = pg_fetch_result($dsH, 0, "poinames");
	$poiids = pg_fetch_result($dsH, 0, "poiids");
	$ignition = pg_fetch_result($dsH, 0, $ign);
	$sLon = pg_fetch_result($dsH, 0, "longitude");
	$sLat = pg_fetch_result($dsH, 0, "latitude");
	
	$tzone = nnull(dlookup("select timezone from users where id=".session("user_id")),1);
	$tzone = $tzone - 1;
	$DFormat1 = "dd-MM-yyyy"; //nnull(dlookup("select DateFormat from usersettings where userid=" . session("user_id")),"dd-MM-yyyy");
	$TFormat1 = "24 Hour Time"; //nnull(dlookup("select TimeFormat from usersettings where userid=" . session("user_id")),"24 Hour Time");
	$TFormat = "";
	$DFormat = "";
	if($DFormat1 == "dd-MM-yyyy")
		$DFormat = "d-m-Y";
	else
		if($DFormat1 == "yyyy-MM-dd")
			$DFormat = "Y-m-d";
		else
			$DFormat = "m-d-Y";

	if($TFormat1 == "24 Hour Time")
		$TFormat = "H:i:s";
	else
		$TFormat = "h:i:s A";
	$DTFormat = $DFormat . " " . $TFormat;

    
    $dbDatum = DlookUP("select now() DateTime");
	
	$position = "";
	$stil = "";
	$oldDate = "0";
	if(abs(strtotime(pg_fetch_result($dsH, 0, "datetime")) - strtotime($dbDatum))>60) 
	{
		$oldDate = "1";
	}
	$address = dlookup("select latloninarea(" . $sLat . ", " . $sLon . ", " . session("client_id") . ")");
	$alarm = pg_fetch_result($dsH, 0, "text");
	if($ClientTypeID == 2)
	{
		$pass = "0";
		$tax = "1";
		if($ignition."" == "1") $stil = pg_fetch_result($dsStyles, 0, "EngineON");
		if($ignition."" == "0") $stil = pg_fetch_result($dsStyles, 0, "EngineOFF");
		if($status == "0") $stil = pg_fetch_result($dsStyles, 0, "SatelliteOFF");
	} else {
		$pass = "0";
		$tax = "0";
		if($ignition."" == "1") $stil = pg_fetch_result($dsStyles, 0, "EngineON");
		if($ignition."" == "0") $stil = pg_fetch_result($dsStyles, 0, "EngineOFF");
		if($status == "0") $stil = pg_fetch_result($dsStyles, 0, "SatelliteOFF");
	}
	//echo $status;
	//exit;
	$position .= "#" . pg_fetch_result($dsH, 0, "code") . "|" . $sLon . "|" . $sLat . "|" . $stil . "|" . $pass . "|" . date($DTFormat, strtotime(pg_fetch_result($dsH, 0, "datetime") .' '.$tzone.' hour')) . "|" . $poiname . "|" . intval($speed) . "|" . $tax . "|" . $sedista . "|" . $oldDate . "|"  . $address . "|" . $location . "|" . $reg ."|". $alarm;

	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	if($yourbrowser == "1")
		$he = '400px;';
	else
		$he = '632px;';
	
	$dtTmp = new Datetime($dat);
	$dtTmp = $dtTmp->format("H:i:s d-m-Y");
	$zonename = "";
 	$zoneid = '';
	$zonecolor = '';
	if($type == "enterZone")
	{
		$zoneds = query("select poi.name, poi.id, poig.fillcolor from tempzone tz left join pointsofinterest poi on tz.zoneid=poi.id left join pointsofinterestgroups poig on poi.groupid=poig.id where tz.datetimein='" . $dat . "' and tz.vehid=" . $vehID . " and tz.inoutzone='1'");
		$zonename = pg_fetch_result($zoneds, 0, "name");
		$zoneid = pg_fetch_result($zoneds, 0, "id");
		$zonecolor = pg_fetch_result($zoneds, 0, "fillcolor");
	}
	if($type == "leaveZone")
	{
		$zoneds = query("select poi.name, poi.id, poig.fillcolor from tempzone tz left join pointsofinterest poi on tz.zoneid=poi.id left join pointsofinterestgroups poig on poi.groupid=poig.id where tz.datetimeout='" . $dat . "' and tz.vehid=" . $vehID . " and tz.inoutzone='0'");
		$zonename = pg_fetch_result($zoneds, 0, "name");
		$zoneid = pg_fetch_result($zoneds, 0, "id");
		$zonecolor = pg_fetch_result($zoneds, 0, "fillcolor");
	}
	if($type == "fueldown")
	{
		$fuelcalc = dlookup("select fueldown from alarmshistory where vehicleid=" . $vehID . " and datetime='" . $dat . "'");
		$fuelparams = explode('|', $fuelcalc);
	}
?>

<body>
<table id="live-table" width="100%" border="0" cellpadding="0" cellspacing="0" style="position: relative;">
	<tr>
		<td id="vehicle-list" width="250px" valign="top">
			<div id="div-menu" style="width:100%; overflow-x:hidden; position: relative;">
				
					<div id="menu-1" class="menu-container" style="width:100%; height: auto; border-top: 1px solid #BBBBBB;">
						<a id="menu-title-1" class="menu-titleAlarm text3" style="width:100%;"><?php echo dic_("Tracking.AlarmType")?></a>
						<div id="menu-container-1" style="width:230px; padding-left:10px; padding-top:10px; overflow:auto">
							<div class="Text5">
								<?php echo dic($type)?>
								<br/>
								<?php echo $zonename?>
								<?php
								if($type == 'fueldown') {
									$dtTmpStart = new Datetime($fuelparams[1]);
									$dtTmpStart = $dtTmpStart->format("H:i:s d-m-Y");
									echo '<br>Почеток: ' . $dtTmpStart . ' - ' . $fuelparams[0] . ' L<br>';
									echo 'Крај: ' . $dtTmp . ' - ' . $fuelparams[2] . ' L<br><br>';
									echo 'Пад на гориво: ' . ($fuelparams[0] - $fuelparams[2]) . ' L';
								}
								?>
							</div>&nbsp;
						</div>
					</div>
					<div id="menu-2" class="menu-container" style="width:100%;">
						<a id="menu-title-2" class="menu-titleAlarm text3" style="width:100%;"><?php echo dic_("Tracking.BasicInformation")?></a>
						<div id="menu-container-2" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
							<div class="Text5">
								<table class="Text5" cellpadding="0" cellspacing="0" border="0">
									<tr style="height: 25px;"><td width="90px"><?php echo dic_("Tracking.Date")?>:</td><td width="150px"><?php echo $dtTmp?></td></tr>
									<?php 
						            if($ClientTypeID != "3" && $ClientTypeID != "7") { 
						        	?>
									<tr style="height: 25px;"><td><?php echo dic_("Tracking.Registration")?>:</td><td><?php echo $reg?></td></tr>
									<tr style="height: 25px;"><td><?php echo dic_("Tracking.Driver")?>(i):</td><td><?php if($driver != ''){ echo $driver; } else { echo '/'; }?></td></tr>
									<tr style="height: 25px;"><td><?php echo dic_("Tracking.Speed")?>:</td><td><?php echo intval($speed)?> km/h</td></tr>
									<tr style="height: 25px;"><td><?php echo dic_("Tracking.Engine")?>:</td><td><?php if($ignition == '1'){ echo dic_("Tracking.On"); } else { echo dic_("Tracking.Off"); }?></td></tr>
									<?php
									} else { ?>
										<tr style="height: 25px;"><td><?php echo dic_("person")?>:</td><td><?php echo $reg?></td></tr>
									<?php }
									?>
									<tr style="height: 25px;"><td><?php echo dic_("Tracking.Street")?>:</td><td><?php echo $location?></td></tr>
									<tr style="height: 25px;"><td><?php echo dic_("Tracking.POI")?>:</td><td><?php if($poiname != ''){ echo $poiname; } else { echo '/'; } ?></td></tr>
									<tr style="height: 25px;"><td><?php echo dic_("Tracking.geofence")?>:</td><td><?php if($address != ''){ echo $address; } else { echo '/'; }?></td></tr>
								</table>
							</div>&nbsp;
						</div>
					</div>
					<div id="menu-3" class="menu-container" style="width:100%;">
						<a id="menu-title-3" class="menu-titleAlarm text3" style="width:100%;"><?php echo dic_("Tracking.Note")?></a>
						<div id="menu-container-3" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
							<div>
								<textarea id="alarmZabeleska" style="border-style: solid; width: 225px; padding: 5px; height: 100px; font-family: arial; font-size: 12px;"></textarea>
							</div>
						</div>
					</div>
				</div>
			
			<div id="closeAlert" style="position: relative; top: 20px; left: 5px;" onclick="closeAlarmWindow()"><?php echo dic_("Tracking.Close")?></div>
			<div id="cancelAlert" style="position: relative; top: 20px; left: 16px;" onclick="closeAlarmWindow1()"><?php echo dic_("Tracking.Cancel")?></div>
				<script>
					$('#closeAlert').button();
					$('#cancelAlert').button();
				</script>
            <!--div id="race-img" style="position:absolute; left: 250px; width:8px; height:50px; background-image:url(../images/racelive.png); background-position: -8px 0px; z-index: 2000; cursor:pointer" onClick="shleft()"></div-->
		</td>
		<td id="maps-container" valign="top" style="border-left: 2px Solid #387cb0"><!--groletna.aspx?t=2-->
			<div id="div-map"></div>
		</td>
	</tr>
</table>

</div>
<!--Marjan-->
    

<div id="icon-legenda" style="position: relative; cursor: help; float: right; z-index: 3000; margin-right: 10px;"><img src="<?php echo $tpoint?>/images/legenda.png" border="0" align="absmiddle" /></div>

<div id="dialog-message" title="<?php echo dic("Tracking.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAll" style="font-size:11px; padding-left: 23px;"><input id="InfoForAll" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?></div>
</div>

</body>
<?php

	$sqlStyles = "";
	
	$sqlStyles .= "SELECT c1.name engineon, c2.name engineoff, c3.name engineoffpassengeron, c4.name satelliteoff, c5.name taximeteron, c6.name taximeteroffpassengeron, c7.name passiveon, c8.name activeoff ";
	$sqlStyles .= "from users us ";
	$sqlStyles .= "left outer join statuscolors c1 on c1.id=us.engineon ";
	$sqlStyles .= "left outer join statuscolors c2 on c2.id=us.engineoff ";
	$sqlStyles .= "left outer join statuscolors c3 on c3.id=us.engineoffpassengeron ";
	$sqlStyles .= "left outer join statuscolors c4 on c4.id=us.satelliteoff ";
	$sqlStyles .= "left outer join statuscolors c5 on c5.id=us.taximeteron ";
	$sqlStyles .= "left outer join statuscolors c6 on c6.id=us.taximeteroffpassengeron ";
	$sqlStyles .= "left outer join statuscolors c7 on c7.id=us.passiveon ";
	$sqlStyles .= "left outer join statuscolors c8 on c8.id=us.activeoff ";
	$sqlStyles .= "where us.id=".session("user_id");
	
	
	$dsSt = query($sqlStyles);

?>
</html>


<script type="text/javascript">
   var lang = '<?php echo $cLang ?>';
   
   $('#alarmZabeleska').focus();
   
   //$('#alarmZabeleska').on('touchstart', function (event) {
	    //event.preventDefault(); //should prevent the hop
	    // rest of your code goes here
	//});
	//new iScroll(document.getElementById('scroller'));
    //$('#div-mainalerts').css({ height: (document.body.clientHeight - 75) + 'px' });
    //window.onload = function() { setTimeout(function(){ new iScroll(document.getElementById('scroller')) }, 100) };
    //$('#race-img').css({ top: (document.body.clientHeight / 2 - 35) + 'px' });
    
    //Marjan

	legendStr = '<table border="0" cellpadding="0" cellspacing="0" width="200px">'
	legendStr = legendStr + '<tr><td width="20px" height="20px" colspan="2" class="text3"><?php echo dic("Tracking.Legend")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOn")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineOFF")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOff")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><img style="height: 14px; width: 14px; top: 0px; position: relative; left: 0px;" src="../images/nosignal.png"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.LowSat")?></td></tr>'
	var CTUD = '<?php echo $ClientTypeID ?>';
    
    if(parseInt(CTUD, 10) == 2)
    {
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineOFFPassengerON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOffPassOn")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "TaximeterON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.Engaged")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "TaximeterOFFPassengerON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.TaxOffPassOn")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "PassiveON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.TaxOn")?></td></tr>'
	}
	legendStr = legendStr + '</table>'

	
	var _dt = '<?php echo $dat?>';
	var _reg = '<?php echo $reg?>';
	var _type = '<?php echo $type?>';
	var _vehid = '<?php echo $vehID?>';
	var _num = '<?php echo $num?>';
	
    StartLat = '<?php echo $sLat?>';
    StartLon = '<?php echo $sLon?>';
    Position = '<?php echo $position?>';
    ParseCarStrFirst();
	ParseCarStr(Position);
    //var _userId = '506';
	setLiveHeightAlarm();

    DefMapType = '<?php echo $DefMap?>'
    
    var zoneid = '<?php echo $zoneid?>';
    var zonecolor = '<?php echo $zonecolor?>';
    
    OpenForDrawing = true;
    LoadCurrentPosition = false;
    ShowVehiclesMenu = false;
    
    CreateBoards()

    LoadMaps();
    
    //LoadPOIbyID('217190');
	if(_type == "enterZone" || _type == "leaveZone")
		PleaseDrawArea(zoneid, zonecolor);

</script>
