<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	$gsmnum = getQUERY("gsmnum");
	opendb();
	$desc = dlookup("select registration || ' (' || code || ')<br>GSM number: ' || gsmnumber from vehicles where gsmnumber='" . $gsmnum . "'");
	addlog('50', $desc);
	$blockstatus = dlookup("select blockstatus from historyofblocks where vehicleid in (select id from vehicles where gsmnumber='" . $gsmnum . "') order by datetime desc limit 1");
	closedb();
	echo $blockstatus;
?>