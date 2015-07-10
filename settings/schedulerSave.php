<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php

    $rep = getQUERY("rep");
    $veh = getQUERY("veh");
    $range = getQUERY("range");
    $per = getQUERY("per");
    $day = getQUERY("day");
    $date1 = getQUERY("date1");
    $saati = getQUERY("saati");
    $email = getQUERY("email");
    $uid = getQUERY("uid");
    $path = getQUERY("path");
	$doctype = getQUERY("doctype");
	
    $Today = DateTimeFormat(now(), "Y-m-d H:i:s");
    
    opendb();
        
    $vehID = nnull(dlookup("select id from vehicles where registration = '" . $veh . "'"), 0);
      
    $dayInsert = "";
    If ($per == "Weekly") {
        $dayInsert = $day;
    }
    If ($per == "Daily") {
        $dayInsert = "";
	}
    If ($per == "Monthly") {
        $dayInsert = $date1;
    }
    
    $time = $saati . ":00";
  
   /* echo "insert into Scheduler (clientID, userID, report, vehicle, period, day, time, email, 
    subusers, range, vehID, path, CreationDate) values(" . Session("client_id") . "," . $uid . ",
    '" . $rep . "','" . $veh . "','" . $per . "','" . $dayInsert . "','" . $time . "','" . $email . "','', 
    '" . $range . "', '" . $vehID . "', '" . $path . "', '" . $Today . "');";
	       */
    RunSQL("delete from Scheduler where clientID = " . Session("client_id") . " and userID = " . $uid . " and report = '" . $rep . "' and vehicle = '" . $veh . "' and period = '" . $per . "' and day = '" . $dayInsert . "' and time = '" . $time . "' and email = '" . $email . "'");
    $ret = DlookUP("insert into Scheduler (clientID, userID, report, vehicle, period, day, time, email, subusers, range, 
    vehID, path, CreationDate, doctype) values(" . Session("client_id") . "," . $uid . ",
    '" . $rep . "','" . $veh . "','" . $per . "','" . $dayInsert . "','" . $time . "','" . $email . "','', 
    '" . $range . "', '" . $vehID . "', '" . $path . "', '" . $Today . "', '" . $doctype . "') ");
    
    closedb();
    
    echo $ret;
    
?>