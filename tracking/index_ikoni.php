<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo dic("Reports.PanoramaGPS")?></title>
	<link rel="stylesheet" type="text/css" href="styleGM.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../rstyle.css">
	<script src="../amcharts/amcharts.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../amcharts/style.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">
    <link rel="stylesheet" href="mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />

<style type="text/css">
<!--

#top1 {position:absolute; left:220px; top:0px; width:80%; height:5px; border:0px solid #000000; z-index:9997}

#topmiddle {position:relative; float:left; left:0px; top:0px; width:100%; height:5px; border:0px solid #000000}
#topmiddle1 {position:relative; left:0px; top:0px; width:100%; height:1px; border-left:1px solid #cfcfd1; border-right:1px solid #cfcfd1; background-color:#FFFFFF;}
#topmiddle2 {position:relative; left:0px; top:0px; width:100%; height:14px;  background-image:URL(../images/topback.png)}
#strelkatop {position:relative; left:50%; top:0px; width:51px; height:14px; background-image:url(../images/dolus.png); z-index:5999; cursor:pointer}


.no-close .ui-dialog-titlebar-close {
    display: none;
}

-->
</style>

	<LINK REL="SHORTCUT ICON" HREF="../images/icon.ico">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script src="../js/jquery.json-2.2.min.js"></script>
	<script src="../js/jquery.websocket-0.0.1.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/md5.js"></script>
	
	<script type="text/javascript" src="./live.js"></script>
	<script type="text/javascript" src="./live1.js"></script>
	<script type="text/javascript" src="../main/main.js"></script>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script type="text/javascript" src="./mlColorPicker.js"></script>
	<script type="text/javascript" src="../js/OpenLayers.js"></script>
	<script src="../js/jsxcompressor.js"></script>
	
	<script type="text/javascript" src="../js/jquery.collapsible.js"></script>
	<script src="../js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="newchartOneVeh24h.js"></script>
	
</head>

