
<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php

	// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);  // [josip] za error reports

	header("Content-type: text/html; charset=utf-8");
	opendb();


	$all_alerts = query("select a.*,at.name, at.description, v.registration, v.code, v.id vid from alarms a left join alarmtypes at on a.alarmtypeid=at.id left join vehicles v on a.vehicleid=v.id
					where a.clientid=357 and at.id <> 11
					order by cast(a.uniqid as integer) desc, alarmtypeid");
	$vehReg = array();
	$oldUniqID = 1;
	$setBreak = false;


	$allRows = pg_fetch_all($all_alerts);

	// print_r($allRows);
	foreach ($allRows as $key => $row3) {
		echo "------------ <br>";

		echo dic($row3["name"]);

		if ($key > 0) {
		echo "<br> red pred: " . $allRows[($key-1)]["uniqid"] . " <br> ";
	}
		echo "<br> ------------ <br>";
	}



// if ($oldUniqID == 1) {
		// 	$oldUniqID = (int)$row3["uniqid"];
		// }
		// if($oldUniqID != (int)$row3["uniqid"] ) {
		// 	$oldUniqID = (int)$row3["uniqid"];
		// 	$setBreak = true;
		// }

		// 	$tmpColor = '#2f5185';

		// 	if ($_SESSION['role_id'] == "2") {
		// 		$checkVeh = dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and active='1' and id=".$row3["vid"]);
		// 	}
		// 	else {
		// 		$checkVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where vehicleid=" . $row3["vid"] . " and userid=" . session("user_id") . ") and active='1'");
		// 	}
		// 	if ($checkVeh == 0) $fontVeh = "red";
		// 	else $fontVeh = "";
		// 		if ($checkVeh > 0) {
		// 			$registration .= '<span style="color:'.$fontVeh.'">'.$row3["registration"]. ' ('.$row3["code"].'); </span> ';
		// 		}

		// 	array_push($vehReg, array('id' => $row3["id"],
		// 								'registration' => $row3["registration"],
		// 								'code' => $row3["code"],
		// 								'vid' => $row3["vid"]
		// 						));


		// if ($row3["typeofgroup"] == 2) {
		// 	$registration = dlookup("select name from organisation where id=" . $row3["settings"]) . "<br>" . $registration;

		// 	if ($_SESSION['role_id'] == "2") {
		// 		$cntAllowVeh = dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and organisationid = " . $row3["settings"] . " and active='1'") ;
		// 	} else {
		// 		$cntAllowVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and organisationid = " . $row3["settings"] . " and active='1'");
		// 	}
		// }
		// if ($row3["typeofgroup"] == 3) {
		// 	$registration = dic_("Tracking.AllVehCompany") . "<br>" . $registration;

		// 	if ($_SESSION['role_id'] == "2") {
		// 		$cntAllowVeh = dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and active='1'") ;
		// 	} else {
		// 		$cntAllowVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1'");
		// 	}
		// }
		// if ($setBreak) {
		// 	break;
		// }
		// continue;
		// (($setBreak) ? break : continue);
		// 
		// 
?>