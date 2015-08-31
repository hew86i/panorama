<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<html>
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo dic("Reports.PanoramaGPS")?></title>
	<link rel="stylesheet" type="text/css" href="styleGM.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">
    <link rel="stylesheet" href="mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />

<style type="text/css">
<!--

#top1 {position:absolute; left:220px; top:0px; width:80%; height:5px; border:0px solid #000000; z-index:9999}

#topmiddle {position:relative; float:left; left:0px; top:0px; width:100%; height:5px; border:0px solid #000000}
#topmiddle1 {position:relative; left:0px; top:0px; width:100%; height:1px; border-left:1px solid #cfcfd1; border-right:1px solid #cfcfd1; background-color:#FFFFFF;}
#topmiddle2 {position:relative; left:0px; top:0px; width:100%; height:14px;  background-image:URL(../images/topback.png)}
#strelkatop {position:relative; left:50%; top:0px; width:51px; height:14px; background-image:url(../images/dolus.png); z-index:5999; cursor:pointer}

-->
</style>

	<LINK REL="SHORTCUT ICON" HREF="../images/icon.ico">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="./live.js"></script>
	<script type="text/javascript" src="./live1.js"></script>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script type="text/javascript" src="./mlColorPicker.js"></script>
	<script type="text/javascript" src="../js/OpenLayers.js"></script>
	<script src="../js/jsxcompressor.js"></script>
	
	<script type="text/javascript" src="../js/jquery.collapsible.js"></script>

</head>

