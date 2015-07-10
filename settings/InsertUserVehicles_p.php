<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$userID = str_replace("'", "''", NNull($_GET['uid'], ''));
	$ve = str_replace("'", "''", NNull($_GET['ve'], ''));
	opendb();
    
    $vehicles = explode(";", $ve);
	
	
    $bris = query("delete from uservehicles where userid = " . $userID);
	
    if(sizeof($vehicles) > 1)
	{
        for($i = 1; $i < sizeof($vehicles); $i++)
		{
			if($vehicles[$i] != "undefined")
				$vnes = query("insert into uservehicles (userid, vehicleid) values (" . $userID . ", " . intval($vehicles[$i]) . ")");
        }
    }
	closedb();
?>