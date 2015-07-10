<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php

	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	opendb();
	
	$kveri = query("select * from companydaysholiday where id = ".$id);
	
	$idTO = pg_fetch_result($kveri, 0 , "holidayid");

	$proverka = dlookup("SELECT count(*) FROM companydays where typeofholiday = '" . $idTO. "' and clientid =" . Session("client_id"));	
	
	if($proverka>0)
	{
		echo 1;
		exit();
	}
	else
	{
		$brisi = query("Delete from companydaysholiday where id = " . $id . " and clientid =" . Session("client_id"));	
	}

	
	
    closedb();
?>
