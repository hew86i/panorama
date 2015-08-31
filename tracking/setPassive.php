<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    set_time_limit(0);
	opendb();

	$q = str_replace("'", "''", NNull($_GET['q'], ''));
	$nov = str_replace("'", "''", NNull($_GET['nov'], ''));
	
	runsql("update currentposition set passive='" . $q . "' where vehicleid=" . $nov);

	/*if(is_numeric($nov) == "1")
	{
		$vid = nnull(dlookup("select id from vehicles where code=" . $nov . " and clientid=" . session("client_id")), 0);
		if(is_numeric($vid))
		{
			if($q == "0")
				runsql("update geonet.dbo.currentposition set passive=0 where alarmid=" . $vid);
			else
				runsql("update geonet.dbo.currentposition set passive=1 where alarmid=" . $vid);
		}
	}*/
	closedb();
?>
