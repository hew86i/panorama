<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();
	
	$id = str_replace("'", "''", NNull($_GET['id1'], ''));
	$groupid = str_replace("'", "''", NNull($_GET['groupidVtoro'], ''));
	
	RunSQL("update pointsofinterest set groupid = '" . $groupid . "' where id = '" . $id . "' and clientid =" . Session("client_id"));
	closedb();
?>