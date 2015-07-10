<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	$dat = getQUERY("dt");
	$reg = getQUERY("reg");
	$type = getQUERY("type");
	$note = getQUERY("note");
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
	$cnt = dlookup("select count(*) from alarmshistory where datetime='" . $dat . "' and vehicleid=" . $vehID . " and name='" . $type . "'");
	if($cnt == 0)
	{
		print "NotOk";
		//$cnt = dlookup("select count(*) from historylog where datetime='" . $dat . "' and vehicleid=" . $vehID);
		//if($cnt == 1)
			//RunSQL("insert into alarmshistory (datetime, vehicleid, name, read) values ('" . $dat . "', " . $vehID . ", '" . $type . "', '0')");
	} else {
		$readuser = dlookup("select readuser from alarmshistory where datetime='" . $dat . "' and vehicleid=" . $vehID . " and name='" . $type . "'");
		$ru = explode(",", $readuser);
		$bool = TRUE;
		for($i=0;$i<sizeof($ru);$i++)
		{
		    if($ru[$i] == $userid)
		    	$bool = FALSE;
		}
		if($bool)
		{
			$readuser .= $userid . ",";
		}
		$runsql= query("update alarmshistory set read='1', readuser='" . $readuser . "', note='" . $note . "' where datetime='" . $dat . "' and vehicleid=" . $vehID . " and name='" . $type . "'");
		print "Ok";
	}
	closedb();
?>