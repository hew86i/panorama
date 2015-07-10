<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php   

    $datetime = DateTimeFormat(getQUERY("dt"), 'Y-m-d H:i:s');
	$driver = nnull(getQUERY("driver"), "0");
    $veh = getQUERY("veh");
    $km = getQUERY("km");
	$loc = getQUERY("loc");
    $costtypeid = getQUERY("costtypeid");
    $price = getQUERY("price");
	$pay = getQUERY("pay");
	 
    If (is_numeric($km) == false) {
        $km = "0";
    }
    
    If (is_numeric($price) == false) {
        $price = "0";
    }
    
	opendb();
	$checkCnt = dlookup("select count(*) from newcosts where costtypeid=" . $costtypeid . " and clientid=" . Session("client_id") . " and datetime='" . $datetime . "' 
	and vehicleid=" . $veh . "	and userid=" . Session("user_id") . " and price=" . intval($price) . " and km=" . intval($km) . " and pay='" . $pay . "' 
	and driverid=" . $driver . " and location='" . $loc . "'");
	
	if ($checkCnt == 0) {
		RunSQL("INSERT INTO newcosts (costtypeid, clientid, datetime, vehicleid, userid, price, km, pay, driverid, location) 
	    VALUES (" . $costtypeid . ", " . Session("client_id") . ", '" . $datetime . "', " . $veh . ", " . Session("user_id") . ",
	    " . intval($price) . ", " . intval($km) . ", '" . $pay . "', " . $driver . ", '" . $loc . "')");
		
		echo 1;	
	} else {
		echo 0;	
	}
    closedb();
	
?>