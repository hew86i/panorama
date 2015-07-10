<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css"> 
 .menuTable { display:none; width:200px; } 
</style> 

<script type="text/javascript">
function VratiSeNazad() {
<?php $url = htmlspecialchars($_SERVER['HTTP_REFERER']); "<a href='$url'><--</a>"; ?>
}
</script>

<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
	
</style>
</head>
<body>
	
	
	

	
<?php
	opendb();
	$UserID = str_replace("'", "''", NNull($_GET['uid'], ''));
    $role = str_replace("'", "''", NNull($_GET['roleid'], '3'));
    
    if ($role == "1" || $role == "2"){
        $dsp = query("select id, registration , code from vehicles where clientid = " . Session("clientid") . "  order by code asc ");
    }

    if($role == "3"){
    	$dsp = query("select * from uservehicles left outer join vehicles on vehicles.id = uservehicles.vehicleid where uservehicles.userid = " . $UserID . "   order by vehicleid ");
    }

    $dsk = query("select * from users where id = " . $UserID);
    $kilometri = "km/h";

    $ki = "1";
	
    if(pg_num_rows($dsk) > 0)
	{
		$ki = NNull(pg_result($dsk,"metric"), "1");
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
<div class="textTitle" style="padding:2px 2px 2px 2px; margin:2px 2px 2px 2px;"><?php echo strtoupper(dic("Settings.UserSett"))?></div>
<div class="text2" align = "center"><FONT SIZE = "+1"><?php $url = htmlspecialchars($_SERVER['HTTP_REFERER']); echo "<a href='$url' ><--</a>"; ?>&nbsp;<?php echo dic ("Settings.GoBack")?></FONT></div>

<br><br><br>
<div class="textTitle" style="padding:2px 2px 2px 2px; margin:2px 2px 2px 2px;">1.<?php echo dic("Settings.SpeedLimit")?></div><br><br>
<div style="width:350px; id="aha" style="padding:2px 2px 2px 2px; margin:2px 2px 2px 2px;">
<?php
    if(pg_num_rows($dsp) > 0)
	{
        while($row = pg_fetch_array($dsp))
		{ 
?>
    <div class="text5 corner5" style="font-size:14px; width:97%; height:30px; padding:2px 2px 2px 2px; margin:2px 2px 2px 2px; border:1px solid #ccc;  background-color:#eee;" id="vehicle_<?php echo $row["id"]?>">
        &nbsp;&nbsp;&nbsp;<strong style="top:5px; position:relative"><?php echo $row["registration"]?>(<?php echo $row["code"]?>)</strong>
        &nbsp;&nbsp;<button style="float:right; width:29px " id="veBtnDel_<?php echo $row["id"]?>" onclick="VehicleBtnDelSpeed(<?php echo $row["id"]?>)">&nbsp;</button>
        &nbsp;&nbsp;<button style="float:right; width:29px" id="veBtnAdd_<?php echo $row["id"]?>" onclick="VehicleBtnAddSpeed(<?php echo $row["id"]?>)">&nbsp;</button></p>
    </div>
    <script>
        $('#veBtnDel_<?php echo $row["id"]?>').button({ icons: { primary: "ui-icon-trash"} });
        $('#veBtnAdd_<?php echo $row["id"]?>').button({ icons: { primary: "ui-icon-plus"} });
    </script>
<?php
    $dsSpeed = query("select * from AlarmSpeedExcess where id = " . $row["id"] . " and uid = " . $UserID); 
    if(pg_num_rows($dsSpeed) > 0)
	{
        while($row1 = pg_fetch_array($dsSpeed))
		{
?>

 <div  class="text5 corner5" style="font-size:12; width:97%; padding:2px 2px 2px 2px; margin:2px 2px 2px 2px; height:30px;" id="sp_id">
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
</div>
<div id="div-del-vehicle" style="display:none" title="<?php echo dic("Settings.Delete")?>">
    <?php echo dic("Settings.DelAllAlarms")?>
</div>
<div id="div-del-speedLimit" style="display:none" title="<?php echo dic("Settings.Delete")?>">
    <?php echo dic("Settings.DelSpeedLimit")?>
</div>
<div id="div-add-schedule" style="display:none" title="<?php echo dic("Settings.AddSchedule")?>">
   
</div>

<br><br><br><br>
<div style="border-top:1px dotted #95B1d7"></div>
<div class="textTitle" style="padding:2px 2px 2px 2px; margin:2px 2px 2px 2px;" >3.<?php echo dic("Main.ReportsTitle")?></div><br><br><br><br>




<!-- TUKA TREBA DA IMA KOD ZA IZVESTAI -->









<!--

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
-->
</body>
</html>	
<?php
	closedb();
?>