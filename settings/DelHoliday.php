<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php

	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	opendb();

	$brisi = query("Delete from companydays where id = " . $id . " and clientid =" . Session("client_id"));
	
    closedb();
?>