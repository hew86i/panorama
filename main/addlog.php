<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	set_time_limit(0);
	opendb();
	
	$ipa = getIP();
	echo $ipa . "<br>";
	
	include('../include/ip2locationlite.class.php');
	
	$ipLite = new ip2location_lite;
	$ipLite->setKey('6fd5f186e30b05cfb5da94f5d9f073a66242543b9521cd5969c7fd903fa1b878');
	
	//Language variable
	$locations = $ipLite->getCountry("217.16.79.81");
	echo $locations;
	closedb();
?>