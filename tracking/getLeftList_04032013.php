<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	if (session("role_id")."" == "2"){
		$sqlV = "select id from vehicles where clientid=".session("client_id");
	} else {
		$sqlV = "select vehicleid from uservehicles where userid=".session("user_id");
	}
	set_time_limit(0);
	opendb();
	
	$dsCP = query('select cast(v.code as integer), v.registration, v.model, cp.*, cp."DateTime" tzdatetime, visible from currentposition cp left outer join vehicles v on v.id=cp.vehicleid where v.id in (' . $sqlV . ')  order by 1');

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
	$dsAllowed = query("select timedate,speed,location,poi,zone,passengers,taximeter,fuel from users where id=" . session("user_id"));
	if(pg_fetch_result($dsAllowed, 0, "speed") != "1" && pg_fetch_result($dsAllowed, 0, "taximeter") != "1" && pg_fetch_result($dsAllowed, 0, "passengers") != "1")
		$AllowedSTP = "0";
	else
		$AllowedSTP = "1";
	$AllowViewZone = getPriv("ViewZones", session("user_id"));
?>

<div id="menu-4" class="menu-container" style="width:100%">
	<a id="menu-title-4" href="#" class="menu-title text3" onClick="OnMenuClick(4)" style="width:100%"><?php echo dic("Tracking.VehDetails")?></a>
	<div id="searchVeh" style="width:230px; padding-left:10px; padding-top:10px; overflow:hidden; height: 55px; margin-bottom: -8px;">
        <input type="text" style="width: 220px; font-family: Arial,Helvetica,sans-serif; font-size: 12px;" name="searchbyreg" id="searchbyreg" value="" onkeyup="searchVehicle(this)" placeholder="<?php echo dic("Fm.SearchReg")?>" />
        <input type="text" style="width: 220px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; position: relative; top: 5px;" name="searchbydriv" id="searchbydriv" value="" onkeyup="searchByDriver(this)" placeholder="<?php echo dic("searchbydriver")?>" />
	</div>
	<div id="menu-container-4" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
		<?php
			
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
		       $dsPre = query("select ID, code, FullName from Drivers where clientid=" . Session("client_id") . " and id in (select Driverid from VehicleDriver where VehicleID in (select id from Vehicles where ID=" . $row["vehicleid"] . ")) order by FullName");
		        //$dsPre = query("select * from drivers where clientid=" . Session("client_id"));
			?>
			<script type="text/javascript">
            	var vis = '<?php echo $row["visible"]?>';
            	if (vis != "1")
                	EnableDisable('<?php echo $row["vehicleid"]?>','<?php echo $row["code"]?>');
        	</script>
			<div id="vehicleList-<?php echo $row["code"]?>" style="overflow: hidden" class="div-one-vehicle-list text3 corner5" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')">
	            <div id="divOpt-<?php echo $row["vehicleid"]?>" class="corner5" onmouseout="MouseOutOptions('vehOption-<?php echo $row["code"]?>')" onmouseover="OpenOptionsForVeh(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>', 0)" style="width: 120px; height: auto; opacity: 0.9; background-color: #387CB0; display: none; position: absolute; border: 1px Solid Black; left: 117px; color: White; text-align: center; z-index: 9;">
	                <div id="settings-<?php echo $row["code"]?>">
	                    <img id="closeSett" width="13px" src="../images/close.png" style="position: relative; float: right; right: 3px; top: 3px;" onclick="CloseSett('<?php echo $row["vehicleid"]?>', '')" alt="" />
	                    <font onmouseover="OpenOptionsForVeh(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>', 0)" style="text-decoration: underline; position: relative; left: -1px;"><?php echo dic("Tracking.Settings")?></font><br />
	                    <font onmouseover="OpenOptionsForVeh(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>', 0)" style="text-decoration: underline; position: relative; left: -8px; font-size: 11px;">(<?php echo $row["code"]?>)&nbsp;<?php echo $row["registration"]?></font>
	                    <div style="height: 5px;">&nbsp;</div>
	                    <div id="ActiveSett-<?php echo $row["vehicleid"]?>" class="meni" onclick="EnableDisable('<?php echo $row["vehicleid"]?>', '<?php echo $row["code"]?>')"><?php echo dic("Tracking.Deactive")?></div>
	                    <div id="FuelSett-<?php echo $row["vehicleid"]?>" onclick="FuelSett(event, '<?php echo $row["vehicleid"]?>', '')">
	                        <div class="meni"><?php echo dic("Tracking.Fuel")?></div>
	                        <div id="fuel-item-<?php echo $row["vehicleid"]?>" style="display: none; text-align: left; margin-left: 5px; min-height: 125px; top: 6px; position: relative;">
	                            <input id="inp1-<?php echo $row["vehicleid"]?>" class="corner5 text9" type="text" style="width: 50px; margin-bottom: 4px; text-align: right; border: 0px; height: 20px; padding-right: 3px;" />&nbsp;&nbsp;<?php echo dic("Tracking.Litres")?><br />
	                            <input id="inp2-<?php echo $row["vehicleid"]?>" class="corner5 text9" type="text" style="width: 50px; margin-bottom: 4px; text-align: right; border: 0px; height: 20px; padding-right: 3px;" />&nbsp;&nbsp;<?php echo dic("Tracking.Amount")?><br />
	                            <select id="DriversSett-<?php echo $row["vehicleid"]?>" class="text9" style="width: 111px; font-size: 11px; height: 20px; cursor: pointer; border-radius: 5px 0px 0px 5px; border: 1px solid Transparent;">
	                            <?php
	                            	
	                                while($row1 = pg_fetch_array($dsPre))
	                                {
	                            ?>
	                                <option value="<?php echo $row1['id']?>" style="font-size: 14px;"><?php echo $row1['fullname']?></option>
	                            <?php
	                                }
	                            ?>
	                            </select>
	                            <button id="btn-<?php echo $row["vehicleid"]?>" onclick="AddFuel('<?php echo $row["vehicleid"]?>', '')" style="width: 60px; position: relative; top: 12px; left: 26px;"><?php echo dic("Tracking.Enter")?></button>
	                        </div>
	                    </div>
	                    <div id="DriverSett-<?php echo $row["vehicleid"]?>" onclick="DrivSett(event, '<?php echo $row["vehicleid"]?>', '')">
	                        <div class="meni"><?php echo dic("Tracking.Driver")?></div>
	                        <div id="driv-item-<?php echo $row["vehicleid"]?>" style="display: none; text-align: left; min-height: 50px; position: relative; overflow-y: auto; width: 100%; height: 100px;">
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
	                    <div style="height: 5px;">&nbsp;</div>
	                </div>
	            </div>
	            <script type="text/javascript">
	                $('#btn-' + <?php echo $row["vehicleid"]?>).button();
	            </script>
				<div style="width:40%; float:left;" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')">
					<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="vh-small-<?php echo $row["code"]?>" class="gnMarkerListGray" style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer"  onClick="FindVehicleOnMap0(<?php echo $row["code"]?>)" onMouseOver="ShowPopup(event, '<?php echo dic("Tracking.ClickToFind")?> <?php echo $row["code"]?>')" onMouseOut="HidePopup()"><?php echo $row["code"]?></div>
					<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="color: #000000; width: 61px; height: 14px; overflow: hidden; float:left; padding-top:2px; padding-left:5px; font-weight:bold; cursor:pointer" onclick="FindVehicleOnMap0(<?php echo $row["code"]?>)" onMouseOver="ShowPopup(event, '<?php echo dic("Tracking.ClickToFind")?> <?php echo $row["code"]?>')" onMouseOut="HidePopup()"><?php echo $row["registration"]?></div>
				</div>
	            <div id="vehOption-<?php echo $row["code"]?>" class="corner5" onclick="OpenOptionsForVeh(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>', 1)" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" style="display: none; width:8%; height: 15px; float:left; color:#000000; font-size:10px; background: Snow url(../images/keyblue.png) no-repeat center center; border: 1px Solid #387CB0; cursor: pointer;"></div>
				<?php if(pg_fetch_result($dsAllowed, 0, "timedate") == "1"){
                ?>
				<div id="vh-date-<?php echo $row["code"]?>" style="width:51%; float:right; text-align:right; color:#000000; font-size:10px;" onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')">
				<?php echo $tzDatetime->format("d-m-Y H:i:s").''?>&nbsp;
				</div>
				<?php } 
					if(true){
                ?>
	            <div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic_("Tracking.Driver") ?>: <span style="font-weight: bold" id="vh-driver-<?php echo $row["code"]?>"><?php echo $strDrivName ?></span>
				</div>
	            <div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php echo dic("Fm.Marka")
					    ?>: <span style="font-weight: bold" id="vh-type-<?php echo $row["code"]?>"><?php echo $row["model"]?></span>
				</div>
	            <?php } 
	            	if($AllowedSTP == "1"){
                ?>
				<div onmouseover="MouseOverOptions('vehOption-<?php echo $row["code"]?>','<?php echo $row["vehicleid"]?>')" id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">							
					<?php
						if(pg_fetch_result($dsAllowed, 0, "speed") == "1"){ ?>
					<?php echo dic("Tracking.Speed")?>: <span style="font-weight: bold" id="vh-speed-<?php echo $row["code"]?>">0 Km/h</span>&nbsp;
					<?php } 
						if(pg_fetch_result($dsAllowed, 0, "taximeter") == "1"){
					?>
					<span id="div-taxi-<?php echo $row["code"]?>" style="color:#ff0000;"><?php echo dic("Tracking.Taximeter")?></span>&nbsp;
					<?php } 
						if(pg_fetch_result($dsAllowed, 0, "passengers") == "1"){
					?>
					<span><?php echo dic("Tracking.Passengers")?>:</span><span id="vh-sedista-<?php echo $row["code"]?>" style="font-size:12px; color:#000066;">0</span>
					<?php } ?>
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
	            <?php } ?>
			</div>
		<?php
		}
		?>
	</div>
