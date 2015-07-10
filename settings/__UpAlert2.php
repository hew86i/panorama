<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php


	$uid = Session("user_id");
	$cid = Session("client_id");
	
	opendb();
	
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$tipNaAlarm= str_replace("'", "''", NNull($_GET['tipNaAlarm2'], ''));
	$emails = str_replace("'", "''", NNull($_GET['email2'], ''));
	$sms = str_replace("'", "''", NNull($_GET['sms2'], ''));
	$zvukot = str_replace("'", "''", NNull($_GET['zvukot2'], ''));
	$dostapno = str_replace("'", "''", NNull($_GET['dostapno2'], ''));
	$vnesiAlertZa = str_replace("'", "''", NNull($_GET['odbraniVozila2'], ''));
	

	$pobaraj = query("select * from alarms where id = ".$id." and clientid = ".$cid."");
	$uniqid = pg_fetch_result($pobaraj, 0 , "uniqid");
	
	// AKO IMA UNIQID
	if($uniqid>0)
	{
		
	
	//  1-VA KOMBINACIJA   AKO E ODBRAN ALARM - POSETA NA TOCKA OD INTERES//
	if($tipNaAlarm==10 && $vnesiAlertZa == 1)
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));	
		$vreme = str_replace("'", "''", NNull($_GET['vreme2'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka2'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "',0,'" .$vreme. "','" .$ImeNaTocka. "', null,null)");
  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",poiid = '" .$ImeNaTocka. "',timeofpoi = '" .$vreme. "',uniqid = null  where uniqid = '" . $uniqid . "' and clientid =" .$cid);
	}
	
	if($tipNaAlarm==10 && $vnesiAlertZa == 2)
	{
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka2'], ''));
		$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		$vreme = str_replace("'", "''", NNull($_GET['vreme2'], ''));
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,'" .$vreme. "','" .$ImeNaTocka. "','".$uniqid."', 2)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$ImeNaTocka. "',timeofpoi = '" .$vreme. "',uniqid = ".$uniqid.",typeofgroup = 2  where uniqid = '" . $uniqid . "' and clientid =" .$cid);
		}
	}
	
	if($tipNaAlarm==10 && $vnesiAlertZa == 3)
	{
		$vreme = str_replace("'", "''", NNull($_GET['vreme2'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka2'], ''));	
		$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,'" .$vreme. "','" .$ImeNaTocka. "','".$uniqid."', 3)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$ImeNaTocka. "',timeofpoi = '" .$vreme. "',uniqid = ".$uniqid.",typeofgroup = 3  where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
		}	
	}
	
	
	//  2-RA KOMBINACIJA  AKO E ODBRAN ALARM - IZLEZ OD ZONA //
	
	if($tipNaAlarm==9 && $vnesiAlertZa == 1)
	
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));	
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez2'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "',0,0,'" .$tockaIzlez. "', null,null)");
  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",poiid = '" .$tockaIzlez. "',timeofpoi = null,uniqid = null  where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
	}
	if($tipNaAlarm==9 && $vnesiAlertZa == 2)
	
	{
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez2'], ''));	
		$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaIzlez. "','".$uniqid."', 2)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$tockaIzlez. "',timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 2  where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
		}                      
	}
	if($tipNaAlarm==9 && $vnesiAlertZa == 3)
	
	{
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez2'], ''));	
		$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaIzlez. "','".$uniqid."', 3)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$tockaIzlez. "',timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 3  where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
		} 	
	}
	
	//   3-TA KOMBINACIJA AKO E ODBRAN ALARM - VLEZ VO ZONA  //
	
	if($tipNaAlarm==8  && $vnesiAlertZa == 1)
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));	
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez2'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "',0,0,'" .$tockaVlez. "', null,null)"); 
  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",poiid = '" .$tockaVlez. "',timeofpoi = null,uniqid = null where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
	}
	
	if($tipNaAlarm==8  && $vnesiAlertZa == 2)
	{
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez2'], ''));	
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
		$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaVlez. "','".$uniqid."', 2)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$tockaVlez. "',timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 2  where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
		}      
	}
	
	if($tipNaAlarm==8  && $vnesiAlertZa == 3)
	{
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez2'], ''));	
		$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaVlez. "','".$uniqid."', 3)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$tockaVlez. "',timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 3  where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
		} 	
	}
	
	
	
	//   4-TA KOMBINACIJA AKO E ODBRAN ALARM - NADMINUVANJE NA BRZINA  //
	if($tipNaAlarm==7 && $vnesiAlertZa == 1)
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina2'], ''));
		$posledno = dlookup("select Max(id)+1 from alarms");	
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "', '" .$NadminataBrzina. "', null, null, null, null)");
  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",speed = ".$NadminataBrzina.",poiid = null,timeofpoi = null,uniqid = null  where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
	}
	
	if($tipNaAlarm==7 && $vnesiAlertZa == 2)
	{
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina2'], ''));
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
		$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "', '" .$NadminataBrzina. "',0,0,'".$uniqid."', 2)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = ".$NadminataBrzina.",poiid = null,timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 2  where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
		}      
	}
	
	if($tipNaAlarm==7 && $vnesiAlertZa == 3)
	{
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina2'], ''));
		$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "', '" .$NadminataBrzina. "',0,0,'".$uniqid."', 3)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = ".$NadminataBrzina.",poiid = null,timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 3  where uniqid = '" . $uniqid . "' and clientid =" .$cid);                      
		} 	
  	}
	
	if($tipNaAlarm==17 or $tipNaAlarm==18 or $tipNaAlarm==19 or $tipNaAlarm==20)
	{				
		$remindme = str_replace("'", "''", NNull($_GET['remindme'], ''));
		if ($vnesiAlertZa == 1) {
			$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));
			$posledno = dlookup("select Max(id)+1 from alarms");	
			$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");			
			$ret = query("insert into alarms (id, alarmtypeid, available, emails, soundid, snooze, clientid, vehicleid, remindme)
			values('" . $posledno . "','" . $tipNaAlarm . "','" . $dostapno . "','" . $emails . "','".$zvukot."',1," . Session("client_id") . ",'" .$ednoVozilo. "','".$remindme."')");
		}
		if ($vnesiAlertZa == 2) {
			$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
			$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
			$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
		  		$ret = query("insert into alarms (id, alarmtypeid, settings, available, emails, soundid, snooze, clientid, vehicleid, uniqid, typeofgroup, remindme)
				values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."', '" . $dostapno . "','" . $emails . "','".$zvukot."',1," . Session("client_id") . ",'" .$row["id"]. "','".$uniqid."', 2, '".$remindme."')");
		  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = null,poiid = null,timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 2  where uniqid = '" . $uniqid . "' and clientid =" .$cid);
			}
		}
		if ($vnesiAlertZa == 3) {
			$najdiVozila = query("select * from vehicles where clientid = ".$cid);
			$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
				$ret = query("insert into alarms (id, alarmtypeid, available, emails, soundid, snooze, clientid, vehicleid, uniqid, typeofgroup, remindme)
				values('" . $posledno . "','" . $tipNaAlarm . "', '" . $dostapno . "','" . $emails . "','".$zvukot."',1," . Session("client_id") . ",'" .$row["id"]. "','".$uniqid."', 3, '".$remindme."')");
		  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = null,poiid = null,timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 3  where uniqid = '" . $uniqid . "' and clientid =" .$cid);
			}
		}
	}		
	
	//   5-TA KOMBINACIJA AKO E ODBRAN ALARM BEZ DOPOLNITELNI POLINJA  //
	
	if($tipNaAlarm!=7 && $tipNaAlarm!=8 && $tipNaAlarm!=9 && $tipNaAlarm!=10 && $tipNaAlarm!=17 && $tipNaAlarm!=18 && $tipNaAlarm!=19 && $tipNaAlarm!=20)
    {
    	
		if($vnesiAlertZa == 1)
		{
			$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));
			$posledno = dlookup("select Max(id)+1 from alarms");	
			$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "', null, null, null, null, null)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",speed = null,poiid = null,timeofpoi = null,uniqid = null  where uniqid = '" . $uniqid . "' and clientid =" .$cid);
		}
		///////////////
		if($vnesiAlertZa == 2)
		{
			$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
			$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
			$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
				$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',NULL,NULL,NULL,'".$uniqid."', 2)");
		  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = null,poiid = null,timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 2  where uniqid = '" . $uniqid . "' and clientid =" .$cid);
			}
		}
		
		if($vnesiAlertZa == 3)
		{
			$najdiVozila = query("select * from vehicles where clientid = ".$cid);
			$brisi = query("delete from alarms where uniqid = ".$uniqid." and clientid = ".$cid."");
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
		  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',NULL ,NULL ,NULL ,'".$uniqid."', 3)");
		  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = null,poiid = null,timeofpoi = null,uniqid = ".$uniqid.",typeofgroup = 3  where uniqid = '" . $uniqid . "' and clientid =" .$cid);
			} 	
		}
	}

	}
	
	//  AKO NEMA UNIQID
	
	else
	{
	
		//  1-VA KOMBINACIJA   AKO E ODBRAN ALARM - POSETA NA TOCKA OD INTERES//
	if($tipNaAlarm==10 && $vnesiAlertZa == 1)
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));	
		$vreme = str_replace("'", "''", NNull($_GET['vreme2'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka2'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "',0,'" .$vreme. "','" .$ImeNaTocka. "', null,null)");
  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",poiid = '" .$ImeNaTocka. "',timeofpoi = '" .$vreme. "',uniqid = null  where id = '" . $id . "' and clientid =" .$cid);
	}
	
	if($tipNaAlarm==10 && $vnesiAlertZa == 2)
	{
		$today = getdate();
		$q = ''.$today[0];
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
		$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		$vreme = str_replace("'", "''", NNull($_GET['vreme2'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka2'], ''));	
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
			$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,'" .$vreme. "','" .$ImeNaTocka. "','".$q."', 2)");
			//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$ImeNaTocka. "',timeofpoi = '" .$vreme. "',uniqid = ".$q.",typeofgroup = 2  where id = '" . $id . "' and clientid =" .$cid);
		}
	}
	
	if($tipNaAlarm==10 && $vnesiAlertZa == 3)
	{
		$today = getdate();
		$q = ''.$today[0];
		$vreme = str_replace("'", "''", NNull($_GET['vreme2'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka2'], ''));	
		$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
		
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,'" .$vreme. "','" .$ImeNaTocka. "','".$q."', 3)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$ImeNaTocka. "',timeofpoi = '" .$vreme. "',uniqid = ".$q.",typeofgroup = 3 where id = '" . $id . "' and clientid =" .$cid);                      
		}	
	}
	
	
	//  2-RA KOMBINACIJA  AKO E ODBRAN ALARM - IZLEZ OD ZONA //
	
	if($tipNaAlarm==9 && $vnesiAlertZa == 1)
	
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));	
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez2'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "',0,0,'" .$tockaIzlez. "', null,null)");
  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",poiid = '" .$tockaIzlez. "',timeofpoi = null,uniqid = null  where id = '" . $id . "' and clientid =" .$cid);                      
	}
	if($tipNaAlarm==9 && $vnesiAlertZa == 2)
	
	{
		$today = getdate();
		$q = ''.$today[0];
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez2'], ''));	
		$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaIzlez. "','".$q."', 2)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$tockaIzlez. "',timeofpoi = null,uniqid = ".$q.",typeofgroup = 2  where id = '" . $id . "' and clientid =" .$cid);                      
		}                      
	}
	if($tipNaAlarm==9 && $vnesiAlertZa == 3)
	
	{
		$today = getdate();
		$q = ''.$today[0];
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez2'], ''));	
		$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaIzlez. "','".$q."', 3)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$tockaIzlez. "',timeofpoi = null,uniqid = ".$q.",typeofgroup = 3  where id = '" . $id . "' and clientid =" .$cid);                      
		} 	
	}
	
	//   3-TA KOMBINACIJA AKO E ODBRAN ALARM - VLEZ VO ZONA  //
	
	if($tipNaAlarm==8  && $vnesiAlertZa == 1)
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));	
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez2'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "',0,0,'" .$tockaVlez. "', null,null)");
  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",poiid = '" .$tockaVlez. "',timeofpoi = null,uniqid = null  where id = '" . $id . "' and clientid =" .$cid);                      
	}
	
	if($tipNaAlarm==8  && $vnesiAlertZa == 2)
	{
		$today = getdate();
		$q = ''.$today[0];
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez2'], ''));	
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
		$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaVlez. "','".$q."', 2)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$tockaVlez. "',timeofpoi = null,uniqid = ".$q.",typeofgroup = 2  where id = '" . $id . "' and clientid =" .$cid);                      
		}      
	}
	
	if($tipNaAlarm==8  && $vnesiAlertZa == 3)
	{
		$today = getdate();
		$q = ''.$today[0];
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez2'], ''));	
		$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaVlez. "','".$q."', 3)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",poiid = '" .$tockaVlez. "',timeofpoi = null,uniqid = ".$q.",typeofgroup = 3  where id = '" . $id . "' and clientid =" .$cid);                      
		} 	
	}
	
	
	
	//   4-TA KOMBINACIJA AKO E ODBRAN ALARM - NADMINUVANJE NA BRZINA  //
	if($tipNaAlarm==7 && $vnesiAlertZa == 1)
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina2'], ''));
		$posledno = dlookup("select Max(id)+1 from alarms");	
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "', '" .$NadminataBrzina. "', null, null, null, null)");
  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",speed = ".$NadminataBrzina.",poiid = null,timeofpoi = null,uniqid = null  where id = '" . $id . "' and clientid =" .$cid);                      
	}
	
	if($tipNaAlarm==7 && $vnesiAlertZa == 2)
	{
		$today = getdate();
		$q = ''.$today[0];
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina2'], ''));
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
		$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "', '" .$NadminataBrzina. "',0,0,'".$q."', 2)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = ".$NadminataBrzina.",poiid = null,timeofpoi = null,uniqid = ".$q.",typeofgroup = 2 where id = '" . $id . "' and clientid =" .$cid);                      
		}      
	}
	
	if($tipNaAlarm==7 && $vnesiAlertZa == 3)
	{
		$today = getdate();
		$q = ''.$today[0];
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina2'], ''));
		$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "', '" .$NadminataBrzina. "',0,0,'".$q."', 3)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = ".$NadminataBrzina.",poiid = null,timeofpoi = null,uniqid = ".$q.",typeofgroup = 3  where id = '" . $id . "' and clientid =" .$cid);                      
		} 	
  	}
	
	
	if($tipNaAlarm==17 or $tipNaAlarm==18 or $tipNaAlarm==19 or $tipNaAlarm==20)
	{		
		$remindme = str_replace("'", "''", NNull($_GET['remindme'], ''));
		if ($vnesiAlertZa == 1) {
			$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));
			$posledno = dlookup("select Max(id)+1 from alarms");	
			$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
	  		
			$ret = query("insert into alarms (id, alarmtypeid, available, emails, soundid, snooze, clientid, vehicleid, remindme)
			values('" . $posledno . "','" . $tipNaAlarm . "','" . $dostapno . "','" . $emails . "','".$zvukot."',1," . Session("client_id") . ",'" .$ednoVozilo. "','".$remindme."')");
		}
		if ($vnesiAlertZa == 2) {
			$today = getdate();
			$q = ''.$today[0];
			$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
			$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
			$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
				$ret = query("insert into alarms (id, alarmtypeid, settings, available, emails, soundid, snooze, clientid, vehicleid, uniqid, typeofgroup, remindme)
				values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."', '" . $dostapno . "','" . $emails . "','".$zvukot."',1," . Session("client_id") . ",'" .$row["id"]. "','".$q."', 2, '".$remindme."')");
				//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = null,poiid = null,timeofpoi = null,uniqid = ".$q.",typeofgroup = 2  where id = '" . $id . "' and clientid =" .$cid);
			}
		}
		if ($vnesiAlertZa == 3) {
			$today = getdate();
			$q = ''.$today[0];
			$najdiVozila = query("select * from vehicles where clientid = ".$cid);
			$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
		  		
				$ret = query("insert into alarms (id, alarmtypeid, available, emails, soundid, snooze, clientid, vehicleid, uniqid, typeofgroup, remindme)
				values('" . $posledno . "','" . $tipNaAlarm . "', '" . $dostapno . "','" . $emails . "','".$zvukot."',1," . Session("client_id") . ",'" .$row["id"]. "','".$q."', 3, '".$remindme."')");            
		  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = null,poiid = null,timeofpoi = null,uniqid = ".$q.",typeofgroup = 3  where id = '" . $id . "' and clientid =" .$cid);
			}
		}
	}
	//   5-TA KOMBINACIJA AKO E ODBRAN ALARM BEZ DOPOLNITELNI POLINJA  //
	
	if($tipNaAlarm!=7 && $tipNaAlarm!=8 && $tipNaAlarm!=9 && $tipNaAlarm!=10 && $tipNaAlarm!=17 && $tipNaAlarm!=18 && $tipNaAlarm!=19 && $tipNaAlarm!=20)
    {
    	
		if($vnesiAlertZa == 1)
		{
			$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano2'], ''));
			$posledno = dlookup("select Max(id)+1 from alarms");	
			$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "', null, null, null, null, null)");
	  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$ednoVozilo.",speed = null,poiid = null,timeofpoi = null,uniqid = null  where id = '" . $id . "' and clientid =" .$cid);
		}
		///////////////
		if($vnesiAlertZa == 2)
		{
			$today = getdate();
			$q = ''.$today[0];
			$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica2'], ''));
			$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
			$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
		  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',NULL,NULL,NULL,'".$q."', 2)");
				//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = ".$orgEdinica." , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = null,poiid = null,timeofpoi = null,uniqid = ".$q.",typeofgroup = 2  where id = '" . $id . "' and clientid =" .$cid);
			}
		}
		
		if($vnesiAlertZa == 3)
		{
			$today = getdate();
			$q = ''.$today[0];
			$najdiVozila = query("select * from vehicles where clientid = ".$cid);
			$brisi = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
		  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $emails . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',NULL ,NULL ,NULL ,'".$q."', 3)");
		  		//RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',settings = null , available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',vehicleid = ".$row["id"].",speed = null,poiid = null,timeofpoi = null,uniqid = ".$q.",typeofgroup = 3  where id = '" . $id . "' and clientid =" .$cid);
			} 	
		}
	}
		
	}
	
	closedb();
?>