<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php
	header("Content-type: text/html; charset=utf-8");
?>

<?php
    $id = getQUERY('id');
    $table = getQUERY('table');

	opendb();

    RunSQL("DELETE FROM " . $table . " where id=" . $id);

    If ($table == "vehicles") {
        RunSQL("DELETE FROM vehicledriver where vehicleid=" . $id);
		RunSQL("DELETE FROM drivervehicle where vehicleid=" . $id);
		RunSQL("DELETE FROM uservehicles where vehicleid=" . $id);
    }

    If ($table == "drivers") {
        RunSQL("DELETE FROM vehicledriver where driverid=" . $id);
		RunSQL("DELETE FROM drivervehicle where driverid=" . $id);
    }

	closedb();

?>