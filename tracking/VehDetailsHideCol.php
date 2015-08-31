<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	$column = getQUERY("column");
	$userid = getQUERY("userid");
	
	opendb();
	
	if (dlookup("SELECT count(*) FROM vehicledetailscolumns where userid = " . $userid) == 0) {
		$ClientType = dlookup("select ClientTypeID from clients where id = ".session("client_id"));

		if ($ClientType == 2) {
			$r = runSQL("insert into vehicledetailscolumns (userid, clientid) values(".$userid.", ".Session("client_id") .")");
		} else {
			$r = runSQL("insert into vehicledetailscolumns (userid, clientid, ddriver, dtime, dodometer, dspeed, dlocation, dpoi, dzone, dntours, dprice, dtaximeter, dpassengers) 
			values(".$userid.", ".Session("client_id").", '1', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0')");
		}
	}
	
	$column = strtolower(str_replace("col", "d", $column));
	$r1 = runSQL("update vehicledetailscolumns set " . $column . " = '0' where userid = " . $userid);
	
	closedb();

?>