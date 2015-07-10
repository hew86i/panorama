<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	opendb();
	$uid = Session("user_id");
	$cid = Session("client_id");
	$tipklient = str_replace("'", "''", NNull($_GET['clientTypeID'], ''));
	$datFormat = str_replace("'", "''", NNull($_GET['datetimeformat'], ''));
	$DefMap = str_replace("'", "''", NNull($_GET['DefMap'], ''));
	$eon = str_replace("'", "''", NNull($_GET['EngineON'], ''));
	$eoff = str_replace("'", "''", NNull($_GET['EngineOFF'], ''));
	$eoffpon = str_replace("'", "''", NNull($_GET['EngineOFFPassengerON'], ''));
	$ls = str_replace("'", "''", NNull($_GET['SatelliteOFF'], ''));
	$ton = str_replace("'", "''", NNull($_GET['taximeteron'], ''));
	$tonpoff = str_replace("'", "''", NNull($_GET['TaximeterOFFPassengerON'], ''));
	$ec = str_replace("'", "''", NNull($_GET['PassiveON'], ''));
	$dt = str_replace("'", "''", NNull($_GET['datetime'], ''));
	$sped = str_replace("'", "''", NNull($_GET['speed'], ''));
	$loca = str_replace("'", "''", NNull($_GET['location'], ''));
	$po = str_replace("'", "''", NNull($_GET['poi'], ''));
	$zon = str_replace("'", "''", NNull($_GET['zone'], ''));
	$pas = str_replace("'", "''", NNull($_GET['passengers'], ''));
	$tax = str_replace("'", "''", NNull($_GET['taximeter'], ''));
	$ful = str_replace("'", "''", NNull($_GET['fuel'], ''));
	$weather = str_replace("'", "''", NNull($_GET['weather'], ''));
	$directlive = str_replace("'", "''", NNull($_GET['directlive'], ''));
	$TT = str_replace("'", "''", NNull($_GET['trace'], ''));
	$idlOver = str_replace("'", "''", NNull($_GET['idleOver'], ''));
	$kil = str_replace("'", "''", NNull($_GET['metric'], ''));
	$temperatura = str_replace("'", "''", NNull($_GET['temperatura'], ''));
	// $show = str_replace("'", "''", NNull($_GET['active'], ''));   // ne se prakja vekje
	$start = str_replace("'", "''", NNull($_GET['start'], ''));
	$km_start = str_replace("'", "''", NNull($_GET['km_start'], ''));
	$cena_km = str_replace("'", "''", NNull($_GET['cena_km'], ''));
	$wait_price = str_replace("'", "''", NNull($_GET['wait_price'], ''));
	$valuta = str_replace("'", "''", NNull($_GET['valutata'], ''));
	$tecnost = str_replace("'", "''", NNull($_GET['tecnost'], ''));
	$tarifata = str_replace("'", "''", NNull($_GET['tarifa'], ''));
	$snooze = str_replace("'", "''", NNull($_GET['snooze'], ''));
	$snoozevolume = str_replace("'", "''", NNull($_GET['snoozevolume'], 10));

	$cbFuel = (isset($_GET['cbfuel'])) ? NNull($_GET['cbfuel'], '') : '';
	$cbRpm = (isset($_GET['cbRpm'])) ? NNull($_GET['cbRpm'], '') : '';
	$cbTemperature = (isset($_GET['cbTemperature'])) ? NNull($_GET['cbTemperature'], '') : '';
	$cbDistance = (isset($_GET['cbDistance'])) ? NNull($_GET['cbDistance'], '') : '';

	$resetdrivertypeid = str_replace("'", "''", NNull($_GET['resetdrivertypeid'], ''));

	//VEHICLE DETAILS
	$dforecast = str_replace("'", "''", NNull($_GET['dforecast'], ''));
	$ddriver = str_replace("'", "''", NNull($_GET['ddriver'], ''));
	$dtime = str_replace("'", "''", NNull($_GET['dtime'], ''));
	$dodometer = str_replace("'", "''", NNull($_GET['dodometer'], ''));
	$dspeed = str_replace("'", "''", NNull($_GET['dspeed'], ''));
	$dlocation = str_replace("'", "''", NNull($_GET['dlocation'], ''));
	$dpoi = str_replace("'", "''", NNull($_GET['dpoi'], ''));
	$dzone = str_replace("'", "''", NNull($_GET['dzone'], ''));
	$dntours = str_replace("'", "''", NNull($_GET['dntours'], ''));
	$dprice = str_replace("'", "''", NNull($_GET['dprice'], ''));
	$dtaximeter = str_replace("'", "''", NNull($_GET['dtaximeter'], ''));
	$dpassengers = str_replace("'", "''", NNull($_GET['dpassengers'], ''));
	$vehdetails = "update vehicledetailscolumns set ddriver = '".$ddriver."', dtime = '".$dtime."', dodometer = '".$dodometer."', dspeed = '".$dspeed."', dlocation = '".$dlocation."', dpoi = '".$dpoi."', dzone = '".$dzone."', dntours = '".$dntours."', dprice = '".$dprice."', dtaximeter = '".$dtaximeter."', dpassengers = '".$dpassengers."', dforecast = '".$dforecast."' where userid = " . $uid;
	RunSQL($vehdetails);  // UPDATE INFO
	//VEHICLE DETAILS
	$cityID = str_replace("'", "''", NNull($_GET['city'], ''));
	// ------------- time zone ---------------------------
	$tzone = dlookup("select ctzone from cities where id=" . $cityID );

	if($tarifata == "undefined"){ $tarifata = "redovna"; }

	$returnQuery = '';   //test
	$query = "UPDATE users SET weather = '" . $weather . "', directlive = '" . $directlive . "', engineon = '". $eon . "', engineoff = '" .$eoff. "', satelliteoff = '" . $ls . "', passiveon = '" . $ec . "', timedate = '" . $dt . "', datetimeformat = '" . $datFormat . "', defaultmap = '"  . $DefMap . "', speed = '" . $sped . "', location = '" . $loca . "', poi = '" . $po . "', zone = '" . $zon .  "', passengers = '" . $pas . "',  fuel = '" . $ful . "', trace = '" . $TT . "', idleover = '" . $idlOver . "', tempunit = '" . $temperatura . "', metric = '" . $kil . "', currency = '" . $valuta . "', liquidunit = '" . $tecnost . "', snoozevolume = '" . $snoozevolume . "', snooze = '" . $snooze . "' where id= " .$uid;
	echo $query;
	$qCANbus = "UPDATE users SET cbfuel = '" . $cbFuel . "', cbrpm = '" . $cbRpm . "', cbtemp = '". $cbTemperature . "', cbdistance = '" . $cbDistance . "'   where id=  ".$uid;
	$qTaxi = "UPDATE users SET engineoffpassengeron = '" . $eoffpon . "', taximeteron = '" . $ton . "', taximeteroffpassengeron = '" . $tonpoff . "', passengers = '" . $pas . "', taximeter = '" . $tax . "',tariff = '" . $tarifata . "' where id = " . $uid;

	RunSQL($query);
	RunSQL($qCANbus);

	if($tipklient==2) {
		RunSQL($qTaxi);

		$prov = query("SELECT * FROM price where client_id=" . $cid);

		If(pg_num_rows($prov) == 0){
			$maksimum = dlookup("select Max(id)+1 from price");
	    $query1 = "INSERT INTO price (id,client_id, start, km_start, cena_km, waitprice) VALUES (". $maksimum . ",". $cid . "," . $start . "," . $km_start .  "," . $cena_km . ", " . $wait_price . ")";
			RunSQL($query1);
		}
		else {
		$query2 = "UPDATE price SET start = ".$start.", km_start = ".$km_start.", cena_km = " . $cena_km . ", waitprice = " . $wait_price . " where client_id= " . $cid;
			RunSQL($query2);
		}
	}
	RunSQL("UPDATE users SET cityid='". $cityID. "', tzone=" . ($tzone-1) . ", timezone=". $tzone ." where id=" . $uid);
	RunSQL("update clients set resetdrivertypeid = " . $resetdrivertypeid . " where id=" . $cid);

	print "Ok";
    closedb();
?>
