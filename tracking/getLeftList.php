<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (session("role_id")."" == "2"){
		$sqlV = "select id from vehicles where clientid=".session("client_id");
	} else {
		$sqlV = "select vehicleid from uservehicles where userid=".session("user_id");
	}
	set_time_limit(0);
	opendb();
	
	//$dsCP = query('select cast(v.code as integer), v.allowcamera, v.gsmnumber, v.allowgarmin, v.allowhoist, v.allowultrasonic, v.allowengineblock, v.allowgeolock, v.allowbattery, v.allowinputvoltage, v.registration, v.fuelcapacity, v.allowtemp altemp, v.alias, v.allowfuel alfuel, v.allowrpm alrpm, v.showrpm, v.allowcanbas alcanbas, v.model, cp.*, cp."DateTime" tzdatetime, visible from currentposition cp left outer join vehicles v on v.id=cp.vehicleid where v.id in (' . $sqlV . ')  order by 1');

	$dsCP = query('select cast(v.code as integer), v.allowcamera, v.gsmnumber, v.allowgarmin, v.allowhoist, v.allowultrasonic, v.allowengineblock, v.allowgeolock, v.allowbattery, v.allowinputvoltage, v.registration, v.fuelcapacity, v.allowtemp altemp, v.alias, v.allowfuel alfuel, v.allowrpm alrpm, v.showrpm, v.allowcanbas alcanbas, v.model, vc.allow_cbfuel a_cbf, vc.allow_cbtemp a_cbt, vc.allow_cbdistance a_cbd, vc.allow_cbrpm a_cbr, cp.*, cp."DateTime" tzdatetime, visible from currentposition cp left outer join vehicles v on v.id=cp.vehicleid left outer join vehicle_canbus vc on v.id=vc.vehicleid where v.id in (' . $sqlV . ')  order by 1');

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
	$dsAllowed = query("select datetimeformat,metric,timedate,speed,location,poi,zone,passengers,taximeter,fuel, cbfuel, cbrpm, cbtemp, cbdistance, weather, liquidunit, tempunit from users where id=" . session("user_id"));
	$weather = pg_fetch_result($dsAllowed, 0, "weather");
	$metric = pg_fetch_result($dsAllowed, 0, "metric");
	$dtformat = pg_fetch_result($dsAllowed, 0, "datetimeformat");
	$dtf = explode(" ", $dtformat);
	$dateformat = $dtf[0];
	$timeformat =  $dtf[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " A";
	if($dtf[1] == "h:i:s")
	{
		$widdt = '118';
		$widrest = '0';
	} else {
		$widdt = '100';
		$widrest = '13';
	}
	$metricValue = ' Km/h';
	$metricValue1 = 1;
	if($metric.'' == 'mi') {
		$metricValue = ' mph';
		$metricValue1 = 0.621371;
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
		$wid123 = '91px';
	else
		$wid123 = '91px';
	
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
	
	$dsVehicles = query("select cast(code as integer), id from vehicles where id in (".$sqlV.") order by code");

	if ($ClientTypeID == 2) 
	{
	?>
	<div id="menu-6" class="menu-container" style="width:248px">
		<a id="menu-title-6" href="#" class="menu-title text3" onClick="OnMenuClick(6)" style="width:100%"><?php echo dic("Tracking.Engaged1")?>
			<img src="../images/downMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 2px; " />
			<img src="../images/upMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 1px; " />
		</a>
		<div id="menu-container-6" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow-y: hidden; overflow-x:auto;">
		<div>
			<?php
				while($row = pg_fetch_array($dsVehicles))
				{
			?>
				<li id="div-pass-<?php echo $row["code"]?>" onClick="ChangePassiveStatus(<?php echo $row["code"]?>, <?php echo $row["id"]?>)" <?php if($yourbrowser != "1") { ?> onMouseOver="ShowPopup(event, '<?php echo dic("Tracking.ClickToChange")?> <?php echo $row["code"]?>')" onMouseOut="HidePopup()" <?php } ?> style="float:left; display:inherit; padding-top:2px; height:16px; margin-left:5px; margin-top:5px; cursor:pointer; opacity:0.3" class="gnMarkerListOrange text3"><strong><?php echo $row["code"]?></strong></li>
			<?php
				}
			?>	
			</div><br><br>&nbsp;
		</div>
	</div>
	<?php
	}
	?>
	<div id="menu-1" class="menu-container" style="width:248px">
		<a id="menu-title-1" href="#" class="menu-title text3" onClick="OnMenuClick(1)" style="width:100%"><?php echo dic("Tracking.QuickView")?>
			<img src="../images/downMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 2px; " />
			<img src="../images/upMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 1px; " />
		</a>
		<div id="menu-container-1" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow-y: hidden; overflow-x:auto;">
			<div>
			<?php
				$dsVehicles = query("select cast(code as integer) from vehicles where id in (".$sqlV.") order by code");

				while ($row = pg_fetch_array($dsVehicles)){
			?>
				<li id="div-sv-<?php echo $row["code"]?>" onClick="FindVehicleOnMap0(<?php echo $row["code"]?>)" <?php if($yourbrowser != "1") { ?>onMouseOver="ShowPopup(event, '<?php echo dic("Tracking.ClickToFind")?> <?php echo $row["code"]?>')" onMouseOut="HidePopup()" <?php } ?> style="float:left; display:inherit; padding-top:2px; height:16px; margin-left:5px; margin-top:5px; cursor:pointer" class="gnMarkerListGray text3"><strong><?php echo $row["code"]?></strong></li>
			<?php
				}
			?>
			</div>
			<br /><br />&nbsp;
		</div>
	</div>


<div id="menu-2" class="menu-container" style="width:248px">
	<a id="menu-title-2" href="#" class="menu-title text3" onClick="OnMenuClick(2)" style="width:100%"><?php echo dic("Tracking.VehDetails")?>
		<img src="../images/downMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 2px; " />
		<img src="../images/upMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 1px; " />
	</a>
	<div id="searchVeh" style="width:0px; padding-left:0px; padding-top:0px; overflow:hidden; height: 0px; margin-bottom: 0px;">
        <!--input type="text" style="width: 220px; font-family: Arial,Helvetica,sans-serif; font-size: 12px;" name="searchbyreg" id="searchbyreg" value="" onclick="$(this).focus()" onkeyup="searchVehicle(this)" placeholder="<?php echo dic("search")?>..." onmousemove="ShowPopup(event, '<div style=\'position: relative; float: left; margin-left: 7px; margin-top: 5px; padding-right: 3px;\'><?php echo dic("Tracking.Registration")?>,<br /><?php echo dic("Tracking.Driver")?>,<br /><?php echo dic("Tracking.Speed")?>,<br /><?php echo dic("Reports.DateTime")?></div>')" onmouseout="HidePopup()"/>
        <!--input type="text" style="width: 220px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; position: relative; top: 5px;" name="searchbydriv" id="searchbydriv" value="" onclick="$(this).focus()" onkeyup="searchByDriver(this)" placeholder="<?php echo dic("searchbydriver")?>" /-->
	</div>
	<div id="menu-container-2" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow-y: hidden; overflow-x:auto;">
		<?php
			$allowGarminVeh = 0;
			$brojaaac = 1;
			while($row = pg_fetch_array($dsCP))
			{
				$fontsize = '';
				if(strlen($row["code"]) > 2) {
					$fontsize = ' font-size: 10px;';
				}
				$lon = $row["longitude"];
				$lat = $row["latitude"];
				
				if($row["allowgarmin"] == 1){
					$allowGarminVeh = $allowGarminVeh + 1;
				}
				//if($row["LongOrientation"] == "W") $lon = "-" & $lon;
				//if($row["LatOrientation"] == "S") $lat = "-" & $lat;
				$tzDatetime = new DateTime($row["tzdatetime"]);
				
				$strDrivName = "";
				$strDrivDest = "";
				$driverDestStyle = "display:none";
	        	$dsDrivName = query("select d.fullname, coalesce(vd.destination, '/') destination from drivervehicle vd left outer join drivers d on vd.driverid=d.id where vd.vehicleid=" . $row["vehicleid"] . " and vd.enddate is null");
	        	if(pg_num_rows($dsDrivName) > 0) {
	            	$strDrivName = pg_fetch_result($dsDrivName, 0, "fullname");
				}
		        else
		            $strDrivName = "/";
				if(pg_num_rows($dsDrivName) > 0) {
					if (pg_fetch_result($dsDrivName, 0, "destination") <> "/") {
						$driverDestStyle = "display:block";
						$strDrivDest = pg_fetch_result($dsDrivName, 0, "destination");
					}
				}
		       $dsPre = query("select ID, code, FullName from Drivers where clientid=" . Session("client_id") . " and id in (select Driverid from VehicleDriver where VehicleID in (select id from Vehicles where ID=" . $row["vehicleid"] . ")) order by FullName");
		        //$dsPre = query("select * from drivers where clientid=" . Session("client_id"));
		        
		        $kapaci = dlookup("select coalesce((select portname from vehicleport where vehicleid=" . $row["vehicleid"] . " and porttypeid=7), '-')");
				$pumpa = dlookup("select coalesce((select portname from vehicleport where vehicleid=" . $row["vehicleid"] . " and porttypeid=15), '-')");
				$sovozac = dlookup("select coalesce((select portname from vehicleport where vehicleid=" . $row["vehicleid"] . " and porttypeid=11), '-')");
				$digalka = dlookup("select coalesce((select portname from vehicleport where vehicleid=" . $row["vehicleid"] . " and porttypeid=21), '-')");
				$AllowedPKSABH = '0';
				if($pumpa != '-' || $kapaci != '-' || $sovozac != '-' || $digalka != '-' || $row["allowbattery"] == "1" || $row["allowinputvoltage"] == "1")
		        {
		        	$AllowedPKSABH = '1';
				}
			?>
			<script type="text/javascript">
            	var vis = '<?php echo $row["visible"]?>';
            	if (vis != "1")
                	EnableDisable('<?php echo $row["vehicleid"]?>','<?php echo $row["code"]?>', '0');
        	</script>
			<div id="vehicleList-<?php echo $row["code"]?>" style="overflow: hidden" class="div-one-vehicle-list text3 corner5" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')">
				<?php
					if($ClientTypeID == "6" && ($row["allowengineblock"] == "1" || $row["allowgeolock"] == "1"))
					{
						 if($row["allowgeolock"] == "1")
						 	$wid = '33';
						 else
						 	$wid = '50';
					?>
				<div id="twobuttons" style="margin-top: -5px; height: 12px; padding-bottom: 14px; background-color: #fafafa; width:100%; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
					<table border="0" width="100%" height="90%" cellpadding="0" cellspacing="0">
						<tr>
							<td width="<?=($wid+1)?>%"><button id="naredba1_<?= $row["vehicleid"]?>" onclick="motoalarm('<?= $row["gsmnumber"]?>')" style="width: 100%; height: auto; font-size: 10px;">Moto-alarm</button></td>
							<td width="<?=$wid?>%"><button id="naredba2_<?= $row["vehicleid"]?>" onclick="motoblock('<?= $row["gsmnumber"]?>', this.id)" style="width: 100%; height: auto; font-size: 10px;">Moto-block</button></td>
							<?php
								if($row["allowgeolock"] == "1") { ?>
							<td width="<?=$wid?>%"><button id="naredba3_<?= $row["vehicleid"]?>" onclick="geolock('<?= $row["gsmnumber"]?>', '<?= $row["vehicleid"]?>', '<?= $row["code"]?>')" style="width: 100%; height: auto; font-size: 10px;">Geo-lock</button></td>
							<?php } ?>
							<script>
								$('#naredba1_<?= $row["vehicleid"]?>').button();
								$('#naredba2_<?= $row["vehicleid"]?>').button();
								$('#naredba3_<?= $row["vehicleid"]?>').button();
								$('.ui-button-text').css({paddingLeft: '0px', paddingRight: '0px'})
							</script>
						</tr>
					</table>
				</div>
					<?php } ?>
	            <div id="divOpt-<?php echo $row["vehicleid"]?>" class="corner5" onmouseout="MouseOutOptions('vehOption-<?php echo $row["code"]?>')" onmouseover="OpenOptionsForVeh(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>', 0)" style="width: 122px; height: auto; opacity: 0.9; background-color: #E2ECFA; display: none; position: absolute; border: 1px solid #1A6EA5; left: 117px; color: #1A6EA5; text-align: center; z-index: 9;">
	                <div id="settings-<?php echo $row["code"]?>">
	                    <img id="closeSett" width="13px" src="../images/close.png" style="position: relative; float: right; right: 3px; top: 3px;" onclick="CloseSett('<?php echo $row["vehicleid"]?>', '')" alt="" />
	                    <font onmouseover="OpenOptionsForVeh(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>', 0)" style="text-decoration: underline; position: relative; left: -1px;"><?php echo dic("Tracking.Settings")?></font><br />
	                    <font onmouseover="OpenOptionsForVeh(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>', 0)" style="text-decoration: underline; position: relative; left: -8px; font-size: 11px;">(<?php echo $row["code"]?>)&nbsp;<?php echo $row["registration"]?></font>
	                    <div style="height: 5px;">&nbsp;</div>
	                    <div id="ActiveSett-<?php echo $row["vehicleid"]?>" onMouseMove="ShowPopup(event, '<?php echo dic("temporaryNonUse")?>')" onMouseOut="HidePopup()" class="meni corner5" onclick="EnableDisable('<?php echo $row["vehicleid"]?>', '<?php echo $row["code"]?>', '1')"><?php echo dic("Tracking.Deactive")?></div>
	                    <div id="FuelSett-<?php echo $row["vehicleid"]?>" onMouseMove="ShowPopup(event, '<?php echo dic("iconCosts")?>')" onMouseOut="HidePopup()" style="<?php echo $fm1?>" onclick="<?php echo $fm?>costVehicleW('<?php echo $brojaaac?>', '<?php echo $row["vehicleid"]?>', '<?php echo $row["registration"]?>')">
	                        <div class="meni corner5"><?php echo dic("Fm.Costs")?></div>
	                    </div>
	                    <?php
	                    	if($ClientTypeID != "3" && $ClientTypeID != "7") { 
                		?>
	                    <div id="DriverSett-<?php echo $row["vehicleid"]?>" onclick="DrivSett(event, '<?php echo $row["vehicleid"]?>', '')">
	                        <div class="meni corner5"><?php echo dic("Tracking.Driver")?></div>
	                        <div id="driv-item-<?php echo $row["vehicleid"]?>" style="display: none; padding-left: 5px; padding-top: 5px; text-align: left; min-height: 50px; position: relative; overflow-y: auto; width: 105px; height: 100px; position: relative; left: 5px; border: 1px solid #1A6EA5;">
                            <?php
                                if(pg_num_rows($dsPre) > 0) {
                                    //Dim drPre As Data.DataRow
                                    ?>
                                    <div class="menu_drivers" id="driver-0" onclick="changeDriver('vh-driver-<?php echo $row["code"]?>', '<?php echo $row["vehicleid"]?>', '0')">/</div>
                                    <?php
                                    $dsPre = query("select ID, code, FullName from Drivers where clientid=" . Session("client_id") . " and id in (select Driverid from VehicleDriver where VehicleID in (select id from Vehicles where ID=" . $row["vehicleid"] . ")) order by FullName");
                                    while($row2 = pg_fetch_array($dsPre))
                                    {
                                        ?>
                                        <div class="menu_drivers" id="driver-<?php echo $row2["id"]?>" onclick="changeDriver('vh-driver-<?php echo $row["code"]?>', '<?php echo $row["vehicleid"]?>', '<?php echo $row2["id"]?>')"><?php echo $row2["fullname"]?></div>
                                        <?php
                                    }
                                } else {
                                    echo "/";
                            }
                                ?>
                        	</div>
	                    </div>
	                    <?php }
							if($row["allowgarmin"] == "1") { ?>
							<div id="Canned-<?php echo $row["vehicleid"]?>" onMouseMove="ShowPopup(event, '<?=dic_("EnterPredefMess")?>')" onMouseOut="HidePopup()" style="<?php echo $fm1?>" onclick="fncAddCanned('<?php echo $row["vehicleid"]?>', '<?php echo $row["gsmnumber"]?>')">
		                        <div class="meni corner5"><?=dic_("Garmin")?></div>
		                    </div>
						<? } ?>
	                    <div style="height: 5px;">&nbsp;</div>
	                </div>
	            </div>
	            <script type="text/javascript">
	                $('#btn-' + <?php echo $row["vehicleid"]?>).button();
	            </script>
				<div style="width: <?=(78+$widrest)?>px; float:left;" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')">
					<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="vh-small-<?php echo $row["code"]?>" class="gnMarkerListGray" style="float:left; <?=$fontsize?> width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer"  onClick="FindVehicleOnMap0(<?php echo $row["code"]?>)" onMouseOver="ShowPopup(event, '<?php echo dic("Tracking.ClickToFind")?> <?php echo $row["code"]?>')" onMouseOut="HidePopup()"><?php echo $row["code"]?></div>
					<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="color: #000000; width: <?=(55+$widrest)?>px; text-overflow: ellipsis; white-space: nowrap; height: 14px; overflow: hidden; float:left; padding-top:2px; padding-left:3px; font-weight:bold; cursor:pointer" onclick="FindVehicleOnMap0(<?php echo $row["code"]?>)" onMouseOver="ShowPopup(event, '<?php echo dic("Tracking.ClickToFind")?> <?php echo $row["code"]?>')" onMouseOut="HidePopup()"><?php echo $row["registration"]?></div>
				</div>
				<?php if(pg_fetch_result($dsAllowed, 0, "timedate") == "1"){
                ?>
				<div id="vh-date-<?php echo $row["code"]?>" style="width:<?=$widdt?>px; position: relative; right: 2px; top: 2px; float:right; text-align:right; color:#000000; font-size:10px;" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')">
				<?php echo $tzDatetime->format($dtformat).''?>
				</div>
				<?php } ?>
				<div id="vehOption-<?php echo $row["code"]?>" class="corner5" onclick="OpenOptionsForVeh(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>', 1)" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="display: none; position: relative; width:17px; height: 15px; float:right; color:#000000; font-size:10px; background: Snow url(../images/keyblue.png) no-repeat center center; border: 1px Solid #387CB0; cursor: pointer;"></div>
				<?php
					if($row["alias"].'' != '')
					{
                ?>
                <div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Reports.Alias")?>: <span style="font-weight: bold" id="vh-alias-<?php echo $row["code"]?>"><?php echo $row["alias"]?></span>
				</div>
				<?php }
					if($row["allowcamera"].'' == '1')
					{
						if (dlookup("select count(*) from camera where vehicleid=".$row["vehicleid"]."") > 0) {
							$dsLastPhoto = query("select * from camera where vehicleid=".$row["vehicleid"]." order by datetime desc limit 1");
							$camImg = pg_fetch_result($dsLastPhoto, 0, "image");
							$camTime = DateTimeFormat(pg_fetch_result($dsLastPhoto, 0, "datetime"), $dtformat);
						} else {
							$camImg = ""; $camTime = "";							
						}
						
                
                		$checkCamera = nnull(dlookup("select count(*) from cameravehicle where vehicleid=".$row["vehicleid"]." and datetime between '".DateTimeFormat(now(), '"Y-m-d 00:00:00"')."'  and '".DateTimeFormat(now(), '"Y-m-d 23:59:59"')."'"), 0);
			    ?>
                <div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:1px; padding-bottom:1px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<span style="position: relative; top: 2px;" id="vh-image-<?php echo $row["code"]?>"><?= dic_("Reports.LastPhoto")?>: </span>
					<!--img style="cursor: pointer; position: relative; float: right; margin-top: -1px;" onclick="newImageFromCamera('<?=$row["gsmnumber"]?>', '<?=$row["code"]?>')" onmouseover="ShowPopup(event, 'Кликнете за нова слика')" onmouseout="HidePopup()" width="18px;" src="../images/camera2.png" /-->
					<img id="camera-<?=$row["vehicleid"]?>" style="cursor: pointer; position: relative; float: right; margin-top: -1px;" onclick="openCameraWindow('<?=$row["gsmnumber"]?>', '<?=$row["code"]?>', '<?= $camImg ?>', '<?= $camTime ?>', <?=$checkCamera?>)" onmouseover="ShowPopup(event, '<?= dic_("Reports.ClickNewPhoto")?>')" onmouseout="HidePopup()" width="18px;" src="../images/camera2.png" />
					<img id="vh-img-newimage-<?= $row["code"]?>" src="../images/smallref.gif" width="17px" style="display:none; position: relative; float: right; right: 3px;" />
				</div>
				<?php
					}
                	if($ClientTypeID != "3" && $ClientTypeID != "7") { 
        		?>
	            <div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic_("Tracking.Driver") ?>: <span style="font-weight: bold" id="vh-driver-<?php echo $row["code"]?>"><?php echo $strDrivName ?></span>
				</div>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="div-driverdest-<?php echo $row["code"]?>" style="<?=$driverDestStyle?>; height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic_("Reports.Destination") ?>: <span style="font-weight: bold" id="vh-driverdest-<?php echo $row["code"]?>"><?php echo $strDrivDest ?></span>
				</div>
	            <div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Fm.Marka")
					    ?>: <span style="font-weight: bold" id="vh-type-<?php echo $row["code"]?>"><?php echo $row["model"]?></span>
				</div>
				<?php
					}
					if($row["alrpm"]."" == "1"){ ?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Tracking.rpm")
					    ?>: <span style="font-weight: bold" id="vh-rpm-<?php echo $row["code"]?>"> 0 <?=$row["showrpm"]?></span>
				</div>
				<?php }	
					if($row["altemp"] == "1"){ 
				?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Tracking.Temp")
					    ?>: <span style="font-weight: bold" id="vh-temp-<?php echo $row["code"]?>"> <?= converttemp(0, $tempunit) . " " . $tempunit?></span>
				</div>
				
	            <?php }
					if($row["alfuel"] == "1"){ 
				?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Tracking.Fuel")
					    ?>: <span style="font-weight: bold" id="vh-litres-<?php echo $row["code"]?>"> <?=0*$liqvalue . " " . $liqunit?></span>
				</div>
				
	            <?php }
					if($row["allowultrasonic"] == "1"){
						$ultraport = dlookup("select coalesce((select portname from vehicleport where vehicleid=" . $row["vehicleid"] . " and porttypeid=20), '')");
						if($ultraport.'' != '')
							$ultrafuel = dlookup("select " . $ultraport . " from historylog where vehicleid=" . $row["vehicleid"] . " and cast(" . $ultraport . " as integer)<>0 order by datetime desc limit 1");
						else
							$ultrafuel = 0;
					?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Tracking.Fuel")
					    ?>: <span style="font-weight: bold" id="vh-ultrasonic-<?php echo $row["code"]?>"> <?=round($ultrafuel * $liqvalue)?> <?php echo $liqunit?></span>
				</div>
				
	            <?php }
                	if($ClientTypeID != "3" && $ClientTypeID != "7") { 
                		$allowOdometer = 1;
                		if($row["alcanbas"] == "1") {
							if($AllowedCANbus == "1") {
                				//$allowOdometer = dlookup("select allow_cbdistance from vehicle_canbus where vehicleid=".$row["vehicleid"]);
                				$allowOdometer = $row["a_cbd"];
                			}
                		}
                		//echo $row["alcanbas"] . " " . $AllowedCANbus . " " . pg_fetch_result($dsAllowed, 0, "cbdistance") . " " . $row["a_cbd"];

                		//if($row["alcanbas"] == "1") {
						//if($AllowedCANbus == "1") {
						//if(pg_fetch_result($dsAllowed, 0, "cbdistance") == "1"){
						//if ($row["a_cbd"] == "1") {
                		//if ($allowOdometer == 0) {
                		if ($row["alcanbas"] == '0' or $AllowedCANbus == '0' or pg_fetch_result($dsAllowed, 0, "cbdistance") == '0' or $row["a_cbd"] == '0') {
        		?>
				<div onclick="fncAddOdometer('<?php echo $row["vehicleid"]?>', '<?php echo $row["code"]?>')" onmouseout="pencilnewout('<?php echo $row["code"]?>')" onmouseover="pencilnew('<?php echo $row["code"]?>'); MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="vh-up-odometar-<?php echo $row["code"]?>" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333; cursor: pointer; height: 12px;">							
					<?= dic("Reports.Odometer")?>: <span style="font-weight: bold" id="vh-odometar-<?php echo $row["code"]?>"> <?=$metric?></span>
					<img id="img-pencil-<?php echo $row["code"]?>" src="../images/pencilnew.png" style="display:none; height: 13px; margin-top: 0px; position: relative; right: 5px; float: right; width: 13px;" />
				</div>
				<?php
						}
					}
	            	if($AllowedPKSABH == "1"){
                ?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
					<table border="0" width="100%" cellpadding="0" cellspacing="0" style="font-size: 10px">
						<tr>
							<?php
							if($digalka != '-')
		        			{
							?>
							<td>
								<span id="div-hoist-<?php echo $row["code"]?>" style="color:#ff0000;"><?=dic_("Tracking.Hoist")?></span>
							</td>
							<?php } 
							if($row["allowbattery"] == "1"){ ?>
								<td>
									<span><?= dic("Admin.Battery")?>: </span><span style="font-weight: bold" id="vh-battery-<?php echo $row["code"]?>"> / </span>
								</td>
							<?php }
							if($row["allowinputvoltage"] == "1"){ ?>
								<td>
									<span><?= dic("acumulator")?>: </span><span style="font-weight: bold" id="vh-inputvoltage-<?php echo $row["code"]?>"> / </span>
								</td>
							<?php }  
							if($pumpa != '-')
		        			{
		        				?>
		        				<td>
									<span id="div-pumpa-<?php echo $row["code"]?>" style="color:#ff0000; position: relative; right: 5px;"><?=dic_("Reports.Pump")?></span>
								</td>
		        				<?php
							}
							if($kapaci != '-')
		        			{
		        				?>
		        				<td>
									<span id="div-kapaci-<?php echo $row["code"]?>" style="color:#ff0000;"><?=dic_("Reports.Caps")?></span>
								</td>
		        				<?php
							}
							if($sovozac != '-')
							{
								?>
		        				<td>
									<span id="div-sovozac-<?php echo $row["code"]?>" style="color:#ff0000;"><?=dic("Reports.FrontPassenger")?></span>
								</td>
		        				<?php
							}
							?>
						</tr>
					</table>							
				</div>
				<?php
					}
	            	if($AllowedSTP == "1"){
                ?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
					<table border="0" width="100%" cellpadding="0" cellspacing="0" style="font-size: 10px">
						<tr>
							<?php
							if(pg_fetch_result($dsAllowed, 0, "speed") == "1"){ ?>
								<td>
									<span><?php echo dic("Tracking.Speed")?>:</span><span style="font-weight: bold" id="vh-speed-<?php echo $row["code"]?>"> 0<?=$metricValue?></span>
								</td>
							<?php }
							if(pg_fetch_result($dsAllowed, 0, "taximeter") == "1"){
							?>
							<td>
								<span id="div-taxi-<?php echo $row["code"]?>" style="color:#ff0000;"><?php echo dic("Tracking.Taximeter")?></span>
							</td>
							<?php } 
							if(pg_fetch_result($dsAllowed, 0, "passengers") == "1"){
							?>
							<td>
								<span><?php echo dic("Tracking.Passengers")?>:</span><span id="vh-sedista-<?php echo $row["code"]?>" style="font-size:12px; color:#000066;">0</span>
							</td>
							<?php } ?>
						</tr>
					</table>							
					
				</div>
				<?php }
					if($row["alcanbas"] == "1") {
					if($AllowedCANbus == "1") {
                ?>
				<div id="vh-canbus-<?php echo $row["code"]?>" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="display: none; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333; height: auto; min-height: 12px;">							
					<?php
						if(pg_fetch_result($dsAllowed, 0, "cbfuel") == "1"){
							if ($row["a_cbf"] == "1") {
								$fuel = $row["cbfuel"];
								$fuel = 100*$fuel/100;							
					?>
					<div id="vh-cbfuel1-<?php echo $row["code"]?>"><?php echo dic("Tracking.Fuel")?>: <span id="vh-cbfuel-<?php echo $row["code"]?>" style="font-weight: bold"><?php echo round($fuel*$liqvalue)?> <?=$liqunit?></span></div>
					<?php 
							}
						}
						if(pg_fetch_result($dsAllowed, 0, "cbrpm") == "1"){
							if ($row["a_cbr"] == "1") {
					?>
					<div id="vh-cbrpm1-<?php echo $row["code"]?>"><?php echo dic("Tracking.rpm")?>: <span id="vh-cbrpm-<?php echo $row["code"]?>" style="font-weight: bold"><?php echo round($row["cbrpm"])?> rpm</span></div>
					<?php 
							}
						} 
						if(pg_fetch_result($dsAllowed, 0, "cbtemp") == "1"){
							if ($row["a_cbt"] == "1") {
					?>
					<div id="vh-cbtemp1-<?php echo $row["code"]?>"><?php echo dic("Tracking.Temp")?>: <span id="vh-cbtemp-<?php echo $row["code"]?>" style="font-weight: bold"><?php echo round(converttemp($row["cbtemp"], $tempunit))?> °<?= $tempunit?></span></div>
					<?php 
							}
						} 
					if(pg_fetch_result($dsAllowed, 0, "cbdistance") == "1"){
						if ($row["a_cbd"] == "1") {
					?>
					<div id="vh-cbdistance1-<?php echo $row["code"]?>"><?php echo dic("Reports.Odometer")?>: <span id="vh-cbdistance-<?php echo $row["code"]?>" style="font-weight: bold"><?php echo round(($row["cbdistance"] / 1000)*$metricValue1)?> <?=$metric?></span></div>
					<?php 
						}
					} 
					?>
				</div>
				<?php }}
					if($weather == '1'){?>
				<div id="weather-<?= $row["code"]?>" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="display: none; width:210px; padding-left:5px; padding-right:0px; float:left; background-color:#fafafa; color:#333333; font-size:10px; border-top:1px dotted #333">
	                <table border="0" width="100%" cellpadding="0" cellspacing="0" style="font-size: 10px">
						<tr id="row0-<?=$row["code"]?>">
							<td width="35px">
								<span id="weather-temp-<?php echo $row["code"]?>" style="font-weight: bold; font-size: 12px;">/</span>
							</td>
							<td width="125px">
								<span id="weather-weather-<?php echo $row["code"]?>" style="font-weight: bold">/</span>
							</td>
							<td width="30px">
								<img width="22px" id="weather-img-<?= $row["code"]?>" src="" style="margin-right: 4px; position: relative; float: right;" />
							</td>
							<td width="20px">
								<img width="12px" onclick="ShowHideRow('<?=$row["code"]?>')" src="../images/info1.png" style="cursor: pointer; position: relative; float: right; margin-right: 2px; margin-bottom: -5px;" />
							</td>
						</tr>
						<tr id="row1-<?=$row["code"]?>" style="display: none;">
							<td colspan="3">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" style="padding-bottom: 3px; font-size: 10px; margin-top: -2px;">
									<tr>
										<td>
											<span><?=dic('feelslike')?>:</span>
											<span id="weather-feelslike-<?php echo $row["code"]?>" style="font-weight: bold">/</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr id="row2-<?=$row["code"]?>" style="display: none;">
							<td colspan="4">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" style="font-size: 10px; margin-top: -2px;">
									<tr>
										<td>
											<span><?= dic("humidity")?>:</span>
											<span id="weather-humidity-<?php echo $row["code"]?>" style="font-weight: bold">/</span><br>
										</td>
										<td>
											<span><?=dic("wind")?>:</span>
											<span id="weather-wind-<?php echo $row["code"]?>" style="font-weight: bold">/</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr id="row3-<?=$row["code"]?>" style="display: none;">
							<td colspan="4">
								<table border="0" width="100%" cellpadding="0" cellspacing="0" style="font-size: 10px;">
									<tr>
										<td>
											<span><?= dic("lastupdate")?>:</span>
											<span id="weather-time-<?php echo $row["code"]?>" style="font-weight: bold">/</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr id="row4-<?=$row["code"]?>" style="display: none;">
							<td colspan="4">
								<table id="row4-table-<?=$row["code"]?>" border="0" width="100%" cellpadding="0" cellspacing="0" style="padding-bottom: 5px; font-size: 10px;">
									<tr>
										<td>
											<span style="font-weight: bold">
												<a id="weather-link-<?php echo $row["code"]?>" href="" target="_blank" class="text2_" style="font-size: 10px; cursor: pointer; text-decoration: none;" ><?=dic("WeatherForecast")?></a>
											</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
					<?php }
	            	if(pg_fetch_result($dsAllowed, 0, "poi") == "1"){
                ?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="width:205px; padding-left:5px; padding-right:5px; float:left; background-color:#fafafa; color:#333333; font-size:10px; border-top:1px dotted #333">
	                <img id="vh-pp-pic-<?php echo $row["code"]?>" onmouseover="ShowPopup(event, '<img src=\'../images/poiButton.png\' style=\'position: relative; float: left;\' /><div style=\'position: relative; float: left; margin-left: 7px; margin-top: 5px; padding-right: 3px;\'><?php echo dic("Tracking.POI")?></div>')" onmouseout="HidePopup()" src="../images/poiButton.png" width="14px" style="padding-top: 2px; padding-bottom: 2px; position: relative; float: left;" />
	                <div id="vh-pp-<?php echo $row["code"]?>" style="width: 190px; position: relative; float: right; left: 5px; top: 1px;"></div>
				</div>
				<?php } 
	            	if(pg_fetch_result($dsAllowed, 0, "location") == "1"){
                ?>
	            <div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="width:205px; padding-left:5px; padding-right:5px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
	                <img id="vh-location-pic-<?php echo $row["code"]?>" onmouseover="ShowPopup(event, '<img src=\'../images/shome.png\' style=\'position: relative; float: left;\' /><div style=\'position: relative; float: left; margin-left: 7px; margin-top: 5px; padding-right: 3px;\'><?php echo dic("Tracking.Street")?></div>')" onmouseout="HidePopup()" src="../images/shome.png" width="14px" style="padding-top: 2px; padding-bottom: 2px; position: relative; float: left;" />
	                <div id="vh-location-<?php echo $row["code"]?>" style="width: 190px; position: relative; float: right; left: 5px; top: 1px;">&nbsp;<?php echo $row["Location"]?></div>
				</div>
				<?php } 
	            	if(pg_fetch_result($dsAllowed, 0, "zone") == "1"){
                ?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="width:205px; padding-left:5px; padding-right:5px; float:left; background-color:#fafafa; color:#333333; font-size:10px; border-top:1px dotted #333">
	                <img id="vh-address-pic-<?php echo $row["code"]?>" onmouseover="ShowPopup(event, '<img src=\'../images/areaImg.png\' style=\'position: relative; float: left;\' /><div style=\'position: relative; float: left; margin-left: 7px; margin-top: 5px; padding-right: 3px;\'><?php echo dic("Tracking.GFVeh")?></div>')" onmouseout="HidePopup()" src="../images/areaImg.png" width="14px" style="padding-top: 2px; padding-bottom: 2px; position: relative; float: left;" />
	                <div id="vh-address-<?php echo $row["code"]?>" style="width: 190px; position: relative; float: right; left: 5px; top: 1px;"></div>
	            </div>
	            <?php } 
	            	$dsAllowedGarmin = query('select * from stopstatus where toid=' . $row["vehicleid"].' and status = 100 order by dtstart DESC limit 1');
					if(pg_num_rows($dsAllowedGarmin) > 0) {
					$row123 = pg_fetch_array($dsAllowedGarmin);
					$StartDatetime1 = new DateTime($row123["dtstart"]);
					$etaDT = new DateTime($row123["etadt"]);
					if(round($row123["etadistance"] / 1000) > 0)
						$etaDist = round(($row123["etadistance"] / 1000), 1, PHP_ROUND_HALF_ODD) . ' Km';
					else
						$etaDist = round($row123["etadistance"]) . ' m';
					?>
		            	<div id="garminstop-<?php echo $row["code"]?>" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="width:205px; padding-left:5px; padding-right:5px; float:left; background-color:#fafafa; color:#333333; font-size:10px; border-top:1px dotted #333; display: block;">
			                <img src="../images/areaSave1.png" width="14px" style="padding-top: 2px; padding-bottom: 2px; position: relative; float: left;" />
			                <div id="vh-garmin-status-<?php echo $row["code"]?>" onclick="checkGarmin('<?=$row["gsmnumber"]?>')" onmouseover="ShowPopup(event, '<?=dic_("ClickCheckGarmin")?>')" onmouseout="HidePopup()" style="cursor: pointer; width: 190px; position: relative; float: right; left: 5px; top: 1px;"><?=dic_("Garmin")?>: <?=dic_("Admin.Active")?> <img src="../images/stikla2.png" width="10px" style="padding-top: 2px; padding-bottom: 2px; padding-right: 4px; position: relative; float: right;" /></div>
			            	<div style="width: 190px; position: relative; float: right; left: 5px; top: 1px; border-top:1px dotted #333"><?=dic_("Name")?>: <span id="vh-garmin-text-<?php echo $row["code"]?>"><?= $row123["text"] ?></span></div>
			            	<div style="width: 190px; position: relative; float: right; left: 5px; top: 1px; border-top:1px dotted #333"><?=dic_("Tracking.Start")?>: <span id="vh-garmin-start-<?php echo $row["code"]?>"><?= $StartDatetime1->format($dtformat).'' ?></span></div>
			            	<div style="width: 190px; position: relative; float: right; left: 5px; top: 1px; border-top:1px dotted #333"><?=dic_("Reports.Location")?>: <span id="vh-garmin-location-<?php echo $row["code"]?>" ><?= $row123["location"]; ?></span></div>
			            	<div style="height: 44px; width: 190px; position: relative; float: right; left: 5px; top: 1px; border-top:1px dotted #333"><?=dic_("Estimation")?>:<br>&nbsp;&nbsp;<?=dic_("Reports.Vreme")?>: <span id="vh-garmin-estimationtime-<?php echo $row["code"]?>"><?=$etaDT->format($dtformat).''?></span><br>&nbsp;&nbsp;Километри: <span id="vh-garmin-estimationkm-<?= $row["code"]?>"><?=$etaDist?></span><img id="vh-img-garminref-<?= $row["code"]?>" onclick="refreshEstimation('<?=$row["gsmnumber"]?>', '<?=$row["code"]?>')" src="../images/smallref.png" width="17px" style="cursor: pointer; position: absolute; right: 5px; bottom: 6px;" onmouseover="ShowPopup(event, '<?=dic_("ClickNewData")?>')" onmouseout="HidePopup()" /></div>
			            </div>
		            <?php } else { 
		            	if($row["allowgarmin"] == "1") { ?>
		            		<div id="garminstop-<?php echo $row["code"]?>" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="width:205px; padding-left:5px; padding-right:5px; float:left; background-color:#fafafa; color:#333333; font-size:10px; border-top:1px dotted #333; display: block;">
		            			<img src="../images/areaSave1.png" width="14px" style="padding-top: 2px; padding-bottom: 2px; position: relative; float: left;" />
		            			<div id="vh-garmin-status-<?php echo $row["code"]?>" onclick="checkGarmin('<?=$row["gsmnumber"]?>')" onmouseover="ShowPopup(event, '<?=dic_("ClickCheckGarmin")?>')" onmouseout="HidePopup()" style="cursor: pointer; width: 190px; position: relative; float: right; left: 5px; top: 2px;"><?=dic_("Garmin")?>: <?=dic_("Inactive")?> <img src="../images/stikla3.png" width="10px" style="padding-top: 2px; padding-bottom: 2px; padding-right: 4px; position: relative; float: right;" /></div>
		            		</div>
	            	<?php } } ?>
			</div>
		<?php
			$brojaaac++;
		}
		?>
	</div>
</div>

<div id="menu-3" class="menu-container<?php echo $al2?>" style="width:248px;<?php echo $al3?>">
	<a id="menu-title-3" href="#" class="menu-title<?php echo $al2?> text3" onClick="<?php echo $al?>OnMenuClick(3)" style="width:100%;<?php echo $al1?>"><?php echo dic_("Routes.Alarms")?>
		<img src="../images/downMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 2px; " />
		<img src="../images/upMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 1px; " />
	</a>
	<div id="menu-container-3" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow-y: hidden; overflow-x:auto;">
		<?php
		if($allowedAlarms)
		{?>
			<div id="alarms">
				<?php
					$sqlAlarm = "";
					$sqlAlarm .= "select ah.*, v.registration from alarmshistory ah left join vehicles v on v.id=ah.vehicleid ";
					$sqlAlarm .= " where ah.vehicleid in (" . $sqlV . ") ";
					$sqlAlarm .= " and ah.datetime > cast((select now()) as date) + cast('-1 day' as interval) ";
					$sqlAlarm .= " order by read asc, datetime desc";
					$dsAlarms = query($sqlAlarm);
					$brojac = 1;
					$brojac1 = dlookup("select count(*) from alarmshistory where vehicleid in (" . $sqlV . ") and datetime > cast((select now()) as date) + cast('-1 day' as interval) and read='0'");
					while($row = pg_fetch_array($dsAlarms))
					{
						$tzDatetime = new DateTime($row["datetime"]);
						list($d, $m, $y) = explode('-', $row["datetime"]);
						$a = explode(" ", $y);
						$d1 = explode(":", $a[1]);
						$d2 = explode(".", $d1[2]);
						$idCreate = $row["vehicleid"] . "_" . $d . "_" . $m . "_" . $a[0] . "_" . $d1[0] . "_" . $d1[1] . "_" . $d2[0] . "_" . $d2[1];
						if($row["read"] == "0")
						{
							?>
							<script>
								AlertEventInit('<?php echo $row["datetime"]?>', '<?php echo $row["registration"]?>', '<?php echo $row["name"]?>', '<?php echo $row["vehicleid"]?>', '<?php echo $brojac1?>');
							</script>
							<?php
							$brojac1--;
						}
						$readuser = $row["readuser"];
						$userid = session("user_id");
						$bg = 'no1';
						$ru = explode(",", $readuser);
						$bool = FALSE;
						for($i=0;$i<sizeof($ru);$i++)
						{
						    if($ru[$i] == $userid)
						    	$bool = TRUE;
						}
						$zonename = '';
				  	  
						if($bool)
						{
							$bg = 'yes1';
						?>
						<div id="alarmList" style="overflow: hidden" class="div-one-vehicle-list text3 corner5" onclick="OpenMapAlarm2('<?php echo $row["datetime"]?>', '<?php echo $row["registration"]?>', '<?php echo $row["name"]?>', '<?php echo $row["vehicleid"]?>', '<?php echo ($brojac1+1)?>')">
						<?php } else { ?>
							<div id="alarmList" style="overflow: hidden" class="div-one-vehicle-list text3 corner5" onclick="OpenMapAlarm1('<?php echo $row["datetime"]?>', '<?php echo $row["registration"]?>', '<?php echo $row["name"]?>', '<?php echo $row["vehicleid"]?>', '<?php echo ($brojac1+1)?>')">
						<?php } ?>
							<div style="width: 91px; float:left;">
								<div id="alarm-small-<?php echo $idCreate?>" onMouseOver="ShowPopup(event, '<?php echo dic_("Tracking.Read")?>/<?php echo dic_("Tracking.Unread")?><?php echo dic_("Tracking.FromUser")?>')" onMouseOut="HidePopup()" style="float:left; width:12px; height:12px; margin-left:5px; background-image: url('../images/<?php echo $bg?>.png'); margin-top:1px; margin-bottom:2px; cursor:pointer"></div>
								<div style="color: #000000; width: 68px; height: 14px; overflow: hidden; float:left; padding-top:2px; padding-left:3px; font-weight:bold; cursor:pointer" ><?php echo $row["registration"]?></div>
							</div>
							<div id="vh-date-" style="width:117px; position: relative; right: 2px; top: 2px; float:right; text-align:right; color:#000000; font-size:10px;">
							<?php echo $tzDatetime->format($dateformat . " " . $timeformat).''?>
							</div>
							<div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
								<?php echo dic_("Tracking.Alarm")?>: <span style="font-weight: bold"><?php echo dic($row["name"]) ?></span>
							</div>
							<?php
							if($row["name"] == "enterZone")
						  	{
						  		$zonename = dlookup("select poi.name from tempzone tz left join pointsofinterest poi on tz.zoneid=poi.id where poi.active='1' and tz.datetimein='" . $row["datetime"] . "' and tz.vehid=" . $row["vehicleid"] . " and tz.inoutzone='1'");
						  	 
							?>
							<div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
								<?php echo dic_("Reports.GeoFence")?>: <span style="font-weight: bold"><?php echo $zonename ?></span>
							</div>
							<?php
							}
							if($row["name"] == "leaveZone")
						  	{
						  		$zonename = dlookup("select poi.name from tempzone tz left join pointsofinterest poi on tz.zoneid=poi.id where poi.active='1' and tz.datetimeout='" . $row["datetime"] . "' and tz.vehid=" . $row["vehicleid"] . " and tz.inoutzone='0'");
							 
					  		?>
					  		<div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
								<?php echo dic_("Reports.GeoFence")?>: <span style="font-weight: bold"><?php echo $zonename?></span>
							</div>
					  		<?php
							}
					  		?>
						</div>
					<?php
						$brojac++;
					}
					?>
				</div>
			<?php } ?>
			<br><br>&nbsp;
	</div>
</div>

<?php
	$cntz=0;
	if($AllowViewZone == "1")
	{
?>
<div id="menu-4" class="menu-container" style="width:248px">
	<a id="menu-title-4" href="#" class="menu-title text3" onClick="OnMenuClick(4)" style="width:100%"><?php echo dic("Tracking.geofence")?>
		<img src="../images/downMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 2px; " />
		<img src="../images/upMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 1px; " />
	</a>
	<div id="menu-container-4" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow-y: hidden; overflow-x:auto;">
		<div id="add_del_geofence">
			<?php
				$str3 = "";
				if (session("role_id")."" != "2")
					$str3 = " and (ca.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or ca.userid=" . session("user_id") . " or ca.available = 3)";
    
				$dsZone = query("select ca.*, ppg.fillcolor color from pointsofinterest ca left outer join pointsofinterestgroups ppg on ca.groupid=ppg.id where ca.active='1' and ca.type=2 and ca.clientid=" . session("client_id") . $str3 . " ORDER BY ca.name asc");
				
				while($row = pg_fetch_array($dsZone))
				{
				?>
					<div style="width:94%; border:1px solid #95b1d7; background-color:#c6d7f2; margin-bottom:5px; overflow-x: hidden; overflow-y:auto" class="text5">
						<input id="zona_<?php echo $cntz?>" type="checkbox" onChange="if (this.checked==true){checkGF(1); DrawZoneOnLive2('<?php echo $row["id"]?>', '<?php echo $row["color"]?>')} else {checkGF(0); RemoveFeature('<?php echo $row["id"]?>')}"><span onclick="DrawZoneOnLive1('<?php echo $row["id"]?>', '<?php echo $row["color"]?>', 'zona_<?php echo $cntz?>')" style="cursor:pointer"><?php echo $row["name"]?></span>
						&nbsp;
						<div class="allzones" id="geo-fence-<?php echo $row["id"]?>" style="width: auto; position: relative; float: right;"></div>
					</div>
				<?php
					$cntz = $cntz + 1;
				}
			?>
			
		</div>
		<br><br>&nbsp;
	</div>
</div>

<?php
 
	if($ClientTypeID == 2){
		$tabNo = 7;
	} else { $tabNo = 6; }
	
	if (session("role_id")."" == "2") {
		$dsStopStat = query("select *, (select code from vehicles where id = toid) veh_code, (select registration from vehicles where id = toid) registration from stopstatus where clientid = " . session("client_id")." and datetime >= (select cast(cast(now() as date) || ' 00:00:00' as timestamp)) order by status");
	} else {
		$dsStopStat = query("select *, (select code from vehicles where id = toid) veh_code, (select registration from vehicles where id = toid) registration from stopstatus where toid in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and datetime >= (select cast(cast(now() as date) || ' 00:00:00' as timestamp)) order by status");
	}
	
	if(pg_num_rows($dsStopStat) > 0 || $allowGarminVeh > 0){
?>
	<div id="menu-<?= $tabNo; ?>" class="menu-container" style="width:248px">
		<a id="menu-title-<?= $tabNo; ?>" href="#" class="menu-title text3" onClick="OnMenuClick(<?= $tabNo; ?>)" style="width:100%"><?=dic_("Garmin")?>
			<img src="../images/downMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 2px; " />
			<img src="../images/upMenu1.png" width="8" height="11" style="position: relative; float: right; opacity: 0.13; right: 40px; top: 1px; " />
		</a>
		
		<div id="menu-container-<?= $tabNo; ?>" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow-y: hidden; overflow-x:auto;">
			
			<?php while ($row = pg_fetch_array($dsStopStat)) {
				$StartDatetime = new DateTime($row["dtstart"]);
				$EndDatetime = new DateTime($row["dtend"]);
				$DelDatetime = new DateTime($row["dtdelete"]);
				$longitude = $row["longitude"];
				$latitude = $row["latitude"];
				$location = $row["location"];
				$opacity = '';
				if($row["flag"] == 1){
					$image = '<img src="../images/no1.png"  />';	
					if($row["status"] == 100){
						$status = dic_("Reports.Active");	
					} 
					else if($row["status"] == 101){
						$image = '<img src="../images/yes1.png"  />';
						$status = dic_("Reports.Completed");
					}
					else if($row["status"] == 102){
						$status = dic_("Reports.Unread");
					}
					else if($row["status"] == 103){
						$status = dic_("Reports.Read");
					} if($row["status"] == 104){
						$opacity = 'opacity: 0.5';
						$status = dic_("Reports.Deleted");
					} 
				} else {
					$opacity = 'opacity: 0.5';
					$image = '<img src="../images/nosignal.png"  />';
				}
			 ?>
			 
			 <div id="garminList-<?php echo $row["toid"]?>-<?php echo $row["garminid"]?>" style="overflow: hidden; <?= $opacity ?>;" class="div-one-vehicle-list text3 corner5">
				<div>
					<div onClick="setStopPositionCenter(<?= $longitude?>,<?= $latitude?>,'<?= $row["text"]?>')" style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer"><?= $image; ?></div>
					<div onClick="setStopPositionCenter(<?= $longitude?>,<?= $latitude?>,'<?= $row["text"]?>')" style="color: #000000; width: 125px; text-overflow: ellipsis; white-space: nowrap; height: 14px; overflow: hidden; float:left; padding-top:2px; padding-left:3px; font-weight:bold; cursor:pointer"><?= $row["registration"]; ?> (<?= $row["veh_code"] ?>)</div>
					<div id="vh-garminList-status-<?php echo $row["code"]?>" style="width: 65px; position: relative; right: 2px; top: 2px; float:right; text-align:right; color:#000000; font-size:10px;" >
						<?= $status; ?>
					</div>
				</div>
				<div id="vh-garminList-text-<?php echo $row["code"]?>" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
					<?=dic_("Admin.Text")?>: <?= $row["text"] ?>
				</div>
				<div id="vh-garminList-location-<?php echo $row["code"]?>" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
					<?=dic_("Reports.Location")?>: <?= $location; ?>
				</div>
			<?php if($row["dtstart"] != ''){ ?>
				<div id="vh-garminList-start-<?php echo $row["code"]?>" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
					<?=dic_("Tracking.Start")?>: <?= $StartDatetime->format($dtformat).''?>
				</div>
			<?php }
				if($row["dtend"] != ''){ ?>
				<div id="vh-garminList-end-<?php echo $row["code"]?>" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
					<?=dic_("End")?>: <?= $EndDatetime->format($dtformat).''?>
				</div>
			<?php } 
				if($row["dtdelete"] != ''){ ?>
				<div id="vh-garminList-delete-<?php echo $row["code"]?>"style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
					<?=dic_("Reports.Deleted")?>: <?= $DelDatetime->format($dtformat).''?>
				</div>
			<?php } ?>
			
			</div>
			 
			 <?php } ?>
		</div>
	</div>
	
	<?php } ?>
	<!--button onclick="getGarminInfo(67)">VOZILO</button>
	<h4><?= $allowGarminVeh; ?>-Возила со Гармин</h4-->
<?php
}
closedb();
?>
<script>
	function getGarminInfo(_garminID){
	 	$.ajax({
	        type: "GET",
	        url: "getGarminInfo.php",
	        data: 'id='+_garminID,
	        cache: false,
	        
	        success: function(data){
	            $("#web-content").html(_garminID);
	        }
	    });
   	}
</script>




