<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php

    $gsm = getQUERY("gsm");
    opendb();

	$vehicleid = dlookup("select id from vehicles where gsmnumber='" . $gsm . "'");
	$r = runSQL("insert into cameravehicle (vehicleid, datetime) values(" . $vehicleid . ", '" . now() . "')");
	
	echo dlookup("select count(*) from cameravehicle where vehicleid=".$vehicleid." and datetime between '".DateTimeFormat(now(), '"Y-m-d 00:00:00"')."'  and '".DateTimeFormat(now(), '"Y-m-d 23:59:59"')."'");
    
    closedb();
?>
