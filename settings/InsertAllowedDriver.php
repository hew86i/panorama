<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>


<?php
    
    $selected = getQUERY("selected");
    $vehID = getQUERY("vehID");
    
    $driArray = explode("*", $selected);
    
	opendb();

	for ($i=0; $i < count($driArray) - 1; $i++) {
        RunSQL("INSERT INTO vehicledriver (vehicleid, driverid) VALUES (" . $vehID . ", " . $driArray[$i] . ")");
    }
    
	closedb();
	
?>