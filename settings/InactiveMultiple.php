<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php
	opendb();
	
	$idTocki = str_replace("'", "''", NNull($_GET['selektiraniInactive'], ''));
	
	RunSQL("update pointsofinterest set active = B'0' where id in (" . $idTocki . ")");
	
	RunSQL("INSERT INTO poiactivetimestatus(idpoi, active)
	SELECT cast(id as integer), '0' active
	FROM unnest(string_to_array('".$idTocki."',',')) g(id)");
	
	closedb();
?>