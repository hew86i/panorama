<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php


	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	opendb();
	
	$daliUniqId = dlookup("select uniqid from alarms where id = ".$id." and clientid =" . Session("client_id"));
	
	if($daliUniqId != ""){
		$brisi = query("Delete from alarms where uniqid = " . $daliUniqId . " and clientid =" . Session("client_id"));
	}
	else
	{
		$brisi = query("Delete from alarms where id = " . $id . " and clientid =" . Session("client_id"));
	}
	
	closedb();
?>