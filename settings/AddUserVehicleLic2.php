<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>
<?php
	opendb();
	
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$pocetok = DateTimeFormat(getQUERY("pocetok"), 'Y-m-d');
	$kraj = DateTimeFormat(getQUERY("kraj"), 'Y-m-d');
	$kopce = str_replace("'", "''", NNull($_GET['input'], ''));
	$prvoID = dlookup("select Max(id)+1 from vehicleslicense");
	$cid = Session("client_id");
	
	$proverka = query("select * from vehicleslicense");
	
	$LicenseCheck=dlookup("SELECT count(*) FROM vehicleslicense WHERE vehicleid = '" . $kopce. "' and userid = ".$id."");
	
	if($LicenseCheck > 0)
	{
		echo 1;
	}
	else
	{
	if(pg_num_rows($proverka)==0)
	{
		$prv = 1;
		RunSQL("INSERT INTO vehicleslicense(id,vehicleid, clientid, begining, ending, userid) VALUES(" . $prv . " , " . $kopce . "," . $cid .",
  		'" . DateTimeFormat($pocetok, "Y-m-d") . "',
  		'" . DateTimeFormat($kraj, "Y-m-d") . "' , ".$id.")");
	}
	else
	{
		RunSQL("INSERT INTO vehicleslicense(id,vehicleid, clientid, begining, ending, userid) VALUES(" . $prvoID . " , " . $kopce . "," . $cid .",
  		'" . DateTimeFormat($pocetok, "Y-m-d") . "',
  		'" . DateTimeFormat($kraj, "Y-m-d") . "' , ".$id.")");
	}
	}
	closedb();
?>