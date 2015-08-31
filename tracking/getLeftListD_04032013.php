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
	
	$dsCP = query('select cast(v.code as integer), v.registration, cp.*, cp."DateTime" tzdatetime from currentposition cp left outer join vehicles v on v.id=cp.vehicleid where v.id in (' . $sqlV . ')  order by 1');
	
	$AllowedMaps = "11111";	
	

?>
<div id="menu-6" class="menu-container-collapsed" style="width:100%">
	<a id="menu-title-6" href="#" class="menu-title-collapsed text3" onClick="OnMenuClick(6)" style="width:100%"><?php echo dic("Tracking.Inactive")?></a>
	<div id="menu-container-6" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
		<?php
			while($row = pg_fetch_array($dsCP))
			{
				$lon = $row["longitude"];
				$lat = $row["latitude"];
				//if($row["LongOrientation"] == "W") $lon = "-" & $lon;
				//if($row["LatOrientation"] == "S") $lat = "-" & $lat;
				
				//$dsAllow = query("select AllowPassinger, AllowTaximeter from vehicles where id=" . $row["vehicleid"]);
				
				$strTaxi = "";
				$strPas = "";
				
				/*if(odbc_result($dsAllow,"AllowTaximeter") == false) 
					$strTaxi = "display:none";
				
				if (odbc_result($dsAllow,"AllowPassinger") == false) 
					$strPas = "display:none";*/

				$tzDatetime = new DateTime($row["tzdatetime"]);

			?>
		<div id="vehicleList-<?php echo $row["code"]?>-disable" class="div-one-vehicle-list text3 corner5" style="display: none;" onmouseover="MouseOverOptionsDISABLE('vehOption-<?php echo $row["code"]?>-disable','<?php echo $row["vehicleid"]?>')">
            <div id="divOpt-<?php echo $row["vehicleid"]?>-disable" class="corner5" onmouseout="MouseOutOptionsDISABLE('vehOption-<?php echo $row["code"]?>-disable')" onmouseover="OpenOptionsForVehDISABLE(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>-disable', 0)" style="width: 120px; height: auto; opacity: 0.9; background-color: #387CB0; display: none; position: absolute; border: 1px Solid Black; left: 117px; color: White; text-align: center; z-index: 9;">
                <div id="settings-<?php echo $row["code"]?>-disable">
                    <img id="closeSett-disable" width="13px" src="../images/close.png" style="position: relative; float: right; right: 3px; top: 3px;" onclick="CloseSett('<?php echo $row["vehicleid"]?>', '-disable')" alt="" />
                    <font onmouseover="OpenOptionsForVehDISABLE(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>-disable', 0)" style="text-decoration: underline; position: relative; left: -1px;"><?php echo dic("Tracking.Settings")?></font><br />
                    <font onmouseover="OpenOptionsForVehDISABLE(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>-disable', 0)" style="text-decoration: underline; position: relative; left: -8px; font-size: 11px;">(<?php echo $row["code"]?>)&nbsp;<?php echo $row["registration"]?></font>
                    <div style="height: 5px;">&nbsp;</div>
                    <div id="ActiveSett-<?php echo $row["vehicleid"]?>-disable" class="meni" onclick="EnableDisableDISABLE('<?php echo $row["vehicleid"]?>', '<?php echo $row["code"]?>')"><?php echo dic("Tracking.Active")?></div>
                    <div id="FuelSett-<?php echo $row["vehicleid"]?>-disable" onclick="FuelSett(event, '<?php echo $row["vehicleid"]?>', '-disable')">
                        <div class="meni"><?php echo dic("Tracking.Fuel")?></div>
                        <div id="fuel-item-<?php echo $row["vehicleid"]?>-disable" style="display: none; text-align: left; margin-left: 5px; min-height: 125px; top: 6px; position: relative;">
                            <input id="inp1-<?php echo $row["vehicleid"]?>-disable" class="corner5 text9" type="text" style="width: 50px; margin-bottom: 4px; text-align: right; border: 0px; height: 20px; padding-right: 3px;" />&nbsp;&nbsp;<?php echo dic("Tracking.Litres")?><br />
                            <input id="inp2-<?php echo $row["vehicleid"]?>-disable" class="corner5 text9" type="text" style="width: 50px; margin-bottom: 4px; text-align: right; border: 0px; height: 20px; padding-right: 3px;" />&nbsp;&nbsp;<?php echo dic("Tracking.Amount")?><br />
                            <select id="DriversSett-<?php echo $row["vehicleid"]?>-disable" class="text9" style="width: 111px; font-size: 11px; height: 20px; cursor: pointer; border-radius: 5px 0px 0px 5px; border: 1px solid Transparent;">
                            <?php
                            	$dsDriv = query("select id, fullname from drivers where clientid=" . session("client_id"));
                                while($row1 = pg_fetch_array($dsDriv))
                                {
                            ?>
                                <option value="<?php echo $row1['id']?>" style="font-size: 14px;"><?php echo $row1['fullname']?></option>
                            <?php
                                }
                            ?>
                            </select>
                            <button id="btn-<?php echo $row["vehicleid"]?>-disable" onclick="AddFuel('<?php echo $row["vehicleid"]?>', '-disable')" style="width: 60px; position: relative; top: 12px; left: 26px;"><?php echo dic("Tracking.Enter")?></button>
                        </div>
                    </div>
                    <div id="DriverSett-<?php echo $row["vehicleid"]?>-disable" onclick="DrivSett(event, '<?php echo $row["vehicleid"]?>', '-disable')">
                        <div class="meni"><?php echo dic("Tracking.Driver")?></div>
                        <div id="driv-item-<?php echo $row["vehicleid"]?>-disable" style="display: none; text-align: left; margin-left: 5px; min-height: 50px; top: 6px; position: relative;">
                        &nbsp;<?php echo dic("Tracking.ComingSoon")?></div>
                    </div>
                    <div style="height: 5px;">&nbsp;</div>
                </div>
            </div>
            <script type="text/javascript">
                $('#btn-<?php echo $row["vehicleid"]?>-disable').button();
            </script>
			<div style="width:40%; float:left;" onmouseover="MouseOverOptionsDISABLE('vehOption-<?php echo $row["code"]?>-disable','<?php echo $row["vehicleid"]?>')">
				<div onmouseover="MouseOverOptionsDISABLE('vehOption-<?php echo $row["code"]?>-disable','<?php echo $row["vehicleid"]?>')" id="vh-small-<?php echo $row["code"]?>-disable" class="gnMarkerListGray" style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer"><?php echo $row["code"]?></div>
				<div onmouseover="MouseOverOptionsDISABLE('vehOption-<?php echo $row["code"]?>-disable','<?php echo $row["vehicleid"]?>')" style="color: #000000; width: 61px; height: 14px; overflow: hidden; float:left; padding-top:2px; padding-left:5px; font-weight:bold; cursor:pointer"><?php echo $row["registration"]?></div>
			</div>
            <div id="vehOption-<?php echo $row["code"]?>-disable" class="corner5" onclick="OpenOptionsForVehDISABLE(event, '<?php echo $row["vehicleid"]?>','vehOption-<?php echo $row["code"]?>-disable', 1)" onmouseover="MouseOverOptionsDISABLE('vehOption-<?php echo $row["code"]?>-disable','<?php echo $row["vehicleid"]?>')" style="display: none; width:8%; height: 15px; float:left; color:#000000; font-size:10px; background: Snow url(../images/keyBlue.png) no-repeat center center; border: 1px Solid #387CB0; cursor: pointer;"></div>
		</div>
		<?php
			}
		?>
	</div>
</div>
