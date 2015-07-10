<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	
	opendb();
	
	$vehicleid = str_replace("'", "''", NNull($_GET['id'], ''));
	$datum = DateTimeFormat(getQUERY("datumce"), 'Y-m-d H:i:s');
	$km = str_replace("'", "''", NNull($_GET['odometarVrednost'], ''));
	
	$informacii = query("select * from currkm WHERE vehicleid = ". $vehicleid);
	$datumVnesenVeke = pg_fetch_result($informacii, 0, "datetime");
	$datumVnesenRacno = DateTimeFormat($datum, "Y-m-d 23:59:59");
	$datumVnesenRacnoSPOREDBA = DateTimeFormat($datum, "Y-m-d");
	
	$denesSporedba = strstr(now("Y-m-d H:i:s"), ' ', true); 
	$DENES = now("Y-m-d H:i:s");
	
	
	if($denesSporedba==$datumVnesenRacnoSPOREDBA)
	{
			
		$updateCurrKm = query("update currkm set km=".$km.", datetime = '".$DENES."' where vehicleid=".$vehicleid);
		
		$updateOdometer = query("update odometer set datetime = '".$DENES."', km=cast((select calculatecurrkm('".$vehicleid."', cast(now() as timestamp))) as numeric(19,6)) where vehicleid=".$vehicleid);
		
	}
	else
	{
	
		$updateCurrKm = query("update currkm set km=".$km.", datetime = '".$datum."' where vehicleid=".$vehicleid);
		
		$updateOdometer = query("update odometer set km=cast((select calculatecurrkm('".$vehicleid."', cast(now() as timestamp))) as numeric(19,6)) where vehicleid=".$vehicleid);	
			
	}
	
	
	
	closedb();
?>
