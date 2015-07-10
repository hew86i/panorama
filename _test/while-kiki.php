<?php



$alarmRowInfo = array();
	$lastuniqid = '';
	$lastalarm = array();
	$vehReg = "";
	$cnt = 0;
	$isUniq = false;

	while($row3 = pg_fetch_array($all_alerts)){
		if ($row3["vid"] <> "") {  //site alerti
			if ($row3["uniqid"] == "" || ($row3["uniqid"] <> $lastuniqid && $lastuniqid <> "")) {
				if ($vehReg == "") $vehReg = $row3["registration"];

				if ($row3["uniqid"] == "") $lastalarm = $row3;

				echo $lastalarm['name'] . " " . $vehReg . "<br>";

				array_push($alarmRowInfo,
					array('type' => 1,
							'alarmcode' => $lastalarm["name"],
							'emails' => $lastalarm["emails"],
							'soundid' => $lastalarm['soundid'],
							'available' => $lastalarm['available']

				));


				if ($row3["uniqid"] <> "") {
					$poz=$cnt;
					$vehReg = $row3["registration"] . "*; ";
				}
				else {
					$vehReg = "";
				}
			} else {
				if ($row3["uniqid"] <> "")
					$vehReg .= $row3["registration"] . "; ";

			}
			$lastuniqid = $row3["uniqid"];
			$lastalarm = $row3;
		$cnt++;
		}
		// echo "counter : $cnt <br>";

	}
	if ($lastuniqid <> "") {
		echo $lastalarm['name'] . " " . $vehReg . "-- <br>";
		array_push($alarmRowInfo,
					array('type' => 1,
							'alarmcode' => $lastalarm["name"],
							'emails' => $lastalarm["emails"],
							'soundid' => $lastalarm['soundid'],
							'available' => $lastalarm['available']

				));

	}
	// pp($alarmRowInfo);
	exit;



 ?>

