<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php 
       
    $datetime = getQUERY("dt");
	$driver = nnull(getQUERY("driver"), "");
	
    $veh = getQUERY("veh");
    $km = getQUERY("km");
    $type = getQUERY("type");
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
    
    If ($type == 0) {
        $type = "Associate";
    } Else {
        $type = "Regular";
    }
    
	opendb();
	$checkCnt = dlookup("select count(*) from service where clientid=" . Session("client_id") . " and datetime='" . DateTimeFormat($datetime, "Y-m-d H:i:s") . "' 
	and vehicleid=" . $veh . " and location='" . $loc . "' and userid=" . Session("user_id") . " and type='" . $type . "' and description='" . $desc . "' 
	and components='" . $comp . "' and price=" . intval($price) . " and km=" . intval($km) . " and pay='" . $pay . "' and driverid=" . $driver);
	
	if($checkCnt == 0) { 
		if ($driver == "")
		    RunSQL("INSERT INTO service (clientid, datetime, vehicleid, location, userid, type, description, components, price, km, pay) 
		    VALUES (" . Session("client_id") . ", '" . DateTimeFormat($datetime, "Y-m-d H:i:s") . "', " . $veh . ", '" . $loc . "', " . Session("user_id") . ", 
		    '" . $type . "', '" . $desc . "', '" . $comp . "', " . intval($price) . ", " . intval($km) . ", '" . $pay . "')");
		else
			 RunSQL("INSERT INTO service (clientid, datetime, driverid, vehicleid, location, userid, type, description, components, price, km, pay) 
		    VALUES (" . Session("client_id") . ", '" . DateTimeFormat($datetime, "Y-m-d H:i:s") . "', " . $driver . ", " . $veh . ", '" . $loc . "', " . Session("user_id") . ", 
		    '" . $type . "', '" . $desc . "', '" . $comp . "', " . intval($price) . ", " . intval($km) . ", '" . $pay . "')");
		
		echo 1;	
	} else {
		echo 0;	
	}	
    closedb();
?>
