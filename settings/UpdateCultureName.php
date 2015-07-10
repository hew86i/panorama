<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
opendb();
?>

<?php
	
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$kultura = str_replace("'", "''", NNull($_GET['kulturataIme'], ''));
	
	
	
	$kulturaCheck = dlookup("SELECT count(*) FROM route_culture WHERE clientid = ".Session("client_id")." and name = '" . $kultura. "' and name not in (select name from route_culture where id=" . $id . ")");
	
	if($kulturaCheck > 0)
	{
		echo 1;
	}
	else
	{
	
	$updt = query("update route_culture set name = '" . $kultura . "' where id = '" . $id . "'  and clientid = " . Session("client_id"));

    }
    closedb();
	
?>
