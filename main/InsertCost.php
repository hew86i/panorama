<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php   

    $datetime = DateTimeFormat(getQUERY("dt"), 'Y-m-d H:i:s');
	$driver = nnull(getQUERY("driver"), "");
    $veh = getQUERY("veh");
    $km = getQUERY("km");
	$loc = getQUERY("loc");
    $desc = getQUERY("desc");
    $comp = getQUERY("comp");
    $price = getQUERY("price");
	$pay = getQUERY("pay");
	 
    If (is_numeric($km) == false) {
        $km = "0";
    }
    
    If (is_numeric($price) == false) {
        $price = "0";
    }
    
	opendb();
	$checkCnt = dlookup("select count(*) from costs where clientid=" . Session("client_id") . " and datetime='" . $datetime . "' and vehicleid=" . $veh . " 
	and userid=" . Session("user_id") . " and description='" . $desc . "' and components='" . $comp . "' and price=" . intval($price) . " 
	and km=" . intval($km) . " and pay='" . $pay . "' and driverid=" . $driver . " and location='" . $loc . "'");
	
	if ($checkCnt == 0) {
		if ($driver == "")
		    RunSQL("INSERT INTO costs (clientid, datetime, vehicleid, userid, description, components, price, km, pay, location) 
		    VALUES (" . Session("client_id") . ", '" . $datetime . "', " . $veh . ", " . Session("user_id") . ", '" . $desc . "', 
		    '" . $comp . "', " . intval($price) . ", " . intval($km) . ", '" . $pay . "', '" . $loc . "')");
		else
			RunSQL("INSERT INTO costs (clientid, datetime, driverid, vehicleid, userid, description, components, price, km, pay, location) 
		    VALUES (" . Session("client_id") . ", '" . $datetime . "', " . $driver . ", " . $veh . ", " . Session("user_id") . ", '" . $desc . "', 
		    '" . $comp . "', " . intval($price) . ", " . intval($km) . ", '" . $pay . "','" . $loc . "')");
	    
		echo 1;	
	} else {
		echo 0;	
	}
		
    closedb();
	
?>