<?php
	set_time_limit(0);
	if (session('user_id') == "261" or session('user_id') == "779" or session('user_id') == "780" or session('user_id') == "781" or session('user_id') == "776" or session('user_id') == "777" or session('user_id') == "782" or session('user_id') == "778") echo header('Location: ../sessionexpired/?l='.$cLang);
	//Ispituvame dali ima najaven korisnik. Ako nema mora da se odi na Login
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	opendb();
	
	$Allow = getPriv("livetracking", session("user_id"));
	if ($Allow==FALSE) {echo header( 'Location: ../?l='.$cLang."&err=permission");}
	
	$SaveSettings = FALSE;
	$sql_ = "";
	$sqlV = "";
	if ($_SESSION['role_id'] == "2") {
		$sql_ = "select * from vehicles where id in (select id from vehicles where clientID=" . session("client_id") .  ") order by code asc";
		$sqlV = "select id from vehicles where clientID=" . session("client_id") ;
		$allowgarmin = dlookup("select count(*) from vehicles where clientid=" . session("client_id") . " and allowgarmin='1'");
	} else {
		$sql_ = "select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") order by code asc";
		$sqlV = "select vehicleID from uservehicles where userID=" . session("user_id") . "" ;
		$allowgarmin = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and allowgarmin='1'");
	}
    $firstVehId = pg_fetch_result(query($sql_), 0, "id");
    
	$check = query("select chechVehicles(" . session("client_id") . ")");
	$strVhList = "";
	$strVhListID = "";
	$strVhListOEID = "";
	$strVhListOENum = "";
	$strVhListOEName = "";
	$strVhListNotOENum = "";
	$strVhListNotOEName = "";
	
	$strVehcileID = "";
	
	$dsVehicles = query("select cast(code as integer), registration, organisationid, id from vehicles where id in (".$sqlV.") order by code");
	
	while($row = pg_fetch_array($dsVehicles))
	{
		$strVehcileID .= ",".$row["id"];
		$strVhList .= ", '(<strong>".$row["code"]."</strong>)&nbsp;&nbsp;".trim($row["registration"]," ")."'";
		$strVhListID .= ", ".$row["code"];
		$strVhListOEID .= ", ".$row["organisationid"];
		if($row["organisationid"] == "0")
		{
			$strVhListNotOEName .= ", '(<strong>".$row["code"]."</strong>)&nbsp;&nbsp;".trim($row["registration"]," ")."'";
			$strVhListNotOENum .= ", ".$row["code"];
		}
	}
	
	if (strlen($strVehcileID)>0) {
		$strVehcileID = substr($strVehcileID,1);	
	}
	
	$strVhList = substr($strVhList,1);
	$strVhListID = substr($strVhListID,1);
	$strVhListOEID = substr($strVhListOEID,1);
	$strVhListNotOEName = substr($strVhListNotOEName,1);
	$strVhListNotOENum = substr($strVhListNotOENum,1);
	
	$dsVehiclesOE = query("select id,name from organisation where id in (select organisationid from vehicles where id in (" . $sqlV . ") group by organisationid)");
	while($row = pg_fetch_array($dsVehiclesOE))
	{
		$strVhListOENum .= ", ".$row["id"];
		$strVhListOEName .= ",".$row["name"];
	}
	$strVhListOENum = substr($strVhListOENum,1);
	$strVhListOEName = substr($strVhListOEName,1);

	$dsStartLL = query("select * from cities where id = (select cityid from clients where id=".session("client_id")." limit 1)");

	$sLon = "21.432767";
	$sLat = "41.996434";
	if (pg_num_rows($dsStartLL) > 0 ) {
		$sLon = pg_fetch_result($dsStartLL, 0, 'longitude');
		$sLat = pg_fetch_result($dsStartLL, 0, 'latitude');
	}
	
	$CPosition = GetCurrentPosition(session("role_id"), session("client_id"), session("user_id"));
	
	$dsTraceSnooze = query("select trace, snooze, metric, weather, liquidunit, tempunit, numdelimiter from users where id=" . session("user_id"));
	$trace = pg_fetch_result($dsTraceSnooze, 0, "trace");
	$snooze = pg_fetch_result($dsTraceSnooze, 0, "snooze");
	$metric = pg_fetch_result($dsTraceSnooze, 0, "metric");
	if ($metric == 'mi') $valueM = 1.0936;
	else $valueM = 1;
	$numdelimiter = pg_fetch_result($dsTraceSnooze, 0, "numdelimiter");
	$weather = pg_fetch_result($dsTraceSnooze, 0, "weather");
	$liquidunit = pg_fetch_result($dsTraceSnooze, 0, "liquidunit");
	$tempunit = pg_fetch_result($dsTraceSnooze, 0, "tempunit");
	
	//$ClientTypeID = dlookup("select clienttypeid from clients where id=".session("client_id"));
	//$allowedrouting = dlookup("select allowedrouting from clients where id=".session("client_id"));
	$ds = query("select allowedrouting, allowedfm, allowedmess, allowedalarms, clienttypeid from clients where id=" . session("client_id"));
	$ClientTypeID = pg_fetch_result($ds, 0, "clienttypeid");
	$allowedrouting = pg_fetch_result($ds, 0, "allowedrouting");
	$allowedFM = pg_fetch_result($ds, 0, "allowedfm");
	$allowedMess = pg_fetch_result($ds, 0, "allowedmess");
	$allowedAlarms = pg_fetch_result($ds, 0, "allowedalarms");
	$fm = '';
	$fm1 = '';
	$routes = '';
	$routes1 = '';
	$tv = '';
	$tv1 = '';
	$mess = '';
	$mess1 = '';
	$al = '';
	$al1 = '';
	$al2 = '';
	if(true)
	{
		$tv = 'return false;';
		$tv1 = 'opacity: 0.4;';
	}
	if(!$allowedFM)
	{
		$fm = 'return false;';
		$fm1 = 'opacity: 0.4;';
	}
	if(!$allowedrouting)
	{
		$routes = 'return false;';
		$routes1 = 'opacity: 0.4;';
	}
	if(!$allowedMess)
	{
		$mess = 'return false;';
		$mess1 = 'opacity: 0.4;';
	}
	if(!$allowedAlarms)
	{
		$al = 'return false;';
		$al1 = 'opacity: 0.4;';
		$al2 = 'display: none;';
	}
	//echo $allowedrouting;
	//exit;
	$allPOI = dlookup("select count(*) from pointsofinterest where active='1' and clientId=".session("client_id"));
	$allPOIs = "false";
	if ($allPOI<1000) {$allPOIs = "true";};
	
	$DefMap = nnull(dlookup("select defaultmap from users where id=".session("user_id")),1);

	/*if ($DefMap==1){$DefMap="GOOGLEM";};
	if ($DefMap==2){$DefMap="OSMM";};
	if ($DefMap==3){$DefMap="BINGM";};
	if ($DefMap==4){$DefMap="YAHOOM";};
	if ($DefMap==5){$DefMap="GOOGLES";};*/
	
	/*$dsAllMaps = query("select AMapsGoogle, AMapsOMS, AMapsBing, AMapsYahoo, Satellite from usersettings where userID=".session("user_id"));
	$AllowedMaps = "";
	
	if (odbc_num_rows($dsAllMaps)>0){
		if (nnull(odbc_result($dsAllMaps,"AMapsGoogle"),1)==1) {$AllowedMaps .= "1";} else {$AllowedMaps .= "0";};
		if (nnull(odbc_result($dsAllMaps,"AMapsOMS"),1)==1) {$AllowedMaps .= "1";} else {$AllowedMaps .= "0";};
		if (nnull(odbc_result($dsAllMaps,"AMapsBing"),1)==1) {$AllowedMaps .= "1";} else {$AllowedMaps .= "0";};
		if (nnull(odbc_result($dsAllMaps,"AMapsYahoo"),1)==1) {
			$AllowedMaps .= "1";
			echo "<script src=\"http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=euzuro-openlayers\"></script>";
		} else {
			$AllowedMaps .= "0";
		};
		if (nnull(odbc_result($dsAllMaps,"Satellite"),1)==1) {$AllowedMaps .= "1";} else {$AllowedMaps .= "0";};
	} else {*/
		$AllowedMaps = "11111";	
	//}
	//echo $AllowedMaps;
	
	$AllowAddPoi = getPriv("AddPOI", session("user_id"));
	$AllowViewPoi = getPriv("ViewPOI", session("user_id"));
	$AllowAddZone = getPriv("AddZones", session("user_id"));
	$AllowViewZone = getPriv("ViewZones", session("user_id"));
	
   	$cntz = dlookup("select count(*) from pointsofinterest where active='1' and type=2 and clientid=".session("client_id"));
	
	$dsFormats = query("select timezone, datetimeformat from users where id=" . session("user_id"));
	$TimeZone = pg_fetch_result($dsFormats, 0, 'timezone');
	$FormatDT = pg_fetch_result($dsFormats, 0, 'datetimeformat');
	$FormatDT1 = explode(" ", $FormatDT);
	$dateformat = $FormatDT1[0];
	$timeformat1 =  $FormatDT1[1];
	if ($timeformat1 == 'h:i:s') $timeformat1 = $timeformat1 . " A";
	if($FormatDT1[1] == 'h:i:s')
		$timeformat = 'HH12:MI:SS AM';
	else
		$timeformat = 'HH24:MI:SS';
	$CurrentTime = DlookUP("select to_char(now() + cast('" . ($TimeZone-1) . " hour' as interval), 'YYYY-MM-DD " . $timeformat . "') DateTime");
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	//echo $yourbrowser;
	//exit;
	
	$bojanakola = query("SELECT c1.name engineon, c2.name engineoff, c3.name engineoffpassengeron, c4.name satelliteoff, 
	c5.name taximeteron, c6.name taximeteroffpassengeron, c7.name passiveon, c8.name activeoff
	from users us 
	left outer join statuscolors c1 on c1.id=us.engineon 
	left outer join statuscolors c2 on c2.id=us.engineoff 
	left outer join statuscolors c3 on c3.id=us.engineoffpassengeron 
	left outer join statuscolors c4 on c4.id=us.satelliteoff 
	left outer join statuscolors c5 on c5.id=us.taximeteron 
	left outer join statuscolors c6 on c6.id=us.taximeteroffpassengeron 
	left outer join statuscolors c7 on c7.id=us.passiveon 
	left outer join statuscolors c8 on c8.id=us.activeoff 
	where us.id = " . session("user_id"));
	$engineon = pg_fetch_result($bojanakola, 0, "engineon");
	$engineoff = pg_fetch_result($bojanakola, 0, "engineoff");
	$engineoffpassengeron = pg_fetch_result($bojanakola, 0, "engineoffpassengeron");
	$satelliteoff = pg_fetch_result($bojanakola, 0, "satelliteoff");
	$taximeteron = pg_fetch_result($bojanakola, 0, "taximeteron");
	$taximeteroffpassengeron = pg_fetch_result($bojanakola, 0, "taximeteroffpassengeron");
	$passiveon = pg_fetch_result($bojanakola, 0, "passiveon");
	$activeoff = pg_fetch_result($bojanakola, 0, "activeoff");
	
	addlog(2);
	
	$pass = dlookup("select md5(password) from users where clientid=" . session("client_id") . " and roleid=2 order by id asc limit 1");
	
?>
<script>
	AllowAddPoi = '<?php echo $AllowAddPoi?>'
	AllowViewPoi = '<?php echo $AllowViewPoi?>'
	AllowAddZone = '<?php echo $AllowAddZone?>'
	AllowViewZone = '<?php echo $AllowViewZone?>'
</script>

<body onResize="setLiveHeight()">
<table class="resmenutable" width="100%" border="0" cellpadding="0" cellspacing="0" style="position: relative; z-index: 10; min-width: 700px;">
	<tr>
		<td class="resmenucol1" width="35%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999">
			&nbsp;<span class="reslogo"><img src="../images/tiniLogo.png" border="0" align="absmiddle" />&nbsp;</span>
			<span class="reslogo">&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;</span>
			<a id="icon-home" href="../?l=<?php echo $cLang?>"><img src="../images/shome.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-live" href=""><img src="../images/smap.png" border="0" align="absmiddle" style="opacity:0.4" /></a>&nbsp;
			<a id="icon-rep"  href="../report/?l=<?php echo $cLang?>#rep/menu_1_1" ><img src="../images/sdocument.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-route" onclick="<?php echo $routes?>" style="<?php echo $routes1?>" href="../routes/?l=<?php echo $cLang?>" ><img src="../images/srouting.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-tv" onclick="<?php echo $tv?>" style="<?php echo $tv1?>" href="../tv/?l=<?php echo $cLang?>#tv/menu_2_1" ><img src="../images/stv.png" border="0" align="absmiddle" /></a>&nbsp;
			&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;
			
			<a id="a-split" href="javascript:"></a>&nbsp;
            <a id="activeBoard" href="javascript:"></a>&nbsp;
			<a id="icon-poi" href="javascript:"></a>
            <a id="icon-poi-down" href="javascript:"></a>&nbsp;
			<a id="icon-draw-zone" href="javascript:"></a>
            <a id="icon-zone-down" href="javascript:"></a>&nbsp;
			<a id="icon-draw-path" href="javascript:"></a>
            <a id="icon-draw-path-down" href="javascript:"></a>&nbsp;
            <a id="icon-newtab-details" onmousemove="ShowPopup(event, '<?=dic_("Tracking.DetailNewTab")?>')" onmouseout="HidePopup()" href="../detail/?l=<?php echo $cLang?>" target="_blank"></a>&nbsp;
            <a id="icon-newtab-orders" onmousemove="ShowPopup(event, '<?=dic_("Tracking.OrdersNewTab")?>')" onmouseout="HidePopup()" onclick="<?php echo $routes?>" style="<?php echo $routes1?>" href="../routes/?l=<?php echo $cLang?>#rep/menu_2_1" target="_blank"></a>&nbsp;
			
            <!--input id="testText" value="0" type="text" onclick="javascript: resetScreen = false;" style="width: 650px; position: absolute; top: 5px; left: 500px;" /-->
		</td>
		<td width="65%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999" align="right" class="text2 resmenucol2" valign="middle">
			<img class="rescompany" src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<span class="rescompany"><?php if($yourbrowser != "1") { echo dic("Tracking.Company").":"; } ?> <strong><?php echo session("company")?></strong>&nbsp;&nbsp;&nbsp;</span>
			<img class="resuser" src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<span class="resuser"><?php if($yourbrowser != "1") { echo dic("Tracking.User").":"; } ?> <strong><?php echo session("user_fullname")?></strong>&nbsp;&nbsp;&nbsp;&nbsp;</span>
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="span-time" style="cursor:help">22:55:36&nbsp;</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			
			<a id="icon-alert" style="position: relative; left: 15px; margin-left: -10px;<?php echo $al1?>">
				<img src="../images/warning1.png" onclick="<?php echo $al?>ShowHideAlerts()" border="0" align="absmiddle" style="cursor: pointer;" />
				<span id="alertsNew" class="notify corner5"  style="visibility: hidden;"  disabled onclick="<?php echo $al?>ShowHideAlerts()">0</span>
				<!--input id="alertsNew" class="notify corner5" onclick="ShowHideAlerts()" style="visibility: hidden;" value="0" disabled /-->
			</a>&nbsp;
			<!--a>
				<div id="alertsNew" class="corner5" style="background-color: Red; color: White; height: 13px; left: 0px; float: left; z-index: 134354; width: 13px; top: 0px; text-align: center;">1</div>
			</a-->
			<a id="icon-mail" style="position: relative; left: 15px; margin-left: -10px;<?php echo $mess1?>">
				<img src="../images/mail.png" onclick="<?php echo $mess?>ShowHideMail()" border="0" align="absmiddle" style="cursor: pointer;" />
				<span id="mailNew" class="notify corner5"  style="visibility: hidden;"  disabled onclick="ShowHideMail()">0</span>
				<!--input id="mailNew" class="notify corner5" onclick="ShowHideMail()" style="visibility: hidden;" value="0" disabled /-->
			</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="icon-costs" style="position: relative; left: 15px; margin-left: -10px;<?php echo $fm1?>">
				<img src="../images/cost24.png" onclick="<?php echo $fm?>costVehicle123('1', '<?php echo $firstVehId?>', 'SK-0001-AB')" border="0" align="absmiddle" style="cursor: pointer;" />
				<input readonly id="costNew" class="notify corner5" style="visibility: hidden;" value="0" disabled />
			</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="icon-sett" href="../settings/?l=<?php echo $cLang?>"><img src="../images/ssettings.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-help"><img src="../images/shelp.png" border="0" align="absmiddle" /></a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;		
			<a id="icon-logout" href="../logout/?l=<?php echo $cLang?>"><img width="24px" src="../images/exitNew1.png" border="0" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>
<table id="live-table" width="100%" border="0" cellpadding="0" cellspacing="0" style="position: relative;">
	<tr>
		<td id="vehicle-list" width="250px" valign="top">
			<div id="searchVeh" style="width: 240px;">
        <input type="text" style="width: 248px; height: 25px; font-family: Arial,Helvetica,sans-serif; font-size: 12px;" name="searchbyreg" id="searchbyreg" value="" onclick="$(this).focus()" onkeyup="searchVehicle(this)" placeholder="<?php echo dic("search")?>..." onmousemove="ShowPopup(event, '<div style=\'position: relative; float: left; margin-left: 7px; margin-top: 5px; padding-right: 3px;\'><?php echo dic("Tracking.Registration")?>,<br /><?php echo dic("Tracking.Driver")?>,<br /><?php echo dic("Tracking.Speed")?>,<br /><?php echo dic("Reports.DateTime")?></div>')" onmouseout="HidePopup()"/>

			<div id="div-menu" style="width:248px; overflow-y:auto; overflow-x:hidden; display: none">
			</div>
            <div id="race-img" style="position:absolute; left: 250px; width:8px; height:50px; background-image:url(../images/racelive.png); background-position: -8px 0px; z-index: 2000; cursor:pointer" onClick="shleft()"></div>
		</td>
		<td id="maps-container" valign="top" style="border-left: 2px Solid #387cb0"><!--groletna.aspx?t=2-->
			<audio id="soundHandle" loop="loop" style="display: none;"></audio>
			<!--div onclick="startplay()" style="cursor: pointer; position: absolute; left: 300px; top: 50px; width: 100px; height: 50px; opacity: 0.5; z-index: 99999;">
				<audio id="soundHandle" style="display: block;"></audio>
				<!--object data="sound/bells_alarm.mp3" type="application/x-mplayer2" width="200px" height="100px">
					<param name="filename" value="muzika">
				</object>
				<embed type="application/x-mplayer2" src="sound/bells_alarm.mp3" height="50px" width="50px"->
			</div
			<audio id="demo" src="sound/bells_alarm.ogg"></audio>
			<div style="position: absolute; left: 300px; top: 50px; width: 600px; height: 50px; opacity: 1; z-index: 99999;">
			  <button onclick="document.getElementById('demo').play()">Play the Audio</button>
			  <button onclick="document.getElementById('demo').pause()">Pause the Audio</button>
			  <button onclick="document.getElementById('demo').volume+=0.1">Increase Volume</button>
			  <button onclick="document.getElementById('demo').volume-=0.1">Decrease Volume</button>
			</div>
			<input class='ui-button' type='button' value='Затвори' id='closealarm' onclick='closedialog()' />
			-->
			
			<div id="div-map"></div>
			
			<div id="dialog-map" style="display:none; z-index: 9999" title="<?php echo dic_("Reports.ViewOnMap")?>"></div>
			<div id="div-mainalerts" onmouseover="clearTimeOutAlertView()" onmouseout="setTimeOutAlertView()" style="display:none; font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; border: 0px; right: 35px; float: right; position: absolute; z-index: 9999; top: 20px; width: 315px; overflow-x: hidden; overflow-y: auto;"></div>
			<div id="div-costMain" style="display:none" title="<?php echo dic("Reports.AddingCost")?>"></div>
			<div id="div-del-cost" style="display:none" title="<?=dic_("Reports.DelCost")?>"></div>
			<div id="div-showMessage" style="display:none" title="<?php echo dic("Routes.ShowMessages")?>"></div>
			<div id="div-costnewMain" style="display:none" title="<?php echo dic("Reports.AddingNewCost")?>"></div>
			<div id="div-locMain" style="display:none" title="<?php echo dic("Reports.AddNewExecutor")?>"></div>
			<div id="div-compMain" style="display:none" title="<?php echo dic("Reports.AddNewComponent")?>"></div>
			<div id="div-delComp" style="display:none" title="<?php echo dic("Reports.DelComp")?>"></div>

			<div id="dialog-cameraW" style="display:none" title="<?=dic_("Reports.PreviewLastPhoto")?>" align="middle">
				 <table width=500px align=center class="text2">
				    <tr>
				      <td width=30% id="cam01"><?=dic_("Reports.PhotoName")?>:</td>
				      <td width=45%><span id="cameraName" style="font-weight:bold"></span></td>
				      <td rowspan="2" width=25%>
				      	<img width="17px" id="vh-img-newimage" src="../images/smallref.gif" style="display: none; position: relative; right: 3px; float: left; top: 5px;">
				      	<div id="tmpCamera" align="middle"></div>
				      </td>
				    </tr>
				    <tr>
				    	<td id="cam02"><?=dic_("Reports.DateTime")?>:</td>
				    	<td><span id="cameraTime" style="font-weight:bold"></span></td>
				    </tr>
				  </table> 
				<br>
				<img height="87%" src="" id="cameraImg">
			</div>
			
			<div id="top1">
				<div id="topmiddle">
					<div id="topmiddle1" onMouseOver="this.style.opacity = 1; this.style.filter = 'alpha(opacity=100)';" onMouseOut="this.style.opacity = 0.8; this.style.filter = 'alpha(opacity=80)';">
						<iframe id="iFrmS" name="iFrmS" src="Roller.php?l=<?php echo $cLang?>"  frameborder="0" scrolling="auto" style="position:absolute;width:100%; top:0px; display:none;"></iframe>
					</div>
					<div id="topmiddle2">
						<div id="strelkatop" onClick="HideShowTopPanel(0);"></div>
					</div>
				</div>
			</div>
			<div id="trajectory24h" class="shadow" style="display: none; height: 215px; position: relative; left: 10px; width: calc(100% - 20px); top: -225px;"></div>
		</td>
	</tr>
</table>
<div id="addodometer" title="<?=dic_("EnterOdometer")?>" style="display:none">
	 <p>
		<div align="center" style="font-size:14px">
			<?=dic_("CurrentMileage")?>:
			<br /><br />
			<input id="txtOdometer" type="text" class="textboxCalender corner5" style="width:300px" />	
		</div>
	</p>
</div>
<div id="addCanned" title="<?=dic_("GarminCommMess")?>" style="display:none"></div>
<div id="div-ask-confirmation" style="display:none" title="<?php echo dic("Settings.Action")?>">
	<?=dic_("AlreadyNewOdometer")?>
</div>
 <div id="div-ask-motoalarm" style="display:none" title="<?php echo dic("Settings.Action")?>">
	<?=dic_("SureActAlarm")?>
 </div>
 <div id="div-ask-engineblock" title="<?=dic_("BlockadeEngine")?>" style="display:none">
	 <p>
		<div align="center" style="font-size:14px">
			<?=dic_("SureWant")?><br><?=dic_("ToBlockVeh")?>
			<br /><br />
			<input id="txtBlock" type="password" placeholder="<?=dic_("Login.Password")?>" class="textboxCalender corner5" style="width:200px" />	
		</div>
	</p>
</div>
<div id="div-ask-enginedeblock" title="<?=dic_("UnblockEngine")?>" style="display:none">
	 <p>
		<div align="center" style="font-size:14px">
			<?=dic_("SureWant")?><br><?=dic_("ToUnBlockVeh")?>
			<br /><br />
			<input id="txtDeBlock" type="password" placeholder="<?=dic_("Login.Password")?>" class="textboxCalender corner5" style="width:200px" />	
		</div>
	</p>
</div>
<div id="div-engineblockwaiting" title="<?=dic_("EngineBlocking")?><img align='absmiddle' style='height: 31px; width: 31px; margin-left: 215px; margin-top: -5px;' src='../images/ajax-loader.gif' />" style="display:none">
	 <p>
		<div align="center" style="font-size:14px">
			<?=dic_("SentBlockade")?> 3 Km/h<br><br>
			<?=dic_("CancelBlocking")?>
			<br />
		</div>
	</p>
</div>
<div id="div-ask-geolockon" title="Geo-lock" style="display:none">
	 <p>
		<div align="center" style="font-size:14px">
			<?=dic_("SureWant")?><br><?=dic_("ActParkArea")?>
			<br /><br />
			<span><?=dic_("Tracking.SelectRadius")?></span>
			<select id="txtRadius" style="width:200px" class="combobox text2">
				<option value=50><?php echo round(50*$valueM)?>&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></option>
				<option value=100><?php echo round(100*$valueM)?>&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></option>
				<option value=150><?php echo round(150*$valueM)?>&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></option>
				<option value=200><?php echo round(200*$valueM)?>&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></option>
			</select>
		</div>
	</p>
</div>
<div id="div-ask-geolockoff" title="Geo-lock" style="display:none">
	 <p>
		<div align="center" style="font-size:14px">
			<?=dic_("SureWant")?><br><?=dic_("DeactParkArea")?>
			<br />
		</div>
	</p>
</div>
<div id="div-feedbackblock" style="display:none" title="<?php echo dic("Settings.Action")?>">
	<?=dic_("EngineSuccBlock")?>
</div>
<div id="icon-legenda" style="position: relative; cursor: help; float: right; z-index: 3000; margin-right: 10px;"><img src="../images/legenda.png" border="0" align="absmiddle" /></div>
<div id="dialog-message" title="<?php echo dic("Tracking.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAll" style="font-size:11px; padding-left: 23px;"><input id="InfoForAll" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?></div>
</div>
<div id="dialog-message1" title="<?php dic("Reports.Warning")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-minus" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox1" style="font-size:14px"></div>
	</p>
</div>
<div id="dialog-draw-area" title="<?php echo dic("Tracking.DrawArea")?>" style="display:none">
	<iframe src="" id="ifrm-edit-areas" scrolling="no" frameborder="0" style="border:0px dotted #387cb0"></iframe>
</div>
<div id="div-Add-Group" style="display: none;" title="<?php echo dic("Tracking.AddGroup")?>">
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.GroupName")?></span><input id="GroupName" type="text" class="textboxCalender corner5" style="width:220px" /><br /><br />
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.Color")?></span>
    <div id="colorPicker2">
		<span id="colorPicker1" style="cursor: pointer; float:left; border:1px solid black; width:20px; height:20px;margin:5px;"></span>
		<input id="clickAny" type="text" class="textboxCalender corner5" onchange="changecolor()" value="" style="width:120px" />
	</div>
    <img id="loadingIconsPOI" style="visibility: hidden; width: 140px; position: absolute; left: 125px; top: 180px;" src="../images/loading_bar1.gif" alt="" />
    <br><br>
    <span id="spanIconsPOI" style="display:block; width:90px; float:left; margin-left:20px; position: relative; top: 70px;"><?php echo dic("General.Icon")?></span>
    <table id="tblIconsPOI" border="0" style="width: 268px; text-align: center; position: relative; top: -10px; left: -15px;">
        <tr>
        <?php
            for ($icon=0; $icon <= 7; $icon++) { 
        ?>
            <td><img id="GroupIconImg<?php echo $icon?>" src="http://80.77.159.246:88/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
        <?php
            }
        ?>
        </tr>
        <tr>
        <?php
            for ($icon=0; $icon <= 7; $icon++) { 
                if($icon == 0)
                {
                    ?>
                    <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" checked type="radio" /></td>
                    <?php
                } else
				{
                    ?>
                    <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" type="radio" /></td>
                    <?php
                }
            
            }
        ?>
        </tr>
        <tr>
        <?php
            for ($icon=8; $icon <= 14; $icon++) { 
            ?>
            <td  style="padding-top: 20px"><img id="GroupIconImg<?php echo $icon?>" src="http://80.77.159.246:88/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
            <?php
            }
            ?>
        </tr>
        <tr>
        <?php
            for ($icon=8; $icon <= 14; $icon++) { 
            ?>
            <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" type="radio" /></td>
            <?php
            }
            ?>
        </tr>
        <tr>
        <?php
            for ($icon=15; $icon <= 21; $icon++) { 
            ?>
            <td  style="padding-top: 20px"><img id="GroupIconImg<?php echo $icon?>" src="http://80.77.159.246:88/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
            <?php
            }
            ?>
        </tr>
        <tr>
        <?php
            for ($icon=15; $icon <= 21; $icon++) { 
            ?>
            <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" type="radio" /></td>
            <?php
            }
            ?>
        </tr>
    </table>
    <br /><br />
	<div align="right" style="display:block; width:330px">
        <img id="loading1" style="display: none; width: 150px; position: absolute; left: 32px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" class="BlackText corner5" id="btnAddGroup" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddGroupOkClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelGroup" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-Group').dialog('destroy');" />
	</div><br />
</div>
<div id="div-ver-DelGroup" style="display: none;" title="<?php echo dic("Tracking.DeletePoi")?>">
	<span class="ui-icon ui-icon-alert" style="position: absolute; left: 11px; top: 7px;"></span>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisPoi")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnYesDelGroup" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGroup').dialog('destroy'); ButtonDeletePOIokClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelDelGroup" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGroup').dialog('destroy');" />
	</div><br />
