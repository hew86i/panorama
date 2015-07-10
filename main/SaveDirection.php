<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
    set_time_limit(0);
	opendb();
	
	$directionname = nnull(utf8_urldecode(getQUERY('directionname')), "");
	$startgoogleaddress = nnull(utf8_urldecode(getQUERY('startgoogleaddress')), "");
	$startgeocodeaddress = nnull(utf8_urldecode(getQUERY('startgeocodeaddress')), "");
	$startlongitude = getQUERY("startlongitude");
	$startlatitude = getQUERY("startlatitude");
	$endgoogleaddress = nnull(utf8_urldecode(getQUERY('endgoogleaddress')), "");
	$endgeocodeaddress = nnull(utf8_urldecode(getQUERY('endgeocodeaddress')), "");
	$endlongitude = getQUERY("endlongitude");
	$endlatitude = getQUERY("endlatitude");
	$shortlineid = getQUERY('shortlineid');
	$fastlineid = getQUERY('fastlineid');
	
    $sqlAddDirection = "insert into directions (userid, clientid, directionname, startgoogleaddress, startgeocodeaddress, 
            startlongitude, startlatitude, endgoogleaddress, endgeocodeaddress, 
            endlongitude, endlatitude, shortlineid, fastlineid) values";
	$sqlAddDirection .= "(" . session("user_id") . ", " . session("client_id") . ", '" . $directionname . "'";
	$sqlAddDirection .= ",'" . $startgoogleaddress . "', '" . $startgeocodeaddress . "', " . $startlongitude;
	$sqlAddDirection .= "," . $startlatitude . ", '" . $endgoogleaddress . "', '" . $endgeocodeaddress . "'";
	$sqlAddDirection .= "," . $endlongitude . ", " . $endlatitude . ", " . $shortlineid . ", " . $fastlineid . ")";
	//echo $sqlAddDirection;
	$retID = RunSQL($sqlAddDirection);
	echo $retID;
    closedb();
    exit;
?>
