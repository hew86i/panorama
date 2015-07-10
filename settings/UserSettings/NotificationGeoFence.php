<?php include "../../include/functions.php" ?>
<?php include "../../include/db.php" ?>

<?php include "../../include/params.php" ?>
<?php include "../../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	opendb();
    $UserID = str_replace("'", "''", NNull($_GET['uid'], ''));
    $role = str_replace("'", "''", NNull($_GET['role'], '3'));

	if ($role == "2" || $role == "1"){
	    $dsp = query("select id as VehicleID, Registration, NumberOfVehicle from Vehicles where ClientID = " . Session("client_id") . " order by NumberOfVehicle");
	}
	if($role == "3"){
	    $dsp = query("select * from UserVehicles left outer join Vehicles on Vehicles.ID = UserVehicles.VehicleID where UserVehicles.UserID = " . $UserID . " order by NumberOfVehicle");
	}
?>

<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
</style>

<div id="div-vehicles-notification">
<?php
    if(odbc_num_rows($dsp) > 0)
	{
        while($row = odbc_fetch_array($dsp))
		{                
?>
    <div class="text5 corner5" style="font-size:14px; width:97%; height:30px; padding:2px 2px 2px 2px; margin:2px 2px 2px 2px; border:1px solid #ccc;  background-color:#eee;" id="vehicle_<?php echo $row["VehicleID"]?>">
        &nbsp;&nbsp;&nbsp;<strong style="top:5px; position:relative"><?php echo $row["Registration"]?>(<?php echo $row["NumberOfVehicle"]?>)</strong>
        &nbsp;&nbsp;<button style="float:right; width:29px " id="veBtnDelG_<?php echo $row["VehicleID"]?>" onclick="VehicleBtnDelGeo(<?php echo $row["VehicleID"]?>)">&nbsp;</button>
        &nbsp;&nbsp;<button style="float:right; width:29px" id="veBtnAddG_<?php echo $row["VehicleID"]?>" onclick="VehicleBtnAddGeo(<?php echo $row["VehicleID"]?>)">&nbsp;</button></p>
    </div>
    <script>
        $('#veBtnDelG_<?php echo $row["VehicleID"]?>').button({ icons: { primary: "ui-icon-trash"} });
        $('#veBtnAddG_<?php echo $row["VehicleID"]?>').button({ icons: { primary: "ui-icon-plus"} });
    </script>
<?php
			$dsZone = query("select AreasAlarmsDetail.ID, areaID, vehicleID, Name, type from AreasAlarmsDetail left outer join ClientAreas on ClientAreas.ID = AreasAlarmsDetail.areaID where vehicleID = " . $row["VehicleID"] . " and AreasAlarmsDetail.UserID = " . $UserID);
			//echo "select AreasAlarmsDetail.ID, areaID, vehicleID, Name, type from AreasAlarmsDetail left outer join ClientAreas on ClientAreas.ID = AreasAlarmsDetail.areaID where vehicleID = " . $row["VehicleID"] . " and AreasAlarmsDetail.UserID = " . $UserID;
			//echo "<br />";
			//echo odbc_num_rows($dsZone);
			//exit;
			
			if(odbc_num_rows($dsZone) > 0)
			{
		        while($row1 = odbc_fetch_array($dsZone))
				{ 
		        	if($row1["type"]."" == "2")
					{
?>
    <div class="text5 corner5" style="font-size:12; width:97%; padding:2px 2px 2px 2px; margin:2px 2px 2px 2px; height:30px;" id="zon_<?php echo $row1["ID"]?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?php echo dic("Settings.InGeoFence")?></em> <strong style="font-weight:bold; color:#800000;"><?php echo $row1["Name"]?></strong>
        &nbsp;&nbsp;<button style="float:right; width:29px" id="zoBtn_<?php echo $row1["ID"]?>" value="Delete" onclick="ZoneBtnDel(<?php echo $row1["ID"]?>)" >&nbsp;</button></p>
    </div>
    <script>
        $('#zoBtn_<?php echo $row1["ID"]?>').button({ icons: { primary: "ui-icon-trash"} });
    </script>
    <?php
		    		}
		    		if($row1["type"]."" == "3")
					{
?>        
    <div class="text5 corner5" style="font-size:12; width:97%; padding:2px 2px 2px 2px; margin:2px 2px 2px 2px; height:30px;" id="zon_<?php echo $row1["ID"]?>">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?php echo dic("Settings.OutGeoFence")?></em> <strong style="font-weight:bold; color:#800000;"><?php echo $row1["Name"]?></strong>&nbsp;&nbsp;
        <button  style="float:right; width:29px" id="zoBtn_<?php echo $row1["ID"]?>" value="Delete" onclick="ZoneBtnDel(<?php echo $row1["ID"]?>)" >&nbsp;</button></p>
    </div>
    <script>
        $('#zoBtn_<?php echo $row1["ID"]?>').button({ icons: { primary: "ui-icon-trash"} });
    </script>
<?php
		    		}
				}
			}
		}
	}
