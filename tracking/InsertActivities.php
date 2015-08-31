<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
    $action = getQUERY("action");
	//$gsmnum = getQUERY("gsmnum");
	$vehid = getQUERY("vehid");
	$status = getQUERY("status");
	$radius = getQUERY("radius");
	$longitude = getQUERY("longitude");
	$latitude = getQUERY("latitude");
	
    opendb();
	$email = dlookup("select email from clients where id in (select clientid from vehicles where id=" . $vehid . ")");
	$sendmail = '';
	$email = explode(",", $email);
	
    if($action.'' == 'alarm')
	{
		RunSQL("insert into historyofmotoalarms (datetime, vehicleid) values (now(), '" . $vehid . "')");
		for($i=0; $i<sizeof($email); $i++)
		{
			$sendmail = '';
			$sendmail .= "insert into send_mail (datetime, frommail, tomail, subject, body, flag) values";
			$sendmail .= " (now(), 'sysinfo@gps.mk', '" . $email[$i] . "', 'Мото-аларм', getmailhtmlform(" . $vehid . ", cast(to_char(now(), 'YYYY-MM-DD HH24:MI:SS') as timestamp), 'Мото-аларм'), '0')";
			RunSQL($sendmail);
			//echo $email[$i] . "<br>";
		}
	}
	if($action.'' == 'block')
	{
    	RunSQL("insert into historyofblocks (datetime, vehicleid, blockstatus) values (now(), '" . $vehid . "', '1')");
    	for($i=0; $i<sizeof($email); $i++)
		{
			$sendmail = '';
			$sendmail .= "insert into send_mail (datetime, frommail, tomail, subject, body, flag) values";
			$sendmail .= " (now(), 'sysinfo@gps.mk', '" . $email[$i] . "', 'Блокада на мотор', getmailhtmlform(" . $vehid . ", cast(to_char(now(), 'YYYY-MM-DD HH24:MI:SS') as timestamp), 'Блокада на мотор'), '0')";
			RunSQL($sendmail);
			//echo $email[$i] . "<br>";
		}
	}
	if($action.'' == 'deblock')
	{
    	RunSQL("insert into historyofblocks (datetime, vehicleid, blockstatus) values (now(), '" . $vehid . "', '0')");
    	for($i=0; $i<sizeof($email); $i++)
		{
	    	$sendmail = '';
			$sendmail .= "insert into send_mail (datetime, frommail, tomail, subject, body, flag) values";
			$sendmail .= " (now(), 'sysinfo@gps.mk', '" . $email[$i] . "', 'Деблокада на мотор', getmailhtmlform(" . $vehid . ", cast(to_char(now(), 'YYYY-MM-DD HH24:MI:SS') as timestamp), 'Деблокада на мотор'), '0')";
			RunSQL($sendmail);
			//echo $email[$i] . "<br>";
		}
	}
	if($action.'' == 'geolock')
	{
    	RunSQL("insert into historyofgeolock (datetime, vehicleid, geolockstatus, radius, longitude, latitude) values (now(), '" . $vehid . "', '" . $status . "', " . $radius . ", " . $longitude . ", " . $latitude . ")");
    	/*for($i=0; $i<sizeof($email); $i++)
		{
	    	$sendmail = '';
			$sendmail .= "insert into send_mail (datetime, frommail, tomail, subject, body, flag) values";
			$sendmail .= " (now(), 'sysinfo@gps.mk', '" . $email[$i] . "', 'Деблокада на мотор', getmailhtmlform(" . $vehid . ", cast(to_char(now(), 'YYYY-MM-DD HH24:MI:SS') as timestamp), ''), '0')";
			RunSQL($sendmail);
			//echo $email[$i] . "<br>";
		}*/
	}
	closedb();
?>