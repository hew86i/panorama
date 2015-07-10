<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>

<?php
	opendb();
	
	$id = str_replace("'", "''", NNull($_GET['id1'], ''));
	$name = str_replace("'", "''", NNull($_GET['GroupName'], ''));
	$color = str_replace("'", "''", NNull($_GET['ColorName'], ''));
	
	RunSQL("update pointsofinterestgroups set fillcolor = '" . $color . "', name ='" . $name . "', strokecolor = '#000000' where id = '" . $id . "' and clientid =" . Session("client_id"));
	closedb();
?>
