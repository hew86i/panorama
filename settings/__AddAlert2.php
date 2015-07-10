<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php


	$tipNaAlarm = str_replace("'", "''", NNull($_GET['tipNaAlarm'], ''));
	$email = str_replace("'", "''", NNull($_GET['email'], ''));
	$sms = str_replace("'", "''", NNull($_GET['sms'], ''));
	$zvukot = str_replace("'", "''", NNull($_GET['zvukot'], ''));
	$dostapno = str_replace("'", "''", NNull($_GET['dostapno'], ''));
	$vnesiAlertZa = str_replace("'", "''", NNull($_GET['odbraniVozila'], ''));
	$uid = Session("user_id");
	$cid = Session("client_id");
    opendb();


	//  1-VA KOMBINACIJA   AKO E ODBRAN ALARM - POSETA NA TOCKA OD INTERES//
	if($tipNaAlarm==10 && $vnesiAlertZa == 1)
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano'], ''));
		$vreme = str_replace("'", "''", NNull($_GET['vreme'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka'], ''));
		$posledno = dlookup("select Max(id)+1 from alarms");
		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "',0,'" .$vreme. "','" .$ImeNaTocka. "', null)");                      
	}
	
	if($tipNaAlarm==10 && $vnesiAlertZa == 2)
	{
		$today = getdate();
		$q = ''.$today[0];
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica'], ''));
		//$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		if ($_SESSION['role_id'] == "2") {
			$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc") ;
		} else {
			$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc");
		}
		$vreme = str_replace("'", "''", NNull($_GET['vreme'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka'], ''));
		
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,'" .$vreme. "','" .$ImeNaTocka. "','".$q."', 2)");
		}
	}
	
	if($tipNaAlarm==10 && $vnesiAlertZa == 3)
	{
		$today = getdate();
		$q = ''.$today[0];
		$vreme = str_replace("'", "''", NNull($_GET['vreme'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka'], ''));	
		//$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		if ($_SESSION['role_id'] == "2") {
			$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and active='1' order by cast(code as integer) asc") ;
		} else {
			$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1' order by cast(code as integer) asc");
		}
		
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,'" .$vreme. "','" .$ImeNaTocka. "','".$q."', 3)");                      
		}	
	}
	
	
	//  2-RA KOMBINACIJA  AKO E ODBRAN ALARM - IZLEZ OD ZONA //
	
	if($tipNaAlarm==9 && $vnesiAlertZa == 1)
	
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano'], ''));	
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "',0,0,'" .$tockaIzlez. "', null)");                      
	}
	if($tipNaAlarm==9 && $vnesiAlertZa == 2)
	
	{
		$today = getdate();
		$q = ''.$today[0];
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica'], ''));
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez'], ''));	
		//$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		if ($_SESSION['role_id'] == "2") {
			$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc") ;
		} else {
			$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc");
		}
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaIzlez. "','".$q."', 2)");                      
		}                      
	}
	if($tipNaAlarm==9 && $vnesiAlertZa == 3)
	
	{
		$today = getdate();
		$q = ''.$today[0];
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez'], ''));	
		//$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		if ($_SESSION['role_id'] == "2") {
			$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and active='1' order by cast(code as integer) asc") ;
		} else {
			$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1' order 				by cast(code as integer) asc");
		}
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaIzlez. "','".$q."', 3)");                      
		} 	
	}
	
	//   3-TA KOMBINACIJA AKO E ODBRAN ALARM - VLEZ VO ZONA  //
	
	if($tipNaAlarm==8  && $vnesiAlertZa == 1)
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano'], ''));	
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "',0,0,'" .$tockaVlez. "', null)");                      
	}
	
	if($tipNaAlarm==8  && $vnesiAlertZa == 2)
	{
		$today = getdate();
		$q = ''.$today[0];
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez'], ''));	
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica'], ''));
		//$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		if ($_SESSION['role_id'] == "2") {
			$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc") ;
		} else {
			$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc");
		}
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaVlez. "','".$q."', 2)");                      
		}      
	}
	
	if($tipNaAlarm==8  && $vnesiAlertZa == 3)
	{
		$today = getdate();
		$q = ''.$today[0];
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez'], ''));	
		//$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		if ($_SESSION['role_id'] == "2") {
			$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and active='1' order by cast(code as integer) asc") ;
		} else {
			$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1' order by cast(code as integer) asc");
		}
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',0,0,'" .$tockaVlez. "','".$q."', 3)");                      
		} 	
	}
	
	
	
	//   4-TA KOMBINACIJA AKO E ODBRAN ALARM - NADMINUVANJE NA BRZINA  //
	if($tipNaAlarm==7 && $vnesiAlertZa == 1)
	{
		$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano'], ''));
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina'], ''));
		$posledno = dlookup("select Max(id)+1 from alarms");

  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "', '" .$NadminataBrzina. "', null)");
	}
	
	if($tipNaAlarm==7 && $vnesiAlertZa == 2)
	{
		$today = getdate();
		$q = ''.$today[0];
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina'], ''));
		$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica'], ''));
		//$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
		if ($_SESSION['role_id'] == "2") {
			$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc") ;
		} else {
			$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc");
		}
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "', '" .$NadminataBrzina. "',0,0,'".$q."', 2)");                      
		}      
	}
	
	if($tipNaAlarm==7 && $vnesiAlertZa == 3)
	{
		$today = getdate();
		$q = ''.$today[0];
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina'], ''));
		//$najdiVozila = query("select * from vehicles where clientid = ".$cid);
		if ($_SESSION['role_id'] == "2") {
			$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and active='1' order by cast(code as integer) asc") ;
		} else {
			$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1' order by cast(code as integer) asc");
		}
		while($row = pg_fetch_array($najdiVozila))
 		{
 			$data[] = ($row);
		}
		foreach ($data as $row)
		{
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "', '" .$NadminataBrzina. "',0,0,'".$q."', 3)");                      
		} 	
  	}
	
	
	
	//new!!!
	if($tipNaAlarm==17 or $tipNaAlarm==18 or $tipNaAlarm==19 or $tipNaAlarm==20)
	{		
		$remindme = str_replace("'", "''", NNull($_GET['remindme'], ''));
		if ($vnesiAlertZa == 1) {
			$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano'], ''));
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms (id, alarmtypeid, available, emails, soundid, snooze, clientid, vehicleid, remindme)
			values('" . $posledno . "','" . $tipNaAlarm . "','" . $dostapno . "','" . $email . "','".$zvukot."',1," . Session("client_id") . ",'" .$ednoVozilo. "','".$remindme."')");
		}
		if ($vnesiAlertZa == 2) {
			$today = getdate();
			$q = ''.$today[0];
			$posledno = dlookup("select Max(id)+1 from alarms");
			$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica'], ''));
			if ($_SESSION['role_id'] == "2") {
				$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc") ;
			} else {
				$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc");
			}

			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
				$ret = query("insert into alarms (id, alarmtypeid, settings, available, emails, soundid, snooze, clientid, vehicleid, uniqid, typeofgroup, remindme)
				values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."', '" . $dostapno . "','" . $email . "','".$zvukot."',1," . Session("client_id") . ",'" .$row["id"]. "','".$q."', 2, '".$remindme."')");                      
			}
		}
		if ($vnesiAlertZa == 3) {
			$today = getdate();
			$q = ''.$today[0];
			if ($_SESSION['role_id'] == "2") {
				$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and active='1' order by cast(code as integer) asc") ;
			} else {
				$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1' order by cast(code as integer) asc");
			}
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}

			foreach ($data as $row)
			{
			$posledno = dlookup("select Max(id)+1 from alarms");
			
			$ret = query("insert into alarms (id, alarmtypeid, available, emails, soundid, snooze, clientid, vehicleid, uniqid, typeofgroup, remindme)
			values('" . $posledno . "','" . $tipNaAlarm . "', '" . $dostapno . "','" . $email . "','".$zvukot."',1," . Session("client_id") . ",'" .$row["id"]. "','".$q."', 3, '".$remindme."')");            
			} 	
		}                     
	}	
	//new!!!
	//   5-TA KOMBINACIJA AKO E ODBRAN ALARM BEZ DOPOLNITELNI POLINJA  //
	
	if($tipNaAlarm!=7 && $tipNaAlarm!=8 && $tipNaAlarm!=9 && $tipNaAlarm!=10 && $tipNaAlarm!=17 && $tipNaAlarm!=18 && $tipNaAlarm!=19 && $tipNaAlarm!=20)
    {
    	
		if($vnesiAlertZa == 1)
		{
			$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano'], ''));
			$posledno = dlookup("select Max(id)+1 from alarms");	
	  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$ednoVozilo. "', null)");                      
		}
		
		if($vnesiAlertZa == 2)
		{
			$today = getdate();
			$q = ''.$today[0];
			$posledno = dlookup("select Max(id)+1 from alarms");
			$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica'], ''));
			//$najdiVozila = query("select * from vehicles where organisationid = ".$orgEdinica." and clientid = ".$cid);
			if ($_SESSION['role_id'] == "2") {
				$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc") ;
			} else {
				$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and organisationid = ".$orgEdinica." and active='1' order by cast(code as integer) asc");
			}
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");	
		  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','".$orgEdinica."','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',NULL,NULL,NULL,'".$q."', 2)");                      
			}
		}
		
		if($vnesiAlertZa == 3)
		{
			$today = getdate();
			$q = ''.$today[0];
			//$najdiVozila = query("select * from vehicles where clientid = ".$cid);
			if ($_SESSION['role_id'] == "2") {
				$najdiVozila = query("select * from vehicles where clientID=" . session("client_id") . " and active='1' order by cast(code as integer) asc") ;
			} else {
				$najdiVozila = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1' order by cast(code as integer) asc");
			}
			while($row = pg_fetch_array($najdiVozila))
	 		{
	 			$data[] = ($row);
			}
			foreach ($data as $row)
			{
				$posledno = dlookup("select Max(id)+1 from alarms");{
		  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$row["id"]. "',NULL ,NULL ,NULL ,'".$q."', 3)");                      
			} 	
		}
	}
	}

	$vreme = str_replace("'", "''", NNull($_GET['vreme'], 'null'));
	$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano'], ''));
	$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka'], ''));
	$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez'], ''));
	$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez'], ''));
	$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica'], ''));

	$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina'], 'null'));
	$remindme = str_replace("'", "''", NNull($_GET['remindme'], 'null'));

	$posledno = dlookup("select Max(id)+1 from alarms");
	$poiid = 'null';
	$snooze = '1';
	$settings = 'null';
	$uniqid = 'null';
	$typeofgroup = 'null';
	$sms = str_replace("'", "''", NNull($_GET['sms'], 'null'));
	$email = "'" . $email . "'";

		if($tockaVlez != '') $poiid = $tockaVlez;
		if($tockaIzlez != '') $poiid = $tockaIzlez;
		if($ImeNaTocka != '') $poiid = $ImeNaTocka;

		echo "runSQL : " . "insert into alarms values(".$posledno.", ".$tipNaAlarm .", ".$settings .", ".$dostapno .", ".$email .", ".$sms .", ".$zvukot .", ".$snooze .", ".$cid .", ".$ednoVozilo .", ".$NadminataBrzina .", ".$vreme .", ".$poiid .", ".$uniqid .", ".$typeofgroup .", ".$remindme .")";
		echo "<br>";
		echo "query: " . "insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . $cid . " , '" . $ednoVozilo . "','" . $NadminataBrzina . "','" . $vreme . "','" .$poiid. "','','', null)";



	closedb();
?>