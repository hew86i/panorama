<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	$veh = str_replace("'", "''", NNull($_GET['veh'], ''));
    $reg = str_replace("'", "''", NNull($_GET['reg'], ''));
	$no = str_replace("'", "''", NNull($_GET['no'], ''));
	opendb();

    RunSQL("UPDATE Vehicles SET registration='" . $reg . "', code = " .  intval($no) . " WHERE id = " . intval($veh) . "");

	closedb();
?>