<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	opendb();
	
	$CARDNAME = str_replace("'", "''", NNull($_GET['cardname'], ''));

	$posledno = dlookup("select Max(id)+1 from clubcards");
	
	$workCheck=dlookup("SELECT count(*) FROM clubcards WHERE cardname = '" . $CARDNAME . "' and clientid = " . Session("client_id"));

	if($workCheck > 0)
	{
		echo 1;
	}
	else{

	$vnesi = query("INSERT into clubcards(id,cardname,clientid) values ('" . $posledno . "','" . $CARDNAME . "'," . Session("client_id") . "); ");
	echo 0;
	
	}
	closedb();
?>