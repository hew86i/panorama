<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$cardname = str_replace("'", "''", NNull($_GET['cardname1'], ''));

	opendb();
	
	$cardCheck = dlookup("SELECT count(*) FROM clubcards WHERE clientid = ".Session("client_id")." and cardname = '" . $cardname. "' and cardname not in (select cardname from clubcards where id=" . $id . ")");
	
	if($cardCheck > 0)
	{
		echo 1;
	}
	else
	{
	
	$updt = query("update clubcards set cardname = '" . $cardname . "' where id = " . $id . "  and clientid = " . Session("client_id"));

    }
    closedb();
	
?>
