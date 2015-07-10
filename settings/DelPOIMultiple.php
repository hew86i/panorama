<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php
	
	opendb();
	$id = str_replace("'", "''", NNull($_GET['selektirani'], ''));
	
	RunSQL("Delete from pointsofinterest where id in (" . $id . ")");
	closedb();
	
?>