</div>

<?php
	$cntz=0;
	if($AllowViewZone == "1")
	{
?>
<div id="menu-5" class="menu-container" style="width:100%">
	<a id="menu-title-5" href="#" class="menu-title text3" onClick="OnMenuClick(5)" style="width:100%"><?php echo dic("Tracking.geofence")?></a>
	<div id="menu-container-5" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
		<div id="add_del_geofence">
			<?php
				
				$dsZone = query("select ca.*, ppg.fillcolor color from pointsofinterest ca left outer join pointsofinterestgroups ppg on ca.groupid=ppg.id where ca.type=2 and ca.clientid=" . session("client_id"));
				
				while($row = pg_fetch_array($dsZone))
				{
				?>
					<div style="width:94%; border:1px solid #95b1d7; background-color:#c6d7f2; margin-bottom:5px; overflow:auto" class="text5">
						<input id="zona_<?php echo $cntz?>" type="checkbox" onChange="if (this.checked==true){checkGF(1); DrawZoneOnLive('<?php echo $row["id"]?>', '<?php echo $row["color"]?>')} else {checkGF(0); RemoveFeature('<?php echo $row["id"]?>')}"><span onclick="DrawZoneOnLive1('<?php echo $row["id"]?>', '<?php echo $row["color"]?>', 'zona_<?php echo $cntz?>')" style="cursor:pointer"><?php echo $row["name"]?></span>
						&nbsp;
						<br>
						<div id="geo-fence-<?php echo $row["id"]?>"></div>
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
}
closedb();
?>