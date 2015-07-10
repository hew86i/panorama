<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
    set_time_limit(0);
	opendb();
	
	$vehid = getQUERY("vehid");
	$_name = nnull(utf8_urldecode(getQUERY('name')), "");
	
    $garminid = dlookup("select coalesce((select messageid from quickmessage where vehicleid=" . $vehid . " order by messageid desc limit 1), 0)");
	$garminid = $garminid + 1;
    $sqlAddPoi = "insert into quickmessage (vehicleid, messageid, body) values";
	$sqlAddPoi .= "(" . $vehid . ", " . $garminid . ", '" . $_name . "')";
	$ret = RunSQL($sqlAddPoi);
	echo $garminid;
    closedb();
?>
