<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$userID = str_replace("'", "''", NNull($_GET['uid'], ''));
	$ve = str_replace("'", "''", NNull($_GET['selected'], ''));
	opendb();
    
    $vehicles = explode("*",$ve);
	
    $bris = query("delete from uservehicles where userid = " . $userID);

    if(sizeof($vehicles) > 0)
	{
        
		for ($i=0; $i < sizeof($vehicles)-1; $i++) 
		{
				
			$vnes = query("insert into uservehicles (id, userid, vehicleid) values ((select max(id) + 1 from uservehicles), " . $userID . ", " . $vehicles[$i] . ")");
		}
    }

	closedb();
?>