<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	header("Content-type: text/html; charset=utf-8");

	opendb();

    $id = getQUERY('id');
    $cid = session('client_id');
    $uid = session('user_id');



    echo "info:" . $id. "-" .$cid . "-" . $uid;
    // exit();

  //   RunSQL("DELETE FROM " . $table . " where id=" . $id);

  //   If ($table == "vehicles") {
  //       RunSQL("DELETE FROM vehicledriver where vehicleid=" . $id);
		// RunSQL("DELETE FROM drivervehicle where vehicleid=" . $id);
		// RunSQL("DELETE FROM uservehicles where vehicleid=" . $id);
  //   }

  //   If ($table == "drivers") {
  //       RunSQL("DELETE FROM vehicledriver where driverid=" . $id);
		// RunSQL("DELETE FROM drivervehicle where driverid=" . $id);
  //   }

	closedb();

?>