</div>
<div id="div-ver-DelGeoF" style="display: none;" title="<?php echo dic("Tracking.DeleteGF")?>">
	<div style="background: url('../images/izv.png')"></div>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisGeoFence")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnYesDelGF" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy'); ButtonDeleteGFokClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelDelGF" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy');" />
	</div><br />
</div>

<div id="div-Add-POI" style="display: none;">
	<br />
	<table style="font-size: 11px; color: rgb(65, 65, 65); font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Latitude")?></td>
    		<td>
    			<input id="poiLat" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.Longitude")?></td>
    		<td>
    			<input id="poiLon" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr>
    		<td width="90px"><?php echo dic("Tracking.Address")?></td>
    		<td>
    			<input id="poiAddress" type="text" class="textboxCalender corner5" style="width:269px; position: relative; float: left;" /><img id="loadingAddress" style="visibility: hidden; position: relative; float: left; top: 2px;" width="25px" src="../images/loadingP1.gif" border="0" align="absmiddle" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.NamePoi")?></td>
    		<td>
    			<input id="poiName" type="text" class="textboxCalender corner5" style="width:269px" />
    		</td>
		</tr>
		<tr>
    		<td width="90px"><?php echo dic("Tracking.AvailableFor")?></td>
    		<td>
    			<div id="poiAvail" class="corner5" style="font-size: 10px">
			        <input type="radio" id="APcheck1" name="radio" /><label for="APcheck1"><?php echo dic("Tracking.User")?></label>
			        <input type="radio" id="APcheck2" name="radio" /><label for="APcheck2"><?php echo dic("Tracking.OrgU")?></label>
			        <input type="radio" id="APcheck3" name="radio" /><label for="APcheck3"><?php echo dic("Tracking.Company")?></label>
			    </div>
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.Radius")?></td>
    		<td>
    			<dl id="poiRadius" class="dropdownRadius" style="width: 70px; margin: 0px;">
			        <dt><a href="#" title="" class="combobox1"><span><?php echo dic("Tracking.SelectRadius")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="RadiusID_50" href="#"><?php echo round(50*$valueM)?>&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_70" href="#"><?php echo round(70*$valueM)?>&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_100" href="#"><?php echo round(100*$valueM)?>&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_150" href="#"><?php echo round(150*$valueM)?>&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			            </ul>
			        </dd>
			    </dl>
    		</td>
		</tr>
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Group")?></td>
    		<td>
    			<dl id="poiGroup" class="dropdown" style="width: 150px; position: relative; float: left; padding: 0px; margin: 0px;">
			    <?php
					$dsUG = query("SELECT id, name, fillcolor FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#" title="" id="groupidTEst" class="combobox1"><span><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG, 0, "id")?>" href="#">&nbsp;&nbsp;<?php echo dic("Settings.NotGroupedItems")?>
			                	<img style="height: 18px; position: relative; width: 18px; float: left; top: -5px; margin-right: 6px;" src="../images/pin-1.png">
		                	</a></li>
			                <?php
								$dsGroup1 = query("select id, name, fillcolor, image from pointsofinterestgroups where id <> 1 and clientid=".session("client_id")." order by name asc");
			                    while ($row1 = pg_fetch_array($dsGroup1)) {
			                    	$_color = substr($row1["fillcolor"], 1, strlen($row1["fillcolor"]));
			                ?>
			                <li><a id="<?php echo $row1["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row1["name"]?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://80.77.159.246:88/new/pin/?color=<?php echo $_color?>&type=<?php echo $row1["image"]?>') no-repeat; position: relative; float: left;"></div></a></li>
			                <?php
			                    }
			                ?>
			            </ul>
			        </dd>
			    </dl>
    			<input type="button" id="AddGroup" style="left: 20px; top: 1px;" onclick="AddGroup('1')" value="+" />
    		</td>
    	</tr>
	</table>
    <br /><br />
    <input type="hidden" id="idPoi" value="" />
    <input type="hidden" id="numPoi" value="" />
	<div align="right" style="display:block; width:380px; height: 30px; padding-top: 5px; position: relative; float: right; right: 15px;">
        <img id="loading" style="display: none; width: 140px; position: absolute; left: 10px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelPOI" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-POI').dialog('destroy');" />        
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnAddPOI" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddEditPOIokClick()" />
		<input type="button" style="display: none; position: relative; float: right; " class="BlackText corner5"  id="btnDeletePOI" value="<?php echo dic("Tracking.Delete")?>" onclick="DeleteGroup()" />
	</div><br /><br />
