<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
    $id = getQUERY("id");
	$descr = getQUERY("desc");
	opendb();
	$desc = dlookup("select registration || ' (' || code || ')<br>GSM number: ' || gsmnumber from vehicles where gsmnumber='" . $descr . "'");
	//echo $desc;
	addlog($id, $desc);
	closedb();
?>