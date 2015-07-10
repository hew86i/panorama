<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	opendb();
	
    $ids = str_replace("'", "''", NNull($_GET['ids'], ''));
	//echo "delete from fmcomponents where id in (" . $ids . ")";
	//exit;
	
	RunSQL("delete from fmcomponents where id in (" . $ids . ")");
	
	closedb();
?>