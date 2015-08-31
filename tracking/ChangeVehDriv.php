<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
    
    $idVeh  = str_replace("'", "''", NNull($_GET['idVeh'], ''));
	$idDriv  = str_replace("'", "''", NNull($_GET['idDriv'], ''));
	$lang  = str_replace("'", "''", NNull($_GET['l'], ''));
    
    $cLang = $lang;
    
    opendb();
    $dsPre = query("select * from drivervehicle where driverid=" . $idDriv . " and enddate is null");
	
    if(pg_num_rows($dsPre) > 0) {
        $dsPre1 = query("select * from drivervehicle where vehicleid=" . $idVeh . " and driverid=" . $idDriv . " and enddate is null");
        //echo "select * from vehicledriver where vehicleid=" . $idVeh . " and driverid=" . $idDriv . " and enddate is null";
    	//exit;
        if(pg_num_rows($dsPre1) == 0) {
            print dic("Tracking.BusyDriver");
        } else {
            print "Ok";
        }
    } else {
        RunSQL("update drivervehicle set enddate=now() where id in (select id from drivervehicle where vehicleid=" . $idVeh . " and enddate is null)");
		//echo "update vehicledriver set enddate=now() where id in (select id from vehicledriver where vehicleid=" . $idVeh . " and enddate is null)";
		//exit;
		if($idDriv != "0")
        	RunSQL("insert into drivervehicle (VehicleID, DriverID, strfrom) values ('" . $idVeh . "', '" . $idDriv . "', 'livetracking')");
    	print "Ok";
    }
	closedb();
?>