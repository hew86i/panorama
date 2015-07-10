<?php include "../../include/functions.php" ?>
<?php include "../../include/db.php" ?>

<?php include "../../include/params.php" ?>
<?php include "../../include/dictionary2.php" ?>
<?php session_start()?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	opendb();
    $vid = str_replace("'", "''", NNull($_GET['vID'], ''));
	$speed = str_replace("'", "''", NNull($_GET['speed'], ''));
	$tip = str_replace("'", "''", NNull($_GET['tip'], ''));
	$areaID = str_replace("'", "''", NNull($_GET['areaID'], ''));
	$inz = str_replace("'", "''", NNull($_GET['inz'], ''));
	$outz = str_replace("'", "''", NNull($_GET['outz'], ''));
    $uid = str_replace("'", "''", NNull($_GET['uid'], ''));
    
	if($tip == "1")
	{
        RunSQL("insert into AlarmSpeedExcess (VehicleID, Speed, UserID) values (" . $vid . "," . $speed . "," . $uid . ")");
    }
    
    if($tip == "2")
	{
        if($inz == "1")
        {
            RunSQL("insert into AreasAlarmsDetail (areaID, vehicleID, type, UserID) values (" . $areaID . "," . $vid . ",2," . $uid . ")");
        }
        if($outz == "1")
        {
            RunSQL("insert into AreasAlarmsDetail (areaID, vehicleID, type, UserID) values (" . $areaID . "," . $vid . ",3," . $uid . ")");
        }
    }
    print "Ok";
	closedb();
?>