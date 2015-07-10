<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
opendb();
?>

<?php
	
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$materijal = str_replace("'", "''", NNull($_GET['materijalIme'], ''));
	
	$materijalCheck = dlookup("SELECT count(*) FROM route_material WHERE clientid = ".Session("client_id")." and name = '" . $materijal. "' and name not in (select name from route_material where id=" . $id . ")");
	
	if($materijalCheck > 0)
	{
		echo 1;
	}
	else
	{
	
	$updt = query("update route_material set name = '" . $materijal . "' where id = '" . $id . "'  and clientid = " . Session("client_id"));

    }
    closedb();
	
?>
