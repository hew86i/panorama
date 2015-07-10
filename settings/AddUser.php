<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$ime = str_replace("'", "''", NNull($_GET['ime'], ''));
	$prezime = str_replace("'", "''", NNull($_GET['prezime'], ''));
	$email = str_replace("'", "''", NNull($_GET['email'], ''));
	$telefon = str_replace("'", "''", NNull($_GET['telefon'], ''));
	$username = str_replace("'", "''", NNull($_GET['username'], ''));
	$password = str_replace("'", "''", NNull($_GET['password1'], ''));
	
	if($telefon=="")
	{
		$telefon =="";
	}
	$uid = Session("user_id");
	$cid = Session("client_id");
    opendb();
	
	$userCheck=dlookup("SELECT count(*) FROM users WHERE username = '" . $username. "'");
	
	$city = dlookup("SELECT cityid FROM clients WHERE id = '" . $cid. "'");
	$dsAll = query("select longitude, latitude from cities where id=" . $city );
	$latC = pg_fetch_result($dsAll, 0, "latitude");
	$longC = pg_fetch_result($dsAll, 0, "longitude");
	$url = "http://ws.geonames.org/timezone?lat=" . $latC . "&lng=" . $longC . "&username=geonetgps&style=full";
	$xml = simplexml_load_file($url);
	$tzoneUser = $xml->timezone->dstOffset;
	$url = "http://ws.geonames.org/timezone?lat=41.995900&lng=21.431500&username=geonetgps&style=full";
	$xml = simplexml_load_file($url);
	$tzoneLocal = $xml->timezone->dstOffset;
	$tzone = $tzoneUser - $tzoneLocal;
	
	if($userCheck > 0)
	{
		echo 1;
	}
	else{
		$posledno = dlookup("select Max(id)+1 from users");	
  		$ret = query("insert into users(id,fullname,username,password,clientid,roleid,active,email,timezone,datetimeformat,defaultmap,engineon,engineoff,engineoffpassengeron,satelliteoff,taximeteron,taximeteroffpassengeron,passiveon,activeoff,deflanguage,speed,location,poi,zone,passengers,taximeter,fuel,trace,timedate,idleover,metric,currency,liquidunit,phone,cityid,tzone) values('" . $posledno . "','" . $ime . " ". $prezime ."','" . $username . "','" . $password . "'," . Session("client_id") . ",3,B'1','" . $email . "',1,'d-m-Y h:i:s','YAHOOM',4,2,9,5,3,1,8,6,'mk','1','1','1','1','0','0','0','5','1','4','km','MKD','litar','".$telefon."','".$city."','".$tzone."'); ");
	}
	closedb();
?>