<?php
	set_time_limit(0);
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	//Ispituvame dali ima najaven korisnik. Ako nema mora da se odi na Login
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	opendb();
	
	$Allow = getPriv("livetracking", session("user_id"));
	if ($Allow==FALSE) {echo header( 'Location: ../?l='.$cLang."&err=permission");}
	
	$SaveSettings = FALSE;
	$sqlV = "";
	
	if (session("role_id")."" == "2"){
		$sqlV = "select id from vehicles where clientid=".session("client_id");
	} else {
		$sqlV = "select vehicleID from uservehicles where userid=".session("user_id"); 
	}
	$check = query("select chechVehicles(" . session("client_id") . ")");
	$strVhList = "";
	$strVhListID = "";
	$strVhListOEID = "";
	$strVhListOENum = "";
	$strVhListOEName = "";
	$strVhListNotOENum = "";
	$strVhListNotOEName = "";
	
	$dsVehicles = query("select cast(code as integer), registration, organisationid from vehicles where id in (".$sqlV.") order by code");
	
	while($row = pg_fetch_array($dsVehicles))
	{
		$strVhList .= ", '(<strong>".$row["code"]."</strong>)&nbsp;&nbsp;".trim($row["registration"]," ")."'";
		$strVhListID .= ", ".$row["code"];
		$strVhListOEID .= ", ".$row["organisationid"];
		if($row["organisationid"] == "0")
		{
			$strVhListNotOEName .= ", '(<strong>".$row["code"]."</strong>)&nbsp;&nbsp;".trim($row["registration"]," ")."'";
			$strVhListNotOENum .= ", ".$row["code"];
		}
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
	
	$ClientTypeID = dlookup("select clienttypeid from clients where id=".session("client_id"));
	//$allowedrouting = dlookup("select allowedrouting from clients where id=".session("client_id"));
	$ds = query("select allowedrouting, allowedfm from clients where id=" . session("client_id"));
	$allowedrouting = pg_fetch_result($ds, 0, "allowedrouting");
	$allowedFM = pg_fetch_result($ds, 0, "allowedfm");
	$fm = '';
	$fm1 = '';
	$routes = '';
	$routes1 = '';
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
	
	//echo $allowedrouting;
	//exit;
	$allPOI = dlookup("select count(*) from pointsofinterest where clientId=".session("client_id"));
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
	
   	$cntz = dlookup("select count(*) from pointsofinterest where type=2 and clientid=".session("client_id"));
	$TimeZone = DlookUP("select timezone from users where id=" . session("user_id"));
	$CurrentTime = DlookUP("select to_char(now() + cast('" . ($TimeZone-1) . " hour' as interval), 'YYYY-MM-DD HH:MI:SS') DateTime");
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	//echo $yourbrowser;
	//exit;
	
?>
<script>
	AllowAddPoi = '<?php echo $AllowAddPoi?>'
	AllowViewPoi = '<?php echo $AllowViewPoi?>'
	AllowAddZone = '<?php echo $AllowAddZone?>'
	AllowViewZone = '<?php echo $AllowViewZone?>'
</script>

<body onResize="setLiveHeight()">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="position: relative; z-index: 10;">
	<tr>
		<td  width="50%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999">
			&nbsp;<img src="../images/tiniLogo.png" border="0" align="absmiddle" />&nbsp;
			&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;
			<a id="icon-home" href="../?l=<?php echo $cLang?>"><img src="../images/shome.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-live" href=""><img src="../images/smap.png" border="0" align="absmiddle" style="opacity:0.4" /></a>&nbsp;
			<a id="icon-rep"  href="../report/?l=<?php echo $cLang?>#rep/menu_1_1" ><img src="../images/sdocument.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-route" onclick="<?php echo $routes?>" style="<?php echo $routes1?>" href="../routes/?l=<?php echo $cLang?>" ><img src="../images/srouting.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-fm"  onclick="<?php echo $fm?>" style="<?php echo $fm1?>" href="../fm/?l=<?php echo $cLang?>#fm/menu_2_1" ><img src="../images/sfm.png" border="0" align="absmiddle" /></a>&nbsp;
			&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;
			
            <a id="activeBoard" href="javascript:"></a>&nbsp;
			<a id="a-AddPOI" href="javascript:"></a>&nbsp;
			<a id="icon-poi" href="javascript:"></a>
            <a id="icon-poi-down" href="javascript:"></a>&nbsp;
			<a id="icon-draw-zone" href="javascript:"></a>
            <a id="icon-zone-down" href="javascript:"></a>&nbsp;
			<a id="icon-draw-path" href="javascript:"></a>
            <a id="icon-draw-path-down" href="javascript:"></a>&nbsp;
			<a id="a-split" href="javascript:"></a>&nbsp;
			
            <!--input id="testText" type="text" onclick="javascript: resetScreen = false;" style="width: 650px; position: absolute; top: 5px; left: 500px;" /-->
		</td>
		<td width="50%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999" align="right" class="text2" valign="middle">
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<?php if($yourbrowser != "1") { echo dic("Tracking.Company").":"; } ?> <strong><?php echo session("company")?></strong>&nbsp;&nbsp;&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<?php if($yourbrowser != "1") { echo dic("Tracking.User").":"; } ?> <strong><?php echo session("user_fullname")?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="span-time" style="cursor:help">22:55:36&nbsp;</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<!--a>
				<div id="alertsNew" class="corner5" style="background-color: Red; color: White; height: 13px; left: 0px; float: left; z-index: 134354; width: 13px; top: 0px; text-align: center;">1</div>
			</a-->
			<a id="icon-alert" style="position: relative; left: 15px; margin-left: -10px; opacity: 0.4">
				<img src="../images/warning1.png" onclick="ShowHideAlerts()" border="0" align="absmiddle" style="cursor: pointer;" />
				<input id="alertsNew" class="notify corner5" onclick="ShowHideAlerts()" style="visibility: hidden;" value="0" disabled />
			</a>&nbsp;
			<!--a>
				<div id="alertsNew" class="corner5" style="background-color: Red; color: White; height: 13px; left: 0px; float: left; z-index: 134354; width: 13px; top: 0px; text-align: center;">1</div>
			</a-->
			<a id="icon-mail" style="position: relative; left: 15px; margin-left: -10px; opacity: 0.4">
				<img src="../images/mail.png" onclick="ShowHideMail()" border="0" align="absmiddle" style="cursor: pointer;" />
				<input id="mailNew" class="notify corner5" onclick="ShowHideMail()" style="visibility: hidden;" value="0" disabled />
			</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="icon-sett" href="../settings/?l=<?php echo $cLang?>"><img src="../images/ssettings.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-help"><img src="../images/shelp.png" border="0" align="absmiddle" /></a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;		
			<a id="icon-logout" href="../logout/?l=<?php echo $cLang?>"><img src="../images/exit.png" border="0" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>
<table id="live-table" width="100%" border="0" cellpadding="0" cellspacing="0" style="position: relative;">
	<tr>
		<td id="vehicle-list" width="250px" valign="top">
			<div id="div-menu" style="width:248px; overflow-y:auto; overflow-x:hidden; display: none">
			</div>
            <div id="race-img" style="position:absolute; left: 250px; width:8px; height:50px; background-image:url(../images/racelive.png); background-position: -8px 0px; z-index: 2000; cursor:pointer" onClick="shleft()"></div>
		</td>
		<td id="maps-container" valign="top" style="border-left: 2px Solid #387cb0"><!--groletna.aspx?t=2-->
			<div id="dialog-map" style="display:none; z-index: 9999" title="<?php echo dic_("Reports.ViewOnMap")?>"></div>
			<div id="div-mainalerts" onmouseover="clearTimeOutAlertView()" onmouseout="setTimeOutAlertView()" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; border: 0px; right: 35px; float: right; position: absolute; z-index: 9999; top: 20px; width: 315px; overflow-x: hidden; overflow-y: auto;"></div>
			<div id="div-map"></div>
			<?php
		
			if($allowedrouting == "1")
			{
			?>
			<div id="top1">
				<div id="topmiddle">
					<div id="topmiddle1" onMouseOver="this.style.opacity = 1; this.style.filter = 'alpha(opacity=100)';" onMouseOut="this.style.opacity = 0.8; this.style.filter = 'alpha(opacity=80)';">
						<iframe id="iFrmS" name="iFrmS" src="NaloziDenes.php"  frameborder="0" scrolling="auto" style="position:absolute;width:100%; top:0px; display:none;"></iframe>
					</div>
					<div id="topmiddle2">
						<div id="strelkatop" onClick="HideShowTopPanel(0)"></div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
		</td>
	</tr>
</table>
<div id="icon-legenda" style="position: relative; cursor: help; float: right; z-index: 3000; margin-right: 10px;"><img src="../images/legenda.png" border="0" align="absmiddle" /></div>
<div id="dialog-message" title="<?php echo dic("Tracking.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAll" style="font-size:11px; padding-left: 23px;"><input id="InfoForAll" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?></div>
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
    <img id="loadingIconsPOI" style="visibility: hidden; width: 150px; position: absolute; left: 32px; top: 185px;" src="../images/loading_bar1.gif" alt="" />
    <br><br>
    <span id="spanIconsPOI" style="display:none; width:90px; float:left; margin-left:20px; position: relative; top: 9px;"><?php echo dic("General.Icon")?></span>
    <table id="tblIconsPOI" border="0" style="display: none; width: 268px; text-align: center; position: relative; top: -10px; left: -15px;">
        <tr>
        <?php
            for ($icon=0; $icon <= 0; $icon++) { 
        ?>
            <td><img id="GroupIconImg<?php echo $icon?>" src="http://gps.mk/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
        <?php
            }
        ?>
        </tr>
        <tr>
        <?php

            for ($icon=0; $icon <= 0; $icon++) { 
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
        <!--tr>
        <?php
            for ($icon=8; $icon <= 14; $icon++) { 
            ?>
            <td  style="padding-top: 20px"><img id="GroupIconImg<?php echo $icon?>" src="http://gps.mk/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
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
            <td  style="padding-top: 20px"><img id="GroupIconImg<?php echo $icon?>" src="http://gps.mk/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
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
        </tr-->
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
			        <input type="radio" id="APcheck1" name="radio" /><label for="APcheck1">Корисник</label>
			        <input type="radio" id="APcheck2" name="radio" /><label for="APcheck2">Организациона единица</label>
			        <input type="radio" id="APcheck3" name="radio" /><label for="APcheck3">Компанија</label>
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
			                <li><a id="RadiusID_50" href="#">50&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
			                <li><a id="RadiusID_70" href="#">70&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
			                <li><a id="RadiusID_100" href="#">100&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
			                <li><a id="RadiusID_150" href="#">150&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
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
					$dsUG = query("SELECT id, name, fillcolor, '0' image FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#" title="" id="groupidTEst" class="combobox1"><span><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG, 0, "id")?>" href="#">&nbsp;&nbsp;<?php echo dic("Settings.NotGroupedItems")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo pg_fetch_result($dsUG, 0, "fillcolor")?>&type=<?php echo pg_fetch_result($dsUG, 0, "image")?>') no-repeat; position: relative; float: left;"></div></a></li>
			                <?php
								$dsGroup1 = query("select id, name, fillcolor, '0' image from pointsofinterestgroups where clientid=".session("client_id"));
			                    while ($row1 = pg_fetch_array($dsGroup1)) {
			                    	$_color = substr($row1["fillcolor"], 1, strlen($row1["fillcolor"]));
			                ?>
			                <li><a id="<?php echo $row1["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row1["name"]?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo $_color?>&type=<?php echo $row1["image"]?>') no-repeat; position: relative; float: left;"></div></a></li>
			                <?php
			                    }
			                ?>
			            </ul>
			        </dd>
			    </dl>
    			<input type="button" id="AddGroup" style="left: 20px; top: 1px;" onclick="AddGroup('0')" value="+" />
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
	<table style="font-size: 11px; color: rgb(65, 65, 65); font-family: Arial,Helvetica,sans-serif;" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td width="90px"><?php echo dic("Tracking.GFName")?>:</td>
			<td><input id="txt_zonename" type="text" value="" class="textboxcalender corner5 text5" style="width: 301px; height: 22px; font-size: 11px;" /></td>
		</tr>
		<tr height="50px">
			<td><?php echo dic("Tracking.AvailableFor")?>:</td>
			<td>
				<div id="gfAvail" class="corner5">
			        <input type="radio" id="GFcheck1" name="radio" /><label for="GFcheck1">Корисник</label>
			        <input type="radio" id="GFcheck2" name="radio" /><label for="GFcheck2">Организациона единица</label>
			        <input type="radio" id="GFcheck3" name="radio" /><label for="GFcheck3">Компанија</label>
			    </div>
			</td></tr>
		<tr>
			<td><?php echo dic("Tracking.Group")?>:</td>
			<td>
				<dl id="gfGroup" class="dropdown" style="width: 150px; position: relative; float: left; margin: 0px;">
			    <?php
				$dsUG1 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE id=1");
		        ?>
		        <dt><a href="#" title="" class="combobox1"><span><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
		        <dd>
		            <ul>
		                <li><a id="<?php echo pg_fetch_result($dsUG1, 0, "id")?>" href="#">&nbsp;<?php echo dic("Settings.NotGroupedItems")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo pg_fetch_result($dsUG1, 0, "fillcolor")?>; position: relative; float: left;"></div></a></li>
		                <?php
		                    $dsGroup2 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE clientid=".session("client_id"));
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
			</td></tr>
	</table>
    <br />
	<div style="width:620px; height:180px; background-color:#c6d7f2; border:1px solid #95b1d7; overflow-h:hidden; overflow-y:auto">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 11px">
		<?php
			$strVehcileID = "";
			$dsvv = query("select cast(code as integer), id, registration from vehicles where clientid=".session("client_id")." order by code");
            while ($row = pg_fetch_array($dsvv))
            {
            	$strVehcileID .= ",".$row["id"];
		?>
            <tr>
                <td><strong>(<?php echo $row["code"]?>) <?php echo $row["registration"]?></strong></td>
                <td><label><input type="checkbox" id="av_<?php echo $row["id"]?>" /><?php echo dic("Tracking.AllowedInGeoFence")?></label></td>
                <td><label><input type="checkbox" id="in_<?php echo $row["id"]?>"/><?php echo dic("Tracking.AlertEnter")?></label></td>
                <td><label><input type="checkbox" id="out_<?php echo $row["id"]?>"/><?php echo dic("Tracking.AlertExit")?></label></td>
            </tr>
		<?php
			}
			if (strlen($strVehcileID)>0) {
				$strVehcileID = substr($strVehcileID,1);	
			}
		?>
        </table>
	</div>
	<label><input type="checkbox" id="chk_1_in" /><?php echo dic("Tracking.AlertAllowEnter")?></label><br />
	<label><input type="checkbox" id="chk_1_out"/><?php echo dic("Tracking.AlertAllowExit")?></label><br />
	<label><input type="checkbox" id="chk_2_in" /><?php echo dic("Tracking.AlertNotAllowEnter")?></label><br />
	<label><input type="checkbox" id="chk_2_out"/><?php echo dic("Tracking.AlertNotAllowExit")?></label><br />
	<div style="display:block; height:10px"></div>

	<strong><?php echo dic("Tracking.AlertEmail")?>: <span style="font-size:10px; color:#666">(<?php echo dic("Tracking.Example")?>: John@google.com, Marc@yahoo.com)</span>:</strong><br />
	<input id="txt_emails" type="text" value="" class="textboxcalender corner5 text5" style="width:622px; height:22px; font-size:11px"/><br />
	<div style="display:block; height:10px"></div>
	<strong><?php echo dic("Tracking.AlertPhone")?>: <span style="font-size:10px; color:#666">(<?php echo dic("Tracking.MacExample")?>: 075100000, 071100000)</span>:</strong><br />
	<input id="txt_phones" type="text" value="" class="textboxcalender corner5 text5" style="width:622px; height:22px; font-size:11px"/><br />
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

<script type="text/javascript">

	$('#alertsNew').val('0');

	var ar = '<?php echo $allowedrouting?>';
	if(ar == "1")
	{
		document.getElementById('top1').style.left = '290px';
		document.getElementById('top1').style.width = (document.body.clientWidth - 310) + 'px';
		document.getElementById('iFrmS').style.height = (document.getElementById('topmiddle1').offsetHeight-20) + 'px';
		var TopPanelVisible = true;
	} else
		var TopPanelVisible = false;
	
	var geocoder = new google.maps.Geocoder();

    $("#gfGroup dd ul li a").click(function() {
        var text = $(this).html();
        $("#gfGroup dt a")[0].title = this.id;
        document.getElementById("groupidTEst").title = this.id;
        $("#gfGroup dt a span").html(text);
        $("#gfGroup dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });
    
    $('#div-mainalerts').css({ height: (document.body.clientHeight - 75) + 'px' });
    
    $('#race-img').css({ top: (document.body.clientHeight / 2 - 35) + 'px' });
    $(".dropdown dt a").click(function() {
        $(".dropdown dd ul").toggle();
    });
    $(".dropdown dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdown dt a")[0].title = this.id;
        document.getElementById("groupidTEst").title = this.id;
        $(".dropdown dt a span").html(text);
        $(".dropdown dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
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
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "SatelliteOFF")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.LowSat")?></td></tr>'
	var CTUD = '<?php echo $ClientTypeID ?>';
    
    if(parseInt(CTUD, 10) == 2)
    {
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineOFFPassengerON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOffPassOn")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "TaximeterON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.Engaged")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "TaximeterOFFPassengerON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.TaxOffPassOn")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "PassiveON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.TaxOn")?></td></tr>'
	}
	legendStr = legendStr + '</table>'
	
	
	var _currTime = '<?php echo $CurrentTime?>';
    timeZone = parseInt('<?php echo $TimeZone?>', 10);
	getCurrentTime();
	// OVA TREBA 
	LoadCurrentPosition = false;
    JustSave = true;
    RecOn = false;

    ShowAreaIcons = true
    OpenForDrawing = true;

    ShowPOIBtn = false;
    ShowGFBtn = false;
    
	lang = '<?php echo $cLang?>';
	getLeftList(lang);

	VehicleList = [<?php echo $strVhList?>];
	VehicleListID = [<?php echo $strVhListID?>];
    VehcileIDs = [<?php echo $strVehcileID?>];

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
    for(var i=0; i<Maps.length; i++){
        if(Maps[i] != null)
            zoomWorldScreen(Maps[i], DefMapZoom);
    }
	ShowHideAlerts();
	ShowHideMail();
</script>
<?php
	closedb();
?>
</html>