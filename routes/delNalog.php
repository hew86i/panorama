<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	$id = getQUERY("id");
	$pred = nnull(getQUERY("pred"), "0");
	opendb();

	if ($pred == 0)
		runsql("delete from rNalogDetail where hederID=" . $id . "; delete from rNalogHeder where id=" . $id);
	if ($pred == 1)
		runsql("delete from rNalogDetailpre where hederID=" . $id . "; delete from rnaloghederpre where id=" . $id);
	
	print "ok";
	closedb();
?>