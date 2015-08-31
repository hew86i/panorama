<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	
	$veh = getQUERY("veh");
	
	set_time_limit(0);
	opendb();
	
	$dsCP = query('select cast(v.code as integer), v.registration, v.fuelcapacity, v.allowtemp altemp, v.alias, v.allowfuel alfuel, v.allowrpm alrpm, v.showrpm, v.allowcanbas alcanbas, v.model, cp.*, cp."DateTime" tzdatetime, visible from currentposition cp left outer join vehicles v on v.id=cp.vehicleid where v.id in (' . $veh . ')  order by 1');

    $dsDriv = query("select id, fullname from drivers where clientid=".session("client_id"));

	

	/*$dsAllMaps = query("select AMapsGoogle, AMapsOMS, AMapsBing, AMapsYahoo, Satellite from usersettings where userID=" . session("user_id"));
	$AllowedMaps = "";
	if (count($dsAllMaps)>0){
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
	$dsAllowed = query("select metric,timedate,speed,location,poi,zone,passengers,taximeter,fuel, cbfuel, cbrpm, cbtemp, cbdistance, liquidunit, tempunit from users where id=" . session("user_id"));
	$metric = pg_fetch_result($dsAllowed, 0, "metric");
	if ($metric == 'mi') {
		$metricvalue = 0.621371;
		$speedunit = "mph";
	} else {
		$metricvalue = 1;
		$speedunit = "Km/h";
	}
	$liq = pg_fetch_result($dsAllowed, 0, 'liquidunit');
	if ($liq == 'galon') {
		$liqvalue = 0.264172;
		$liqunit = "gal";
	} else {
		$liqvalue = 1;
		$liqunit = "lit";
	}
	$tempunit = pg_fetch_result($dsAllowed, 0, "tempunit");
	
	if(pg_fetch_result($dsAllowed, 0, "cbfuel") == "1" || pg_fetch_result($dsAllowed, 0, "cbrpm") == "1" || pg_fetch_result($dsAllowed, 0, "cbtemp") == "1" || pg_fetch_result($dsAllowed, 0, "cbdistance") == "1")
		$AllowedCANbus = "1";
	else
		$AllowedCANbus = "0";
	
	if(pg_fetch_result($dsAllowed, 0, "speed") != "1" && pg_fetch_result($dsAllowed, 0, "taximeter") != "1" && pg_fetch_result($dsAllowed, 0, "passengers") != "1")
		$AllowedSTP = "0";
	else
		$AllowedSTP = "1";
	$AllowViewZone = getPriv("ViewZones", session("user_id"));
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	if($yourbrowser == "1")
		$wid = '91px';
	else
		$wid = '91px';
	
	//$ClientTypeID = dlookup("select clienttypeid from clients where id=".session("client_id"));
	$dsFM = query("select allowedfm, allowedalarms, clienttypeid from clients where id=" . session("client_id"));
	$ClientTypeID = pg_fetch_result($dsFM, 0, "clienttypeid");
	$allowedFM = pg_fetch_result($dsFM, 0, "allowedfm");
	$allowedAlarms = pg_fetch_result($dsFM, 0, "allowedalarms");
	$fm = '';
	$fm1 = '';
	$al = '';
	$al1 = '';
	$al2 = '';
	$al3 = '';
	if(!$allowedFM)
	{
		$fm = 'return false;';
		$fm1 = 'opacity: 0.4;';
	}
	if(!$allowedAlarms)
	{
		$al = 'return false;';
		$al1 = 'opacity: 0.4;';
		$al2 = '-collapsed';
		$al3 = 'height: 33px;';
	}
	
	$dsVehicles = query("select cast(code as integer), id from vehicles where id in (".$veh.") order by code");

?>

	<div id="menu-container-2" style="width:230px; padding-left:10px; padding-bottom:10px; overflow:auto">
		<?php
			$brojaaac = 1;
			while($row = pg_fetch_array($dsCP))
			{
				$lon = $row["longitude"];
				$lat = $row["latitude"];
				//if($row["LongOrientation"] == "W") $lon = "-" & $lon;
				//if($row["LatOrientation"] == "S") $lat = "-" & $lat;
				$tzDatetime = new DateTime($row["tzdatetime"]);
				
				$strDrivName = "";
	        	$dsDrivName = query("select d.fullname from drivervehicle vd left outer join drivers d on vd.driverid=d.id where vd.vehicleid=" . $row["vehicleid"] . " and vd.enddate is null");
	        	if(pg_num_rows($dsDrivName) > 0) {
	            	$strDrivName = pg_fetch_result($dsDrivName, 0, "fullname");
				}
		        else
		            $strDrivName = "/";
		       //$dsPre = query("select ID, code, FullName from Drivers where clientid=" . Session("client_id") . " and id in (select Driverid from VehicleDriver where VehicleID in (select id from Vehicles where ID=" . $row["vehicleid"] . ")) order by FullName");
		        //$dsPre = query("select * from drivers where clientid=" . Session("client_id"));
			?>
			
			<div id="vehicleList-<?php echo $row["code"]?>" style="overflow: hidden; padding-top: 0px; margin-top: 0px; border: 2px solid #387CB0" class="div-one-vehicle-list text3 corner5">
	            <div style="width: <?php echo $wid?>; float:left;">
					<div id="vh-small-<?php echo $row["code"]?>" class="gnMarkerListGray" style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer"><?php echo $row["code"]?></div>
					<div style="color: #000000; width: 68px; height: 14px; overflow: hidden; float:left; padding-top:2px; padding-left:3px; font-weight:bold; cursor:pointer"><?php echo $row["registration"]?></div>
				</div>
				<?php if(pg_fetch_result($dsAllowed, 0, "timedate") == "1"){
                ?>
				<div id="vh-date-<?php echo $row["code"]?>" style="width:105px; position: relative; right: 2px; top: 2px; float:right; text-align:right; color:#000000; font-size:10px;">
				<?php echo $tzDatetime->format("d-m-Y H:i:s").''?>
				</div>
				<?php } 
					if(true){
						if($row["alias"].'' != '')
						{
                ?>
                <div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Reports.Alias")?>: <span style="font-weight: bold" id="vh-alias-<?php echo $row["code"]?>"><?php echo $row["alias"]?></span>
				</div>
				<?php }?>
	            <div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic_("Tracking.Driver") ?>: <span style="font-weight: bold" id="vh-driver-<?php echo $row["code"]?>"><?php echo $strDrivName ?></span>
				</div>
	            <div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Fm.Marka")
					    ?>: <span style="font-weight: bold" id="vh-type-<?php echo $row["code"]?>"><?php echo $row["model"]?></span>
				</div>
				<?php
					if($row["alrpm"]."" == "1"){ ?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Tracking.rpm")
					    ?>: <span style="font-weight: bold" id="vh-rpm-<?php echo $row["code"]?>"> 0 <?=$row["showrpm"]?></span>
				</div>
				<?php }
					if($row["altemp"] == "1"){ ?>
				<div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Tracking.Temp")
					    ?>: <span style="font-weight: bold" id="vh-temp-<?php echo $row["code"]?>"> 0 °<?=$tempunit?></span>
				</div>
				
	            <?php }
					if($row["alfuel"] == "1"){ ?>
				<div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Tracking.Fuel")
					    ?>: <span style="font-weight: bold" id="vh-litres-<?php echo $row["code"]?>"> 0 <?= $liqunit ?></span>
				</div>
				
	            <?php }
					}
				
	            	if($AllowedSTP == "1"){
                ?>
				<div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php
						if(pg_fetch_result($dsAllowed, 0, "speed") == "1"){ ?>
					<?php echo dic("Tracking.Speed")?>: <span style="font-weight: bold" id="vh-speed-<?php echo $row["code"]?>">0 <?=$speedunit?></span>&nbsp;
					<?php } 
						if(pg_fetch_result($dsAllowed, 0, "taximeter") == "1"){
					?>
					<span id="div-taxi-<?php echo $row["code"]?>" style="color:#ff0000;"><?php echo dic("Tracking.Taximeter")?></span>&nbsp;
					<?php } 
						if(pg_fetch_result($dsAllowed, 0, "passengers") == "1"){
					?>
					<span><?php echo dic("Tracking.Passengers")?>:</span><span id="vh-sedista-<?php echo $row["code"]?>" style="font-size:11px; color:#000066;">0</span>
					<?php } ?>
				</div>
				<?php }
					if($row["alcanbas"] == "1") {
					if($AllowedCANbus == "1") {
                ?>
				<div id="vh-canbus-<?php echo $row["code"]?>" id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php
						if(pg_fetch_result($dsAllowed, 0, "cbfuel") == "1"){
							$fuel = $row["cbfuel"];
							$fuel = 1000*$fuel/100;							
					?>
					<div id="vh-cbfuel1-<?php echo $row["code"]?>"><?php echo dic("Tracking.Fuel")?>: <span id="vh-cbfuel-<?php echo $row["code"]?>" style="font-weight: bold"><?php echo round($fuel*$liqvalue) ?> <?=$liqunit?></span></div>
					<?php } 
						if(pg_fetch_result($dsAllowed, 0, "cbrpm") == "1"){
					?>
					<div id="vh-cbrpm1-<?php echo $row["code"]?>"><?php echo dic("Tracking.rpm")?>: <span id="vh-cbrpm-<?php echo $row["code"]?>" style="font-weight: bold"><?php echo round($row["cbrpm"])?> rpm</span></div>
					<?php } 
						if(pg_fetch_result($dsAllowed, 0, "cbtemp") == "1"){
					?>
					<div id="vh-cbtemp1-<?php echo $row["code"]?>"><?php echo dic("Tracking.Temp")?>: <span id="vh-cbtemp-<?php echo $row["code"]?>" style="font-weight: bold"><?php echo round(converttemp($row["cbtemp"], $tempunit))?> °<?= $tempunit?></span></div>
					<?php } 
					if(pg_fetch_result($dsAllowed, 0, "cbdistance") == "1"){
					?>
					<div id="vh-cbdistance1-<?php echo $row["code"]?>"><?php echo dic("Reports.Odometer")?>: <span id="vh-cbdistance-<?php echo $row["code"]?>" style="font-weight: bold"><?php echo round($row["cbdistance"] / 1000 * $metricvalue)?> <?=$metric?></span></div>
					<?php } ?>
				</div>
				<?php }}
	            	if(pg_fetch_result($dsAllowed, 0, "poi") == "1"){
                ?>
				<div style="width:205px; padding-left:5px; padding-right:5px; float:left; background-color:#fafafa; color:#333333; font-size:10px; border-top:1px dotted #333">
	                <img id="vh-pp-pic-<?php echo $row["code"]?>" onmouseover="ShowPopup(event, '<img src=\'../images/poiButton.png\' style=\'position: relative; float: left;\' /><div style=\'position: relative; float: left; margin-left: 7px; margin-top: 5px; padding-right: 3px;\'><?php echo dic("Tracking.POI")?></div>')" onmouseout="HidePopup()" src="../images/poiButton.png" width="14px" style="padding-top: 2px; padding-bottom: 2px; position: relative; float: left;" />
	                <div id="vh-pp-<?php echo $row["code"]?>" style="width: 190px; position: relative; float: right; left: 5px; top: 1px;"></div>
				</div>
				<?php } 
	            	if(pg_fetch_result($dsAllowed, 0, "location") == "1"){
                ?>
	            <div style="width:205px; padding-left:5px; padding-right:5px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
	                <img id="vh-location-pic-<?php echo $row["code"]?>" onmouseover="ShowPopup(event, '<img src=\'../images/shome.png\' style=\'position: relative; float: left;\' /><div style=\'position: relative; float: left; margin-left: 7px; margin-top: 5px; padding-right: 3px;\'><?php echo dic("Tracking.Street")?></div>')" onmouseout="HidePopup()" src="../images/shome.png" width="14px" style="padding-top: 2px; padding-bottom: 2px; position: relative; float: left;" />
	                <div id="vh-location-<?php echo $row["code"]?>" style="width: 190px; position: relative; float: right; left: 5px; top: 1px;">&nbsp;<?php echo $row["Location"]?></div>
				</div>
				<?php } 
	            	if(pg_fetch_result($dsAllowed, 0, "zone") == "1"){
                ?>
				<div style="width:205px; padding-left:5px; padding-right:5px; float:left; background-color:#fafafa; color:#333333; font-size:10px; border-top:1px dotted #333">
	                <img id="vh-address-pic-<?php echo $row["code"]?>" onmouseover="ShowPopup(event, '<img src=\'../images/areaImg.png\' style=\'position: relative; float: left;\' /><div style=\'position: relative; float: left; margin-left: 7px; margin-top: 5px; padding-right: 3px;\'><?php echo dic("Tracking.GFVeh")?></div>')" onmouseout="HidePopup()" src="../images/areaImg.png" width="14px" style="padding-top: 2px; padding-bottom: 2px; position: relative; float: left;" />
	                <div id="vh-address-<?php echo $row["code"]?>" style="width: 190px; position: relative; float: right; left: 5px; top: 1px;"></div>
	            </div>
	            <?php } ?>
			</div>
		<?php
			$brojaaac++;
		}
		?>
	</div>

<?php
closedb();
?>