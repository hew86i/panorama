<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();
	
	$imeMehanizacija = str_replace("'", "''", NNull($_GET['mehanizacijaIme'], ''));
	$mehanizacijaRange = str_replace(",", ".", NNull($_GET['mehanizacijaRange'], ''));
	
	$posledno = dlookup("select Max(id)+1 from route_mechanisation");
	
	$proverka=dlookup("SELECT count(*) FROM route_mechanisation WHERE name = '" . $imeMehanizacija . "' and clientid = " . Session("client_id"));

	if($proverka > 0)
	{
		echo 1;
	}
	else
	{

	$vnesi = query("INSERT into route_mechanisation(id,name,clientid,range) values ('" . $posledno . "','" . $imeMehanizacija . "'," . Session("client_id") . ", " . $mehanizacijaRange . "); ");
	echo 0;
	}
	closedb();
?>
