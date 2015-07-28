<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
    opendb();

	$uid = Session("user_id");
	$cid = Session("client_id");
	$role_id = $_SESSION['role_id'];

	$isEdit = str_replace("'", "''", NNull($_GET['isEdit'], false));  //default = false (add alert)
	$id = str_replace("'", "''", NNull($_GET['id'], 'null'));
	$uniqidDel = str_replace("'", "''", NNull($_GET['uniqid'], ''));

	$sendviaEmail = str_replace("'", "''", NNull($_GET['sendviaEmail'], null));

	$email = str_replace("'", "''", NNull($_GET['email'], null));
	$sms = str_replace("'", "''", NNull($_GET['sms'], null));
	$remindme = str_replace("'", "''", NNull($_GET['remindme'], null));

	$tipNaAlarm = str_replace("'", "''", NNull($_GET['tipNaAlarm'], 'null'));
	$zvukot = str_replace("'", "''", NNull($_GET['zvukot'], 'null'));
	$dostapno = str_replace("'", "''", NNull($_GET['dostapno'], 'null'));
	$vnesiAlertZa = str_replace("'", "''", NNull($_GET['odbraniVozila'], 'null'));
	$vreme = str_replace("'", "''", NNull($_GET['vreme'], 'null'));
	$ednoVozilo = str_replace("'", "''", NNull($_GET['voziloOdbrano'], 'null'));
	$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka'], 'null'));
	$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez'], 'null'));
	$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez'], 'null'));
	$orgEdinica = str_replace("'", "''", NNull($_GET['orgEdinica'], 'null'));
	$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina'], 'null'));

	$poiid = 'null';
	$snooze = '1';
	$uniqid = 'null';
	$typeofgroup = 'null';

	$email = "'" . $email . "'";
	$sms = "'" . $sms . "'";
	$remindme = "'" . $remindme . "'";
	$sendviaEmail = "'" . $sendviaEmail . "'";

	if($tipNaAlarm == 8) $poiid = $tockaVlez;
	if($tipNaAlarm == 9) $poiid = $tockaIzlez;
	if($tipNaAlarm == 10) $poiid = $ImeNaTocka;

	// ---------------- EDIT -------------------------- //
	if($isEdit == true) {
		echo "uniqid: " . $uniqidDel;
		if($uniqidDel == 'null') {

			$del = query("delete from alarms where id = ".$id." and clientid = ".$cid."");
		} else {

			$del = query("delete from alarms where uniqid = ".$uniqidDel." and clientid = ".$cid."");
		}
	}
	// ------------------------------------------------ //

	if($vnesiAlertZa == 1) {  // edno vozilo

	$posledno = dlookup("select Max(id)+1 from alarms");

		echo "query : " . "insert into alarms values(".$posledno.", ".$tipNaAlarm .", ".$orgEdinica .", ".$dostapno .", ".$email .", ".$sms .", ".$zvukot .", ".$snooze .", ".$cid .", ".$ednoVozilo .", ".$NadminataBrzina .", ".$vreme .", ".$poiid .", ".$uniqid .", ".$vnesiAlertZa .", ".$remindme .", ".$sendviaEmail .")" ;
		// die;exit();
		$ret = query("insert into alarms values(".$posledno.", ".$tipNaAlarm .", ".$orgEdinica .", ".$dostapno .", ".$email .", ".$sms .", ".$zvukot .", ".$snooze .", ".$cid .", ".$ednoVozilo .", ".$NadminataBrzina .", ".$vreme .", ".$poiid .", ".$uniqid .", ".$vnesiAlertZa .", ".$remindme .", ".$sendviaEmail .")");

	} else {  // ako e org. edninica ili cela kompanija

	$today = getdate(); //generira uniqid
	$uniqid = $today[0];
	$getVeh='';

	if ($role_id == "2") {

			if ($vnesiAlertZa == 2) $getVeh = query("select * from vehicles where clientID=" . $cid . " and organisationid = ". $orgEdinica ." and active='1' order by cast(code as integer) asc") ;
			if ($vnesiAlertZa == 3) $getVeh = query("select * from vehicles where clientID=" . $cid . " and active='1' order by cast(code as integer) asc") ;

		} else {

			if ($vnesiAlertZa == 2) $getVeh = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . $uid . ") and organisationid = ". $orgEdinica ." and active='1' order by cast(code as integer) asc");
			if ($vnesiAlertZa == 3) $getVeh = query("select * from vehicles where id in (select vehicleid from uservehicles where userid=" . $uid . ") and active='1' order by cast(code as integer) asc");
		}

		while($row = pg_fetch_array($getVeh)) {

			$posledno = dlookup("select Max(id)+1 from alarms");
	  		$ret = query("insert into alarms values(".$posledno.", ".$tipNaAlarm .", ".$orgEdinica .", ".$dostapno .", ".$email .", ".$sms .", ".$zvukot .", ".$snooze .", ".$cid .", ".$row["id"] .", ".$NadminataBrzina .", ".$vreme .", ".$poiid .", ".$uniqid .", ".$vnesiAlertZa .", ".$remindme .", ".$sendviaEmail .")");
	  		echo ("insert into alarms values(".$posledno.", ".$tipNaAlarm .", ".$orgEdinica .", ".$dostapno .", ".$email .", ".$sms .", ".$zvukot .", ".$snooze .", ".$cid .", ".$row["id"] .", ".$NadminataBrzina .", ".$vreme .", ".$poiid .", ".$uniqid .", ".$vnesiAlertZa .", ".$remindme .", ".$sendviaEmail .")");

		}

	}

	closedb();
 ?>