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

    $dsk = query("select * from UserSettings where UserId = " . $UserID);
    $kilometri = "km/h";
    $ki = "1";
	
    if(odbc_num_rows($dsk) > 0)
	{
		$ki = NNull(odbc_result($dsk,"Kilometri"), "1");
        if($ki == "1")
            $kilometri = "km/h";
        else
            $kilometri = "MPH";
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
        &nbsp;&nbsp;<button style="float:right; width:29px " id="veBtnDel_<?php echo $row["VehicleID"]?>" onclick="VehicleBtnDelSpeed(<?php echo $row["VehicleID"]?>)">&nbsp;</button>
        &nbsp;&nbsp;<button style="float:right; width:29px" id="veBtnAdd_<?php echo $row["VehicleID"]?>" onclick="VehicleBtnAddSpeed(<?php echo $row["VehicleID"]?>)">&nbsp;</button></p>
    </div>
    <script>
        $('#veBtnDel_<?php echo $row["VehicleID"]?>').button({ icons: { primary: "ui-icon-trash"} });
        $('#veBtnAdd_<?php echo $row["VehicleID"]?>').button({ icons: { primary: "ui-icon-plus"} });
    </script>
<?php
    $dsSpeed = query("select * from AlarmSpeedExcess where VehicleID = " . $row["VehicleID"] . " and UserID = " . $UserID); 
    if(odbc_num_rows($dsSpeed) > 0)
	{
        while($row1 = odbc_fetch_array($dsSpeed))
		{
?>
    <div class="text5 corner5" style="font-size:12; width:97%; padding:2px 2px 2px 2px; margin:2px 2px 2px 2px; height:30px;" id="sp_id">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em><?php echo dic("Settings.SpeedLimitExcess")?></em> (<strong style="font-weight:bold; color:#800000;"><?php echo $row1["Speed"]?></strong>) <em><?php echo $kilometri?></em>
        &nbsp;&nbsp;<button id="spBtn_<?php echo $row1["ID"]?>" style="float:right; width:29px" value="<?php echo dic("Settings.Delete")?>" onclick="SpeedLimitBtnDel(<?php echo $row1["ID"]?>)">&nbsp;</button></p>
    </div>
    <script>
        $('#spBtn_<?php echo $row1["ID"]?>').button({ icons: { primary: "ui-icon-trash"} });
    </script>
<?php
		}
	}
}
}
?>

<div id="div-del-vehicle" style="display:none" title="<?php echo dic("Settings.Delete")?>">
    <?php echo dic("Settings.DelAllAlarms")?>
</div>
<div id="div-del-speedLimit" style="display:none" title="<?php echo dic("Settings.Delete")?>">
    <?php echo dic("Settings.DelSpeedLimit")?>
</div>
<div id="div-add-schedule" style="display:none" title="<?php echo dic("Settings.AddSchedule")?>">
   
</div>
<script>
    function VehicleBtnDelSpeed(VehicleID) {
        $('#div-del-vehicle').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
                <?php echo dic("Settings.Yes")?>: function () {
                    $.ajax({
                        url: "UserSettings/DelVehicleAlarms.php?vid=" + VehicleID + "&a=1",
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

    function SpeedLimitBtnDel(slID) {
        $('#div-del-speedLimit').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
                <?php echo dic("Settings.Yes")?>: function () {
                    $.ajax({
                        url: "UserSettings/DelVehicleAlarms.php?vid=" + slID + "&a=2",
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

    function VehicleBtnAddSpeed(vid) {
        var uid = $('#lbUsers').val();
        var reload = "0";
        $.ajax({
            url: "UserSettings/VehicleAlarmsSpeed.php?uid=" + uid,
            context: document.body,
            success: function (data) {
                $('#div-add-schedule').html(data)
                var Combo = document.getElementById("cbVehicleSpeed");
                Combo.value = vid;

                $('#div-add-schedule').dialog({ modal: true, height: 170, width: 350, resizable: false,
                    buttons: {
                        <?php echo dic("Settings.Add")?>: function () {
                            var vid = $('#cbVehicleSpeed').val()
                            var speed = $('#SpeedExceed').val()
                            if (speed == "") {
                                mymsg('<?php echo dic("Settings.AddSpeedLimit")?>');
                                $('#SpeedExceed').focus()
                                return
                            } else {
                                $.ajax({
                                    url: "UserSettings/SaveAlarms.php?vid=" + vid + "&speed=" + speed + "&tip=1&areaID=0&inz=0&outz=0&uid=" + uid,
                                    context: document.body,
                                    success: function (data) {
                                        reload = "1";
                                        document.getElementById('SpeedExceed').value = '';
                                        mymsg('<?php echo dic("Settings.SuccAdd")?>');
                                    }
                                });
                            }
                        },
                        <?php echo dic("Settings.Close")?>: function () {
                            if (reload == "1") {
                                ShowNotification(-1);
                            }
                            $(this).dialog("close");
                        }
                    }
                });
            }
        });
    }
</script>