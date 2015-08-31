<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	
	opendb();
	
	$vehicleid = str_replace("'", "''", NNull($_GET['id'], ''));
	$km = str_replace("'", "''", NNull($_GET['odometarVrednost'], ''));
	
	$odometarCheck=dlookup("SELECT count(*) FROM currkm WHERE vehicleid = ". $vehicleid);
	 
	$DENES = now("Y-m-d H:i:s");

	if($odometarCheck>0)
	{
		$informacii = query("select * from currkm WHERE vehicleid = ". $vehicleid);
		$datumVnesenVeke = pg_fetch_result($informacii, 0, "datetime");
		
		if($datumVnesenVeke >= $DENES)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	else
	{
		$insertCurrKm = query("insert into currkm (vehicleid, datetime, km) values ('".$vehicleid."','".$DENES."','".$km."')");	
		$insertOdometer = query("insert into odometer (vehicleid, datetime, km) values ('".$vehicleid."','".$DENES."',cast((select calculatecurrkm('".$vehicleid."', cast(now() as timestamp))) as numeric(19,6)))");
		echo "Ok";                             
	}
	closedb();
?>
