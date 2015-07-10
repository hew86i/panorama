<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
opendb();
?>

<?php
	
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$operacija = str_replace("'", "''", NNull($_GET['operacijaIme'], ''));
	
	$operacijaCheck = dlookup("SELECT count(*) FROM route_operation WHERE clientid = ".Session("client_id")." and name = '" . $operacija. "' and name not in (select name from route_culture where id=" . $id . ")");
	
	if($operacijaCheck > 0)
	{
		echo 1;
	}
	else
	{
	
	$updt = query("update route_operation set name = '" . $operacija . "' where id = '" . $id . "'  and clientid = " . Session("client_id"));

    }
    closedb();
	
?>
