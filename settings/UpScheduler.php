<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$userId = str_replace("'", "''", NNull($_GET['uid'], ''));
	$izvestaj = str_replace("'", "''", NNull($_GET['izvestaj'], ''));
	$vozilo = str_replace("'", "''", NNull($_GET['vozilo'], ''));

	if ($vozilo <> "0") {
		$voziloArr = explode(" ", $vozilo);
		$vozilo = $voziloArr[0];
	}
	
	$razmerPristig = str_replace("'", "''", NNull($_GET['razmerPristig'], ''));
	$perPristig = str_replace("'", "''", NNull($_GET['perPristig'], ''));
	$denPristig = str_replace("'", "''", NNull($_GET['denPristig'], ''));
	$vremePristig = str_replace("'", "''", NNull($_GET['vremePristig'], ''));
	$email = str_replace("'", "''", NNull($_GET['email'], ''));
	$input = str_replace("'", "''", NNull($_GET['input'], ''));
	$repid= 0;
	
	$reparr = explode("_", $izvestaj);
	if (count($reparr) > 1 and $reparr[0] == "CustomizedReport") {
		$rep = "CustomizedReport";
		$repid = $reparr[1];
	}
	else {
		$rep=$izvestaj;
	}
	
	$dayInsert = "";
    If ($perPristig == "Weekly") {
        $dayInsert = $denPristig;
    }
    If ($perPristig == "Daily") {
        $dayInsert = "";
	}

	opendb();
	$updt = query("update scheduler set userid = '" . $userId . "', report='" . $rep . "',range='" . $razmerPristig . "', vehicle='" . $vozilo."',period='" . $perPristig ."',day='" . $dayInsert ."',time='" . $vremePristig ."',email='" . $email ."' ,doctype='" . $input ."',repid = '". $repid . "'  where id = " . $id . "  and clientid = " . Session("client_id"));
    closedb();
?>
