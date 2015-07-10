<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();
	
	$imeMaterijal = str_replace("'", "''", NNull($_GET['materijalIme'], ''));

	$posledno = dlookup("select Max(id)+1 from route_material");
	
	$proverka=dlookup("SELECT count(*) FROM route_material WHERE name = '" . $imeMaterijal . "' and clientid = " . Session("client_id"));

	if($proverka > 0)
	{
		echo 1;
	}
	else
	{
	$vnesi = query("INSERT into route_material(id,name,clientid) values ('" . $posledno . "','" . $imeMaterijal . "'," . Session("client_id") . "); ");
	echo 0;
	}
	closedb();
?>