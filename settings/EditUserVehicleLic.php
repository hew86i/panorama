<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$pocetok =  DateTimeFormat(getQUERY("pocetok"), 'Y-m-d');
	$kraj = DateTimeFormat(getQUERY("kraj"), 'Y-m-d');
	$vrednost = str_replace("'", "''", NNull($_GET['input'], ''));

	opendb();
	$updt = query("update vehicleslicense set begining =  '" . DateTimeFormat($pocetok, "Y-m-d") . "' , ending= '" . DateTimeFormat($kraj, "Y-m-d") . "' , vehicleid= " . $vrednost . "  where id = " . $id . "  and clientid = " . Session("client_id"));
    closedb();
?>


