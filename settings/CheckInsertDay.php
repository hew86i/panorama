<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php

	/*$datum = str_replace("'", "''", NNull($_GET['Datum'], ''));*/
	
	$datum = DateTimeFormat(getQUERY("Datum"), 'Y-m-d');
	opendb();
	
	/*$kveri = query("select * from companydays where datum = ".$datum);*/
	
	$proverka = dlookup("SELECT count(*) FROM companydays where datum = '" . $datum. "' and clientid =" . Session("client_id"));	
	
	if($proverka>0)
	{	
		echo 1;
	}
	else
	{
		echo 0;
	}

	closedb();
?>