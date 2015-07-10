<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php
 
    $vehId = getQUERY("vehId");
    $dt = DateTimeFormat(nnull(getQUERY("dt"), "01-01-1900"), "Y-m-d". " 23:59:59");
    $dt1 = DateTimeFormat(nnull(getQUERY("dt"), "01-01-1900"), "Y-m-d H:i:s");
	     
	$LastDay = DatetimeFormat(addDay(-1), 'd-m-Y');
    $proKm = 0;
    
	opendb();
	echo number_format(dlookup("select calculatecurrkm(".$vehId.", '".$dt1."')"));
	closedb();
	exit;
	
	$testCurrkm = dlookup("select count(*) from currkm where vehicleid=" . $vehId);
	$lastDateKm = "";
	if ($testCurrkm > 0) {
		$lastDateKm = dlookup("select datetime from currkm where vehicleid=" . $vehId);
	}
	
    $pastKm = 0;
    $Km = 0;
    
    If (DateTimeFormat($dt, "Y-m-d". " 00:00:00") == "1900-01-01 00:00:00") {
        If ($lastDateKm <> "") {
            $pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId . " and Datetime >= '" . $lastDateKm . "' and Datetime <= '" . DateTimeFormat($LastDay, "Y-m-d" . " 23:59:59") . "'"), 0);
            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehId), 0);
            $proKm = $pastKm + $Km;
        } Else {
            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId), 0);
        }
    } Else {
        If ($lastDateKm <> "") {
        	if ($lastDateKm <= $dt) {
        		$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId . " and Datetime >= '" . $lastDateKm . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
	            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehId), 0);
	            $proKm = $pastKm + $Km;
        	} else {
        		$proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
        	}
            /*$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d H:i:s") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehId), 0);
            $proKm = $pastKm + $Km;*/
        } Else {
            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
        }
    }
    

	
	$metric = dlookup("select metric from users where id=" . session("user_id"));
	if ($metric == 'mi') $metricvalue = 0.621371;
	else $metricvalue = 1;
    closedb();

    echo number_format(round($proKm * $metricvalue, 0));
    exit();
    

?>