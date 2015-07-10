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

<div id="div-reports-notification">
    <div class="text5 corner5" id="reports" style="font-size:14; width:97%; height:30px; padding:2px 2px 2px 2px; margin:2px 2px 2px 2px; border:1px solid #ccc; background-color:#eee;">
        &nbsp;&nbsp;<strong style="top:5px; position:relative"><?php echo dic("Settings.Reports")?></strong>
        &nbsp;&nbsp;<button style="float:right; width:29px;" value="Delete" id="BtnDelAll" onclick="BtnDellAll()">&nbsp;</button>
        &nbsp;&nbsp;<button style="float:right; width:29px;" value="Add" id="addRep" onclick="AddReports()">&nbsp;</button></p>
    </div>
    <script>
        $('#addRep').button({ icons: { primary: "ui-icon-plus"} });
        $('#BtnDelAll').button({ icons: { primary: "ui-icon-trash"} });
    </script>
<?php
    $dsRep = query("select * from Scheduler where userID = " . $UserID);
    if(odbc_num_rows($dsRep) > 0)
	{
        while($row = odbc_fetch_array($dsRep))
		{
?>
    <div class="text5 corner5" style="font-size:12; width:97%; padding:2px 2px 2px 2px; margin:2px 2px 2px 2px; height:30px;" id="rep_<?php echo $row["id"]?>">
        &nbsp;&nbsp;&nbsp;<?php echo $row["report"]?> for (<?php echo $row["vehicle"]?>) period (<?php echo $row["period"]?>, <?php echo $row["day"]?> at <?php echo $row["time"]?>)
        &nbsp;&nbsp;<button style="float:right; width:29px;" id="ReBtnDel_<?php echo $row["id"]?>" value="Delete" onclick="BtnDeleteSchedule(<?php echo $row["id"]?>)">&nbsp;</button></p>
    </div>
    <script>
        $('#ReBtnDel_<?php echo $row["id"]?>').button({ icons: { primary: "ui-icon-trash"} });
    </script>
<?php
		}
    }
?>
</div>
<div id="div-del-shedule" style="display:none" title="<?php echo dic("Settings.Delete")?>">
    <?php echo dic("Settings.DeleteSch")?>
</div>
<div id="div-del-all" style="display:none" title="<?php echo dic("Settings.Delete")?>">
    <?php echo dic("Settings.DeleteAllSch")?>
</div>
<div id="div-add-schedule" style="display:none" title="<?php echo dic("Settings.AddSchedule")?>">
   
</div>
<script>

    function BtnDellAll(){													
        var uid = $('#lbUsers').val()
        $('#div-del-all').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
                <?php echo dic("Settings.Yes")?>: function () {
                    $.ajax({
                        url: "UserSettings/DelVehicleAlarms.php?vid=" + uid + "&a=5",
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

    function BtnDeleteSchedule(sID) {
        $('#div-del-shedule').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
                <?php echo dic("Settings.Yes")?>: function () {
                    $.ajax({
                        url: "UserSettings/DelVehicleAlarms.php?vid=" + sID + "&a=6",
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

    function AddReports() {
        var reload = "0";
        $.ajax({
            url: "UserSettings/Scheduler.php",
            context: document.body,
            success: function (data) {
                $('#div-add-schedule').html(data)
                $('#div-add-schedule').dialog({ modal: true, height: 450, width: 350, resizable: false,
                    buttons: {
                        <?php echo dic("Settings.Add")?>: function () {
                            var rep = ''
                            var report = $('#cbReports').val()
                            if (report == "Dashboard") { rep = "Dashboard" }
                            if (report == "FleetReport") { rep = "Fleet report" }
                            if (report == "Overview") { rep = "Overview" }
                            if (report == "ShortReport") { rep = "Short report" }
                            if (report == "DetailReport") { rep = "Detail report" }
                            if (report == "VisitedPointsOfInterest") { rep = "Visited points of interest" }
                            if (report == "Reconstruction") { rep = "Reconstruction" }
                            if (report == "TaxiReport") { rep = "Taxi report" }
                            if (report == "DistanceTravelled") { rep = "Distance travelled" }
                            if (report == "Activity") { rep = "Activity" }
                            if (report == "MaxSpeed") { rep = "Max speed" }
                            if (report == "SpeedLimitExcess") { rep = "Speed limit excess" }
                            var veh = $('#cbVehicles').val()
                            var per = $('#cbPeriod').val()
                            var day = $('#cbDay').val()
                            var date = $('#cbDate1').val()
                            var sati = $('#cbTimeHours').val()
                            var minuti = $('#cbTimeMinutes').val()
                            var uid = $('#lbUsers').val()
                            _list = document.getElementById('div-email')
                            var email = ''
                            var emailID = ''
                            if (_list.childNodes.length > 0) {
                                for (var k = 0; k < _list.childNodes.length; k++) {
                                    if (_list.childNodes[k].checked == true) {
                                        emailID = _list.childNodes[k].alt
                                        email += document.getElementById('email_' + emailID).value + ';'
                                    }
                                }
                            }
                            //alert("UserSettings/schedulerSave.php?rep=" + rep + "&veh=" + veh + "&per=" + per + "&day=" + day + "&date1=" + date + "&sati=" + sati + "&minuti=" + minuti + "&email=" + email + "&uid=" + uid);

                            $.ajax({
                                url: "UserSettings/schedulerSave.php?rep=" + rep + "&veh=" + veh + "&per=" + per + "&day=" + day + "&date1=" + date + "&sati=" + sati + "&minuti=" + minuti + "&email=" + email + "&uid=" + uid,
                                context: document.body,
                                success: function (data) {
                                    reload = "1";
                                    mymsg('<?php echo dic("Settings.SuccAdd")?>');
                                }
                            });
                            //$(this).dialog("close");
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