</div>
<div id="div-enter-zone-name" style="display:none">
	<div align = "center">
 		<table cellpadding="3" width="100%" style="font-size: 11px">
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.GFName")?>:</td>
				<td width = "75%" style="font-weight:bold" class ="text2">
					<input id="txt_zonename" type="text" value="" class="textboxcalender corner5 text5" style="width:365px;" />
				</td>
			</tr>
			<tr width = "75%" style="font-weight:bold" class ="text2">
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.AvailableFor")?>:</td>
				<td>
					<div id="gfAvail" class="corner5">
				        <input type="radio" id="GFcheck1" name="radio" /><label for="GFcheck1"><?php echo dic("Tracking.User")?></label>
				        <input type="radio" id="GFcheck2" name="radio" /><label for="GFcheck2"><?php echo dic("Tracking.OrgU")?></label>
				        <input type="radio" id="GFcheck3" name="radio" /><label for="GFcheck3"><?php echo dic("Tracking.Company")?></label>
				        <script>
				    		$('#GFcheck1').click(function(){ $(this).blur(); });
				    		$('#GFcheck2').click(function(){ $(this).blur(); });
				    		$('#GFcheck3').click(function(){ $(this).blur(); });
				    </script>
				    </div>
				</td>
			</tr>
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.Group")?>:</td>
				<td width = "75%" style="font-weight:bold" class ="text2">
					<dl id="gfGroup" class="dropdown" style="width: 150px; position: relative; float: left; margin: 0px;">
				    <?php
					$dsUG1 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#" title="" class="combobox1"><span class ="text2"><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG1, 0, "id")?>" href="#">&nbsp;<?php echo dic("Settings.NotGroupedItems")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo pg_fetch_result($dsUG1, 0, "fillcolor")?>; position: relative; float: left;"></div></a></li>
			                <?php
			                    $dsGroup2 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE clientid=".session("client_id") . " order by name asc");
			                    while ($row = pg_fetch_array($dsGroup2)) {
			                ?>
			                <li><a id="<?php echo $row["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row["name"]?><div class="flag" style="margin-top: -1px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo $row["fillcolor"]?>; position: relative; float: left;"></div></a></li>
			                <?php
								}
			                ?>
			            </ul>
			        </dd>
			    </dl>
			    <input type="button" id="AddGroup1" style="position: relative; float: left; left: 20px; top: 1px;" onclick="AddGroup('0')" value="+" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr width="100%" style="opacity: 0.3; border-left: 0px none; border-width: 2px 0px 0px; border-style: dotted none none; border-color: -moz-use-text-color;">
				</td>
			</tr>
			<?php
				if(!$allowedAlarms) 
				{ ?>
					<tr>
						<td colspan="2">
							<table cellpadding="3" onclick="return false;" width="100%" style="font-size: 11px; opacity: 0.5;">
								<tr>
									<td>
				<?php } ?>
					
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.AlertFor")?>:</td>
			    <td width = "75%" style="font-weight:bold" class ="text2">
				    <div id="alertINOUT" class="corner5">
				        <input type="checkbox" id="alVlez" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> name="checkbox" /><label for="alVlez"><?php echo dic("Tracking.Enter1")?></label>
				        <input type="checkbox" id="alIzlez" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> name="checkbox" /><label for="alIzlez"><?php echo dic("Tracking.Exit")?></label>
				    </div>
				</td>
		    </tr>
     		<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.GroupOFAlerts")?>:</td>
			    <td width = "75%" style="font-weight:bold" class ="text2">
				    <div class="ui-widget" style="height: 25px; width: 100%;">
					    <select id="vozila" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2" onchange="OptionsChangeVehicle()">
					    	<option value="0"><?php echo dic("Tracking.SelectOption")?></option>
					        <option value="1"><?php echo dic("Tracking.OneVehicle")?></option>
					        <option value="2"><?php echo dic("Tracking.VehInOrgU")?></option>
					        <option value="3"><?php echo dic("Tracking.AllVehCompany")?></option>
					    </select>
					</div>
				</td>
		    </tr>
			<tr id="ednoVozilo" style="display:none;">
		     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.SelectVeh")?>:</td>
		     <td width = "75%" style="font-weight:bold" class ="text2">
		     <div class="ui-widget" style="height: 25px; width: 100%;">
		     <select id="voziloOdbrano" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2">
		     	<?php
		        	$str1 = "";
					$str1 .= "select * from vehicles where clientid=" . session("client_id") ." ORDER BY code::INTEGER";
					$dsPP = query($str1);
		            while($row = pg_fetch_array($dsPP)) {
		        ?>
		            <option value="<?php echo $row["id"] ?>"><?php echo $row["registration"]?>&nbsp;(<?php echo $row["code"]?>)</option>
		        <?php
		            }
		        ?>
		     </select>
			 </div>
			 </td>   
		     </tr>
     
		     <tr id="OrganizacionaEdinica" style="display:none;">
		     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.SelectOrg.Unit")?>:</td>
		     <td width = "75%" style="font-weight:bold" class ="text2">
		     <div class="ui-widget" style="height: 25px; width: 100%">
		     <select id="oEdinica" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2">
		     	<?php
		        	$str2 = "";
					$str2 .= "select * from organisation where clientid=" . session("client_id") ." order by code::INTEGER";
					$dsPP2 = query($str2);
					$brojRedovi = dlookup("select count(*) from organisation where clientid=" . session("client_id"));
		            while($row2 = pg_fetch_array($dsPP2)) {
		        ?>
		            <option value="<?php echo $row2["id"] ?>"><?php if ($brojRedovi>0){ echo $row2["name"]?>&nbsp;(<?php echo $row2["code"]?> <?php }else{ echo dic("Settings.NoOrgU");}?>)</option>
		        <?php
		            }
		        ?>
		     </select>
			 </div>
			 </td>
		     </tr>
		     
     	     <tr>
		     	<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic("Tracking.Emails")?></td>
		     	<td width = "75%" style="font-weight:bold" class ="text2">
		     		<input id = "txt_emails" class="textboxcalender corner5 text5" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> type="text" style = "width:365px"></input>
	     		</td>
		     </tr>
		     <tr>
		     	<td width = "25%"></td>	
		     	<td width = "75%" style="font-weight:bold ; " class ="text2"><font color = RED style="font-size = 10px"><?php echo dic("Reports.SchNote")?></font></td>
		     </tr>
		     <tr>
		     	<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic("Settings.SMS")?></td>
		     	<td width = "75%" style="font-weight:bold" class ="text2"><input id = "txt_phones" class="textboxcalender corner5 text5" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> type="text" style = "width:365px"></input></td>
		     </tr>
	     	
		 <?php if(!$allowedAlarms)
			{
				?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?php
			}?>
		 
	   	 </table>
     </div>
     
	<!--label><input type="checkbox" id="chk_1_in" /><?php echo dic("Tracking.AlertAllowEnter")?></label><br />
	<label><input type="checkbox" id="chk_1_out"/><?php echo dic("Tracking.AlertAllowExit")?></label><br />
	<label><input type="checkbox" id="chk_2_in" /><?php echo dic("Tracking.AlertNotAllowEnter")?></label><br />
	<label><input type="checkbox" id="chk_2_out"/><?php echo dic("Tracking.AlertNotAllowExit")?></label><br />
	<div style="display:block; height:10px"></div>

	<strong><?php echo dic("Tracking.AlertEmail")?>: <span style="font-size:10px; color:#666">(<?php echo dic("Tracking.Example")?>: John@google.com, Marc@yahoo.com)</span>:</strong><br />
	<input id="txt_emails" type="text" value="" class="textboxcalender corner5 text5" style="width:622px; height:22px; font-size:11px"/><br />
	<div style="display:block; height:10px"></div>
	<strong><?php echo dic("Tracking.AlertPhone")?>: <span style="font-size:10px; color:#666">(<?php echo dic("Tracking.MacExample")?>: 075100000, 071100000)</span>:</strong><br />
	<input id="txt_phones" type="text" value="" class="textboxcalender corner5 text5" style="width:622px; height:22px; font-size:11px"/><br /-->
