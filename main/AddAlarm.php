<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	$dat = getQUERY("dt");
	$reg = getQUERY("reg");
	$type = getQUERY("type");
	$userid = session("user_id");
	
	//list($d, $m, $y) = explode('-', $dat);
	//$a = explode(" ", $y);
	//$d1 = explode(":", $a[1]);
	//$d2 = explode(".", $d1[2]);
	//echo $dat . "<br />";
	//echo $d . "_" . $m . "_" . $a[0] . "_" . $d1[0] . "_" . $d1[1] . "_" . $d2[0] . "_" . $d2[1];
	//exit;
	opendb();
	$vehID = dlookup("select id from vehicles where registration='" . $reg . "'");
	$ifsetalarm = dlookup("select count(*) from alarms a left join alarmtypes at on at.id=a.alarmtypeid where a.vehicleid=" . $vehID . " and at.name='" . $type . "'");
	
	if($ifsetalarm > 0 || $type == 'mandown' || $type == 'sosalarm' || $type == 'tow' || $type == 'weakAccumulator' || $type == 'geolock' || $type == 'changelocation' || $type == 'geolockasset')
	{
		$cnt = dlookup("select count(*) from alarmshistory where datetime='" . $dat . "' and vehicleid=" . $vehID . " and name='" . $type . "'");
		if($cnt == 0)
		{
			$cnt = dlookup("select count(*) from historylog where datetime='" . $dat . "' and vehicleid=" . $vehID);
			if($cnt == 1)
				RunSQL("insert into alarmshistory (datetime, vehicleid, name, read) values ('" . $dat . "', " . $vehID . ", '" . $type . "', '0')");
			print "Ok";
		} else
			print "Ima";
	} else
		print "NotOk";
	
	closedb();
?>
