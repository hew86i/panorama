<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>

<?php

	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	opendb();
	RunSQL("Delete from pointsofinterest where id = " . $id . " and clientid =" . Session("client_id"));
	closedb();
?>