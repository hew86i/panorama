<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	opendb();
	$opis = getQUERY("o");
	$rbr = getQUERY("rbr");
	$h = getQUERY("h");
	$ppid = getQUERY("ppid");
	$pointkm = getQUERY("pointkm");
	$pointtime = getQUERY("pointtime");
	$h1 = getQUERY("h1");
	
	$predefined = getQUERY("predefined");

	$sqlInsert = "insert into rnalogdetail (opis, ppid, hederid, rbr, poikm, poitime) values ('" .  $opis . "', " . $ppid . ", " . $h . ", " . $rbr . ", " . $pointkm . ", " . $pointtime . ") ";
	runsql($sqlInsert);
	
	if($predefined.'' == 'true')
	{
		$sqlInsert = "insert into rnalogdetailpre (opis, ppid, hederid, rbr, poikm, poitime) values ('" .  $opis . "', " . $ppid . ", " . $h1 . ", " . $rbr . ", " . $pointkm . ", " . $pointtime . ") ";
		runsql($sqlInsert);
	}
	print "OK";
	closedb();
?>