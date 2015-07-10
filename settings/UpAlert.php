<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>

<?php
	opendb();

	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$vehid = str_replace("'", "''", NNull($_GET['vehicleid2'], ''));

	$tipNaAlarm= str_replace("'", "''", NNull($_GET['tipNaAlarm2'], ''));
	$emails = str_replace("'", "''", NNull($_GET['email2'], ''));
	$sms = str_replace("'", "''", NNull($_GET['sms2'], ''));
	$zvukot = str_replace("'", "''", NNull($_GET['zvukot2'], ''));
	$dostapno = str_replace("'", "''", NNull($_GET['dostapno2'], ''));
		
	if($tipNaAlarm==10)
	{
		$vreme = str_replace("'", "''", NNull($_GET['vreme2'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka2'], ''));	
		RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',poiid = '" .$ImeNaTocka. "',timeofpoi = '" .$vreme. "',uniqid = null where id = '" . $id . "' and clientid =" . Session("client_id"));
	}
	if($tipNaAlarm==9)
	{
		$TockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez2'], ''));	
		RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',  available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',poiid = '" .$TockaIzlez. "',uniqid = null  where id = '" . $id . "' and clientid =" . Session("client_id"));
	}
	if($tipNaAlarm==8)
	{
		$TockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez2'], ''));
		RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',  available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',poiid = '" .$TockaVlez. "',uniqid = null  where id = '" . $id . "' and clientid =" . Session("client_id"));
	}
	if($tipNaAlarm==7)
	{
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina2'], ''));
		RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',  available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',speed = '" .$NadminataBrzina. "',uniqid = null  where id = '" . $id . "' and clientid =" . Session("client_id"));
	}
	if($tipNaAlarm==17 or $tipNaAlarm==18 or $tipNaAlarm==19 or $tipNaAlarm==20)
	{	
		$remindme = str_replace("'", "''", NNull($_GET['remindme'], ''));
		RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "', available = '" . $dostapno . "', emails = '" . $emails . "', soundid = '".$zvukot."', remindme = '" . $remindme . "'  where id = '" . $id . "' and clientid =" . Session("client_id"));                     
	}
	if($tipNaAlarm!=7 && $tipNaAlarm!=8 && $tipNaAlarm!=9 && $tipNaAlarm!=10 && $tipNaAlarm!=17 && $tipNaAlarm!=18 && $tipNaAlarm!=19 && $tipNaAlarm!=20)
    {
		RunSQL("update alarms set alarmtypeid = '" . $tipNaAlarm . "',  available ='" . $dostapno . "', emails ='" . $emails . "', sms = '" .$sms. "',soundid = '" .$zvukot. "',uniqid = null where id = '" . $id . "' and clientid =" . Session("client_id"));
	}
	
	
	closedb();
?>
