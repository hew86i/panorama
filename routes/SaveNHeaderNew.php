﻿<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	opendb();
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
	
	$predefined = getQUERY("predefined");
	
	$routeCallback = getQUERY("routeCallback");
	$routeType = getQUERY("routeType");
	/*Za ZKPelagonija*/
	$culid = nnull(getQUERY("culid"), 0);
	
	/*Za ZKPelagonija*/
	
	$totalkm = getQUERY("totalkm");
	$totaltime = getQUERY("totaltime");
	if($alarm == "/")
		$alarm = 0;
	if($zadrz == "/")
		$zadrz = 0;
	//dim dat() as string = split(datum,"-")
	//dim datum1 = dat(2) & "-" & dat(1) & "-" & dat(0)
	$tmpDT = new DateTime($datum . ' ' . $vreme);
	$tmpDT = $tmpDT->format("Y-m-d H:i:s");
	
	$sqlInsert = "insert into rnalogheder (datetime, vehicleid, driverid1, driverid2, driverid3, StartDate, Name, ClientID, userID, Alarm, toStay, Pause1, Pause2, Pause3, Pause4, Pause5, TotalKm, TotalTime, culid, routecallback, routetype) ";
	$sqlInsert .= " Values (now(), " . $vozilo . ", " . $sofer1 . ", " . $sofer2 . ", " . $sofer3 . ", '" . $tmpDT . "', '" . $naslov . "', " . session("client_id") . ", " . session("user_id") . ", " . $alarm . ", " . $zadrz .", " . $pause1 .", " . $pause2 .", " . $pause3 .", " . $pause4 .", " . $pause5 . ", " . $totalkm . ", " . $totaltime . ", " . $culid .", '" . $routeCallback . "', '" . $routeType . "' )";
	
	//$dsInsert = query($sqlInsert);
	$dsInsert = dlookup($sqlInsert . " RETURNING id");
	$dsInsert1 = '-1';
	if($predefined.'' == 'true')
	{
		$sqlInsert = "insert into rnaloghederpre (datetime, vehicleid, driverid1, driverid2, driverid3, StartDate, Name, ClientID, userID, Alarm, toStay, Pause1, Pause2, Pause3, Pause4, Pause5, TotalKm, TotalTime, culid, routecallback, routetype) ";
		$sqlInsert .= " values (now(), " . $vozilo . ", " . $sofer1 . ", " . $sofer2 . ", " . $sofer3 . ", '" . $tmpDT . "', '" . $naslov . "', " . session("client_id") . ", " . session("user_id") . ", " . $alarm . ", " . $zadrz .", " . $pause1 .", " . $pause2 .", " . $pause3 .", " . $pause4 .", " . $pause5 . ", " . $totalkm . ", " . $totaltime . ", " . $culid .", '" . $routeCallback . "', '" . $routeType . "' )";
		$dsInsert1 = dlookup($sqlInsert . " RETURNING id");
	}
	//$dsInsert1 = query("select id from rnalogheder order by id desc limit 1");
	//$id = pg_fetch_result($dsInsert1, 0, "id");
	
	addlog(38, dic_('Routes.NewOrderWithNumber') . " " . $dsInsert);
	
	print $dsInsert . "^*" . $dsInsert1;
	closedb();
?>