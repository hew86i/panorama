<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();
	
	$imeKultura = str_replace("'", "''", NNull($_GET['kulturaIme'], ''));

	$posledno = dlookup("select Max(id)+1 from route_culture");
	
	$proverka=dlookup("SELECT count(*) FROM route_culture WHERE name = '" . $imeKultura . "' and clientid = " . Session("client_id"));

	if($proverka > 0)
	{
		echo 1;
	}
	else
	{
	$vnesi = query("INSERT into route_culture(id,name,clientid) values ('" . $posledno . "','" . $imeKultura . "'," . Session("client_id") . "); ");
	echo 0;
	}
	closedb();
?>