?>
</div>
<div id="div-del-vehicle" style="display:none" title="<?php echo dic("Settings.Delete")?>">
    <?php echo dic("Settings.DelAllAlarms")?>
</div>
<div id="div-del-ZoneAlarm" style="display:none" title="<?php echo dic("Settings.Delete")?>">
    <?php echo dic("Settings.DelAlarm")?>
</div>
<div id="div-add-schedule" style="display:none" title="<?php echo dic("Settings.AddSchedule")?>">
   
</div>
<script>
    function VehicleBtnDelGeo(VehicleID) {
        $('#div-del-vehicle').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
                <?php echo dic("Settings.Yes")?>: function () {
                    $.ajax({
                        url: "UserSettings/DelVehicleAlarms.php?vid=" + VehicleID + "&a=3",
                        context: document.body,
                        success: function (data) {
                            ShowNotification(-1);
                        }
                    });
                    $(this).dialog("close");
                },
                <?php echo dic("Settings.No")?>: function () {
                    $(this).dialog("close");
                }
            }
        });
    }

    function ZoneBtnDel(zaID) {
        $('#div-del-ZoneAlarm').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
                Yes: function () {
                    $.ajax({
                        url: "UserSettings/DelVehicleAlarms.php?vid=" + zaID + "&a=4",
                        context: document.body,
                        success: function (data) {
                            ShowNotification(-1);
                        }
                    });
                    $(this).dialog("close");
                },
                No: function () {
                    $(this).dialog("close");
                }
            }
        });
    }

    function VehicleBtnAddGeo(vid) {
        var uid = $('#lbUsers').val();
        var reload = "0";
        $.ajax({
            url: "UserSettings/VehicleAlarmsGeo.php?uid=" + uid + "&vid=" + vid,
            context: document.body,
            success: function (data) {
                $('#div-add-schedule').html(data)
                var Combo1 = document.getElementById("cbVehicle_" + vid);
                Combo1.value = vid;

                $('#div-add-schedule').dialog({ modal: true, height: 230, width: 350, resizable: false,
                    buttons: {
                        <?php echo dic("Settings.Add")?>: function () {
                            var areaID = document.getElementById("cbArea_" + vid).value
                            var vID = document.getElementById("cbVehicle_" + vid).value
                            var inZ = ""
                            var outZ = ""
                            if (document.getElementById('InArea').checked == true) { inZ = "1" } else { inZ = "0" }
                            if (document.getElementById('OutArea').checked == true) { outZ = "1" } else { outZ = "0" }
                            
                            if (inZ == "0" && outZ == "0") {
                                mymsg('<?php echo dic("Settings.MustSel")?>');
                                return
                            } else {
                                $.ajax({
                                    url: "UserSettings/SaveAlarms.php?vID=" + vID + "&areaID=" + areaID + "&inz=" + inZ + "&outz=" + outZ + "&tip=2&speed=0&uid=" + uid,
                                    context: document.body,
                                    success: function (data) {
                                        reload = "1";
                                        mymsg('<?php echo dic("Settings.SuccAdd")?>');
                                    }
                                });
                            }
                        },
                        <?php echo dic("Settings.Close")?>: function () {
                            if (reload == "1") {
                                ShowNotification(-1);
                            }
                            var c1 = document.getElementById("cbArea_" + vid);
                            var c2 = document.getElementById("cbVehicle_" + vid);
                            var c3 = document.getElementById("InArea");
                            var c4 = document.getElementById("OutArea");
                            c1.parentNode.removeChild(c1);
                            c2.parentNode.removeChild(c2);
                            c3.parentNode.removeChild(c3);
                            c4.parentNode.removeChild(c4);
                            $(this).dialog("destroy");
                        }
                    }
                });
            }
        });
    }
</script>
<?php
	closedb();
?>