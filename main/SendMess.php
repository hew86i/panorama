<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php
	opendb();
	
	$action = nnull(getQUERY("action"), "");
	if($action == 'garmin')
	{
		$fromid = nnull(getQUERY("fromid"), "");
		$toid = session("user_id");
		$garminid = getQUERY("messid");
	}
	$toobject = nnull(getQUERY("toobj"), "");
	$flag = '0';
	$delivery = "";
	$deliverycoll = "";
	if($action == 'user')
	{
		$fromid = session("user_id");
		if($toobject == 'vehicle') {
			$toid = nnull(getQUERY("toid"), "");
			$toid = dlookup("select id from vehicles where gsmnumber='" . $toid . "'");
		} else {
			$flag = '1';
			$toid = nnull(getQUERY("toid"), "");
			$delivery = ", now()";
			$deliverycoll = ", dtdelivery";
		}
		$garminid = dlookup("select coalesce((select garminid from messages where toid=" . $toid . " order by datetime desc limit 1), 0)");
		$garminid = $garminid + 1;
	}
    $clientid = session("client_id");
	$userid = session("user_id");
	$datetime = nnull(getQUERY("dt"), now());
	//$datetime = now();
    $subject = nnull(getQUERY("subject"), "");
    $body = nnull(utf8_urldecode(getQUERY("body")), "");
    $checked = '0';

	RunSQL("INSERT INTO messages (fromid, toobject, toid, clientid, userid, datetime, subject, body, checked, garminid, flag" . $deliverycoll . ") 
	    VALUES (" . $fromid . ", '" . $toobject . "', " . $toid . ", " . $clientid . ", " . $userid . ", 
	    '" . $datetime . "', '" . $subject . "', '" . $body . "', " . $checked . ", " . $garminid . ", '" . $flag . "'" . $delivery . ")");
	
    closedb();
	echo $garminid;
	//echo 54336;
    exit();
    
?>
