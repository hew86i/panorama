<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
    
    header("Expires: Mon, 20 Jul 2000 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", FALSE);
    header("Pragma: no-cache");
	set_time_limit(0);
	opendb();
    $_alid = str_replace("'", "''", NNull($_GET['alid'], ''));
    $_drivID = str_replace("'", "''", NNull($_GET['drivID'], ''));
    $_litri = str_replace("'", "''", NNull($_GET['litri'], ''));
    $_iznos = str_replace("'", "''", NNull($_GET['iznos'], ''));

    $sqlAddF = "INSERT INTO Fuel ([VehicleID], [DriverID], [Litres], [Amount], [userID], [clientID]) VALUES (N'" . $_alid . "', N'" . $_drivID . "', N'" . $_litri . "', N'" . $_iznos . "', N'" . session("user_id") . "', N'" . session("client_id") . "')";
    $ret = RunSQL($sqlAddF);
    
    if($ret."" == "1")
        print dic("Tracking.InsertFuel");
	else
        print dic("Tracking.Error");
	closedb();
?>
