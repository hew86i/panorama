<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();
	
	$imeOperacija = str_replace("'", "''", NNull($_GET['operacijaIme'], ''));

	$posledno = dlookup("select Max(id)+1 from route_operation");
	
	$proverka=dlookup("SELECT count(*) FROM route_operation WHERE name = '" . $imeOperacija . "' and clientid = " . Session("client_id"));

	if($proverka > 0)
	{
		echo 1;
	}
	else
	{
	$vnesi = query("INSERT into route_operation(id,name,clientid) values ('" . $posledno . "','" . $imeOperacija . "'," . Session("client_id") . "); ");
	echo 0;
	}
	closedb();
?>