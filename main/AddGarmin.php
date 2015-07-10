<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
    set_time_limit(0);
	opendb();
	
	$vehid = getQUERY("vehid");
	$lon = getQUERY('lon');
    $lat = getQUERY('lat');
	$_name = nnull(utf8_urldecode(getQUERY('name')), "");
	$_description = nnull(utf8_urldecode(getQUERY('description')), "");
	
    $garminid = dlookup("select coalesce((select garminid from stopstatus where toid=" . $vehid . " order by datetime desc limit 1), 0)");
	$garminid = $garminid + 1;
    $sqlAddPoi = "insert into stopstatus (fromid, toid, clientid, userid, datetime, text, garminid, latitude, longitude, location) values";
	$sqlAddPoi .= "(" . session("user_id") . ", " . $vehid . ", " . session("client_id") . ", " . session("user_id") . ", now(),";
	$sqlAddPoi .= "'" . $_name . "', " . $garminid . ", " . $lat . ", " . $lon . ", '" . $_description . "')";
	$ret = RunSQL($sqlAddPoi);
	echo $garminid;
    closedb();
?>
