<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php

    $vehID = getQUERY("vehID");
    
    $dt = DateTimeFormat(getQUERY("dt"), 'Y-m-d H:i:s');

    $driver = nnull(getQUERY("driver"), "");
    $km = getQUERY("km");
	$loc = getQUERY("loc");
    $liters = nnull(getQUERY("liters"), 0);
    $litersLast = nnull(getQUERY("litersLast"), 0);
    $price = nnull(getQUERY("price"), 0);
    $pay = getQUERY("pay");
	
	opendb();
	
	$checkCnt = dlookup("select count(*) from fuel where vehicleid=".$vehID." and datetime = '".$dt."' and driverid=".$driver."
	and km = ".$km." and price = ".$price." and liters = ".$liters." and literslast = ".$litersLast." and pay = '".$pay."' and location = '".$loc."'");
	
	if($checkCnt == 0) { 
		if ($driver == "")
		    RunSQL("INSERT INTO fuel (vehicleid, datetime, km, price, liters, literslast, pay, location) 
		    VALUES (" . $vehID . ", '" . DateTimeFormat($dt, "Y-m-d H:i:s") . "', " . $km . ", " . $price . ", " . $liters . ", 
		    " . $litersLast . ", '" . $pay . "','" . $loc . "')");
		else
			RunSQL("INSERT INTO fuel (vehicleid, datetime, driverid, km, price, liters, literslast, pay, location) 
		    VALUES (" . $vehID . ", '" . DateTimeFormat($dt, "Y-m-d H:i:s") . "', " . $driver . ", " . $km . ", " . $price . ", " . $liters . ", 
		    " . $litersLast . ", '" . $pay . "', '" . $loc . "')");
			
		echo 1;	
	} else {
		echo 0;
	}
		
    closedb();
   
    exit();
    
?>