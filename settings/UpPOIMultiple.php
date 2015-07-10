<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php
	opendb();
	
	$idTocki = str_replace("'", "''", NNull($_GET['selektirani'], ''));
	$groupid = str_replace("'", "''", NNull($_GET['groupid'], ''));
	
	RunSQL("update pointsofinterest set groupid = " . $groupid . " where id in (" . $idTocki . ")");
	closedb();
?>