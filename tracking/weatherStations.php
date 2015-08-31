<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	set_time_limit(0);
	opendb();
	
	$city = nnull(utf8_urldecode(getQUERY('city')), "");
	$country = getQUERY("country");
	$elevation = nnull(utf8_urldecode(getQUERY('elevation')), "");
	$fullname = nnull(utf8_urldecode(getQUERY('fullname')), "");
	$lon = getQUERY("lon");
	$lat = getQUERY("lat");
	
	$otime = getQUERY("otime");
	$temp = getQUERY("temp");
	$feelslike = getQUERY("feelslike");
	$wind = getQUERY("wind");
	$visibility = getQUERY("visibility");
	$weather = nnull(utf8_urldecode(getQUERY("weather")), "");
	$humidity = getQUERY("humidity");
	$icon = nnull(utf8_urldecode(getQUERY("icon")), "");
	$iconurl = nnull(utf8_urldecode(getQUERY("iconurl")), "");
	
	$cntW = dlookup("select count(*) from weatherstations where city='" . $city . "'");
	if($cntW > 0) {
		$sqlAddW = "UPDATE weatherstations set observationtime='" . $otime . "', temerature=" . $temp;
		$sqlAddW .= ", feelslike=" . $feelslike . ", weather='" . $weather . "', humidity='" . $humidity;
		$sqlAddW .= "', visibility=" . $visibility . ", wind=" . $wind . ", icon='" . $icon . "', iconurl='" . $iconurl . "'";
	    $sqlAddW .= " where city='" . $city . "'";
		RunSQL($sqlAddW);
		echo "update";
	} else {
	    $sqlAddW = "INSERT INTO weatherstations (city, country, elevation, fullname, latitude, longitude, observationtime, temerature, feelslike, weather, humidity, visibility, wind, icon, iconurl) VALUES ";
	    $sqlAddW .= "('" . $city . "', '" . $country . "', '" . $elevation . "', '" . $fullname . "', " . $lat . ", " . $lon . ", '" . $otime . "', " . $temp . ", " . $feelslike . ", '" . $weather . "', '" . $humidity . "', " . $visibility . ", " . $wind . ", '" . $icon . "', '" . $iconurl . "')";
	    RunSQL($sqlAddW);
	    echo "insert";
	}
	closedb();
	exit;
?>
