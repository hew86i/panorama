<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	
	opendb();
	
	$vehicleid = str_replace("'", "''", NNull($_GET['id'], ''));
	$datum = DateTimeFormat(getQUERY("datumce"), 'Y-m-d H:i:s');
	$km = str_replace("'", "''", NNull($_GET['odometarVrednost'], ''));
	
	
	$odometarCheck=dlookup("SELECT count(*) FROM currkm WHERE vehicleid = ". $vehicleid);
	$informacii = query("select * from currkm WHERE vehicleid = ". $vehicleid);
	$datumVnesenVeke = pg_fetch_result($informacii, 0, "datetime");
	$datumVnesenRacno = DateTimeFormat($datum, "Y-m-d 23:59:59");
	$datumVnesenRacnoSPOREDBA = DateTimeFormat($datum, "Y-m-d");
	
	$denesSporedba = strstr(now("Y-m-d H:i:s"), ' ', true); 
	$DENES = now("Y-m-d H:i:s");
	

	
	if($odometarCheck>0)
	{
	
		if($datumVnesenVeke>=$datumVnesenRacno)
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
		
		if($denesSporedba==$datumVnesenRacnoSPOREDBA)
		{
			
			$poslednoCurrKm = dlookup("select Max(id)+1 from currkm");
			$insertCurrKm = query("insert into currkm values('".$poslednoCurrKm."','".$vehicleid."','".$DENES."','".$km."')");	
			
			$poslednoOdometer = dlookup("select Max(id)+1 from odometer");
			$insertOdometer = query("insert into odometer values('".$poslednoOdometer."','".$vehicleid."','".$DENES."',cast((select calculatecurrkm('".$vehicleid."', cast(now() as timestamp))) as numeric(19,6)))");                             
		
		}
		
		else
		
		{
			$poslednoCurrKm = dlookup("select Max(id)+1 from currkm");
			$insertCurrKm = query("insert into currkm values('".$poslednoCurrKm."','".$vehicleid."','".$datum."','".$km."')");	
			
			$poslednoOdometer = dlookup("select Max(id)+1 from odometer");
			$insertOdometer = query("insert into odometer values('".$poslednoOdometer."','".$vehicleid."','".$datum."',cast((select calculatecurrkm('".$vehicleid."', cast(now() as timestamp))) as numeric(19,6)))");
		}
	
	}	
	closedb();
?>
