<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
    
    header("Expires: Mon, 20 Jul 2000 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", FALSE);
	header("Pragma: no-cache");
	set_time_limit(0);
	opendb();
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('client_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
    
    $id = str_replace("'", "''", NNull($_GET['id'], ''));
	
    //$dsvv = query("EXEC sp_getGeoFenceDetail " . $id . ", " . Session("client_id"));
    $alertsVeh = "";
    //$alertsVeh = odbc_result($dsvv,"detail");
    //$dsvv1 = query("EXEC sp_getGeoFenceHeader " . $id);
    $alertsH = "";
    //$alertsH = odbc_result($dsvv1,"header");

    $_canChange = "";
	
	$dsName = query("select ST_AsText(geom) poly, name, groupid, available from pointsofinterest where id=" . $id);
	
	$strName = pg_fetch_result($dsName, 0, "name");
	$strGroupid = pg_fetch_result($dsName, 0, "groupid");
	$strLonLat = pg_fetch_result($dsName, 0, "poly");
	$available = pg_fetch_result($dsName, 0, "available");
    /*if (strlen($strLon)>0)
		$strLon = substr($strLon,1);
	if (strlen($strLat)>0)
		$strLat = substr($strLat,1);*/
	
	$_canChange = "True";
    
    print $strLonLat . "%^" . $strName . "%^" . $available . "%^" . $_canChange . "%^" . $strGroupid . "%^" . $alertsH . "%^" . $alertsVeh;
  	closedb();  
?>