</div>
<div id="div-Add-Garmin" style="display: none;">
	<br />
	<table style="font-size: 11px; color: rgb(65, 65, 65); font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Latitude")?></td>
    		<td>
    			<input id="garminLat" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.Longitude")?></td>
    		<td>
    			<input id="garminLon" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr>
    		<td width="90px"><?php echo dic("Tracking.Address")?></td>
    		<td>
    			<input id="garminAddress" type="text" class="textboxCalender corner5" style="width:269px; position: relative; float: left;" /><img id="loadinggarminAddress" style="visibility: hidden; position: relative; float: left; top: 2px;" width="25px" src="../images/loadingP1.gif" border="0" align="absmiddle" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.NamePoi")?></td>
    		<td>
    			<input onkeydown="javascritp: $('#errAddGarmin').css({display: 'none'});" id="garminName" type="text" class="textboxCalender corner5" style="width:269px" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?=dic_("Fm.Vehicle")?></td>
    		<td>
    			<select onchange="javascritp: $('#errAddGarmin').css({display: 'none'});" id="vozilca" class="textboxCalender corner5 text2" style="width: 271px; margin-top: 2px; padding-top:5px; padding-bottom:3px">
    				<option id="0" selected value="<?=dic("SelectVeh")?>"><?=dic("SelectVeh")?></option>
    				<?php
    					if ($_SESSION['role_id'] == "2") {
		                  $tovehicles = "select * from vehicles where clientid = " . session("client_id") . " and allowgarmin='1'";
					  } else {
					  	  $tovehicles = "select * from vehicles where id in (select distinct vehicleid from uservehicles 
					  	  where userid=(" . session("user_id") . ")) and allowgarmin='1'";
					  }
		                  $dsVehicles = query($tovehicles);
						  
		                  while ($drVehicles = pg_fetch_array($dsVehicles)) {
		              ?>
		                          <option id="<?= $drVehicles["id"] ?>" value="<?= $drVehicles["gsmnumber"] ?>"><?= $drVehicles["registration"]?> (<?= $drVehicles["code"]?>)</option>
		               <?php
		                  } //end while   
    				?>
    			</select>
    		</td>
		</tr>
	</table>
    <br /><br />
	<div align="right" style="display:block; width:380px; height: 30px; padding-top: 5px; position: relative; float: right; right: 15px;">
		<span id="errAddGarmin" style="display: none; position: absolute; color: red; text-align: left; margin-left: 51px;"><?=dic_("HaveNotEntered")?><br><?=dic_("TheReqInfo")?></span>
        <img id="loadingGarmin" style="display: none; width: 140px; position: absolute; left: 10px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelGarmin" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-Garmin').dialog('destroy');" />        
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnAddGarmin" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddGarmin()" />
	</div><br /><br />
