<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>
<?php
    $vehID = getQUERY("vehId");
	opendb();
	$ifDriver = dlookup("select count(*) from vehicledriver where vehicleid=" . $vehID);
	if ($ifDriver > 0) {
        $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID . ") order by fullname asc";
	} else {
		$drivers = "select fullname, id from drivers where clientid=" . session("client_id") . " order by fullname asc";
	}
    $dsDrivers = query($drivers);
	$driversStr = "";	
	while ($drDrivers = pg_fetch_array($dsDrivers)) {
		$driversStr .=  "<option value='" . $drDrivers["id"] . "'>" . $drDrivers["fullname"] . "</option>";  
    }           
    closedb();
    echo $driversStr;
    exit();
?>