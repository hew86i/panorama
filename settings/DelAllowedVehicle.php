<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>

<?php
	$driverid = str_replace("'", "''", NNull($_GET['i'], ''));
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	
	opendb();
	$brisi = query("Delete from vehicledriver where id = " . $id . " and driverid =" . $driverid);
    echo $brisi;
    closedb();
?>
