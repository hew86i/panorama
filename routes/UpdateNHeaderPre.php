﻿<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	opendb();
	$id = getQUERY("id");
	$naslov = getQUERY("n");
	$vozilo = getQUERY("vo");
	$sofer1 = getQUERY("d1");
	$sofer2 = getQUERY("d2");
	$sofer3 = getQUERY("d3");
	
	$datum = getQUERY("d");
	$vreme = getQUERY("v");
	$alarm = getQUERY("alarm");
	$zadrz = getQUERY("zadrz");
	$pause1 = getQUERY("pause1");
	$pause2 = getQUERY("pause2");
	$pause3 = getQUERY("pause3");
	$pause4 = getQUERY("pause4");
	$pause5 = getQUERY("pause5");

	$totalkm = getQUERY("totalkm");
	$totaltime = getQUERY("totaltime");
	
	//dim dat() as string = split(datum,"-")
	//dim datum1 = dat(2) & "-" & dat(1) & "-" & dat(0)
	$tmpDT = new DateTime($datum . ' ' . $vreme);
	$tmpDT = $tmpDT->format("Y-m-d H:i:s");
	//$sqlInsert = "insert into rnalogheder (datetime, VehicleID, DriverID1, DriverID2, DriverID3, StartDate, Name, ClientID, userID, Alarm) ";
	//$sqlInsert .= " Values (now(), " . $vozilo . ", " . $sofer1 . ", " . $sofer2 . ", " . $sofer3 . ", '" . $tmpDT . "', '" . $naslov . "', " . session("client_id") . ", " . session("user_id") . ", " . $alarm . " )";
	if($alarm == "/")
		$alarm = 0;
	if($zadrz == "/")
		$zadrz = 0;
	$sqlInsert = "update rnaloghederpre set name='" . $naslov . "', vehicleid=" . $vozilo . ", driverid1=" . $sofer1 . ", driverid2=" . $sofer2 . ", driverid3=" . $sofer3;
	$sqlInsert .= ", tostay=" . $zadrz . ", pause1=" . $pause1 . ", pause2=" . $pause2 . ", pause3=" . $pause3 . ", pause4=" . $pause4 . ", pause5=" . $pause5;
	$sqlInsert .= ", totalkm=" . $totalkm . ", totaltime=" . $totaltime;
	$sqlInsert .= ", startdate='" . $tmpDT . "', alarm=" . $alarm . ", datetime='" . now() . "' where id=" . $id;
	//echo $sqlInsert;
	//exit;
	$dsInsert = query($sqlInsert);
	
	$sqlInsert1 = "delete from rnalogdetailpre where hederid=" . $id;
	runsql($sqlInsert1);
	
	//$dsInsert1 = query("select id from rnalogheder order by id desc limit 1");
	//$id = pg_fetch_result($dsInsert1, 0, "id");
	print $id;
	closedb();
?>