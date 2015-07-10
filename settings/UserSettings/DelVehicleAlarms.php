<?php include "../../include/functions.php" ?>
<?php include "../../include/db.php" ?>

<?php include "../../include/params.php" ?>
<?php include "../../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	opendb();
    $vid = str_replace("'", "''", NNull($_GET['vid'], ''));
	$a = str_replace("'", "''", NNull($_GET['a'], ''));
    
	//delete All speed limit excess for vehicle
    if($a == "1")
        RunSQL("delete from AlarmSpeedExcess where id = " . $vid);

    //delete specific speed limit excess for vehicle
    if($a == "2")
        RunSQL("delete from AlarmSpeedExcess where id = " . $vid);

    //delete All GeoFence notification for vehicle
    if($a == "3")
        RunSQL("delete from AreasAlarmsDetail where id = " . $vid);

    //delete specific GeoFence notification for vehicle
    if($a == "4")
        RunSQL("delete from AreasAlarmsDetail where id = " . $vid);

    //delete All repost shedule for user 
    if($a == "5")
        RunSQL("delete from Scheduler where userID = " . $vid);

    //delete specific repost shedule for user
    if($a == "6")
        RunSQL("delete from Scheduler where ID = " . $vid);

    print $vid;
	closedb();
?>