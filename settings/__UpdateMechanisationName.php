<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
opendb();
?>

<?php
	
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$mehanizacija = str_replace("'", "''", NNull($_GET['mehanizacijaIme'], ''));
	$mehanizacijaRange = str_replace(",", ".", NNull($_GET['mehanizacijaRange'], ''));
	if ($mehanizacijaRange == "") $mehanizacijaRange = 0;
	
	$mehanizacijaCheck = dlookup("SELECT count(*) FROM route_mechanisation WHERE clientid = ".Session("client_id")." and name = '" . $mehanizacija. "' and name not in (select name from route_mechanisation where id=" . $id . ")");
	
	if($mehanizacijaCheck > 0)
	{
		echo 1;
	}
	else
	{
	
	$updt = query("update route_mechanisation set name = '" . $mehanizacija . "', range =  " . $mehanizacijaRange . " where id = '" . $id . "'  and clientid = " . Session("client_id"));

    }
    closedb();
	
?>
