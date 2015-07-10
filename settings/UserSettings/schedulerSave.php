<?php include "../../include/functions.php" ?>
<?php include "../../include/db.php" ?>

<?php include "../../include/params.php" ?>
<?php include "../../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	opendb();
	
	$rep = str_replace("'", "''", NNull($_GET['rep'], ''));
	$veh = str_replace("'", "''", NNull($_GET['veh'], ''));
	$per = str_replace("'", "''", NNull($_GET['per'], ''));
	$day = str_replace("'", "''", NNull($_GET['day'], ''));
	$date1 = str_replace("'", "''", NNull($_GET['date1'], ''));
	$sati = str_replace("'", "''", NNull($_GET['sati'], ''));
    $minuti = str_replace("'", "''", NNull($_GET['minuti'], ''));
	$email = str_replace("'", "''", NNull($_GET['email'], ''));
    $uid = str_replace("'", "''", NNull($_GET['uid'], ''));
	
    $dayInsert = "";
    if($day == "")
        $dayInsert = $date1;

    if($date1 == "")
        $dayInsert = $day;

    $time = $sati . ":" . $minuti;
	
	RunSQL("insert into Scheduler (clientID, userID, report, vehicle, period, day, time, email, subusers) values(" . Session("client_id") . "," . $uid . ",'" . $rep . "','" . $veh . "','" . $per . "','" . $dayInsert . "','" . $time . "','" . $email . "','')");
    
    print "Ok";
    
    closedb();
?>