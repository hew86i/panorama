<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$un = str_replace("'", "''", NNull($_GET['un'], ''));	
	
	$proverka = query("SELECT * FROM users WHERE username = '" . $un . "'");
	
	closedb();
?>