</div>
<div id="div-Directions" class="text2_ corner5 shadow" style="display: none; opacity: 0.9; z-index: 9996; background-color: white; float: right; position: absolute; right: 20px; top: 55px; width: 310px; min-height: 315px; height: auto; padding-bottom: 10px;">
	<div class="textSubTitle" style="text-align: center; padding-top: 10px; height: 25px; border-bottom: 1px solid #ccc;"><?=dic('CalculatingDistance')?></div>
	<table class="text2_" style="font-size: 11px; color: rgb(65, 65, 65); margin-top: 5px; font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
		<tr height="50px">
    		<td>
    			<select onchange="ChangeVozDir()" id="vozilcaDirection" class="textboxCalender corner5 text2_" style="width: 271px; margin-top: 2px; padding-top:5px; padding-bottom:3px">
    				<option id="0" selected value="-1"><?=dic('SelectVeh')?></option>
    				<?php
    					if (session("role_id")."" == "2"){
							$tovehicles = "select id, code, registration from vehicles where clientid=".session("client_id");
						} else {
							$tovehicles = "select id, code, registration from vehicles where id in (select distinct vehicleid from uservehicles 
		                  	where userid=(" . session("user_id") . "))";
						}
	                  	$dsVehicles = query($tovehicles);
	                  	while ($drVehicles = pg_fetch_array($dsVehicles)) {
		              	?>
                          <option id="<?= $drVehicles["id"] ?>" value="<?= $drVehicles["code"] ?>"><?= $drVehicles["registration"]?> (<?= $drVehicles["code"]?>)</option>
		               <?php
	                  	} //end while   
    				?>
    			</select>
    		</td>
		</tr>
		<tr style="height:5px;">
	         <td><div style="border-bottom: 1px dotted rgb(190, 190, 190); margin-left: -5px; width: 278px;"></div></td>
	    </tr>
		<tr height="67px">
    		<td>
    			<input id="fromDirection" onmousemove="ShowPopup(event, '<?=dic('search')?>' + ' ' + '<?=dic('Reports.Mo')?>'.toLowerCase() + ' ' + '<?=dic('Tracking.Address')?>'.toLowerCase())" onmouseout="HidePopup()" type="text" class="textboxCalender corner5 text2_" placeholder="<?=dic('ChooseStartingPoint')?>" style="border-bottom: 0px none; width: 236px; border-radius: 5px 0px 0px; border-right: 0px none;" />
    			<span onclick="ButtonAddStartDirectionClick(event, 0)" onmousemove="ShowPopup(event, '<?=dic('clickforstartpoint')?>')" onmouseout="HidePopup()" style="float: right; cursor: pointer; right: 22px; padding: 4px 6px 2px 5px; position: absolute; border: 1px solid #ccc; height: 21px; border-radius: 0px 5px 0px 0px;"><img id="clickstartaddress" src="../images/plus.png" width="20px" /></span>
    			<input id="direcitonAddress" onclick="javascript: $('#fromDirection').focus();" readonly="readonly" type="text" class="textboxCalender corner5 text2_" style="width: 269px; position: relative; float: left; border-radius: 0px 0px 5px 5px; background-color: #e9e9e9;" /><img id="loadingDirectionAddress" style="float: right; position: absolute; display: none; right: 25px;" width="25px" src="../images/smallref.gif" border="0" align="absmiddle" />
    			<input id="directionLon" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    			<input id="directionLat" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    		</td>
		</tr>
		<tr style="height:5px;">
	         <td>
	         	<div style="border-bottom: 1px dotted rgb(190, 190, 190); margin-left: -5px; width: 269px;"></div>
	         	<img onclick="SwitchPoints()" onmousemove="ShowPopup(event, '<?=dic('ReverseDestinationa')?>')" onmouseout="HidePopup()" width="8" height="11" src="../images/downMenu1.png" style="cursor: pointer; float: right; opacity: 0.25; position: absolute; right: 14px; margin-top: -5px;">
	         	<img onclick="SwitchPoints()" onmousemove="ShowPopup(event, '<?=dic('ReverseDestinationa')?>')" onmouseout="HidePopup()" width="8" height="11" src="../images/upMenu1.png" style="cursor: pointer; float: right; opacity: 0.25; position: absolute; margin-top: -5px; right: 7px;">
	         </td>
	    </tr>
	    <tr height="67px">
    		<td>
    			<input id="toDirection" onmousemove="ShowPopup(event, '<?=dic('search')?>' + ' ' + '<?=dic('Reports.Mo')?>'.toLowerCase() + ' ' + '<?=dic('Tracking.Address')?>'.toLowerCase())" onmouseout="HidePopup()" type="text" class="textboxCalender corner5 text2_" placeholder="<?=dic('ChooseDestination')?>" style="border-bottom: 0px none; width: 236px; border-radius: 5px 0px 0px; border-right: 0px none;" />
    			<span onclick="ButtonAddEndDirectionClick(event, 0)" onmousemove="ShowPopup(event, '<?=dic('clickforendpoint')?>')" onmouseout="HidePopup()" style="float: right; cursor: pointer; right: 22px; padding: 4px 6px 2px 5px; position: absolute; border: 1px solid #ccc; height: 21px; border-radius: 0px 5px 0px 0px;"><img id="clickendaddress" src="../images/plus.png" width="20px" /></span>
    			<input id="direcitonAddressEnd" onclick="javascript: $('#toDirection').focus();" readonly="readonly" type="text" class="textboxCalender corner5 text2_" style="width: 269px; position: relative; float: left; border-radius: 0px 0px 5px 5px; background-color: #e9e9e9;" /><img id="loadingDirectionAddressEnd" style="float: right; position: absolute; display: none; right: 25px;" width="25px" src="../images/smallref.gif" border="0" align="absmiddle" />
    			<input id="directionLonEnd" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    			<input id="directionLatEnd" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    		</td>
		</tr>
		<tr style="height:5px;">
	         <td>
	         	<table id="ResultDirectionsTable" cellpadding="0" cellspacing="0" class="text2_" style="display: none; padding: 7px;">
	         		<tr>
	         			<td style="border-bottom: 1px dotted #2f5185">
	         				<span style="position: relative; float: left;"><?=dic('ShortRoute')?></span>
	         				<hr width="20px" style="position: relative; float: left; left: 10px; top: -1px; border-color: #0000FF; border-width: 4px 0px 0px;">
	         			</td>
	         			<td style="border-bottom: 1px dotted #2f5185; border-left: 1px dotted #2f5185; padding-left: 5px;">
         					<span style="position: relative; float: left;"><?=dic('FastRoute')?></span>
         					<hr width="20px" style="position: relative; float: left; left: 10px; top: -1px; border-color: #FF0000; border-width: 4px 0px 0px;">
     					</td>
	         		</tr>
	         		<tr>
	         			<td><div id="ResultDirections" style="display: none; width: 122px; height: auto;"></div></td>
	         			<td style="border-left: 1px dotted #2f5185; padding: 5px;"><div id="ResultDirectionsF" style="display: none; width: 127px; height: auto;"></div></td>
	         		</tr>
	         	</table>
	         </td>
	    </tr>
		<tr style="height:5px;">
	         <td><div style="border-bottom: 1px dotted rgb(190, 190, 190); margin-left: -5px; width: 278px;"></div></td>
	    </tr>
	</table>
    <br />
	<div align="right" style="display:block; width:270px; height: 30px; padding-top: 5px; position: relative; float: right; right: 20px;">
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelDirections" value="<?php echo dic("Tracking.Close")?>" onclick="$('#div-Directions').css({display: 'none'}); clearDirectionS(); clearDirectionE(); ButtonAddEndDirectionClick(); ButtonAddStartDirectionClick();" />        
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnDirections" value="<?=dic('calculate')?>" onclick="GetDirections('0')" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnSaveDirections" value="<?=dic('Save')?>" onclick="SaveDirections('0')" />
	</div><br /><br />
