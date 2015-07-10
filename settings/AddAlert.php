<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$tipNaAlarm = str_replace("'", "''", NNull($_GET['tipNaAlarm'], ''));
	$email = str_replace("'", "''", NNull($_GET['email'], ''));
	$sms = str_replace("'", "''", NNull($_GET['sms'], ''));
	$zvukot = str_replace("'", "''", NNull($_GET['zvukot'], ''));
	$vehicleid = str_replace("'", "''", NNull($_GET['vehicleid'], ''));
	$dostapno = str_replace("'", "''", NNull($_GET['dostapno'], ''));
		
	$uid = Session("user_id");
	$cid = Session("client_id");
    opendb();

	if($tipNaAlarm==10)
	{
		$vreme = str_replace("'", "''", NNull($_GET['vreme'], ''));
		$ImeNaTocka = str_replace("'", "''", NNull($_GET['ImeNaTocka'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$vehicleid. "',0,'" .$vreme. "','" .$ImeNaTocka. "')");                      
	}
    if($tipNaAlarm==9)
	{
		$tockaIzlez = str_replace("'", "''", NNull($_GET['ImeNaZonaIzlez'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$vehicleid. "',0,0,'" .$tockaIzlez. "')");                      
	}
	if($tipNaAlarm==8)
	{
		$tockaVlez = str_replace("'", "''", NNull($_GET['ImeNaZonaVlez'], ''));	
		$posledno = dlookup("select Max(id)+1 from alarms");	
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$vehicleid. "',0,0,'" .$tockaVlez. "')");                      
	}
	if($tipNaAlarm==7)
	{
		$NadminataBrzina = str_replace("'", "''", NNull($_GET['NadminataBrzina'], ''));
		$posledno = dlookup("select Max(id)+1 from alarms");	
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$vehicleid. "', '" .$NadminataBrzina. "')");                      
	}
	if($tipNaAlarm==17 or $tipNaAlarm==18 or $tipNaAlarm==19 or $tipNaAlarm==20)
	{
		$remindme = str_replace("'", "''", NNull($_GET['remindme'], ''));
		$posledno = dlookup("select Max(id)+1 from alarms");	
		$ret = query("insert into alarms (id, alarmtypeid, available, emails, soundid, snooze, clientid, vehicleid, remindme)
		values('" . $posledno . "','" . $tipNaAlarm . "','" . $dostapno . "','" . $email . "','".$zvukot."',1," . Session("client_id") . ",'" .$vehicleid. "','".$remindme."')");                      
	}
	
	if($tipNaAlarm!=7 && $tipNaAlarm!=8 && $tipNaAlarm!=9 && $tipNaAlarm!=10 && $tipNaAlarm!=17 && $tipNaAlarm!=18 && $tipNaAlarm!=19 && $tipNaAlarm!=20)
    {
		$posledno = dlookup("select Max(id)+1 from alarms");	
  		$ret = query("insert into alarms values('" . $posledno . "','" . $tipNaAlarm . "','','" . $dostapno . "','" . $email . "','".$sms."','".$zvukot."',1," . Session("client_id") . " , '" .$vehicleid. "')");                      
	}
	
	closedb();
?>