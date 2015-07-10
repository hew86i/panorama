<?php

while($alertrow = pg_fetch_array($all_alerts,$rn))
{  //w3

if($alertrow["vid"] <> ""){

	if($lastrow	== '') $lastrow = $alertrow;

	if($lastrow["uniqid"] == "") {	// ako se raboti za obicen red

		$vehReg = $lastrow['registration'];
		echo $lastrow['name'] . " : $vehReg -- <br>";

		array_push($alarmRowInfo, array(
			'name' => $lastrow['name'],
			'uniqid' => $lastrow["uniqid"],
			'vreg'	=> $vehReg
		));

		$vehReg="";

	} else {	// redovi kade uniqid <> ""

		if ($lastrow["uniqid"] == $alertrow["uniqid"]){		// redovi so isti uniqid

			//startuvaj counter
			$vehReg .= $lastrow['registration'] . " * ";
			echo "[$rn] :  uniqid : " . $lastrow['uniqid'] . " <br>";
			// za posleden red
			if($RowsNumber == $rn+2){		// vazi samo za posledniot red
				$vehFlag = true;
				$vehReg .= $alertrow['registration'];
				$vehRegTemp = $vehReg;
				echo "[$rn] :  last uniqid : " . $alertrow['uniqid'] . " <br>";
				echo "registration : $vehReg <br>";
			}

		} else {	// ako uniqid na naredniot red ne e ist so prethodniot
			echo "[$rn] :  uniqid : " . $lastrow['uniqid'] . " <br>";
			echo "nov uniqid <br>";
			// resetiraj counter
			$vehReg .= $lastrow['registration'] . " * ";
			echo "registration : $vehReg <br>";
			$vehFlag = true;
			$vehRegTemp = $vehReg;
			$vehReg="";
		}
	}
	if($vehFlag) {
		array_push($alarmRowInfo, array(
			'name' => $lastrow['name'],
			'uniqid' => $lastrow["uniqid"],
			'vreg'	=> $vehRegTemp
		));
		$vehFlag = false;
	}

	$lastrow = $alertrow;

	}
$rn++;

}

pp($alarmRowInfo);
die;


 ?>