</div>
<input type="hidden" id="datetimenow" value="" />
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

<script type="text/javascript">

	//$(document).ready(function () {
    	//jQuery('body').bind('touchmove', function(e){e.preventDefault()});
    //});
    
    
    $("#div-Directions").mousemove(function(event) {
    	$(this).css({opacity: '1'});
    });
    $("#div-Directions").mouseout(function(event) {
    	$(this).css({opacity: '0.8'});
    });
    
    $('#btnDirections').button();
    $('#btnSaveDirections').button();
    $('#btnCancelDirections').button();
    $("#toDirection").autocomplete({
        //This bit uses the geocoder to fetch address values
        source: function (request, response) {
            geocoder.geocode({ 'address': request.term }, function (results, status) {
                response($.map(results, function (item) {
                    return {
                        label: item.formatted_address,
                        value: item.formatted_address,
                        latitude: item.geometry.location.lat(),
                        longitude: item.geometry.location.lng()
                    }
                }));
            })
        },
        //This bit is executed upon selection of an address
        select: function (event, ui) {
        	clearDirectionE();
        	ButtonAddEndDirectionClick();
        	setCenterMap(ui.item.longitude, ui.item.latitude, 18, 0);
        	AddMarkerDestinationE1(ui.item.longitude, ui.item.latitude);
        	//ButtonAddDirectionClick(event, 0);
            /*setCenterMap(ui.item.longitude, ui.item.latitude, 18, num);
            AddMarkerS(ui.item.longitude, ui.item.latitude, num, ui.item.label);*/
           
        },
        open: function () { clearDirectionE('0'); $("#toDirection").autocomplete("widget").width(269); }
    });
    $("#fromDirection").autocomplete({
        //This bit uses the geocoder to fetch address values
        source: function (request, response) {
            geocoder.geocode({ 'address': request.term }, function (results, status) {
                response($.map(results, function (item) {
                    return {
                        label: item.formatted_address,
                        value: item.formatted_address,
                        latitude: item.geometry.location.lat(),
                        longitude: item.geometry.location.lng()
                    }
                }));
            })
        },
        //This bit is executed upon selection of an address
        select: function (event, ui) {
        	//$("#vozilcaDirection option[value=-1]").attr('selected', 'selected');
        	$("#vozilcaDirection").val(-1);
        	clearDirectionS();
        	ButtonAddStartDirectionClick();
        	setCenterMap(ui.item.longitude, ui.item.latitude, 18, 0);
        	AddMarkerDestinationS1(ui.item.longitude, ui.item.latitude);
        },
        open: function () { clearDirectionS('0'); $("#fromDirection").autocomplete("widget").width(269); }
    });
    function clearDirectionS(_ch) {
    	$('#fromDirection').removeAttr('required');
	    if (tmpMarkerDirectionS != undefined) {
	        vectors[0].removeFeatures(tmpMarkerDirectionS);
	        tmpMarkerDirectionS = undefined;
	    }
	    if(_ch == undefined)
	    	$('#fromDirection').val('')
    	$('#direcitonAddress').val('');
    	$('#directionLat').val('');
    	$('#directionLon').val('');
    	$('#ResultDirections').css({ display: 'none' });
        $('#ResultDirections').html('');
        $('#ResultDirectionsF').css({ display: 'none' });
        $('#ResultDirectionsF').html('');
        $('#ResultDirectionsTable').css({ display: 'none' });
        if(lineFeatureDirections[0] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[0].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[0][i]]);
	        }
	        lineFeatureDirections[0] = [];
       	}
       	if(lineFeatureDirections[1] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[1].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[1][i]]);
	        }
	        lineFeatureDirections[1] = [];
       	}
    }
    function clearDirectionE(_ch) {
    	$('#toDirection').removeAttr('required');
    	if (tmpMarkerDirectionE != undefined) {
	        vectors[0].removeFeatures(tmpMarkerDirectionE);
	        tmpMarkerDirectionE = undefined;
	    }
	    if(_ch == undefined)
	    	$('#toDirection').val('')
	    $('#direcitonAddressEnd').val('');
    	$('#directionLatEnd').val('');
    	$('#directionLonEnd').val('');
    	$('#ResultDirections').css({ display: 'none' });
        $('#ResultDirections').html('');
        $('#ResultDirectionsF').css({ display: 'none' });
        $('#ResultDirectionsF').html('');
        $('#ResultDirectionsTable').css({ display: 'none' });
        if(lineFeatureDirections[0] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[0].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[0][i]]);
	        }
	        lineFeatureDirections[0] = [];
       	}
       	if(lineFeatureDirections[1] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[1].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[1][i]]);
	        }
	        lineFeatureDirections[1] = [];
       	}
    }
    function ChangeVozDir() {
    	ButtonAddStartDirectionClick();
    	clearDirectionS();
    	if($("#vozilcaDirection").find('option:selected').val() != '-1') {
	    	for(var i=0; i<Car.length; i++) {
	            if(Car[i].id == $("#vozilcaDirection").find('option:selected').val()){
	                $('#direcitonAddress').val('');
				    $('#directionLon').val('');
				    $('#directionLat').val('');
				    $('#loadingDirectionAddress').css({ display: "block" });
				    $.ajax({
				        url: twopoint + "/main/getGeocode.php?lon=" + Car[i].lon + "&lat=" + Car[i].lat + "&tpoint=" + twopoint,
				        context: document.body,
				        success: function (data) {
				            $('#direcitonAddress').val(data);
				            $('#loadingDirectionAddress').css({ display: "none" });
				            $('#fromDirection').val($("#vozilcaDirection").find('option:selected').html())
				        }
				    });
				    $('#directionLat').val(Car[i].lat)
				    $('#directionLon').val(Car[i].lon)
	                break;
	            }
	        }
       	}
    }
    function SwitchPoints() {
    	var tmpLon = $('#directionLon').val();
    	var tmpLat =  $('#directionLat').val();
    	var tmpFromDir =  $('#fromDirection').val();
    	var tmpDirAddress = $('#direcitonAddress').val();
    	vectors[0].removeFeatures(tmpMarkerDirectionS);
    	tmpMarkerDirectionS = undefined;
    	vectors[0].removeFeatures(tmpMarkerDirectionE);
	    tmpMarkerDirectionE = undefined;
	    
	    $('#directionLon').val($('#directionLonEnd').val());
	    $('#directionLat').val($('#directionLatEnd').val());
    	$('#fromDirection').val($('#toDirection').val());
    	$('#direcitonAddress').val($('#direcitonAddressEnd').val());
    	
    	$('#directionLonEnd').val(tmpLon);
	    $('#directionLatEnd').val(tmpLat);
    	$('#toDirection').val(tmpFromDir);
    	$('#direcitonAddressEnd').val(tmpDirAddress);
    	
    	AddMarkerDirectionS($('#directionLon').val(), $('#directionLat').val(), 0, $('#direcitonAddress').val());
    	AddMarkerDirectionE($('#directionLonEnd').val(), $('#directionLatEnd').val(), 0, $('#direcitonAddressEnd').val());
    	
    	$('#ResultDirections').css({ display: 'none' });
	    $('#ResultDirections').html('');
	    $('#ResultDirectionsF').css({ display: 'none' });
	    $('#ResultDirectionsF').html('');
	    $('#ResultDirectionsTable').css({ display: 'none' });
	    $("#vozilcaDirection").val(-1);
	    GetDirections('1');
    }
    clientid = '<?=session("client_id")?>';
    
    
    var passwordforblock = '<?=$pass?>';
    
	engineon = '<?=$engineon?>';
	engineoff = '<?=$engineoff?>';
	engineoffpassengeron = '<?=$engineoffpassengeron?>';
	satelliteoff = '<?=$satelliteoff?>';
	taximeteron = '<?=$taximeteron?>';
	taximeteroffpassengeron = '<?=$taximeteroffpassengeron?>';
	passiveon = '<?=$passiveon?>';
	activeoff = '<?=$activeoff?>';
 
    var allowedMess = '<?php echo $allowedMess?>';
	var allowedAlarms = '<?php echo $allowedAlarms?>';

	traceForUser = '<?php echo $trace?>';
	
	if(allowedAlarms == '1')
	{
		var snoozeTmp = 0;
		snooze = '<?php echo $snooze?>';
		$('#alertsNew').val('0');
	}
	liq = '<?php echo $liquidunit?>';
	metric = '<?php echo $metric?>';
	dateformatU_ = '<?php echo $dateformat?>';
	timeformatU_ = '<?php echo $timeformat1?>';
	numdelimiter = '<?php echo $numdelimiter?>';
	tempunit = '<?php echo $tempunit?>';
	if(metric != 'mi') {
		//var urlForWeather = 'http://api.openweathermap.org/data/2.5/weather?lat=##LAT##&lon=##LON##&units=metric&lang=##LANG##';
		//var urlForWeather = 'http://www.myweather2.com/developer/forecast.ashx?uac=RPBC-36uCY&output=json&query=##LAT##,##LON##&temp_unit=c&ws_unit=mps&callback=?';
		//var urlForWeather = 'api.worldweatheronline.com/free/v2/weather.ashx?q=##LAT##,##LON##&format=json&fx=no&cc=yes&fx24=no&includelocation=yes&show_comments=no&tp=3&key=f92008350f329b70e85c27c14e084';
		var urlForWeather = 'http://api.wunderground.com/api/240cbcbe0238d14a/conditions/lang:##LANG##/q/##LAT##,##LON##.json';
	} else {
		//var urlForWeather = 'http://api.openweathermap.org/data/2.5/weather?lat=##LAT##&lon=##LON##&units=imperial&lang=##LANG##';
		//var urlForWeather = 'http://www.myweather2.com/developer/forecast.ashx?uac=RPBC-36uCY&output=json&query=##LAT##,##LON##&temp_unit=f&ws_unit=mph&callback=?';
		//var urlForWeather = 'api.worldweatheronline.com/free/v2/weather.ashx?q=##LAT##,##LON##&format=json&fx=no&cc=yes&fx24=no&includelocation=yes&show_comments=no&tp=3&key=f92008350f329b70e85c27c14e084';
		var urlForWeather = 'http://api.wunderground.com/api/240cbcbe0238d14a/conditions/lang:##LANG##/q/##LAT##,##LON##.json';
	}
	var imgForWeather = 'http://openweathermap.org/img/w/##IMG##.png';

	document.getElementById('top1').style.left = '290px';
	document.getElementById('top1').style.width = (document.body.clientWidth - 310) + 'px';
	document.getElementById('iFrmS').style.height = (document.getElementById('topmiddle1').offsetHeight-20) + 'px';
	var TopPanelVisible = true;

	
	var geocoder = new google.maps.Geocoder();

    $("#gfGroup dd ul li a").click(function() {
        var text = $(this).html();
        $("#gfGroup dt a")[0].title = this.id;
        document.getElementById("groupidTEst").title = this.id;
        $("#gfGroup dt a span").html(text);
        $("#gfGroup dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });
    if(allowedAlarms == '1')
    	$('#div-mainalerts').css({ height: (document.body.clientHeight - 75) + 'px' });
    
    $('#race-img').css({ top: (document.body.clientHeight / 2 - 35) + 'px' });
    $(".dropdown dt a").click(function() {
        $(".dropdown dd ul").toggle();
    });
    $(".dropdown dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdown dt a")[0].title = this.id;
        document.getElementById("groupidTEst").title = this.id;
        if(text.indexOf("pin-1") != -1)
        	$(".dropdown dt a span").html(text.replace('top: -5px', 'top: -1px'));
        else
			$(".dropdown dt a span").html(text);
        $(".dropdown dd ul").hide();
    });
    
    $(".dropdownRadius dt a").click(function() {
        $(".dropdownRadius dd ul").toggle();
    });
    $(".dropdownRadius dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdownRadius dt a")[0].title = this.id;
        
        $(".dropdownRadius dt a span").html(text);
        $(".dropdownRadius dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });

    function getSelectedValue(id) {
        return $("#" + id).find("dt a span.value").html();
    }

    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("dropdown"))
            $(".dropdown dd ul").hide();
    });

    var savesettings = '<?php echo $SaveSettings?>';
    var _userId = '<?php echo session("user_id")?>';
    
	AllowedMaps = '<?php echo $AllowedMaps?>';
	DefMapType = '<?php echo $DefMap?>';

	var cntz = parseInt('<?php echo ($cntz-1)?>');
	
	//for (var cz=0; cz<cntz; cz++){
	//	document.getElementById('zona_'+cz).checked = false
	//}
	AllPOI = '<?php echo $allPOIs?>';
	
	legendStr = '<table border="0" cellpadding="0" cellspacing="0" width="200px">'
	legendStr = legendStr + '<tr><td width="20px" height="20px" colspan="2" class="text3"><?php echo dic("Tracking.Legend")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOn")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineOFF")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOff")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><img style="height: 14px; width: 14px; top: 0px; position: relative; left: 0px;" src="../images/nosignal.png"></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.LowSat")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><img style="height: 14px; width: 14px; top: 0px; position: relative; left: 0px;" src="../images/nocommunication.png"></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.LostComm")?></td></tr>'
	var CTUD = '<?=$ClientTypeID?>';
    traektorija = 180;
    if(parseInt(CTUD, 10) == 2)
    {
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineOFFPassengerON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOffPassOn")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "TaximeterON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.TaxOn")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "TaximeterOFFPassengerON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.TaxOffPassOn")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "PassiveON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.Engaged")?></td></tr>'
		traektorija = 30;
	}
	legendStr = legendStr + '</table>'
	
	
	var _currTime = '<?=$CurrentTime?>';
	var datetimeformat = '<?=$FormatDT?>';
    timeZone = parseInt('<?=$TimeZone?>', 10);
    
    allowgarmin = '<?=$allowgarmin?>';
    
	getCurrentTimeFirst();
	// OVA TREBA 
	LoadCurrentPosition = false;
    JustSave = true;
    RecOn = false;
    RecOnNew = false;

    ShowAreaIcons = true
    OpenForDrawing = true;

    ShowPOIBtn = false;
    ShowGFBtn = false;
    
    livetracking = true;
    allowweather = '<?=$weather?>';
    
	lang = '<?php echo $cLang?>';
	getLeftList(lang);

	VehicleList = [<?php echo $strVhList?>];
	VehicleListID = [<?php echo $strVhListID?>];
    VehcileIDs = [<?php echo $strVehcileID?>];
	VehcileIDsWS = '<?php echo $strVehcileID?>';
	//VehcileIDsWS = VehcileIDsWS.replace(/,/g,'|');
	
	VehicleListNotOENum = [<?php echo $strVhListNotOENum?>];
	VehicleListNotOEName = [<?php echo $strVhListNotOEName?>];

	VehicleListOEID = [<?php echo $strVhListOEID?>];
	VehicleListOENum = [<?php echo $strVhListOENum?>];
	VehicleListOEName = ['<?php echo $strVhListOEName?>'];
	
	StartLat = '<?php echo $sLat?>';
	StartLon = '<?php echo $sLon?>';
	CarStr = '<?php echo $CPosition?>';
	
	ParseCarStr()
	setLiveHeight()
    
    var _selSplit = getCookie(_userId + "_SelectedSpliter");
    if(_selSplit != "" && _selSplit != "0")
    {
        ShowSeparators();
        SelectSeparators(_selSplit, "1");
    }
    
    var _shLeft = getCookie(_userId + "_shLeft");

    if(_shLeft != "" && _shLeft == "0")
        shleft();
    
    CreateBoards();

	LoadMaps()
    
    AddLayerPlayNewRec(Boards[0], 0);
    
    if(_selSplit != "" && _selSplit !="0")
    {
        $('#div-spliter').remove();
    }
	iPadSettings()
	if (Browser()!='iPad') {
		$('#icon-draw-path').mousemove(function(event) {ShowPopup(event, '<?php echo dic("Tracking.ShowHideAllVeh")?>')});
    	$('#icon-draw-path-down').mousemove(function(event) {ShowPopup(event, '<?php echo dic("Tracking.ShowHideVeh")?>')});
		$('#icon-draw-path').mouseout(function() {HidePopup()});
    	$('#icon-draw-path-down').mouseout(function() {HidePopup()});
	}

    ShowActiveBoard();
    /*for(var i=0; i<Maps.length; i++){
        if(Maps[i] != null)
            zoomWorldScreen(Maps[i], DefMapZoom);
    }*/
	if(allowedAlarms == '1')
	{
		//ShowHideAlerts();
		//ShowHideMail();
		snoozeAlarm();
		//AjaxNotify();
		AjaxMessageNotify();
	}

</script>
<?php
	closedb();
?>
</html>
