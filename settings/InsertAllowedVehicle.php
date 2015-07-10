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
    $driID = getQUERY("driID");
    
    $vehArray = explode("*", $selected);
   
    opendb();
	
	for ($i = 0; $i < count($vehArray) - 1; $i ++) {
		RunSQL("INSERT INTO vehicledriver (vehicleid, driverid) VALUES (" . $vehArray[$i] . ", " . $driID . ")");		
	}
       
    closedb();
	
?>