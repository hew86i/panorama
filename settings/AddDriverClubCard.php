<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();
	
	$vozacID = str_replace("'", "''", NNull($_GET['id'], ''));
	$kartickaID = str_replace("'", "''", NNull($_GET['kartickataID'], ''));

	
	$posledno = dlookup("select Max(id)+1 from drivercard");
	
	$workCheck=dlookup("SELECT count(*) FROM drivercard WHERE driverid = '" . $vozacID . "' and cardid = " . $kartickaID);

	if($workCheck > 0)
	{
		echo 1;
		exit();
	}
	else{

	$vnesi = query("INSERT into drivercard(id,driverid,cardid) values ('" . $posledno . "','" . $vozacID . "'," . $kartickaID . "); ");
	echo 0;
	
	}
	closedb();
?>