<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$vozacId = str_replace("'", "''", NNull($_GET['vozacId'], ''));
	opendb();

	$brisi = query("Delete from drivercard where cardid = " . $id . " and driverid =" .$vozacId);
    closedb();
?>